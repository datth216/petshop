@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Chi tiết sản phẩm </h5>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <h5 style="text-align: center">THÔNG TIN SẢN PHẨM</h5>
                </div>
                <div class="d-flex flex-column">
                    <div class="p-2 ">
                        <span class="font-weight-bold">Mã sản phẩm: </span>
                        <span>{{ $product->id }}</span>
                    </div>
                    {{-- <div class="p-2 ">
                        <span class="font-weight-bold">Hình ảnh: </span>
                        <span><img src="{{ url($product->img) }}" alt="" height="80" width=""></span>
                    </div> --}}
                    <div class="p-2 ">
                        <span class="font-weight-bold">Mô tả sản phẩm: </span>
                        <span>{!! $product->desc !!}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Chi tiết sản phẩm: </span>
                        <span>{!! $product->detail !!}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Danh mục sản phẩm: </span>
                        <span>{{ $product->category->name }}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Nhà cung cấp: </span>
                        <span>{{ $product->supplier->name }}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Người tạo: </span>
                        <span>{{ $product->user->name }}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Ngày tạo: </span>
                        <span>{{ $product->created_at->format('d/m/y - H:i:s') }}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Số lượng: </span>
                        <span>{{ $product->qty }}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Đơn giá: </span>
                        <span>{{ number_format($product->price, 0, '', '.') }}đ</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Tổng: </span>
                        <span>{{ number_format($product->total_price, 0, '', '.') }}đ</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Trạng thái: </span>
                        <span>{{ $product->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
