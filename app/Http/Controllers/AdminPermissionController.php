<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    function addPermission()
    {
        return view('admin.permission.add');
    }

    function store(Request $request)
    {
        // dd($request->all());
        $permission = Permission::create([
            'name' => $request->module_parent,
            'display_name' => $request->module_parent,
            'parent_id' => 0,
            'key_code' => '',
        ]);

        foreach ($request->module_children as $value) {
            Permission::create([
                'name' => $value,
                'display_name' => $value,
                'parent_id' => $permission->id,
                'key_code' => $value . '_' . $request->module_parent
            ]);
        }
       return redirect('/admin/role/add')->with('status', 'Đã tạo Permission thành công');
    }
}
