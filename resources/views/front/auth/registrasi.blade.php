@extends('front/template')

@push('scripts')

<script type="text/javascript">

$(document).ready(function() {

    @if(session('erroract'))
        $("#userpelanggan").val("{{ old('userpelanggan') }}");
        $("#namapelanggan").val("{{ old('namapelanggan') }}");
        $("#passwordpelanggan").val("{{ old('passwordpelanggan') }}");
        $("#emailpelanggan").val("{{ old('emailpelanggan') }}");
        $("#alamatpelanggan").val("{{ old('alamatpelanggan') }}");
        $("#noteleponpelanggan").val("{{ old('noteleponpelanggan') }}");
    @endif

    $("#simpan").click(function() {

        // jika data kosong
        var namapelanggan = $("#namapelanggan").val();
        var userpelanggan = $("#userpelanggan").val();
        var passwordpelanggan = $("#passwordpelanggan").val();

        if(userpelanggan == "")
        {
            swal("PERINGATAN", "nama [userpelanggan] kosong", "warning");
        }
        else if(namapelanggan == "")
        {
            swal("PERINGATAN", "nama [namapelanggan] kosong", "warning");
        }
        else if(passwordpelanggan == "")
        {
            swal("PERINGATAN", "nama [passwordpelanggan] kosong", "warning");
        }
        else
        {
            $("#form1").submit();
        }
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
                    <h1 style="font-size: 40pt;">Registrasi</h1>
                    <span class="subheading">silahkan lengkapi data anda.</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            @if(session('erroract'))
                {!! session('pesaninfo') !!}
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <form id="form1" method="post" action='{{ url("auth/actregistrasi") }}'>

                @csrf

                <div class="row">
                    <div class="col">
                        <label for="userpelanggan">Username</label>
                        <input type="text" class="form-control" id="userpelanggan" name="userpelanggan" placeholder="masukkan user pelanggan">
                    </div>
                    <div class="col">
                        <label for="passwordpelanggan">Password</label>
                        <input type="text" class="form-control" id="passwordpelanggan" name="passwordpelanggan" placeholder="masukkan password">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="namapelanggan">Nama</label>
                    <input type="text" class="form-control" id="namapelanggan" name="namapelanggan" placeholder="masukkan nama">
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <label for="emailpelanggan">Email</label>
                        <input type="text" class="form-control" id="emailpelanggan" name="emailpelanggan" placeholder="masukkan email">
                    </div>
                    <div class="col">
                        <label for="alamatpelanggan">Alamat</label>
                        <input type="text" class="form-control" id="alamatpelanggan" name="alamatpelanggan" placeholder="masukkan alamat">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="noteleponpelanggan">No Telepon</label>
                    <input type="text" class="form-control" id="noteleponpelanggan" name="noteleponpelanggan" placeholder="masukkan no telepon">
                </div>

                <button type="button" id="simpan" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
