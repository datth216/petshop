@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">SỐ LƯỢNG SẢN PHẨM </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product_qty }}</h5>
                        <p class="card-text">Sản phẩm trong kho</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">CHI PHÍ NHẬP KHO</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($input_price, 0, '', '.') }}đ</h5>
                        <p class="card-text">Tổng giá trị nhập kho</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">CHI PHÍ XUẤT KHO</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($output_price, 0, '', '.') }}đ</h5>
                        <p class="card-text">Tổng giá trị xuất kho</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY / THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderform_list_cancel }} đơn / {{ $orderform_list_success }} đơn</h5>
                        <p class="card-text">Số đơn đặt hàng huỷ / thành công</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Mã</th>
                            <th scope="col">Tên đơn hàng</th>
                            <th scope="col">Nhà cung cấp</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderform as $orderformItem)
                            <tr>
                                <td>{{ $orderformItem->id }}</td>
                                <td>{{ $orderformItem->name }}</td>
                                <td>{{ $orderformItem->supplier->name }}</td>
                                @if ($orderformItem->status == 'not-yet')
                                    <td><span class="badge badge-warning">Đang xử lý</span></td>
                                @else
                                    <td><span class="badge badge-success">Thành công</span></td>
                                @endif

                                <td>{{ $orderformItem->user->name }}</td>
                                <td>26:06:2020 14:00</td>
                                <td>
                                    <a href="{{ route('edit_orderform', $orderformItem->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ route('delete_orderform', $orderformItem->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $orderform->links() }}
            </div>
        </div>

    </div>
@endsection
