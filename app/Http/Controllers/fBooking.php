<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

// load library
use App\Lib\Csendemail;
use App\Lib\Csql;
use App\Lib\Cupload;
use App\Lib\Cfilter;
use App\Lib\Cview;

use App\Http\Controllers\fBooking;
use App\Http\Controllers\fBoat;
use App\Http\Controllers\fInfo;

class fBooking extends Controller
{
	public function __construct()
    {
		// page data
		$this->pesan = "";
    	$this->baseTable = "tbl_booking";
    	$this->prefix = "booking";
    	$this->pagename = "Booking";
    }

    public function list(Request $request)
    {
		$kodepelanggan = session('kodepelanggan');

        // Judul Halaman
		$data['prefix'] = $this->prefix;
		$data['pagename'] = $this->pagename;

		// passing function ke view
		$data['rows'] = DB::table($this->baseTable)
                        ->select('*')
                        ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
                        ->join('tbl_boat', 'tbl_boat.kodeboat', '=', 'tbl_booking.kodeboat')
                        ->where('tbl_booking.kodepelanggan', '=', $kodepelanggan)
						->orderBy('tbl_booking.kodebooking', 'desc')
						->get();

        return view("front/$this->prefix/list", $data);
    }

    public function konfirmasi($id)
    {
        // $this->middleware('ceklogin');

        // $kodepelanggan = session('kodepelanggan');

        // Judul Halaman
        $data['prefix'] = $this->prefix;
        $data['pagename'] = 'Profile User';
        $data['aksi'] = "actkonfirmasi";

        // paramerter error
        $data['pesaninfo'] = "";
        $data['iserror'] = false;

        $data['rows'] = DB::table('tbl_booking')
                        ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
                        ->where('tbl_booking.kodebooking', '=', $id)
                        ->first();

        return view("front/$this->prefix/konfirmasi", $data);
    }

    public function detail($id)
    {
        // $this->middleware('ceklogin');

        $kodepelanggan = session('kodepelanggan');

        // Judul Halaman
        $data['prefix'] = $this->prefix;
        $data['pagename'] = 'Profile User';
        $data['aksi'] = "actkonfirmasi";

        // paramerter error
        $data['pesaninfo'] = "";
        $data['iserror'] = false;

        $data['rows_booking'] = DB::table('tbl_booking')
                        ->join('tbl_pelanggan', 'tbl_pelanggan.kodepelanggan', '=', 'tbl_booking.kodepelanggan')
                        ->where('tbl_booking.kodepelanggan', '=', $kodepelanggan)
                        ->where('tbl_booking.kodebooking', '=', $id)
                        ->first();

        $data['rows_konfirmasi'] = DB::table('tbl_konfirmasi')
                        ->where('tbl_konfirmasi.kodebooking', '=', $id)
                        ->first();

        return view("front/$this->prefix/detail", $data);
    }

