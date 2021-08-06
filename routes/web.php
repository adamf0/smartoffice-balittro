<?php

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

Route::get('/', 'AdminController@login');
Route::post('/login', 'AdminController@dologin');
Route::get('/logout', 'AdminController@logout');

Route::get('/admin/beranda', 'AdminController@index');
Route::get('/admin/filemanager', 'AdminController@filemanager');
// Route::get('/testing', 'AdminController@testing');
// Route::post('/storeData', 'AdminController@storeData');
Route::get('/download/{laporan}/{id}', 'AdminController@direct_download');

Route::get('/admin/pengajuan_perjalanan_dinas', 'AdminController@pengajuan_perjalanan_dinas');
Route::get('/admin/pengajuan_perjalanan_dinas/{status}/{id}', 'AdminController@status_pengajuan_perjalanan_dinas');
Route::get('/admin/cetak/pengajuan_perjalanan_dinas', 'AdminController@filter_cetak_sppd');
Route::get('/admin/cetak/pengajuan_perjalanan_dinas/{filter}/{id}', 'AdminController@cetak_sppd');
Route::get('/admin/cetak/pengajuan_perjalanan_dinas/filter/{filter}/{id}', 'AdminController@execute_cetak_sppd');
Route::get('/admin/download/pengajuan_perjalanan_dinas/{id}', 'AdminController@download_cetak_sppd'); //download sppd

Route::get('/admin/cetak/surat_tugas', 'AdminController@cetak_surat_tugas');
Route::get('/admin/cetak/surat_tugas/filter/{filter}/{id}', 'AdminController@execute_cetak_surat_tugas');
Route::get('/admin/download/surat_tugas/{id}', 'AdminController@download_cetak_surat_tugas'); //download st

Route::get('/admin/pinjam_kendaraan', 'AdminController@pinjam_kendaraan');

Route::post('/admin/pinjam_kendaraan/update/{id}', 'AdminController@update_pinjam_kendaraan'); 
Route::post('/admin/pinjam_kendaraan/store/{id}', 'AdminController@store_pinjam_kendaraan');
Route::get('/admin/pinjam_kendaraan/{status}/{id}', 'AdminController@status_pinjam_kendaraan'); //reject & blm lengkap
Route::get('/admin/pinjam_kendaraan/form/edit/{id}', 'AdminController@edit_pinjam_kendaraan'); //view edit
Route::get('/admin/pinjam_kendaraan/form/acc/{id}', 'AdminController@acc_pinjam_kendaraan'); //view acc

Route::get('/admin/cetak/pinjam_kendaraan', 'AdminController@filter_cetak_pinjam_kendaraan');
Route::get('/admin/cetak/pinjam_kendaraan/{filter}/{id}', 'AdminController@cetak_pinjam_kendaraan');
Route::get('/admin/cetak/pinjam_kendaraan/filter/{filter}/{id}', 'AdminController@execute_cetak_pinjam_kendaraan');
Route::get('/admin/download/pinjam_kendaraan/{id}', 'AdminController@download_cetak_pinjam_kendaraan'); //downnload spk

Route::get('/admin/cuti', 'AdminController@cuti');
Route::post('/admin/cuti', 'AdminController@status_cuti_0');
Route::get('/admin/cuti/{status}/{id}', 'AdminController@status_cuti_1');
Route::get('/admin/cetak/surat_cuti', 'AdminController@filter_cetak_cuti');
Route::get('/admin/cetak/surat_cuti/{filter}/{id}', 'AdminController@cetak_cuti');
Route::get('/admin/cetak/surat_cuti/filter/{filter}/{id}', 'AdminController@execute_cetak_cuti');
Route::get('/admin/download/surat_cuti/{id}', 'AdminController@download_cetak_cuti'); //download cuti

Route::get('/admin/laporan_upg', 'AdminController@laporan_upg');
Route::get('/admin/laporan_upg/{status}/{id}', 'AdminController@status_laporan_upg');
Route::get('/admin/cetak/laporan_upg', 'AdminController@filter_cetak_laporan_upg');
Route::get('/admin/cetak/laporan_upg/{filter}/{id}', 'AdminController@cetak_laporan_upg');
Route::get('/admin/cetak/laporan_upg/filter/{filter}/{id}', 'AdminController@execute_cetak_laporan_upg');

