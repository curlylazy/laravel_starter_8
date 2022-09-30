<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Panel</title>

    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('cssadmin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('cssadmin/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('cssadmin/css/style_sidebar.css') }}" rel="stylesheet">

    <script src="{{ asset('cssadmin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('cssadmin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('cssadmin/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

    <!--Wave Effects -->
    <script src="{{ asset('cssadmin/js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('cssadmin/js/myadmin.js') }}"></script>

    <!-- autonumeric -->
    <script type="text/javascript" src="{{ asset('cssadmin/plugins/autonumeric/autoNumeric.min.js') }}"></script>

    <!-- numeral JS -->
    <script type="text/javascript" src="{{ asset('cssadmin/plugins/numeral/numeral.min.js') }}"></script>

    <!-- Date Picker -->
    <link href="{{ asset('cssadmin/plugins/datepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('cssadmin/plugins/datepicker/jquery.datetimepicker.full.js') }}"></script>

    <!-- font awesome -->
    <link rel="stylesheet" href="{{ asset('cssadmin/css/font-awesome/css/font-awesome.min.css') }}">

    <!-- Datatable -->
    <link href="{{ asset('cssadmin/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('cssadmin/bower_components/datatables/jquery.dataTables.min.js') }}"></script>

    <!--Nice scroll JavaScript -->
    <script src="{{ asset('cssadmin/js/jquery.nicescroll.js') }}"></script>

    <!-- Sweet Alerts -->
    <link href="{{ asset('cssadmin/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('cssadmin/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('cssadmin/bower_components/sweetalert/jquery.sweet-alert.custom.js') }}"></script>

    <!-- JQuery Grid -->
    <script type="text/javascript" src="{{ asset('cssadmin/plugins/appendgrid/jquery-ui-1.11.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cssadmin/plugins/appendgrid/jquery.appendGrid-1.6.3.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('cssadmin/plugins/appendgrid/jquery-ui.structure.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('cssadmin/plugins/appendgrid/jquery-ui.theme.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('cssadmin/plugins/appendgrid/jquery.appendGrid-1.6.3.css') }}"/>

    <!-- Colorbox -->
    <link href="{{ asset('cssadmin/plugins/colorbox/colorbox.css') }}" rel="stylesheet" />
    <script src="{{ asset('cssadmin/plugins/colorbox/jquery.colorbox.js') }}"></script>

    <!-- autocomplete -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- High Chart -->
    <script src="{{ asset('cssadmin/plugins/highchart/js/highcharts.js') }}"></script>
    <script src="{{ asset('cssadmin/plugins/highchart/js/modules/exporting.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('cssadmin/plugins/highchart/js/highcharts.css') }}" type="text/css"/>

    <!-- high chart -->
    <!-- <script src="{{ asset('cssadmin/plugins/highchart/js/highcharts.js') }}"></script> -->
    <!-- <script src="{{ asset('cssadmin/plugins/highchart/js/modules/exporting.js') }}"></script> -->

    <!--alerts CSS -->
    <!-- <link href="{{ asset('cssadmin/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css"> -->
    <!-- <script src="{{ asset('cssadmin/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script> -->
    <!-- <script src="{{ asset('cssadmin/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js') }}"></script> -->

    <style type="text/css">
    .disable
    {
        pointer-events: none;
    }

    table.dataTable thead th, table.dataTable thead td {
        padding: 10px ;
        border-bottom: 1px solid #111;
    }

    .gridtext
    {
        border: 0px solid rgba(0,0,0,.15);
    }

    /* width */
    ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #8e8e8e;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    </style>

    <script>

    function fNumber(iVal)
    {
        var iRes = numeral(iVal).format('0,0');
        return iRes;
    }

    function ufNumber(iVal)
    {
        var myNumeral2 = numeral(iVal);
        var iRes = parseInt(myNumeral2.value());
        return iRes;
    }

    function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        }
        else
        {
            // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if( !regex.test(key) )
        {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    $(document).ready(function() {
        $('.datepicker').datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });
    });
    </script>

    @stack('scripts')
    @stack('stylecss')

</head>


<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>

<div id="wrapper">

    <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0">
        <div class="navbar-header"><a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
            <div class="top-left-part"><a class="logo" href="{{ url('admin/dashboard') }}"><i class="glyphicon glyphicon-fire"></i>&nbsp;<span class="hidden-xs">My Admin</span></a></div>
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="ti-menu icon-arrow-left-circle"></i></a></li>
                <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="{{ url('admin/profile') }}"><i class="icon-user"></i> {{ session('username') }} ({{ session('akses') }})</a></li>
                <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" href="{{ url('admin/login/actlogout') }}"><i class="icon-logout"></i> Log Out</a></li>
            </ul>

            <ul class="nav navbar-top-links navbar-right pull-right">
                <li class="dropdown"> <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src='{{ asset("image/user.png") }}' alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ session('namaadmin') }}</b> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ url('admin/profile') }}"><i class="ti-user"></i> My Profile</a></li>
                        <li><a href="{{ url('admin/login/actlogout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="navbar-default sidebar nicescroll" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                        </span>
                    </div>
                </li>
                <li class="nav-small-cap">Admin Menu</li>
                <li><a href="{{ url('admin/dashboard') }}" class="waves-effect"><i class="fa fa-home fa-fw"></i> Dashboard</a></li>
                <li><a href="{{ url('admin/profile') }}" class="waves-effect"><i class="fa fa-user fa-fw"></i> Profile</a></li>

                @if(session('akses') == 'ADMIN')

                <li class="nav-small-cap">Master</li>
                <li><a href="{{ url('admin/admin/list') }}"><i class="fa fa-users fa-fw"></i> Staff</a></li>
                <li><a href="{{ url('admin/kategori/list') }}"><i class="fa fa-tag fa-fw"></i> Kategori</a></li>
                <li><a href="{{ url('admin/ruangan/list') }}"><i class="fa fa-building fa-fw"></i> Ruangan</a></li>
                <li><a href="{{ url('admin/barang/list') }}"><i class="fa fa-cube fa-fw"></i> Barang</a></li>

                @endif

                <li class="nav-small-cap">Inventaris</li>
                <li><a href="{{ url('admin/inventaris/list') }}" class="waves-effect"><i class="fa fa-inbox fa-fw"></i> Inventaris</a></li>

                <li class="nav-small-cap">Laporan</li>
                <li><a href="{{ url('admin/laporan/order') }}" class="waves-effect"><i class="fa fa-book fa-fw"></i> Laporan Inventaris</a></li>
                <li><a href="#" class="waves-effect"></a></li>

            </ul>
        </div>
    </div>

    <div id="page-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

</div>

</html>
