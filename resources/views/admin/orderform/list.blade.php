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
                <h5 class="m-0 ">Danh sách phiếu đặt hàng</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search" placeholder="Tìm kiếm"
                            value="{{ request()->input('keyword') }}" name="keyword">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'delivered']) }}" class="text-primary">Đã giao<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'not-yet']) }}" class="text-primary">Chưa giao<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/orderform/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
                            {{-- <option>Chọn</option>
                            <option>Tác vụ 1</option>
                            <option>Tác vụ 2</option> --}}
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
                                <th scope="col">#</th>
                                <th scope="col">Tên phiếu</th>
                                <th scope="col">Nhà cung cấp</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orderform->total() > 0)
                            @php
                            $temp = 0;
                            @endphp
                            @foreach ($orderform as $row)
                                @php
                                $temp++;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $row->id }}">
                                    </td>
                                    <th scope="row">{{ $temp }}</th>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->supplier->name }}</td>
                                    <td>{!! $row->user->name !!}</td>
                                    <td>{{ $row->created_at->format('d/m/Y - H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('detail_orderform', $row->id) }}"
                                            class="btn btn-primary btn-sm rounded-0 text-white" type="button"
                                            data-placement="top" title="Xem"><i class="fas fa-info-circle"></i></a>
                                        <a href="{{ route('edit_orderform', $row->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete_orderform', $row->id) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"
                                            onclick="return confirm('Bạn có chắc chắn muốn xoá nhà cung cấp này?')"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr class="">
                                <td colspan="7" class="bg-white" style="text-align: center">Không tìm thấy phiếu đặt hàng
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </form>
                {{ $orderform->links() }}
            </div>
        </div>
    </div>
@endsection
