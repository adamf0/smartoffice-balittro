<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    protected $table = 'jabatan';
    public function Detail_User(){
    	return $this->hasMany(data_user::class);
    }
}
