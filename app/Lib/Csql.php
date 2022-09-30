<?php

namespace App\Lib;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Lib\Cfilter;

class Csql
{
	public static function cekLogin()
	{
		if(empty(session('nip')))
		{
			redirect()->action('cLogin@login');
		}
	}

	public static function addDayswithdate($date, $days)
	{
	    $date = strtotime("+".$days." days", strtotime($date));
	    return  date("Y-m-d", $date);
	}

	public static function updateStatusReservasi()
	{
		// cari data pending
		$rows = DB::table('tbl_reservation')
						->select('*')
						->get();

		foreach ($rows as $row)
		{

		    $id_reservation = $row->id_reservation;
		    $tanggalreservasi = $row->created_at;
		    $datefrom = $row->datefrom;
		    $dateto = $row->dateto;
		    $reservation_status = $row->reservation_status;
		    $tanggalsekarang = date("Y-m-d");

		    // PENDING
		    if($reservation_status == "PENDING" || $reservation_status == "FAILED")
		    {
		    	$tanggalcancel = Csql::addDayswithdate($tanggalreservasi, 1);

			    // jika tanggal cancelnya sudah melebihi tanggal sekarang maka, cancel bookingnya
			    if($tanggalsekarang > $tanggalcancel)
			    {
			    	DB::table("tbl_reservation")
		            ->where('id_reservation', "=", $id_reservation)
		            ->update
		            ([
		                'reservation_status' => "CANCEL",
		            ]);
			    }
		    }

		    // VALID
		    if($reservation_status == "VALID")
		    {
		    	if($tanggalsekarang >= $datefrom)
		    	{
		    		DB::table("tbl_reservation")
		            ->where('id_reservation', "=", $id_reservation)
		            ->update
		            ([
		                'reservation_status' => "CHECKIN",
		            ]);
		    	}
		    }

		    // CHECK OUT
		    if($reservation_status == "CHECKIN")
		    {
		    	if($tanggalsekarang >= $dateto)
		    	{
		    		DB::table("tbl_reservation")
		            ->where('id_reservation', "=", $id_reservation)
		            ->update
		            ([
		                'reservation_status' => "CHECKOUT",
		            ]);
		    	}
		    }

		}
	}

    public static function generateFakeID($prefix, $numkode)
    {
        // parsing kode
        $nilaikode = substr($numkode, strlen($prefix));
        $kode = (int) $nilaikode;
        $kode = $kode + $numkode;
        $hasilkode = $prefix.str_pad($kode, 4, "0", STR_PAD_LEFT);

        return $hasilkode;
    }

	public static function generateKode($prefix, $table)
    {

		// ambil max data counter
    	$datakode = DB::table("tbl_counter")
					->where("tabel", $table)
					->max('counter');

    	if($datakode == "")
    	{
    		$hasilkode = $prefix."0001";

			// simpan ke tbl_counter
			DB::table("tbl_counter")->insert([[
		    	'tabel' => $table,
				'counter' => $hasilkode
			]]);
    	}

    	else
    	{
			// parsing kode
    		$nilaikode = substr($datakode, strlen($prefix));
    		$kode = (int) $nilaikode;
			$kode = $kode + 1;
			$hasilkode = $prefix.str_pad($kode, 4, "0", STR_PAD_LEFT);

			// update data counter
			DB::table("tbl_counter")
            ->where('tabel', "=", $table)
            ->update
            ([
                'counter' => $hasilkode,
            ]);
    	}

    	return $hasilkode;

    }

    public static function generateKode2($kode, $param, $table)
	{

		if($kode =="" || $param == "" || $table == "")
		{
			echo "Tidak dapat menggenerate data Kode Otomatis";
			return;
		}

		$autonum = "";
		$value	 = "";

        $nomer = DB::table($table)
					->max($kode);

		$autonum = $nomer;

		# Cek Parameter
		if($autonum == "")
		{
			$autonum = $param."001";
		}
		else
		{
			$autonum = (int) substr($autonum, strlen($param), 4);
			$autonum++;
			$autonum =  $param.sprintf("%03s", $autonum);
		}

		return $autonum;
	}

