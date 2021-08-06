<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class agama extends Model
{
    protected $table = 'agama';
    public function Detail_User(){
    	return $this->hasMany(data_user::class);
    }
}
