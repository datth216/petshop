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
                <h5 class="m-0 ">Danh sách quyền</h5>
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
                </div>
                <form action="{{ url('admin/role/action') }}" method="">
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
                                <th scope="col">Tên vai trò</th>
                                <th scope="col">Mô tả vai trò</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($role->total() > 0)
                                @php
                                $temp = 0;
                                @endphp
                                @foreach ($role as $row)
                                    @php
                                    $temp++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $row->id }}">
                                        </td>
                                        <th scope="row">{{ $temp }}</th>
                                        <td>{{ $row->name }}</td>
                                        <td>{!! $row->display_name !!}</td>
                                        <td>
                                            <a href="{{ route('edit_role', $row->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('delete_role', $row->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="return confirm('Bạn có chắc chắn muốn xoá quyền này?')"><i
                                                    class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="">
                                    <td colspan="7" class="bg-white" style="text-align: center">Không tìm thấy quyền
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $role->links() }}
            </div>
        </div>
    </div>
@endsection