	public static function cariData($table, $field, $value)
    {
    	$hasil = DB::table($table)->where($field, $value)->first();

        if(empty($data->$hasil))
        {
            $hasil = "";
            return;
        }

        return $hasil;
    }

	public static function cariData2($get, $field, $value, $tabel)
    {
    	$iRes = "";
        $data = DB::table($tabel)
                ->select($get)
                ->where($field, '=', $value)
                ->first();

        if(empty($data->$get))
        {
        	$iRes = "";
        	return $iRes;
        }

		$iRes = $data->$get;
    	return $iRes;

    // 	$iRes = "";
    //     $sql = "SELECT * FROM $tabel
				// WHERE $field = '$value'";

    //     $results = DB::select(DB::raw($sql));

    //     if(empty($results[0]->$get))
    //     {
    //     	$iRes = "";
    //     	return $iRes;
    //     }

    //     $iRes = $results[0]->$get;
    //     return $iRes;

    }

    public static function cekPeriodePenilaian($periode, $kodepegawai)
    {
    	$periode = date('Y-m', strtotime($periode));
    	$sql = "SELECT count(*) as jml FROM tbl_penilaian
				WHERE (DATE_FORMAT(periode, '%Y-%m') = '$periode'
				AND kodepegawai = '$kodepegawai')";

        $results = DB::select(DB::raw($sql));

        return $results[0]->jml;
    }

    public static function cekSisaCuti($tahun, $nip)
    {
    	$sql = "SELECT SUM(DATEDIFF(tanggalselesai, tanggalmulai)) as jml FROM tbl_permohonan_cuti
				WHERE (DATE_FORMAT(tanggalmulai, '%Y') = '$tahun'
				AND nip = '$nip' AND statuspermohonan = 'DITERIMA')";

        $results = DB::select(DB::raw($sql));

        $jumlah = $results[0]->jml;
        $sisa_cuti = 20 - $jumlah;

        return $sisa_cuti;
    }

    public static function cekJumlahCuti($tahun, $nip)
    {
    	$sql = "SELECT SUM(DATEDIFF(tanggalselesai, tanggalmulai)) as jml FROM tbl_permohonan_cuti
				WHERE (DATE_FORMAT(tanggalmulai, '%Y') = '$tahun'
				AND nip = '$nip' AND statuspermohonan = 'DITERIMA')";

        $results = DB::select(DB::raw($sql));

        $jumlah = $results[0]->jml;

        return $jumlah;
    }

    public static function SelisihTanggal($datefrom, $dateto)
    {
  //   	$ts1 = strtotime($date1);
		// $ts2 = strtotime($date2);

		// $seconds_diff = $ts2 - $ts1;

		$date1 = date_create($datefrom);
		$date2 = date_create($dateto);
		$diff = date_diff($date1, $date2);

		return $diff->format('%a');
    }

    public static function DropDown($value, $display, $tabel)
    {
        $rows = DB::table($tabel)
                ->select('*')
                ->get();

        $temp = "";

        $temp .= "<option value=''>Pilih..</option>";

        foreach ($rows as $row)
        {
			$temp .= "<option value='".$row->$value."'>".$row->$display."</option>";
		}

        return $temp;
    }

    public static function DropDownStatus($value, $display, $tabel, $statusfield)
    {
        $rows = DB::table($tabel)
                ->select('*')
                ->where($statusfield, "=", 1)
                ->get();

        $temp = "";

        $temp .= "<option value=''>Pilih..</option>";

        foreach ($rows as $row)
        {
            $temp .= "<option value='".$row->$value."'>".$row->$display."</option>";
        }

        return $temp;
    }

    public static function DropDownGrid($value, $display, $tabel, $statusfield, $placeholder = NULL)
    {
        $rows = DB::table($tabel)
                ->select('*')
                ->where($statusfield, "=", 1)
                ->get();

        $temp = array();

        if(!empty($placeholder))
        {
            $temp []= " '' : '$placeholder' ";
        }

        foreach ($rows as $row)
        {
            $temp []= " '".$row->$value."' : '".$row->$display."'";
        }

        return join($temp, ",");

    }

