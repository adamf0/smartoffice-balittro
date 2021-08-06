<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anggaran extends Model
{
    protected $table = 'biaya_anggaran';
    public function Jenis_Anggaran(){
    	return $this->belongsTo(jenis_anggaran::class,'id_jenis_anggaran');
    }
    public function Tujuan(){
    	return $this->belongsTo(tujuan::class,'id_tujuan');
    }
}
