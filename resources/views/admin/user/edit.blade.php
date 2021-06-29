@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendors/select2.min.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật người dùng
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('update_user', $user->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}" disabled>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                        @error('password-confirm')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Chọn vai trò</label>
                        <select name="role_id[]" class="form-control select2_init" multiple>
                            @foreach ($roles as $role)
                                <option {{ $rolesOfUser->contains('id', $role->id) ? 'selected' : '' }}
                                    value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id[]')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" name="btn-add" class="btn btn-primary" value="Cập nhật">Cập nhật</button>
                </form>
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
@endsection
