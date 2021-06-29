@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm nhà cung cấp
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/supplier/store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên nhà cung cấp</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú</label>
                        <textarea name="note" class="form-control" id="note" cols="30" rows="5">{{{ old('note') }}}</textarea>
                        @error('note')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn-add">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
