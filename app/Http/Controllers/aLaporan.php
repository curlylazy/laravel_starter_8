<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

// load library
use App\Lib\Csql;
use App\Lib\Cupload;
use App\Lib\Cfilter;
use App\Lib\Cview;

use App\Http\Controllers\aBoat;

use PDF;

class aLaporan extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_booking";
    	$this->prefix = "laporan";
    	$this->pagename = "Laporan";
    }

    // ================= PELANGGAN ===================================
    public function pelanggan(Request $request)
    {

    	$katakunci = Cfilter::FilterString($request->input('katakunci'));

		$data['katakunci'] = $katakunci;

		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>$this->pagename</li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>List</li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = "Laporan Pelanggan";

		$this->baseTable = "tbl_pelanggan";

		// passing function ke view
		$rows = DB::table($this->baseTable)
		        ->select('*')
		        ->where('tbl_pelanggan.namapelanggan', 'like', "%$katakunci%")
		        ->get();

        $data['rows'] = $rows;

        return view("admin/$this->prefix/pelanggan", $data);
    }

    public function cetak_pelanggan(Request $request)
    {

    	$katakunci = Cfilter::FilterString($request->input('katakunci'));

    	$data['judul'] = "Laporan Pelanggan";

    	$data['keterangan'] = "";

    	if(!empty($katakunci))
    	{
    		$data['keterangan'] = "katakunci : $katakunci <br />";
    	}

    	$data['keterangan'] .= "laporan cetak pelanggan Pengambengan Boat.";

    	$this->baseTable = "tbl_pelanggan";

    	// passing function ke view
		$rows = DB::table($this->baseTable)
		        ->select('*')
		        ->where('tbl_pelanggan.namapelanggan', 'like', "%$katakunci%")
		        ->get();

        $data['rows'] = $rows;

    	$pdf = PDF::loadView('admin/laporan/cetak_pelanggan', $data)
               ->setPaper('a4', 'landscape');

		return $pdf->stream();
    }


    // ================= BOOKING ===================================
    public function booking(Request $request)
    {

    	$statusbooking = Cfilter::FilterString($request->input('statusbooking'));
    	$katakunci = Cfilter::FilterString($request->input('katakunci'));

    	$tglorder_dari = Cfilter::FilterString($request->input('tglorder_dari'));
		$tglorder_sampai = Cfilter::FilterString($request->input('tglorder_sampai'));

		if(empty($tglorder_dari))
		{
			$tglorder_dari = date("Y-m-01");
		}

		if(empty($tglorder_sampai))
		{
			$tglorder_sampai = date("Y-m-t");
		}

		$data['katakunci'] = $katakunci;
		$data['tglorder_sampai'] = $tglorder_sampai;
		$data['tglorder_dari'] = $tglorder_dari;

		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>$this->pagename</li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>List</li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = "Laporan Booking";

		$this->baseTable = "tbl_booking";

		// passing function ke view
		$rows = DB::table($this->baseTable)
		        ->select('*')
		        ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
		        ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
		        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
		        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
		        ->where('tbl_booking.statusbooking', '=', 2)
		        ->whereBetween('tbl_booking.tanggalbooking', [$tglorder_dari, $tglorder_sampai])
		        ->where(function($query) {
		        	global $katakunci;

	                $query->where('tbl_pelanggan.namapelanggan', 'like', "%$katakunci%")
	                      ->orWhere('tbl_pelanggan.kodepelanggan', 'like', "%$katakunci%");

	            })->get();

        $data['rows'] = $rows;

        return view("admin/$this->prefix/booking", $data);
    }

    public function cetak_booking(Request $request)
    {

    	$katakunci = Cfilter::FilterString($request->input('katakunci'));
		$tglorder_dari = Cfilter::FilterString($request->input('tglorder_dari'));
		$tglorder_sampai = Cfilter::FilterString($request->input('tglorder_sampai'));

    	$data['judul'] = "Laporan Booking Boat";

    	$data['keterangan'] = "";

    	if(!empty($katakunci))
    	{
    		$data['keterangan'] = "katakunci : $katakunci <br />";
    	}

    	$data['keterangan'] .= "tanggal order $tglorder_dari s/d $tglorder_sampai";

    	// passing function ke view
		$rows = DB::table($this->baseTable)
		        ->select('*')
		        ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
		        ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
		        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
		        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
		        ->where('tbl_booking.statusbooking', '=', 2)
		        ->whereBetween('tbl_booking.tanggalbooking', [$tglorder_dari, $tglorder_sampai])
		        ->where(function($query) {
		        	global $katakunci;

	                $query->where('tbl_pelanggan.namapelanggan', 'like', "%$katakunci%")
	                      ->orWhere('tbl_pelanggan.kodepelanggan', 'like', "%$katakunci%");

	            })->get();

        $data['rows'] = $rows;

    	$pdf = PDF::loadView('admin/laporan/cetak_booking', $data)
               ->setPaper('a4', 'landscape');

		return $pdf->stream();
    }

}
?>
