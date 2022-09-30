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

class aBooking extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_booking";
    	$this->prefix = "booking";
    	$this->pagename = "Booking";

    	// cek apakah sudah login atau belum
    	$this->middleware('ceklogin');
    }

    public function list(Request $request)
    {

    	$statusbooking = Cfilter::FilterString($request->input('statusbooking'));

		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>$this->pagename</li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>List</li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = "Daftar Booking";

		// passing function ke view
		// $data['rows'] = DB::table($this->baseTable)
  //                       ->select('*')
  //                       ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
  //                       ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
  //                       ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
  //                       ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner');

		$sql = "SELECT * FROM tbl_booking
				INNER JOIN tbl_pelanggan ON (tbl_pelanggan.kodepelanggan = tbl_booking.kodepelanggan)
				INNER JOIN tbl_boat ON (tbl_boat.kodeboat = tbl_booking.kodeboat)
				INNER JOIN tbl_jenis ON (tbl_jenis.kodejenis = tbl_boat.kodejenis)
				WHERE TRUE 
				";

		if(!empty($statusbooking))
		{
			$sql .= " AND (tbl_booking.statusbooking = '".$statusbooking."') ";
		}

		$sql .= " ORDER BY tbl_booking.kodebooking DESC ";

        $data['rows'] = DB::select(DB::raw($sql));

        return view("admin/$this->prefix/list", $data);
    }

    public function listkonfirmasi(Request $request)
    {
		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>$this->pagename</li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>List</li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = "Konfirmasi Booking";

		// passing function ke view
		$data['rows'] = DB::table($this->baseTable)
                        ->select('*')
                        ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
                        ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
                        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
                        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
                        ->where('tbl_booking.statusbooking', '=', 1)
						->orderBy('tbl_booking.kodebooking', 'desc')
						->get();

        return view("admin/$this->prefix/listkonfirmasi", $data);
    }

    public function listjadwal(Request $request)
    {
		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>$this->pagename</li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>List</li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = "Jadwal Booking";

		// passing function ke view
		$data['rows'] = DB::table($this->baseTable)
                        ->select('*')
                        ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
                        ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
                        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
                        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
                        ->where('tbl_booking.statusbooking', '=', 2)
                        ->where('tbl_booking.tanggalbooking', '>=', date('Y-m-d'))
						->orderBy('tbl_booking.kodebooking', 'desc')
						->get();

        return view("admin/$this->prefix/listjadwal", $data);
    }

    public function detailbooking($id)
    {
		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'> Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/master/$this->prefix/list")."'>$this->pagename</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item'>Edit</li>";
		$breadcrumb []= "<li class='breadcrumb-item'><b>$id</b></li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = $this->pagename;
		$data['aksi'] = "";

		// paramerter error
		$data['pesaninfo'] = "";
		$data['iserror'] = false;

        $data['rows'] = DB::table($this->baseTable)
        				->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
                        ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
                        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
                        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
                        ->leftJoin('tbl_konfirmasi', 'tbl_konfirmasi.kodebooking', '=', 'tbl_booking.kodebooking')
                        ->where('tbl_booking.kodebooking', '=', $id)
                        ->first();

        return view("admin/$this->prefix/detailbooking", $data);
    }

    public function detailkonfirmasi($id)
    {
		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'> Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/master/$this->prefix/list")."'>$this->pagename</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item'>Edit</li>";
		$breadcrumb []= "<li class='breadcrumb-item'><b>$id</b></li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = $this->pagename;
		$data['aksi'] = "actkonfirmasi";

		$this->baseTable = "tbl_konfirmasi";

		// paramerter error
		$data['pesaninfo'] = "";
		$data['iserror'] = false;

        $data['rows'] = DB::table($this->baseTable)
        				->join('tbl_booking', 'tbl_booking.kodebooking', '=', 'tbl_konfirmasi.kodebooking')
        				->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
                        ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
                        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
                        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
                        ->where('tbl_konfirmasi.kodebooking', '=', $id)
                        ->first();

        return view("admin/$this->prefix/detailkonfirmasi", $data);
    }

    public function actkonfirmasi(Request $request)
    {
        // Update Data

		DB::beginTransaction();

		try {

            $id = Cfilter::FilterString($request->input('kodebooking'));

			// update user
			DB::table($this->baseTable)
	            ->where('kodebooking', "=", $id)
	            ->update
	            ([
		            'statusbooking' => Cfilter::FilterString($request->input('statusbooking')),
	            ]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Update Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aBooking::class, 'detailbooking'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Update Data : <b>".$request->input('kodebooking')."</b>");
		return redirect()->action([aBooking::class, 'listkonfirmasi'])->with('pesaninfo', $this->pesaninfo);

    }

    public function acthapus($id)
    {
		DB::beginTransaction();

        try
        {
            DB::table($this->baseTable)
                ->where('kodebooking', '=', $id)
                ->delete();

		    DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Hapus Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aBooking::class, 'list'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Hapus Data : <b>".$id."</b>");
		return redirect()->action([aBooking::class, 'list'])->with('pesaninfo', $this->pesaninfo);
    }

}
?>
