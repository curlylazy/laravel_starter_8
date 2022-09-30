@extends('admin/template')

@push('scripts')
    <script type="text/javascript">
		$(document).ready(function() {

            $("#gambarview_boat_1").attr("src", "{{ url('gambar/noimage.jpg') }}");
            $("#gambarview_boat_2").attr("src", "{{ url('gambar/noimage.jpg') }}");
            $("#gambarview_boat_3").attr("src", "{{ url('gambar/noimage.jpg') }}");
            $("#gambarview_boat_4").attr("src", "{{ url('gambar/noimage.jpg') }}");

			// DATA EDIT
			@if($aksi == "actedit")

				@php
					$mode = "UPDATE";
					$keteranganboat = $rows->keteranganboat;
				@endphp

                @if($rows->gambarboat_1  != "")
                    $("#gambarview_boat_1").attr("src", '{{ url("gambar/$rows->gambarboat_1") }}');
                @endif

                @if($rows->gambarboat_2  != "")
                    $("#gambarview_boat_2").attr("src", '{{ url("gambar/$rows->gambarboat_2") }}');
                @endif

                @if($rows->gambarboat_3  != "")
                    $("#gambarview_boat_3").attr("src", '{{ url("gambar/$rows->gambarboat_3") }}');
                @endif

                @if($rows->gambarboat_4  != "")
                    $("#gambarview_boat_4").attr("src", '{{ url("gambar/$rows->gambarboat_4") }}');
                @endif

                $("#kodeboat").val("{{ $rows->kodeboat }}");
                $("#kodejenis").val("{{ $rows->kodejenis }}");
                $("#kodeowner").val("{{ $rows->kodeowner }}");
                $("#hargaboat").val("{{ $rows->hargaboat }}");
                $("#keteranganboat").val("{{ $rows->keteranganboat }}");

			// DATA BARU
			@elseif($aksi == "acttambah")

				@php
					$mode = "ADD";
                    $keteranganboat = "";
				@endphp

			@endif

			// =========== jika ada error
			@if(session('erroract'))

                $("#kodeboat").val("{{ old('kodeboat') }}");
                $("#kodejenis").val("{{ old('kodejenis') }}");
                $("#kodeowner").val("{{ old('kodeowner') }}");
                $("#hargaboat").val("{{ old('hargaboat') }}");
                $("#keteranganboat").val("{{ old('keteranganboat') }}");

			@endif

			// ========== initialize button
			$("#pesanwarning").addClass("hidden");
			$("#isipesanwarning").html("");

			$("#simpan").click(function() {

                 // jika data kosong
				var kodeowner = $("#kodeowner").val();
				var kodejenis = $("#kodejenis").val();
                var hargaboat = $("#hargaboat").val();

				if(kodeowner == "")
                {
                    swal("PERINGATAN", "nama [kodeowner] kosong", "warning");
                }
                else if(kodejenis == "")
				{
					swal("PERINGATAN", "nama [kodejenis] kosong", "warning");
                }
                else if(hargaboat == "")
				{
					swal("PERINGATAN", "nama [hargaboat] kosong", "warning");
                }
				else
				{
					$("#form1").submit();
				}
			});

            $('.decnumber').autoNumeric('init', {decimalPlacesOverride: '0'});
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


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="text-transform: uppercase; letter-spacing: 3px;">{{ $pagename }}</div>
            <div class="card-body">

                <form id="form1" enctype="multipart/form-data" method="post" action='{{ url("admin/master/$prefix/$aksi") }}' id="form1" >

                @csrf

                <div class="form-group">
                    <label for="kodeboat">Kode Boat</label>
                    <input class="form-control readonly" id="kodeboat" name="kodeboat" type="text" placeholder="AUTO">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="kodeowner">Owner</label>
                        <select id="kodeowner" name="kodeowner" class="form-control">
                            {!! App\Lib\Csql::DropDown("kodeowner", "namaowner", "tbl_owner") !!}
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="kodeowner">Jenis Boat</label>
                        <select id="kodejenis" name="kodejenis" class="form-control">
                            {!! App\Lib\Csql::DropDown("kodejenis", "namajenis", "tbl_jenis") !!}
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <!-- <div class="form-group col-md-6">
                        <label for="namaboat">Nama Boat</label>
                        <input type="text" class="form-control" id="namaboat" name="namaboat" placeholder="masukkan data">
                    </div> -->

                    <div class="form-group col-md-12">
                        <label for="hargaboat">Harga Boat</label>
                        <input class="form-control decnumber" id="hargaboat" name="hargaboat" type="text" placeholder="masukkan data">
                    </div>
                </div>

                <div class="form-group">
                    <label for="keteranganboat">Keterangan</label>
                    <textarea class="form-control" id="keteranganboat" name="keteranganboat" rows="10">{{ $keteranganboat }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <img id="gambarview_boat_1" style="width: 100%; height: 200px; object-fit: cover;" />
                        <input type="file" id="gambarboat_1" name="gambarboat_1" />
                    </div>

                    <div class="form-group col-md-3">
                        <img id="gambarview_boat_2" style="width: 100%; height: 200px; object-fit: cover;" />
                        <input type="file" id="gambarboat_2" name="gambarboat_2" />
                    </div>

                    <div class="form-group col-md-3">
                        <img id="gambarview_boat_3" style="width: 100%; height: 200px; object-fit: cover;" />
                        <input type="file" id="gambarboat_3" name="gambarboat_3" />
                    </div>

                    <div class="form-group col-md-3">
                        <img id="gambarview_boat_4" style="width: 100%; height: 200px; object-fit: cover;" />
                        <input type="file" id="gambarboat_4" name="gambarboat_4" />
                    </div>
                </div>

                </form>

            </div>
            <div class="card-footer">
                <a class="btn btn-primary" href='{{ url("admin/master/$prefix/list") }}'><i class="fa fa-backward"></i> KEMBALI</a>
                <button type="button" id="simpan" class="btn btn-info"><i class="fa fa-save"></i> SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">{{ $mode .' '.$pagename }}</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form id="form1" enctype="multipart/form-data" method="post" action='{{ url("admin/master/$prefix/$aksi") }}' id="form1" >

                    	@csrf

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Bank</label>
                                        <input type="text" id="nama_bank" name="nama_bank" class="form-control" placeholder="masukkan nama bank">
                                        <input type="text" id="id_bank" name="id_bank" class="hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <a class="btn btn-default btn-flat" href='{{ url("admin/$prefix/list") }}'><i class="fa fa-backward"></i> KEMBALI</a>
                            <button type="button" id="simpan" class="btn btn-success"><i class="fa fa-check"></i> SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

@endsection
