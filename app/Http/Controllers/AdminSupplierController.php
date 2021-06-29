<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Supplier;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSupplierController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'supplier']);
            return $next($request);
        });
    }

    function add()
    {
        $cate = Category::all(['id', 'name']);
        // return $cate;
        return view('admin.supplier.add', compact('cate'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:suppliers',
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => 'Email phải là địa chỉ hợp lệ',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên nhà cung cấp',
                'email' => 'Email',
            ],
        );

        Supplier::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'note' => $request->input('note'),
            'user_id' => $request->user_id = Auth::id(),
        ]);

        return redirect('admin/supplier/list')->with('status', 'Đã thêm nhà cung cấp thành công');
    }

    function edit($id)
    {
        $supplier = Supplier::find($id);
        // $this->authorize('update', $supplier);

        return view('admin.supplier.edit', compact('supplier'));
    }

    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên nhà cung cấp',
            ],
        );

        Supplier::Where('id', $id)->update([
            'name' => $request->input('name'),
            'note' => $request->input('note'),
            'user_id' => $request->user_id = Auth::id(),
        ]);

        return redirect('admin/supplier/list')->with('status', 'Đã cập nhật thành công');
    }

    function delete($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect('admin/supplier/list')->with('status', 'Đã xoá nhà cung cấp thành công');
    }

    function restore($id)
    {
        Supplier::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect('admin/supplier/list')->with('status', 'Đã phục hồi nhà cung cấp thành công');
    }

    function list(Request $request)
    {
        $keyword = "";
        $list_act = [];
        $status = $request->input('status');
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
            $supplier = Supplier::where("name", "LIKE", "%{$keyword}%")->orWhere("email", "LIKE", "%{$keyword}%")->paginate(3);
            $supplier->withPath("list?keyword={$keyword}&btn-search=Tìm+kiếm"); //Tuỳ chỉnh url
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        } else {
            $supplier = Supplier::paginate(3);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }
        if ($status == 'trash') {
            $supplier = Supplier::onlyTrashed()->paginate(3);
            $supplier->appends(['status' => 'trash']);
            $list_act = [
                'empty' => 'Chọn',
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }

        if ($status == 'active') {
            $supplier = Supplier::paginate(3);
            $supplier->appends(['status' => 'active']);
            $list_act = [
                'empty' => 'Chọn',
                'delete' => 'Xoá tạm thời',
                'forceDelete' => 'Xoá vĩnh viễn'
            ];
        }
        $count_supplier_active = Supplier::count();
        $count_supplier_trash = Supplier::onlyTrashed()->count();
        $count = [$count_supplier_active, $count_supplier_trash];

        return view('admin.supplier.list', compact('supplier', 'list_act', 'count', 'status'));
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');
                if ($act == 'delete') {
                    Supplier::destroy($list_check);
                    return redirect('admin/supplier/list')->with('status', 'Bạn đã xoá thành công');
                }

                if ($act == 'restore') {
                    Supplier::withTrashed()
                        ->whereIn('id', $list_check)
                        ->restore();
                    return redirect('admin/supplier/list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($act == 'forceDelete') {
                    Supplier::withTrashed()
                        ->whereIn('id', $list_check)
                        ->forceDelete();
                    return redirect('admin/supplier/list')->with('status', 'Bạn đã xoá vĩnh viễn thành công');
                }

                if ($act == 'empty') {
                    return redirect('admin/supplier/list')->with('error', 'Bạn cần chọn tác vụ');
                }
            }
        } else {
            return redirect('admin/supplier/list')->with('error', 'Bạn cần chọn nhà cung cấp thực hiện');
        }
    }
}
