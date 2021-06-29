@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm danh mục
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('admin/supplier/cat/store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug') }}">
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="type">Loại </label>
                                <select class="form-control" name="type">
                                    @foreach ($list_cat as $k => $cat)
                                        <option value="{{ $k }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="type_cat">Danh mục </label>
                                <select class="form-control" name="type_cat">
                                    <option value="">Chọn</option>
                                    @foreach ($category as $k => $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('type_cat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{-- <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                        value="option1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                        value="option2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div> --}}
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $tmp = 0;
                                @endphp
                                @foreach ($category as $cat)
                                    @php
                                    $tmp++;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $tmp }}</th>
                                        <td>{{ $cat->name }}</td>
                                        <td>{{ $cat->slug }}</td>                                          
                                        {{-- @php dd($cat->user->toArray()) @endphp --}}                                       
                                        <td>{{ $cat->user->name }}</td>                                                                                  
                                        <td>
                                            <a href="{{ route('supplier_cat_edit', $cat->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            {{-- <a
                                                href="{{ route('supplier_cat_delete', $cat->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="return confirm('Bạn có chắc chắn muốn xoá danh mục này?')"><i
                                                    class="fa fa-trash"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
