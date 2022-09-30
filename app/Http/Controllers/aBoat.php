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

class aBoat extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_boat";
    	$this->prefix = "boat";
    	$this->pagename = "Boat";

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
                        ->join('tbl_jenis', 'tbl_jenis.kodejenis', '=', 'tbl_boat.kodejenis')
                        ->join('tbl_owner', 'tbl_owner.kodeowner', '=', 'tbl_boat.kodeowner')
						->orderBy('tbl_boat.kodeboat', 'desc')
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
                        ->where('kodeboat', '=', $id)
                        ->first();

        return view("admin/$this->prefix/tambah", $data);
    }

    public function acttambah(Request $request)
    {

		// pass request
		$data['request'] = $request;

		DB::beginTransaction();

		try
		{

            $kodeboat = Csql::generateKode2("kodeboat", "BOAT", $this->baseTable);

            $gambarboat_1 = Cupload::UploadGambar('gambarboat_1', '', $request);
            $gambarboat_2 = Cupload::UploadGambar('gambarboat_2', '', $request);
            $gambarboat_3 = Cupload::UploadGambar('gambarboat_3', '', $request);
            $gambarboat_4 = Cupload::UploadGambar('gambarboat_4', '', $request);

			// simpan ke table user_login
			DB::table($this->baseTable)->insert([[
                'kodeboat' => Cfilter::FilterString($kodeboat),
                'kodeowner' => Cfilter::FilterString($request->input('kodeowner')),
                'kodejenis' => Cfilter::FilterString($request->input('kodejenis')),
                // 'kodeboat' => Cfilter::FilterString($request->input('kodeboat')),
                'keteranganboat' => Cfilter::FilterString($request->input('keteranganboat')),
                'hargaboat' => Cfilter::FilterInt($request->input('hargaboat')),
                'kapasitas' => Cfilter::FilterInt($request->input('kapasitas')),
                'gambarboat_1' => Cfilter::FilterString($gambarboat_1),
                'gambarboat_2' => Cfilter::FilterString($gambarboat_2),
                'gambarboat_3' => Cfilter::FilterString($gambarboat_3),
                'gambarboat_4' => Cfilter::FilterString($gambarboat_4),
                'dateaddboat' => Cfilter::FilterString(date("Y-m-d H:i")),
                'dateupdboat' => Cfilter::FilterString(date("Y-m-d H:i")),
			]]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aBoat::class, 'tambah'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Tambah Data : <b>".$kodeboat."</b>");
		return redirect()->action([aBoat::class, 'list'])->with('pesaninfo', $this->pesaninfo);

    }

    public function actedit(Request $request)
    {
        // Update Data

		DB::beginTransaction();

		try {

            $id = Cfilter::FilterString($request->input('kodeboat'));

            $gambarboat_1_old = Csql::cariData2("gambarboat_1", "kodeboat", $id, $this->baseTable);
            $gambarboat_2_old = Csql::cariData2("gambarboat_2", "kodeboat", $id, $this->baseTable);
            $gambarboat_3_old = Csql::cariData2("gambarboat_3", "kodeboat", $id, $this->baseTable);
            $gambarboat_4_old = Csql::cariData2("gambarboat_4", "kodeboat", $id, $this->baseTable);

            $gambarboat_1 = Cupload::UploadGambar('gambarboat_1', $gambarboat_1_old, $request);
            $gambarboat_2 = Cupload::UploadGambar('gambarboat_2', $gambarboat_2_old, $request);
            $gambarboat_3 = Cupload::UploadGambar('gambarboat_3', $gambarboat_3_old, $request);
            $gambarboat_4 = Cupload::UploadGambar('gambarboat_4', $gambarboat_4_old, $request);

			// update user
			DB::table($this->baseTable)
	            ->where('kodeboat', "=", $id)
	            ->update
	            ([
		            'kodeowner' => Cfilter::FilterString($request->input('kodeowner')),
		            'kodejenis' => Cfilter::FilterString($request->input('kodejenis')),
	                // 'kodeboat' => Cfilter::FilterString($request->input('kodeboat')),
	                'keteranganboat' => Cfilter::FilterString($request->input('keteranganboat')),
	                'hargaboat' => Cfilter::FilterInt($request->input('hargaboat')),
	                'kapasitas' => Cfilter::FilterInt($request->input('kapasitas')),
	                'gambarboat_1' => Cfilter::FilterString($gambarboat_1),
	                'gambarboat_2' => Cfilter::FilterString($gambarboat_2),
	                'gambarboat_3' => Cfilter::FilterString($gambarboat_3),
	                'gambarboat_4' => Cfilter::FilterString($gambarboat_4),
                    'dateupdboat' => Cfilter::FilterString(date("Y-m-d H:i")),
	            ]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Update Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aBoat::class, 'edit'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Update Data : <b>".$request->input('kodeboat')."</b>");
		return redirect()->action([aBoat::class, 'list'])->with('pesaninfo', $this->pesaninfo);

    }

    public function acthapus($id)
    {
		DB::beginTransaction();

        try
        {
            DB::table($this->baseTable)
                ->where('kodeboat', '=', $id)
                ->delete();

		    DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Hapus Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([aBoat::class, 'list'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Hapus Data : <b>".$id."</b>");
		return redirect()->action([aBoat::class, 'list'])->with('pesaninfo', $this->pesaninfo);
    }

}
?>
