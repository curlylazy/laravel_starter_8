<html lang="en">

    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="admin panel untuk maintenance sistem">
        <meta name="author" content="Admin Sistem">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">

        <title>Admin Boat</title>
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css">
        <link href="{{ asset('cssadmin/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('cssadmin/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

        <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            // Shared ID
            gtag('config', 'UA-118965717-3');
            // Bootstrap ID
            gtag('config', 'UA-118965717-5');

        </script>

        @stack('stylecss')

    </head>

    <body class="c-app c-dark-theme">
        <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
            <div class="c-sidebar-brand d-lg-down-none">
                <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="{{ asset('cssadmin/assets/brand/coreui.svg#full') }}"></use>
                </svg>
                <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
                    <use xlink:href="{{ asset('cssadmin/assets/brand/coreui.svg#signet') }}"></use>
                </svg>
            </div>
            <ul class="c-sidebar-nav">
                <!-- <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="index.html">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('cssadmin/vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg> Dashboard<span class="badge badge-info">NEW</span></a>
                </li> -->
                <li class="c-sidebar-nav-title">User Menu</li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href='{{ url("admin/dashboard") }}'><i class="c-sidebar-nav-icon cil-speedometer"></i> Dashboard</a>
                    <a class="c-sidebar-nav-link" href='{{ url("admin/auth/profile") }}'><i class="c-sidebar-nav-icon cil-user-female"></i> Profile</a>
                </li>

                @if(session('akses') == 'ADMIN')
                    <li class="c-sidebar-nav-title">Master</li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href='{{ url("admin/master/jenisboat/list") }}'><i class="c-sidebar-nav-icon cil-boat-alt"></i> Jenis Boat</a>
                        <a class="c-sidebar-nav-link" href='{{ url("admin/master/user/list") }}'><i class="c-sidebar-nav-icon cil-user"></i> User</a>
                        <a class="c-sidebar-nav-link" href='{{ url("admin/master/owner/list") }}'><i class="c-sidebar-nav-icon cib-redhat"></i> Owner</a>
                        <a class="c-sidebar-nav-link" href='{{ url("admin/master/boat/list") }}'><i class="c-sidebar-nav-icon cil-boat-alt"></i> Boat</a>
                        <a class="c-sidebar-nav-link" href='{{ url("admin/master/pelanggan/list") }}'><i class="c-sidebar-nav-icon cil-user-follow"></i> Pelanggan</a>
                    </li>
                @endif

                <li class="c-sidebar-nav-title">Transaksi</li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href='{{ url("admin/transaksi/booking/konfirmasi") }}'><i class="c-sidebar-nav-icon cil-featured-playlist"></i> Konfirmasi</a>
                    <a class="c-sidebar-nav-link" href='{{ url("admin/transaksi/booking/list") }}'><i class="c-sidebar-nav-icon cil-featured-playlist"></i> Booking</a>
                    <a class="c-sidebar-nav-link" href='{{ url("admin/transaksi/booking/jadwal") }}'><i class="c-sidebar-nav-icon cil-featured-playlist"></i> Jadwal Booking</a>
                </li>

                <li class="c-sidebar-nav-title">Laporan</li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href='{{ url("admin/laporan/booking") }}'><i class="c-sidebar-nav-icon cil-book"></i> Laporan Booking</a>
                    <a class="c-sidebar-nav-link" href='{{ url("admin/laporan/pelanggan") }}'><i class="c-sidebar-nav-icon cil-book"></i> Laporan Pelanggan</a>
                </li>

            </ul>
            <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
        </div>

        <div class="c-wrapper c-fixed-components">
            <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
                <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                    <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{ asset('cssadmin/vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
                    </svg>
                </button>
                <a class="c-header-brand d-lg-none" href="#">
                    <svg width="118" height="46" alt="CoreUI Logo">
                        <use xlink:href="{{ asset('cssadmin/assets/brand/coreui.svg#full') }}"></use>
                    </svg>
                </a>
                <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                    <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{ asset('cssadmin/vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
                    </svg>
                </button>


                <ul class="c-header-nav d-md-down-none">
                    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" onclick="return confirm('Log out dari sistem ?');" href="{{ url('admin/auth/actlogout') }}"> Log Out</a></li>
                </ul>

                <ul class="c-header-nav ml-auto mr-4">
                    <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#">{{ session('namauser') }}</a></li>
                </ul>

                <div class="c-subheader px-3">
                    @yield('breadcumb')
                    <!-- <ol class="breadcrumb border-0 m-0">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol> -->
                </div>
            </header>

            <div class="c-body">
                <main class="c-main">
                    <div class="container-fluid">
                        <div class="fade-in">
                            @yield('content')
                        </div>
                    </div>
                </main>
                <footer class="c-footer">
                    <div><a href="https://coreui.io">CoreUI</a> © 2020 Egik - Penyewaan Boat.</div>
                    <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
                </footer>
            </div>
        </div>

        <script src="{{ asset('cssadmin/plugins/jquery/dist/jquery.min.js') }}"></script>

        <!-- CoreUI and necessary plugins-->
        <script src="{{ asset('cssadmin/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
        <!--[if IE]><!-->
        <script src="{{ asset('cssadmin/vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
        <!--<![endif]-->
        <!-- Plugins and scripts required by this view-->
        <script src="{{ asset('cssadmin/vendors/@coreui/chartjs/js/coreui-chartjs.bundle.js') }}"></script>
        <script src="{{ asset('cssadmin/vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
        <!-- <script src="{{ asset('cssadmin/js/main.js') }}"></script> -->

        <!-- Date Picker -->
        <link href="{{ asset('cssadmin/plugins/datepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
        <script src="{{ asset('cssadmin/plugins/datepicker/jquery.datetimepicker.full.js') }}"></script>

        <!-- autonumeric -->
        <script type="text/javascript" src="{{ asset('cssadmin/plugins/autonumeric/autoNumeric.min.js') }}"></script>

        <!-- Data Table -->
        <!-- <link href="{{ asset('cssadmin/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ asset('cssadmin/plugins/datatables/jquery.dataTables.min.js') }}"></script> -->

        <style>
            div.dataTables_wrapper div.dataTables_length select {
                width: 50px !important;
                display: inline-block;
            }

            .readonly
            {
                pointer-events: none;
            }
        </style>

        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

        <!--alerts CSS -->
        <link href="{{ asset('cssadmin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ asset('cssadmin/plugins/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('cssadmin/plugins/sweetalert/jquery.sweet-alert.custom.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.datepicker').datetimepicker({
                    timepicker: false,
                    format: 'Y-m-d'
                });
            });
        </script>

        @stack('scripts')
    </body>

</html>
