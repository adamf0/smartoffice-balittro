<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\pengemudi;
use App\data_user;
use App\pagu_anggaran;
use App\potong_anggaran;
use App\pinjam_kendaraan;
use App\pinjam_kendaraan_penumpang;
use App\pinjam_kendaraan_pengemudi;
use App\perjalanan_dinas;
use App\perjalanan_dinas_detail;
use App\laporan_upg;
use App\laporan_upg_detail;
use App\jenis_gratifikasi;
use App\anggaran;
use App\jenis_anggaran;
use App\pangkat;
use App\jabatan;
use App\agama;
use App\golongan;
use App\jenjang_pendidikan;
use App\tujuan;
use App\cuti;
use App\jenis_cuti;
use App\User;
use App\role;
use App\kwitansi_sppd;
use App\surat_perjalanan_dinas;

use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Mail;

use App\Exports\ExcelUpg;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller{
	function __construct(){
        Carbon::setlocale('id');
    } 
    // function testing(){
    //     return view('test');
    // }
    // function storeData(Request $request){
    //     $this->validate($request, [
    //         'file' => 'required|mimes:xls,xlsx'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file'); //GET FILE
    //         //Excel::import(new UserImport, $file); //IMPORT FILE 
    //         dd(Excel::toArray(new UserImport, $file))[0]; //IMPORT FILE 
    //         //return redirect()->back()->with(['success' => 'Upload success']);
    //     }  
    //     //return redirect()->back()->with(['error' => 'Please choose file before']);
    // }

    function getMenugaskan($id_perjalanan_dinas){
        $data = array();
        $list = perjalanan_dinas_detail::where('id_perjalanan_dinas',$id_perjalanan_dinas)->get();
        for ($i=0; $i < $list->count(); $i++) { 
            $data_user = data_user::where('id_user',$list[$i]->id_user)->first();
            $arr = [
                "id"=>$data_user->id_user,
                "nip"=>$data_user->nip,
                "nama"=>$data_user->nama,
                "agama"=>$data_user->agama->agama,
                "jenjang_pendidikan"=>$data_user->jenjang_pendidikan->jenjang_pendidikan,
                "nama_sekolah"=>$data_user->nama_sekolah,
                "tahun_lulus"=>$data_user->tahun_lulus,
                "jabatan"=>$data_user->jabatan->jabatan,
                "pangkat"=>$data_user->pangkat->pangkat,
                "golongan"=>$data_user->golongan->golongan,
                "tmt"=>$data_user->tmt,
                "Masa_kerja"=>$data_user->masa_kerja,
                "alamat"=>$data_user->alamat,
                "tanggal_lahir"=>($data_user->tgl_lahir=='0000-00-00'?'- - -':Carbon::parse($data_user->tgl_lahir)->formatLocalized("%A, %d %B %Y")),
                "status"=>$data_user->status
            ];
            array_push($data, $arr);
        }
        return $data;   
    }
    function getPenumpang($id_pinjam_kendaraan){
        $data = array();
        $list = pinjam_kendaraan_penumpang::where('id_pinjam_kendaraan',$id_pinjam_kendaraan)->get();
        for ($i=0; $i < $list->count(); $i++) {
            $id_user=$list[$i]->id_user;
            $nip=$this->getPengguna($id_user)['nip'];
            $nama=$this->getPengguna($id_user)['nama'];
            $agama=$this->getPengguna($id_user)['agama'];
            $jenjang_pendidikan=$this->getPengguna($id_user)['jenjang_pendidikan'];
            $nama_sekolah=$this->getPengguna($id_user)['nama_sekolah'];
            $tahun_lulus=$this->getPengguna($id_user)['tahun_lulus'];
            $jabatan=$this->getPengguna($id_user)['jabatan'];
            $pangkat=$this->getPengguna($id_user)['pangkat'];
            $golongan=$this->getPengguna($id_user)['golongan'];
            $tmt=$this->getPengguna($id_user)['tmt'];
            $masa_kerja=$this->getPengguna($id_user)['masa_kerja'];
            $alamat=$this->getPengguna($id_user)['alamat'];
            $status=$this->getPengguna($id_user)['status'];

            $arr = [
                "id"=>$id_user,
                "nip"=>$nip,
                "nama"=>$nama,
                "agama"=>$agama,
                "jenjang_pendidikan"=>$jenjang_pendidikan,
                "nama_sekolah"=>$nama_sekolah,
                "tahun_lulus"=>$tahun_lulus,
                "jabatan"=>$jabatan,
                "pangkat"=>$pangkat,
                "golongan"=>$golongan,
                "tmt"=>$tmt,
                "Masa_kerja"=>$masa_kerja,
                "alamat"=>$alamat,
                "status"=>$status
            ];
            array_push($data, $arr);
        }
        return $data;   
    }
    function getPenumpangShortList($id_pinjam_kendaraan){
        $data = array();
        $list = pinjam_kendaraan_penumpang::where('id_pinjam_kendaraan',$id_pinjam_kendaraan)->get();
        for ($i=0; $i < $list->count(); $i++) { 
            $data_user = data_user::where('id_user',$list[$i]->id_user)->first();
            $nama = ($data_user==null? "N/a":$data_user->nama);
            array_push($data, $nama);
        }
        return $data;   
    }
    function getPengguna($id_user){
        $data = data_user::where('id_user',$id_user)->first();
        if($data == null)
            return null;
        else
            return array(
                    "id"=>$data->id,
                    "nip"=>$data->nip,
                    "nama"=>$data->nama,
                    "agama"=>$data->agama->agama,
                    "jenjang_pendidikan"=>$data->jenjang_pendidikan->jenjang_pendidikan,
                    "nama_sekolah"=>$data->nama_sekolah,
                    "tahun_lulus"=>$data->tahun_lulus,
                    "jabatan"=>$data->jabatan->jabatan,
                    "pangkat"=>$data->pangkat->pangkat,
                    "golongan"=>$data->golongan->golongan,
                    "tmt"=>$data->tmt,
                    "masa_kerja"=>$data->masa_kerja,
                    "alamat"=>$data->alamat,
                    "cuti_n"=>$data->cuti_n,
                    "cuti_n1"=>$data->cuti_n1,
                    "cuti_n2"=>$data->cuti_n2,
                    "tanda_tangan"=>($data->tanda_tangan==null? "no_signature.jpg":$data->tanda_tangan),
                    "status"=>$data->status
            );  
    }
    function getTujuan(){
        $list = array();
        $datas = anggaran::all();
        for ($i=0; $i < $datas->count(); $i++) { 
            $arr = [
                'id' =>$datas[$i]->id,
                'nama_anggaran' =>$datas[$i]->jenis_anggaran->nama,
                'id_tujuan' =>$datas[$i]->id_tujuan,
                'nama_tujuan' =>$datas[$i]->tujuan->tujuan,
                'biaya' =>$datas[$i]->biaya, 
                'tipe' =>$datas[$i]->jenis_anggaran->type
            ];
            array_push($list, $arr);
        }
        echo json_encode( $this->group_data($list, 'nama_tujuan'));
    }
    function getPengemudi($id_pinjam_kendaraan){
        $list = array();
        $data = pinjam_kendaraan_pengemudi::where("id_pinjam_kendaraan",$id_pinjam_kendaraan)->get();
        for($i=0;$i<$data->count();$i++){
            $arr = [
                "id" => $data[$i]->id_pengemudi,
                "nama" => ($this->getPengguna($data[$i]->pengemudi->id_user)==null?"N/a":$this->getPengguna($data[$i]->pengemudi->id_user)['nama'] ),
                "jenis_kendaraan" => $data[$i]->pengemudi->jenis_kendaraan,
                "no_polisi" => $data[$i]->pengemudi->no_polisi,
                "accept" => $data[$i]->accept
            ];
            array_push($list, $arr);
        }
        return $list;
    }
    function getJenisCuti(){
        $list = array();
        $datas = jenis_cuti::all();
        for ($i=0; $i < $datas->count(); $i++) { 
            $arr = [
                'id' =>$datas[$i]->id,
                'nama' =>$datas[$i]->nama,
                'img' =>$datas[$i]->img
            ];
            array_push($list, $arr);
        }
        echo json_encode($list);
    }
    function CekTerima($arr){
        for ($i=0; $i < count($arr); $i++) { 
            if($arr[$i]['accept']!=1)
                unset($arr[$i]);
        }

        return $arr;
    }

    function login(){
        return view('login');
    }
    function dologin(Request $req){
        $username = $req->username;
        $password = $req->password;

        if( Auth::attempt(["username"=>$username,"password"=>$password]) ){
            if(Auth::check()){
                if(Auth::user()->id_role != 2 || Auth::user()->id_role != 3){
                    $data_user = data_user::where('id_user',Auth::user()->id)->first();
                    $id = Auth::user()->id;
                    
                    $role = Auth::user()->id_role;
                    $nama = ($data_user==null?"Admin":$data_user->nama);
                    $pangkat = ($data_user==null?null:$data_user->pangkat);
                    $jabatan = ($data_user==null?null:$data_user->jabatan);
                    $foto    = ($data_user==null?null:$data_user->foto);
                    $data_session = ['id'=>$id,'nama'=>$nama,'role'=>$role,'pangkat'=>$pangkat,'jabatan'=>$jabatan,'foto'=>$foto,'isLogin'=>1];

                    session($data_session);
                    return redirect('/admin/beranda');
                }
                else{
                    return redirect('/')->with('type_msg',0)->with('msg','Akses ditolak');
                }
            }
            else{
                return redirect('/')->with('type_msg',0)->with('msg','Gagal login');
            }
        }
        else{
            return redirect('/')->with('type_msg',0)->with('msg','Akun tidak ditemukan');
        }
    }
    function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    function index(){
        if(Session::has('isLogin')){
    	   if(Session::get('role')==1){
    	       $sppd = perjalanan_dinas::where('status_acc',0)->get();
    	       $cuti2 = cuti::where('status_acc2',0)->get();
    	       return view('index',['layout'=>'beranda','title_layout'=>'Beranda','sppd'=>$sppd->count(),'cuti2'=>$cuti2->count()]);
    	   }
    	   else if(Session::get('role')==5){
    	       $id=array();
    	       $spd = surat_perjalanan_dinas::all();
    	       foreach ($spd as $key => $value) {
                    array_push($id,$value->id_perjalanan_dinas);
               }
               $sppd = perjalanan_dinas::whereNotIn('id',$id)->get();
    	       return view('index',['layout'=>'beranda','title_layout'=>'Beranda','spd'=>$sppd->count()]);
    	   }
    	   else if(Session::get('role')==6){
    	       $id=array();
    	       $kwitansi = kwitansi_sppd::all();
    	       foreach ($kwitansi as $key => $value) {
                    array_push($id,$value->id_perjalanan_dinas);
               }
    	       $sppd = perjalanan_dinas::whereNotIn('id',$id)->get();    
    	       return view('index',['layout'=>'beranda','title_layout'=>'Beranda','bendahara'=>$sppd->count()]);
    	   }
    	   else if(Session::get('role')==7){
    	       $kwitansi = kwitansi_sppd::where('tanda_tangan_admin1','!=',null)->where('tanda_tangan_admin2',null)->get();
    	       return view('index',['layout'=>'beranda','title_layout'=>'Beranda','kwitansi'=>$kwitansi->count()]);
    	   }
    	   else if(Session::get('role')==8){
    	       $kendaraan = pinjam_kendaraan::where('status_acc',0)->get();
    	       $cuti1 = cuti::where('status_acc1',0)->get();
    	       return view('index',['layout'=>'beranda','title_layout'=>'Beranda','kendaraan'=>$kendaraan->count(),'cuti1'=>$cuti1->count()]);
    	   }
    	   else if(Session::get('role')==9){
    	       $upg = laporan_upg::where('status',0)->get();
    	       return view('index',['layout'=>'beranda','title_layout'=>'Beranda','upg'=>$upg->count()]);
    	   }
    	   else{
    	       return view('index',['layout'=>'beranda','title_layout'=>'Beranda']);
    	   }
        }
        else{
            return redirect('/');
        }
    }

    function filemanager(){
        if(Session::has('isLogin'))
           return view('index',['layout'=>'filemanager','title_layout'=>'File Manager']);
        else
            return redirect('/'); 
    }
    
    function pengajuan_perjalanan_dinas(){
    	if(Session::has('isLogin')){
            $datas = array();
        	$list = perjalanan_dinas::all();
        	
        	for ($i=0; $i < $list->count(); $i++) {
                
                $arr = [
                    "id"=>$list[$i]->id,
        			"nomor_perjalanan_dinas"=>$list[$i]->nomor_perjalanan_dinas,
                    "pemohon"=>$this->getPengguna($list[$i]->id_pemohon),
                    "penanggung_jawab"=>$this->getPengguna($list[$i]->id_penanggung_jawab),
        			"judul_kegiatan"=>$list[$i]->judul_kegiatan,
        			"menugaskan"=>$this->getMenugaskan($list[$i]->id),
        			"tujuan"=>$list[$i]->tujuan->tujuan,
        			"maksud_perjalanan"=>$list[$i]->maksud_perjalanan,
        			"tanggal"=>Carbon::parse($list[$i]->tanggal)->formatLocalized("%A, %d %B %Y"),
        			"lama_perjalanan"=>$list[$i]->lama_perjalanan,
        			"kegiatan"=>$list[$i]->Pagu_Anggaran->nama_kegiatan,
        			"kendaraan"=>$list[$i]->namakendaraan,
        			"surat_tugas"=>$list[$i]->surat_tugas,
        			"pagu_anggaran"=>$list[$i]->pagu_anggaran,
        			"biaya_telah_digunakan"=>$list[$i]->biaya_telah_digunakan,
        			"biaya_akan_digunakan"=>$list[$i]->biaya_akan_digunakan,
        			// "verifikator"=>$list[$i]->verifikator,
                    "status_acc"=>$list[$i]->status_acc,
        		];	
        		array_push($datas, $arr);
        	}
        	return view('index',['layout'=>'pengajuan_perjalanan_dinas','title_layout'=>'Laporan Pengajuan Perjalanan Dinas','datas'=>$datas]);
        }
        else{
            return redirect('/');
        }
    }
    //clear, email ok
    function status_pengajuan_perjalanan_dinas($status,$id){
        if(Session::has('isLogin')){
            $data_admin    = data_user::find(Session::get('id'));
            $jabatan_admin = ($data_admin==null? "Kuasa Pengguna Anggaran":$data_admin->Jabatan->jabatan);

            if($status=="reject"){
                $status = -1;    
                $respon_pesan = " telah ditolak oleh $jabatan_admin";
            }
            else if($status=="acc"){
                $status = 1;
                $respon_pesan = " telah diterima oleh $jabatan_admin";   
            }
            else{
                $status = -2;
                $respon_pesan = " telah ditolak oleh $jabatan_admin dikarenakan data yang diajukan belum benar";
            }

            $perjalanan_dinas = perjalanan_dinas::find($id);
            if($perjalanan_dinas != null){
                $perjalanan_dinas->status_acc = $status;
                if($status==1)
                    $perjalanan_dinas->tanda_tangan = Session::get('id');
                
                if($perjalanan_dinas->save()){
                    //$id_user                = $perjalanan_dinas->id_penanggung_jawab;
                    $id_user                = $perjalanan_dinas->id_pemohon;
                    $nomor_laporan          = $perjalanan_dinas->nomor_perjalanan_dinas;
                    $data_user              = data_user::where('id_user',$id_user)->first();
                    $data_akun_user         = User::find($id_user);
                    $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                    $email_user             = ($data_akun_user==null? "":$data_akun_user->email);

                    if( $email_user != "" || $email_user != null ){
                        $pesan = "Yth.$nama_user<br>
                                    permohonan perjalanan dinas nomor $nomor_laporan $respon_pesan.<br>
                                    Klik <a href='".url("/download/sppd/$id")."'>unduh</a> untuk mendapatkan surat pengajuan perjalanan dinas.";
                        if($perjalanan_dinas->surat_tugas==1){
                            $pesan .= "<br>
                                  Klik <a href='".url("/download/surat_tugas/$id")."'>unduh</a> untuk mendapatkan surat tugas."; 
                        }

                        //$pesan = "hai ".$nama_user.", nomor perjalanan dinas ".$nomor_laporan.$respon_pesan;
                        $this->kirim_notif($nama_user,$email_user,$pesan);
                        if($status==1 || $status=='acc'){
                            //kirim notif ke admin spd
                            $data_admin_spd = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 5)
                                                // ->where('data_user.id_jabatan', 23)
                                                ->where('data_user.status',1);
                                          })->get();

                            if($data_admin_spd->count()>0){
                                foreach ($data_admin_spd as $data_admin_spd => $x) {
                                    $id_admin           = $x->id_user;
                                    $nama_admin         = $x->nama;
                                    $jabatan_admin      = $x->Jabatan->jabatan;
                                    $data_akun_admin    = User::find($id_admin);

                                    if($data_akun_admin != null){
                                        $email_admin = $data_akun_admin->email;
                                        if( $email_admin != null || $email_admin != '' ){
                                            $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                                        berikut saya sampaikan pengajuan perjalanan dinas atas nama $nama_user dengan nomor $nomor_laporan mohon dibuatkan surat perjalanan dinas";

                                            //$pesan = "hai ".$nama_admin.", hari ini laporan surat pengajuan perjalanan dinas ".$nama_user." dengan nomor laporan ".$nomor_laporan." telah diterima oleh Kuasa Pengguna Anggaran, mohon dibuat surat perjalanan dinasnya";
                                            $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    return redirect('/admin/pengajuan_perjalanan_dinas')->with('type_msg',1)->with('msg','Berhasil Simpan');
                }
                else{
                    return redirect('/admin/pengajuan_perjalanan_dinas')->with('type_msg',0)->with('msg','Gagal Simpan');
                }
            }
            else{
                return redirect('/admin/pengajuan_perjalanan_dinas')->with('type_msg',0)->with('msg','Data Tidak Ditemukan');
            }
        }
        else{
            return redirect('/');
        }
    }
    function download_cetak_sppd($id){
        $item = perjalanan_dinas::find($id);
        
        $data_admin = data_user::where('id_user',$item->tanda_tangan)->first();
        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        $data_user = data_user::where('id_user',$item->id_penanggung_jawab)->first();
        if($data_user != null){
            $nip                = $data_user->nip;
            $nama               = $data_user->nama;
            $tanda_tangan       = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nip                = "N/a";
            $nama               = "N/a";
            $tanda_tangan       = "no_signature.jpg";
        }
        
        $pemohon = data_user::where('id_user',$item->id_pemohon)->first();
        $pemohon = ($pemohon==null? "Na":$pemohon->nama);
        
        $nomor_laporan = $item->nomor_perjalanan_dinas;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'penanggung_jawab'  =>$nama,
            'judul'             =>$item->judul_kegiatan,
            'menugaskan'        =>array_column($this->getMenugaskan($item->id),'nama'),
            'tujuan'            =>($item->id_tujuan==null? "N/a":$item->tujuan->tujuan),
            'maksud_perjalanan' =>$item->maksud_perjalanan,
            'tanggal_berangkat' =>Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y"),
            'tanggal_kembali'   =>Carbon::parse($item->tanggal)->addDays($item->lama_perjalanan-1)->formatLocalized("%A, %d %B %Y"),
            'kegiatan'          =>($item->kegiatan==null? "N/a":$item->Pagu_Anggaran->nama_kegiatan),
            'jenis_kendaraan'   =>$item->kendaraan,
            'tanda_tangan'      => array(
                'admin'     => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'pengaju'   => array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            ),
            'pagu_anggaran'         =>number_format($item->pagu_anggaran,0,'','.'),
            'biaya_telah_digunakan' =>number_format($item->biaya_telah_digunakan,0,'','.'),
            'biaya_akan_digunakan'  =>number_format($item->biaya_akan_digunakan,0,'','.'),
            'sisa_anggaran'         =>number_format($item->pagu_anggaran-$item->biaya_telah_digunakan-$item->biaya_akan_digunakan,0,'','.'),
            // 'verifikator'           =>$item->verifikator,
        ];
    
        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_pengajuan_perjalanan_dinas','data'=>$arr]);
        $html .= $pdf->render();
        $download = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->download("surat pengajuan perjalanan dinas ($pemohon - $nomor_laporan - $tgl).pdf");
        return $download;
    }
    function download_cetak_surat_tugas($id){
        $item = perjalanan_dinas::find($id);
        
        $data_admin = data_user::where('id_user',$item->tanda_tangan)->first();
        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        $data_user = data_user::where('id_user',$item->id_penanggung_jawab)->first();
        if($data_user != null){
            $nip                = $data_user->nip;
            $nama               = $data_user->nama;
            $tanda_tangan       = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nip                = "N/a";
            $nama               = "N/a";
            $tanda_tangan       = "no_signature.jpg";
        }

        $pemohon = data_user::where('id_user',$item->id_pemohon)->first();
        $pemohon = ($pemohon==null? "Na":$pemohon->nama);
        
        $nomor_laporan = $item->nomor_perjalanan_dinas;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'penanggung_jawab'  =>$nama,
            'judul'             =>$item->judul_kegiatan,
            'menugaskan'        =>$this->getMenugaskan($item->id),
            'tujuan'            =>($item->id_tujuan==null? "N/a":$item->tujuan->tujuan),
            'maksud_perjalanan' =>$item->maksud_perjalanan,
            'tanggal'           =>Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y"),
            'lama'              =>$item->lama_perjalanan,
            'kegiatan'          =>$item->kegiatan,
            'jenis_kendaraan'   =>$item->kendaraan,
            'tanda_tangan'      => array(
                'admin'     => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'pengaju'   => array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            )
        ];

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_surat_tugas','data'=>$arr]);
        $html .= $pdf->render();
        $download = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->download("surat tugas ($pemohon - $nomor_laporan - $tgl).pdf");
        return $download;
    }

    function pinjam_kendaraan(){
        if(Session::has('isLogin')){
            $data       = array();
            $pinjam_kendaraan = pinjam_kendaraan::all();
            for ($i=0; $i < $pinjam_kendaraan->count(); $i++) { 
                if($pinjam_kendaraan[$i]->id_perjalanan_dinas!=null){
                    $surat_perjalanan_dinas = array(
                        "id_perjalanan_dinas" => $pinjam_kendaraan[$i]->perjalanan_dinas->id,
                        "nomor_perjalanan_dinas" => $pinjam_kendaraan[$i]->perjalanan_dinas->nomor_perjalanan_dinas,
                        "status_perjalanan_dinas" => $pinjam_kendaraan[$i]->perjalanan_dinas->status_acc,
                    );
                }
                else{
                    $surat_perjalanan_dinas = null;   
                }

                $arr = [
                    "id"                        => $pinjam_kendaraan[$i]->id,
                    "peminjam"                  => ($pinjam_kendaraan[$i]->id_peminjam==null?null:$this->getPengguna($pinjam_kendaraan[$i]->id_peminjam)),
                    "jenis_kendaraan"           => $pinjam_kendaraan[$i]->jenis_kendaraan,
                    "keperluan"                 => $pinjam_kendaraan[$i]->keperluan,
                    "tujuan"                    => $pinjam_kendaraan[$i]->tujuan,
                    "tanggal"                   => Carbon::parse($pinjam_kendaraan[$i]->tanggal)->formatLocalized("%A, %d %B %Y"),
                    "jam"                       => $pinjam_kendaraan[$i]->jam,
                    "lama"                      => $pinjam_kendaraan[$i]->lama_keperluan,
                    "pengemudi"                 => $this->getPengemudi($pinjam_kendaraan[$i]->id),
                    "penumpang"                 => $this->getPenumpang($pinjam_kendaraan[$i]->id),
                    "status_pinjam_kendaraan"   => $pinjam_kendaraan[$i]->status_acc,
                    "surat_perjalanan_dinas"    => $surat_perjalanan_dinas 
                ];
                array_push($data, $arr);
            }

            return view('index',['layout'=>'pinjam_kendaraan','title_layout'=>'Laporan Pinjam Kendaraan','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function acc_pinjam_kendaraan($id){
        $pinjam_kendaraan = pinjam_kendaraan::find($id);
        $peminjam = data_user::where('id_user',$pinjam_kendaraan->id_peminjam)->first();

        $data = (Object) array(
                    "id"=>$id,
                    "nomor_laporan"=>$pinjam_kendaraan->nomor_laporan,
                    "peminjam"=>($peminjam==null? "N/a":$peminjam->nama),
                    "tujuan"=> ($pinjam_kendaraan->id_tujuan==null? "N/a":$pinjam_kendaraan->Tujuan->tujuan)
                );
        
        $pengemudi = pengemudi::where('status',1)->get();
        $data_pengemudi = array();
        foreach ($pengemudi as $key => $value) {
            $pengemudi_ = data_user::where('id_user',$value->id_user)->first();
            if($pengemudi_!=null){
                $arr = [
                         "id"=>$value->id,
                         "nama"=>$pengemudi_['nama']
                       ];

                array_push($data_pengemudi,$arr);            
            }
        }

        return view('index',['layout'=>'acc_pinjam_kendaraan','title_layout'=>'Acc Laporan Pinjam Kendaraan','data'=>$data, 'data_pengemudi'=>$data_pengemudi]);
    }
    function edit_pinjam_kendaraan($id){
        $pinjam_kendaraan = pinjam_kendaraan::find($id);

        $peminjam = data_user::where('id_user',$pinjam_kendaraan->id_peminjam)->first();
        $pinjam_kendaraan_pengemudi = pinjam_kendaraan_pengemudi::where('id_pinjam_kendaraan',$id)->get();
        
        $pengemudi = array();
        foreach ($pinjam_kendaraan_pengemudi as $key => $value) {
            $pengemudi_ = data_user::where('id_user',$value->Pengemudi->id_user)->first();
            $arr = [
                    "id"=>$value->id_pengemudi,
                    "nama"=>$pengemudi_['nama']
            ];

            array_push($pengemudi,$arr);
         } 


        $data = (Object) array(
                    "id"=>$id,
                    "nomor_laporan"=>$pinjam_kendaraan->nomor_laporan,
                    "peminjam"=>($peminjam==null? "N/a":$peminjam->nama),
                    "tujuan"=> ($pinjam_kendaraan->id_tujuan==null? "N/a":$pinjam_kendaraan->Tujuan->tujuan),
                    "pengemudi" => $pengemudi
                );
        
        $pengemudi = pengemudi::where('status',1)->get();
        $data_pengemudi = array();
        foreach ($pengemudi as $key => $value) {
            $pengemudi_ = data_user::where('id_user',$value->id_user)->first();
            if($pengemudi_!=null){
                $arr = [
                         "id"=>$value->id,
                         "nama"=>$pengemudi_['nama']
                       ];

                array_push($data_pengemudi,$arr);            
            }
        }

        return view('index',['layout'=>'edit_pinjam_kendaraan','title_layout'=>'Edit Laporan Pinjam Kendaraan','data'=>$data, 'data_pengemudi'=>$data_pengemudi]);
    }
    //email x
    function store_pinjam_kendaraan(Request $req,$id){
        $pengemudi = $req->pengemudi;
        $data_admin    = data_user::find(Session::get('id'));
        $jabatan_admin = ($data_admin==null? "Kepala Subbag TU":$data_admin->Jabatan->jabatan);
        // if(count($pengemudi)>0){
        //     $pengemudi=array_unique($pengemudi);
        // }
        
        $data = array();
        foreach ($pengemudi as $value) {
           array_push($data, array('id_pinjam_kendaraan'=>$id,'id_pengemudi'=>$value,'accept'=>0,'income_device_owner'=>0));
        }

        $save = json_decode($this->multiInsertKendaraan($data));
        if($save->status==1){
            $pinjam_kendaraan = pinjam_kendaraan::find($save->id);
            $pinjam_kendaraan->status_acc = 1;
            $pinjam_kendaraan->tanda_tangan = Session::get('id');
            $pinjam_kendaraan->save();

            $id_user                = $pinjam_kendaraan->id_peminjam;
            $nomor_laporan          = $pinjam_kendaraan->nomor_laporan;
            $data_user              = data_user::where('id_user',$id_user)->first();
            $data_akun_user         = User::find($id_user);
            $nama_user              = ($data_user==null? "N/a":$data_user->nama);
            $email_user             = ($data_akun_user==null? "":$data_akun_user->email);

            if( $email_user != "" || $email_user != null ){
                $pesan = "Yth.$nama_user
                            permohonan pinjam kendaraan dengan nomor $nomor_laporan telah diterima $jabatan_admin.<br>
                            Klik <a href='".url("/download/kendaraan/$id")."'>unduh</a> untuk mendapatkan surat pinjam kendaraan.";
                //$pesan = "hai ".$nama_user.", nomor laporan upg ".$nomor_laporan.$respon_pesan;
                $this->kirim_notif($nama_user,$email_user,$pesan);
            }

            return redirect('/admin/pinjam_kendaraan')->with('type_msg',1)->with('msg','Berhasil simpan');  
        }
        else{
            return redirect('/admin/pinjam_kendaraan')->with('type_msg',0)->with('msg','Gagal simpan');
        }
    }
    function update_pinjam_kendaraan(Request $req,$id){
        $pengemudi = $req->pengemudi;
        // if(count($pengemudi)>0){
        //     $pengemudi=array_unique($pengemudi);
        // }

        $data = array();
        foreach ($pengemudi as $value) {
           array_push($data, array('id_pinjam_kendaraan'=>$id,'id_pengemudi'=>$value,'accept'=>0,'income_device_owner'=>0));
        }

        $pengemudi_lama = pinjam_kendaraan_pengemudi::where('id_pinjam_kendaraan',$id);
        if($pengemudi_lama->delete()){
            $update = json_decode($this->multiInsertKendaraan($data));
            if($update->status==1){
                $pinjam_kendaraan = pinjam_kendaraan::find($update->id);
                $pinjam_kendaraan->status_acc = 1;
                $pinjam_kendaraan->tanda_tangan = Session::get('id');
                $pinjam_kendaraan->save();
                return redirect('/admin/pinjam_kendaraan')->with('type_msg',1)->with('msg','Berhasil simpan');  
            }
            else{
                return redirect('/admin/pinjam_kendaraan')->with('type_msg',0)->with('msg','Gagal simpan');
            }
        }
        else{
            return redirect('/admin/pinjam_kendaraan')->with('type_msg',0)->with('msg','Gagal simpan');
        }
    }
    function multiInsertKendaraan($datas){
        $id_pinjam_kendaraan = null;
        $success=0;
        foreach ($datas as $data) {
            $pinjam_kendaraan_pengemudi                         = new pinjam_kendaraan_pengemudi();
            $pinjam_kendaraan_pengemudi->id_pinjam_kendaraan    = $data['id_pinjam_kendaraan'];
            $pinjam_kendaraan_pengemudi->id_pengemudi           = $data['id_pengemudi'];
            $pinjam_kendaraan_pengemudi->accept                 = $data['accept'];
            $pinjam_kendaraan_pengemudi->income_device_owner    = $data['income_device_owner'];
            if($pinjam_kendaraan_pengemudi->save()){
                $success+=1;
            }
            
            $id_pinjam_kendaraan = $pinjam_kendaraan_pengemudi->id_pinjam_kendaraan;
        }
        return json_encode(array("status"=>($success==count($datas)? 1:0),"id"=>$id_pinjam_kendaraan));
    }
    //clear, email x
    function status_pinjam_kendaraan($status,$id){
        if(Session::has('isLogin')){
            $data_admin    = data_user::find(Session::get('id'));
            $jabatan_admin = ($data_admin==null? "Kepala Subbag TU":$data_admin->Jabatan->jabatan);

            if($status=="reject"){
                $status = -1;    
                $respon_pesan = " telah ditolak $jabatan_admin";
            }
            // else if($status=="acc"){
            //     $status = 1;
            //     $respon_pesan = " telah diterima $jabatan_admin";   
            // }
            else{
                $status = -2;
                $respon_pesan = " telah ditolak $jabatan_admin dikarenakan data yang diajukan belum benar";
            }

            $pinjam_kendaraan = pinjam_kendaraan::find($id);
            if($pinjam_kendaraan != null){//check data
                $pinjam_kendaraan->status_acc = ($status=="reject"? "-1":"-2" );
                if($pinjam_kendaraan->save()){
                    $id_user                = $pinjam_kendaraan->id_peminjam;
                    $nomor_laporan          = $pinjam_kendaraan->nomor_laporan;
                    $data_user              = data_user::where('id_user',$id_user)->first();
                    $data_akun_user         = User::find($id_user);
                    $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                    $email_user             = ($data_akun_user==null? "":$data_akun_user->email);

                    if( $email_user != "" || $email_user != null ){
                        $pesan = "Yth.$nama_user<br>
                                    permohonan pinjam kendaraan dengan nomor $nomor_laporan $respon_pesan.";
                        //$pesan = "hai ".$nama_user.", nomor laporan upg ".$nomor_laporan.$respon_pesan;
                        $this->kirim_notif($nama_user,$email_user,$pesan);
                    }

                    return redirect('/admin/pinjam_kendaraan')->with('type_msg',1)->with('msg','Berhasil simpan');    
                }
                else{
                    return redirect('/admin/pinjam_kendaraan')->with('type_msg',0)->with('msg','Gagal simpan');    
                }
            }
            else{
                return redirect('/admin/pinjam_kendaraan')->with('type_msg',0)->with('msg','Data tidak ditemukan');
            }   
        }
        else{
            return redirect('/');
        }
    } 

    function download_cetak_pinjam_kendaraan($id){
        $item = pinjam_kendaraan::find($id);
        
        $data_admin = data_user::where('id_user',$item->tanda_tangan)->first();
        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        $data_user = data_user::where('id_user',$item->id_peminjam)->first();
        if($data_user != null){
            $nip            = $data_user->nip;
            $nama           = $data_user->nama;
            $pangkat        = $data_user->pangkat->pangkat;
            $golongan       = $data_user->golongan->golongan;
            $tanda_tangan   = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nip            = "N/a";
            $nama           = "N/a";
            $pangkat        = "N/a";
            $golongan       = "N/a";
            $tanda_tangan   = "no_signature.jpg";
        }

        $nomor_laporan = $item->nomor_laporan;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'nama'                  => $nama,
            'pangkat'               => $pangkat,
            'subbag'                => $golongan,
            'jenis_kendaraan'       => $item->jenis_kendaraan,
            'penumpang'             => implode(',', $this->getPenumpangShortList($item->id)),
            'keperluan'             => $item->keperluan,
            'tujuan'                => ($item->id_tujuan==null? "N/a":$item->tujuan->tujuan),
            'jam_berangkat'         => $item->jam,
            'tanggal_berangkat'     => Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y"),
            'lama_keperluan'        => $item->lama_keperluan." hari",
            'nama_pengemudi'        => implode(',', array_column($this->getPengemudi($item->id),'nama')),
            'jenis_kendaaraan'      => implode(',', array_column($this->getPengemudi($item->id),'jenis_kendaraan')),
            'no_polisi'             => implode(',', array_column($this->getPengemudi($item->id),'no_polisi')),
            'create'                => Carbon::parse($item->created_at)->formatLocalized("%A, %d %B %Y %H:%M:%S"),
            'tanda_tangan'          => array(
                'admin'=> array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'peminjam'=> array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            )
        ];

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_pinjam_kendaraan','data'=>$arr]);
        $html .= $pdf->render();
        $download = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->download("pinjam kendaraan ($nama - $nomor_laporan - $tgl).pdf");
        return $download;
    }   

    function cuti(){
        if(Session::has('isLogin')){
            $role = Session::get('role');

            $data           = array();
            if($role==8)        
                $data_laporan   = cuti::all();
            else
                $data_laporan   = cuti::where('status_acc1',1)->get();

            for ($i=0; $i < $data_laporan->count(); $i++) { 
                $jenis_cuti = null;
                if(!$data_laporan[$i]->jenis_cuti==null){
                    $jenis_cuti = array(
                        'id'    =>$data_laporan[$i]->jenis_cuti->id,
                        'nama'  =>$data_laporan[$i]->jenis_cuti->nama,
                        'img'   =>$data_laporan[$i]->jenis_cuti->img
                    );
                }

                $arr = [
                    "id"             => $data_laporan[$i]->id,
                    "nomor_cuti"     => $data_laporan[$i]->nomor_laporan,
                    "pengguna"       => ($data_laporan[$i]->id_user==null?null:$this->getPengguna($data_laporan[$i]->id_user)),
                    "jenis_cuti"     => $jenis_cuti,
                    "alasan"         => $data_laporan[$i]->alasan,
                    "tanggal"        => Carbon::parse($data_laporan[$i]->tanggal)->formatLocalized("%A, %d %B %Y"),
                    "lama"           => ($data_laporan[$i]->cuti_n+$data_laporan[$i]->cuti_n1+$data_laporan[$i]->cuti_n2),
                    // "keterangan"     => $data_laporan[$i]->keterangan,
                    "alamat_cuti"    => $data_laporan[$i]->alamat_cuti,
                    "telp"           => $data_laporan[$i]->telp,
                    "status_acc1"    => $data_laporan[$i]->status_acc1,
                    "catatan_acc1"   => $data_laporan[$i]->catatan_acc1,
                    "status_acc2"    => $data_laporan[$i]->status_acc2,
                    "catatan_acc2"   => $data_laporan[$i]->catatan_acc2,
                ];
                array_push($data, $arr);
            }

            return view('index',['layout'=>'cuti','title_layout'=>'Laporan Cuti','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //clear, email ok
    function status_cuti_0(Request $req){
        if(Session::has('isLogin')){
            $role = Session::get('role');

            $cuti = cuti::find($req->id);
            if($cuti != null){
                if($role==8){      
                    $cuti->status_acc1 = $req->status;
                    $cuti->catatan_acc1 = $req->alasan;

                    $data_admin    = data_user::find(Session::get('id'));
                    $jabatan_admin = ($data_admin==null? "Kepala Subbag TU":$data_admin->Jabatan->jabatan);
                
                    if($cuti->save()){
                        $id_user                = $cuti->id_user;
                        $nomor_laporan          = $cuti->nomor_laporan;
                        $data_user              = data_user::where('id_user',$id_user)->first();
                        $data_akun_user         = User::find($id_user);
                        $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                        $email_user             = ($data_akun_user==null? "":$data_akun_user->email);
                        $alasan                 = $cuti->catatan_acc1;
                        $status_acc1            = $cuti->status_acc1;

                        if( $email_user != "" || $email_user != null ){
                            if($status_acc1 == -1){
                                $pesan = "Yth.$nama_user<br>
                                            permohonan cuti nomor $nomor_laporan telah ditolak oleh $jabatan_admin dengan alasan $alasan";
                                //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." telah ditolak dan diminta perubahan oleh Kepala Subbag TU dengan alasan '".$alasan."'";
                            }
                            else if($status_acc1 == -2){
                                $pesan = "Yth.$nama_user<br>
                                            permohonan cuti nomor $nomor_laporan telah ditangguhkan oleh $jabatan_admin dengan alasan $alasan";
                                //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." telah ditangguhkan oleh Kepala Subbag TU dengan alasan '".$alasan."'";
                            }
                            else{
                                $pesan = "Yth.$nama_user<br>
                                            permohonan cuti nomor $nomor_laporan tidak disetujui oleh $jabatan_admin dengan alasan $alasan";
                                //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." tidak disetujui oleh Kepala Subbag TU dengan alasan '".$alasan."'";
                            }
                            $this->kirim_notif($nama_user,$email_user,$pesan);
                        }

                        return redirect('/admin/cuti')->with('type_msg',1)->with('msg','Berhasil Simpan');
                    }
                    else{
                        return redirect('/admin/cuti')->with('type_msg',0)->with('msg','Gagal Simpan');
                    }
                }
                else{
                    $cuti->status_acc2 = $req->status;
                    $cuti->catatan_acc2 = $req->alasan;

                    $data_admin    = data_user::find(Session::get('id'));
                    $jabatan_admin = ($data_admin==null? "Kepala Balai":$data_admin->Jabatan->jabatan);

                    if($cuti->save()){
                        //kirim notif ke user
                        $id_user                = $cuti->id_user;
                        $nomor_laporan          = $cuti->nomor_laporan;
                        $data_user              = data_user::where('id_user',$id_user)->first();
                        $data_akun_user         = User::find($id_user);
                        $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                        $email_user             = ($data_akun_user==null? "":$data_akun_user->email);
                        $alasan                 =  $cuti->catatan_acc2;
                        $status_acc2            = $cuti->status_acc2;
                        if( $email_user != "" || $email_user != null ){
                            if($status_acc2 == -1){
                                $pesan = "Yth.$nama_user<br>
                                            permohonan cuti nomor $nomor_laporan telah ditolak oleh $jabatan_admin dengan alasan $alasan";
                                //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." telah ditolak dan diminta perubahan oleh Kepala Balai dengan alasan '".$alasan."'";
                            }
                            else if($status_acc2 == -2){
                                $pesan = "Yth.$nama_user<br>
                                            permohonan cuti nomor $nomor_laporan telah ditangguhkan oleh $jabatan_admin dengan alasan $alasan";
                                //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." telah ditangguhkan oleh Kepala Balai dengan alasan '".$alasan."'";
                            }
                            else{
                                $pesan = "Yth.$nama_user<br>
                                            permohonan cuti nomor $nomor_laporan tidak disetujui oleh $jabatan_admin dengan alasan $alasan";
                                //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." tidak disetujui oleh oleh Kepala Balai dengan alasan '".$alasan."'";
                            }
                            $this->kirim_notif($nama_user,$email_user,$pesan);
                        }
                        //kirim notif ke admin 1
                        $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 8)
                                                // ->where('data_user.id_jabatan', 26)
                                                ->where('data_user.status',1);
                                          })->get();
                        
                        //data_user::where('id_jabatan',26)->get();
                        if($data_admin->count()>0){
                            foreach ($data_admin as $data_admin => $item) {
                                $id_admin           = $item->id_user;
                                $nama_admin         = $item->nama;
                                $jabatan_admin      = $item->Jabatan->jabatan;
                                $nomor_laporan      = $cuti->nomor_laporan;
                                $data_akun_admin    = User::find($id_admin);
                                if($data_akun_admin != null){
                                    $email_admin = $data_akun_admin->email;
                                    if( $email_admin != null || $email_admin != '' ){
                                        if($status_acc2 == -1){
                                            $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                                        berikut saya sampaikan pengajuan cuti atas nama $nama_user dengan nomor $nomor_laporan telah ditolak dengan alasan $alasan";
                                            //$pesan = "hai ".$nama_admin.", laporan cuti ".$nama_user." dengan nomor laporan ".$nomor_laporan." telah ditolak dan diminta perubahan dengan alasan '".$alasan."'";
                                        }
                                        else if($status_acc2 == -2){
                                            $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                                        berikut saya sampaikan pengajuan cuti atas nama $nama_user dengan nomor $nomor_laporan telah ditangguhkan dengan alasan $alasan";
                                            //$pesan = "hai ".$nama_admin.", laporan cuti ".$nama_user." dengan nomor laporan ".$nomor_laporan." telah ditangguhkan dengan alasan '".$alasan."'";
                                        }
                                        else{
                                            $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                                        berikut saya sampaikan pengajuan cuti atas nama $nama_user dengan nomor $nomor_laporan tidak disetujui dengan alasan $alasan";
                                            //$pesan = "hai ".$nama_admin.", laporan cuti ".$nama_user." dengan nomor laporan ".$nomor_laporan." telah ditolak/tidak disetujui dengan alasan '".$alasan."'";
                                        }
                                        $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                    }
                                }
                            }
                        }

                        return redirect('/admin/cuti')->with('type_msg',1)->with('msg','Berhasil Simpan');
                    }
                    else{
                        return redirect('/admin/cuti')->with('type_msg',0)->with('msg','Gagal Simpan');
                    }
                }
            }
            else{
                return redirect('/admin/cuti')->with('type_msg',0)->with('msg','Data Tidak Ditemukan');
            }
        }
        else{
            return redirect('/');     
        }
    }//untuk selain acc
    function status_cuti_1($status,$id){
        if(Session::has('isLogin')){
            $role = Session::get('role');

            $cuti = cuti::find($id);
            if($cuti != null){
                if($role==8){      
                    $data_admin    = data_user::find(Session::get('id'));
                    $jabatan_admin = ($data_admin==null? "Kepala Subbag TU":$data_admin->Jabatan->jabatan);

                    $cuti->status_acc1 = $status;
                    $cuti->catatan_acc1 = null;
                    $cuti->tanda_tangan_admin1 = Session::get('id');
                    if($cuti->save()){
                        //kirim notif ke user
                        $id_user                = $cuti->id_user;
                        $nomor_laporan          = $cuti->nomor_laporan;
                        $data_user              = data_user::where('id_user',$id_user)->first();
                        $data_akun_user         = User::find($id_user);
                        $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                        $email_user             = ($data_akun_user==null? "":$data_akun_user->email);

                        if( $email_user != "" || $email_user != null ){
                            $pesan  = "Yth.$nama_user<br>
                                            permohonan cuti nomor $nomor_laporan telah diterima oleh $jabatan_admin.";
                            //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." telah diterima oleh Kepala Subbag TU, sekarang tinggal menunggu diterima olah Kepala Balai";
                            $this->kirim_notif($nama_user,$email_user,$pesan);
                        }
                        //kirim notif ke admin 2
                        $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 1)
                                                // ->where('data_user.id_jabatan', 24)
                                                ->where('data_user.status',1);
                                          })->get();

                        //data_user::where('id_jabatan',24)->get();
                        if($data_admin->count()>0){
                            foreach ($data_admin as $data_admin => $item) {
                                $id_admin           = $item->id_user;
                                $nama_admin         = $item->nama;
                                $jabatan_admin      = $item->Jabatan->jabatan;
                                $nomor_laporan      = $cuti->nomor_laporan;
                                $data_akun_admin    = User::find($id_admin);

                                if($data_akun_admin != null){
                                    $email_admin = $data_akun_admin->email;
                                    if( $email_admin != null || $email_admin != '' ){
                                        $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                                    berikut saya sampaikan pengajuan cuti atas nama $nama_user dengan nomor $nomor_laporan mohon diverifikasi";
                                        //$pesan = "hai ".$nama_admin.", hari ini ada yang mengajukan laporan cuti dari ".$nama_user." dengan nomor laporan ".$nomor_laporan." dan laporannya sudah diterima oleh Kepala Subbag TU. mohon diverifikasi laporannya.";
                                        $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                    }
                                }
                            }
                        }                        

                        return redirect('/admin/cuti')->with('type_msg',1)->with('msg','Berhasil Simpan');
                    }
                    else{
                        return redirect('/admin/cuti')->with('type_msg',0)->with('msg','Gagal Simpan');
                    }
                }
                else{
                    $data_admin    = data_user::find(Session::get('id'));
                    $jabatan_admin = ($data_admin==null? "Kepala Balai":$data_admin->Jabatan->jabatan);

                    $cuti->status_acc2 = $status;
                    $cuti->catatan_acc2 = null;
                    $cuti->tanda_tangan_admin2 = Session::get('id');
                    if($cuti->save()){
                        $id_user                = $cuti->id_user;
                        $nomor_laporan          = $cuti->nomor_laporan;
                        $data_user              = data_user::where('id_user',$id_user)->first();
                        $data_akun_user         = User::find($id_user);
                        $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                        $email_user             = ($data_akun_user==null? "":$data_akun_user->email);

                        if( $email_user != "" || $email_user != null ){
                            $pesan = "Yth.$nama_user
                                        permohonan cuti nomor $nomor_laporan telah diterima oleh $jabatan_admin.<br>
                                        Klik <a href='".url("/download/cuti/$id")."'>unduh</a> untuk mendapatkan surat cuti.";
                            //$pesan = "hai ".$nama_user.", nomor laporan cuti ".$nomor_laporan." telah diterima oleh Kepala Subbag TU dan Kepala Balai, selamat anda bisa cuti sesuai yang dicantumkan.";
                            $this->kirim_notif($nama_user,$email_user,$pesan);
                        }

                        return redirect('/admin/cuti')->with('type_msg',1)->with('msg','Berhasil Simpan');
                    }
                    else{
                        return redirect('/admin/cuti')->with('type_msg',0)->with('msg','Gagal Simpan');
                    }
                }
            }
            else{
                return redirect('/admin/cuti')->with('type_msg',0)->with('msg','Data Tidak Ditemukan');
            }
        }
        else{
            return redirect('/');     
        }
    }//untuk acc
    function download_cetak_cuti($id){
        $data_cuti = cuti::find($id);
        $pengguna = $this->getPengguna($data_cuti->id_user);
        $total = $data_cuti->cuti_n+$data_cuti->cuti_n1+$data_cuti->cuti_n2;

        $data_admin1 = data_user::where('id_user',$data_cuti->tanda_tangan_admin1)->first();
        if($data_admin1 != null){
            $nip_admin1      = $data_admin1->nip;
            $nama_admin1     = $data_admin1->nama;
            $tanda_tangan1   = ($data_admin1->tanda_tangan==null? "no_signature.jpg":$data_admin1->tanda_tangan);
        }
        else{
            $nip_admin1      = "- - -";
            $nama_admin1     = "N/a";
            $tanda_tangan1   = "no_signature.jpg";
        }

        $data_admin2 = data_user::where('id_user',$data_cuti->tanda_tangan_admin2)->first();
        if($data_admin2 != null){
            $nip_admin2      = $data_admin2->nip;
            $nama_admin2     = $data_admin2->nama;
            $tanda_tangan2   = ($data_admin2->tanda_tangan==null? "no_signature.jpg":$data_admin2->tanda_tangan);
        }
        else{
            $nip_admin2      = "- - -";
            $nama_admin2     = "N/a";
            $tanda_tangan2   = "no_signature.jpg";
        }

        $nomor_laporan = $data_cuti->nomor_laporan;
        $tgl = Carbon::parse($data_cuti->tanggal)->formatLocalized("%d %B %Y");
        $nama = ($pengguna==null? "??":$pengguna['nama']);

        $data = array(
            'create'=>Carbon::parse($data_cuti->created_at)->formatLocalized("%A, %d %B %Y"),
            'nama'=>$pengguna['nama'],
            'jabatan'=>$pengguna['jabatan'],
            'unit'=>$pengguna['golongan'],
            'nip'=>$pengguna['nip'],
            'masa_kerja'=>$pengguna['masa_kerja'],
            'jenis_cuti'=>$data_cuti->id_jenis_cuti,
            'alasan'=>$data_cuti->alasan,
            'selama'=>$total,
            'alamat_cuti'=>$data_cuti->alamat_cuti,
            'telp'=>$data_cuti->telp,
            'tanggal_awal'=>Carbon::parse($data_cuti->tanggal)->formatLocalized("%A, %d %B %Y"),
            'tanggal_akhir'=>Carbon::parse($data_cuti->tanggal)->addDays($total-1)->formatLocalized("%A, %d %B %Y"),
            'data_cuti'=>[
                'n'=>$pengguna['cuti_n'],
                'n1'=>$pengguna['cuti_n1'],
                'n2'=>$pengguna['cuti_n2']
            ],
            'penerima'      => array('nama'=> $pengguna['nama'],'nip'=> $pengguna['nip'],'tanda_tangan'=>$pengguna['tanda_tangan']),
            'acc1'=>[
                'status' =>$data_cuti->status_acc1,
                'alasan' =>$data_cuti->catatan_acc1,
                'tanda_tangan' =>[
                    'nip'=>$nip_admin1,
                    'nama'=>$nama_admin1,
                    'tanda_tangan'=>$tanda_tangan1,
                ]
            ],
            'acc2'=>[
                'status' =>$data_cuti->status_acc2,
                'alasan' =>$data_cuti->catatan_acc2,
                'tanda_tangan' =>[
                    'nip'=>$nip_admin2,
                    'nama'=>$nama_admin2,
                    'tanda_tangan'=>$tanda_tangan2
                ]
            ]
        );

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_laporan_cuti','data'=>$data]);
        $html .= $pdf->render();
        $download = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->setPaper(array(0,0,609.4488,935.433), 'portrait')->download("surat cuti ($nama - $nomor_laporan - $tgl).pdf");
        return $download;
    }

    function laporan_upg(){
        if(Session::has('isLogin')){
            $data           = array();
            $data_laporan   = laporan_upg::all();

            for ($i=0; $i < $data_laporan->count(); $i++) { 
                $gratifikasi = array();
                $datas = laporan_upg_detail::where('id_laporan_upg',$data_laporan[$i]->id)->where('id_jenis_gratifikasi','!=',null)->get();
                for ($j=0; $j < $datas->count(); $j++) { 
                    $arr = [
                        'id'            =>$datas[$j]->id,
                        'nama'          =>($datas[$j]->id_jenis_gratifikasi==null?"N/a":$datas[$j]->jenis_gratifikasi->nama),
                        'keterangan'    =>$datas[$j]->keterangan
                    ];
                    array_push($gratifikasi, $arr);
                }

                $arr = [
                    "id"                        => $data_laporan[$i]->id,
                    "nomor_laporan"             => $data_laporan[$i]->nomor_laporan,
                    "pengguna"                  => ($data_laporan[$i]->id_user==null?"N/a":$this->getPengguna($data_laporan[$i]->id_user)),
                    "lokasi"                    => $data_laporan[$i]->lokasi,
                    "tanggal_mulai"             => Carbon::parse($data_laporan[$i]->tanggal)->formatLocalized("%A, %d %B %Y"),
                    "tanggal_berakhir"          => Carbon::parse($data_laporan[$i]->tanggal)->addDays($data_laporan[$i]->lama-1)->formatLocalized("%A, %d %B %Y"),
                    "honor"                     => $data_laporan[$i]->honor,
                    "pemberi"                   => $data_laporan[$i]->pemberi,
                    "gratifikasi"               => $gratifikasi,
                    "keterangan"                => $data_laporan[$i]->keterangan,
                    "hubungan_gratifikasi"      => $data_laporan[$i]->hubungan_gratifikasi,
                    "status"                    => $data_laporan[$i]->status
                ];
                array_push($data, $arr);
            }

            return view('index',['layout'=>'laporan_upg','title_layout'=>'Laporan UPG','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //clear, email ok
    function status_laporan_upg($status,$id){
        if(Session::has('isLogin')){
            $data_admin    = data_user::find(Session::get('id'));
            $jabatan_admin = ($data_admin==null? "Kepala Seksi Pelayanan":$data_admin->Jabatan->jabatan);

            if($status=="reject"){
                $status = -1;    
                $respon_pesan = " telah ditolak $jabatan_admin";
            }
            else if($status=="acc"){
                $status = 1;
                $respon_pesan = " telah diterima $jabatan_admin";   
            }
            else{
                $status = -2;
                $respon_pesan = " telah ditolak $jabatan_admin dikarenakan data yang diajukan belum benar";
            }
            
            $laporan_upg = laporan_upg::find($id);
            if($laporan_upg != null){
                $laporan_upg->status = $status;
                if($status==1)
                    $laporan_upg->tanda_tangan = Session::get('id');
                
                if($laporan_upg->save()){
                    $id_user                = $laporan_upg->id_user;
                    $nomor_laporan          = $laporan_upg->nomor_laporan;
                    $data_user              = data_user::where('id_user',$id_user)->first();
                    $data_akun_user         = User::find($id_user);
                    $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                    $email_user             = ($data_akun_user==null? "":$data_akun_user->email);

                    if( $email_user != "" || $email_user != null ){
                        $pesan = "Yth.$nama_user
                                    permohonan laporan gratifikasi dengan nomor $nomor_laporan $respon_pesan";
                        //$pesan = "hai ".$nama_user.", nomor laporan upg ".$nomor_laporan.$respon_pesan;
                        $this->kirim_notif($nama_user,$email_user,$pesan);
                    }
                    return redirect('/admin/laporan_upg')->with('type_msg',1)->with('msg','Berhasil Simpan');
                }
                else{
                    return redirect('/admin/laporan_upg')->with('type_msg',0)->with('msg','Gagal Simpan');
                }
            }
            else{
                return redirect('/admin/laporan_upg')->with('type_msg',0)->with('msg','Data Tidak Ditemukan');
            }     
        }
        else{
            return redirect('/');
        }
    }   

    function kwitansi_sppd(){
        if(Session::has('isLogin')){
           $data_kwitansi = kwitansi_sppd::all();
           $data = array();
           foreach ($data_kwitansi as $key => $value) {
                $nomor_laporan  = ($value->perjalanan_dinas->nomor_perjalanan_dinas == null? 'N/a':$value->perjalanan_dinas->nomor_perjalanan_dinas); 
                $tanggal        = $value->perjalanan_dinas->tanggal; 
                $tujuan         = ($value->perjalanan_dinas->tujuan->tujuan == null? 'N/a':$value->perjalanan_dinas->tujuan->tujuan); 
                $maksud         = $value->perjalanan_dinas->maksud_perjalanan; 
                $pagu_anggaran  = $value->perjalanan_dinas->pagu_anggaran;
                $biaya_telah_digunakan  = $value->perjalanan_dinas->biaya_telah_digunakan;
                $biaya_akan_digunakan  = $value->perjalanan_dinas->biaya_akan_digunakan;
                
                $arr = [
                    'id'                    => $value->id,
                    'id_sppd'               => $value->id_perjalanan_dinas,
                    'nomor_laporan'         => $nomor_laporan,
                    'tanggal'               => Carbon::parse($tanggal)->formatLocalized("%A, %d %B %Y"),
                    'tujuan'                => $tujuan,
                    'maksud'                => $maksud,
                    'pagu_anggaran'         => $pagu_anggaran,
                    'biaya_telah_digunakan' => $biaya_telah_digunakan,
                    'biaya_akan_digunakan'  => $biaya_akan_digunakan,
                    'transport'             => $value->transport,
                    'penginapan_makan'      => $value->penginapan_makan,
                    'biaya_rill'            => $value->biaya_rill,
                    'uang_saku'             => $value->uang_saku,
                    'status'                => $value->status
                ];
                array_push($data, $arr);
            }

           return view('index',['layout'=>'kwitansi_sppd','title_layout'=>'Kwitansi SPPD','datas'=>$data]);
        }
        else{
            return redirect('/'); 
        }
    }
    function add_kwitansi_sppd(){
        if(Session::has('isLogin')){
           $data_sppd = perjalanan_dinas::all();        
           return view('index',['layout'=>'add_kwitansi_sppd','title_layout'=>'Tambah Kwitansi SPPD','datas'=>$data_sppd]);
        }
        else{
            return redirect('/'); 
        }
    }
    function edit_kwitansi_sppd($id){
        if(Session::has('isLogin')){
           $data_sppd = perjalanan_dinas::all();
           $data_kwitansi = kwitansi_sppd::find($id);        
           return view('index',['layout'=>'edit_kwitansi_sppd','title_layout'=>'Ubah Kwitansi SPPD','kwitansi'=>$data_kwitansi,'datas'=>$data_sppd]);
        }
        else{
            return redirect('/'); 
        }
    }
    function store_kwitansi_sppd(Request $req){
        $id_perjalanan_dinas = $req->id_perjalanan_dinas;
        $transport           = $req->transport;
        $penginapan_makan    = $req->penginapan_makan;
        $biaya_rill          = $req->biaya_rill;
        $uang_saku           = $req->uang_saku;

        $kwitansi_sppd                      = new kwitansi_sppd();
        $kwitansi_sppd->id_perjalanan_dinas = $id_perjalanan_dinas;
        $kwitansi_sppd->transport           = $transport;
        $kwitansi_sppd->penginapan_makan    = $penginapan_makan;
        $kwitansi_sppd->biaya_rill          = $biaya_rill;
        $kwitansi_sppd->uang_saku           = $uang_saku;
        $kwitansi_sppd->tanda_tangan_admin1 = Session::get('id');

        if($kwitansi_sppd->save()){
            
            $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 7)
                                                // ->where('data_user.id_jabatan', 37)
                                                ->where('data_user.status',1);
                                          })->get();
            //data_user::where('id_jabatan',37)->get();
            if($data_admin->count()>0){
                foreach ($data_admin as $data_admin => $item) {
                    $id_admin           = $item->id_user;
                    $nama_admin         = $item->nama;
                    $jabatan_admin      = $item->Jabatan->jabatan;
                    $nomor_laporan      = $kwitansi_sppd->perjalanan_dinas->nomor_perjalanan_dinas;
                    //$nama_user          = $this->getPengguna($kwitansi_sppd->perjalanan_dinas->id_penanggung_jawab)['nama'];
                    $nama_user          = $this->getPengguna($kwitansi_sppd->perjalanan_dinas->id_pemohon)['nama'];
                    $data_akun_admin    = User::find($id_admin);

                    if($data_akun_admin != null){
                        $email_admin = $data_akun_admin->email;
                        if( $email_admin != null || $email_admin != '' ){
                            $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                        berikut saya sampaikan pengajuan kwitansi perjalanan dinas atas nama $nama_user dengan nomor $nomor_laporan mohon diverifikasi";
                            //$pesan = "hai ".$nama_admin.", laporan sppd dari ".$nama_user." dengan nomor laporan ".$nomor_laporan." telah di terima Kuasa Pengguna Anggaran dan laporan spd sudah dibuat Bendahara Pengeluaran. mohon diverifikasi laporannya";
                            $this->kirim_notif($nama_admin,$email_admin,$pesan);
                        }
                    }
                }
            }

            return redirect('/admin/kwitansi_sppd')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/admin/kwitansi_sppd')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_kwitansi_sppd(Request $req){
        $id                  = $req->id;
        $id_perjalanan_dinas = $req->id_perjalanan_dinas;
        $transport           = $req->transport;
        $penginapan_makan    = $req->penginapan_makan;
        $biaya_rill          = $req->biaya_rill;
        $uang_saku           = $req->uang_saku;

        $kwitansi_sppd                      = kwitansi_sppd::find($id);
        $kwitansi_sppd->id_perjalanan_dinas = $id_perjalanan_dinas;
        $kwitansi_sppd->transport           = $transport;
        $kwitansi_sppd->penginapan_makan    = $penginapan_makan;
        $kwitansi_sppd->biaya_rill          = $biaya_rill;
        $kwitansi_sppd->uang_saku           = $uang_saku;

        if($kwitansi_sppd->save()){
            return redirect('/admin/kwitansi_sppd')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/admin/kwitansi_sppd')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_kwitansi_sppd($id){
        $kwitansi_sppd = kwitansi_sppd::find($id);
        if($kwitansi_sppd->delete()){
            return redirect('/admin/kwitansi_sppd')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/admin/kwitansi_sppd')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }
    function status_kwitansi_sppd($status,$id){
        if(Session::has('isLogin')){
            $data_admin    = data_user::find(Session::get('id'));
            $jabatan_admin = ($data_admin==null? "Penjabat Pembuat Komitmen Balai Penelitian Tanaman Rempah dan Obat":$data_admin->Jabatan->jabatan);

            if($status=="reject"){
                $status = -1;    
                $respon_pesan = " telah ditolak oleh $jabatan_admin";
            }
            else if($status=="acc"){
                $status = 1;
                $respon_pesan = " telah diterima oleh $jabatan_admin";   
            }
            else{
                $status = -2;
                $respon_pesan = " telah ditolak oleh $jabatan_admin dikarenakan data yang diajukan belum benar";
            }
            
            $kwitansi_sppd = kwitansi_sppd::find($id);
            if($kwitansi_sppd != null){
                $kwitansi_sppd->status = $status;
                if($status==1)
                    $kwitansi_sppd->tanda_tangan_admin2 = Session::get('id');
                
                if($kwitansi_sppd->save()){
                    $nomor_laporan          = $kwitansi_sppd->perjalanan_dinas->nomor_perjalanan_dinas;

                    $data_user              = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 6)
                                                // ->where('data_user.id_jabatan', 34)
                                                ->where('data_user.status',1);
                                            })->first();
                    //data_user::where('id_jabatan',34)->first();
                    $data_akun_user         = User::find($data_user->id_user);
                    $nama_user              = ($data_user==null? "N/a":$data_user->nama);
                    $email_user             = ($data_akun_user==null? "":$data_akun_user->email);

                    if( $email_user != "" || $email_user != null ){
                        $pesan = "Yth.$nama_user<br>
                                    permohonan kwitansi perjalanan dinas nomor $nomor_laporan $respon_pesan.<br>
                                    Klik <a href='".url("/download/kwitansi/$id")."'>unduh</a> untuk mendapatkan surat kwitansi";
                        //$pesan = "hai ".$nama_user.", surat kwitansi untuk laporan sppd dengan nomor ".$nomor_laporan.$respon_pesan;
                        $this->kirim_notif($nama_user,$email_user,$pesan);
                    }
                    return redirect('/admin/kwitansi_sppd')->with('type_msg',1)->with('msg','Berhasil Simpan');
                }
                else{
                    return redirect('/admin/kwitansi_sppd')->with('type_msg',0)->with('msg','Gagal Simpan');
                }
            }
            else{
                return redirect('/admin/kwitansi_sppd')->with('type_msg',0)->with('msg','Data Tidak Ditemukan');
            }     
        }
        else{
            return redirect('/');
        }
    }
    function download_cetak_kwitansi_sppd($id){
        $kwitansi = kwitansi_sppd::where('id_perjalanan_dinas',$id)->first();
        $item = perjalanan_dinas::find($id);        
        $data_bendahara = data_user::where('id_user',$kwitansi->tanda_tangan_admin1)->first();
                                    // join('user', function ($join) {
                                    //             $join->on('data_user.id_user', '=', 'user.id')
                                    //             ->where('user.id_role', 6)
                                    //             // ->where('data_user.id_jabatan', 34)
                                    //             ->where('data_user.status',1);
                                    //       })->first();
        //data_user::where('id_jabatan',34)->first();
        $data_admin     = data_user::where('id_user',$kwitansi->tanda_tangan_admin2)->first();
                                    // join('user', function ($join) {
                                    //             $join->on('data_user.id_user', '=', 'user.id')
                                    //             ->where('user.id_role', 7)
                                    //             // ->where('data_user.id_jabatan', 37)
                                    //             ->where('data_user.status',1);
                                    //       })->first();
        //data_user::where('id_jabatan',37)->first();

        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        if($data_bendahara != null){
                $nip_bendahara          = $data_bendahara->nip;
                $nama_bendahara         = $data_bendahara->nama;
                $tanda_tangan_bendahara = ($data_bendahara->tanda_tangan==null? "no_signature.jpg":$data_bendahara->tanda_tangan);
        }
        else{
                $nip_bendahara          = "- - -";
                $nama_bendahara         = "N/a";
                $tanda_tangan_bendahara = "no_signature.jpg";
        }

        //$data_user = data_user::where('id_user',$item->id_penanggung_jawab)->first();
        $data_user = data_user::where('id_user',$item->id_pemohon)->first();
        $data_kwitansi = kwitansi_sppd::where('id_perjalanan_dinas',$id)->first();
        if($data_user != null){
            $nama                    = $data_user->nama;
            $nip                     = $data_user->nip;
            $tanda_tangan            = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nama                    = 'N/a';
            $tanda_tangan            = 'no_signature.jpg';
            $nip                     = '- - -';
        }

        $banyak_uang             = ($item==null? "N/a":$item->biaya_akan_digunakan);
        $nomor_perjalanan_dinas  = ($item==null? "N/a":$item->nomor_perjalanan_dinas);
        $tanggal                 = ($item==null? "N/a":Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y"));
        $tujuan                  = ($item==null? "N/a":$item->tujuan->tujuan);
        $kegiatan                = ($item==null? "N/a":$item->Pagu_Anggaran->nama_kegiatan);

        $transport               = ($data_kwitansi!=null? $data_kwitansi->transport:0);
        $penginapan_makan        = ($data_kwitansi!=null? $data_kwitansi->penginapan_makan:0);
        $biaya_rill              = ($data_kwitansi!=null? $data_kwitansi->biaya_rill:0);
        $uang_saku               = ($data_kwitansi!=null? $data_kwitansi->uang_saku:0);

        $nomor_laporan = $nomor_perjalanan_dinas;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'banyak_uang'            => "Rp ".number_format($banyak_uang,0,'','.'),
            'nomor_perjalanan_dinas' => $nomor_perjalanan_dinas,
            'tanggal'                => $tanggal,
            'tujuan'                 => $tujuan,
            'kegiatan'               => $kegiatan,
            'transport'              => "Rp ".number_format($transport,0,'','.'),
            'penginapan_makan'       => "Rp ".number_format($penginapan_makan,0,'','.'),
            'biaya_rill'             => "Rp ".number_format($biaya_rill,0,'','.'),
            'uang_saku'              => "Rp ".number_format($uang_saku,0,'','.'),
            'total'                  => "Rp ".number_format($transport+$penginapan_makan+$biaya_rill+$uang_saku,0,'','.'),
            'total_terbilang'        => $this->terbilang($transport+$penginapan_makan+$biaya_rill+$uang_saku),
            'tanda_tangan'           => array(
                'admin'     => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'bendahara' => array('nama'=> $nama_bendahara,'nip'=> $nip_bendahara,'tanda_tangan'=>$tanda_tangan_bendahara),
                'penerima'  => array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            )
        ];

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_kwitansi_sppd','data'=>$arr]);
        $html .= $pdf->render();
        $download = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->download("kwitansi surat pengajuan perjalanan dinas ($nama - $nomor_laporan - $tgl).pdf");
        return $download;
    }


    function laporan_spd(){
        if(Session::has('isLogin')){
            $data = array();
            $data_sppd = perjalanan_dinas::all();
            foreach ($data_sppd as $key => $value) {
                $data_spd = surat_perjalanan_dinas::where('id_perjalanan_dinas',$value->id)->first();

                $arr = [
                    'id_sppd'                => ($value==null? -1:$value->id),
                    'id'                     => ($data_spd==null?"N/a":$data_spd->id),
                    'nomor_laporan'          => ($value==null? 0:$value->nomor_perjalanan_dinas),
                    'biaya_perjalanan_dinas' => ($value==null? 0: "Rp ".number_format($value->biaya_akan_digunakan,0,'','.')),
                    'maksud_perjalanan'      => ($value==null? "N/a":$value->maksud_perjalanan),
                    'angkutan'               => ($value==null? "N/a":$value->kendaraan),
                    'tempat_berangkat'       => ($data_spd==null?null:$data_spd->tempat_berangkat),
                    'tempat_tujuan'          => ($value==null? "N/a":$value->tujuan->tujuan),
                    'lama_perjalanan'        => ($value==null? 0:$value->lama_perjalanan." Hari"),
                    'tanggal_berangkat'      => ($value==null? "N/a":Carbon::parse($value->tanggal)->formatLocalized("%A, %d %B %Y")),       
                    'keterangan'             => ($data_spd==null?-1:$data_spd->keterangan),
                    'tanggal_akhir'          => Carbon::parse($value->tanggal)->addDays( ($value->lama_perjalanan==null?0:$value->lama_perjalanan-1) )->formatLocalized("%A, %d %B %Y"),
                        
                    'pengikut'          => $this->getMenugaskan($value->id),
                    'keterangan_lain'   => ($data_spd==null?null:$data_spd->keterangan_lain),
                    'status'            => ($data_spd==null?0:1)
                ];

                array_push($data, $arr);
            }
            
            return view('index',['layout'=>'laporan_spd','title_layout'=>'Laporan SPD','datas'=>$data]);
        }
        else{
            return redirect('/'); 
        }
    }
    function add_laporan_spd(){
        if(Session::has('isLogin')){
           $data_sppd = perjalanan_dinas::all();        
           return view('index',['layout'=>'add_laporan_spd','title_layout'=>'Tambah Laporan SPD','datas'=>$data_sppd]);
        }
        else{
            return redirect('/'); 
        }
    }
    function edit_laporan_spd($id){
        if(Session::has('isLogin')){
           $data_sppd = perjalanan_dinas::all();
           $data_spd = surat_perjalanan_dinas::find($id);        
           return view('index',['layout'=>'edit_laporan_spd','title_layout'=>'Ubah Laporan SPD','spd'=>$data_spd,'datas'=>$data_sppd]);
        }
        else{
            return redirect('/'); 
        }
    }
    function store_laporan_spd(Request $req){
        $id_perjalanan_dinas    = $req->id_perjalanan_dinas;
        $tempat_berangkat       = $req->tempat_berangkat;
        $keterangan             = ($req->keterangan==''?null:$req->keterangan);
        $keterangan_lain        = ($req->keterangan_lain==''?null:$req->keterangan_lain);

        $spd = surat_perjalanan_dinas::where('id_perjalanan_dinas',$id_perjalanan_dinas)->get();
        if($spd->count()==0){
            $laporan_spd                        = new surat_perjalanan_dinas();
            $laporan_spd->id_perjalanan_dinas   = $id_perjalanan_dinas;
            $laporan_spd->tempat_berangkat      = $tempat_berangkat;
            $laporan_spd->keterangan            = $keterangan;
            $laporan_spd->keterangan_lain       = $keterangan_lain;
            $laporan_spd->tanda_tangan          = Session::get('id');
            if($laporan_spd->save()){
                $nomor_laporan  = ($laporan_spd->id_perjalanan_dinas==null?"N/a":$laporan_spd->Perjalanan_Dinas->nomor_perjalanan_dinas);
                //$id_user        = $laporan_spd->Perjalanan_Dinas->id_penanggung_jawab;
                $id_user        = $laporan_spd->Perjalanan_Dinas->id_pemohon;
                $data_user      = data_user::where('id_user',$id_user)->first();
                $nama_user      = ($data_user==null? "N/a":$data_user->nama);
                $user           = user::find($id_user); 
                $email_user     = ($user==null? "N/a":$user->email);
                
                $data_admin_kwitansi = data_user::join('user', function ($join) {
                                                    $join->on('data_user.id_user', '=', 'user.id')
                                                    ->where('user.id_role', 6)
                                                    // ->where('data_user.id_jabatan', 34)
                                                    ->where('data_user.status',1);
                                              })->get();

                if($data_admin_kwitansi->count()>0){
                    foreach ($data_admin_kwitansi as $data_admin_kwitansi => $y) {
                        $id_admin           = $y->id_user;
                        $nama_admin         = $y->nama;
                        $jabatan_admin      = $y->Jabatan->jabatan;
                        $data_akun_admin    = User::find($id_admin);

                        if($data_akun_admin != null){
                            $email_admin = $data_akun_admin->email;
                            if( $email_admin != null || $email_admin != '' ){
                                $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                            berikut saya sampaikan pengajuan perjalanan dinas atas nama $nama_user dengan nomor $nomor_laporan mohon dibuatkan surat kwitansi perjalanan dinas";

                                //$pesan = "hai ".$nama_admin.", hari ini laporan surat pengajuan perjalanan dinas ".$nama_user." dengan nomor laporan ".$nomor_laporan." telah diterima oleh Kuasa Pengguna Anggaran, mohon dibuat kwitansi surat perjalanan dinasnya";
                                $this->kirim_notif($nama_admin,$email_admin,$pesan);
                            }
                        }
                    }
                }
                if( $email_user != "" || $email_user != null ){
                    $data_admin_spd    = data_user::find(Session::get('id'));
                    $jabatan_admin_spd = ($data_admin_spd==null? "Penjabat Pembuat Komitmen":$data_admin_spd->Jabatan->jabatan);

                    $pesan = "Yth.$nama_user<br>
                                Surat perjalanan dinas nomor $nomor_laporan telah dibuat oleh $jabatan_admin_spd.<br>
                                Klik <a href='".url("/download/spd/$id_perjalanan_dinas")."'>unduh</a> untuk mendapatkan surat perjalanan dinas";
                    //$pesan = "hai ".$nama_user.", surat kwitansi untuk laporan sppd dengan nomor ".$nomor_laporan.$respon_pesan;
                    $this->kirim_notif($nama_user,$email_user,$pesan);
                }

                return redirect('/admin/laporan_spd')->with('type_msg',1)->with('msg','Berhasil Simpan');
            }
            else{
                return redirect('/admin/laporan_spd')->with('type_msg',0)->with('msg','Gagal Simpan');
            }
        }
        else{
            return redirect('/admin/laporan_spd')->with('type_msg',0)->with('msg','Laporan Sudah Ada');
        }
    }
    function update_laporan_spd(Request $req){
        $id                     = $req->id; 
        $id_perjalanan_dinas    = $req->id_perjalanan_dinas;
        $tempat_berangkat       = $req->tempat_berangkat;
        $keterangan             = ($req->keterangan==''?null:$req->keterangan);
        $keterangan_lain        = ($req->keterangan_lain==''?null:$req->keterangan_lain);

        $laporan_spd                        = surat_perjalanan_dinas::find($id);
        $laporan_spd->id_perjalanan_dinas   = $id_perjalanan_dinas;
        $laporan_spd->tempat_berangkat      = $tempat_berangkat;
        $laporan_spd->keterangan            = $keterangan;
        $laporan_spd->keterangan_lain       = $keterangan_lain;
        if($laporan_spd->save()){
            return redirect('/admin/laporan_spd')->with('type_msg',1)->with('msg','Berhasil Ubah');
        }
        else{
            return redirect('/admin/laporan_spd')->with('type_msg',0)->with('msg','Gagal Ubah');
        }
    }
    function delete_laporan_spd($id){
        $hapus = surat_perjalanan_dinas::find($id);
        if($hapus->delete()){
            return redirect('/admin/laporan_spd')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/admin/laporan_spd')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }
    function download_cetak_laporan_spd($id){        
        $data_spd_detail = perjalanan_dinas_detail::where('id_perjalanan_dinas',$id)->get();
        foreach ($data_spd_detail as $a => $b) {
            $id_user = $b->id_user;
            $url     = url("/admin/cetak/surat_spd/filter/all/$id/target/$id_user");
            echo "<script>window.open('".$url."', '_blank')</script>";
        }     
        echo "<script>window.close();</script>";
    }
    

    function filter_cetak_sppd(){
        if(Session::has('isLogin')){
            $tujuan = tujuan::all();
            
            // $black_search = array();
            // $user = User::where('id_role','!=',2)->get();
            // foreach ($user as $key => $value) {
            //     array_push($black_search, $value->id);
            // }
            //$pengguna = data_user::whereNotIn('id_user',$black_search)->get(); 
            $pengguna = data_user::all(); 

            return view('index',['layout'=>'filter_cetak_sppd','title_layout'=>'Simpan Surat Pengajuan Perjalanan Dinas Digital','pengguna'=>$pengguna,'tujuan'=>$tujuan]);
        }
        else{
            return redirect('/');
        }
    }
    //tanda tangan ok
    function cetak_sppd($filter,$id){
        if(Session::has('isLogin')){
            $tujuan = null;
            if($filter=="nama"){
                //$data_perjalanan_dinas = perjalanan_dinas::where('id_penanggung_jawab',$id)->where('status_acc',1)->get();
                $data_perjalanan_dinas = perjalanan_dinas::where('id_pemohon',$id)->where('status_acc',1)->get();
            }
            else if($filter=="tujuan"){
                $data_perjalanan_dinas = perjalanan_dinas::where('id_tujuan',$id)->where('status_acc',1)->get();
                $tujuan = tujuan::find($id);
            }
            else{
                $data_perjalanan_dinas = perjalanan_dinas::Where('tanggal', 'like', '%'.$id.'%')->where('status_acc',1)->get();
            }

            $data_user = data_user::where('id_user',$id)->first();
            $list = array();
            foreach ($data_perjalanan_dinas as $key => $value) {
                $arr = [
                    "id" => $value->id,
                    "nomor_laporan" => $value->nomor_perjalanan_dinas,
                    "download_sppd" => 0,
                    "download_st" => 0,
                    'surat_tugas' => $value->surat_tugas
                ];
                array_push($list, $arr);
            }
            $data = array(
                "id_user" => ($data_user==null? -1:$data_user->id_user),
                "nama" => ($data_user==null? "N/a":$data_user->nama),
                "tujuan" => ($tujuan==null? "N/a":$tujuan->tujuan),
                "tanggal" => ($filter=='tanggal'?Carbon::parse($id)->formatLocalized("%B %Y"):null),
                "filter" => $filter,
                "data" => $list 
            );

            return view('index',['layout'=>'cetak_sppd','title_layout'=>'Simpan Surat Pengajuan Perjalanan Dinas','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //tanda tangan ok
    function execute_cetak_sppd($filter,$id){
        $item = perjalanan_dinas::find($id);
        
        $data_admin = data_user::where('id_user',$item->tanda_tangan)->first();
        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        $data_user = data_user::where('id_user',$item->id_pemohon)->first();
        if($data_user != null){
            $nip                = $data_user->nip;
            $nama               = $data_user->nama;
            $tanda_tangan       = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nip                = "N/a";
            $nama               = "N/a";
            $tanda_tangan       = "no_signature.jpg";
        }

        $pemohon = data_user::where('id_user',$item->id_pemohon)->first();
        $pemohon = ($pemohon==null? "Na":$pemohon->nama);
        
        $nomor_laporan = $item->nomor_perjalanan_dinas;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'penanggung_jawab'  =>$nama,
            'judul'             =>$item->judul_kegiatan,
            'menugaskan'        =>array_column($this->getMenugaskan($item->id),'nama'),
            'tujuan'            =>($item->id_tujuan==null? "N/a":$item->tujuan->tujuan),
            'maksud_perjalanan' =>$item->maksud_perjalanan,
            'tanggal_berangkat' =>Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y"),
            'tanggal_kembali'   =>Carbon::parse($item->tanggal)->addDays($item->lama_perjalanan-1)->formatLocalized("%A, %d %B %Y"),
            'kegiatan'          =>($item->kegiatan==null? "N/a":$item->Pagu_Anggaran->nama_kegiatan),
            'jenis_kendaraan'   =>$item->kendaraan,
            'tanda_tangan'      => array(
                'admin'     => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'pengaju'   => array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            ),
            'pagu_anggaran'         =>number_format($item->pagu_anggaran,0,'','.'),
            'biaya_telah_digunakan' =>number_format($item->biaya_telah_digunakan,0,'','.'),
            'biaya_akan_digunakan'  =>number_format($item->biaya_akan_digunakan,0,'','.'),
            'sisa_anggaran'         =>number_format($item->pagu_anggaran-$item->biaya_telah_digunakan-$item->biaya_akan_digunakan,0,'','.'),
            // 'verifikator'           =>$item->verifikator,
        ];

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_pengajuan_perjalanan_dinas','data'=>$arr]);
        $html .= $pdf->render();
        $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/surat pengajuan perjalanan dinas/surat pengajuan perjalanan dinas ($pemohon - $nomor_laporan - $tgl).pdf");
        if($simpan){
            echo "1";
        }
        else{
            echo "0";
        }

        //return view('index_print',['layout'=>'cetak_pengajuan_perjalanan_dinas','data'=>$arr]);
        // $pdf = \PDF::loadView('index_print',['layout'=>'cetak_pinjam_kendaraan','data'=>$arr]);
        // return $pdf->setPaper('a4', 'portrait')->download('pinjam_kendaraan.pdf');
    }
    function execute_cetak_surat_tugas($filter,$id){
    	$item = perjalanan_dinas::find($id);
        
        $data_admin = data_user::where('id_user',$item->tanda_tangan)->first();
        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        $data_user = data_user::where('id_user',$item->id_penanggung_jawab)->first();
        if($data_user != null){
            $nip                = $data_user->nip;
            $nama               = $data_user->nama;
            $tanda_tangan       = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nip                = "N/a";
            $nama               = "N/a";
            $tanda_tangan       = "no_signature.jpg";
        }

        $pemohon = data_user::where('id_user',$item->id_pemohon)->first();
        $pemohon = ($pemohon==null? "Na":$pemohon->nama);
        
        $nomor_laporan = $item->nomor_perjalanan_dinas;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'penanggung_jawab'  =>$nama,
            'judul'             =>$item->judul_kegiatan,
            'menugaskan'        =>$this->getMenugaskan($item->id),
            'tujuan'            =>($item->id_tujuan==null? "N/a":$item->tujuan->tujuan),
            'maksud_perjalanan' =>$item->maksud_perjalanan,
            'tanggal'           =>Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y"),
            'lama'              =>$item->lama_perjalanan,
            'kegiatan'          =>($item->kegiatan==null? "N/a":$item->Pagu_Anggaran->nama_kegiatan),
            'jenis_kendaraan'   =>$item->kendaraan,
            'tanda_tangan'      => array(
                'admin'     => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'pengaju'   => array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            )
        ];

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_surat_tugas','data'=>$arr]);
        $html .= $pdf->render();
        $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/surat tugas/surat tugas ($pemohon - $nomor_laporan - $tgl).pdf");
        if($simpan){
            echo "1";
        }
        else{
            echo "0";
        }

        //return view('index_print',['layout'=>'cetak_surat_tugas','data'=>$arr]);
        // $pdf = \PDF::loadView('index_print',['layout'=>'cetak_surat_tugas']);
    	// return $pdf->setPaper('a4', 'portrait')->download('surat_tugas.pdf');
    }   
    function filter_cetak_pinjam_kendaraan(){
        if(Session::has('isLogin')){
            $tujuan = tujuan::all();
            
            // $black_search = array();
            // $user = User::where('id_role','!=',2)->get();
            // foreach ($user as $key => $value) {
            //     array_push($black_search, $value->id);
            // }
            // $pengguna = data_user::whereNotIn('id_user',$black_search)->get(); 
            $pengguna = data_user::all(); 

            return view('index',['layout'=>'filter_cetak_pinjam_kendaraan','title_layout'=>'Simpan Laporan Pinjam Kendaraan Digital','pengguna'=>$pengguna,'tujuan'=>$tujuan]);
        }
        else{
            return redirect('/');
        }
    }
    function cetak_pinjam_kendaraan($filter,$id){
        if(Session::has('isLogin')){
            $tujuan = null;
            if($filter=="nama"){
                $data_pinjam_kendaraan = pinjam_kendaraan::where('id_peminjam',$id)->where('status_acc',1)->get();
            }
            else if($filter=="tujuan"){
                $data_pinjam_kendaraan = pinjam_kendaraan::where('id_tujuan',$id)->where('status_acc',1)->get();
                $tujuan = tujuan::find($id);
            }
            else{
                $data_pinjam_kendaraan = pinjam_kendaraan::Where('tanggal', 'like', '%'.$id.'%')->where('status_acc',1)->get();
            }

            $data_user = data_user::where('id_user',$id)->first();
            $list = array();
            foreach ($data_pinjam_kendaraan as $key => $value) {
                $arr = [
                    "id" => $value->id,
                    "nomor_laporan" => $value->nomor_laporan,
                    "download" => 0,
                ];
                array_push($list, $arr);
            }
            $data = array(
                "id_user" => ($data_user==null? -1:$data_user->id_user),
                "nama" => ($data_user==null? "N/a":$data_user->nama),
                "tujuan" => ($tujuan==null? "N/a":$tujuan->tujuan),
                "tanggal" => ($filter=='tanggal'?Carbon::parse($id)->formatLocalized("%B %Y"):null),
                "filter" => $filter,
                "data" => $list 
            );

            return view('index',['layout'=>'cetak_pinjam_kendaraan','title_layout'=>'Simpan Laporan Pinjam Kendaraan','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //tanda tangan ok,print ok
    function execute_cetak_pinjam_kendaraan($filter,$id){
    	$item = pinjam_kendaraan::find($id);
        
        $data_admin = data_user::where('id_user',$item->tanda_tangan)->first();
        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        $data_user = data_user::where('id_user',$item->id_peminjam)->first();
        if($data_user != null){
            $nip            = $data_user->nip;
            $nama           = $data_user->nama;
            $pangkat        = $data_user->pangkat->pangkat;
            $golongan       = $data_user->golongan->golongan;
            $tanda_tangan   = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nip            = "N/a";
            $nama           = "N/a";
            $pangkat        = "N/a";
            $golongan       = "N/a";
            $tanda_tangan   = "no_signature.jpg";
        }

        $nomor_laporan = $item->nomor_laporan;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'nama'                  => $nama,
            'pangkat'               => $pangkat,
            'subbag'                => $golongan,
            'jenis_kendaraan'       => $item->jenis_kendaraan,
            'penumpang'             => implode(',', $this->getPenumpangShortList($item->id)),
            'keperluan'             => $item->keperluan,
            'tujuan'                => ($item->id_tujuan==null? "N/a":$item->tujuan->tujuan),
            'jam_berangkat'         => $item->jam,
            'tanggal_berangkat'     => Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y"),
            'lama_keperluan'        => $item->lama_keperluan." hari",
            'nama_pengemudi'        => implode(',', array_column($this->getPengemudi($item->id),'nama')),
            'jenis_kendaaraan'      => implode(',', array_column($this->getPengemudi($item->id),'jenis_kendaraan')),
            'no_polisi'             => implode(',', array_column($this->getPengemudi($item->id),'no_polisi')),
            'create'                => Carbon::parse($item->created_at)->formatLocalized("%A, %d %B %Y %H:%M:%S"),
            'tanda_tangan'          => array(
                'admin'=> array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'peminjam'=> array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            )
        ];

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_pinjam_kendaraan','data'=>$arr]);
        $html .= $pdf->render();
        $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/pinjam kendaraan/pinjam kendaraan ($nama - $nomor_laporan - $tgl).pdf");
        if($simpan){
            echo "1";
        }
        else{
            echo "0";
        }

        //return view('index_print',['layout'=>'cetak_pinjam_kendaraan','data'=>$arr]);
        //$pdf = \PDF::loadView('index_print',['layout'=>'cetak_pinjam_kendaraan','data'=>$arr]);
        //return $pdf->setPaper('a4', 'portrait')->download('pinjam_kendaraan.pdf');
    }

    function filter_cetak_laporan_upg(){
        if(Session::has('isLogin')){
            return view('index',['layout'=>'filter_cetak_laporan_upg','title_layout'=>'Simpan Laporan UPG Digital']);
        }
        else{
            return redirect('/');
        }
    }
    function cetak_laporan_upg($filter,$id){
        if(Session::has('isLogin')){
            $data_upg = laporan_upg::Where('tanggal', 'like', '%'.$id.'%')->where('status',1)->get();
            
            $nomor_laporan = array();
            foreach ($data_upg as $key => $value) {
                array_push($nomor_laporan, $value->nomor_laporan);
            }

            $data = array(
                "tanggal"   => ($filter=='tanggal'?Carbon::parse($id)->formatLocalized("%B %Y"):null),
                "filter"    => $filter,
                "data"      => [
                                "id" => $id,
                                "nomor_laporan" => implode(';', $nomor_laporan),
                                "download_upg" => 0,
                            ]
            );

            return view('index',['layout'=>'cetak_laporan_upg','title_layout'=>'Simpan Laporan UPG','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //print ok
    function execute_cetak_laporan_upg($filter,$id){
        $data = array();
        $data_upg = laporan_upg::Where('tanggal', 'like', '%'.$id.'%')->where('status',1)->get();
        foreach ($data_upg as $key => $value) {
            $data_user = data_user::where('id_user',$value->id_user)->first();
            $data_gratifikasi = laporan_upg_detail::where('id_laporan_upg',$value->id)->get();

            $gratifikasi = array();
            foreach ($data_gratifikasi as $x => $y) {
                array_push($gratifikasi, $y->jenis_gratifikasi->nama);  
            }

            $arr = [
                'nama'          =>($data_user==null?"N/a":"$data_user->nama - $data_user->nip"),
                'gratifikasi'   =>implode(';', $gratifikasi),
                'lokasi'        =>$value->lokasi,
                'tanggal_mulai'     =>Carbon::parse($value->tanggal)->formatLocalized("%A, %d %B %Y"),
                'tanggal_berakhir'  =>Carbon::parse($value->tanggal)->addDays($value->lama-1)->formatLocalized("%A, %d %B %Y"),
                'honor'         =>"Rp ".number_format($value->honor,0,'','.'),
                'pemberi'       =>$value->pemberi,
                'hubungan'      =>$value->hubungan_gratifikasi
            ];

            array_push($data, $arr);
        }

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_laporan_upg','bulan'=>Carbon::parse($id)->formatLocalized("%B %Y"),'datas'=>$data]);
        $html .= $pdf->render();
        
        $simpan_pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/laporan upg/laporan upg (".Carbon::parse($value->tanggal)->formatLocalized("%B %Y").").pdf");
        
        $excel = "laporan upg (".Carbon::parse($id)->formatLocalized("%B %Y").").xlsx";
        $simpan_excel = Excel::store(new ExcelUpg($id), $excel,"folder_upg");

        if($simpan_pdf && $simpan_excel){
            echo "1";
        }
        else{
            echo "0";
        }
        //return view('index_print',['layout'=>'cetak_laporan_upg','datas'=>$data]);
    }


    function filter_cetak_laporan_spd(){
        if(Session::has('isLogin')){
            $tujuan = tujuan::all();
            
            // $black_search = array();
            // $user = User::where('id_role','!=',2)->get();
            // foreach ($user as $key => $value) {
            //     array_push($black_search, $value->id);
            // }
            // $pengguna = data_user::whereNotIn('id_user',$black_search)->get(); 
            $pengguna = data_user::all(); 

            return view('index',['layout'=>'filter_cetak_laporan_spd','title_layout'=>'Simpan Laporan SPD Digital','pengguna'=>$pengguna,'tujuan'=>$tujuan]);
        }
        else{
            return redirect('/');
        }
    }
    function cetak_laporan_spd($filter,$id){
        if(Session::has('isLogin')){
            $tujuan = null;
            if($filter=="nama"){
                $data_laporan = array();
                $data_perjalanan_dinas_detail = perjalanan_dinas_detail::where('id_user',$id)->get();
                foreach ($data_perjalanan_dinas_detail as $key => $value) {
                    array_push($data_laporan, $value->id_perjalanan_dinas);
                }
                $data_perjalanan_dinas = perjalanan_dinas::whereIn('id',$data_laporan)->where('status_acc',1)->get();
                $data_user = data_user::where('id_user',$id)->first();

                $id_user = ($data_user==null?-1:$data_user->id_user);
                $nama = $data_user->nama;
                $id_tujuan = -1;
                $id_tanggal = 'N/a';
            }
            else if($filter=="tujuan"){
                $data_perjalanan_dinas = perjalanan_dinas::where('id_tujuan',$id)->where('status_acc',1)->get();
                $tujuan = tujuan::find($id);
                
                $id_user = -1;
                $nama = 'N/a';
                $id_tujuan = $id;
                $id_tanggal = 'N/a';
            }
            else{
                $data_perjalanan_dinas = perjalanan_dinas::Where('tanggal', 'like', '%'.$id.'%')->where('status_acc',1)->get();
                $id_user = -1;
                $nama = 'N/a';
                $id_tujuan = -1;
                $id_tanggal = $id;
            }

            
            $list = array();
            foreach ($data_perjalanan_dinas as $key => $value) {
                $arr = [
                    "id" => $value->id,
                    "nomor_laporan" => $value->nomor_perjalanan_dinas,
                    "download_spd" => 0,
                ];
                array_push($list, $arr);
            }

            $data = array(
                "id_user" => $id_user,
                "id_tujuan" => $id_tujuan,
                "id_tanggal" => $id_tanggal,
                "nama" => $nama,
                "tujuan" => ($tujuan==null?"N/a":$tujuan->tujuan),
                "tanggal" => ($id_tanggal !='N/a'? Carbon::parse($id_tanggal)->formatLocalized("%B %Y"):"N/a"),
                "filter" => $filter,
                "data" => $list 
            );

            return view('index',['layout'=>'cetak_laporan_spd','title_layout'=>'Simpan Laporan SPD','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //tanda tangan ok,print ok
    function execute_cetak_laporan_spd($filter,$id,$id_user){        
        if($filter=='nama' || $filter=='all'){
            $item = perjalanan_dinas::find($id);

            if($filter=='nama'){
                $spd = surat_perjalanan_dinas::where('id_perjalanan_dinas',$id)->first();

                if($item != null && $spd != null){
                    $pengguna = $this->getMenugaskan($id);
                    $data_admin = data_user::where('id_user',$spd->tanda_tangan)->first();
                    if($data_admin != null){
                            $nip_admin      = $data_admin->nip;
                            $nama_admin     = $data_admin->nama;
                            $tanda_tangan   = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                    }
                    else{
                            $nip_admin      = "- - -";
                            $nama_admin     = "N/a";
                            $tanda_tangan   = "no_signature.jpg";
                    }
                    
                    $data_admin_sppd = data_user::where('id_user',$spd->Perjalanan_Dinas->tanda_tangan)->first();
                    if($data_admin_sppd != null){
                            $nip_admin_sppd      = $data_admin_sppd->nip;
                            $nama_admin_sppd     = $data_admin_sppd->nama;
                            $tanda_tangan_sppd   = ($data_admin_sppd->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                    }
                    else{
                            $nip_admin_sppd      = "- - -";
                            $nama_admin_sppd     = "N/a";
                            $tanda_tangan_sppd   = "no_signature.jpg";
                    }
                    
                    $pengikut = array();
                    if($pengguna>1){
                        foreach ($pengguna as $pengguna) {
                            if($pengguna['id']!=$id_user){
                                array_push($pengikut, $pengguna);
                            }
                        }
                    }
                    $nama                       = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['nama']);
                    $nip                        = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['nip']);
                    $pangkat                    = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['pangkat']);
                    $golongan                   = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['golongan']);
                    $jabatan                    = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['jabatan']);
                    $biaya_perjalanan_dinas     = $item->biaya_akan_digunakan;
                    $maksud_perjalanan          = $item->maksud_perjalanan;
                    $kendaraan                  = ($item->kendaraan==1?"Umum":"Dinas");
                    $tempat_berangkat           = $spd['tempat_berangkat'];
                    $tempat_tujuan              = $item->tujuan->tujuan;
                    $keterangan                 = $spd['keterangan'];
                    $tanggal                    = $item->tanggal;
                    $lama_perjalanan            = $item->lama_perjalanan;
                    $tanggal_akhir              = Carbon::parse($tanggal)->addDays($lama_perjalanan-1);
                    $pengikut                   = $pengikut;
                    $keterangan_lain            = $item->keterangan_lain;

                    $arr = [
                        'nama'                      => $nama,
                        'nip'                       => $nip,
                        'pangkat'                   => $pangkat,
                        'golongan'                  => $golongan,
                        'jabatan'                   => $jabatan,
                        'biaya_perjalanan_dinas'    => "Rp ".number_format($biaya_perjalanan_dinas,0,'','.'),
                        'maksud_perjalanan'         => $maksud_perjalanan,
                        'kendaraan'                 => $kendaraan,
                        'tempat_berangkat'          => $tempat_berangkat,
                        'tempat_tujuan'             => $tempat_tujuan,
                        'keterangan'                => $keterangan,
                        'tanggal_berangkat'         => Carbon::parse($tanggal)->formatLocalized("%A, %d %B %Y"),
                        'lama_perjalanan'           => $lama_perjalanan,
                        'tanggal_akhir'             => Carbon::parse($tanggal_akhir)->formatLocalized("%A, %d %B %Y"),
                        'pengikut'                  => $pengikut,
                        'keterangan_lain'           => $keterangan_lain,
                        'create'                    => Carbon::parse($item->created_at)->formatLocalized("%A, %d %B %Y %H:%M:%S"),
                        'tanda_tangan'              => array(
                            'admin'             => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan),
                            'admin_sppd'        => array('nama'=> $nama_admin_sppd,'nip'=> $nip_admin_sppd,'tanda_tangan'=>$tanda_tangan_sppd),
                        )
                    ];

                    $nomor_laporan = $item->nomor_perjalanan_dinas; 
                    $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");      
                    $html  = '';
                    $pdf   = view('index_print')->with(['layout'=>'cetak_surat_spd','data'=>$arr]);
                    $html .= $pdf->render();

                    $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/surat perjalanan dinas/surat perjalanan dinas ($nama - $nomor_laporan - $tgl).pdf");
                    
                    if($simpan){
                        echo "1";
                    }
                    else{
                        echo "0";
                    }

                    // $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('index_print',['layout'=>'cetak_surat_spd','data'=>$arr]);
                    // return $pdf->setPaper('a4', 'portrait')->stream();
                }
                else{
                    return '0';
                }
            }
            else{
                $spd = surat_perjalanan_dinas::where('id_perjalanan_dinas',$id)->first();

                if($item != null && $spd != null && $item->status_acc==1){
                    $pengguna = $this->getMenugaskan($id);
                    $data_admin = data_user::where('id_user',$spd->tanda_tangan)->first();
                    if($data_admin != null){
                            $nip_admin      = $data_admin->nip;
                            $nama_admin     = $data_admin->nama;
                            $tanda_tangan   = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                    }
                    else{
                            $nip_admin      = "- - -";
                            $nama_admin     = "N/a";
                            $tanda_tangan   = "no_signature.jpg";
                    }
                    $data_admin_sppd = data_user::where('id_user',$spd->Perjalanan_Dinas->tanda_tangan)->first();
                    if($data_admin_sppd != null){
                            $nip_admin_sppd      = $data_admin_sppd->nip;
                            $nama_admin_sppd     = $data_admin_sppd->nama;
                            $tanda_tangan_sppd   = ($data_admin_sppd->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                    }
                    else{
                            $nip_admin_sppd      = "- - -";
                            $nama_admin_sppd     = "N/a";
                            $tanda_tangan_sppd   = "no_signature.jpg";
                    }
                    
                    $pengikut = array();
                    if($pengguna>1){
                        foreach ($pengguna as $pengguna) {
                            if($pengguna['id']!=$id_user){
                                array_push($pengikut, $pengguna);
                            }
                        }
                    }
                    $nama                       = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['nama']);
                    $nip                        = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['nip']);
                    $pangkat                    = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['pangkat']);
                    $golongan                   = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['golongan']);
                    $jabatan                    = ($this->getPengguna($id_user)==null?"N/a":$this->getPengguna($id_user)['jabatan']);
                    $biaya_perjalanan_dinas     = $item->biaya_akan_digunakan;
                    $maksud_perjalanan          = $item->maksud_perjalanan;
                    $kendaraan                  = ($item->kendaraan==1?"Umum":"Dinas");
                    $tempat_berangkat           = $spd['tempat_berangkat'];
                    $tempat_tujuan              = $item->tujuan->tujuan;
                    $keterangan                 = $spd['keterangan'];
                    $tanggal                    = $item->tanggal;
                    $lama_perjalanan            = $item->lama_perjalanan;
                    $tanggal_akhir              = Carbon::parse($tanggal)->addDays($lama_perjalanan-1);
                    $pengikut                   = $pengikut;
                    $keterangan_lain            = $item->keterangan_lain;

                    $arr = [
                        'nama'                      => $nama,
                        'nip'                       => $nip,
                        'pangkat'                   => $pangkat,
                        'golongan'                  => $golongan,
                        'jabatan'                   => $jabatan,
                        'biaya_perjalanan_dinas'    => "Rp ".number_format($biaya_perjalanan_dinas,0,'','.'),
                        'maksud_perjalanan'         => $maksud_perjalanan,
                        'kendaraan'                 => $kendaraan,
                        'tempat_berangkat'          => $tempat_berangkat,
                        'tempat_tujuan'             => $tempat_tujuan,
                        'keterangan'                => $keterangan,
                        'tanggal_berangkat'         => Carbon::parse($tanggal)->formatLocalized("%A, %d %B %Y"),
                        'lama_perjalanan'           => $lama_perjalanan,
                        'tanggal_akhir'             => Carbon::parse($tanggal_akhir)->formatLocalized("%A, %d %B %Y"),
                        'pengikut'                  => $pengikut,
                        'keterangan_lain'           => $keterangan_lain,
                        'create'                    => Carbon::parse($item->created_at)->formatLocalized("%A, %d %B %Y %H:%M:%S"),
                        'tanda_tangan'              => array(
                            'admin'             => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan),
                            'admin_sppd'        => array('nama'=> $nama_admin_sppd,'nip'=> $nip_admin_sppd,'tanda_tangan'=>$tanda_tangan_sppd),
                        )
                    ];
                    
                    $nomor_laporan = $item->nomor_perjalanan_dinas; 
                    $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");      
                    $html  = '';
                    $pdf   = view('index_print')->with(['layout'=>'cetak_surat_spd','data'=>$arr]);
                    $html .= $pdf->render();

                    //return \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->download("surat perjalanan dinas ($nama - $nomor_laporan - $tgl).pdf");
                    return \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->download("surat perjalanan dinas ($nama - $nomor_laporan - $tgl).pdf");
                }
                else{
                    echo "<script>window.close();</script>";
                }
            }
        }
        else if($filter == 'tujuan'){
            $item = perjalanan_dinas::find($id);
            if($item!=null){                
                $item_detail = perjalanan_dinas_detail::where('id_perjalanan_dinas',$id)->get();
                $spd = surat_perjalanan_dinas::where('id_perjalanan_dinas',$id)->first();
                    
                if($item_detail->count()>0 && $spd != null){
                    $data_admin = data_user::where('id_user',$spd->tanda_tangan)->first();
                    if($data_admin != null){
                        $nip_admin  = $data_admin->nip;
                        $nama_admin = $data_admin->nama;
                        $tanda_tangan   = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                    }
                    else{
                        $nip_admin  = "- - -";
                        $nama_admin = "N/a";
                        $tanda_tangan   = 'no_signature.jpg';
                    }
                    
                    $data_admin_sppd = data_user::where('id_user',$spd->Perjalanan_Dinas->tanda_tangan)->first();
                    if($data_admin_sppd != null){
                            $nip_admin_sppd      = $data_admin_sppd->nip;
                            $nama_admin_sppd     = $data_admin_sppd->nama;
                            $tanda_tangan_sppd   = ($data_admin_sppd->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                    }
                    else{
                            $nip_admin_sppd      = "- - -";
                            $nama_admin_sppd     = "N/a";
                            $tanda_tangan_sppd   = "no_signature.jpg";
                    }

                    $success = 0;
                    foreach ($item_detail as $key => $value) {
                        $pengguna = $this->getMenugaskan($id);
                        $pengikut = array();
                        if($pengguna>1){
                            foreach ($pengguna as $pengguna) {
                                if($pengguna['id']!=$value->id_user){
                                    array_push($pengikut, $pengguna);
                                }
                            }
                        }
                        $nama                       = ($this->getPengguna($value->id_user)==null?"N/a":$this->getPengguna($value->id_user)['nama']);
                        $nip                        = ($this->getPengguna($value->id_user)==null?"N/a":$this->getPengguna($value->id_user)['nip']);
                        $pangkat                    = ($this->getPengguna($value->id_user)==null?"N/a":$this->getPengguna($value->id_user)['pangkat']);
                        $golongan                   = ($this->getPengguna($value->id_user)==null?"N/a":$this->getPengguna($value->id_user)['golongan']);
                        $jabatan                    = ($this->getPengguna($value->id_user)==null?"N/a":$this->getPengguna($value->id_user)['jabatan']);
                        $biaya_perjalanan_dinas     = $item->biaya_akan_digunakan;
                        $maksud_perjalanan          = $item->maksud_perjalanan;
                        $kendaraan                  = ($item->kendaraan==1?"Umum":"Dinas");
                        $tempat_berangkat           = $spd['tempat_berangkat'];
                        $tempat_tujuan              = $item->tujuan->tujuan;
                        $keterangan                 = $spd['keterangan'];
                        $tanggal                    = Carbon::parse($item->tanggal);
                        $lama_perjalanan            = $item->lama_perjalanan;
                        $tanggal_akhir              = Carbon::parse($item->tanggal)->addDays($lama_perjalanan-1);
                        $pengikut                   = $pengikut;
                        $keterangan_lain            = $item->keterangan_lain;

                        $arr = [
                            'nama'                      => $nama,
                            'nip'                       => $nip,
                            'pangkat'                   => $pangkat,
                            'golongan'                  => $golongan,
                            'jabatan'                   => $jabatan,
                            'biaya_perjalanan_dinas'    => "Rp ".number_format($biaya_perjalanan_dinas,0,'','.'),
                            'maksud_perjalanan'         => $maksud_perjalanan,
                            'kendaraan'                 => $kendaraan,
                            'tempat_berangkat'          => $tempat_berangkat,
                            'tempat_tujuan'             => $tempat_tujuan,
                            'keterangan'                => $keterangan,
                            'tanggal_berangkat'         => Carbon::parse($tanggal)->formatLocalized("%A, %d %B %Y"),
                            'lama_perjalanan'           => $lama_perjalanan,
                            'tanggal_akhir'             => Carbon::parse($tanggal_akhir)->formatLocalized("%A, %d %B %Y"),
                            'pengikut'                  => $pengikut,
                            'keterangan_lain'           => $keterangan_lain,
                            'create'                    => Carbon::parse($item->created_at)->formatLocalized("%A, %d %B %Y %H:%M:%S"),
                            'tanda_tangan'              => array(
                                'admin'             => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan),
                                'admin_sppd'        => array('nama'=> $nama_admin_sppd,'nip'=> $nip_admin_sppd,'tanda_tangan'=>$tanda_tangan_sppd),
                            )
                        ];

                        $nomor_laporan = $item->nomor_perjalanan_dinas;
                        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
                        $html  = '';
                        $pdf   = view('index_print')->with(['layout'=>'cetak_surat_spd','data'=>$arr]);
                        $html .= $pdf->render();
                        $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/surat perjalanan dinas/surat perjalanan dinas ($nama - $nomor_laporan - $tgl).pdf");
                            if($simpan){
                                $success++;
                        }
                        //return view('index_print',['layout'=>'cetak_surat_spd','data'=>$arr]);   
                    }
                        
                    if($success == $item_detail->count()){
                        return '1';
                    }
                    else{
                        return '0';
                    }
                }
                else{
                    return '0';
                }
            }
            else{
                return '0';
            }
        }
        else if($filter == 'tanggal'){
            $spd = surat_perjalanan_dinas::where('id_perjalanan_dinas',$id)->first();
            if($spd != null){
                $item = $spd->Perjalanan_Dinas;
                if($item!=null){
                    $item_detail = perjalanan_dinas_detail::where('id_perjalanan_dinas',$id)->get();

                    if($item_detail->count()>0){
                        $data_admin = data_user::where('id_user',$spd->tanda_tangan)->first();
                        if($data_admin != null){
                                $nip_admin      = $data_admin->nip;
                                $nama_admin     = $data_admin->nama;
                                $tanda_tangan   = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                        }
                        else{
                                $nip_admin      = "- - -";
                                $nama_admin     = "N/a";
                                $tanda_tangan   = "no_signature.jpg";
                        }
                        
                        $data_admin_sppd = data_user::where('id_user',$spd->Perjalanan_Dinas->tanda_tangan)->first();
                        if($data_admin_sppd != null){
                                $nip_admin_sppd      = $data_admin_sppd->nip;
                                $nama_admin_sppd     = $data_admin_sppd->nama;
                                $tanda_tangan_sppd   = ($data_admin_sppd->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
                        }
                        else{
                                $nip_admin_sppd      = "- - -";
                                $nama_admin_sppd     = "N/a";
                                $tanda_tangan_sppd   = "no_signature.jpg";
                        }
    
                        $success = 0;
                        foreach ($item_detail as $key => $value) {
                            $pengguna = $this->getMenugaskan($id);
                            $pengikut = array();
                            if($pengguna>1){
                                foreach ($pengguna as $pengguna) {
                                    if($pengguna['id']!=$value->id_user){
                                        array_push($pengikut, $pengguna);
                                    }
                                }
                            }
                            $pengguna = $this->getPengguna($value->id_user);   
                            
                            $nama                       = ($pengguna==null?"N/a":$pengguna['nama']);
                            $nip                        = ($pengguna==null?"N/a":$pengguna['nip']);
                            $pangkat                    = ($pengguna==null?"N/a":$pengguna['pangkat']);
                            $golongan                   = ($pengguna==null?"N/a":$pengguna['golongan']);
                            $jabatan                    = ($pengguna==null?"N/a":$pengguna['jabatan']);
                            $biaya_perjalanan_dinas     = $item->biaya_akan_digunakan;
                            $maksud_perjalanan          = $item->maksud_perjalanan;
                            $kendaraan                  = ($item->kendaraan==1?"Umum":"Dinas");
                            $tempat_berangkat           = $spd['tempat_berangkat'];
                            $tempat_tujuan              = $item->tujuan->tujuan;
                            $keterangan                 = $spd['keterangan'];
                            $tanggal                    = $item->tanggal;
                            $lama_perjalanan            = $item->lama_perjalanan;
                            $tanggal_akhir              = Carbon::parse($tanggal)->addDays($lama_perjalanan-1);
                            $pengikut                   = $pengikut;
                            $keterangan_lain            = $item->keterangan_lain;
    
                            $arr = [
                                'nama'                      => $nama,
                                'nip'                       => $nip,
                                'pangkat'                   => $pangkat,
                                'golongan'                  => $golongan,
                                'jabatan'                   => $jabatan,
                                'biaya_perjalanan_dinas'    => "Rp ".number_format($biaya_perjalanan_dinas,0,'','.'),
                                'maksud_perjalanan'         => $maksud_perjalanan,
                                'kendaraan'                 => $kendaraan,
                                'tempat_berangkat'          => $tempat_berangkat,
                                'tempat_tujuan'             => $tempat_tujuan,
                                'keterangan'                => $keterangan,
                                'tanggal_berangkat'         => Carbon::parse($tanggal)->formatLocalized("%A, %d %B %Y"),
                                'lama_perjalanan'           => $lama_perjalanan,
                                'tanggal_akhir'             => Carbon::parse($tanggal_akhir)->formatLocalized("%A, %d %B %Y"),
                                'pengikut'                  => $pengikut,
                                'keterangan_lain'           => $keterangan_lain,
                                'create'                    => Carbon::parse($item->created_at)->formatLocalized("%A, %d %B %Y %H:%M:%S"),
                                'tanda_tangan'              => array(
                                    'admin'             => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan),
                                    'admin_sppd'        => array('nama'=> $nama_admin_sppd,'nip'=> $nip_admin_sppd,'tanda_tangan'=>$tanda_tangan_sppd),
                                )
                            ];
                            
                            //dd($arr);
    
                            $nomor_laporan = $item->nomor_perjalanan_dinas;
                            $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
                            $html  = '';
                            $pdf   = view('index_print')->with(['layout'=>'cetak_surat_spd','data'=>$arr]);
                            $html .= $pdf->render();
                            $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/surat perjalanan dinas/surat perjalanan dinas ($nama - $nomor_laporan - $tgl).pdf");
                            if($simpan){
                                $success++;
                            }
                            //return view('index_print',['layout'=>'cetak_surat_spd','data'=>$arr]);   
                        }
                        if($success == $item_detail->count()){
                            return '1';
                        }
                        else{
                            return '0';
                        }
                    }
                    else{
                        return '0';
                    }
                }
                else{
                    return '0';
                }    
            }
            else{
                return '0';
            }
        }
    }

    function filter_cetak_kwitansi_sppd(){
        if(Session::has('isLogin')){
            $tujuan = tujuan::all();
            
            // $black_search = array();
            // $user = User::where('id_role','!=',2)->get();
            // foreach ($user as $key => $value) {
            //     array_push($black_search, $value->id);
            // }
            // $pengguna = data_user::whereNotIn('id_user',$black_search)->get(); 
            $pengguna = data_user::all(); 

            return view('index',['layout'=>'filter_cetak_kwitansi_sppd','title_layout'=>'Simpan Kwitansi SPPD Digital','pengguna'=>$pengguna,'tujuan'=>$tujuan]);
        }
        else{
            return redirect('/');
        }
    }
    function cetak_kwitansi_sppd($filter,$id){
        if(Session::has('isLogin')){
            $tujuan = null;
            if($filter=="nama"){
                //$data_perjalanan_dinas = perjalanan_dinas::where('id_penanggung_jawab',$id)->where('status_acc',1)->get();
                $data_perjalanan_dinas = perjalanan_dinas::where('id_pemohon',$id)->where('status_acc',1)->get();
            }
            else if($filter=="tujuan"){
                $data_perjalanan_dinas = perjalanan_dinas::where('id_tujuan',$id)->where('status_acc',1)->get();
                $tujuan = tujuan::find($id);
            }
            else{
                $data_perjalanan_dinas = perjalanan_dinas::Where('tanggal', 'like', '%'.$id.'%')->where('status_acc',1)->get();
            }

            $data_user = data_user::where('id_user',$id)->first();
            $list = array();
            foreach ($data_perjalanan_dinas as $key => $value) {
                $kwitansi = kwitansi_sppd::where('id_perjalanan_dinas',$value->id)->first();

                if($kwitansi != null && $kwitansi->status==1){
                    $arr = [
                        "id" => $value->id,
                        "nomor_laporan" => $value->nomor_perjalanan_dinas,
                        "download_kwitansi" => 0,
                    ];
                    array_push($list, $arr);
                }
            }

            $data = array(
                "id_user" => $id,
                "nama" => ($data_user==null? "N/a":$data_user->nama),
                "tujuan" => ($tujuan==null? "N/a":$tujuan->tujuan),
                "tanggal" => ($filter=='tanggal'?Carbon::parse($id)->formatLocalized("%B %Y"):null),
                "filter" => $filter,
                "data" => $list 
            );

            return view('index',['layout'=>'cetak_kwitansi_sppd','title_layout'=>'Simpan Kwitansi SPPD','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //tanda tangan ok,print ok
    function execute_cetak_kwitansi_sppd($filter,$id){
        $kwitansi = kwitansi_sppd::where('id_perjalanan_dinas',$id)->first();
        $item = perjalanan_dinas::find($id);        
        $data_bendahara = data_user::where('id_user',$kwitansi->tanda_tangan_admin1)->first();
                                    // join('user', function ($join) {
                                    //             $join->on('data_user.id_user', '=', 'user.id')
                                    //             ->where('user.id_role', 6)
                                    //             // ->where('data_user.id_jabatan', 34)
                                    //             ->where('data_user.status',1);
                                    //       })->first();
        //data_user::where('id_jabatan',34)->first();
        $data_admin     = data_user::where('id_user',$kwitansi->tanda_tangan_admin2)->first();
                                    // join('user', function ($join) {
                                    //             $join->on('data_user.id_user', '=', 'user.id')
                                    //             ->where('user.id_role', 7)
                                    //             // ->where('data_user.id_jabatan', 37)
                                    //             ->where('data_user.status',1);
                                    //       })->first();
        //data_user::where('id_jabatan',37)->first();


        if($data_admin != null){
                $nip_admin          = $data_admin->nip;
                $nama_admin         = $data_admin->nama;
                $tanda_tangan_admin = ($data_admin->tanda_tangan==null? "no_signature.jpg":$data_admin->tanda_tangan);
        }
        else{
                $nip_admin          = "- - -";
                $nama_admin         = "N/a";
                $tanda_tangan_admin = "no_signature.jpg";
        }

        if($data_bendahara != null){
                $nip_bendahara          = $data_bendahara->nip;
                $nama_bendahara         = $data_bendahara->nama;
                $tanda_tangan_bendahara = ($data_bendahara->tanda_tangan==null? "no_signature.jpg":$data_bendahara->tanda_tangan);
        }
        else{
                $nip_bendahara          = "- - -";
                $nama_bendahara         = "N/a";
                $tanda_tangan_bendahara = "no_signature.jpg";
        }

        //$data_user = data_user::where('id_user',$item->id_penanggung_jawab)->first();
        $data_user = data_user::where('id_user',$item->id_pemohon)->first();
        $data_kwitansi = kwitansi_sppd::where('id_perjalanan_dinas',$id)->first();
        if($data_user != null){
            $nama                    = $data_user->nama;
            $nip                     = $data_user->nip;
            $tanda_tangan            = ($data_user->tanda_tangan==null? "no_signature.jpg":$data_user->tanda_tangan);
        }
        else{
            $nama                    = 'N/a';
            $tanda_tangan            = 'no_signature.jpg';
            $nip                     = '- - -';
        }

        $banyak_uang             = $item->biaya_akan_digunakan;
        $nomor_perjalanan_dinas  = $item->nomor_perjalanan_dinas;
        $tanggal                 = Carbon::parse($item->tanggal)->formatLocalized("%A, %d %B %Y");
        $tujuan                  = ($item->id_tujuan==null? "N/a":$item->tujuan->tujuan);
        $kegiatan                = ($item->kegiatan==null? "N/a":$item->Pagu_Anggaran->nama_kegiatan);

        $transport               = $data_kwitansi->transport;
        $penginapan_makan        = $data_kwitansi->penginapan_makan;
        $biaya_rill              = $data_kwitansi->biaya_rill;
        $uang_saku               = $data_kwitansi->uang_saku;

        $nomor_laporan = $nomor_perjalanan_dinas;
        $tgl = Carbon::parse($item->tanggal)->formatLocalized("%d %B %Y");
        $arr = [
            'banyak_uang'            => "Rp ".number_format($banyak_uang,0,'','.'),
            'nomor_perjalanan_dinas' => $nomor_perjalanan_dinas,
            'tanggal'                => $tanggal,
            'tujuan'                 => $tujuan,
            'kegiatan'               => $kegiatan,
            'transport'              => "Rp ".number_format($transport,0,'','.'),
            'penginapan_makan'       => "Rp ".number_format($penginapan_makan,0,'','.'),
            'biaya_rill'             => "Rp ".number_format($biaya_rill,0,'','.'),
            'uang_saku'              => "Rp ".number_format($uang_saku,0,'','.'),
            'total'                  => "Rp ".number_format($transport+$penginapan_makan+$biaya_rill+$uang_saku,0,'','.'),
            'total_terbilang'        => $this->terbilang($transport+$penginapan_makan+$biaya_rill+$uang_saku),
            'tanda_tangan'           => array(
                'admin'     => array('nama'=> $nama_admin,'nip'=> $nip_admin,'tanda_tangan'=>$tanda_tangan_admin),
                'bendahara' => array('nama'=> $nama_bendahara,'nip'=> $nip_bendahara,'tanda_tangan'=>$tanda_tangan_bendahara),
                'penerima'  => array('nama'=> $nama,'nip'=> $nip,'tanda_tangan'=>$tanda_tangan),
            )
        ];

        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_kwitansi_sppd','data'=>$arr]);
        $html .= $pdf->render();
        $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->save(public_path()."/kwitansi surat pengajuan perjalanan dinas/kwitansi surat pengajuan perjalanan dinas ($nama - $nomor_laporan - $tgl).pdf");
        if($simpan){
            echo "1";
        }
        else{
            echo "0";
        }

        //return view('index_print',['layout'=>'cetak_kwitansi_sppd','data'=>$arr]);
        // $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('index_print',['layout'=>'cetak_kwitansi_sppd','data'=>$arr]);
        // return $pdf->setPaper('a4', 'portrait')->stream();
    }

    function filter_cetak_cuti(){
        if(Session::has('isLogin')){
            // $black_search = array();
            // $user = User::where('id_role','!=',2)->get();
            // foreach ($user as $key => $value) {
            //     array_push($black_search, $value->id);
            // }
            // $pengguna = data_user::whereNotIn('id_user',$black_search)->get(); 
            $pengguna = data_user::all(); 

            return view('index',['layout'=>'filter_cetak_cuti','title_layout'=>'Simpan Laporan Cuti Digital','pengguna'=>$pengguna]);
        }
        else{
            return redirect('/');
        }
    }
    function cetak_cuti($filter,$id){
        if(Session::has('isLogin')){
            if($filter=="nama"){
                $data_cuti = cuti::where('id_user',$id)->where('status_acc1',1)->where('status_acc2',1)->get();
            }
            else{
                $data_cuti = cuti::Where('tanggal', 'like', '%'.$id.'%')->where('status_acc1',1)->where('status_acc2',1)->get();
            }

            $data_user = data_user::where('id_user',$id)->first();
            $list = array();
            foreach ($data_cuti as $key => $value) {
                $arr = [
                    "id" => $value->id,
                    "nomor_laporan" => $value->nomor_laporan,
                    "download_cuti" => 0,
                ];
                array_push($list, $arr);
            }

            $data = array(
                "id_user" => $id,
                "nama" => ($data_user==null? "N/a":$data_user->nama),
                "tanggal" => ($filter=='tanggal'?Carbon::parse($id)->formatLocalized("%B %Y"):null),
                "filter" => $filter,
                "data" => $list 
            );

            return view('index',['layout'=>'cetak_cuti','title_layout'=>'Simpan Laporan Cuti','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    //tanda tangan ok
    function execute_cetak_cuti($filter,$id){
        $data_cuti = cuti::find($id);
        $pengguna = $this->getPengguna($data_cuti->id_user);
        $total = $data_cuti->cuti_n+$data_cuti->cuti_n1+$data_cuti->cuti_n2;

        $data_admin1 = data_user::where('id_user',$data_cuti->tanda_tangan_admin1)->first();
        if($data_admin1 != null){
            $nip_admin1      = $data_admin1->nip;
            $nama_admin1     = $data_admin1->nama;
            $tanda_tangan1   = ($data_admin1->tanda_tangan==null? "no_signature.jpg":$data_admin1->tanda_tangan);
        }
        else{
            $nip_admin1      = "- - -";
            $nama_admin1     = "N/a";
            $tanda_tangan1   = "no_signature.jpg";
        }

        $data_admin2 = data_user::where('id_user',$data_cuti->tanda_tangan_admin2)->first();
        if($data_admin2 != null){
            $nip_admin2      = $data_admin2->nip;
            $nama_admin2     = $data_admin2->nama;
            $tanda_tangan2   = ($data_admin2->tanda_tangan==null? "no_signature.jpg":$data_admin2->tanda_tangan);
        }
        else{
            $nip_admin2      = "- - -";
            $nama_admin2     = "N/a";
            $tanda_tangan2   = "no_signature.jpg";
        }

        $nomor_laporan = $data_cuti->nomor_laporan;
        $tgl = Carbon::parse($data_cuti->tanggal)->formatLocalized("%d %B %Y");
        $nama = ($pengguna==null? "??":$pengguna['nama']);

        $data = array(
            'create'=>Carbon::parse($data_cuti->created_at)->formatLocalized("%A, %d %B %Y"),
            'nama'=>$pengguna['nama'],
            'jabatan'=>$pengguna['jabatan'],
            'unit'=>$pengguna['golongan'],
            'nip'=>$pengguna['nip'],
            'masa_kerja'=>$pengguna['masa_kerja'],
            'jenis_cuti'=>$data_cuti->id_jenis_cuti,
            'alasan'=>$data_cuti->alasan,
            'selama'=>$total,
            'alamat_cuti'=>$data_cuti->alamat_cuti,
            'telp'=>$data_cuti->telp,
            'tanggal_awal'=>Carbon::parse($data_cuti->tanggal)->formatLocalized("%A, %d %B %Y"),
            'tanggal_akhir'=>Carbon::parse($data_cuti->tanggal)->addDays($total-1)->formatLocalized("%A, %d %B %Y"),
            'penerima'      => array('nama'=> $pengguna['nama'],'nip'=> $pengguna['nip'],'tanda_tangan'=>$pengguna['tanda_tangan']),
            'data_cuti'=>[
                'n'=>$pengguna['cuti_n'],
                'n1'=>$pengguna['cuti_n1'],
                'n2'=>$pengguna['cuti_n2']
            ],
            'acc1'=>[
                'status' =>$data_cuti->status_acc1,
                'alasan' =>$data_cuti->catatan_acc1,
                'tanda_tangan' =>[
                    'nip'=>$nip_admin1,
                    'nama'=>$nama_admin1,
                    'tanda_tangan'=>$tanda_tangan1,
                ]
            ],
            'acc2'=>[
                'status' =>$data_cuti->status_acc2,
                'alasan' =>$data_cuti->catatan_acc2,
                'tanda_tangan' =>[
                    'nip'=>$nip_admin2,
                    'nama'=>$nama_admin2,
                    'tanda_tangan'=>$tanda_tangan2
                ]
            ]
        );


        $html  = '';
        $pdf   = view('index_print')->with(['layout'=>'cetak_laporan_cuti','data'=>$data]);
        $html .= $pdf->render();
        $simpan = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadHTML($html)->setPaper(array(0,0,609.4488,935.433), 'portrait')->save(public_path()."/surat cuti/surat cuti ($nama - $nomor_laporan - $tgl).pdf");
        if($simpan){
            echo "1";
        }
        else{
            echo "0";
        }

        // $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('index_print',['layout'=>'cetak_laporan_cuti','data'=>$data]);
        // return $pdf->setPaper(array(0,0,609.4488,935.433), 'portrait')->stream();
        //return $pdf->setPaper('A4', 'portrait')->stream();
    }

    function akun_pribadi(){
        if(Session::has('isLogin')){
            $data = User::find(Session::get('id'));
            return view('index',['layout'=>'akun_pribadi','title_layout'=>'Akun Pribadi','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function ubah_akun(Request $req){
        if(Session::has('isLogin')){
            $username   = $req->username;
            $password   = $req->password;
            $email      = $req->email;

            $user = User::find(Session::get('id'));
            $user->username = $username;
            if($password != ""){
                $user->password = \Hash::make($password);
            }
            $user->email    = $email;
            if($user->save()){
                return redirect('/admin/akun_pribadi')->with(['type_msg'=>1, 'msg' => 'Berhasil Simpan']);
            }
            else{
                return redirect('/admin/akun_pribadi')->with('type_msg',0)->with('msg','Gagal simpan');
            }
        }
        else{
            return redirect('/');
        }
    }

    function direct_download($laporan,$id){
        if($laporan=="sppd"){
            return $this->download_cetak_sppd($id);
        }
        if($laporan=="surat_tugas"){
            return $this->download_cetak_surat_tugas($id);
        }
        if($laporan=="spd"){
            return $this->download_cetak_laporan_spd($id);
        }
        if($laporan=="kwitansi"){
            return $this->download_cetak_kwitansi_sppd($id);
        }
        if($laporan=="cuti"){
            return $this->download_cetak_cuti($id);
        }
        if($laporan=="kendaraan"){
            return $this->download_cetak_pinjam_kendaraan($id);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function index_(){
        if(Session::has('isLogin'))
           return view('index',['layout'=>'beranda_super_admin','title_layout'=>'Beranda']);
        else
            return redirect('/'); 
    }
    
    function pengguna_(){
        if(Session::has('isLogin')){
            $data = data_user::all();
            return view('index',['layout'=>'pengguna_super_admin','title_layout'=>'Pengguna','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_pengguna_(){
        if(Session::has('isLogin')){
            $data_agama = agama::all();
            $data_golongan = golongan::all();
            $data_pangkat = pangkat::all();
            $data_jabatan = jabatan::all();
            $data_jenjang_pendidikan = jenjang_pendidikan::all();
            $data_akun = User::all();

            return view('index',['layout'=>'add_pengguna_super_admin','title_layout'=>'Tambah Pengguna','agama'=>$data_agama,'golongan'=>$data_golongan,'pangkat'=>$data_pangkat,'jabatan'=>$data_jabatan,'pendidikan'=>$data_jenjang_pendidikan,'akun'=>$data_akun]);
        }
        else{
            return redirect('/');
        }
    }
    function edit_pengguna_($id){
        if(Session::has('isLogin')){
            $data = data_user::find($id);
            $data_agama = agama::all();
            $data_golongan = golongan::all();
            $data_pangkat = pangkat::all();
            $data_jabatan = jabatan::all();
            $data_akun = User::all();

            $data_jenjang_pendidikan = jenjang_pendidikan::all();
            return view('index',['layout'=>'edit_pengguna_super_admin','title_layout'=>'Ubah Pengguna','data'=>$data,'agama'=>$data_agama,'golongan'=>$data_golongan,'pangkat'=>$data_pangkat,'jabatan'=>$data_jabatan,'pendidikan'=>$data_jenjang_pendidikan,'akun'=>$data_akun]);
        }
        else{
            return redirect('/');
        }
    }
    function store_pengguna_(Request $req){
        try {
            $nip                    = $req->nip;
            $akun                   = ($req->akun==-1?null:$req->akun);
            $nama                   = $req->nama;
            $agama                  = $req->agama; 
            $jenjang_pendidikan     = $req->jenjang_pendidikan;
            $nama_sekolah           = $req->nama_sekolah;
            $tahun_lulus            = $req->tahun_lulus;
            $jabatan                = $req->jabatan;
            $pangkat                = $req->pangkat;
            $golongan               = $req->golongan;
            $tmt                    = $req->tmt;
            $masa_kerja             = $req->masa_kerja;
            $alamat                 = $req->alamat;
            $status                 = $req->status;
            $tanggal_lahir          = $req->tanggal_lahir;
            $tanda_tangan           = $req->file('tanda_tangan'); 
            if($tanda_tangan != null)
                $name_file              = $nip.'.'.$tanda_tangan->getClientOriginalExtension();
            
            $data_user                          = new data_user();
            $data_user->id_user                 = $akun;
            $data_user->nip                     = $nip;
            $data_user->nama                    = $nama;
            $data_user->tgl_lahir               = $tanggal_lahir;
            $data_user->id_agama                = $agama;
            $data_user->id_jenjang_pendidikan   = $jenjang_pendidikan;
            $data_user->nama_sekolah            = $nama_sekolah;
            $data_user->tahun_lulus             = $tahun_lulus;
            $data_user->id_jabatan              = $jabatan;
            $data_user->id_pangkat              = $pangkat;
            $data_user->id_golongan             = $golongan;
            $data_user->tmt                     = $tmt;
            $data_user->masa_kerja              = $masa_kerja;
            $data_user->alamat                  = $alamat;
            if($tanda_tangan != null)
                $data_user->tanda_tangan            = $name_file;
            $data_user->status                  = $status;

            if($data_user->save()){
                if($tanda_tangan != null)
                    $tanda_tangan->move(public_path().'/storage',$name_file);

                return redirect('/super_admin/pengguna')->with('type_msg',1)->with('msg','Berhasil Simpan');
            }
            else{
                return redirect('/super_admin/pengguna')->with('type_msg',0)->with('msg','Gagal Simpan');
            }
        } catch (Exception $e) {
            return redirect('/super_admin/pengguna')->with('type_msg',0)->with('msg','Gagal Simpan');            
        }
    }
    function update_pengguna_(Request $req){
        try {
            $id                     = $req->id;
            $akun                   = ($req->akun==-1?null:$req->akun);
            $nip                    = $req->nip;
            $nama                   = $req->nama;
            $agama                  = $req->agama; 
            $jenjang_pendidikan     = $req->jenjang_pendidikan;
            $nama_sekolah           = $req->nama_sekolah;
            $tahun_lulus            = $req->tahun_lulus;
            $jabatan                = $req->jabatan;
            $pangkat                = $req->pangkat;
            $golongan               = $req->golongan;
            $tmt                    = $req->tmt;
            $masa_kerja             = $req->masa_kerja;
            $alamat                 = $req->alamat;
            $status                 = $req->status;
            $tanggal_lahir          = $req->tanggal_lahir;
            $tanda_tangan           = $req->file('tanda_tangan'); 
            if($tanda_tangan != null)
                $name_file              = $nip.'.'.$tanda_tangan->getClientOriginalExtension();

            $data_user                          = data_user::find($id);
            $data_user->id_user                 = $akun;
            $data_user->nip                     = $nip;
            $data_user->nama                    = $nama;
            $data_user->tgl_lahir               = $tanggal_lahir;
            $data_user->id_agama                = $agama;
            $data_user->id_jenjang_pendidikan   = $jenjang_pendidikan;
            $data_user->nama_sekolah            = $nama_sekolah;
            $data_user->tahun_lulus             = $tahun_lulus;
            $data_user->id_jabatan              = $jabatan;
            $data_user->id_pangkat              = $pangkat;
            $data_user->id_golongan             = $golongan;
            $data_user->tmt                     = $tmt;
            $data_user->masa_kerja              = $masa_kerja;
            $data_user->alamat                  = $alamat;
            if($tanda_tangan != null)
                $data_user->tanda_tangan            = $name_file;
            $data_user->status                  = $status;

            if($data_user->save()){
                if($tanda_tangan != null)
                    $tanda_tangan->move(public_path().'/storage',$name_file);

                return redirect('/super_admin/pengguna')->with('type_msg',1)->with('msg','Berhasil Ubah');
            }
            else{
                return redirect('/super_admin/pengguna')->with('type_msg',0)->with('msg','Gagal Ubah');
            }
        } catch (Exception $e) {
            return redirect('/super_admin/pengguna')->with('type_msg',0)->with('msg','Gagal Ubah');
        }
    }
    function delete_pengguna_($id){
        $data_user = data_user::find($id);
        if($data_user->delete()){
            return redirect('/super_admin/pengguna')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/pengguna')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function akun_(){
        if(Session::has('isLogin')){
            $data = User::all();
            return view('index',['layout'=>'akun_super_admin','title_layout'=>'Akun','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_akun_(){
        if(Session::has('isLogin')){
            $data_role = role::all();
            return view('index',['layout'=>'add_akun_super_admin','title_layout'=>'Tambah Akun','role'=>$data_role]);
        }
        else{
            return redirect('/');
        }
    }
    function edit_akun_($id){
        if(Session::has('isLogin')){
            $data = User::find($id);
            $data_role = role::all();
            return view('index',['layout'=>'edit_akun_super_admin','title_layout'=>'Ubah Akun','data'=>$data,'role'=>$data_role]);
        }
        else{
            return redirect('/');
        }
    }
    function store_akun_(Request $req){
        $username   = $req->username;
        $password   = $req->password;
        $email      = $req->email;
        $level      = $req->level;

        $user = new User();
        $user->username = $username;
        $user->password = \Hash::make($password);
        $user->email    = $email;
        $user->id_role  = $level;

        if($user->save()){
            return redirect('/super_admin/akun')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/akun')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_akun_(Request $req){
        $id         = $req->id;
        $username   = $req->username;
        $password   = $req->password;
        $email      = $req->email;
        $level      = $req->level;

        $user = User::find($id);
        $user->username = $username;
        $user->password = \Hash::make($password);
        $user->email    = $email;
        $user->id_role  = $level;

        if($user->save()){
            return redirect('/super_admin/akun')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/akun')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_akun_($id){
        $user = User::find($id);
        if($user->delete()){
            return redirect('/super_admin/akun')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/akun')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    function pagu_anggaran_(){
        if(Session::has('isLogin')){
            $pagu_anggaran = pagu_anggaran::all();
            $data = array();
            foreach($pagu_anggaran as $pagu_anggaran){
                $data_user = data_user::where('id_user',$pagu_anggaran->id_user)->first();
                $arr = [
                    "id"                => $pagu_anggaran->id,    
                    "kode"              => $pagu_anggaran->kode,    
                    "nama_kegiatan"     => $pagu_anggaran->nama_kegiatan,    
                    "penanggung_jawab"  => ($data_user==null? "-":$data_user->nama),    
                    "total_biaya"       => $pagu_anggaran->total_biaya,    
                    "sisa_biaya"        => $pagu_anggaran->sisa_biaya,    
                    "tanggal"           => $pagu_anggaran->tanggal  
                ];
                array_push($data,$arr);
            }
            return view('index',['layout'=>'pagu_anggaran_super_admin','title_layout'=>'Pagu Anggaran','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_pagu_anggaran_(){
        if(Session::has('isLogin')){
            $data_user = data_user::all();
            return view('index',['layout'=>'add_pagu_anggaran_super_admin','title_layout'=>'Tambah Pagu Anggaran','data_user'=>$data_user]);
        }
        else{
            return redirect('/');
        }
    }
    function edit_pagu_anggaran_($id){
        if(Session::has('isLogin')){
            $data = pagu_anggaran::find($id);
            $data_user = data_user::all();
            return view('index',['layout'=>'edit_pagu_anggaran_super_admin','title_layout'=>'Ubah Pagu Anggaran','data'=>$data,'data_user'=>$data_user]);
        }
        else{
            return redirect('/');
        }
    }
    function store_pagu_anggaran_(Request $req){
        $kode               = $req->kode_kegiatan;
        $nama_kegiatan      = $req->nama_kegiatan;
        $penanggung_jawab   = $req->penanggung_jawab;
        $total_biaya        = $req->total_biaya;
        $sisa_biaya         = $req->sisa_biaya;

        $pagu_anggaran                 = new pagu_anggaran();
        $pagu_anggaran->kode           = $kode;
        $pagu_anggaran->nama_kegiatan  = $nama_kegiatan;
        $pagu_anggaran->id_user        = $penanggung_jawab;
        $pagu_anggaran->total_biaya    = $total_biaya;
        $pagu_anggaran->sisa_biaya     = $sisa_biaya;

        if($pagu_anggaran->save()){
            return redirect('/super_admin/pagu_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/pagu_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_pagu_anggaran_(Request $req){
        $id                 = $req->id;
        $kode               = $req->kode_kegiatan;
        $nama_kegiatan      = $req->nama_kegiatan;
        $penanggung_jawab   = $req->penanggung_jawab;
        $total_biaya        = $req->total_biaya;
        $sisa_biaya         = $req->sisa_biaya;

        $pagu_anggaran                 = pagu_anggaran::find($id);
        $pagu_anggaran->kode           = $kode;
        $pagu_anggaran->nama_kegiatan  = $nama_kegiatan;
        $pagu_anggaran->id_user        = $penanggung_jawab;
        $pagu_anggaran->sisa_biaya     = $sisa_biaya;
        $pagu_anggaran->total_biaya    = $total_biaya;
        // if($total_biaya >= $pagu_anggaran->total_biaya){
        //     $pagu_anggaran->sisa_biaya    = $pagu_anggaran->sisa_biaya + ($total_biaya - $pagu_anggaran->total_biaya);
        //     $pagu_anggaran->total_biaya   = $total_biaya;
        // }
        // else{
        //     $pagu_anggaran->sisa_biaya    = $pagu_anggaran->sisa_biaya - ($pagu_anggaran->total_biaya - $total_biaya);
        //     $pagu_anggaran->total_biaya   = $total_biaya;
        // } -> migrasi ke pemotongan anggaran

        if($pagu_anggaran->save()){
            return redirect('/super_admin/pagu_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/pagu_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_pagu_anggaran_($id){
        $tujuan = pagu_anggaran::find($id);
        if($tujuan->delete()){
            return redirect('/super_admin/pagu_anggaran')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/pagu_anggaran')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    function potong_anggaran_($id){
        if(Session::has('isLogin')){
            $pagu_anggaran = pagu_anggaran::find($id);
            $data = potong_anggaran::where('id_pagu_anggaran',$id)->where( DB::raw('YEAR(created_at)'), DB::raw('YEAR(now())') )->get();
            return view('index',['layout'=>'potong_anggaran_super_admin','title_layout'=>'Tambah Potong Pagu Anggaran','data'=>$data,'pagu_anggaran'=>$pagu_anggaran]);
        }
        else{
            return redirect('/');
        }
    }
    function add_potong_anggaran_($id){
        if(Session::has('isLogin')){
            $data = pagu_anggaran::find($id);
            return view('index',['layout'=>'add_potong_anggaran_super_admin','title_layout'=>'Tambah Potong Pagu Anggaran','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function store_potong_anggaran_(Request $req){
        $id                     = $req->id;
        $keterangan             = $req->keterangan;
        $jumlah_biaya_potong    = $req->jumlah_biaya_potong;
        
        $data = array();        
        for($i=0;$i<count($keterangan);$i++) {
            $arr = [
                'id_pagu_anggaran'=>$id,
                'keterangan'=>($keterangan[$i]==null?"-":$keterangan[$i]),
                'jumlah_biaya'=>$jumlah_biaya_potong[$i],
                'created_at'=>Carbon::now()->formatLocalized("%Y-%m-%d %H:%M:%S"), //translatedFormat('Y-m-d H:i:s')
            ];
            array_push($data, $arr);
        }
        if(potong_anggaran::insert($data)){
            return redirect("/super_admin/potong_anggaran/$id")->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect("/super_admin/potong_anggaran/$id")->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_potong_anggaran_(Request $req){
        $id = $req->id;
        $delete = potong_anggaran::find($id);
        if($delete->delete()){
            return redirect("/super_admin/potong_anggaran/$id")->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect("/super_admin/potong_anggaran/$id")->with('type_msg',0)->with('msg','Gagal Hapus');
        }   
    }


    function tujuan_anggaran_(){
        if(Session::has('isLogin')){
            $data = tujuan::all();
            return view('index',['layout'=>'tujuan_anggaran_super_admin','title_layout'=>'Tujuan Anggaran','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_tujuan_anggaran_(){
        if(Session::has('isLogin')){
            return view('index',['layout'=>'add_tujuan_anggaran_super_admin','title_layout'=>'Tambah Tujuan Anggaran']);
        }
        else{
            return redirect('/');
        }
    }
    function edit_tujuan_anggaran_($id){
        if(Session::has('isLogin')){
            $data = tujuan::find($id);
            return view('index',['layout'=>'edit_tujuan_anggaran_super_admin','title_layout'=>'Ubah Tujuan Anggaran','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function store_tujuan_anggaran_(Request $req){
        $nama_tujuan        = $req->nama_tujuan;
        $tujuan             = new tujuan();
        $tujuan->tujuan     = $nama_tujuan;

        if($tujuan->save()){
            return redirect('/super_admin/tujuan_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/tujuan_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_tujuan_anggaran_(Request $req){
        $id           = $req->id;
        $nama_tujuan  = $req->nama_tujuan;

        $tujuan         = tujuan::find($id);
        $tujuan->tujuan = $nama_tujuan;

        if($tujuan->save()){
            return redirect('/super_admin/tujuan_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/tujuan_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_tujuan_anggaran_($id){
        $tujuan = tujuan::find($id);
        if($tujuan->delete()){
            return redirect('/super_admin/tujuan_anggaran')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/tujuan_anggaran')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function jenis_anggaran_(){
        if(Session::has('isLogin')){
            $data = jenis_anggaran::all();
            return view('index',['layout'=>'jenis_anggaran_super_admin','title_layout'=>'Jenis Anggaran','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_jenis_anggaran_(){
        if(Session::has('isLogin')){
            return view('index',['layout'=>'add_jenis_anggaran_super_admin','title_layout'=>'Tambah Jenis Anggaran']);
        }
        else{
            return redirect('/');
        }
    }
    function edit_jenis_anggaran_($id){
        if(Session::has('isLogin')){
            $data = jenis_anggaran::find($id);
            return view('index',['layout'=>'edit_jenis_anggaran_super_admin','title_layout'=>'Ubah Jenis Anggaran','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function store_jenis_anggaran_(Request $req){
        $nama_anggaran          = $req->nama_anggaran;
        $type                   = $req->type;
        $jenis_anggaran         = new jenis_anggaran();
        $jenis_anggaran->nama   = $nama_anggaran;
        $jenis_anggaran->type   = $type;

        if($jenis_anggaran->save()){
            return redirect('/super_admin/jenis_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_jenis_anggaran_(Request $req){
        $id                   = $req->id;
        $nama_anggaran        = $req->nama_anggaran;
        $type                 = $req->type;

        $jenis_anggaran         = jenis_anggaran::find($id);
        $jenis_anggaran->nama   = $nama_anggaran;
        $jenis_anggaran->type   = $type;

        if($jenis_anggaran->save()){
            return redirect('/super_admin/jenis_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_jenis_anggaran_($id){
        $jenis_anggaran = jenis_anggaran::find($id);
        if($jenis_anggaran->delete()){
            return redirect('/super_admin/jenis_anggaran')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/jenis_anggaran')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function jenis_golongan_(){
        if(Session::has('isLogin')){
            $data = golongan::all();
            return view('index',['layout'=>'jenis_golongan_super_admin','title_layout'=>'Golongan','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_jenis_golongan_(){
        if(Session::has('isLogin')){
            return view('index',['layout'=>'add_jenis_golongan_super_admin','title_layout'=>'Tambah Golongan']);
        }
        else{
            return redirect('/');
        }
    }
    function edit_jenis_golongan_($id){
        if(Session::has('isLogin')){
            $data = golongan::find($id);
            return view('index',['layout'=>'edit_jenis_golongan_super_admin','title_layout'=>'Ubah Golongan','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function store_jenis_golongan_(Request $req){
        $nama_golongan          = $req->nama_golongan;
        $jenis_golongan         = new golongan();
        $jenis_golongan->golongan   = $nama_golongan;

        if($jenis_golongan->save()){
            return redirect('/super_admin/jenis_golongan')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_golongan')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_jenis_golongan_(Request $req){
        $id                   = $req->id;
        $nama_golongan        = $req->nama_golongan;

        $jenis_golongan       = golongan::find($id);
        $jenis_golongan->golongan = $nama_golongan;

        if($jenis_golongan->save()){
            return redirect('/super_admin/jenis_golongan')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_golongan')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_jenis_golongan_($id){
        $jenis_golongan = golongan::find($id);
        if($jenis_golongan->delete()){
            return redirect('/super_admin/jenis_golongan')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/jenis_golongan')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function jenis_gratifikasi_(){
        if(Session::has('isLogin')){
            $data = jenis_gratifikasi::all();
            return view('index',['layout'=>'jenis_gratifikasi_super_admin','title_layout'=>'Jenis Gratifikasi','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_jenis_gratifikasi_(){
        if(Session::has('isLogin')){
            return view('index',['layout'=>'add_jenis_gratifikasi_super_admin','title_layout'=>'Tambah Jenis Gratifikasi']);
        }
        else{
            return redirect('/');
        }
    }
    function edit_jenis_gratifikasi_($id){
        if(Session::has('isLogin')){
            $data = jenis_gratifikasi::find($id);
            return view('index',['layout'=>'edit_jenis_gratifikasi_super_admin','title_layout'=>'Ubah Jenis Gratifikasi','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function store_jenis_gratifikasi_(Request $req){
        $nama_jenis_gratifikasi     = $req->nama_jenis_gratifikasi;
        $jenis_gratifikasi          = new jenis_gratifikasi();
        $jenis_gratifikasi->nama    = $nama_jenis_gratifikasi;

        if($jenis_gratifikasi->save()){
            return redirect('/super_admin/jenis_gratifikasi')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_gratifikasi')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_jenis_gratifikasi_(Request $req){
        $id                             = $req->id;
        $nama_jenis_gratifikasi         = $req->nama_jenis_gratifikasi;

        $jenis_gratifikasi              = jenis_gratifikasi::find($id);
        $jenis_gratifikasi->nama        = $nama_jenis_gratifikasi;

        if($jenis_gratifikasi->save()){
            return redirect('/super_admin/jenis_gratifikasi')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_gratifikasi')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_jenis_gratifikasi_($id){
        $jenis_gratifikasi = jenis_gratifikasi::find($id);
        if($jenis_gratifikasi->delete()){
            return redirect('/super_admin/jenis_gratifikasi')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/jenis_gratifikasi')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function jenis_jabatan_(){
        if(Session::has('isLogin')){
            $data = jabatan::all();
            return view('index',['layout'=>'jenis_jabatan_super_admin','title_layout'=>'Jabatan','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_jenis_jabatan_(){
        if(Session::has('isLogin')){
            return view('index',['layout'=>'add_jenis_jabatan_super_admin','title_layout'=>'Tambah Jabatan']);
        }
        else{
            return redirect('/');
        }
    }
    function edit_jenis_jabatan_($id){
        if(Session::has('isLogin')){
            $data = jabatan::find($id);
            return view('index',['layout'=>'edit_jenis_jabatan_super_admin','title_layout'=>'Ubah Jabatan','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function store_jenis_jabatan_(Request $req){
        $nama_jabatan     = $req->nama_jabatan;
        $jabatan          = new jabatan();
        $jabatan->jabatan = $nama_jabatan;

        if($jabatan->save()){
            return redirect('/super_admin/jenis_jabatan')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_jabatan')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_jenis_jabatan_(Request $req){
        $id                   = $req->id;
        $nama_jabatan         = $req->nama_jabatan;

        $jabatan              = jabatan::find($id);
        $jabatan->jabatan     = $nama_jabatan;

        if($jabatan->save()){
            return redirect('/super_admin/jenis_jabatan')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_jabatan')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_jenis_jabatan_($id){
        $jabatan = jabatan::find($id);
        if($jabatan->delete()){
            return redirect('/super_admin/jenis_jabatan')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/jenis_jabatan')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function jenis_pangkat_(){
        if(Session::has('isLogin')){
            $data = pangkat::all();
            return view('index',['layout'=>'jenis_pangkat_super_admin','title_layout'=>'Pangkat','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_jenis_pangkat_(){
        if(Session::has('isLogin')){
            return view('index',['layout'=>'add_jenis_pangkat_super_admin','title_layout'=>'Tambah Pangkat']);
        }
        else{
            return redirect('/');
        }
    }
    function edit_jenis_pangkat_($id){
        if(Session::has('isLogin')){
            $data = pangkat::find($id);
            return view('index',['layout'=>'edit_jenis_pangkat_super_admin','title_layout'=>'Ubah Pangkat','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function store_jenis_pangkat_(Request $req){
        $nama_pangkat     = $req->nama_pangkat;
        $pangkat          = new pangkat();
        $pangkat->pangkat = $nama_pangkat;

        if($pangkat->save()){
            return redirect('/super_admin/jenis_pangkat')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_pangkat')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_jenis_pangkat_(Request $req){
        $id                   = $req->id;
        $nama_pangkat         = $req->nama_pangkat;

        $pangkat              = pangkat::find($id);
        $pangkat->pangkat     = $nama_pangkat;

        if($pangkat->save()){
            return redirect('/super_admin/jenis_pangkat')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/jenis_pangkat')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_jenis_pangkat_($id){
        $pangkat = pangkat::find($id);
        if($pangkat->delete()){
            return redirect('/super_admin/jenis_pangkat')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/jenis_pangkat')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function pengemudi_(){
        if(Session::has('isLogin')){
            $data = array();
            $list = pengemudi::all();
            foreach ($list as $key => $value) {
                $nama = 'N/a';
                if($value != null){
                    $data_user = data_user::where('id_user',$value->id_user)->first();     
                    $nama = ($value->id_user==null?"N/a":$data_user->nama);
                }
                $arr = [
                    'id'=>$value->id,
                    'nama'=>$nama,
                    'jenis_kendaraan'=>$value->jenis_kendaraan,
                    'no_polisi'=>$value->no_polisi,
                    'status'=>$value->status
                ];
                array_push($data, $arr);
            }
            return view('index',['layout'=>'pengemudi_super_admin','title_layout'=>'Pengemudi','datas'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function add_pengemudi_(){
        if(Session::has('isLogin')){
            $data_user = data_user::all();
            return view('index',['layout'=>'add_pengemudi_super_admin','title_layout'=>'Tambah Pengemudi','pengguna'=>$data_user]);
        }
        else{
            return redirect('/');
        }
    }
    function edit_pengemudi_($id){
        if(Session::has('isLogin')){
            $data = pengemudi::find($id);
            $data_user = data_user::all();
            return view('index',['layout'=>'edit_pengemudi_super_admin','title_layout'=>'Ubah Pengemudi','data'=>$data,'pengguna'=>$data_user]);
        }
        else{
            return redirect('/');
        }
    }
    function store_pengemudi_(Request $req){
        $pengguna           = ($req->pengguna==-1?null:$req->pengguna);
        $jenis_kendaraan    = $req->jenis_kendaraan;
        $nomor_polisi       = $req->nomor_polisi;
        $status             = $req->status;

        $pengemudi                  = new pengemudi();
        $pengemudi->id_user         = $pengguna;
        $pengemudi->jenis_kendaraan = $jenis_kendaraan;
        $pengemudi->no_polisi       = $nomor_polisi;
        $pengemudi->status          = $status;

        if($pengemudi->save()){
            return redirect('/super_admin/pengemudi')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/pengemudi')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_pengemudi_(Request $req){
        $id                 = $req->id;
        $pengguna           = ($req->pengguna==-1?null:$req->pengguna);
        $jenis_kendaraan    = $req->jenis_kendaraan;
        $nomor_polisi       = $req->nomor_polisi;
        $status             = $req->status;

        $pengemudi                  = pengemudi::find($id);
        $pengemudi->id_user         = $pengguna;
        $pengemudi->jenis_kendaraan = $jenis_kendaraan;
        $pengemudi->no_polisi       = $nomor_polisi;
        $pengemudi->status          = $status;

        if($pengemudi->save()){
            return redirect('/super_admin/pengemudi')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/pengemudi')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_pengemudi_($id){
        $pengemudi = pengemudi::find($id);
        if($pengemudi->delete()){
            return redirect('/super_admin/pengemudi')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/pengemudi')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    //x
    function biaya_anggaran_(){
        if(Session::has('isLogin')){
            $list = array();
            $datas = anggaran::all();
            for ($i=0; $i < $datas->count(); $i++) { 
                $arr = [
                    'id' =>$datas[$i]->id,
                    'nama_anggaran' =>$datas[$i]->jenis_anggaran->nama,
                    'id_tujuan' =>$datas[$i]->id_tujuan,
                    'nama_tujuan' =>$datas[$i]->tujuan->tujuan,
                    'biaya' => "Rp " . number_format($datas[$i]->biaya,0,'','.') 
                ];
                array_push($list, $arr);
            }

            return view('index',['layout'=>'biaya_anggaran_super_admin','title_layout'=>'Biaya Anggaran','datas'=>$this->group_data($list, 'nama_tujuan')]);
        }
        else{
            return redirect('/');
        }
    }
    function add_biaya_anggaran_(){
        if(Session::has('isLogin')){
            $data_tujuan = tujuan::all();
            $data_jenis_anggaran = jenis_anggaran::all();
            return view('index',['layout'=>'add_biaya_anggaran_super_admin','title_layout'=>'Tambah Biaya Anggaran','tujuan'=>$data_tujuan,'jenis_anggaran'=>$data_jenis_anggaran]);
        }
        else{
            return redirect('/');
        }
    }
    function edit_biaya_anggaran_($id_tujuan){
        if(Session::has('isLogin')){
            $data = anggaran::where('id_tujuan',$id_tujuan)->get();
            $anggaran = array(); 
            foreach ($data as $key => $value) {
                array_push($anggaran, array('id_jenis_anggaran'=> $value->id_jenis_anggaran,'biaya'=> $value->biaya));
            }
            $datas = [
                'id_tujuan'=> $id_tujuan,
                'nama_tujuan'=> $data[0]->tujuan->tujuan,
                'data_anggaran' => $anggaran
            ];

            $data_tujuan = tujuan::all();
            $data_jenis_anggaran = jenis_anggaran::all();
            return view('index',['layout'=>'edit_biaya_anggaran_super_admin','title_layout'=>'Tambah Biaya Anggaran','tujuan'=>$data_tujuan,'jenis_anggaran'=>$data_jenis_anggaran,'datas'=>$datas]);
        }
        else{
            return redirect('/');
        }
    }
    function store_biaya_anggaran_(Request $req){
        $tujuan     = $req->tujuan;
        $anggaran   = $req->anggaran;
        $biaya      = $req->biaya;

        $data = array();
        for($i=0;$i<count($anggaran);$i++){
            array_push($data, array('id_jenis_anggaran'=>$anggaran[$i],'id_tujuan'=>$tujuan,'biaya'=>$biaya[$i]));
        }

        if(anggaran::insert($data)){
            return redirect('/super_admin/biaya_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/biaya_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function update_biaya_anggaran_(Request $req){
        $id_tujuan  = $req->id;
        $tujuan     = $req->tujuan;
        $anggaran   = $req->anggaran;
        $biaya      = $req->biaya;

        $data = array();
        for($i=0;$i<count($anggaran);$i++){
            array_push($data, array('id_jenis_anggaran'=>$anggaran[$i],'id_tujuan'=>$tujuan,'biaya'=>$biaya[$i]));
        }

        $hapus = anggaran::where('id_tujuan',$id_tujuan);
        if($hapus->delete()){
            if(anggaran::insert($data)){
                return redirect('/super_admin/biaya_anggaran')->with('type_msg',1)->with('msg','Berhasil Simpan');
            }
            else{
                return redirect('/super_admin/biaya_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
            }
        }
        else{
            return redirect('/super_admin/biaya_anggaran')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }
    function delete_biaya_anggaran_($id_tujuan){
        $id_tujuan = $id_tujuan;
        $hapus = anggaran::where('id_tujuan',$id_tujuan);
        if($hapus->delete()){
            return redirect('/super_admin/biaya_anggaran')->with('type_msg',1)->with('msg','Berhasil Hapus');
        }
        else{
            return redirect('/super_admin/biaya_anggaran')->with('type_msg',0)->with('msg','Gagal Hapus');
        }
    }

    function cuti_(){
        if(Session::has('isLogin')){
            $datas = data_user::all();
            return view('index',['layout'=>'cuti_super_admin','title_layout'=>'Cuti','datas'=>$datas]);
        }
        else{
            return redirect('/');
        }
    }
    function edit_cuti_($id_tujuan){
        if(Session::has('isLogin')){
            $data = data_user::find($id_tujuan);
            return view('index',['layout'=>'edit_cuti_super_admin','title_layout'=>'Ubah Cuti','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function update_cuti_(Request $req){
        $id         = $req->id;
        $cuti_n     = $req->cuti_n;
        $cuti_n1    = $req->cuti_n1;
        $cuti_n2    = $req->cuti_n2;

        $update = data_user::find($id);
        $update->cuti_n = $cuti_n;
        $update->cuti_n1 = $cuti_n1;
        $update->cuti_n2 = $cuti_n2;

        if($update->save()){
            return redirect('/super_admin/cuti')->with('type_msg',1)->with('msg','Berhasil Simpan');
        }
        else{
            return redirect('/super_admin/cuti')->with('type_msg',0)->with('msg','Gagal Simpan');
        }
    }

    function akun_pribadi_(){
        if(Session::has('isLogin')){
            $data = User::find(Session::get('id'));
            return view('index',['layout'=>'akun_pribadi_','title_layout'=>'Akun Pribadi','data'=>$data]);
        }
        else{
            return redirect('/');
        }
    }
    function ubah_akun_(Request $req){
        if(Session::has('isLogin')){
            $username   = $req->username;
            $password   = $req->password;
            $email      = $req->email;

            $user = User::find(Session::get('id'));
            $user->username = $username;
            if($password != ""){
                $user->password = \Hash::make($password);
            }
            $user->email    = $email;
            if($user->save()){
                return redirect('/super_admin/akun_pribadi')->with(['type_msg'=>1, 'msg' => 'Berhasil Simpan']);
            }
            else{
                return redirect('/super_admin/akun_pribadi')->with('type_msg',0)->with('msg','Gagal simpan');
            }
        }
        else{
            return redirect('/');
        }
    }

    function group_data($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    function kirim_notif($nama_admin,$email_admin,$pesan){
        try{
            $kirim = Mail::send('template_email', array('pesan' => $pesan) , function($pesan) use ($email_admin, $nama_admin){
                        $pesan->to($email_admin,$nama_admin)->subject('Notifikasi');
                        $pesan->from('no-reply@app.balittro.com','App Balittro');
                    });
            echo "terkirim email";
        }
        catch (Exception $e) {
            echo "error:".$e->getMessage();
        }
    }
    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }           
        return $hasil;
    }
    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }

}
