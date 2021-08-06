<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class perjalanan_dinas extends Model
{
    protected $table = 'perjalanan_dinas';
    // public function Pengemudi(){
    // 	return $this->belongsTo(pengemudi::class,'id_pengemudi');
    // }
    public function getNamaKendaraanAttribute($value){
    	return ($this->attributes['kendaraan']==0? "Dinas":"Umum");
    }
    public function Tujuan(){
    	return $this->belongsTo(tujuan::class,'id_tujuan');
    }
    public function Pinjam_Kendaraan(){
        return $this->hasMany(pinjam_kendaraan::class);
    }
    public function Kwitansi_SPPD(){
        $this->hasMany(kwitansi_sppd::class);
    }
    public function Surat_Perjalanan_Dinas(){
        $this->hasMany(surat_perjalanan_dinas::class);
    }

    public function Pagu_Anggaran(){
        return $this->belongsTo(pagu_anggaran::class,'kegiatan');
    }
}