Route::get('/admin/kwitansi_sppd', 'AdminController@kwitansi_sppd');
Route::get('/admin/kwitansi_sppd/add', 'AdminController@add_kwitansi_sppd');
Route::get('/admin/kwitansi_sppd/edit/{id}', 'AdminController@edit_kwitansi_sppd');
Route::post('/admin/kwitansi_sppd/store', 'AdminController@store_kwitansi_sppd');
Route::post('/admin/kwitansi_sppd/update', 'AdminController@update_kwitansi_sppd');
Route::get('/admin/kwitansi_sppd/delete/{id}', 'AdminController@delete_kwitansi_sppd');
Route::get('/admin/kwitansi_sppd/{status}/{id}', 'AdminController@status_kwitansi_sppd');
Route::get('/admin/cetak/surat_quitansi', 'AdminController@filter_cetak_kwitansi_sppd');
Route::get('/admin/cetak/surat_quitansi/{filter}/{id}', 'AdminController@cetak_kwitansi_sppd');
Route::get('/admin/cetak/surat_quitansi/filter/{filter}/{id}', 'AdminController@execute_cetak_kwitansi_sppd');
Route::get('/admin/download/surat_quitansi/{id}', 'AdminController@download_cetak_kwitansi_sppd'); //download kwitansi

Route::get('/admin/laporan_spd', 'AdminController@laporan_spd');
Route::get('/admin/laporan_spd/add', 'AdminController@add_laporan_spd');
Route::get('/admin/laporan_spd/edit/{id}', 'AdminController@edit_laporan_spd');
Route::post('/admin/laporan_spd/store', 'AdminController@store_laporan_spd');
Route::post('/admin/laporan_spd/update', 'AdminController@update_laporan_spd');
Route::get('/admin/laporan_spd/delete/{id}', 'AdminController@delete_laporan_spd');
Route::get('/admin/laporan_spd/{status}/{id}', 'AdminController@status_laporan_spd');
Route::get('/admin/cetak/surat_spd', 'AdminController@filter_cetak_laporan_spd');
Route::get('/admin/cetak/surat_spd/{filter}/{id}', 'AdminController@cetak_laporan_spd');
Route::get('/admin/cetak/surat_spd/filter/{filter}/{id}/target/{id_user}', 'AdminController@execute_cetak_laporan_spd');
Route::get('/admin/download/surat_spd/{id}', 'AdminController@download_cetak_laporan_spd');


Route::get('/admin/akun_pribadi', 'AdminController@akun_pribadi');
Route::post('/admin/akun_pribadi/ubah', 'AdminController@ubah_akun');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/super_admin/beranda', 'AdminController@index_');

Route::get('/super_admin/pengguna', 'AdminController@pengguna_');
Route::get('/super_admin/pengguna/add', 'AdminController@add_pengguna_');
Route::get('/super_admin/pengguna/edit/{id}', 'AdminController@edit_pengguna_');
Route::post('/super_admin/pengguna/store', 'AdminController@store_pengguna_');
Route::post('/super_admin/pengguna/update', 'AdminController@update_pengguna_');
Route::get('/super_admin/pengguna/delete/{id}', 'AdminController@delete_pengguna_');

Route::get('/super_admin/akun', 'AdminController@akun_');
Route::get('/super_admin/akun/add', 'AdminController@add_akun_');
Route::get('/super_admin/akun/edit/{id}', 'AdminController@edit_akun_');
Route::post('/super_admin/akun/store', 'AdminController@store_akun_');
Route::post('/super_admin/akun/update', 'AdminController@update_akun_');
Route::get('/super_admin/akun/delete/{id}', 'AdminController@delete_akun_');

Route::get('/super_admin/pagu_anggaran', 'AdminController@pagu_anggaran_');
Route::get('/super_admin/pagu_anggaran/add', 'AdminController@add_pagu_anggaran_');
Route::get('/super_admin/pagu_anggaran/edit/{id}', 'AdminController@edit_pagu_anggaran_');
Route::post('/super_admin/pagu_anggaran/store', 'AdminController@store_pagu_anggaran_');
Route::post('/super_admin/pagu_anggaran/update', 'AdminController@update_pagu_anggaran_');
Route::get('/super_admin/pagu_anggaran/delete/{id}', 'AdminController@delete_pagu_anggaran_');

Route::get('/super_admin/potong_anggaran/{id}', 'AdminController@potong_anggaran_');
Route::get('/super_admin/potong_anggaran/add/{id}', 'AdminController@add_potong_anggaran_');
Route::post('/super_admin/potong_anggaran/store', 'AdminController@store_potong_anggaran_');
Route::get('/super_admin/potong_anggaran/delete/{id}', 'AdminController@delete_potong_anggaran_');

Route::get('/super_admin/tujuan_anggaran', 'AdminController@tujuan_anggaran_');
Route::get('/super_admin/tujuan_anggaran/add', 'AdminController@add_tujuan_anggaran_');
Route::get('/super_admin/tujuan_anggaran/edit/{id}', 'AdminController@edit_tujuan_anggaran_');
Route::post('/super_admin/tujuan_anggaran/store', 'AdminController@store_tujuan_anggaran_');
Route::post('/super_admin/tujuan_anggaran/update', 'AdminController@update_tujuan_anggaran_');
Route::get('/super_admin/tujuan_anggaran/delete/{id}', 'AdminController@delete_tujuan_anggaran_');

