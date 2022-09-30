@extends('admin/template')

@push('scripts')
    <script type="text/javascript">
		$(document).ready(function() {

            $("#kodepelanggan").val("{{ $rows->kodepelanggan }}");
            $("#userpelanggan").val("{{ $rows->userpelanggan }}");
            $("#namapelanggan").val("{{ $rows->namapelanggan }}");
            $("#noteleponpelanggan").val("{{ $rows->noteleponpelanggan }}");

            $("#kodebooking").val("{{ $rows->kodebooking }}");
            $("#tanggalbooking").val("{{ $rows->tanggalbooking }}");
            $("#keteranganbooking").val("{{ $rows->keteranganbooking }}");
            $("#statusbooking").val("{{ $rows->statusbooking }}");

            $("#tanggalkonfirmasi").val("{{ $rows->tanggalkonfirmasi }}");
            $("#an").val("{{ $rows->an }}");
            $("#bank").val("{{ $rows->bank }}");
            $("#norek").val("{{ $rows->norek }}");

			// ========== initialize button
			$("#pesanwarning").addClass("hidden");
			$("#isipesanwarning").html("");

			$("#simpan").click(function() {

                 // jika data kosong
				var statusbooking = $("#statusbooking").val();

				if(statusbooking == "")
				{
					swal("PERINGATAN", "[statusbooking] masih kosong", "warning");
				}
				else
				{
					$("#form1").submit();
				}
			});
		});
    </script>

@endpush

@section('breadcumb')
    <ol class="breadcrumb border-0 m-0">
        {!! $breadcrumb !!}
    </ol>
@endsection

@section('content')

<!-- cek apakah informasi -->
@if (session('pesaninfo'))
	<div class="row">
		<div class="col-md-12">
		    {!! session('pesaninfo') !!}
		</div>
	</div>
@endif

<form id="form1" enctype="multipart/form-data" method="post" action='{{ url("admin/transaksi/$prefix/$aksi") }}' id="form1" >

@csrf

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="text-transform: uppercase; letter-spacing: 3px;">Data Pelanggan</div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="kodepelanggan">Kode Pelanggan</label>
                        <input class="form-control readonly" id="kodepelanggan" name="kodepelanggan" type="text" placeholder="AUTO">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="userpelanggan">User Pelanggan</label>
                        <input class="form-control readonly" id="userpelanggan" name="userpelanggan" type="text" placeholder="masukkan data">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="namapelanggan">Nama Pelanggan</label>
                        <input class="form-control readonly" id="namapelanggan" name="namapelanggan" type="text" placeholder="masukkan data">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header" style="text-transform: uppercase; letter-spacing: 3px;">Data Booking</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="kodebooking">Kode Booking</label>
                        <input class="form-control readonly" id="kodebooking" name="kodebooking" type="text" placeholder="AUTO">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tanggalbooking">Tanggal Booking</label>
                        <input class="form-control readonly" id="tanggalbooking" name="tanggalbooking" type="text" placeholder="masukkan data">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="keteranganbooking">Keterangan</label>
                        <input class="form-control readonly" id="keteranganbooking" name="keteranganbooking" type="text" placeholder="masukkan data">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($rows->kodekonfirmasi != "" || $rows->kodekonfirmasi != null)

    <div class="col-12">
        <div class="card">
            <div class="card-header" style="text-transform: uppercase; letter-spacing: 3px;">Data Konfirmasi</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="tanggalkonfirmasi">Tanggal Konfirmasi</label>
                        <input class="form-control readonly" id="tanggalkonfirmasi" name="tanggalkonfirmasi" type="text" placeholder="AUTO">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="bank">Bank</label>
                        <input class="form-control readonly" id="bank" name="bank" type="text" placeholder="masukkan data">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="norek">No Rekening</label>
                        <input class="form-control readonly" id="norek" name="norek" type="text" placeholder="masukkan data">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="an">Atas Nama</label>
                        <input class="form-control readonly" id="an" name="an" type="text" placeholder="masukkan data">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="an">Bukti</label><br />
                        <a href='{{ url("gambar/$rows->gambarbukti") }}'><img src='{{ url("gambar/$rows->gambarbukti") }}' style="width: 100px;" /></a>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="statusbooking">Status</label>
                        <select class="form-control" id="statusbooking" name="statusbooking">
                            <option value="">Pilih Status</option>
                            <option value="1">Menunggu Konfirmasi</option>
                            <option value="2">Valid</option>
                            <option value="10">Gagal / Dibatalkan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a class="btn btn-primary" href='{{ url("admin/transaksi/$prefix/konfirmasi") }}'><i class="fa fa-backward"></i> KEMBALI</a>
                <button type="button" id="simpan" class="btn btn-info"><i class="fa fa-save"></i> SIMPAN</button>
            </div>
        </div>
    </div>

    @endif
</div>

</form>
@endsection
