@extends('front/template')

@push('scripts')

<script type="text/javascript">

$(document).ready(function() {
    
});

</script>

@endpush

@push('stylecss')

<style>
.parallax 
{
    /* The image used */
    /*background-image: url("{{ asset('cssfront/img/bg3.jpg') }}"), linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5));*/

    background: 
    linear-gradient( rgb(0 0 0 / 45%), rgb(0 0 0 / 45%) ),
    url("{{ asset('cssfront/img/bg1.jpg') }}");

    /* Set a specific height */
    min-height: 200px; 
    margin-top: 20px;

    /* Create the parallax scrolling effect */
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;

    background-color: rgba(0,0,0,0.5);
    position: relative;
    text-align: center;

    color: white;
}


</style>

@endpush



@section('content')

<!-- Page Header -->
<header class="masthead" style="background-image: url('{{ asset('cssfront/img/bg3.jpg') }}')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <img src="{{ asset('cssfront/img/logo.png') }}" style="width: 200px;" />
                    <h1 style="font-size: 40pt;">Pengambengan Rent Boat</h1>
                    <span class="subheading">sewa online di <b>Pengambengan Boat</b></span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">

    @if(!empty(session('userpelanggan')))
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        Halo, <b>{{ session('namapelanggan') }}</b> anda sudah login.
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-user-friends fa-4x text-info"></i>
                    <h4 class="card-title mt-4 text-info">Daftar Gratis</h4>
                    <p class="card-text">registrasi gratis untuk bisa sewa boat online, mudah & cepat.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-ship fa-4x text-info"></i>
                    <h4 class="card-title mt-4 text-info">Sewa Online</h4>
                    <p class="card-text">sewa berbagai jenis boat, pilih boat dan tanggal, selesai.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-history fa-4x text-info"></i>
                    <h4 class="card-title mt-4 text-info">Transaksi</h4>
                    <p class="card-text">anda bisa cek history transaksi, melalui website kami.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="parallax">
    <h2 style="padding-top: 80px;">Sewa Boat di Pengambengan</h2>
    <p style="margin: 0px 0 !important;">Lebih Mudah, Cepat, Murah dan Aman</p>
</div>

<div class="row mt-2 mb-2">
     @foreach ($rows as $row)    

        @if(!empty($row->gambarboat_1))
            <div class="col-md-3">
                <img src='{{ url("gambar/$row->gambarboat_1") }}' alt="..." class="img-thumbnail">
            </div>
        @endif

        @if(!empty($row->gambarboat_2))
            <div class="col-md-3">
                <img src='{{ url("gambar/$row->gambarboat_2") }}' alt="..." class="img-thumbnail">
            </div>
        @endif

        @if(!empty($row->gambarboat_3))
            <div class="col-md-3">
                <img src='{{ url("gambar/$row->gambarboat_3") }}' alt="..." class="img-thumbnail">
            </div>
        @endif

        @if(!empty($row->gambarboat_4))
            <div class="col-md-3">
                <img src='{{ url("gambar/$row->gambarboat_4") }}' alt="..." class="img-thumbnail">
            </div>
        @endif

    @endforeach
</div>

@endsection

