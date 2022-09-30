<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sewa Boat Online</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('cssfront/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('cssfront/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('cssfront/css/clean-blog.css') }}" rel="stylesheet">

    @stack('stylecss')

    <style>
        .readonly
        {
            pointer-events: none;
        }
    </style>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ url('dashboard') }}">Pengambengan Boat</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('boat/list') }}">Boat</a></li>

                    @if(session('userpelanggan') == '')
                        <li class="nav-item"><a class="nav-link" href="{{ url('auth/login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('auth/registrasi') }}">Registrasi</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ url('booking/list') }}">Booking</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('auth/profile') }}">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('auth/logout') }}">Logout</a></li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <hr>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                <ul class="list-inline text-center">
                    <li class="list-inline-item">
                        <a href="#">
                            <span class="fa-stack fa-lg">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <span class="fa-stack fa-lg">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <span class="fa-stack fa-lg">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </li>
                </ul>
                <p class="copyright text-muted">Copyright &copy; Egik Stikom 2020</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('cssfront/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('cssfront/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('cssfront/js/clean-blog.min.js') }}"></script>

    <!--alerts CSS -->
    <link href="{{ asset('cssadmin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('cssadmin/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('cssadmin/plugins/sweetalert/jquery.sweet-alert.custom.js') }}"></script>

    <!-- Date Picker -->
    <link href="{{ asset('cssadmin/plugins/datepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('cssadmin/plugins/datepicker/jquery.datetimepicker.full.js') }}"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    

    <!-- TODO: Add SDKs for Firebase products that you want to use
         https://firebase.google.com/docs/web/setup#available-libraries -->
    
    
    @stack('scripts')


</body>

</html>
