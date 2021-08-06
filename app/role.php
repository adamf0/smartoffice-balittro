<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $table = 'role';
    public function User(){
    	return $this->hasMany(User::class);
    }
}
