<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menuoptioncategory extends Model
{
    use SoftDeletes;
    protected $table = 'menuoptioncategory';
    protected $dates = ['deleted_at'];

    public function menuoptions()
	{
		return $this->hasMany('App\Models\Menuoption');
	}

	public function Fathercategory()
	{
		return $this->belongsTo('App\Models\Menuoptioncategory', 'menuoptioncategory_id');
	}

	public function Soncategory()
	{
		return $this->hasMany('App\Models\Menuoptioncategory', 'menuoptioncategory_id');
	}

	public function scopelistar($query, $name)
    {
        return $query->where(function($subquery) use($name) {
        	if (!is_null($name)) {
        		$subquery->where('name', 'LIKE', '%'.$name.'%');
        	}
        })
		->orderBy('menuoptioncategory_id', 'ASC')
		->orderBy('order', 'ASC');
    }
}