    public static function DropDownRestoran($id_user_client)
    {
        $rows = DB::table('restoran')
                ->select('*')
                ->where('status_aktif', "=", 1)
                ->where('id_user_client', "=", $id_user_client)
                ->get();

        $temp = "";

        $temp .= "<option value=''>Pilih Data..</option>";

        foreach ($rows as $row)
        {
			$temp .= "<option value='".$row->id_restoran."'>".$row->nama_restoran."</option>";
		}

        return $temp;
    }

    public static function DropDownPegawai()
    {
        $rows = DB::table('tbl_pegawai')
                ->select('*')
                ->where('nip', '<>', session('nip'))
                ->get();

        $temp = "";

        foreach ($rows as $row)
        {
			$temp .= "<option value='".$row->nip."'>".$row->namauser." (".$row->nip.")</option>";
		}

        return $temp;

    }

    public static function getJumlahReward($nip)
    {
    	$results = DB::select(DB::raw("SELECT count(*) as jml FROM tbl_reward
        		   WHERE (nip = '$nip')"));

        return $results[0]->jml;
    }

    public static function getJumlahSanksi($nip)
    {
    	$results = DB::select(DB::raw("SELECT count(*) as jml FROM tbl_sanksi
        		   WHERE (nip = '$nip')"));

        return $results[0]->jml;
    }

	public static function addlog($tabel, $aksi, $kode)
    {
		DB::table("tbl_log")->insert([[
            'user' => Cfilter::FilterString(session('kodeadmin')),
            'tabel' => Cfilter::FilterString($tabel),
            'aksi' => Cfilter::FilterString($aksi),
            'kode' => Cfilter::FilterString($kode),
            'datelog' => Cfilter::FilterString(date("Y-m-d H:i")),
        ]]);
    }

    public static function cekPeriodeAbsen($nip, $bulan, $tahun)
    {

       	$results = DB::select(DB::raw("SELECT count(*) as jml FROM tbl_absen
        		   WHERE (nip = '$nip') AND (bulan = '$bulan') AND (tahun = '$tahun')"));

        return $results[0]->jml;
    }

    public static function cekKategori($id_user_konsultan, $id_kategori)
	{
		$iRes = "";
		$Sql = "SELECT count(*) as jml
				FROM spesialisasi
        		WHERE (id_user_konsultan = '$id_user_konsultan') AND (id_kategori = '$id_kategori')";

		$results = DB::select(DB::raw($Sql));

		if($results[0]->jml > 0)
		{
			$iRes = true;
		}
		else
		{
			$iRes = false;
		}

		return $iRes;
	}

	public static function cekSpesialisasi($id_user_konsultan)
    {
        $rows = DB::table('spesialisasi')
        		->join('kategori', 'kategori.id_kategori', '=', 'spesialisasi.id_kategori')
                ->select('*')
                ->where('spesialisasi.id_user_konsultan', '=', $id_user_konsultan)
                ->get();

        $temp = array();

        foreach ($rows as $row)
        {
			$temp[]= $row->nama_kategori;
		}

        return join($temp, ",");

    }

    public static function cekStatusBooking($status)
    {
    	$iRes = "";

        if($status == 0)
    	{
    		$iRes = "Pending";
    	}

    	elseif($status == 1)
    	{
    		$iRes = "Menunggu Konfirmasi";
    	}

        elseif($status == 2)
        {
            $iRes = "Valid / Lunas";
        }

    	else
    	{
    		$iRes = "Gagal";
    	}

    	return $iRes;
    }

    public static function cekStatusOrderPengiriman($status)
    {
        $iRes = "";

        if($status == 1)
        {
            $iRes = "Belum Ada Status";
        }

        elseif($status == 3)
        {
            $iRes = "Sedang Dikerjakan";
        }

        elseif($status == 4)
        {
            $iRes = "Siap Dikirim";
        }

        elseif($status == 5)
        {
            $iRes = "Dikirim";
        }

        elseif($status == 6)
        {
            $iRes = "Diterima";
        }

        elseif($status == 7)
        {
            $iRes = "Dibatalkan";
        }

        else
        {
            $iRes = "--";
        }

        return $iRes;
    }

    public static function cekStatusPengiriman($status)
    {
        $iRes = "";

        if($status == 0)
        {
            $iRes = "Belum Terkirim";
        }

        elseif($status == 2)
        {
            $iRes = "Sudah Terkirim";
        }

        else
        {
            $iRes = "--";
        }

        return $iRes;
    }

    public static function cekStatusPembayaran($status)
    {
        $iRes = "";

        if($status == 0)
        {
            $iRes = "Pending";
        }

        elseif($status == 1)
        {
            $iRes = "Valid";
        }

        elseif($status == 2)
        {
            $iRes = "Tidak Valid";
        }

        return $iRes;
    }

    public static function cekStatusPenarikan($status)
    {
        $iRes = "";

        if($status == 0)
        {
            $iRes = "Pending";
        }

        elseif($status == 1)
        {
            $iRes = "Disetujui";
        }

        elseif($status == 2)
        {
            $iRes = "Hapus";
        }

        return $iRes;
    }

    public static function getStar($nilai)
    {
        $iRes = "";

        if($nilai == 0)
        {
            $iRes = "--";
            return $iRes;
        }

        if($nilai >= 1)
        {
            $iRes .= "<i class='fa fa-star'></i>";
        }

        if($nilai >= 2)
        {
            $iRes .= "<i class='fa fa-star'></i>";
        }

        if($nilai >= 3)
        {
            $iRes .= "<i class='fa fa-star'></i>";
        }

        if($nilai >= 4)
        {
            $iRes .= "<i class='fa fa-star'></i>";
        }

        if($nilai >= 5)
        {
            $iRes .= "<i class='fa fa-star'></i>";
        }

        return $iRes;
    }

    public static function getAllStar($id_user_konsultan)
    {
        $iRes = "";
        $Sql = "SELECT sum(ulasan.rating) as totalrating, count(*) as jumlah FROM ulasan
                INNER JOIN konsultasi ON (konsultasi.id_konsultasi = ulasan.id_konsultasi)
                INNER JOIN user_konsultan ON (user_konsultan.id_user_konsultan = konsultasi.id_user_konsultan)
                WHERE (konsultasi.id_user_konsultan = '$id_user_konsultan')";

        $results = DB::select(DB::raw($Sql));

        $totalrating = intval($results[0]->totalrating);
        $jumlah = intval($results[0]->jumlah);

        if($totalrating == 0 OR $jumlah == 0)
        {
            $star = 0;
        }
        else
        {
            $star = intval($totalrating / $jumlah);
        }

        $iRes = Csql::getStar($star);

        return $iRes;
    }

    public static function cekJumlahData($id_konsultasi, $jenis)
    {
        $iRes = 0;

        // jumlah dana yang masih ada dan belum ditarik oleh konsultan
        if($jenis == "MASUK")
        {
            $biaya_konsultasi = Csql::cariData2("biaya_konsultasi", "id_konsultasi", $id_konsultasi, "konsultasi");
            $potongan = 20 / 100 * $biaya_konsultasi;
            $penarikan = Csql::cekJumlahData($id_konsultasi, "KELUAR");

            $sql = "SELECT SUM(jumlah) as total FROM pembayaran
                    WHERE id_konsultasi = '$id_konsultasi' AND status_pembayaran = 1";

            $results = DB::select(DB::raw($sql));

            if(empty($results[0]->total))
            {
                $iRes = 0;
            }
            else
            {
                $iRes = ($results[0]->total - $potongan - $penarikan);
            }

        }

        // jumlah dana yang sudah ditarik oleh konsultan
        elseif($jenis == "KELUAR")
        {
            $sql = "SELECT SUM(jumlah_penarikan) as total FROM penarikan
                    WHERE id_konsultasi = '$id_konsultasi' AND status_penarikan = 1";

            $results = DB::select(DB::raw($sql));

            if(empty($results[0]->total))
            {
                $iRes = 0;
            }
            else
            {
                $iRes = $results[0]->total;
            }
        }

        return $iRes;
    }

    // fungsi untuk mengecek apakah dari konsultan sudah melakukan pengajuan request dana
    public static function cekBoatAvaible($kodeboat, $tanggalbooking)
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_booking
                WHERE kodeboat = '$kodeboat' AND tanggalbooking = '$tanggalbooking'";

        $results = DB::select(DB::raw($sql));

        if(empty($results[0]->total))
        {
            $iRes = 0;
        }
        else
        {
            $iRes = $results[0]->total;
        }

        return $iRes;
    }

    public static function getJumlahKonsultan($periode)
    {
        $sql = "SELECT COUNT(*) as total FROM user_konsultan
                WHERE DATE_FORMAT(created_at, '%Y-%m') = '$periode' AND status_aktif = 1";

        $results = DB::select(DB::raw($sql));

        if(empty($results[0]->total))
        {
            $iRes = 0;
        }
        else
        {
            $iRes = $results[0]->total;
        }

        return $iRes;
    }

    public static function getJumlahKonsultasi($periode)
    {
        $sql = "SELECT COUNT(*) as total FROM konsultasi
                WHERE DATE_FORMAT(created_at, '%Y-%m') = '$periode' AND status_konsultasi IN (1, 2)";

        $results = DB::select(DB::raw($sql));

        if(empty($results[0]->total))
        {
            $iRes = 0;
        }
        else
        {
            $iRes = $results[0]->total;
        }

        return $iRes;
    }

    public static function getAllNamaBarang()
    {
        // cari data pending
        $sql = "SELECT namabarang FROM tbl_order_detail
                GROUP BY namabarang";

        $rows = DB::select(DB::raw($sql));

        $arrtemp = [];
        foreach ($rows as $row)
        {
            $arrtemp[] = "'$row->namabarang'";
        }

        return $arrtemp;
    }

    public static function getAllWarna()
    {
        // cari data pending
        $sql = "SELECT warna FROM tbl_order_detail
                GROUP BY warna";

        $rows = DB::select(DB::raw($sql));

        $arrtemp = [];
        foreach ($rows as $row)
        {
            $arrtemp[] = "'$row->warna'";
        }

        return $arrtemp;
    }

    public static function getTotalOrder($kodebrand, $tahun, $bulan)
    {
        // cari data pending
        $Sql = "SELECT SUM(tbl_order.total) as totalall FROM tbl_order
                WHERE (DATE_FORMAT(tbl_order.tglorder, '%Y') = '$tahun') AND (tbl_order.kodebrand = '$kodebrand')
                AND (tbl_order.statusorder IN (1, 3, 4, 5, 6))
                ";

        if(!empty($bulan))
        {
            $Sql .= " AND (DATE_FORMAT(tbl_order.tglorder, '%m') = '$bulan') ";
        }

        $row = DB::select(DB::raw($Sql));

        if(empty($row[0]->totalall))
        {
            $iRes = 0;
        }
        else
        {
            $iRes = $row[0]->totalall;
        }

        return $iRes;
    }

    public static function getDetailOrder($kodeorder)
    {
        $iRes = "";
        $Sql = "SELECT * FROM tbl_order_detail
                INNER JOIN tbl_jenis_barang ON (tbl_jenis_barang.kodejenisbarang = tbl_order_detail.kodejenisbarang)
                INNER JOIN tbl_pengepul ON (tbl_pengepul.kodepengepul = tbl_order_detail.kodepengepul)
                WHERE (tbl_order_detail.kodeorder = '$kodeorder')";

        $rows = DB::select(DB::raw($Sql));

        $no = 1;
        $arr = [];
        foreach ($rows as $row)
        {

            $total = ($row->qty * $row->harga);

            $arr[] = "
            <tr>
                <td>$no</td>
                <td>$row->namajenisbarang</td>
                <td>$row->namapengepul</td>
                <td>$row->qty</td>
                <td>".number_format($row->harga)."</td>
                <td>".number_format($total)."</td>
                <td>$row->namabarang</td>
                <td>$row->warna</td>
                <td>$row->tglambil</td>
                <td>$row->tglsetor</td>
                <td>$row->size</td>
            </tr>
            ";

            $no++;
        }

        $iRes = join($arr, "");
        return $iRes;
    }

}
