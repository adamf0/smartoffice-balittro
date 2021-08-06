<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login','ApiController@login');
Route::get('/clear',function(){
    \Artisan::call('route:clear');
    echo "route clear<br>";
    \Artisan::call('cache:clear');
    echo "cache clear<br>";
    \Artisan::call('config:clear');
    echo "congif clear<br>";
});

Route::get('/getPerjalananDinas/{id}','ApiController@getPerjalananDinas');
Route::post('/setPerjalananDinas','ApiController@setPerjalananDinas');
Route::post('/updatePerjalananDinas','ApiController@updatePerjalananDinas');
Route::get('/delPerjalananDinas/{id}','ApiController@delPerjalananDinas');

Route::get('/getPinjamKendaraan/{id}','ApiController@getPinjamKendaraan');
Route::post('/setPinjamKendaraan','ApiController@setPinjamKendaraan');
Route::post('/updatePinjamKendaraan','ApiController@updatePinjamKendaraan');
Route::get('/delPinjamKendaraan/{id}','ApiController@delPinjamKendaraan');

Route::get('/getLaporanUpg/{id}','ApiController@getLaporanUpg');
Route::post('/setLaporanUpg','ApiController@setLaporanUpg');
Route::post('/updateLaporanUpg','ApiController@updateLaporanUpg');
Route::get('/delLaporanUpg/{id}','ApiController@delLaporanUpg');

Route::get('/getCuti/{id}','ApiController@getCuti');
Route::post('/setCuti','ApiController@setCuti');
Route::post('/updateCuti','ApiController@updateCuti');
Route::get('/delCuti/{id}','ApiController@delCuti');

Route::get('/getPengemudi','ApiController@getAllPengemudi'); //unused
Route::get('/getPenggunaKaryawan','ApiController@getPenggunaKaryawan');
Route::get('/getTujuan','ApiController@getTujuan');
Route::get('/getPaguAnggaran','ApiController@getPaguAnggaran');
Route::get('/getJenisCuti','ApiController@getJenisCuti');

Route::post('/getNotif','ApiController@getNotif');
//Route::get('/getNotif','ApiController@getNotif');

Route::get('/getOrderKendaraan/{id}','ApiController@getOrderKendaraan');
Route::get('/acceptOrderKendaraan/{id_pinjam_kendaraan}/{id}','ApiController@acceptOrderKendaraan');
Route::get('/cancelOrderKendaraan/{id_pinjam_kendaraan}/{id}','ApiController@cancelOrderKendaraan');


Route::get('/get_data','ApiController@get_data');
Route::post('/updateAkun','ApiController@updateAkun');
Route::post('/updateProfil','ApiController@updateDataAkun');
Route::post('/updateImage','ApiController@updateImage');

//Route::get('/roots','ApiController@roots');