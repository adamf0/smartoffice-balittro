<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pinjam_kendaraan extends Model
{
    protected $table = 'pinjam_kendaraan';
    public function Tujuan(){
    	return $this->belongsTo(tujuan::class,'id_tujuan');
    }
    public function Perjalanan_Dinas(){
    	return $this->belongsTo(perjalanan_dinas::class,'id_perjalanan_dinas');
    }

}
