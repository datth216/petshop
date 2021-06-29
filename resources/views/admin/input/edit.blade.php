@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật phiếu nhập hàng
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('update_input', $input->id) }}" id="test1">
                    @csrf
                    {{-- <div class="form-group">
                        <label for="supplier_cat">Nhà cung cấp</label>
                        <select class="form-control" id="supplier_cat" name="supplier_cat" data-dependent="supply">
                            <option value="">Chọn nhà cung cấp</option>
                            @foreach ($supplier as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_cat')
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
                        <label for="content">Nội dung</label>
                        <textarea name="content" class="form-control" id="content" cols="30"
                            rows="5">{{ old('content') }}</textarea>
                        @error('content')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product_cat">Sản phẩm</label>
                        <select class="form-control" id="product_cat" name="product_cat" data-dependent="product_cat">
                            <option value="">Chọn sản phẩm</option>
                        </select>
                        @error('product_cat')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div> --}}
                    {{--  <div class="form-group">
                        <label for="qty">Số lượng</label>
                        <select class="form-control" id="qty" name="qty">
                            <option value="{{$input->product->qty}}">{{$input->product->qty}}</option>
                        </select>
                        @error('qty')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>  --}}
                    <div class="form-group">
                        <label for="qty">Số lượng</label>
                        <input class="form-control" type="text" name="qty" id="qty" value="" >
                        @error('qty')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control" type="text" name="price" id="price" value="">
                        @error('price')
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
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status3" value="not-enough-stock">
                            <label class="form-check-label" for="status3">
                                Chưa đủ hàng
                            </label>
                        </div>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div> 
                    <button type="submit" class="btn btn-primary" name="btn-add">Nhập hàng</button>
                </form>
            </div>
        </div>
    </div>
@endsection
