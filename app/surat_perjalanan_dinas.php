<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class surat_perjalanan_dinas extends Model
{
    protected $table = 'surat_perjalanan_dinas';
    public function Perjalanan_Dinas(){
    	return $this->belongsTo(perjalanan_dinas::class,'id_perjalanan_dinas');
    }
}
