<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;
    protected $table = 'categoria';
    protected $dates = ['deleted_at'];

    public function local() {
		return $this->belongsTo('App\Local', 'local_id');
	}

	public function productos(){
        return $this->hasMany('App\Producto');
    }
}
