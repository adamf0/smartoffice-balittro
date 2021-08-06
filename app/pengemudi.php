<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pengemudi extends Model
{
    protected $table = 'pengemudi';
    // public function Perjalanan_Dinas(){
    // 	$this->hasMany(perjalanan_dinas::class);
    // }
    public function Pinjam_Kendaraan_Pengemudi(){
    	$this->hasMany(pinjam_kendaraan_pengemudi::class);
    }
}
