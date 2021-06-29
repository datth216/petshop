<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AdminUserController extends Controller
{
    private $user;
    private $role;
    function __construct(User $user, Role $role)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });

        return $this->user = $user;
        return $this->role = $role;
    }

    function list(Request $request)
    {
        //=======CHỈ TÌM KIẾM THÀNH VIÊN KÍCH HOẠT - KO TÌM KIẾM TRONG VÔ HIỆU HOÁ (WithTrashed)=======// 

        $keyword = "";
        $list_act = [];
        $status = $request->input('status');
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $user = User::where("name", "LIKE", "%{$keyword}%")->orWhere("email", "LIKE", "%{$keyword}%")->paginate(3);
            $user->withPath("list?keyword={$keyword}&btn-search=Tìm+kiếm"); //Tuỳ chỉnh url
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        } else {
            $user = User::paginate(3);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }

        if ($status == 'trash') {
            $user = User::onlyTrashed()->paginate(3);
            $user->appends(['status' => 'trash']);
            $list_act = [
                'empty' => 'Chọn',
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }

        if ($status == 'active') {
            $user = User::paginate(3);
            $user->appends(['status' => 'active']);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }

        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];

        return view('admin.user.list', compact('user', 'count', 'list_act', 'status'));
    }

    function add()
    {

        $role = Role::all();
        return view('admin.user.add', compact('role'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'required' => ':attribute không được để trống',
                'password' => ':attribute không được để trống',
                'email' => 'Email phải là địa chỉ hợp lệ',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ],
        );

        $user = $this->user->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->roles()->attach($request->role_id);
        return redirect('admin/user/list')->with('status', 'Đã thêm thành viên thành công');
        // dd($request->role_id);
    }

    function delete($id)
    {
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();
            return redirect('admin/user/list')->with('status', 'Đã xoá thành viên thành công');
        } else {
            return redirect('admin/user/list')->with('status', 'Không thể xoá !');
        }
    }

    function restore($id)
    {
        User::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect('admin/user/list')->with('status', 'Đã phục hồi nhà cung cấp thành công');
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    unset($list_check[$k]);
                    return redirect('admin/user/list')->with('error', 'Bạn không thể thao tác');
                }
            }

            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    User::destroy($list_check);
                    // return redirect('admin/user/list')->with('status', 'Bạn đã xoá thành công');
                    print_r($act);
                }

                if ($act == 'restore') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == 'forceDelete') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/user/list')->with('status', 'Bạn đã xoá vĩnh viễn thành công');
                }

                if ($act == 'empty') {
                    return redirect('admin/user/list')->with('error', 'Bạn cần chọn tác vụ');
                }
            }
        } else {
            return redirect('admin/user/list')->with('error', 'Bạn cần chọn thành viên thực hiện');
        }
    }

    function edit($id)
    {
        $roles = Role::all();
        $user = User::find($id);
        $rolesOfUser = $user->roles;
        // dd($roleOfUser);
        return view('admin.user.edit', compact('user', 'roles', 'rolesOfUser'));
    }

    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                
            ],
            [
                'required' => ':attribute không được để trống',
                'password' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu'
            ],
        );

        User::Where('id', $id)->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user = User::find($id);
        $user->roles()->sync($request->role_id);

        return redirect('admin/user/list')->with('status', 'Đã cập nhật thành công');
    }
}
