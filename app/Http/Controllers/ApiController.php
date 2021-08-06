<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\pengemudi;
use App\data_user;
use App\pagu_anggaran;
use App\pinjam_kendaraan;
use App\pinjam_kendaraan_penumpang;
use App\pinjam_kendaraan_pengemudi;
use App\perjalanan_dinas;
use App\perjalanan_dinas_detail;
use App\laporan_upg;
use App\laporan_upg_detail;
use App\jenis_gratifikasi;
use App\anggaran;
use App\pangkat;
use App\jabatan;
use App\agama;
use App\golongan;
use App\jenjang_pendidikan;
use App\tujuan;
use App\cuti;
use App\jenis_cuti;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;

class ApiController extends Controller
{
    function generateCode(){
      return rand(0,9).rand(0,9).rand(0,9).rand(0,9).".".Carbon::now()->format('d').".".Carbon::now()->format('m').".".Carbon::now()->format('Y');
      // rand(0,9).Carbon::now()->format('d').rand(0,9).Carbon::now()->format('m').rand(0,9).Carbon::now()->format('Y').
      // rand(0,9).Carbon::now()->format('H').rand(0,9).Carbon::now()->format('i').rand(0,9).Carbon::now()->format('s').rand(0,9);
    }
    function getPenggunaKaryawan(){
    	$data = array();
    	// $list = data_user::where('id_pangkat',$this->getPangkatName("PENGATUR MUDA")->id)->where('status','1')->get();
        $list = data_user::where('status','1')->get();
    	for ($i=0; $i < $list->count(); $i++) { 
    		$pagu_anggaran = pagu_anggaran::where('id_user',$list[$i]->id_user)->get();
    		
    		$arr = [
				"id"=>$list[$i]->id_user,
	    		"nip"=>$list[$i]->nip,
	    		"nama"=>$list[$i]->nama,
                "agama"=>$list[$i]->agama->agama,
                "jenjang_pendidikan"=>$list[$i]->jenjang_pendidikan->jenjang_pendidikan,
                "nama_sekolah"=>$list[$i]->nama_sekolah,
                "tahun_lulus"=>$list[$i]->tahun_lulus,
                "jabatan"=>$list[$i]->jabatan->jabatan,
	    		"pangkat"=>$list[$i]->pangkat->pangkat,
                "golongan"=>$list[$i]->golongan->golongan,
                "tmt"=>$list[$i]->tmt,
                "masa_kerja"=>$list[$i]->masa_kerja,
                "alamat"=>$list[$i]->alamat,
	    		"status"=>$list[$i]->status,
	    		"foto"=>($list[$i]->foto==null? "-":url('/public/user-image/'.$list[$i]->foto)),
	    		'kegiatan' => $pagu_anggaran
    		];
    		array_push($data, $arr);
    	}	
    	return $data;
    }
    function getMenugaskan($id_perjalanan_dinas){
    	$data = array();
    	$list = perjalanan_dinas_detail::where('id_perjalanan_dinas',$id_perjalanan_dinas)->get();
    	for ($i=0; $i < $list->count(); $i++) {
            $data_user = data_user::where('id_user',$list[$i]->id_user)->first();
    		$pagu_anggaran = pagu_anggaran::where('id_user',$list[$i]->id_user)->get();
    		
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
                "status"=>$data_user->status,
                "foto"=>($data_user->foto==null? "-":url('/public/user-image/'.$data_user->foto)),
                "kegiatan"=>$pagu_anggaran
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
            $masa_kerja=$this->getPengguna($id_user)['Masa_kerja'];
            $alamat=$this->getPengguna($id_user)['alamat'];
            $status=$this->getPengguna($id_user)['status'];
            $foto=$this->getPengguna($id_user)['foto'];
            $pagu_anggaran=$this->getPengguna($id_user)['kegiatan'];

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
                "status"=>$status,
                "foto"=>$foto,
                "kegiatan"=>$pagu_anggaran
            ];
            array_push($data, $arr);
        }
        return $data;   
    }
    function getPengguna($id_user){
    	//DB::enableQueryLog();
        $data = data_user::where('id_user',$id_user)->first();
        //dd(DB::getQueryLog());
    	if($data == null)
            return null;
        else
            $pagu_anggaran = pagu_anggaran::where('id_user',$data->id_user)->get();
            return array(
                    "id"=>$data->id_user,
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
                    "Masa_kerja"=>$data->masa_kerja,
                    "alamat"=>$data->alamat,
                    "status"=>$data->status,
                    "tgl_lahir"=>$data->tgl_lahir,
                    "foto"=>($data->foto==null? "-":url('/public/user-image/'.$data->foto)),
                    "kegiatan"=>$pagu_anggaran
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
    function getPaguAnggaran(){
        $list = array();
        $datas = pagu_anggaran::all();
        for ($i=0; $i < $datas->count(); $i++) { 
            $arr = [
                'id' =>$datas[$i]->id,
                'kode' =>$datas[$i]->kode,
                'nama_kegiatan' =>$datas[$i]->nama_kegiatan,
                'total_biaya' =>$datas[$i]->total_biaya,
                'sisa_biaya' =>$datas[$i]->sisa_biaya
            ];
            array_push($list, $arr);
        }
        echo json_encode($list);
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
                'img' =>$datas[$i]->Image
            ];
            array_push($list, $arr);
        }
        echo json_encode($list);
    }
    function CheckDataId($arr,$table_check,$coloum_check){
        $safe = true;
        for ($i=0; $i < count($arr); $i++) { 
            $data = DB::table($table_check)->where($coloum_check,$arr[$i])->first();
            if($data==null){
                $safe=false;
            }
        }
        return $safe;
    }


    function login(Request $req){
        $respon = array();

        if( Auth::attempt(["username"=>$req->username,"password"=>$req->password]) ){
              if(Auth::check()){
                    $id         = Auth::user()->id;
                    $username   = Auth::user()->username;
                    $email      = Auth::user()->email;
                    $password   = $req->password;
                    $level      = Auth::user()->id_role;
                    $data_pengemudi = pengemudi::where('id_user',$id)->first();

                    $respon = [
                        'status'    => 1,
                        'message'   => 'akses diterima',
                        'data'      => $this->getPengguna($id),
                        'id_pengemudi'  => ($data_pengemudi==null?null:$data_pengemudi->id),
                        'username'  => $username,
                        'password'  => $password,
                        'email'     => $email,
                        'level'     => $level, 
                    ];
              }
              else{
                    $respon = [
                        'status' => 0,
                        'message' => 'akses ditolak'
                    ];
              }
        }
        else{
            $respon = [
              'status' => 0,
              'message' => 'akun tidak ditemukan'
            ];
        }

        echo json_encode($respon);
    }
    function get_data(){
        $data_agama                 = agama::all();
        $data_jenjang_pendidikan    = jenjang_pendidikan::all();
        $data_jabatan               = jabatan::all();
        $data_pangkat               = pangkat::all();
        $data_golongan              = golongan::all();

        $response = [
            "agama"=>$data_agama,
            "jenjang_pendidikan"=>$data_jenjang_pendidikan,
            "jabatan"=>$data_jabatan,
            "pangkat"=>$data_pangkat,
            "golongan"=>$data_golongan
        ];

        echo json_encode($response);   
    }
    function updateAkun(Request $req){
        $respon       = array();
        $id_user        = $req->id_user;
        $username       = $req->username;
        $email          = $req->email;
        $password       = $req->password;
        $password_baru  = $req->password_baru;

        $user = User::find($id_user);
        if($user != null){
            $password_baru = \Hash::make($password_baru);
            if(!\Hash::check($password, $user->password)){
                $respon = [
                    'status' => 0,
                    'message' => 'Password tidak sesuai'
                ];
            }
            else{
                $user->username = $username;
                $user->email    = $email;
                $user->password = $password_baru;
                if($user->save()){
                    $respon = [
                        'status' => 1,
                        'message' => 'Berhasil simpan akun'
                    ];
                }
                else{   
                    $respon = [
                        'status' => 0,
                        'message' => 'Gagal simpan akun'
                    ];
                }
            }
        }
        else{
            $respon = [
                'status' => 0,
                'message' => 'Data tidak ditemukan'
            ];
        }

        echo json_encode($respon);
    }
    function updateDataAkun(Request $req){
        $respon             = array();
        $id_user            = $req->id_user;
        $nip                = $req->nip;
        $nama               = $req->nama;
        $agama              = $req->agama;
        $jenjang_pendidikan = $req->jenjang_pendidikan;
        $nama_sekolah       = $req->nama_sekolah;
        $tahun_lulus        = $req->tahun_lulus;
        $jabatan            = $req->jabatan;
        $pangkat            = $req->pangkat;
        $golongan           = $req->golongan;
        $tmt                = $req->tmt;
        $alamat             = $req->alamat;
        $tgl_lahir          = $req->tgl_lahir;

        $data_user = data_user::where('id_user',$id_user)->first();
        if($data_user != null){
            $data_user->nip                     = $nip;
            $data_user->nama                    = $nama;
            $data_user->id_agama                = $agama;
            $data_user->id_jenjang_pendidikan   = $jenjang_pendidikan;
            $data_user->nama_sekolah            = $nama_sekolah;
            $data_user->tahun_lulus             = $tahun_lulus;
            $data_user->id_jabatan              = $jabatan;
            $data_user->id_pangkat              = $pangkat;
            $data_user->id_golongan             = $golongan;
            $data_user->tmt                     = $tmt;
            $data_user->alamat                  = $alamat;  
            $data_user->tgl_lahir               = $tgl_lahir;  

            if($data_user->save()){
                $respon = [
                    'status' => 1,
                    'message' => 'Berhasil simpan profil'
                ];
            }
            else{
                $respon = [
                    'status' => 0,
                    'message' => 'Gagal simpan profil'
                ];
            }
        }
        else{   
            $respon = [
                'status' => 0,
                'message' => 'Data tidak ditemukan'
            ];
        }

        echo json_encode($respon);
    }
    function updateImage(Request $req){
        $id_user    = $req->id_user;
        $image      = $req->image;
        
        $file       = "Img_User_".$id_user."_".time().".png";
        $path       = public_path()."/user-image/".$file;
        
        $data_user  = data_user::where('id_user', $id_user)->first();
        $old_file   = $data_user->foto; 
        $data_user  = data_user::where('id_user', $id_user)->update(['foto' => $file]);
        if($data_user){
            if( file_put_contents($path,base64_decode($image)) ) {
                $respon = [
                    'status' => 1,
                    'message' => 'Berhasil perbaharui foto profil',
                    'file' => url('/public/user-image/'.$file)
                ];
                if( ($old_file != null || $old_file != '') && file_exists(public_path()."/user-image/".$old_file) )
                    unlink(public_path()."/user-image/".$old_file);
            }
            else{
                $respon = [
                    'status' => 0,
                    'message' => 'Gagal memindahkan foto'
                ];
            }
        }
        else{
            $respon = [
                'status' => 0,
                'message' => 'Gagal perbaharui foto profil'
            ];
        }
        
        echo json_encode($respon);
    }

    //unused
    function getAllPengemudi(){
        $list = array();
        $data = pengemudi::where("status",1)->where("id_user","!=",null)->get();
        for($i=0;$i<$data->count();$i++){
            $arr = [
                "id" => $data[$i]->id,
                "nama_pengemudi" => $this->getPengguna($data[$i]->id_user)['nama'],
                "jenis_kendaraan" => $data[$i]->jenis_kendaraan,
                "no_polisi" => $data[$i]->no_polisi,
            ];
                
            array_push($list, $arr);
        }
        return $list;
    }
    
    //clear, email ok
    function getPerjalananDinas($id){
        $response = array();
        $data = array();
        //$list = perjalanan_dinas::where('id_penanggung_jawab',$id)->get();
        $list = perjalanan_dinas::where('id_pemohon',$id)->get();

        for ($i=0; $i < $list->count(); $i++) {
            $pinjam_kendaraan = pinjam_kendaraan::where('id_perjalanan_dinas',$list[$i]->id)->first();

            if($pinjam_kendaraan!=null){
                $data_pinjam_kendaraan = [
                    "id"                        => $pinjam_kendaraan->id,
                    "nomor_laporan"             => $pinjam_kendaraan->nomor_laporan,
                    "peminjam"                  => ($pinjam_kendaraan->id_peminjam==null?null:$this->getPengguna($pinjam_kendaraan->id_peminjam)),
                    "jenis_kendaraan"           => $pinjam_kendaraan->jenis_kendaraan,
                    "keperluan"                 => $pinjam_kendaraan->keperluan,
                    "tujuan"                    => $pinjam_kendaraan->tujuan,
                    "tanggal"                   => $pinjam_kendaraan->tanggal,
                    "jam"                       => $pinjam_kendaraan->jam,
                    "lama"                      => $pinjam_kendaraan->lama_keperluan,
                    "pengemudi"                 => $this->getPengemudi($pinjam_kendaraan->id),
                    "penumpang"                 => $this->getPenumpang($pinjam_kendaraan->id),
                    "status_pinjam_kendaraan"   => $pinjam_kendaraan->status_acc
                ];
            }
            else{
                $data_pinjam_kendaraan = null;
            }

            $data_tujuan = tujuan::find($list[$i]->id_tujuan);
            if($data_tujuan!=null){
                $anggaran = array();
                $data_anggaran = anggaran::where('id_tujuan',$data_tujuan->id)->get();
                for($j=0;$j<$data_anggaran->count();$j++){
                    $arr = [
                        "id"=>$data_anggaran[$j]->id,
                        "name"=>$data_anggaran[$j]->jenis_anggaran->nama,
                        "biaya"=>$data_anggaran[$j]->biaya,
                        'tipe' =>$data_anggaran[$j]->jenis_anggaran->type
                    ];
                    array_push($anggaran, $arr);
                }

                $tujuan = [
                    "id"=>$data_tujuan->id,
                    "name"=>$data_tujuan->tujuan,
                    "data"=>$anggaran
                ];
            }
            else{
                $tujuan = null;
            }

            $arr = [
                "id"=>$list[$i]->id,
                "nomor_perjalanan_dinas"=>$list[$i]->nomor_perjalanan_dinas,
                "pemohon"=>($list[$i]->id_pemohon==null?null:$this->getPengguna($list[$i]->id_pemohon)),
                "penggung_jawab"=>($list[$i]->id_penanggung_jawab==null?null:$this->getPengguna($list[$i]->id_penanggung_jawab)),
                "judul_kegiatan"=>$list[$i]->judul_kegiatan,
                "menugaskan"=>$this->getMenugaskan($list[$i]->id),
                "tujuan"=>$tujuan,
                "maksud_perjalanan"=>$list[$i]->maksud_perjalanan,
                "tanggal"=>$list[$i]->tanggal,
                "lama_perjalanan"=>$list[$i]->lama_perjalanan,
                "kegiatan"=>array(
                    "id"=>$list[$i]->Pagu_Anggaran->id,
                    "kode"=>$list[$i]->Pagu_Anggaran->kode,
                    "nama_kegiatan"=>$list[$i]->Pagu_Anggaran->nama_kegiatan,
                    "total_biaya"=>$list[$i]->Pagu_Anggaran->total_biaya,
                    "sisa_biaya"=>$list[$i]->Pagu_Anggaran->sisa_biaya
                ),
                "kendaraan"=>$list[$i]->kendaraan,
                "surat_tugas"=>$list[$i]->surat_tugas,
                "pagu_anggaran"=>$list[$i]->pagu_anggaran,
                "biaya_telah_digunakan"=>$list[$i]->biaya_telah_digunakan,
                "biaya_akan_digunakan"=>$list[$i]->biaya_akan_digunakan,
                // "verifikator"=>$list[$i]->verifikator,
                "status_acc"=>$list[$i]->status_acc,
                "surat_pinjam_kendaraan"=> $data_pinjam_kendaraan,
                "create_at" =>$list[$i]->created_at,
                "update_at" =>$list[$i]->updated_at, 
            ];  
            array_push($data, $arr);
        }
        
        $response = [
            'status' => (count($list)>0 ?1:0),
            'message' => (count($list)>0?'data ditemukan':'data kosong'),
            'data' => $data 
        ];
        return json_encode($response);
    }
    function setPerjalananDinas(Request $req){
        $response = array();

        $pemohon                         = $req->pemohon; //id
        $penanggung_jawab_kegiatan       = $req->penanggung_jawab_kegiatan; //id
        $judul_kegiatan                  = $req->judul_kegiatan; //string
        $menugaskan_perjalanan_dinas     = $req->menugaskan_perjalanan_dinas; //array id string
        $tujuan                          = $req->tujuan; //id
        $maksud_perjalanan               = $req->maksud_perjalanan; //string
        $tanggal                         = $req->tanggal; //string
        $lama_perjalanan                 = $req->lama_perjalanan; //string
        $kegiatan                        = $req->kegiatan; //string
        $kendaraan                       = $req->kendaraan; //int
        $surat_tugas                     = $req->surat_tugas; //int
        $pagu_anggaran                   = $req->pagu_anggaran; //string
        $biaya_telah_digunakan           = $req->biaya_telah_digunakan; //string
        $biaya_akan_digunakan            = $req->biaya_akan_digunakan; //string
        // $verifikator                     = $req->verifikator; //string

        $perjalanan_dinas                         = new perjalanan_dinas();
        $perjalanan_dinas->nomor_perjalanan_dinas = $this->generateCode();
        $perjalanan_dinas->id_pemohon             = $pemohon;
        $perjalanan_dinas->id_penanggung_jawab    = $penanggung_jawab_kegiatan;
        $perjalanan_dinas->judul_kegiatan         = $judul_kegiatan;
        $perjalanan_dinas->id_tujuan              = $tujuan;
        $perjalanan_dinas->maksud_perjalanan      = $maksud_perjalanan;
        $perjalanan_dinas->tanggal                = $tanggal;
        $perjalanan_dinas->lama_perjalanan        = $lama_perjalanan;
        $perjalanan_dinas->kegiatan               = $kegiatan;
        $perjalanan_dinas->kendaraan              = $kendaraan;
        $perjalanan_dinas->surat_tugas            = $surat_tugas;
        $perjalanan_dinas->pagu_anggaran          = $pagu_anggaran;
        $perjalanan_dinas->biaya_telah_digunakan  = $biaya_telah_digunakan;
        $perjalanan_dinas->biaya_akan_digunakan   = $biaya_akan_digunakan;
        // $perjalanan_dinas->verifikator            = $verifikator;
        
        if($perjalanan_dinas->save()){
            $data_menugaskan = array();
            $data_menugaskan_json = json_decode($menugaskan_perjalanan_dinas, true);
            for($i=0;$i<count($data_menugaskan_json);$i++){
                array_push($data_menugaskan, array("id_perjalanan_dinas"=>$perjalanan_dinas->id,"id_user"=>$data_menugaskan_json[$i]));
            }
            // if(count($data_menugaskan)>0){
            //     $data_menugaskan = array_unique($data_menugaskan);
            // }

            $perjalanan_dinas_detail = perjalanan_dinas_detail::insert($data_menugaskan);
            if($perjalanan_dinas_detail){
                $response = [
                    'status' => 1,
                    'message' => 'Berhasil Buat Surat Pengajuan Perjalanan Dinas',
                ];

                $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 1)
                                                // ->where('data_user.id_jabatan', 24)
                                                ->where('data_user.status',1);
                                          })->get();
                //data_user::where('id_jabatan',24)->get();
                $data_user  = data_user::where('id_user',$pemohon)->first();
                if($data_admin->count()>0){
                    foreach ($data_admin as $data_admin => $item) {
                        $nama_user          = ($data_user==null? "N/a":$data_user->nama);
                        $id_admin           = $item->id_user;
                        $nama_admin         = $item->nama;
                        $jabatan_admin      = $item->Jabatan->jabatan;
                        $nomor_laporan      = $perjalanan_dinas->nomor_perjalanan_dinas;
                        $data_akun_admin    = User::find($id_admin);

                        if($data_akun_admin != null){
                            $email_admin = $data_akun_admin->email;
                            if( $email_admin != null || $email_admin != '' ){
                                $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                            berikut saya sampaikan pengajuan perjalanan dinas atas nama $nama_user dengan nomor $nomor_laporan mohon diverifikasi";
                                //$pesan = "hai ".$nama_admin.", hari ini ada yang mengajukan perjalanan dinas dari ".$nama_user." dengan nomor perjalanan dinas ".$nomor_laporan.", mohon di verifikasi laporan perjalanan dinasnya";
                                $this->kirim_notif($nama_admin,$email_admin,$pesan);
                            }
                        }
                    }
                }
            }
            else{
                $hapus = perjalanan_dinas::find($perjalanan_dinas->id_perjalanan_dinas);
                $hapus->delete();

                $response = [
                   'status' => 0,
                    'message' => 'Gagagl Simpan Menugaskan' 
                ];
            }

        }
        else{
            $response = [
               'status' => 0,
               'message' => 'Gagal Buat Surat Pengajuan Perjalanan Dinas' 
           ];
        }

        echo json_encode($response);
    }
    function updatePerjalananDinas(Request $req){
        $response = array();
        $id                              = $req->id;
        $pemohon                         = $req->pemohon; //id
        $penanggung_jawab_kegiatan       = $req->penanggung_jawab_kegiatan; //id
        $judul_kegiatan                  = $req->judul_kegiatan; //string
        $menugaskan_perjalanan_dinas     = $req->menugaskan_perjalanan_dinas; //array id string
        $tujuan                          = $req->tujuan; //id
        $maksud_perjalanan               = $req->maksud_perjalanan; //string
        $tanggal                         = $req->tanggal; //string
        $lama_perjalanan                 = $req->lama_perjalanan; //string
        $kegiatan                        = $req->kegiatan; //string
        $kendaraan                       = $req->kendaraan; //int
        $surat_tugas                     = $req->surat_tugas; //int
        $pagu_anggaran                   = $req->pagu_anggaran; //string
        $biaya_telah_digunakan           = $req->biaya_telah_digunakan; //string
        $biaya_akan_digunakan            = $req->biaya_akan_digunakan; //string
        // $verifikator                     = $req->verifikator; //string

        $perjalanan_dinas = perjalanan_dinas::find($id);
        if($perjalanan_dinas != null){
            $perjalanan_dinas->id_penanggung_jawab    = $penanggung_jawab_kegiatan;
            $perjalanan_dinas->judul_kegiatan         = $judul_kegiatan;
            $perjalanan_dinas->id_tujuan              = $tujuan;
            $perjalanan_dinas->maksud_perjalanan      = $maksud_perjalanan;
            $perjalanan_dinas->tanggal                = $tanggal;
            $perjalanan_dinas->lama_perjalanan        = $lama_perjalanan;
            $perjalanan_dinas->kegiatan               = $kegiatan;
            $perjalanan_dinas->kendaraan              = $kendaraan;
            $perjalanan_dinas->surat_tugas            = $surat_tugas;
            $perjalanan_dinas->pagu_anggaran          = $pagu_anggaran;
            $perjalanan_dinas->biaya_telah_digunakan  = $biaya_telah_digunakan;
            $perjalanan_dinas->biaya_akan_digunakan   = $biaya_akan_digunakan;
            // $perjalanan_dinas->verifikator            = $verifikator;
            
            $data_menugaskan_json = json_decode($menugaskan_perjalanan_dinas, true);

            $arr_id_menugaskan = array();
            for($i=0;$i<count($data_menugaskan_json);$i++){
                array_push($arr_id_menugaskan, $data_menugaskan_json[$i]);
            }

            if($this->CheckDataId($arr_id_menugaskan,'user','id')){
                $data_menugaskan = array();
                for($i=0;$i<count($data_menugaskan_json);$i++){
                    array_push($data_menugaskan, array("id_perjalanan_dinas"=>$id,"id_user"=>$data_menugaskan_json[$i]));
                }
                // if(count($data_menugaskan)>0){
                //     $data_menugaskan = array_unique($data_menugaskan);
                // }

                $delete_perjalanan_dinas_detail = perjalanan_dinas_detail::where('id_perjalanan_dinas',$id)->delete(); 

                if($delete_perjalanan_dinas_detail){
                    $perjalanan_dinas_detail = perjalanan_dinas_detail::insert($data_menugaskan);

                    if($perjalanan_dinas_detail && $perjalanan_dinas->save()){
                        $response = [
                            'status' => 1,
                            'message' => 'Berhasil Simpan Surat Pengajuan Perjalanan Dinas',
                        ];

                        $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 1)
                                                // ->where('data_user.id_jabatan', 24)
                                                ->where('data_user.status',1);
                                          })->get();
                        //data_user::where('id_jabatan',24)->get();
                        $data_user  = data_user::where('id_user',$pemohon)->first();
                        if($data_admin->count()>0){
                            foreach ($data_admin as $data_admin => $item) {
                                $nama_user          = ($data_user==null? "N/a":$data_user->nama);
                                $id_admin           = $item->id_user;
                                $nama_admin         = $item->nama;
                                $jabatan_admin      = $item->Jabatan->jabatan;
                                $nomor_laporan      = $perjalanan_dinas->nomor_perjalanan_dinas;
                                $data_akun_admin    = User::find($id_admin);

                                if($data_akun_admin != null){
                                    $email_admin = $data_akun_admin->email;
                                    if( $email_admin != null || $email_admin != '' ){
                                        $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                            berikut saya sampaikan pengajuan perjalanan dinas atas nama $nama_user dengan nomor $nomor_laporan telah diperbaharui mohon diverifikasi";
                                        //$pesan = "hai ".$nama_admin.", nomor laporan dinas ".$nomor_laporan." sudah diperbaharui oleh ".$nama_user." mohon di cek ulang kembali laporan perjalanan dinasnya dan mohon verifikasi laporannya";
                                        $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                    }
                                }
                            }
                        }
                    }
                    else{
                        $response = [
                           'status' => 0,
                            'message' => 'Gagal Simpan Surat Pengajuan Perjalanan Dinas' 
                        ];
                    }

                }
                else{
                    $response = [
                       'status' => 0,
                       'message' => 'Gagal hapus data lama menugaskan' 
                   ];
                }
            }
            else{
                $response = [
                   'status' => 0,
                   'message' => 'Data menugaskan tidak valid' 
                ];
            }
        }
        else{
            $response = [
               'status' => 0,
               'message' => 'Data tidak ditemukan' 
            ];
        }

        echo json_encode($response);
    }
    function delPerjalananDinas($id){
        $response = array();
        $delete = perjalanan_dinas::find($id);
        if($delete != null){
            if($delete->delete()){
                $response = [
                    'status' => 1,
                    'message' => "berhasil hapus",
                ];
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "gagal hapus",
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Data tidak ditemukan",
            ];
        }
        echo json_encode($response);
    }

    //clear, email ok
    function getLaporanUpg($id){
        $response       = array();
        $data           = array();
        $data_laporan   = laporan_upg::where('id_user',$id)->get();

        for ($i=0; $i < $data_laporan->count(); $i++) { 
            $gratifikasi = array();
            $datas = laporan_upg_detail::where('id_laporan_upg',$data_laporan[$i]->id)->where('id_jenis_gratifikasi','!=',null)->get();
            for ($j=0; $j < $datas->count(); $j++) { 
                $arr = [
                    'id'            =>$datas[$j]->id,
                    'nama'          =>($datas[$j]->id_jenis_gratifikasi==null?null:$datas[$j]->jenis_gratifikasi->nama),
                    'keterangan'    =>$datas[$j]->keterangan
                ];
                array_push($gratifikasi, $arr);
            }

            $arr = [
                "id"                        => $data_laporan[$i]->id,
                "nomor_laporan"             => $data_laporan[$i]->nomor_laporan,
                "pengguna"                  => ($data_laporan[$i]->id_user==null?null:$this->getPengguna($data_laporan[$i]->id_user)),
                "lokasi"                    => $data_laporan[$i]->lokasi,
                "tanggal"                   => $data_laporan[$i]->tanggal,
                "lama"                      => $data_laporan[$i]->lama,
                "honor"                     => $data_laporan[$i]->honor,
                "pemberi"                   => $data_laporan[$i]->pemberi,
                "gratifikasi"               => $gratifikasi,
                "hubungan_gratifikasi"      => $data_laporan[$i]->hubungan_gratifikasi,
                "status"                    => $data_laporan[$i]->status
            ];
            array_push($data, $arr);
        }

        $response = [
            'status' => (count($data)>0? 1:0),
            'message' => (count($data)>0?'data ditemukan':'data kosong'),
            'data' => $data 
        ];  

        echo json_encode($response);
    }
    function setLaporanUpg(Request $req){
        $response               =  array();
        $id_user                = $req->id_user;
        $lokasi                 = $req->lokasi;
        $tanggal                = $req->tanggal;
        $lama                   = $req->lama;
        $honor                  = $req->honor;
        $pemberi                = $req->pemberi;
        $gratifikasi_json       = $req->gratifikasi;
        $hubungan_gratifikasi   = $req->hubungan_gratifikasi;
        
        $laporan_upg                        = new laporan_upg();
        $laporan_upg->nomor_laporan         = $this->generateCode();
        $laporan_upg->id_user               = $id_user;
        $laporan_upg->lokasi                = $lokasi;
        $laporan_upg->tanggal               = $tanggal;
        $laporan_upg->lama                  = $lama;
        $laporan_upg->honor                 = $honor;
        $laporan_upg->pemberi               = $pemberi;
        $laporan_upg->hubungan_gratifikasi  = $hubungan_gratifikasi;

        if($laporan_upg->save()){
            $data_laporan_upg_detail = array();
            $gratifikasi_json = json_decode($gratifikasi_json, true);
            foreach ($gratifikasi_json as $key => $value) {
                $arr = [
                    "id_laporan_upg"=>$laporan_upg->id,
                    "id_jenis_gratifikasi"=>$value['id'],
                    "keterangan"=>($value['text']==""?null:$value['text'])
                ];
                array_push($data_laporan_upg_detail, $arr);
            }

            $laporan_upg_detail = laporan_upg_detail::insert($data_laporan_upg_detail);
            if($laporan_upg_detail){
                $response = [
                    'status' => 1,
                    'message' => 'Berhasil Simpan Laporan UPG',
                ];

                $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 9)
                                                // ->where('data_user.id_jabatan', 43)
                                                ->where('data_user.status',1);
                                          })->get();

                //$data_admin = data_user::where('id_jabatan',43)->get();
                $data_user  = data_user::where('id_user',$id_user)->first();
                if($data_admin->count()>0){
                    foreach ($data_admin as $data_admin => $item) {
                        $nama_user          = ($data_user==null? "N/a":$data_user->nama);
                        $id_admin           = $item->id_user;
                        $nama_admin         = $item->nama;
                        $jabatan_admin      = $item->Jabatan->jabatan;
                        $nomor_laporan      = $laporan_upg->nomor_laporan;
                        $data_akun_admin    = User::find($id_admin);

                        if($data_akun_admin != null){
                            $email_admin = $data_akun_admin->email;
                            if( $email_admin != null || $email_admin != '' ){
                                $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                            berikut saya sampaikan pengajuan laporan gratifikasi atas nama $nama_user dengan nomor $nomor_laporan mohon diverifikasi";
                                //$pesan = "hai ".$nama_admin.", hari ini ada yang mengajukan laporan UPG dari ".$nama_user." dengan nomor laporan ".$nomor_laporan.", mohon di verifikasi laporannya";
                                $this->kirim_notif($nama_admin,$email_admin,$pesan);
                            }
                        }
                    }
                }
            }
            else{
                $hapus = laporan_upg::find($laporan_upg->id);
                $hapus->delete();

                $response = [
                   'status' => 0,
                    'message' => 'Gagal Simpan Laporan UPG' 
                ];
            }
        }
        else{
            $response = [
               'status' => 0,
               'message' => 'Gagal Simpan Laporan UPG' 
           ];
        }

        echo json_encode($response);
    }
    function updateLaporanUpg(Request $req){
        $response               =  array();
        $id                     = $req->id;
        $id_user                = $req->id_user;
        $lokasi                 = $req->lokasi;
        $tanggal                = $req->tanggal;
        $lama                   = $req->lama;
        $honor                  = $req->honor;
        $pemberi                = $req->pemberi;
        $gratifikasi_json       = $req->gratifikasi;
        $hubungan_gratifikasi   = $req->hubungan_gratifikasi;
        
        $laporan_upg            = laporan_upg::find($id);
        if($laporan_upg!=null){
            $laporan_upg->id_user               = $id_user;
            $laporan_upg->lokasi                = $lokasi;
            $laporan_upg->tanggal               = $tanggal;
            $laporan_upg->lama                  = $lama;
            $laporan_upg->honor                 = $honor;
            $gratifikasi_json                   = json_decode($gratifikasi_json, true);
            $laporan_upg->pemberi               = $pemberi;
            $laporan_upg->hubungan_gratifikasi  = $hubungan_gratifikasi;

            $arr_id_jenis_gratifikasi = array();
            foreach ($gratifikasi_json as $key => $value) {
                array_push($arr_id_jenis_gratifikasi, $value['id']);
            }

            if($this->CheckDataId($arr_id_jenis_gratifikasi,'jenis_gratifikasi','id')){
                if($laporan_upg->save()){
                    $data_laporan_upg_detail = array();
                    foreach ($gratifikasi_json as $key => $value) {
                        $arr = [
                            "id_laporan_upg"=>$id,
                            "id_jenis_gratifikasi"=>$value['id'],
                            "keterangan"=>($value['text']==""?null:$value['text'])
                        ];
                        array_push($data_laporan_upg_detail, $arr);
                    }

                    $delete_laporan_upg_detail = laporan_upg_detail::where('id_laporan_upg',$id)->delete();
                    if($delete_laporan_upg_detail){
                        $laporan_upg_detail = laporan_upg_detail::insert($data_laporan_upg_detail);
                        if($laporan_upg_detail){
                            $response = [
                                'status' => 1,
                                'message' => 'Berhasil Simpan Laporan UPG',
                            ];

                            $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 9)
                                                // ->where('data_user.id_jabatan', 43)
                                                ->where('data_user.status',1);
                                          })->get();

                            //$data_admin = data_user::where('id_jabatan',43)->get();
                            $data_user  = data_user::where('id_user',$id_user)->first();
                            if($data_admin->count()>0){
                                foreach ($data_admin as $data_admin => $item) {
                                    $nama_user          = ($data_user==null? "N/a":$data_user->nama);
                                    $id_admin           = $item->id_user;
                                    $nama_admin         = $item->nama;
                                    $jabatan_admin      = $item->Jabatan->jabatan;
                                    $nomor_laporan      = $laporan_upg->nomor_laporan;
                                    $data_akun_admin    = User::find($id_admin);

                                    if($data_akun_admin != null){
                                        $email_admin = $data_akun_admin->email;
                                        if( $email_admin != null || $email_admin != '' ){
                                            $pesan = "Yth.$jabatan_admin ($nama_admin)<br>
                                                        berikut saya sampaikan pengajuan laporan gratifikasi atas nama $nama_user dengan nomor $nomor_laporan telah diperbaharui mohon diverifikasi";
                                            //$pesan = "hai ".$nama_admin.", nomor laporan UPG ".$nomor_laporan." sudah diperbaharui oleh ".$nama_user." mohon di cek ulang kembali laporannya dan mohon verifikasi";
                                            $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            $response = [
                               'status' => 0,
                                'message' => 'Gagal simpan data baru gratifikasi' 
                            ];
                        }
                    }
                    else{
                        $response = [
                            'status' => 0,
                            'message' => 'Gagal hapus data lama gratifikasi' 
                        ];
                    }
                }
                else{
                    $response = [
                       'status' => 0,
                       'message' => 'Gagal Simpan Laporan UPG' 
                   ];
                }
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => 'Data gratifikasi tidak valid' 
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => 'Data tidak ditemukan' 
            ];
        }

        echo json_encode($response);
    }
    function delLaporanUpg($id){
        $response = array();
        $delete = laporan_upg::find($id);
        if($delete != null){
            if($delete->delete()){
                $response = [
                    'status' => 1,
                    'message' => "berhasil hapus",
                ];
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "gagal hapus",
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Data tidak ditemukan",
            ];            
        }
        echo json_encode($response);
    }

    //clear, email ok
    function getCuti($id){
        $response       = array();
        $data           = array();
        $data_laporan   = cuti::where('id_user',$id)->get();

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
                "tanggal"        => $data_laporan[$i]->tanggal,
                "lama"           => ($data_laporan[$i]->cuti_n+$data_laporan[$i]->cuti_n1+$data_laporan[$i]->cuti_n2),
                // "keterangan"     => $data_laporan[$i]->keterangan,
                "alamat"         => $data_laporan[$i]->alamat_cuti,
                "telp"           => $data_laporan[$i]->telp,
                "status_acc1"    => $data_laporan[$i]->status_acc1,
                "catatan_acc1"   => $data_laporan[$i]->catatan_acc1,
                "status_acc2"    => $data_laporan[$i]->status_acc2,
                "catatan_acc2"   => $data_laporan[$i]->catatan_acc2,
            ];
            array_push($data, $arr);
        }

        $response = [
            'status' => (count($data)>0? 1:0),
            'message' => (count($data)>0?'data ditemukan':'data kosong'),
            'data' => $data 
        ];  

        echo json_encode($response);
    }
    function setCuti(Request $req){
        $response       = array();
        $id_user        = $req->id_user;
        $id_jenis_cuti  = $req->id_jenis_cuti;
        $alasan         = $req->alasan;
        $tanggal        = $req->tanggal;
        $lama           = $req->lama;
        // $keterangan     = $req->keterangan;
        $alamat_cuti    = $req->alamat;
        $telp           = $req->telp;

        $data_user = data_user::where('id_user',$id_user)->first();
        if($data_user != null){
            $cuti_n     = $data_user->cuti_n;
            $cuti_n_    = 0;
            $cuti_n1    = $data_user->cuti_n1;
            $cuti_n1_   = 0;
            $cuti_n2    = $data_user->cuti_n2;
            $cuti_n2_   = 0;
            $total_cuti = $cuti_n + $cuti_n1 + $cuti_n2;
            
            if($total_cuti  >=  $lama){
                $data_cuti = cuti::where("id_user",$id_user)
                                ->where(function($q) {
                                      $q->where('status_acc1','!=',1)->orWhere('status_acc2','!=',1);
                                  })->get();
                if($data_cuti->count()==0){
                    if($cuti_n2 >= $lama){
                        $cuti_n2_ += $lama;
                        $cuti_n2  -= $lama;
                    }
                    else{
                        $cuti_n2_   = $cuti_n2;
                        $lama      -= $cuti_n2;
                        $cuti_n2    = 0;
                        if($cuti_n1 >= $lama){
                            $cuti_n1_ += $lama;
                            $cuti_n1  -= $lama;
                        }
                        else{
                            $cuti_n1_   = $cuti_n1;
                            $lama      -= $cuti_n1;
                            $cuti_n1    = 0;
                            if($cuti_n >= $lama){
                                $cuti_n_ += $lama;
                                $cuti_n  -= $lama;
                            }
                        }
                    }

                    $cuti                 = new cuti();
                    $cuti->nomor_laporan  = $this->generateCode();
                    $cuti->id_user        = $id_user;
                    $cuti->id_jenis_cuti  = $id_jenis_cuti;
                    $cuti->alasan         = $alasan;
                    $cuti->tanggal        = $tanggal;
                    // $cuti->keterangan     = $keterangan;
                    $cuti->alamat_cuti    = $alamat_cuti;
                    $cuti->telp           = $telp;
                    $cuti->cuti_n         = $cuti_n_;
                    $cuti->cuti_n1        = $cuti_n1_;
                    $cuti->cuti_n2        = $cuti_n2_;

                    if($cuti->save()){
                        $user = data_user::where('id_user', $id_user)->update(['cuti_n' => $cuti_n,'cuti_n1' => $cuti_n1,'cuti_n2' => $cuti_n2]);
                        if($user){
                            $response = [
                                'status' => 1,
                                'message' => "berhasil simpan cuti",
                            ];

                            $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 8)
                                                // ->where('data_user.id_jabatan', 26)
                                                ->where('data_user.status',1);
                                          })->get();
                            
                            $data_user  = data_user::where('id_user',$id_user)->first();
                            if($data_admin->count()>0){
                                foreach ($data_admin as $data_admin => $item) {
                                    $nama_user          = ($data_user==null? 'N/a' :$data_user->nama);
                                    $id_admin           = $item->id_user;
                                    $nama_admin         = $item->nama;
                                    $jabatan_admin      = $item->Jabatan->jabatan;
                                    $nomor_laporan      = $cuti->nomor_laporan;
                                    $data_akun_admin    = User::find($id_admin);

                                    if($data_akun_admin != null){
                                        $email_admin = $data_akun_admin->email;
                                        if( $email_admin != null || $email_admin != '' ){
                                            $pesan = "Yth.$jabatan_admin ($nama_admin)
                                                    berikut saya sampaikan pengajuan cuti atas nama $nama_user dengan nomor $nomor_laporan telah mohon diverifikasi";
                                            //$pesan = "hai ".$nama_admin.", hari ini ada yang mengajukan laporan cuti dari ".$nama_user." dengan nomor laporan ".$nomor_laporan.", mohon di verifikasi laporannya";
                                            $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            $response = [
                                'status' => 0,
                                'message' => "gagal simpan cuti 1",
                            ];
                        }
                    }  
                    else{
                        $response = [
                            'status' => 0,
                            'message' => "gagal simpan cuti 0",
                        ];
                    }
                }
                else{
                    $response = [
                        'status' => 0,
                        'message' => "Menunggu pengajuan cuti sebelumnya di acc",
                    ];
                }              
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "Total pengajuan cuti melebihi batas",
                ];    
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Nama pengguna cuti tidak valid",
            ];       
        }
        echo json_encode($response);
    }
    function updateCuti(Request $req){
        $response       = array();
        $id             = $req->id;
        $id_user        = $req->id_user;
        $id_jenis_cuti  = $req->id_jenis_cuti;
        $alasan         = $req->alasan;
        $tanggal        = $req->tanggal;
        $lama           = $req->lama;
        // $keterangan     = $req->keterangan;
        $alamat_cuti    = $req->alamat;
        $telp           = $req->telp;

        $data_cuti = cuti::find($id);
        if($data_cuti != null){
            $data_user  = data_user::where('id_user',$data_cuti->id_user)->first();
            if($data_user != null){
                $state = false;
                $data_cuti_cuti_n   = $data_cuti->cuti_n;
                $data_cuti_cuti_n1  = $data_cuti->cuti_n1;
                $data_cuti_cuti_n2  = $data_cuti->cuti_n2;
                $data_cuti_total    = $data_cuti_cuti_n + $data_cuti_cuti_n1 + $data_cuti_cuti_n2;

                $data_user_cuti_n  = $data_user->cuti_n;
                $data_user_cuti_n1 = $data_user->cuti_n1;
                $data_user_cuti_n2 = $data_user->cuti_n2;
                $data_user_total   = $data_user_cuti_n + $data_user_cuti_n1 + $data_user_cuti_n2;

                if($data_cuti_total>=$lama){
                    $data_cuti_selisih = $data_cuti_total - $lama;

                    if($data_cuti_cuti_n >= $data_cuti_selisih){ 
                        $data_cuti_cuti_n -= $data_cuti_selisih; 
                        $data_user_cuti_n += $data_cuti_selisih;
                        $data_cuti_selisih = 0;                  
                    }
                    else{ 
                        $data_user_cuti_n  += $data_cuti_cuti_n;
                        $data_cuti_selisih -= $data_cuti_cuti_n; 
                        $data_cuti_cuti_n   = 0;                 
                        
                        if($data_cuti_cuti_n1 >= $data_cuti_selisih){
                            $data_cuti_cuti_n1 -= $data_cuti_selisih;
                            $data_user_cuti_n1 += $data_cuti_selisih; 
                            $data_cuti_selisih  = 0;
                        }
                        else{
                            $data_user_cuti_n1 += $data_cuti_cuti_n1;
                            $data_cuti_selisih -= $data_cuti_cuti_n1; 
                            $data_cuti_cuti_n1  = 0;                 
                            
                            if($data_cuti_cuti_n2 >= $data_cuti_selisih){
                                $data_cuti_cuti_n2 -= $data_cuti_selisih;
                                $data_user_cuti_n2 += $data_cuti_selisih; 
                                $data_cuti_selisih = 0;
                            }
                            else{ //statement yang ga boleh ada
                                $data_user_cuti_n2 += $data_cuti_cuti_n2;
                                $data_cuti_selisih -= $data_cuti_cuti_n2; 
                                $data_cuti_cuti_n2  = 0;                 
                            }
                        }
                    }
                }
                else{
                    $data_cuti_selisih = $lama - $data_cuti_total;

                    if($data_user_total+$data_cuti_total >= $lama){
                        if($data_user_cuti_n2 >= $data_cuti_selisih){
                            $data_cuti_cuti_n2 += $data_cuti_selisih;
                            $data_user_cuti_n2 -= $data_cuti_selisih;
                            $data_cuti_selisih  = 0;
                        }
                        else{
                            $data_cuti_cuti_n2 += $data_user_cuti_n2;
                            $data_cuti_selisih -= $data_user_cuti_n2;
                            $data_user_cuti_n2  = 0;   
                            if($data_user_cuti_n1 >= $data_cuti_selisih){
                                $data_cuti_cuti_n1 += $data_cuti_selisih;
                                $data_user_cuti_n1 -= $data_cuti_selisih;
                                $data_cuti_selisih  = 0;
                            }
                            else{
                                $data_cuti_cuti_n1 += $data_user_cuti_n1;
                                $data_cuti_selisih -= $data_user_cuti_n1;
                                $data_user_cuti_n1  = 0;
                                if($data_user_cuti_n >= $data_cuti_selisih){
                                    $data_cuti_cuti_n   += $data_cuti_selisih;
                                    $data_user_cuti_n   -= $data_cuti_selisih;
                                    $data_cuti_selisih   = 0;
                                }
                                else{
                                    $data_cuti_cuti_n   += $data_user_cuti_n;
                                    $data_cuti_selisih  -= $data_user_cuti_n;
                                    $data_user_cuti_n    = 0;
                                }
                            }
                        }
                    }
                    else{
                        $state = true;
                    }
                }  

                if($state==false){
                    $data_user_ = array("cuti_n"=>$data_user_cuti_n,"cuti_n1"=>$data_user_cuti_n1,"cuti_n2"=>$data_user_cuti_n2);

                    $cuti                 = cuti::find($id);
                    $cuti->id_user        = $id_user;
                    $cuti->id_jenis_cuti  = $id_jenis_cuti;
                    $cuti->alasan         = $alasan;
                    $cuti->tanggal        = $tanggal;
                    // $cuti->keterangan     = $keterangan;
                    $cuti->alamat_cuti    = $alamat_cuti;
                    $cuti->telp           = $telp;
                    $cuti->cuti_n         = $data_cuti_cuti_n;
                    $cuti->cuti_n1        = $data_cuti_cuti_n1;
                    $cuti->cuti_n2        = $data_cuti_cuti_n2;

                    $update_user   = data_user::where('id_user', $data_cuti->id_user)->update($data_user_);
                    if($update_user && $cuti->save()){
                        $response = [
                           'status' => 1,
                           'message' => "Berhasil simpan cuti",
                        ];

                        $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 8)
                                                //->where('data_user.id_jabatan', 26)
                                                ->where('data_user.status',1);
                                          })->get();
                        
                        $data_user  = data_user::where('id_user',$id_user)->first();
                        if($data_admin->count()>0){
                            foreach ($data_admin as $data_admin => $item) {
                                $nama_user          = ($data_user==null? "N/a":$data_user->nama);
                                $id_admin           = $item->id_user;
                                $nama_admin         = $item->nama;
                                $jabatan_admin      = $item->Jabatan->admin;
                                $nomor_laporan      = $cuti->nomor_laporan;
                                $data_akun_admin    = User::find($id_admin);

                                if($data_akun_admin != null){
                                    $email_admin = $data_akun_admin->email;
                                    if( $email_admin != null || $email_admin != '' ){
                                        $pesan = "Yth.$jabatan_admin ($nama_admin)
                                                    berikut saya sampaikan pengajuan cuti atas nama $nama_user dengan nomor $nomor_laporan telah diperbaharui mohon diverifikasi";
                                        //$pesan = "hai ".$nama_admin.", nomor laporan cuti ".$nomor_laporan." sudah diperbaharui oleh ".$nama_user." mohon di cek ulang kembali laporannya dan mohon verifikasi";
                                        $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                    }
                                }
                            }
                        }
                    }
                    else{
                        $response = [
                           'status' => 0,
                           'message' => "Gagal simpan cuti",
                        ];
                    }
                }  
                else{
                    $response = [
                       'status' => 0,
                       'message' => "Total penambahan cuti melebihi batas",
                    ];
                }            
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "Data pengguna tidak ditemukan",
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Data tidak ditemukan",
            ];       
        }
        echo json_encode($response);
    }
    function delCuti($id){
        $response = array();
        $data_cuti = cuti::find($id);
        if($data_cuti != null){
            $cuti_n     = $data_cuti->cuti_n;
            $cuti_n1    = $data_cuti->cuti_n1;
            $cuti_n2    = $data_cuti->cuti_n2;
            
            $user   = data_user::where('id_user', $data_cuti->id_user)
                            ->update([
                                'cuti_n'  => DB::raw("cuti_n+$cuti_n"),
                                'cuti_n1' => DB::raw("cuti_n1+$cuti_n1"),
                                'cuti_n2' => DB::raw("cuti_n2+$cuti_n2")
                            ]);

            if($data_cuti->delete() && $user){
                $response = [
                    'status' => 1,
                    'message' => "berhasil hapus cuti",
                ]; 
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "gagal hapus cuti",
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Data tidak ditemukan",
            ];
        }
        echo json_encode($response);
    }

    //clear, email ok
    function getPinjamKendaraan($id){
        $response   = array();
        $data       = array();
        $pinjam_kendaraan = pinjam_kendaraan::where('id_peminjam',$id)->get();
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
                "nomor_laporan"             => $pinjam_kendaraan[$i]->nomor_laporan,
                "peminjam"                  => ($pinjam_kendaraan[$i]->id_peminjam==null?null:$this->getPengguna($pinjam_kendaraan[$i]->id_peminjam)),
                "jenis_kendaraan"           => $pinjam_kendaraan[$i]->jenis_kendaraan,
                "keperluan"                 => $pinjam_kendaraan[$i]->keperluan,
                "tujuan"                    => $pinjam_kendaraan[$i]->tujuan,
                "tanggal"                   => $pinjam_kendaraan[$i]->tanggal,
                "jam"                       => $pinjam_kendaraan[$i]->jam,
                "lama"                      => $pinjam_kendaraan[$i]->lama_keperluan,
                "pengemudi"                 => $this->getPengemudi($pinjam_kendaraan[$i]->id),
                "penumpang"                 => $this->getPenumpang($pinjam_kendaraan[$i]->id),
                "status_pinjam_kendaraan"   => $pinjam_kendaraan[$i]->status_acc,
                "surat_perjalanan_dinas"    => $surat_perjalanan_dinas 
            ];
            array_push($data, $arr);
        }
        $response = [
            'status' => (count($data)>0? 1:0),
            'message' => (count($data)>0?'data ditemukan':'data kosong'),
            'data' => $data 
        ];
        return json_encode($response);
    }
    function setPinjamKendaraan(Request $req){
        $response            = array();
        $id_perjalanan_dinas = ($req->id_perjalanan_dinas==""?null:$req->id_perjalanan_dinas); //int
        $id_peminjam         = $req->id_peminjam; //int
        $jenis_kendaraan     = $req->jenis_kendaraan; //int
        $penumpang           = $req->penumpang; //array id int
        $keperluan           = $req->keperluan; //int
        $id_tujuan           = $req->id_tujuan; //int
        $tanggal             = $req->tanggal; //string
        $jam                 = $req->jam; //string
        $lama_keperluan      = $req->lama_keperluan; //int
        // $pengemudi           = $req->pengemudi; //array id int

        $pinjam_kendaraan                           = new pinjam_kendaraan();
        $pinjam_kendaraan->nomor_laporan            = $this->generateCode();
        $pinjam_kendaraan->id_perjalanan_dinas      = $id_perjalanan_dinas;
        $pinjam_kendaraan->id_peminjam              = $id_peminjam;
        $pinjam_kendaraan->jenis_kendaraan          = $jenis_kendaraan;
        $pinjam_kendaraan->keperluan                = $keperluan;
        $pinjam_kendaraan->id_tujuan                = $id_tujuan;
        $pinjam_kendaraan->tanggal                  = $tanggal;
        $pinjam_kendaraan->jam                      = $jam;
        $pinjam_kendaraan->lama_keperluan           = $lama_keperluan;

        if($pinjam_kendaraan->save()){
            $data_penumpang = array();
            $data_penumpang_json = json_decode($penumpang, true);
            for($i=0;$i<count($data_penumpang_json);$i++){
                array_push($data_penumpang, array("id_pinjam_kendaraan"=>$pinjam_kendaraan->id,"id_user"=>$data_penumpang_json[$i]));
            }
            // if(count($data_penumpang)>0){
            //    $data_penumpang = array_unique($data_penumpang); 
            // }

            // $data_pengemudi = array();
            // $data_pengemudi_json = json_decode($pengemudi, true);
            // for($i=0;$i<count($data_pengemudi_json);$i++){
            //     array_push($data_pengemudi, array("id_pinjam_kendaraan"=>$pinjam_kendaraan->id,"id_pengemudi"=>$data_pengemudi_json[$i],"accept"=>0,"income_device_owner"=>0));
            // }

            $pinjam_kendaraan_penumpang = pinjam_kendaraan_penumpang::insert($data_penumpang);
            // $pinjam_kendaraan_pengemudi = pinjam_kendaraan_pengemudi::insert($data_pengemudi);
            //if($pinjam_kendaraan_penumpang && $pengemudi){
            if($pinjam_kendaraan_penumpang){
                $response = [
                    'status' => 1,
                    'message' => 'Berhasil Buat Surat Pinjam Kendaraan' 
                ];

                $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 8)
                                                // ->where('data_user.id_jabatan', 26)
                                                ->where('data_user.status',1);
                                          })->get();

                //$data_admin = data_user::where('id_jabatan',26)->get();
                $data_user  = data_user::where('id_user',$id_peminjam)->first();
                if($data_admin->count()>0){
                    foreach ($data_admin as $data_admin => $item) {
                        $nama_user          = ($data_user==null? "N/a":$data_user->nama);
                        $id_admin           = $item->id_user;
                        $nama_admin         = $item->nama;
                        $jabatan_admin      = $item->Jabatan->jabatan;
                        $nomor_laporan      = $pinjam_kendaraan->nomor_laporan;
                        $data_akun_admin    = User::find($id_admin);

                        if($data_akun_admin != null){
                            $email_admin = $data_akun_admin->email;
                            if( $email_admin != null || $email_admin != '' ){
                                $pesan = "Yth.$jabatan_admin ($nama_admin)
                                            berikut saya sampaikan pengajuan pinjam kendaraan atas nama $nama_user dengan nomor $nomor_laporan mohon diverifikasi";
                                //$pesan = "hai ".$nama_admin.", hari ini ada yang mengajukan laporan pinjam kendaraan dari ".$nama_user." dengan nomor laporan ".$nomor_laporan.", mohon di verifikasi laporannya";
                                $this->kirim_notif($nama_admin,$email_admin,$pesan);
                            }
                        }
                    }
                }
            }
            else{
                $hapus = pinjam_kendaraan::find($pinjam_kendaraan->id);
                $hapus->delete();

                $response = [
                   'status' => 0,
                    'message' => 'Gagagl Simpan Menugaskan' 
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => 'Gagagl Buat Surat Pinjam Kendaraan' 
            ];
        }
        echo json_encode($response);
    }
    function updatePinjamKendaraan(Request $req){
        $response            = array();
        $id                  = $req->id;
        $id_perjalanan_dinas = ($req->id_perjalanan_dinas==""?null:$req->id_perjalanan_dinas); //int
        $id_peminjam         = $req->id_peminjam; //int
        $jenis_kendaraan     = $req->jenis_kendaraan; //int
        $penumpang           = $req->penumpang; //array id int
        $keperluan           = $req->keperluan; //int
        $id_tujuan           = $req->id_tujuan; //int
        $tanggal             = $req->tanggal; //string
        $jam                 = $req->jam; //string
        $lama_keperluan      = $req->lama_keperluan; //int
        // $pengemudi           = $req->pengemudi; //array id int

        $pinjam_kendaraan    = pinjam_kendaraan::find($id);
        if($pinjam_kendaraan != null){
            $pinjam_kendaraan->id_perjalanan_dinas      = $id_perjalanan_dinas;
            $pinjam_kendaraan->id_peminjam              = $id_peminjam;
            $pinjam_kendaraan->jenis_kendaraan          = $jenis_kendaraan;
            $pinjam_kendaraan->keperluan                = $keperluan;
            $pinjam_kendaraan->id_tujuan                = $id_tujuan;
            $pinjam_kendaraan->tanggal                  = $tanggal;
            $pinjam_kendaraan->jam                      = $jam;
            $pinjam_kendaraan->lama_keperluan           = $lama_keperluan;

            $data_penumpang_json = json_decode($penumpang, true);
            // $data_pengemudi_json = json_decode($pengemudi, true);

            $arr_id_penumpang = array();
            for($i=0;$i<count($data_penumpang_json);$i++){
                array_push($arr_id_penumpang, $data_penumpang_json[$i]);
            }

            // $arr_id_pengemudi = array();
            // for($i=0;$i<count($data_pengemudi_json);$i++){
            //     array_push($arr_id_pengemudi, $data_pengemudi_json[$i]);
            // }

            if($this->CheckDataId($arr_id_penumpang,'user','id')){
                //if($this->CheckDataId($arr_id_pengemudi,'pengemudi','id')){
                    if($pinjam_kendaraan->save()){
                        $data_penumpang = array();
                        for($i=0;$i<count($data_penumpang_json);$i++){
                            array_push($data_penumpang, array("id_pinjam_kendaraan"=>$id,"id_user"=>$data_penumpang_json[$i]));
                        }
                        // if(count($data_penumpang)>0){
                        //    $data_penumpang = array_unique($data_penumpang); 
                        // }

                        // $data_pengemudi = array();
                        // for($i=0;$i<count($data_pengemudi_json);$i++){
                        //     array_push($data_pengemudi, array("id_pinjam_kendaraan"=>$id,"id_pengemudi"=>$data_pengemudi_json[$i],"accept"=>0,"income_device_owner"=>0));
                        // }

                        $delete_pinjam_kendaraan_penumpang = pinjam_kendaraan_penumpang::where('id_pinjam_kendaraan',$id); 
                        //$delete_pinjam_kendaraan_pengemudi = pinjam_kendaraan_pengemudi::where('id_pinjam_kendaraan',$id); 

                        //if($delete_pinjam_kendaraan_penumpang->delete() && $delete_pinjam_kendaraan_pengemudi->delete()){
                        if($delete_pinjam_kendaraan_penumpang->delete()){
                            $pinjam_kendaraan_penumpang = pinjam_kendaraan_penumpang::insert($data_penumpang);
                            // $pinjam_kendaraan_pengemudi = pinjam_kendaraan_pengemudi::insert($data_pengemudi);

                            //if($pinjam_kendaraan_penumpang && $pinjam_kendaraan_pengemudi){
                            if($pinjam_kendaraan_penumpang){
                                $response = [
                                    'status' => 1,
                                    'message' => 'Berhasil Simpan Surat Pinjam Kendaraan' 
                                ];

                                $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 8)
                                                // ->where('data_user.id_jabatan', 26)
                                                ->where('data_user.status',1);
                                          })->get();

                                //$data_admin = data_user::where('id_jabatan',26)->get();
                                $data_user  = data_user::where('id_user',$id_peminjam)->first();
                                if($data_admin->count()>0){
                                    foreach ($data_admin as $data_admin => $item) {
                                        $nama_user          = ($data_user==null? "N/a":$data_user->nama);
                                        $id_admin           = $item->id_user;
                                        $nama_admin         = $item->nama;
                                        $jabatan_admin      = $item->Jabatan->jabatan;
                                        $nomor_laporan      = $pinjam_kendaraan->nomor_laporan;
                                        $data_akun_admin    = User::find($id_admin);

                                        if($data_akun_admin != null){
                                            $email_admin = $data_akun_admin->email;
                                            if( $email_admin != null || $email_admin != '' ){
                                                $pesan = "Yth.$jabatan_admin ($nama_admin)
                                                            berikut saya sampaikan pengajuan pinjam kendaraan atas nama $nama_user dengan nomor $nomor_laporan telah diperbaharui mohon diverifikasi";
                                                //$pesan = "hai ".$nama_admin.", nomor laporan pinjam kendaraan ".$nomor_laporan." sudah diperbaharui oleh ".$nama_user." mohon di cek ulang kembali laporannya dan mohon verifikasi";
                                                $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                            }
                                        }
                                    }
                                }
                            }
                            else{
                                $response = [
                                   'status' => 0,
                                   'message' => 'Gagal simpan data baru penumpang dan pengemudi' 
                                ];
                            }
                        }
                        else{
                            $response = [
                               'status' => 0,
                               'message' => 'Gagal hapus data lama penumpang dan pengemudi' 
                            ];
                        }
                    }
                    else{
                        $response = [
                            'status' => 0,
                            'message' => 'Gagal Simpan Surat Pinjam Kendaraan' 
                        ];
                    }
                // }
                // else{
                //     $response = [
                //         'status' => 0,
                //         'message' => 'Data pengemudi tidak valid' 
                //     ];
                // }
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => 'Data penumpang tidak valid' 
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => 'Data tidak ditemukan' 
            ];
        }
        echo json_encode($response);
    }
    function delPinjamKendaraan($id){
        $response = array();
        $pinjam_kendaraan = pinjam_kendaraan::find($id);
        if($pinjam_kendaraan != null){
            $pinjam_kendaraan_pengemudi = pinjam_kendaraan_pengemudi::where('id_pinjam_kendaraan',$pinjam_kendaraan->id)->get();
            // $id_pengemudi = array();
            // foreach ($pinjam_kendaraan_pengemudi as $key => $value) {
            //     array_push($id_pengemudi, $value->id_pengemudi);
            // }

            // $pengemudi = pengemudi::whereIn('id',$id_pengemudi);

            //if($pinjam_kendaraan->delete() && $pengemudi->update(['status_tersedia'=>1])){
            if($pinjam_kendaraan->delete()){
                $response = [
                    'status' => 1,
                    'message' => "berhasil hapus",
                ];
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "gagal hapus",
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Data tidak ditemukan",
            ];
        }
        echo json_encode($response);
    }

    function getOrderKendaraan($id){
        $response   = array();
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

            // $data_pengemudi = pengemudi::where('id_user',$id)->first();
            $pengemudi = $this->getPengemudi($pinjam_kendaraan[$i]->id);
            $penumpang = $this->getPenumpang($pinjam_kendaraan[$i]->id);

            $arr = [
                "id"                        => $pinjam_kendaraan[$i]->id,
                "nomor_laporan"             => $pinjam_kendaraan[$i]->nomor_laporan,
                "peminjam"                  => ($pinjam_kendaraan[$i]->id_peminjam==null?null:$this->getPengguna($pinjam_kendaraan[$i]->id_peminjam)),
                "jenis_kendaraan"           => $pinjam_kendaraan[$i]->jenis_kendaraan,
                "keperluan"                 => $pinjam_kendaraan[$i]->keperluan,
                "tujuan"                    => $pinjam_kendaraan[$i]->tujuan,
                "tanggal"                   => $pinjam_kendaraan[$i]->tanggal,
                "jam"                       => $pinjam_kendaraan[$i]->jam,
                "lama"                      => $pinjam_kendaraan[$i]->lama_keperluan,
                "pengemudi"                 => $pengemudi,
                "penumpang"                 => $penumpang,
                "status_pinjam_kendaraan"   => $pinjam_kendaraan[$i]->status_acc,
                "surat_perjalanan_dinas"    => $surat_perjalanan_dinas 
            ];


            foreach ($pengemudi as $item) {
                // if($data_pengemudi != null){
                //     if($item['id']==$data_pengemudi->id)
                //         array_push($data, $arr);
                // }
                if($item['id']==$id){
                    array_push($data, $arr);
                }
            }
        }
        $response = [
            'status' => (count($data)>0? 1:0),
            'message' => (count($data)>0?'data ditemukan':'data kosong'),
            'data' => $data 
        ];
        return json_encode($response);
    }
    function acceptOrderKendaraan($id_pinjam_kendaraan,$id){
        $response = array();
        $data = pinjam_kendaraan_pengemudi::where('id_pinjam_kendaraan',$id_pinjam_kendaraan)->where('id_pengemudi',$id)->first();
        $data_pengemudi = data_user::find($id);

        if($data != null){
            $data->accept = 1;
            if($data->save()){
                $data_pengemudi = data_user::find($data->Pengemudi->id_user);
                $nama_pengemudi = ($data_pengemudi==null? "N/a":$data_pengemudi->nama);

                $data_laporan   = pinjam_kendaraan::find($id_pinjam_kendaraan);
                $id_peminjam    = $data_laporan->id_peminjam;
                $nomor_laporan  = $data_laporan->nomor_laporan;

                $data_user      = data_user::where('id_user',$id_peminjam)->first();
                $nama_user      = ($data_user==null? "N/a":$data_user->nama);
                $data_akun_user = User::find($id_peminjam);
                $email_user     = $data_akun_user->email;

                if($email_user != null){
                    $pesan = "Yth.$nama_user<br>
                                permohonan pinjam kendaraan nomor $nomor_laporan telah diterima pengemudi ($nama_pengemudi)";
                    //$pesan = "hai ".$nama_user.", nomor laporan pinjam kendaraan ".$nomor_laporan." telah di terima pengemudi ".$nama_pengemudi;
                    $this->kirim_notif($nama_user,$email_user,$pesan);

                    $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 8)
                                                // ->where('data_user.id_jabatan', 26)
                                                ->where('data_user.status',1);
                                          })->get();

                    //$data_admin = data_user::where('id_jabatan',26)->get();
                    if($data_admin->count()>0){
                        foreach ($data_admin as $data_admin => $item) {
                            $id_admin           = $item->id_user;
                            $nama_admin         = $item->nama;
                            $jabatan_admin      = $item->Jabatan->jabatan;
                            $data_akun_admin    = User::find($id_admin);

                            if($data_akun_admin != null){
                                $email_admin = $data_akun_admin->email;
                                if( $email_admin != null || $email_admin != '' ){
                                    $pesan = "Yth.$jabatan_admin ($nama_admin)
                                                permohonan pinjam kendaraan nomor $nomor_laporan telah diterima pengemudi ($nama_pengemudi)";
                                    //$pesan = "hai $nama_admin, nomor laporan pinjam kendaraan $nomor_laporan yg diajukan oleh $nama_user telah diterima oleh pengemudi $nama_pengemudi";
                                    $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                }
                            }
                        }
                    }
                }

                $response = [
                    'status' => 1,
                    'message' => "Berhasil terima order",
                ];
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "Gagal terima order",
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Data tidak ditemukan",
            ];
        }

        echo json_encode($response);
    }
    function cancelOrderKendaraan($id_pinjam_kendaraan,$id){
        $response = array();
        $data = pinjam_kendaraan_pengemudi::where('id_pinjam_kendaraan',$id_pinjam_kendaraan)->where('id_pengemudi',$id)->first();
        if($data != null){
            $data->accept = -1;
            if($data->save()){
                $data_pengemudi = data_user::find($data->Pengemudi->id_user);
                $nama_pengemudi = ($data_pengemudi==null? "N/a":$data_pengemudi->nama);

                $data_laporan   = pinjam_kendaraan::find($id_pinjam_kendaraan);
                $id_peminjam    = $data_laporan->id_peminjam;
                $nomor_laporan  = $data_laporan->nomor_laporan;

                $data_user      = data_user::where('id_user',$id_peminjam)->first();
                $nama_user      = ($data_user==null? "N/a":$data_user->nama);
                $data_akun_user = User::find($id_peminjam);
                $email_user     = $data_akun_user->email;

                if($email_user != null){
                    $pesan = "Yth.$nama_user<br>
                                permohonan pinjam kendaraan nomor $nomor_laporan telah ditolak pengemudi ($nama_pengemudi)";
                    //$pesan = "hai ".$nama_user.", nomor laporan pinjam kendaraan ".$nomor_laporan." telah di tolak pengemudi ".$nama_pengemudi;
                    $this->kirim_notif($nama_user,$email_user,$pesan);

                    $data_admin = data_user::join('user', function ($join) {
                                                $join->on('data_user.id_user', '=', 'user.id')
                                                ->where('user.id_role', 8)
                                                // ->where('data_user.id_jabatan', 26)
                                                ->where('data_user.status',1);
                                          })->get();

                    //$data_admin = data_user::where('id_jabatan',26)->get();
                    if($data_admin->count()>0){
                        foreach ($data_admin as $data_admin => $item) {
                            $id_admin           = $item->id_user;
                            $nama_admin         = $item->nama;
                            $jabatan_admin      = $item->Jabatan->jabatan;
                            $data_akun_admin    = User::find($id_admin);

                            if($data_akun_admin != null){
                                $email_admin = $data_akun_admin->email;
                                if( $email_admin != null || $email_admin != '' ){
                                    $pesan = "Yth.$jabatan_admin ($nama_admin)
                                                permohonan pinjam kendaraan nomor $nomor_laporan telah ditolak pengemudi ($nama_pengemudi)";
                                    //$pesan = "hai $nama_admin, nomor laporan pinjam kendaraan $nomor_laporan yg diajukan oleh $nama_user telah ditolak oleh pengemudi $nama_pengemudi";
                                    $this->kirim_notif($nama_admin,$email_admin,$pesan);
                                }
                            }
                        }
                    }
                }

                $response = [
                    'status' => 1,
                    'message' => "Berhasil tolak order",
                ];
            }
            else{
                $response = [
                    'status' => 0,
                    'message' => "Gagal tolak order",
                ];
            }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Data tidak ditemukan",
            ];
        }

        echo json_encode($response);
    }
    function getNotif(Request $req){
        $respon = array();

        if( Auth::attempt(["username"=>$req->username,"password"=>$req->password]) ){
              if(Auth::check()){
                    $data_notif     = array();

                    $id_user        = Auth::user()->id;
                    $data_user      = data_user::where('id_user',$id_user)->first();
                    $nama_pengguna  = ($data_user==null?"N/a":$data_user->nama);

                    $data_pengemudi                         = pengemudi::where('id_user',$id_user)->first();
                    if($data_pengemudi!=null){
                        $id_pengemudi                       = $data_pengemudi->id;
                        $data_pinjam_kendaraan_pengemudi    = pinjam_kendaraan_pengemudi::where('id_pengemudi',$id_pengemudi)->get();

                        for ($i=0; $i < $data_pinjam_kendaraan_pengemudi->count(); $i++) { 
                            if($data_pinjam_kendaraan_pengemudi[$i]->income_device_owner == 0){
                                $id_pinjam_kendaraan    = $data_pinjam_kendaraan_pengemudi[$i]->id_pinjam_kendaraan;

                                $data_pinjam_kendaraan  = pinjam_kendaraan::where('id',$id_pinjam_kendaraan)->first();
                                $tanggal                = ($data_pinjam_kendaraan==null?"N/a": Carbon::parse($data_pinjam_kendaraan->tanggal)->formatLocalized("%d %B %Y"));
                                $pukul                  = ($data_pinjam_kendaraan==null?"N/a":$data_pinjam_kendaraan->jam);
                                $tujuan                 = ($data_pinjam_kendaraan==null?"N/a":$data_pinjam_kendaraan->tujuan->tujuan);
                                $pengguna               = $this->getPengguna($data_pinjam_kendaraan->id_peminjam);
                                if($pengguna == null)
                                    $pengguna = "N/a";
                                else
                                    $pengguna = $pengguna['nama'];

                                $pinjam_kendaraan_pengemudi = pinjam_kendaraan_pengemudi::find($data_pinjam_kendaraan_pengemudi[$i]->id);
                                $pinjam_kendaraan_pengemudi->income_device_owner = 1;
                                if($pinjam_kendaraan_pengemudi->save()){
                                    $arr = [
                                        'id' => $data_pinjam_kendaraan_pengemudi[$i]->id,
                                        "pesan" => "Bapak $nama_pengguna yang berbahagia berikut tugas pengantaran bapak $pengguna ke tujuan $tujuan pada tanggal $tanggal mohon diperhatikan waktu keberangkatan"
                                    ];

                                    array_push($data_notif, $arr);
                                }
                            }
                        }

                        $response = [
                            'status' => (count($data_notif)>0? 1:0),
                            'message' => (count($data_notif)>0?"data ditemukan":" data tidak ditemukan"),
                            "data" => $data_notif
                        ];
                    }
                    else{
                        $response = [
                            'status' => 0,
                            'message' => "Data tidak ditemukan",
                        ];
                    }    
              }
              else{
                $response = [
                    'status' => 0,
                    'message' => "Akses ditolak",
                ];    
              }
        }
        else{
            $response = [
                'status' => 0,
                'message' => "Akun tidak valid",
            ];
        }

        echo json_encode($response);
    }

    //example
    // function roots(){
    //     $data = root::with('subparent')->whereNull('parent')->get();
    //     echo json_encode($data);
    // }

    ///////////////////////////////////////////////////
    function group_data($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
    function getPangkatName($nama){
        return pangkat::where('pangkat',$nama)->first();
    }
    function kirim_notif($nama_admin,$email_admin,$pesan){
        try{
            $kirim = Mail::send('template_email', array('pesan' => $pesan) , function($pesan) use ($email_admin, $nama_admin){
                        $pesan->to($email_admin,$nama_admin)->subject('Notifikasi');
                        $pesan->from('no-reply@app.balittro.com','App Balittro');
                    });
        }
        catch (Exception $e) {
            echo "error:".$e->getMessage();
        }
    }
    function tes(){
        return $this->generateCode();
    }
}
