<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tujuan extends Model
{
    protected $table = 'tujuan';
    public function Anggaran(){
    	return $this->hasMany(anggaran::class);
    }
    public function Perjalanan_Dinas(){
    	return $this->hasMany(perjalanan_dinas::class);
    }
    public function Pinjam_Kendaraan(){
    	return $this->hasMany(pinjam_kendaraan::class);
    }
}
