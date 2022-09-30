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

use App\Http\Controllers\aUser;

class aUser extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_user";
    	$this->prefix = "user";
    	$this->pagename = "User";

    	// cek apakah sudah login atau belum
    	$this->middleware('ceklogin');
    }

    public function list(Request $request)
    {
		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>$this->pagename</li>";
		$breadcrumb []= "<li class='breadcrumb-item active'>List</li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = $this->pagename;

		// passing function ke view
		$data['rows'] = DB::table($this->baseTable)
                        ->select('*')
						->orderBy('tbl_user.kodeuser', 'desc')
						->get();

        return view("admin/$this->prefix/list", $data);
    }

	public function tambah()
    {
		// breadcrumb
		$breadcrumb = array();
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/dashboard")."'>Dashboard</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item'><a href='".url("admin/master/$this->prefix/list")."'>$this->pagename</a></li>";
		$breadcrumb []= "<li class='breadcrumb-item'>Tambah</li>";
		$data['breadcrumb'] = join($breadcrumb, "");

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = "Tambah ". $this->pagename;
		$data['aksi'] = "acttambah";

		// paramerter error
		$data['pesaninfo'] = "";
		$data['iserror'] = false;

        return view("admin/$this->prefix/tambah", $data);
    }

    public function edit($id)
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
		$data['aksi'] = "actedit";

		// paramerter error
		$data['pesaninfo'] = "";
		$data['iserror'] = false;

        $data['rows'] = DB::table($this->baseTable)
                        ->where('kodeuser', '=', $id)
                        ->first();

        $data['password'] = Crypt::decryptString($data['rows']->password);

        return view("admin/$this->prefix/tambah", $data);
    }

    public function acttambah(Request $request)
    {

		// pass request
		$data['request'] = $request;

		DB::beginTransaction();

		try
		{

            // $kodeuser = Csql::generateKode("USR", $this->baseTable);
			$username = Cfilter::FilterString($request->input('username'));

			// cek apakah ada username yang sama
			$cekusername = Csql::cariData2("username", "username", $username, $this->baseTable);
			if($cekusername != "")
			{
				$this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>username</b> sudah ada.");
				return redirect()->action([aUser::class, 'tambah'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
			}

            $kodeuser = Csql::generateKode2("kodeuser", "USER", $this->baseTable);

			// simpan ke table user_login
			DB::table($this->baseTable)->insert([[
                'kodeuser' => Cfilter::FilterString($kodeuser),
                'username' => Cfilter::FilterString($request->input('username')),
                'namauser' => Cfilter::FilterString($request->input('namauser')),
                'akses' => Cfilter::FilterString($request->input('akses')),
                'password' => Crypt::encryptString($request->input('password')),
                'dateadduser' => Cfilter::FilterString(date("Y-m-d H:i")),
                'dateupduser' => Cfilter::FilterString(date("Y-m-d H:i")),
			]]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aUser::class, 'tambah'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Tambah Data : <b>".$request->input('namauser')."</b>");
		return redirect()->action([aUser::class, 'list'])->with('pesaninfo', $this->pesaninfo);

    }

    public function actedit(Request $request)
    {
        // Update Data

		DB::beginTransaction();

		try {

            $id = Cfilter::FilterString($request->input('kodeuser'));
            $username = Cfilter::FilterString($request->input('username'));
			$username_old = Cfilter::FilterString($request->input('username_old'));

			if($username != $username_old)
			{
				// cek apakah ada username yang sama
				$cekusername = Csql::cariData2("username", "username", $username, $this->baseTable);
				if($cekusername != "")
				{
					$this->pesaninfo = Cview::pesanGagal("Kesalahan Edit Data : <b>username</b> sudah ada.");
					return redirect()->action([aUser::class, 'edit'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
				}
			}

			// update user
			DB::table($this->baseTable)
	            ->where('kodeuser', "=", $id)
	            ->update
	            ([
		            'username' => Cfilter::FilterString($request->input('username')),
                    'namauser' => Cfilter::FilterString($request->input('namauser')),
                    'akses' => Cfilter::FilterString($request->input('akses')),
                    'password' => Crypt::encryptString($request->input('password')),
                    'dateupduser' => Cfilter::FilterString(date("Y-m-d H:i")),
	            ]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Update Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aUser::class, 'edit'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Update Data : <b>".$request->input('namauser')."</b>");
		return redirect()->action([aUser::class, 'list'])->with('pesaninfo', $this->pesaninfo);

    }

    public function acthapus($id)
    {
		DB::beginTransaction();

        try
        {
            DB::table($this->baseTable)
                ->where('kodeuser', '=', $id)
                ->delete();

		    DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Hapus Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aUser::class, 'list'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Hapus Data : <b>".$id."</b>");
		return redirect()->action([aUser::class, 'list'])->with('pesaninfo', $this->pesaninfo);
    }

}
?>
