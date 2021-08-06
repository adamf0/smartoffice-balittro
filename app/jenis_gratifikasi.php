<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jenis_gratifikasi extends Model
{
    protected $table = 'jenis_gratifikasi';
    public function laporan_upg_detail(){
    	$this->hasMany(laporan_upg_detail::class);
    }
}
