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
                    <h1 style="font-size: 40pt;">Konfirmasi</h1>
                    <span class="subheading">silahkan konfirmasi booking anda.</span>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">

    @if(!empty(session('pesaninfo')))
        <div class="row">
            <div class="col-lg-12 col-md-12">
                {!! session('pesaninfo') !!}
            </div>
        </div>
    @endif

    <div class="row">

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ $rows_booking->kodebooking }}</h5>
                    <p class="card-text mb-2" style="margin: 0px 0;">
                        Kode Boat : {{ $rows_booking->kodeboat }}<br />
                        Tanggal Booking : {{ date("d F Y", strtotime($rows_booking->tanggalbooking)) }}<br />
                        Status : {{ App\Lib\Csql::cekStatusBooking($rows_booking->statusbooking) }}<br />
                    </p>
                </div>
            </div>
        </div>


        @if($rows_booking->statusbooking == '1' || $rows_booking->statusbooking == '2')
            <div class="col-md-12 mb-2">
                <div class="card">
                    <div class="card-body">
                        Bank : {{ $rows_konfirmasi->bank }}<br />
                        A.N : {{ $rows_konfirmasi->an }}<br />
                        No Rekening : {{ $rows_konfirmasi->norek }}<br />
                        Tanggal Konfirmasi : {{ date('d F Y', strtotime($rows_konfirmasi->tanggalkonfirmasi)) }}<br />

                        <img src='{{ url("gambar/$rows_konfirmasi->gambarbukti") }}' alt="{{ $rows_booking->kodebooking }}" class="img-thumbnail" style="width: 200px;">

                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection
