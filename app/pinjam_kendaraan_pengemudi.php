<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pinjam_kendaraan_pengemudi extends Model
{
    protected $table = "pinjam_kendaraan_pengemudi";
    public function Pengemudi(){
    	return $this->belongsTo(pengemudi::class,'id_pengemudi');
    }
}
