<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class laporan_upg_detail extends Model
{
    protected $table = 'laporan_upg_detail';
    public function Jenis_Gratifikasi(){
    	return $this->belongsTo(jenis_gratifikasi::class,'id_jenis_gratifikasi');
    }
}
