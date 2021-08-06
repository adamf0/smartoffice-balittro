<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class golongan extends Model
{
    protected $table = 'golongan';
    public function Detail_User(){
    	return $this->hasMany(data_user::class);
    }
}
