<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jenis_cuti extends Model
{
    protected $table = 'jenis_cuti';
    public function Cuti(){
    	$this->hasMany(cuti::class);
    }
    public function getImageAttribute($value){
    	return url('/public/storage/'.($this->attributes['img']==null? "error.png":$this->attributes['img']));
    }

}
