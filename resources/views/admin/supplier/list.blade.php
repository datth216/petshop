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
                <h5 class="m-0 ">Danh sách nhà cung cấp</h5>
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
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/supplier/action') }}" method="">
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
                                <th scope="col">#</th>
                                <th scope="col">Tên nhà cung cấp</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($supplier->total() > 0)
                                @php
                                $temp = 0;
                                @endphp
                                @foreach ($supplier as $sup)
                                    @php
                                    $temp++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $sup->id }}">
                                        </td>
                                        <th scope="row">{{ $temp }}</th>
                                        <td>{{ $sup->name }}</td>
                                        <td>{{ $sup->email }}</td>
                                        <td>{!! $sup->created_at->format('d/m/Y - H:i:s') !!}</td>
                                        <td>{{ $sup->user->name }}</td>
                                        <td>
                                            @if ($status != 'trash')
                                                <a href="{{ route('supplier_edit', $sup->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('supplier_delete', $sup->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xoá nhà cung cấp này?')"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('supplier_restore', $sup->id) }}"
                                                    class="btn btn-warning btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có chắc chắn muốn phục hồi nhà cung cấp này?')"><i
                                                        class="fas fa-undo"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="">
                                    <td colspan="7" class="bg-white" style="text-align: center">Không tìm thấy nhà cung cấp
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $supplier->links() }}
            </div>
        </div>
    </div>
@endsection
