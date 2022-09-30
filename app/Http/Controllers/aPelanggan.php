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

use App\Http\Controllers\aPelanggan;

class aPelanggan extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_pelanggan";
    	$this->prefix = "pelanggan";
    	$this->pagename = "Pelanggan";

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
						->orderBy('tbl_pelanggan.kodepelanggan', 'desc')
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
                        ->where('kodepelanggan', '=', $id)
                        ->first();

        $data['passwordpelanggan'] = Crypt::decryptString($data['rows']->passwordpelanggan);

        return view("admin/$this->prefix/tambah", $data);
    }

    public function acttambah(Request $request)
    {

		// pass request
		$data['request'] = $request;

		DB::beginTransaction();

		try
		{
            $userpelanggan = Cfilter::FilterString($request->input('userpelanggan'));

            // cek apakah ada username yang sama
			$cekusername = Csql::cariData2("userpelanggan", "userpelanggan", $userpelanggan, $this->baseTable);
			if($cekusername != "")
			{
				$this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>username</b> sudah ada.");
				return redirect()->action([aPelanggan::class, 'tambah'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
            }

            $kodepelanggan = Csql::generateKode2("kodepelanggan", "PEL", $this->baseTable);

			// simpan ke table user_login
			DB::table($this->baseTable)->insert([[
                'kodepelanggan' => Cfilter::FilterString($kodepelanggan),
                'userpelanggan' => Cfilter::FilterString($request->input('userpelanggan')),
                'passwordpelanggan' => Crypt::encryptString($request->input('passwordpelanggan')),
                'namapelanggan' => Cfilter::FilterString($request->input('namapelanggan')),
                'emailpelanggan' => Cfilter::FilterString($request->input('emailpelanggan')),
                'alamatpelanggan' => Cfilter::FilterString($request->input('alamatpelanggan')),
                'noteleponpelanggan' => Cfilter::FilterString($request->input('noteleponpelanggan')),
                'dateaddpelanggan' => Cfilter::FilterString(date("Y-m-d H:i")),
                'dateupdpelanggan' => Cfilter::FilterString(date("Y-m-d H:i")),
			]]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aPelanggan::class, 'tambah'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Tambah Data : <b>".$request->input('namapelanggan')."</b>");
		return redirect()->action([aPelanggan::class, 'list'])->with('pesaninfo', $this->pesaninfo);

    }

    public function actedit(Request $request)
    {
        // Update Data

		DB::beginTransaction();

		try {

            $userpelanggan = Cfilter::FilterString($request->input('userpelanggan'));
			$userpelanggan_old = Cfilter::FilterString($request->input('userpelanggan_old'));

			if($userpelanggan != $userpelanggan_old)
			{
				// cek apakah ada userpelanggan yang sama
				$cekuserpelanggan = Csql::cariData2("userpelanggan", "userpelanggan", $userpelanggan, $this->baseTable);
				if($cekuserpelanggan != "")
				{
					$this->pesaninfo = Cview::pesanGagal("Kesalahan Edit Data : <b>userpelanggan</b> sudah ada.");
					return redirect()->action([aPelanggan::class, 'edit'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
				}
			}

            $id = Cfilter::FilterString($request->input('kodepelanggan'));

			// update user
			DB::table($this->baseTable)
	            ->where('kodepelanggan', "=", $id)
	            ->update
	            ([
		            'userpelanggan' => Cfilter::FilterString($request->input('userpelanggan')),
                    'passwordpelanggan' => Crypt::encryptString($request->input('passwordpelanggan')),
                    'namapelanggan' => Cfilter::FilterString($request->input('namapelanggan')),
                    'emailpelanggan' => Cfilter::FilterString($request->input('emailpelanggan')),
                    'alamatpelanggan' => Cfilter::FilterString($request->input('alamatpelanggan')),
                    'noteleponpelanggan' => Cfilter::FilterString($request->input('noteleponpelanggan')),
                    'dateupdpelanggan' => Cfilter::FilterString(date("Y-m-d H:i")),
	            ]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Update Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aPelanggan::class, 'edit'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Update Data : <b>".$request->input('namapelanggan')."</b>");
		return redirect()->action([aPelanggan::class, 'list'])->with('pesaninfo', $this->pesaninfo);

    }

    public function acthapus($id)
    {
		DB::beginTransaction();

        try
        {
            DB::table($this->baseTable)
                ->where('kodepelanggan', '=', $id)
                ->delete();

		    DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Hapus Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aPelanggan::class, 'list'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Hapus Data : <b>".$id."</b>");
		return redirect()->action([aPelanggan::class, 'list'])->with('pesaninfo', $this->pesaninfo);
    }

}
?>
