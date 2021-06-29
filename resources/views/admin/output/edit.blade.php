@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật phiếu xuất hàng
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('update_output', $output->id) }}" id="test1">
                    @csrf
                    <div class="form-group">
                        <label for="qty">Số lượng</label>
                        <input class="form-control" type="text" name="qty" id="qty" value="">
                        @error('qty')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control" type="text" name="price" id="price" value="">
                        @error('price')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{--  <div class="form-group">
                        <label for="price">Giá</label>
                        <select class="form-control" id="price" name="price">                            
                            @foreach ($product as $row)
                                <option value="{{ $row->price }}">{{ $row->price }}</option>
                            @endforeach
                        </select>
                        @error('supplier_cat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>  --}}
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="not-yet">
                            <label class="form-check-label" for="status1">
                                Chưa giao
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="delivered">
                            <label class="form-check-label" for="status2">
                                Đã giao
                            </label>
                        </div>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn-add">Nhập hàng</button>
                </form>
            </div>
        </div>
    </div>
@endsection
