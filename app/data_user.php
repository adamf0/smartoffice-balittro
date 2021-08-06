<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class data_user extends Model
{
    protected $table = 'data_user';
    public function Agama(){
    	return $this->belongsTo(agama::class,'id_agama');
    }
    public function Pangkat(){
        return $this->belongsTo(pangkat::class,'id_pangkat');
    }
    public function Jabatan(){
    	return $this->belongsTo(jabatan::class,'id_jabatan');
    }
    public function Golongan(){
        return $this->belongsTo(golongan::class,'id_golongan');
    }
    public function Jenjang_Pendidikan(){
        return $this->belongsTo(jenjang_pendidikan::class,'id_jenjang_pendidikan');
    }
    // public function Perjalanan_Dinas_Detail(){
    // 	return $this->hasMany(perjalanan_dinas_detail::class);
    // }
    // public function Pinjam_Kendaraan_Penumpang(){
    //     $this->hasMany(pinjam_kendaraan_penumpang::class);
    // }
}
