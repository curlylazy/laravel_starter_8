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

class aDashboard extends Controller
{
	public function __construct()
    {
        $this->middleware('ceklogin');
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

		// jumlah data
		// $data['jml_order'] = DB::table('tbl_order')
		// 					 ->whereIn('tbl_order.statusorder', [1, 3, 4, 5, 6])
		// 					 ->count();

		// $data['jml_pengepul'] = DB::table('tbl_pengepul')
		// 						->where('tbl_pengepul.statuspengepul', '=', 1)
		// 					 	->count();

		// $data['jml_brand'] = DB::table('tbl_brand')
		// 					 ->where('tbl_brand.statusbrand', '=', 1)
		// 					 ->count();

		// $data['jml_user'] = DB::table('tbl_admin')
		// 					->where('tbl_admin.statusadmin', '=', 1)
		// 					->count();

        return view('admin/dashboard/dashboardmenu', $data);
    }
}
?>
