<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class potong_anggaran extends Model
{
    protected $table = 'potong_anggaran';

    public function Pagu_Anggaran(){
        return $this->belongsTo(pagu_anggaran::class,'id_pagu_anggaran');
    }
    public function getTanggalAttribute($value){
    	return ($this->attributes['created_at']==null?"N/a":Carbon::parse($this->attributes['created_at'])->formatLocalized("%d %B %Y"));
    }
}
