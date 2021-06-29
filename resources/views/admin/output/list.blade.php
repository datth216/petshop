@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách phiếu xuất hàng</h5>
                <div class="form-search form-inline">
                    {{-- <form action="#">
                        <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'delivered']) }}" class="text-primary">Đã giao<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'not-yet']) }}" class="text-primary">Chưa giao<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/output/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
                            @foreach ($list_act as $k => $act)
                                <option value="{{ $k }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">Mã</th>
                                <th scope="col">Nhà cung cấp</th>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($output->total() > 0)
                                @foreach ($output as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->supplier->name }}</td>
                                        <td><a href="#">{{ $item->product->name }}</a></td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ number_format($item->price, 0, '', '.') }}đ</td>
                                        @if ($item->status == 'not-yet')
                                            <td><span class="badge badge-warning">Chưa giao</span></td>
                                        @else
                                            <td><span class="badge badge-success">Đã giao</span></td>
                                        @endif
                                        <td>{{ $item->created_at->format('d/m/Y - H:i:s') }}</td>
                                        <td>
                                            @if ($item->status == 'delivered')
                                                <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('edit_output', $item->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="">
                                    <td colspan="10" class="bg-white" style="text-align: center">Không tìm thấy phiếu nhập
                                        hàng
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $output->links() }}
            </div>
        </div>
    </div>
@endsection
