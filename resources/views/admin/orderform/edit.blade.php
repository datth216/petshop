@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
           Sửa thông tin phiếu đặt hàng
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('update_orderform', $orderform->id) }}" id="test1">
                @csrf       
                <div class="form-group">
                    <label for="name">Tên phiếu</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">                        
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>      
                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Địa chỉ</label>
                    <input class="form-control" type="text" name="address" id="address" value="{{ old('address') }}">                        
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="supplier_cat">Nhà cung cấp</label>
                    <select class="form-control" id="supplier_cat" name="supplier_cat" data-dependent="supply">
                        <option value="">Chọn nhà cung cấp</option>
                        @foreach ($supplier as $sup)
                        <option value="{{$sup->id}}">{{$sup->name}}</option>
                        @endforeach
                    </select>
                    @error('supplier_cat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="not-yet">
                        <label class="form-check-label" for="status1">
                            Chưa giao
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="delivered">
                        <label class="form-check-label" for="status2">
                            Đã giao
                        </label>
                    </div>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> 
                <button type="submit" class="btn btn-primary" name="btn-add">Cập nhật</button>                    
            </form>
        </div>
    </div>
</div>    
@endsection