<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cuti extends Model
{
    protected $table = 'cuti';
    public function Jenis_Cuti(){
    	return $this->belongsTo(jenis_cuti::class,'id_jenis_cuti');
    }
}
