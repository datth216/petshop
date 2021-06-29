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
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
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
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu hoá<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ url('admin/product/action') }}" method="">
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
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($product->total() > 0)
                                @php
                                $tmp = 0;
                                @endphp
                                {{-- @php
                                $product = Product::with('category')->where('id',$product->id)->get();
                                @endphp --}}
                                @foreach ($product as $pro)
                                    @php
                                    $tmp++;
                                    @endphp
                                    <tr class="">
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $pro->id }}">
                                        </td>
                                        <td>{{ $tmp }}</td>
                                        <td><img src="{{ url($pro->img) }}" alt="" height="80" width=""></td>
                                        <td><a href="#">{{ $pro->name }}</a></td>
                                        {{-- <td>{{ number_format($pro->price, 0, '', '.') }}đ
                                        </td> --}}
                                        <td>{{ $pro->category->name }}</td>
                                        {{-- <td>{{ $pro->qty }}</td>
                                        --}}
                                        {{-- <td>
                                            {{ number_format($pro->total_price, 0, '', '.') }}đ
                                        </td>
                                        --}}
                                        <td>{{ $pro->created_at->format('d/m/Y - H:i:s') }}</td>
                                        @if ($pro->status == 'available' && $pro->qty > 0)
                                            <td><span class="badge badge-success">Còn hàng</span></td>
                                            {{-- @elseif($pro->status == 'out-stock' &&
                                            $pro->qty
                                            > 0)
                                            <td><span class="badge badge-success">Lỗi</span></td>
                                            --}}
                                        @else
                                            <td><span class="badge badge-danger">Hết hàng</span></td>
                                        @endif
                                        <td>
                                            @if ($status != 'trash')
                                                <a href="{{ route('detail_product', $pro->id) }}"
                                                    class="btn btn-primary btn-sm rounded-0 text-white" type="button"
                                                    data-placement="top" title="Xem"><i class="fas fa-info-circle"></i></a>
                                                <a href="{{ route('edit_product', $pro->id) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('delete_product', $pro->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('restore_product', $pro->id) }}"
                                                    class="btn btn-warning btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Bạn có chắc chắn muốn phục hồi sản phẩm này?')"><i
                                                        class="fas fa-undo"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="">
                                    <td colspan="10" class="bg-white" style="text-align: center">Không tìm thấy sản phẩm
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $product->links() }}
            </div>
        </div>
    </div>
@endsection
