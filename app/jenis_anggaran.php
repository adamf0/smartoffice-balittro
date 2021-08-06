<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jenis_anggaran extends Model
{
    protected $table = 'jenis_anggaran';
    public function Anggaran(){
    	return $this->hasMany(anggaran::class);
    }
}
