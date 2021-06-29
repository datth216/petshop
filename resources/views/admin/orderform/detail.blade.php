@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Chi tiết phiếu đặt hàng</h5>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <h5 style="text-align: center">PHIẾU ĐẶT HÀNG</h5>
                </div>
                <div class="d-flex flex-column">
                    <div class="p-2 ">
                        <span class="font-weight-bold">Mã đơn hàng: </span>
                        <span>{{$orderform->id}}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Nhà cung cấp: </span>
                        <span>{{$orderform->supplier->name}}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Ngày tạo: </span>
                        <span>{{$orderform->created_at->format('d/m/Y')}}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Địa điểm nhận hàng: </span>
                        <span>{!!$orderform->address!!}</span>
                    </div>
                    <div class="p-2 ">
                        <span class="font-weight-bold">Nội dung đơn hàng: </span>
                        <span>{!!$orderform->content!!}</span>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
@endsection
