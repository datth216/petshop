<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;

class AdminRoleController extends Controller
{
    function __construct(Role $role, Permission $permission)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });

        $this->role = $role;
        $this->permission = $permission;
    }

    function list(Request $request)
    {
        $keyword = "";
        $list_act = [];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $role = Role::where("name", "LIKE", "%{$keyword}%")->orWhere("display_name", "LIKE", "%{$keyword}%")->paginate(3);
            $role->withPath("list?keyword={$keyword}&btn-search=Tìm+kiếm"); //Tuỳ chỉnh url
            $list_act = [
                'empty' => 'Chọn',
                'forceDelete' => 'Xoá'
            ];
        } else {
            $role = Role::paginate(3);
            $list_act = [
                'empty' => 'Chọn',
                'forceDelete' => 'Xoá'
            ];
        }
        return view('admin.role.list', compact('role', 'list_act'));
    }

    function add()
    {
        $permissionsParent = Permission::where('parent_id', 0)->get();
        return view('admin.role.add', compact('permissionsParent'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'display_name' => 'required|string',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên vai trò',
                'display_name' => 'Mô tả vai trò',
            ],
        );

        $role = $this->role->create([
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
        ]);
        $role->permissions()->attach($request->permission_id);
        return redirect('admin/role/list')->with('status', 'Đã thêm quyền thành công');
    }

    function edit($id)
    {
        $role = Role::find($id);
        $permissionsParent = Permission::where('parent_id', 0)->get();
        $permissionChecked = $role->permissions;
        // dd($permissionChecked);
        return view('admin.role.edit', compact('role', 'permissionsParent', 'permissionChecked'));
    }

    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'display_name' => 'required|string',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên vai trò',
                'display_name' => 'Mô tả vai trò',
            ],
        );

        Role::find($id)->update([
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
        ]);
        $role = Role::find($id);
        $role->permissions()->sync($request->permission_id);
        return redirect('admin/role/list')->with('status', 'Đã cập nhật thành công');
    }

    function delete($id)
    {
        $role = Role::find($id);
        $role->forceDelete();
        return redirect('admin/supplier/list')->with('status', 'Đã xoá quyền thành công');
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == 'forceDelete') {
                Role::whereIn('id', $list_check)
                    ->forceDelete();
                return redirect('admin/role/list')->with('status', 'Bạn đã xoá quyền thành công');
            }
            if ($act == 'empty') {
                return redirect('admin/role/list')->with('error', 'Bạn cần chọn tác vụ');
            }
        } else {
            return redirect('admin/role/list')->with('error', 'Bạn cần chọn quyền thực hiện');
        }
    }

}
