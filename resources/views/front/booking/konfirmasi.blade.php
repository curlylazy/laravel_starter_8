@extends('front/template')

@push('scripts')

<script type="text/javascript">

$(document).ready(function() {
    
    $("#kodebooking").val("{{ $rows->kodebooking }}");

    @if(session('erroract'))
        $("#kodebooking").val("{{ old('kodebooking') }}");
        $("#bank").val("{{ old('bank') }}");
        $("#an").val("{{ old('an') }}");
        $("#norek").val("{{ old('norek') }}");
        $("#tanggalkonfirmasi").val("{{ old('tanggalkonfirmasi') }}");
    @endif

    $("#simpan").click(function() {

        // jika data kosong
        var bank = $("#bank").val();
        var an = $("#an").val();
        var norek = $("#norek").val();
        var tanggalkonfirmasi = $("#tanggalkonfirmasi").val();

        if(tanggalkonfirmasi == "")
        {
            swal("PERINGATAN", "[tanggalkonfirmasi] masih kosong", "warning");
        }
        else if(an == "")
        {
            swal("PERINGATAN", "[an] masih kosong", "warning");
        }
        else if(norek == "")
        {
            swal("PERINGATAN", "[norek] masih kosong", "warning");
        }
        else if(tanggalkonfirmasi == "")
        {
            swal("PERINGATAN", "[tanggalkonfirmasi] masih kosong", "warning");
        }
        else
        {
            $("#form1").submit();
        }
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
                    <h5 class="card-title text-info">{{ $rows->kodebooking }}</h5>
                    <p class="card-text mb-2" style="margin: 0px 0;">
                        Kode Boat : {{ $rows->kodeboat }}<br />
                        Tanggal Booking : {{ date("d F Y", strtotime($rows->tanggalbooking)) }}<br />
                        Status : {{ App\Lib\Csql::cekStatusBooking($rows->statusbooking) }}<br />

                        <hr />
                        Email Pelanggan : {{ $rows->emailpelanggan }} <br />
                        Nama Pelanggan : {{ $rows->namapelanggan }} <br />
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <p>
                        Untuk pengiriman transfer booking silahkan transfer ke rekening <br />
                        <b>BNI - REK.995889499303948 - A.N: Pengambengan Boat</b>
                    </p>

                    <form id="form1" method="post" action='{{ url("booking/actkonfirmasi") }}' enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" class="form-control" id="kodebooking" name="kodebooking" placeholder="masukkan atas nama pemilik rekening">

                        <div class="row">
                            <div class="col">
                                <label for="bank">Bank</label>
                                <select class="form-control" id="bank" name="bank">
                                    <option value="">pilih bank..</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BCA">BCA</option>
                                    <option value="MANDIRI">MANDIRI</option>
                                    <option value="BPD">BPD</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BTN">BTN</option>
                                    <option value="CIMB NIAGA">CIMB NIAGA</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="an">Atas Nama</label>
                                <input type="text" class="form-control" id="an" name="an" placeholder="masukkan atas nama pemilik rekening">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="norek">No Rekening</label>
                                <input type="text" class="form-control" id="norek" name="norek" placeholder="masukkan atas no rekening">
                            </div>
                            <div class="col">
                                <label for="tanggalkonfirmasi">Tanggal Konfirmasi</label>
                                <input type="text" class="form-control datepicker" id="tanggalkonfirmasi" name="tanggalkonfirmasi" placeholder="masukkan atas no rekening">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="gambarbukti">Gambar Bukti Transfer</label>
                                <input type="file" class="form-control" id="gambarbukti" name="gambarbukti" placeholder="masukkan atas no rekening">
                            </div>
                        </div>

                        <button type="button" id="simpan" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Submit</button>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
