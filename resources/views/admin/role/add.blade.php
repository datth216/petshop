@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2.min.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm quyền
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/role/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên vai trò</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Mô tả vai trò</label>
                        {{-- <textarea name="display_name" class="form-control"
                            id="display_name" cols="30" rows="10">{{ old('display_name') }}</textarea>
                        @error('display_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror --}}
                        <input class="form-control" type="text" name="display_name" id="display_name"
                            value="{{ old('display_name') }}">
                        @error('display_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        @foreach ($permissionsParent as $row)
                            <div class="select col-md-3">
                                <div class="card border-secondary mb-5" style="max-width: 18rem;">
                                    <div class="card-header">
                                        <label>
                                            <input type="checkbox" value="" class="checkbox_wrapper">
                                        </label>
                                        {{ $row->name }}
                                    </div>
                                    <div class="card-body text-secondary">
                                        @foreach ($row->permissionsChildren as $permissionsChildrenItem)
                                            <div>
                                                <label>
                                                    <input type="checkbox" value="{{ $permissionsChildrenItem->id }}"
                                                        class="checkbox_children" name="permission_id[]">
                                                </label>
                                                {{ $permissionsChildrenItem->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" name="btn-add" class="btn btn-primary" value="Thêm mới">Thêm mới</button>
                </form>
            </div>

        </div>
    </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendors/select2.min.js') }}"></script>
    <script>
        $('.select2_init').select2({
            'placeholder': 'Chọn vai trò',
        })

    </script>
    <script>
        $('.checkbox_wrapper').on('click', function() {
            $(this).parents('.select').find('.checkbox_children').prop('checked', $(this).prop('checked'));
        });

    </script>
@endsection
