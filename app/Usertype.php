<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usertype extends Model
{
	use SoftDeletes;
    protected $table = 'usertype';
    protected $dates = ['deleted_at'];

    public function scopelistar($query, $name)
    {
        return $query->where(function($subquery) use($name)
		            {
		            	if (!is_null($name)) {
		            		$subquery->where('nombre', 'LIKE', '%'.$name.'%');
		            	}
		            })
        			->orderBy('nombre', 'ASC');
    }

    public function users()
	{
		return $this->hasMany('App\User');
	}

	public function permissions()
	{
		return $this->hasMany('App\Permission');
	}
	
	public function menuoptions(){
		return $this->belongsToMany('App\Menuoption', 'permission', 'usertype_id', 'menuoption_id');
	}
}
