{{--  @can('update', $supplier)  --}}
@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật nhà cung cấp
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('supplier_update', $supplier->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên nhà cung cấp</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{$supplier->name}}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{$supplier->email}}" disabled>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú</label>
                        <textarea name="note" class="form-control" id="note" cols="30" rows="5">{{$supplier->note}}</textarea>
                        @error('note')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn-update">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
{{--  @endcan  --}}