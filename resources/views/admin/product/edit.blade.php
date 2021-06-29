@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật sản phẩm
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('update_product', $product->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $product->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input class="form-control" type="text" name="price" id="price" value="{{ $product->price }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="desc">Mô tả sản phẩm</label>
                                <textarea name="desc" class="form-control" id="desc" cols="30"
                                    rows="5">{{ $product->desc }}</textarea>
                            </div>
                            @error('desc')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="detail">Chi tiết sản phẩm</label>
                        <textarea name="detail" class="form-control" id="detail" cols="30"
                            rows="5">{{ $product->detail }}</textarea>
                        @error('detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="supplier_cat">Nhà cung cấp</label>
                        <select class="form-control" id="supplier_cat" name="supplier_cat">
                            <option value="">Chọn nhà cung cấp</option>
                            @foreach ($supplier as $sup)
                                <option value="{{ $sup->id }}" {{ $product->supplier_cat == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_cat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="product_cat">Danh mục</label>
                        <select class="form-control" id="product_cat" name="product_cat">
                            <option value="">Chọn danh mục</option>
                            @foreach ($category as $cat)
                                <option value="{{ $cat->id }}" {{ $product->product_cat == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_cat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="qty">Số lượng</label>
                                <input class="form-control" type="number" name="qty" id="qty" min="0"
                                    value="{{ $product->qty }}">
                                @error('qty')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="available"
                                {{ $product->status == 'available' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status1">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="out-stock"
                                {{ $product->status == 'out-stock' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status2">
                                Hết hàng
                            </label>
                        </div>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="img">Hình ảnh</label><br>
                        <input type="file" name="img" required="true">
                    </div>
                    @error('img')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <br><button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
