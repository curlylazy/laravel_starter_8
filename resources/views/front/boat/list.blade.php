@extends('front/template')

@push('scripts')

<script type="text/javascript">

$(document).ready(function() {
    
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
                    <h1 style="font-size: 40pt;">Boat</h1>
                    <span class="subheading">daftar boat pantai Pengambengan.</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">

        @foreach ($rows as $row)

        <div class="col-md-4">
            <div class="card">
                <img class="card-img-top" src='{{ url("gambar/$row->gambarboat_1") }}' alt="Card image cap" style="height: 250px; width: 100%; object-fit: cover;">
                <div class="card-body text-center">
                    <h4 class="card-title mt-2 text-info">{{ $row->kodeboat }}</h4>
                    <p class="card-text">Rp. {{ number_format($row->hargaboat) }} / Hari</p>
                    <a href='{{ url("boat/detail/$row->kodeboat") }}' class="btn btn-primary"><i class="fas fa-book"></i> Selengkapnya..</a>
                </div>
            </div>
        </div>

        @endforeach

    </div>
</div>

@endsection
