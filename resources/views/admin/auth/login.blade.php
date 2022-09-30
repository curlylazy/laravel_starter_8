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


    </head>

    <body class="c-app flex-row align-items-center">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group">
                        <div class="card p-4">
                            <div class="card-body">

                                <form id="form1" enctype="multipart/form-data" method="post" action='{{ url("admin/auth/actlogin") }}' id="form1" >
                                
                                @csrf

                                <h1>Login</h1>
                                <p class="text-muted">Sign In to your account</p>

                                @if (session('pesaninfo'))
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!! session('pesaninfo') !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('cssadmin/vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Username" name="username">
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="{{ asset('cssadmin/vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    <input class="form-control" type="password" placeholder="Password" name="password">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary px-4" type="submit">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                            <div class="card-body text-center">
                                <div>
                                    <img src="{{ asset('cssfront/img/logo.png') }}" style="width: 100px;" />
                                    <h2>Admin Sewa Boat</h2>
                                    <p>silahkan login kedalam sistem menggunakan akun login anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>
