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
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" class="form-control form-search" name="keyword" placeholder="Tìm kiếm"
                            value="{{ request()->input('keyword') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu hoá<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/user/action') }}" method="">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
                            {{-- <option value="empty">Chọn</option>
                            <option value="restore">Khôi phục</option>
                            <option value="delete">Xoá</option> --}}
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
                                <th scope="col">Họ tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($user->total() > 0)
                                @php
                                $temp = 0;
                                @endphp
                                @foreach ($user as $u)
                                    @php
                                    $temp++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $u->id }}">
                                        </td>
                                        <th scope="row">{{ $temp }}</th>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->created_at }}</td>
                                        <td>
                                            @if ($status != 'trash')
                                                <a href="{{ route('edit_user', $u->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (Auth::id() != $u->id)
                                                    {{--so sánh id user đang login - id trong
                                                    vòng
                                                    lặp
                                                    --}}

                                                    <a href="{{ route('delete_user', $u->id) }}"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xoá thành viên này?')"><i
                                                            class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ route('restore_user', $u->id) }}"
                                                    class="btn btn-warning btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có chắc chắn muốn phục hồi thành viên này?')"><i
                                                        class="fas fa-undo"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="">
                                    <td colspan="7" class="bg-white" style="text-align: center">Không tìm thấy thành viên
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $user->links() }}
            </div>
        </div>
    </div>
@endsection
