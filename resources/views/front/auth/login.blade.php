@extends('front/template')

@push('scripts')

<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
<script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    
    var firebaseConfig = {
        apiKey: "AIzaSyC_HOQxLwWPDTHEiV4VpmEWHhIPJOOK-bg",
        authDomain: "fireauth-d58a0.firebaseapp.com",
        projectId: "fireauth-d58a0",
        storageBucket: "fireauth-d58a0.appspot.com",
        messagingSenderId: "842266051413",
        appId: "1:842266051413:web:4b5b1211a3422bce0425dc",
        measurementId: "G-WFPFZE29V4"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
</script>

<script type="text/javascript">



$(document).ready(function() {

    $("#btn_google_signin").click(function() {
        
        var provider = new firebase.auth.GoogleAuthProvider();

        firebase.auth()
        .signInWithPopup(provider)
        .then((result) => {
            /** @type {firebase.auth.OAuthCredential} */
            var credential = result.credential;

            // This gives you a Google Access Token. You can use it to access the Google API.
            var token = credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            // ...
            console.log("sukses", user);
        }).catch((error) => {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;
            // ...

            console.log("error", error);
        });
    });

    $("#btn_facebook_signin").click(function() {
        
        var provider = new firebase.auth.FacebookAuthProvider();

        firebase.auth()
        .signInWithPopup(provider)
        .then((result) => {
            /** @type {firebase.auth.OAuthCredential} */
            var credential = result.credential;

            // This gives you a Google Access Token. You can use it to access the Google API.
            var token = credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            // ...
            console.log("sukses", user);
        }).catch((error) => {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;
            // ...

            console.log("error", error);
        });
    });

});

</script>

@endpush


@section('content')

<!-- Page Header -->
<header class="masthead" style="background-image: url('{{ asset('cssfront/img/bg3.jpg') }}'); height: 250px;">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading" style="padding-top: 100px;">
                    <h1 style="font-size: 40pt;">Login</h1>
                    <span class="subheading">silahkan masukkan username dan password anda.</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">

    @if(session('erroract'))
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                {!! session('pesaninfo') !!}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <form id="form1" method="post" action='{{ url("auth/actlogin") }}'>

                @csrf

                <div class="form-group">
                    <label for="userpelanggan">Username</label>
                    <input type="text" class="form-control" id="userpelanggan" name="userpelanggan" placeholder="masukkan user pelanggan">
                </div>

                <div class="form-group">
                    <label for="userpelanggan">Password</label>
                    <input type="text" class="form-control" id="passwordpelanggan" name="passwordpelanggan" placeholder="masukkan password">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login</button>
                <!-- <button type="button" id="btn_google_signin" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Google Sign In</button> -->
                <!-- <button type="button" id="btn_facebook_signin" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Facebook Sign In</button> -->
                <a href="{{ url('auth/registrasi') }}" class="btn btn-primary"><i class="fas fa-user"></i> Registrasi</a>
            </form>
        </div>
    </div>
</div>

@endsection
