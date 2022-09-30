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
                $("#kodeuser").val("{{ $rows->kodeuser }}");
                $("#username").val("{{ $rows->username }}");
                $("#username_old").val("{{ $rows->username }}");
                $("#namauser").val("{{ $rows->namauser }}");
                $("#password").val("{{ $password }}");
                $("#akses").val("{{ $rows->akses }}");

			// DATA BARU
			@elseif($aksi == "acttambah")

				@php
					$mode = "ADD";
				@endphp

			@endif

			// =========== jika ada error
			@if(session('erroract'))
				$("#kodeuser").val("{{ old('kodeuser') }}");
                $("#username").val("{{ old('username') }}");
                $("#namauser").val("{{ old('namauser') }}");
                $("#password").val("{{ old('password') }}");
                $("#akses").val("{{ old('akses') }}");
			@endif

			// ========== initialize button
			$("#pesanwarning").addClass("hidden");
			$("#isipesanwarning").html("");

			$("#simpan").click(function() {

                 // jika data kosong
				var namauser = $("#namauser").val();
				var username = $("#username").val();
				var password = $("#password").val();

				if(username == "")
				{
					swal("PERINGATAN", "nama [username] kosong", "warning");
                }
                else if(namauser == "")
				{
					swal("PERINGATAN", "nama [namauser] kosong", "warning");
                }
                else if(password == "")
				{
					swal("PERINGATAN", "nama [password] kosong", "warning");
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

                <input type="hidden" class="form-control" id="username_old" name="username_old" placeholder="masukkan data">

                <div class="form-group">
                    <label for="kodeuser">Kode User</label>
                    <input class="form-control readonly" id="kodeuser" name="kodeuser" type="text" placeholder="AUTO">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="masukkan data">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="masukkan data">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Nama User</label>
                    <input type="text" class="form-control" id="namauser" name="namauser" placeholder="masukkan data">
                </div>

                <div class="form-group">
                    <label for="akses">Akses</label>
                    <select id="akses" name="akses" class="form-control">
                        <option selected>Pilih...</option>
                        <option value="ADMIN">Admin</option>
                        <option value="STAFF">Staff</option>
                    </select>
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
