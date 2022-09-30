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

use App\Http\Controllers\fAuth;
use App\Http\Controllers\fInfo;

class fAuth extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_user";
    	$this->prefix = "auth";
    	$this->pagename = "Auth";

    	// cek apakah sudah login atau belum
    	// $this->middleware('ceklogin');
    }

    public function login(Request $request)
    {
        return view("front/$this->prefix/login");
    }

    public function registrasi(Request $request)
    {
        return view("front/$this->prefix/registrasi");
    }

    public function profile()
    {
    	// $this->middleware('ceklogin');

    	$id = session('kodepelanggan');

		// Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = 'Profile User';
		$data['aksi'] = "actupdateprofile";

		// paramerter error
		$data['pesaninfo'] = "";
		$data['iserror'] = false;

        $data['rows'] = DB::table('tbl_pelanggan')
                        ->where('kodepelanggan', '=', $id)
                        ->first();

        $data['passwordpelanggan'] = Crypt::decryptString($data['rows']->passwordpelanggan);

        return view("front/$this->prefix/profile", $data);
    }

    public function actregistrasi(Request $request)
    {
        // pass request
		$data['request'] = $request;

        $this->baseTable = "tbl_pelanggan";

		DB::beginTransaction();

		try
		{
            $userpelanggan = Cfilter::FilterString($request->input('userpelanggan'));

            // cek apakah ada username yang sama
			$cekusername = Csql::cariData2("userpelanggan", "userpelanggan", $userpelanggan, $this->baseTable);
			if($cekusername != "")
			{
				$this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>username</b> sudah ada.");
				return redirect()->action([fAuth::class, 'registrasi'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
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
			return redirect()->action([fAuth::class, 'registrasi'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Tambah Data : <b>".$request->input('namapelanggan')."</b>, silahkan melakukan login ulang kedalam sistem.");
		return redirect()->action([fInfo::class, 'info'])->with('pesaninfo', $this->pesaninfo);
    }

    public function actupdateprofile(Request $request)
    {
        // Update Data

		DB::beginTransaction();

		try {

            $id = session('kodepelanggan');
            $userpelanggan = Cfilter::FilterString($request->input('userpelanggan'));
			$userpelanggan_old = Cfilter::FilterString($request->input('userpelanggan_old'));

			if($userpelanggan != $userpelanggan_old)
			{
				// cek apakah ada username yang sama
				$cekusername = Csql::cariData2("userpelanggan", "userpelanggan", $userpelanggan, "tbl_pelanggan");
				if($cekusername != "")
				{
					$this->pesaninfo = Cview::pesanGagal("Kesalahan Edit Data : <b>username</b> sudah ada.");
					return redirect()->action([fAuth::class, 'profile'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
				}
			}

			// update user
			DB::table("tbl_pelanggan")
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

	        session([
				'userpelanggan' => Cfilter::FilterString($request->input('userpelanggan')),
				'namapelanggan' => Cfilter::FilterString($request->input('namapelanggan'))
			]);

            DB::commit();

		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Update Profile Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([fAuth::class, 'profile'], ['id' => $id])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		// jika berhasil
		$this->pesaninfo = Cview::pesanSukses("Berhasil Update Profile Data : <b>".$request->input('namauser')."</b>");
		return redirect()->action([fAuth::class, 'profile'])->with('pesaninfo', $this->pesaninfo);

    }

    public function logout(Request $request)
    {
    	$request->session()->flush();
    	return redirect()->action([fAuth::class, 'login']);
    }

	public function actlogin(Request $request)
    {
		$userpelanggan = Cfilter::FilterString($request->input('userpelanggan'));
		$passwordpelanggan = Cfilter::FilterString($request->input('passwordpelanggan'));

		$sql = "SELECT * FROM tbl_pelanggan
				WHERE ( tbl_pelanggan.userpelanggan = '$userpelanggan')
				";

		$rows = DB::select(DB::raw($sql));

		if(empty($rows[0]->userpelanggan))
		{
			$this->pesaninfo = Cview::pesanGagal("username tidak ditemukan.");
			return redirect()->action([fAuth::class, 'login'])->with('pesaninfo', $this->pesaninfo)->with('erroract', true);
		}

		else
		{
			$password_dec = Crypt::decryptString($rows[0]->passwordpelanggan);
			if($passwordpelanggan != $password_dec)
			{
				$this->pesaninfo = "<p style='font-size: 11pt; color: #ffd7d7;'>useradmin atau [password] anda salah.</p>";
				return redirect()->action([fAuth::class, 'login'])->with('pesaninfo', $this->pesaninfo);
			}

			session([
				'kodepelanggan' => $rows[0]->kodepelanggan,
				'userpelanggan' => $rows[0]->userpelanggan,
				'namapelanggan' => $rows[0]->namapelanggan,
				'emailpelanggan' => $rows[0]->emailpelanggan,
				'waktu' => date('Y-m-d H:i'),
			]);

			$this->pesaninfo = Cview::pesanSukses("Anda berhasil login, kedalam sistem.");
			return redirect()->action([fInfo::class, 'info'])->with('pesaninfo', $this->pesaninfo);
		}
    }



}
?>
