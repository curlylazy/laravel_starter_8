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
                $("#kodepelanggan").val("{{ $rows->kodepelanggan }}");
                $("#userpelanggan").val("{{ $rows->userpelanggan }}");
                $("#userpelanggan_old").val("{{ $rows->userpelanggan }}");
                $("#namapelanggan").val("{{ $rows->namapelanggan }}");
                $("#passwordpelanggan").val("{{ $passwordpelanggan }}");
                $("#emailpelanggan").val("{{ $rows->emailpelanggan }}");
                $("#alamatpelanggan").val("{{ $rows->alamatpelanggan }}");
                $("#noteleponpelanggan").val("{{ $rows->noteleponpelanggan }}");

			// DATA BARU
			@elseif($aksi == "acttambah")

				@php
					$mode = "ADD";
				@endphp

			@endif

			// =========== jika ada error
			@if(session('erroract'))
				$("#kodepelanggan").val("{{ old('kodepelanggan') }}");
                $("#userpelanggan").val("{{ old('userpelanggan') }}");
                $("#userpelanggan_old").val("{{ old('userpelanggan') }}");
                $("#namapelanggan").val("{{ old('namapelanggan') }}");
                $("#passwordpelanggan").val("{{ old('passwordpelanggan') }}");
                $("#emailpelanggan").val("{{ old('emailpelanggan') }}");
                $("#alamatpelanggan").val("{{ old('alamatpelanggan') }}");
                $("#noteleponpelanggan").val("{{ old('noteleponpelanggan') }}");
			@endif

			// ========== initialize button
			$("#pesanwarning").addClass("hidden");
			$("#isipesanwarning").html("");

			$("#simpan").click(function() {

                 // jika data kosong
				var namapelanggan = $("#namapelanggan").val();
				var userpelanggan = $("#userpelanggan").val();
				var passwordpelanggan = $("#passwordpelanggan").val();

				if(userpelanggan == "")
				{
					swal("PERINGATAN", "nama [userpelanggan] kosong", "warning");
                }
                else if(namapelanggan == "")
				{
					swal("PERINGATAN", "nama [namapelanggan] kosong", "warning");
                }
                else if(passwordpelanggan == "")
				{
					swal("PERINGATAN", "nama [passwordpelanggan] kosong", "warning");
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

                <input type="hidden" class="form-control" id="userpelanggan_old" name="userpelanggan_old" placeholder="masukkan data">

                <div class="form-group">
                    <label for="kodepelanggan">Kode Pelanggan</label>
                    <input class="form-control readonly" id="kodepelanggan" name="kodepelanggan" type="text" placeholder="AUTO">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="userpelanggan">Username</label>
                        <input type="text" class="form-control" id="userpelanggan" name="userpelanggan" placeholder="masukkan data">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="passwordpelanggan">Password</label>
                        <input type="text" class="form-control" id="passwordpelanggan" name="passwordpelanggan" placeholder="masukkan data">
                    </div>
                </div>

                <div class="form-group">
                    <label for="namapelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="namapelanggan" name="namapelanggan" placeholder="masukkan data">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="emailpelanggan">Email</label>
                        <input type="text" class="form-control" id="emailpelanggan" name="emailpelanggan" placeholder="masukkan data">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="noteleponpelanggan">No Telepon</label>
                        <input type="text" class="form-control" id="noteleponpelanggan" name="noteleponpelanggan" placeholder="masukkan data">
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamatpelanggan">Alamat Pelanggan</label>
                    <input type="text" class="form-control" id="alamatpelanggan" name="alamatpelanggan" placeholder="masukkan data">
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
