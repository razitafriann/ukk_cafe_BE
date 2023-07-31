<?php

use App\Http\Controllers\MejaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
// use App\Models\Transaksi;

/*
|--------------------------------------------------------------------------
| API Routes
|---------------------------------------------------wwwwwww-----------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth.api']], function () {
    Route::group(['middleware' => ['api.kasir']], function () {
    });

    Route::group(['middleware' => ['api.admin']], function () {
    });

    Route::group(['middleware' => ['api.manager']], function () {
    });
});

// user
Route::get('/getuser', [UserController::class, 'getuser']); //beres
Route::get('/getkasir', [UserController::class, 'getkasir']); //beres
Route::get('/getuser/{id}', [UserController::class, 'selectuser']); //beres
Route::post('/createuser', [UserController::class, 'createuser']); //beres
Route::put('/updateuser/{id}', [UserController::class, 'updateuser']); //beres
Route::delete('/deleteuser/{id}', [UserController::class, 'deleteuser']); //beres

// meja
Route::get('/getmeja', [MejaController::class, 'getmeja']); //beres
Route::get('/getmejakosong', [MejaController::class, 'mejatersedia']); //beres
Route::get('/getmeja/{id}', [MejaController::class, 'selectmeja']); //beres

Route::post('/createmeja', [MejaController::class, 'createmeja']); //beres
Route::put('/updatemeja/{id}', [MejaController::class, 'updatemeja']); //beres
Route::delete('/deletemeja/{id}', [MejaController::class, 'deletemeja']); //beres

// menu
Route::get('/getmenu', [MenuController::class, 'getmenu']); //jumlah_pesan hasilnya masi null //
Route::get('/getmenu/{id}', [MenuController::class, 'selectmenu']); //beres
Route::post('/createmenu', [MenuController::class, 'createmenu']); //beres
Route::put('/updatemenu/{id}', [MenuController::class, 'updatemenu']); //beres
 
Route::post('/updatephoto/{id}', [MenuController::class, 'updatephoto']); // update foto post //
Route::delete('/deletemenu/{id}', [MenuController::class, 'deletemenu']); //beres

// transaksi
Route::get('/gethistory', [TransaksiController::class, 'gethistory']); //email verified masi null, remember token masi null //beres
Route::get('/gethistory/{code}', [TransaksiController::class, 'selecthistory']); //frontend

Route::get('/gettransaksi', [TransaksiController::class, 'gettransaksi']); //beres
Route::get('/get_ongoing_transaksi/{id}', [TransaksiController::class, 'getongoingtransaksi']); //fe
Route::get('/gettotalharga/{id}', [TransaksiController::class, 'totalharga']);
Route::get('/gettotal/{code}', [TransaksiController::class, 'total']); //fe
Route::get('/getcart', [TransaksiController::class, 'getcart']); //fe
Route::get('/getongoing', [TransaksiController::class, 'ongoing']); //buat nampilin kursi yang digunakan
Route::put('/checkout', [TransaksiController::class, 'checkout']); // isi id_user, id_meja, nama_pelanggan biar ga null lagi
Route::put('/done_transaksi/{id}', [TransaksiController::class, 'donetransaksi']); //buat keterangan lunas
Route::get('/gettransaksi/{id}', [TransaksiController::class, 'selecttransaksi']); //ga dipakai gapapa
Route::post('/tambahpesanan', [TransaksiController::class, 'tambahpesanan']); //user, meja, nama pelanggan masi null 
Route::get('/printharga/{id}', [TransaksiController::class, 'printharga']); //user, meja, nama pelanggan masi null 

Route::get('/getday/{date}', [TransaksiController::class, 'getdate']); //fe
Route::get('/getmonth/{month}', [TransaksiController::class, 'getmonth']); //fe

