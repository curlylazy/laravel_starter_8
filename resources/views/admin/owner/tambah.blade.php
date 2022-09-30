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
                $("#kodeowner").val("{{ $rows->kodeowner }}");
                $("#namaowner").val("{{ $rows->namaowner }}");
                $("#emailowner").val("{{ $rows->emailowner }}");
                $("#alamatowner").val("{{ $rows->alamatowner }}");
                $("#noteleponowner").val("{{ $rows->noteleponowner }}");

			// DATA BARU
			@elseif($aksi == "acttambah")

				@php
					$mode = "ADD";
				@endphp

			@endif

			// =========== jika ada error
			@if(session('erroract'))
                $("#kodeowner").val("{{ old('kodeowner') }}");
                $("#namaowner").val("{{ old('namaowner') }}");
                $("#emailowner").val("{{ old('emailowner') }}");
                $("#alamatowner").val("{{ old('alamatowner') }}");
                $("#noteleponowner").val("{{ old('noteleponowner') }}");
			@endif

			// ========== initialize button
			$("#pesanwarning").addClass("hidden");
			$("#isipesanwarning").html("");

			$("#simpan").click(function() {

                 // jika data kosong
				var namaowner = $("#namaowner").val();
				var emailowner = $("#emailowner").val();

				if(namaowner == "")
				{
					swal("PERINGATAN", "nama [namaowner] kosong", "warning");
                }
                else if(emailowner == "")
				{
					swal("PERINGATAN", "nama [emailowner] kosong", "warning");
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
                    <label for="kodeowner">Kode User</label>
                    <input class="form-control readonly" id="kodeowner" name="kodeowner" type="text" placeholder="AUTO">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Nama</label>
                        <input type="text" class="form-control" id="namaowner" name="namaowner" placeholder="masukkan data">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Telepon</label>
                        <input type="text" class="form-control" id="noteleponowner" name="noteleponowner" placeholder="masukkan data">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Email</label>
                        <input type="text" class="form-control" id="emailowner" name="emailowner" placeholder="masukkan data">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Alamat</label>
                        <input type="text" class="form-control" id="alamatowner" name="alamatowner" placeholder="masukkan data">
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
