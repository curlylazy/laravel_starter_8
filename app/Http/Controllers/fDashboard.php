<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

// load library
use App\Lib\Csql;
use App\Lib\Cupload;
use App\Lib\Cfilter;
use App\Lib\Cview;

class fDashboard extends Controller
{
	public function __construct()
    {
        // $this->middleware('ceklogin');
    }

    public function index()
    {
		// nama title
    	$data['pagename'] = "Dashboard";

		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['headname'] = "Halaman Dashboard";
		$data['description'] = "berikut ini adalah halaman dashboard";

		$data['rows'] = DB::table('tbl_boat')
                        ->select('*')
						->orderBy('tbl_boat.kodeboat', 'desc')
						->get();

        return view('front/dashboard/dashboardmenu', $data);
    }
}
?>
