<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', 'AdminDashboardController@show');
    Route::get('/admin', 'AdminDashboardController@show');

    Route::get('/admin/supplier/list', 'AdminSupplierController@list')->middleware('can:supplier-list');
    Route::get('/admin/supplier/add', 'AdminSupplierController@add')->middleware('can:supplier-add');
    Route::post('/admin/supplier/store', 'AdminSupplierController@store');
    Route::get('/admin/supplier/delete/{id}', 'AdminSupplierController@delete')->name('supplier_delete')->middleware('can:supplier-delete');
    Route::get('/admin/supplier/edit/{id}', 'AdminSupplierController@edit')->name('supplier_edit')->middleware('can:supplier-edit');
    Route::post('/admin/supplier/update/{id}', 'AdminSupplierController@update')->name('supplier_update');
    Route::get('/admin/supplier/restore/{id}', 'AdminSupplierController@restore')->name('supplier_restore')->middleware('can:supplier-restore');
    Route::get('/admin/supplier/action', 'AdminSupplierController@action');

    Route::get('/admin/product/category', 'AdminCategoryController@cat_product')->middleware('can:category-list');
    Route::post('/admin/product/cat/store', 'AdminCategoryController@store_product');
    Route::get('/admin/product/cat/edit/{id}', 'AdminCategoryController@product_cat_edit')->name('product_cat_edit')->middleware('can:category-edit');
    Route::post('/admin/product/cat/update/{id}', 'AdminCategoryController@product_cat_update')->name('product_cat_update');
    Route::get('/admin/product/cat/delete/{id}', 'AdminCategoryController@product_cat_delete')->name('product_cat_delete')->middleware('can:category-delete');

    Route::get('/admin/user/list', 'AdminUserController@list')->middleware('can:staff-list');
    Route::get('/admin/user/add', 'AdminUserController@add')->middleware('can:staff-add');
    Route::post('/admin/user/store', 'AdminUserController@store');
    Route::get('/admin/user/delete/{id}', 'AdminUserController@delete')->name('delete_user')->middleware('can:staff-delete');
    Route::get('/admin/user/action', 'AdminUserController@action');
    Route::get('/admin/user/edit/{id}', 'AdminUserController@edit')->name('edit_user')->middleware('can:staff-edit');
    Route::post('/admin/user/update/{id}', 'AdminUserController@update')->name('update_user');
    Route::get('/admin/user/restore/{id}', 'AdminUserController@restore')->name('restore_user')->middleware('can:staff-restore');

    Route::get('/admin/role/list', 'AdminRoleController@list')->middleware('can:role-list');
    Route::get('/admin/role/add', 'AdminRoleController@add')->middleware('can:role-add');
    Route::post('/admin/role/store', 'AdminRoleController@store');
    Route::get('/admin/role/edit/{id}', 'AdminRoleController@edit')->name('edit_role')->middleware('can:role-edit');
    Route::post('/admin/role/update/{id}', 'AdminRoleController@update')->name('update_role');
    Route::get('/admin/role/delete/{id}', 'AdminRoleController@delete')->name('delete_role')->middleware('can:role-delete');
    Route::get('/admin/role/action', 'AdminRoleController@action');

    Route::get('/admin/permission/add', 'AdminPermissionController@addPermission')->name('add_permission')->middleware('can:permission-add');
    Route::post('/admin/permission/store', 'AdminPermissionController@store');

    Route::get('/admin/product/list', 'AdminProductController@list')->middleware('can:product-list');
    Route::get('/admin/product/add', 'AdminProductController@add')->middleware('can:product-add');
    Route::post('/admin/product/store', 'AdminProductController@store');
    Route::get('/admin/product/edit/{id}', 'AdminProductController@edit')->name('edit_product')->middleware('can:product-edit');
    Route::post('/admin/product/update/{id}', 'AdminProductController@update')->name('update_product');
    Route::get('/admin/product/delete/{id}', 'AdminProductController@delete')->name('delete_product')->middleware('can:product-delete');;
    Route::get('/admin/product/action', 'AdminProductController@action');
    Route::get('/admin/product/restore/{id}', 'AdminProductController@restore')->name('restore_product')->middleware('can:product-restore');;
    Route::get('/admin/product/detail/{id}', 'AdminProductController@detail')->name('detail_product')->middleware('can:detail-product');

    Route::get('/admin/orderform/list', 'AdminOrderFormController@list')->middleware('can:orderform-list');
    Route::get('/admin/orderform/add', 'AdminOrderFormController@add')->middleware('can:orderform-add');
    Route::post('/admin/orderform/store', 'AdminOrderFormController@store');
    Route::get('/admin/orderform/fetch', 'AdminOrderFormController@fetch');
    Route::get('/admin/orderform/detail/{id}', 'AdminOrderFormController@detail')->name('detail_orderform')->middleware('can:orderform-detail');
    Route::get('/admin/orderform/edit/{id}', 'AdminOrderFormController@edit')->name('edit_orderform')->middleware('can:orderform-edit');
    Route::post('/admin/orderform/update/{id}', 'AdminOrderFormController@update')->name('update_orderform');
    Route::get('/admin/orderform/delete/{id}', 'AdminOrderFormController@delete')->name('delete_orderform')->middleware('can:orderform-delete');
    Route::get('/admin/orderform/action', 'AdminOrderformController@action');

    Route::get('/admin/input/list', 'AdminInputController@list')->middleware('can:input-list');
    Route::get('/admin/input/add', 'AdminInputController@input_product')->middleware('can:input-add');
    Route::post('/admin/input/store', 'AdminInputController@store');
    Route::get('/admin/input/edit/{id}/', 'AdminInputController@edit')->name('edit_input')->middleware('can:input-edit');
    Route::post('/admin/input/update/{id}', 'AdminInputController@update')->name('update_input');
    Route::get('/admin/input/delete/{id}', 'AdminInputController@delete')->name('delete_input')->middleware('can:input-delete');
    Route::get('/admin/input/action', 'AdminInputController@action');

    Route::get('/admin/output/list', 'AdminOutputController@list')->middleware('can:output-list');
    Route::get('/admin/output/add', 'AdminOutputController@add')->middleware('can:output-add');
    Route::post('/admin/output/store', 'AdminOutputController@store');
    Route::get('/admin/output/edit/{id}/', 'AdminOutputController@edit')->name('edit_output')->middleware('can:output-edit');
    Route::post('/admin/output/update/{id}', 'AdminOutputController@update')->name('update_output');
    Route::get('/admin/output/action', 'AdminOutputController@action');
});
