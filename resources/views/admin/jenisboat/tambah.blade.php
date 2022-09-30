@extends('admin/template')

@push('scripts')
    <script type="text/javascript">
		$(document).ready(function() {

			// DATA EDIT
			@if($aksi == "actedit")

				@php
					$mode = "UPDATE";
				@endphp

				// $("#useradmin").addClass("disable");
                $("#kodejenis").val("{{ $rows->kodejenis }}");
                $("#namajenis").val("{{ $rows->namajenis }}");

			// DATA BARU
			@elseif($aksi == "acttambah")

				@php
					$mode = "ADD";
				@endphp

			@endif

			// =========== jika ada error
			@if(session('pesaninfo'))
				$("#kodejenis").val("{{ old('kodejenis') }}");
                $("#namajenis").val("{{ old('namajenis') }}");
			@endif

			// ========== initialize button
			$("#pesanwarning").addClass("hidden");
			$("#isipesanwarning").html("");

			$("#simpan").click(function() {

                 // jika data kosong
				var namajenis = $("#namajenis").val();

				if(namajenis == "")
				{
					swal("PERINGATAN", "nama jenis masih kosong", "warning");
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


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="text-transform: uppercase; letter-spacing: 3px;">{{ $pagename }}</div>
            <div class="card-body">

                <form id="form1" enctype="multipart/form-data" method="post" action='{{ url("admin/master/$prefix/$aksi") }}' id="form1" >

                @csrf

                <div class="form-group">
                    <label for="kodejenis">Kode Jenis</label>
                    <input class="form-control readonly" id="kodejenis" name="kodejenis" type="text" placeholder="AUTO">
                </div>

                <div class="form-group">
                    <label for="kodejenis">Nama Jenis</label>
                    <input class="form-control" id="namajenis" name="namajenis" type="text" placeholder="masukkan data..">
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
