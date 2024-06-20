<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @yield('title')
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}"> --}}
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/sweet-alert2.css') }}">
    <link rel="icon" href="{{ asset('assets/images/car-fuel-gas-svgrepo-com.svg') }}" type="image/svg+xml">
</head>

{{-- <body onload="window.print();"> --}}

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link">الرئيسية</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <svg width="40px" height="40px" viewBox="0 0 30.00 30.00" id="Layer_1" version="1.1"
                    xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    fill="#000000" stroke="#000000" stroke-width="0.8100000000000002" class="st1">
                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                    <g id="SVGRepo_iconCarrier">
                        <style type="text/css">
                            .st0 {
                                fill: #FD6A7E;
                            }

                            .st1 {
                                fill: #17B978;
                            }

                            .st2 {
                                fill: #8797EE;
                            }

                            .st3 {
                                fill: #41A6F9;
                            }

                            .st4 {
                                fill: #37E0FF;
                            }

                            .st5 {
                                fill: #2FD9B9;
                            }

                            .st6 {
                                fill: #F498BD;
                            }

                            .st7 {
                                fill: #17a2b8;
                            }

                            .st8 {
                                fill: #C6C9CC;
                            }
                        </style>

                        <path class="st8"
                            d="M27,8h-2c-2.2,0-4,1.8-4,4v7c0,0.6-0.4,1-1,1h-1V5c0-0.6-0.4-1-1-1H6C5.4,4,5,4.4,5,5v20H4c-0.6,0-1,0.4-1,1v1 h18v-1c0-0.6-0.4-1-1-1h-1v-3h1c1.7,0,3-1.3,3-3v-7h1c1.1,0,2-0.9,2-2h1c0.6,0,1-0.4,1-1S27.6,8,27,8z M8,11c0-2.2,1.8-4,4-4 s4,1.8,4,4v1h-2.9c0-0.2-0.1-0.3-0.2-0.4l-1.3-1.9c-0.2-0.2-0.5-0.4-0.8-0.3c-0.4,0.1-0.6,0.5-0.4,0.9L11,12H8V11z" />

                    </g>

                </svg>
                <span class="brand-text font-weight-light">المحروقات</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->

                {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex ml-2 mr-0">
                    <div class="image ">
                        <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">أي حد</a>
                    </div>
                </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users "></i>
                                <p>
                                    المستهلكين الرئيسيين
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (App\Models\Consumer::first())
                                    <li class="nav-item">
                                        <a href="{{ route('consumers.index') }}" class="nav-link">
                                            <i class="far fa-eye nav-icon ml-3 mr-0"></i>
                                            <p>عرض</p>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{ route('consumers.create') }}" class="nav-link">
                                        <i class="fas fa-user-plus nav-icon ml-3 mr-0"></i>
                                        <p>إضافة</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                @if (App\Models\Consumer::first() || App\Models\SubConsumer::first())
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users "></i>
                                    <p>
                                        المستهلكين الفرعيين
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (App\Models\SubConsumer::first())
                                        <li class="nav-item">
                                            <a href="{{ route('sub_consumers.index') }}" class="nav-link">
                                                <i class="far fa-eye nav-icon ml-3 mr-0"></i>
                                                <p>عرض</p>
                                            </a>
                                        </li>
                                    @endif

                                    @if (App\Models\Consumer::first())
                                        <li class="nav-item">
                                            <a href="{{ route('sub_consumers.create', App\Models\Consumer::first()) }}"
                                                class="nav-link">
                                                <i class="fas fa-user-plus nav-icon ml-3 mr-0"></i>
                                                <p>إضافة</p>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                        </ul>
                    </nav>
                @endif

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>
                                    العمليات
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: block;">
                                @if (App\Models\Operation::first())
                                    <li class="nav-item">
                                        <a href="{{ route('operations.index') }}" class="nav-link">
                                            <i class="far fa-eye nav-icon ml-3 mr-0"></i>
                                            <p>عرض</p>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-plus-square nav-icon ml-3 mr-0"></i>
                                        <p>
                                            إضافة
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="display: none;">
                                        <li class="nav-item">
                                            <a href="{{ route('operations.create-outcome') }}" class="nav-link">
                                                <i class="fas fa-arrow-up nav-icon ml-5 mr-0"></i>
                                                <p>صرف</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('operations.create-income') }}" class="nav-link">
                                                <i class="fas fa-arrow-down nav-icon ml-5 mr-0"></i>
                                                <p>وارد</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @if (App\Models\Operation::first())
                                    <li class="nav-item">
                                        <a href="{{ route('operations.search') }}" class="nav-link">
                                            <i class="fas fa-search nav-icon ml-3 mr-0"></i>
                                            <p>بحث</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-a text-dark" style="margin: auto; text-align: center">
                                @yield('header')
                            </h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer" style="text-align: center">
            <strong style="float:right">قسم الحاسوب</strong>

            <strong> Copyright &copy; 2024</strong>

            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 rtl -->
    <script src="{{ asset('assets/dist/js/bootstrap.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 -->
    {{-- <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
    <script src="{{ asset('assets/dist/js/sweet-alert2.js') }}"></script>
    <script src="{{ asset('assets/dist/js/axios.js') }}"></script>

    @yield('script')
</body>

</html>
