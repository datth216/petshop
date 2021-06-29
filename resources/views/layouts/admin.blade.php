<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')
    <title>Administrator</title>
    <script src="https://cdn.tiny.cloud/1/5lmhbxfzo2qs2q7sxnwm6zqdo8rdlxq5xt7wkx0jka64zmqm/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: "124.83",
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'table emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor emoticons | help',
            menu: {
                favs: {
                    title: 'My Favorites',
                    items: 'code visualaid | searchreplace | emoticons'
                }
            },
            menubar: 'favs file edit view insert format tools table help',
            content_css: 'css/content.css'
        });

    </script>
</head>

<body>

    <body>
        <div id="warpper" class="nav-fixed">
            <nav class="topnav shadow navbar-light bg-white d-flex">
                <div class="navbar-brand"><a href="{{ url('/admin/dashboard') }}">PETSHOP ADMIN</a></div>
                <div class="nav-right ">
                    <div class="btn-group mr-auto">
                        {{-- <button type="button" class="btn dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="plus-icon fas fa-plus-circle"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ url('admin/post/add') }}">Thêm bài viết</a>
                            <a class="dropdown-item" href="{{ url('admin/post/product') }}">Thêm sản phẩm</a>
                            <a class="dropdown-item" href="{{ url('admin/order/list') }}">Xem đơn hàng</a>
                        </div> --}}
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Tài khoản</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Thoát') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- end nav  -->
            @php
            $module_active = session('module_active');
            @endphp
            <div id="page-body" class="d-flex">
                <div id="sidebar" class="bg-white">
                    <ul id="sidebar-menu">
                        <li class="nav-link   {{ $module_active == 'dashboard' ? 'active' : '' }}">
                            <a href="{{ url('admin/dashboard') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Dashboard
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                        </li>
                        <li class="nav-link   {{ $module_active == 'supplier' ? 'active' : '' }}">
                            <a href="{{ url('admin/supplier/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Nhà cung cấp
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/supplier/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/supplier/list') }}">Danh sách</a></li>
                            </ul>
                        </li>

                        <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }}">
                            <a href="{{ url('admin/product/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Sản phẩm
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/product/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/product/category') }}">Danh mục</a></li>
                                <li><a href="{{ url('admin/product/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                        <li class="nav-link  {{ $module_active == 'orderform' ? 'active' : '' }}">
                            <a href="{{ url('admin/orderform/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Đặt hàng
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/orderform/add') }}">Tạo phiếu</a></li>
                                <li><a href="{{ url('admin/orderform/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                        <li class="nav-link  {{ $module_active == 'input' ? 'active' : '' }}">
                            <a href="{{ url('admin/input/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Nhập hàng
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/input/add') }}">Nhập hàng</a></li>
                                <li><a href="{{ url('admin/input/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                        <li class="nav-link {{ $module_active == 'output' ? 'active' : '' }}">
                            <a href="{{ url('admin/output/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Xuất hàng
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/output/add') }}">Xuất hàng</a></li>
                                <li><a href="{{ url('admin/output/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                        {{-- <li class="nav-link">
                            <a href="{{ url('admin/store/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Kho hàng
                            </a>
                            <i class="arrow fas fa-angle-right"></i>
                        </li> --}}
                        {{--  <li class="nav-link">
                            <a href="{{ url('admin/statistic/revenue') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Thống kê
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/statistic/inventory') }}">Tồn kho</a></li>
                                <li><a href="{{ url('admin/statistic/revenue') }}">Doanh thu</a></li>
                                <li><a href="{{ url('admin/statistic/goods-sold') }}">Đã bán</a></li>
                            </ul>
                        </li>  --}}
                        <li class="nav-link   {{ $module_active == 'user' ? 'active' : '' }}">
                            <a href="{{ url('admin/user/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Quản trị viên
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/user/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/user/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                        <li class="nav-link {{ $module_active == 'role' ? 'active' : '' }}">
                            <a href="{{ url('admin/role/list') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Quyền
                            </a>
                            <i class="arrow fas fa-angle-down"></i>
                            <ul class="sub-menu">
                                <li><a href="{{ url('admin/role/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/role/list') }}">Danh sách</a></li>
                            </ul>
                        </li>
                        <li class="nav-link ">
                            <a href="{{ url('admin/permission/add') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Tạo Permission
                            </a>
                            {{-- <i class="arrow fas fa-angle-down"></i> --}}
                            {{-- <ul class="sub-menu">
                                <li><a href="{{ url('admin/role/add') }}">Thêm mới</a></li>
                                <li><a href="{{ url('admin/role/list') }}">Danh sách</a></li>
                            </ul> --}}
                        </li>

                        <!-- <li class="nav-link"><a>Bài viết</a>
                        <ul class="sub-menu">
                            <li><a>Thêm mới</a></li>
                            <li><a>Danh sách</a></li>
                            <li><a>Thêm danh mục</a></li>
                            <li><a>Danh sách danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link"><a>Sản phẩm</a></li>
                    <li class="nav-link"><a>Đơn hàng</a></li>
                    <li class="nav-link"><a>Hệ thống</a></li> -->

                    </ul>
                </div>
                <div id="wp-content">
                    @yield('content')
                </div>
            </div>


        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/select.js') }}"></script>
        <script src="{{ asset('js/select_product.js') }}"></script>
        @yield('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>

</html>
