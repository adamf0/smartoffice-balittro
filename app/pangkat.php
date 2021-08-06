<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pangkat extends Model
{
    protected $table = 'pangkat';
    public function Detail_User(){
    	return $this->hasMany(data_user::class);
    }
}