    public function actbooking(Request $request)
    {

		// pass request
		$data['request'] = $request;

		DB::beginTransaction();

		try
		{
			$this->baseTable = "tbl_booking";

            $kodebooking = Csql::generateKode2("kodebooking", "BOOKING", $this->baseTable);
            $kodeboat = Cfilter::FilterString($request->input('kodeboat'));
            $tanggalbooking = Cfilter::FilterString($request->input('tanggalbooking'));

            // cek avaible
            $cekavaible = Csql::cekBoatAvaible($kodeboat, $tanggalbooking);
            if($cekavaible > 0)
            {
            	$this->pesaninfo = Cview::pesanGagal("Gagal booking, tanggal yang anda pilih sudah digunakan.");
				return redirect()->action([fBoat::class, 'detail'], ['id' => $kodeboat])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
            }

            $emailpelanggan = Cfilter::FilterString($request->input('emailpelanggan'));
            $cekemailpelanggan = Csql::cariData2("emailpelanggan", "emailpelanggan", $emailpelanggan, "tbl_pelanggan");
            if($cekemailpelanggan == "")
            {
                $kodepelanggan = Csql::generateKode2("kodepelanggan", "PEL", "tbl_pelanggan");
                DB::table("tbl_pelanggan")->insert([[
                    'kodepelanggan' => Cfilter::FilterString($kodepelanggan),
                    'userpelanggan' => Cfilter::FilterString($emailpelanggan),
                    'passwordpelanggan' => Crypt::encryptString(date('Ymd')),
                    'namapelanggan' => Cfilter::FilterString($request->input('namapelanggan')),
                    'emailpelanggan' => Cfilter::FilterString($request->input('emailpelanggan')),
                    'dateaddpelanggan' => Cfilter::FilterString(date("Y-m-d H:i")),
                    'dateupdpelanggan' => Cfilter::FilterString(date("Y-m-d H:i")),
                ]]);
            }

            // ambil kodepelanggannya
            $kodepelanggan = Csql::cariData2("kodepelanggan", "emailpelanggan", $emailpelanggan, "tbl_pelanggan");
            $namapelanggan = Csql::cariData2("namapelanggan", "emailpelanggan", $emailpelanggan, "tbl_pelanggan");

			// simpan ke table user_login
			DB::table($this->baseTable)->insert([[
                'kodebooking' => Cfilter::FilterString($kodebooking),
                'kodeboat' => $kodeboat,
                'kodepelanggan' => $kodepelanggan,
                'tanggalbooking' => Cfilter::FilterString($request->input('tanggalbooking')),
                'keteranganbooking' => Cfilter::FilterString($request->input('keteranganbooking')),
                'harga' => Cfilter::FilterInt($request->input('harga')),
                'statusbooking' => Cfilter::FilterInt(0),
                'dateaddbooking' => Cfilter::FilterString(date("Y-m-d H:i")),
                'dateupdbooking' => Cfilter::FilterString(date("Y-m-d H:i")),
			]]);

            $isipesan = "<h4>BOOKING : $kodebooking</h4>

                        halo ". Cfilter::FilterString($request->input('namapelanggan')) .", terima kasih sudah melakukan booking boat di <b>Pengambengan Boat</b> <br />
                        silahkan melakukan konfirmasi pembayaran anda melalui link ini <a href='".url("booking/konfirmasi/$kodebooking")."'>Konfirmasi Pembayaran</a><br />

                        <h5>Data Booking</h5>
                        Nama Pelanggan : $namapelanggan <br />
                        Tanggal Booking : ".date('d F Y', strtotime(Cfilter::FilterString($request->input('tanggalbooking'))))." <br />
                        Boat : $kodeboat<br />
                        Harga Sewa : ".number_format( Cfilter::FilterInt($request->input('harga')))."<br />
                        Keterangan : ".Cfilter::FilterString($request->input('keteranganbooking'))."
                        ";
            $kirim = Mail::to($emailpelanggan)->send(new Csendemail($isipesan));

            DB::commit();

            // jika berhasil
            $this->pesaninfo = Cview::pesanSukses("Booking berhasil untuk boat : <b>".$kodeboat."</b>, silahkan lakukan konfirmasi booking, kode booking anda adalah : <b>$kodebooking</b>, silahkan cek email anda untuk mengetahui informasi konfirmasi.");
            return redirect()->action([fInfo::class, 'info'])->with('pesaninfo', $this->pesaninfo);


		} catch (\Exception $ex) {
		    DB::rollback();
			$this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>".$ex->getMessage()."</b>");
			return redirect()->action([fBoat::class, 'detail'], ['id' => $kodeboat])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
		}

		
    }

    public function actkonfirmasi(Request $request)
    {

        // pass request
        $data['request'] = $request;

        DB::beginTransaction();

        try
        {
            $this->baseTable = "tbl_konfirmasi";

            $kodebooking = Cfilter::FilterString($request->input('kodebooking'));
            $kodekonfirmasi = Csql::generateKode2("kodekonfirmasi", "KONFIRMASI", $this->baseTable);

            // hapus konfirmasi sebelumnya
            DB::table($this->baseTable)
                ->where('kodebooking', '=', $kodebooking)
                ->delete();

            // update statusbooking
            DB::table("tbl_booking")
                ->where('kodebooking', "=", $kodebooking)
                ->update
                ([
                    'statusbooking' => Cfilter::FilterInt(1),
                ]);

            $gambarbukti = Cupload::UploadGambar('gambarbukti', '', $request);

            // simpan
            DB::table($this->baseTable)->insert([[
                'kodekonfirmasi' => Cfilter::FilterString($kodekonfirmasi),
                'kodebooking' => Cfilter::FilterString($kodebooking),
                'bank' => Cfilter::FilterString($request->input('bank')),
                'an' => Cfilter::FilterString($request->input('an')),
                'norek' => Cfilter::FilterString($request->input('norek')),
                'gambarbukti' => Cfilter::FilterString($gambarbukti),
                'tanggalkonfirmasi' => Cfilter::FilterString($request->input('tanggalkonfirmasi')),
            ]]);

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            $this->pesaninfo = Cview::pesanGagal("Kesalahan Tambah Data : <b>".$ex->getMessage()."</b>");
            return redirect()->action([fBooking::class, 'konfirmasi'], ['id' => $kodebooking])->with('pesaninfo', $this->pesaninfo)->with('erroract', true)->withInput();
        }

        // jika berhasil
        $this->pesaninfo = Cview::pesanSukses("Konfirmasi berhasil untuk booking dengan kode : <b>".$kodebooking."</b>, admin kami akan segera melakukan proses pengecekan.");
        return redirect()->action([fInfo::class, 'info'])->with('pesaninfo', $this->pesaninfo);

    }

}
?>
