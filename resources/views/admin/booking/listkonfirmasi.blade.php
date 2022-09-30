@extends('admin/template')

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
        	$('#myTable').DataTable({"ordering": false});
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
		<div class="col-12 col-md-12">
		    {!! session('pesaninfo') !!}
		</div>
	</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="text-transform: uppercase; letter-spacing: 3px;">{{ $pagename }}</div>
            <div class="card-body">
                <table class="table table-responsive-sm table-sm" id="myTable">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pelanggan</th>
                            <th>Boat</th>
                            <th>Tanggal Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)

                            <tr>
                                <td>{{ $row->kodebooking }}</td>
                                <td>({{ $row->userpelanggan }}) {{ $row->namapelanggan }}</td>
                                <td>{{ $row->kodeboat }}</td>
                                <td>{{ date('d F Y', strtotime($row->tanggalbooking)) }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href='{{ url("admin/transaksi/$prefix/konfirmasi/$row->kodebooking") }}'><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a class="btn btn-primary" href='{{ url("admin/dashboard") }}'><i class="fa fa-backward"></i> KEMBALI</a>
            </div>
        </div>
    </div>
</div>

@endsection
