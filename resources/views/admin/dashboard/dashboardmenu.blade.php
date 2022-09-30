@extends('admin/template')

@push('scripts')

<script type="text/javascript">

$(document).ready(function() {

});

</script>

@endpush

@section('breadcumb')
    <ol class="breadcrumb border-0 m-0">
        {!! $breadcrumb !!}
    </ol>
@endsection


@section('content')

<div class="row">
    <div class="col-6 col-lg-4">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary p-3 mfe-3">
                    <i class="fa fa-phone"></i>
                </div>
                <div>
                    <div class="text-value text-primary"><a href="{{ url('admin/transaksi/booking/konfirmasi') }}">KONFIRMASI</a></div>
                    <div class="text-muted text-uppercase font-weight-bold small">data konfirmasi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-4">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary p-3 mfe-3">
                    <i class="fa fa-list"></i>
                </div>
                <div>
                    <div class="text-value text-primary"><a href="{{ url('admin/transaksi/booking/list') }}">BOOKING</a></div>
                    <div class="text-muted text-uppercase font-weight-bold small">data booking</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-4">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary p-3 mfe-3">
                    <i class="fa fa-calendar"></i>
                </div>
                <div>
                    <div class="text-value text-primary"><a href="{{ url('admin/transaksi/booking/jadwal') }}">JADWAL BOOKING</a></div>
                    <div class="text-muted text-uppercase font-weight-bold small">jadwal booking</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-6">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary p-3 mfe-3">
                    <i class="fa fa-book"></i>
                </div>
                <div>
                    <div class="text-value text-primary"><a href="{{ url('admin/laporan/booking') }}">Laporan Booking Boat</a></div>
                    <div class="text-muted text-uppercase font-weight-bold small">data laporan booking boat</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-6">
        <div class="card">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-primary p-3 mfe-3">
                    <i class="fa fa-book"></i>
                </div>
                <div>
                    <div class="text-value text-primary"><a href="{{ url('admin/laporan/pelanggan') }}">Laporan Pelanggan</a></div>
                    <div class="text-muted text-uppercase font-weight-bold small">data laporan pelanggan</div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
