<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jenjang_pendidikan extends Model
{
    protected $table = 'jenjang_pendidikan';
    public function Detail_User(){
    	return $this->hasMany(data_user::class);
    }
}
