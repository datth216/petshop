@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
               Tạo module
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/permission/store') }}" id="test1">
                    @csrf
                    <div class="form-group">
                        <label for="supplier_cat">Chọn tên module</label>
                        <select class="form-control" id="parent_id" name="module_parent">
                            <option value="">Chọn module</option>
                            @foreach (config('permissions.table_module') as $moduleItem)
                                <option value="{{ $moduleItem }}">{{ $moduleItem }}</option>
                            @endforeach
                        </select>
                        @error('supplier_cat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            @foreach (config('permissions.module_children') as $moduleItemChildren)
                                <div class="col-md-3">
                                    <label for="">
                                        <input type="checkbox" value="{{ $moduleItemChildren }}" name="module_children[]">
                                        {{ $moduleItemChildren }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn-add">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
