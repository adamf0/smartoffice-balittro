<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class pagu_anggaran extends Model
{
    protected $table = 'pagu_anggaran';

    public function Perjalanan_Dinas(){
        $this->hasMany(perjalanan_dinas::class);
    }
    public function Potong_Anggaran(){
    	$this->hasMany(potong_anggaran::class);
    }
    public function getTanggalAttribute($value){
    	return ($this->attributes['created_at']==null?"N/a":Carbon::parse($this->attributes['created_at'])->formatLocalized("%d %B %Y %H:%M:%S"));
    }
}
