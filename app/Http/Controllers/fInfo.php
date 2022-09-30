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

use App\Http\Controllers\fInfo;
use App\Http\Controllers\fDashboard;

class fInfo extends Controller
{
	public function __construct()
    {
    	$this->prefix = "info";
    	$this->pagename = "Info";
    }

    public function info(Request $request)
    {
    	if(empty(session('pesaninfo')))
    	{
    		return redirect()->action([fDashboard::class, 'index']);
    	}

        return view("front/$this->prefix/info");
    }

}
?>