Route::get('/super_admin/jenis_anggaran', 'AdminController@jenis_anggaran_');
Route::get('/super_admin/jenis_anggaran/add', 'AdminController@add_jenis_anggaran_');
Route::get('/super_admin/jenis_anggaran/edit/{id}', 'AdminController@edit_jenis_anggaran_');
Route::post('/super_admin/jenis_anggaran/store', 'AdminController@store_jenis_anggaran_');
Route::post('/super_admin/jenis_anggaran/update', 'AdminController@update_jenis_anggaran_');
Route::get('/super_admin/jenis_anggaran/delete/{id}', 'AdminController@delete_jenis_anggaran_');

Route::get('/super_admin/jenis_golongan', 'AdminController@jenis_golongan_');
Route::get('/super_admin/jenis_golongan/add', 'AdminController@add_jenis_golongan_');
Route::get('/super_admin/jenis_golongan/edit/{id}', 'AdminController@edit_jenis_golongan_');
Route::post('/super_admin/jenis_golongan/store', 'AdminController@store_jenis_golongan_');
Route::post('/super_admin/jenis_golongan/update', 'AdminController@update_jenis_golongan_');
Route::get('/super_admin/jenis_golongan/delete/{id}', 'AdminController@delete_jenis_golongan_');

Route::get('/super_admin/jenis_gratifikasi', 'AdminController@jenis_gratifikasi_');
Route::get('/super_admin/jenis_gratifikasi/add', 'AdminController@add_jenis_gratifikasi_');
Route::get('/super_admin/jenis_gratifikasi/edit/{id}', 'AdminController@edit_jenis_gratifikasi_');
Route::post('/super_admin/jenis_gratifikasi/store', 'AdminController@store_jenis_gratifikasi_');
Route::post('/super_admin/jenis_gratifikasi/update', 'AdminController@update_jenis_gratifikasi_');
Route::get('/super_admin/jenis_gratifikasi/delete/{id}', 'AdminController@delete_jenis_gratifikasi_');

Route::get('/super_admin/jenis_jabatan', 'AdminController@jenis_jabatan_');
Route::get('/super_admin/jenis_jabatan/add', 'AdminController@add_jenis_jabatan_');
Route::get('/super_admin/jenis_jabatan/edit/{id}', 'AdminController@edit_jenis_jabatan_');
Route::post('/super_admin/jenis_jabatan/store', 'AdminController@store_jenis_jabatan_');
Route::post('/super_admin/jenis_jabatan/update', 'AdminController@update_jenis_jabatan_');
Route::get('/super_admin/jenis_jabatan/delete/{id}', 'AdminController@delete_jenis_jabatan_');

Route::get('/super_admin/jenis_pangkat', 'AdminController@jenis_pangkat_');
Route::get('/super_admin/jenis_pangkat/add', 'AdminController@add_jenis_pangkat_');
Route::get('/super_admin/jenis_pangkat/edit/{id}', 'AdminController@edit_jenis_pangkat_');
Route::post('/super_admin/jenis_pangkat/store', 'AdminController@store_jenis_pangkat_');
Route::post('/super_admin/jenis_pangkat/update', 'AdminController@update_jenis_pangkat_');
Route::get('/super_admin/jenis_pangkat/delete/{id}', 'AdminController@delete_jenis_pangkat_');

Route::get('/super_admin/pengemudi', 'AdminController@pengemudi_');
Route::get('/super_admin/pengemudi/add', 'AdminController@add_pengemudi_');
Route::get('/super_admin/pengemudi/edit/{id}', 'AdminController@edit_pengemudi_');
Route::post('/super_admin/pengemudi/store', 'AdminController@store_pengemudi_');
Route::post('/super_admin/pengemudi/update', 'AdminController@update_pengemudi_');
Route::get('/super_admin/pengemudi/delete/{id}', 'AdminController@delete_pengemudi_');

Route::get('/super_admin/biaya_anggaran', 'AdminController@biaya_anggaran_');
Route::get('/super_admin/biaya_anggaran/add', 'AdminController@add_biaya_anggaran_');
Route::get('/super_admin/biaya_anggaran/edit/{id_tujuan}', 'AdminController@edit_biaya_anggaran_');
Route::post('/super_admin/biaya_anggaran/store', 'AdminController@store_biaya_anggaran_');
Route::post('/super_admin/biaya_anggaran/update', 'AdminController@update_biaya_anggaran_');
Route::get('/super_admin/biaya_anggaran/delete/{id_tujuan}', 'AdminController@delete_biaya_anggaran_');

Route::get('/super_admin/cuti', 'AdminController@cuti_');
Route::get('/super_admin/cuti/edit/{id}', 'AdminController@edit_cuti_');
Route::post('/super_admin/cuti/update', 'AdminController@update_cuti_');

Route::get('/super_admin/akun_pribadi', 'AdminController@akun_pribadi_');
Route::post('/super_admin/akun_pribadi/ubah', 'AdminController@ubah_akun_');