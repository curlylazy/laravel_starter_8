@extends('front/template')

@push('scripts')

<script type="text/javascript">

$(document).ready(function() {

    $("#kodeboat").val("{{ $rows->kodeboat }}");
    $("#harga").val("{{ $rows->hargaboat }}");

    $("#namapelanggan").val("{{ session('namapelanggan') }}");
    $("#emailpelanggan").val("{{ session('emailpelanggan') }}");

    $("#namapelanggan").addClass("disable");
    $("#emailpelanggan").addClass("disable");

    @if(session('erroract'))
        $("#kodeboat").val("{{ old('kodeboat') }}");
        $("#harga").val("{{ old('harga') }}");
        $("#tanggalbooking").val("{{ old('tanggalbooking') }}");
        $("#keteranganbooking").val("{{ old('keteranganbooking') }}");
    @endif

    $("#simpan").click(function() {

        // jika data kosong
        var tanggalbooking = $("#tanggalbooking").val();
        var emailpelanggan = $("#emailpelanggan").val();
        var namapelanggan = $("#namapelanggan").val();

        @if(empty(session('kodepelanggan')))
            if(emailpelanggan == "")
            {
                swal("PERINGATAN", "emailpelanggan masih kosong", "warning");
                return;
            }

            if(namapelanggan == "")
            {
                swal("PERINGATAN", "namapelanggan masih kosong", "warning");
                return;
            }
        @endif

        if(tanggalbooking == "")
        {
            swal("PERINGATAN", "tanggal booking masih kosong", "warning");
            return;
        }

        $("#form1").submit();

    });

    $('.datepicker').datetimepicker({
        timepicker: false,
        format: 'Y-m-d'
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
                    <h1 style="font-size: 40pt;">Detail Boat</h1>
                    <span class="subheading">detail boat dengan kode <b>{{ $rows->kodeboat }}</b>.</span>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mt-2 text-info">{{ $rows->kodeboat }}</h4>
                    <p style="font-size: 12pt;">{{ $rows->keteranganboat }}</p>
                    
                    <p class="card-text">
                        Rp. {{ number_format($rows->hargaboat) }} / Hari
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-3">
            <img src='{{ url("gambar/$rows->gambarboat_1") }}' alt="..." class="img-thumbnail">
        </div>
    </div>

    @if(!empty($rows->gambarboat_2))
        <div class="row mt-2 mb-2">
            <div class="col-md-3">
                <img src='{{ url("gambar/$rows->gambarboat_2") }}' alt="..." class="img-thumbnail">
            </div>
        </div>
    @endif

    @if(!empty($rows->gambarboat_3))
        <div class="row mt-2 mb-2">
            <div class="col-md-3">
                <img src='{{ url("gambar/$rows->gambarboat_3") }}' alt="..." class="img-thumbnail">
            </div>
        </div>
    @endif

    @if(!empty($rows->gambarboat_4))
        <div class="row mt-2 mb-2">
            <div class="col-md-3">
                <img src='{{ url("gambar/$rows->gambarboat_4") }}' alt="..." class="img-thumbnail">
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">

            <form method="post" id="form1" action='{{ url("booking/actbooking") }}' autocomplete="off">
            
            @csrf

            <input type="hidden" class="form-control" id="kodeboat" name="kodeboat" placeholder="masukkan tanggal booking">
            <input type="hidden" class="form-control" id="harga" name="harga" placeholder="masukkan tanggal booking">

            @if(empty(session('kodepelanggan')))
                
            @endif

            <div class="card mt-2">
                <div class="card-body">
                    @if(empty(session('kodepelanggan')))
                        <p style="font-size: 11pt;">NB : data anda akan langsung masuk ke dalam sistem, untuk booking selanjutnya silahkan melakukan login.</p>
                    @else
                        <p style="font-size: 11pt;">anda sudah melakukan login ke dalam sistem</p>
                    @endif
                    
                    <div class="row mt-3">
                        <div class="col">
                            <label for="emailpelanggan">Email</label>
                            <input type="email" class="form-control" id="emailpelanggan" name="emailpelanggan" placeholder="masukkan email">
                        </div>
                        <div class="col">
                            <label for="namapelanggan">Nama</label>
                            <input type="text" class="form-control" id="namapelanggan" name="namapelanggan" placeholder="masukkan nama anda">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for="tanggalbooking">Tanggal Booking</label>
                        <input type="text" class="form-control datepicker" id="tanggalbooking" name="tanggalbooking" placeholder="masukkan tanggal booking">
                    </div>

                    <div class="form-group mt-3">
                        <label for="userpelanggan">Keterangan Booking</label>
                        <input type="text" class="form-control" id="keteranganbooking" name="keteranganbooking" placeholder="masukkan catatan booking..">
                    </div>

                    <button type="button" id="simpan" class="btn btn-primary"><i class="fas fa-save"></i> Booking Sekarang</button>
                </div>
            </div>

            </form> 
        </div>

    </div>
</div>

@endsection
