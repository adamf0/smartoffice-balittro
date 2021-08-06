<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class root extends Model
{
    //protected $table = 'roots';
    public function parent()
    {
        return $this->belongsTo(root::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(root::class, 'parent');
    }
    public function subparent()
	{
	   return $this->children()->with('subparent');
	}
}
