<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kwitansi_sppd extends Model
{
    protected $table = 'kwitansi_sppd';
    public function Perjalanan_Dinas(){
    	return $this->belongsTo(perjalanan_dinas::class,'id_perjalanan_dinas');
    }
}
