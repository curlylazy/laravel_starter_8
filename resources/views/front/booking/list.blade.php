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

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ $row->kodebooking }}</h5>
                    <p class="card-text mb-2" style="margin: 0px 0;">
                        Kode Boat : {{ $row->kodeboat }}<br />
                        Tanggal Booking : {{ date("d F Y", strtotime($row->tanggalbooking)) }}<br />
                        Status : {{ App\Lib\Csql::cekStatusBooking($row->statusbooking) }}<br />
                    </p>

                    @if($row->statusbooking === 0)
                        <a href='{{ url("booking/konfirmasi/$row->kodebooking") }}' class="btn btn-primary"><i class="fas fa-money-check"></i> Konfirmasi</a>
                    @elseif($row->statusbooking === 10)
                        <a href='{{ url("booking/konfirmasi/$row->kodebooking") }}' class="btn btn-primary"><i class="fas fa-refresh"></i> Konfirmasi Ulang</a>
                    @endif

                    <a href='{{ url("booking/detail/$row->kodebooking") }}' class="btn btn-primary"><i class="fas fa-list"></i> Detail</a>
                    
                </div>
            </div>
        </div>

        @endforeach

    </div>
</div>

@endsection
