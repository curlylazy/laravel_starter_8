<?php

use Illuminate\Support\Facades\Route;

// controller admin
use App\Http\Controllers\aDashboard;
use App\Http\Controllers\aJenisBoat;
use App\Http\Controllers\aBoat;
use App\Http\Controllers\aUser;
use App\Http\Controllers\aAuth;
use App\Http\Controllers\aOwner;
use App\Http\Controllers\aPelanggan;
use App\Http\Controllers\aBooking;
use App\Http\Controllers\aLaporan;

// controller pelanggan
use App\Http\Controllers\fDashboard;
use App\Http\Controllers\fAuth;
use App\Http\Controllers\fInfo;
use App\Http\Controllers\fBoat;
use App\Http\Controllers\fBooking;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('gambar/{filename}', function ($filename)
{
	$path = public_path('uploads/pic/'.$filename);

    if(!File::exists($path))
	{
        $path = public_path('uploads/pic/noimage.jpg');
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;

});

//  ================================= PELANGGAN ROUTE ===============================

// Dashboard
Route::get('/', [fDashboard::class, 'index']);
Route::get('/dashboard', [fDashboard::class, 'index']);

Route::get('/info', [fInfo::class, 'info']);

Route::get('/auth/login', [fAuth::class, 'login']);
Route::get('/auth/logout', [fAuth::class, 'logout']);
Route::get('/auth/registrasi', [fAuth::class, 'registrasi']);
Route::get('/auth/profile', [fAuth::class, 'profile']);
Route::any('/auth/actupdateprofile', [fAuth::class, 'actupdateprofile']);
Route::any('/auth/actregistrasi', [fAuth::class, 'actregistrasi']);
Route::any('/auth/actlogin', [fAuth::class, 'actlogin']);
Route::any('/auth/actprofile', [fAuth::class, 'actprofile']);

Route::get('/boat/list', [fBoat::class, 'list']);
Route::get('/boat/detail/{id}', [fBoat::class, 'detail']);

Route::any('/booking/list', [fBooking::class, 'list']);
Route::any('/booking/konfirmasi/{id}', [fBooking::class, 'konfirmasi']);
Route::any('/booking/detail/{id}', [fBooking::class, 'detail']);
Route::any('/booking/actbooking', [fBooking::class, 'actbooking']);
Route::any('/booking/actkonfirmasi', [fBooking::class, 'actkonfirmasi']);


//  ================================= ADMIN ROUTE ===============================

// Dashboard
Route::get('/admin', [aDashboard::class, 'index']);
Route::get('/admin/dashboard', [aDashboard::class, 'index']);

// Auth
Route::get('/admin/auth/login', [aAuth::class, 'login']);
Route::get('/admin/auth/profile', [aAuth::class, 'profile']);
Route::any('/admin/auth/actlogin', [aAuth::class, 'actlogin']);
Route::any('/admin/auth/actlogout', [aAuth::class, 'actlogout']);
Route::any('/admin/auth/actupdateprofile', [aAuth::class, 'actupdateprofile']);

// Jenis Boat
Route::any('/admin/master/jenisboat/list', [aJenisBoat::class, 'list']);
Route::any('/admin/master/jenisboat/tambah', [aJenisBoat::class, 'tambah']);
Route::any('/admin/master/jenisboat/edit/{id}', [aJenisBoat::class, 'edit']);
Route::any('/admin/master/jenisboat/acttambah', [aJenisBoat::class, 'acttambah']);
Route::any('/admin/master/jenisboat/actedit', [aJenisBoat::class, 'actedit']);
Route::any('/admin/master/jenisboat/acthapus/{id}', [aJenisBoat::class, 'acthapus']);

// User
Route::any('/admin/master/user/list', [aUser::class, 'list']);
Route::any('/admin/master/user/tambah', [aUser::class, 'tambah']);
Route::any('/admin/master/user/edit/{id}', [aUser::class, 'edit']);
Route::any('/admin/master/user/acttambah', [aUser::class, 'acttambah']);
Route::any('/admin/master/user/actedit', [aUser::class, 'actedit']);
Route::any('/admin/master/user/acthapus/{id}', [aUser::class, 'acthapus']);

// Owner
Route::any('/admin/master/owner/list', [aOwner::class, 'list']);
Route::any('/admin/master/owner/tambah', [aOwner::class, 'tambah']);
Route::any('/admin/master/owner/edit/{id}', [aOwner::class, 'edit']);
Route::any('/admin/master/owner/acttambah', [aOwner::class, 'acttambah']);
Route::any('/admin/master/owner/actedit', [aOwner::class, 'actedit']);
Route::any('/admin/master/owner/acthapus/{id}', [aOwner::class, 'acthapus']);

// Boat
Route::any('/admin/master/boat/list', [aBoat::class, 'list']);
Route::any('/admin/master/boat/tambah', [aBoat::class, 'tambah']);
Route::any('/admin/master/boat/edit/{id}', [aBoat::class, 'edit']);
Route::any('/admin/master/boat/acttambah', [aBoat::class, 'acttambah']);
Route::any('/admin/master/boat/actedit', [aBoat::class, 'actedit']);
Route::any('/admin/master/boat/acthapus/{id}', [aBoat::class, 'acthapus']);

// Boat
Route::any('/admin/master/pelanggan/list', [aPelanggan::class, 'list']);
Route::any('/admin/master/pelanggan/tambah', [aPelanggan::class, 'tambah']);
Route::any('/admin/master/pelanggan/edit/{id}', [aPelanggan::class, 'edit']);
Route::any('/admin/master/pelanggan/acttambah', [aPelanggan::class, 'acttambah']);
Route::any('/admin/master/pelanggan/actedit', [aPelanggan::class, 'actedit']);
Route::any('/admin/master/pelanggan/acthapus/{id}', [aPelanggan::class, 'acthapus']);

// Booking
Route::any('/admin/transaksi/booking/list', [aBooking::class, 'list']);
Route::any('/admin/transaksi/booking/jadwal', [aBooking::class, 'listjadwal']);
Route::any('/admin/transaksi/booking/konfirmasi', [aBooking::class, 'listkonfirmasi']);
Route::any('/admin/transaksi/booking/detail/{id}', [aBooking::class, 'detailbooking']);
Route::any('/admin/transaksi/booking/konfirmasi/{id}', [aBooking::class, 'detailkonfirmasi']);
Route::any('/admin/transaksi/booking/actkonfirmasi', [aBooking::class, 'actkonfirmasi']);

// Boat
Route::any('/admin/laporan/booking', [aLaporan::class, 'booking']);
Route::any('/admin/laporan/pelanggan', [aLaporan::class, 'pelanggan']);
Route::any('/admin/laporan/cetak/booking', [aLaporan::class, 'cetak_booking']);
Route::any('/admin/laporan/cetak/pelanggan', [aLaporan::class, 'cetak_pelanggan']);