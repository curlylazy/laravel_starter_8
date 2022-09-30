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

use App\Http\Controllers\fBoat;

class fBoat extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_boat";
    	$this->prefix = "boat";
    	$this->pagename = "Boat";
    }

    public function list(Request $request)
    {
		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = $this->pagename;

		// passing function ke view
		$data['rows'] = DB::table($this->baseTable)
                        ->select('*')
                        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
                        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
						->orderBy('tbl_boat.kodeboat', 'desc')
						->get();

        return view("front/$this->prefix/list", $data);
    }

    public function detail($id)
    {

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = $this->pagename;

		// paramerter error
		$data['pesaninfo'] = "";
		$data['iserror'] = false;

        $data['rows'] = DB::table($this->baseTable)
        				->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
                        ->where('tbl_boat.kodeboat', '=', $id)
                        ->first();

        return view("front/$this->prefix/detail", $data);
    }

   
}
?>
