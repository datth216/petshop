<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;


class AdminCategoryController extends Controller
{
    function cat_product()
    {
        $category = Category::paginate(3);
        $user = User::all();
        return view('admin.product.cat', compact('category', 'user'));       
    }

    function store_product(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên nhà cung cấp',
                'slug' => 'Slug',
            ],
        );

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('slug')),
            'user_id' => $request->user_id = Auth::id(),
            'parent_id' => $request->type_cat,
        ]);

        return redirect('admin/product/category')->with('status', 'Đã thêm danh mục thành công');
    }

    function product_cat_edit(Request $request, $id)
    {
        $cat = Category::find($id);
        $list_cat = Category::all();
        return view('admin.product.cat_edit', compact('cat', 'list_cat'));
    }

    function product_cat_update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'type' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên nhà cung cấp',
                'slug' => 'Slug',
                'type' => 'Loại'
            ],
        );

        Category::Where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('slug')),
            'parent_id' => $request->type,
            'user_id' => $request->user_id = Auth::id(),
        ]);
        return redirect('admin/product/category')->with('status', 'Đã cập nhật thành công');
    }

    function product_cat_delete(Request $request, $id)
    {
        Category::find($id)
            ->forceDelete();
        return redirect('admin/product/category')->with('status', 'Bạn đã xoá danh mục thành công');
    }
}
