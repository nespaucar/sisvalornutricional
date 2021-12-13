<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menuoption extends Model {
	
	use SoftDeletes;
	use HasFactory;
    protected $table = 'menuoption';
    protected $dates = ['deleted_at'];

	public function menuoptioncategory() {
		return $this->belongsTo('App\Models\Menuoptioncategory', 'menuoptioncategory_id');
	}

	public function scopelistar($query, $name, $menuoptioncategory_id) {
        return $query->where(function($subquery) use($name)
	        {
	        	if (!is_null($name)) {
	        		$subquery->where('name', 'LIKE', '%'.$name.'%');
	        	}
	        })
			->where(function($subquery) use($menuoptioncategory_id)
	        {
	        	if (!is_null($menuoptioncategory_id)) {
	        		$subquery->where('menuoptioncategory_id', '=', $menuoptioncategory_id);
	        	}
	        })
			->orderBy('menuoptioncategory_id', 'ASC')
			->orderBy('order', 'ASC');
    }
}
