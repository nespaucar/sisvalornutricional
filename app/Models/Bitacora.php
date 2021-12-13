<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bitacora extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'bitacora';
    protected $dates = ['deleted_at'];

    public function scopelistar($query, $name) {
        return $query->where(function($subquery) use($name)
        {
        	if (!is_null($name)) {
                $subquery->orWhere('descripcion', 'LIKE', '%'.$name.'%');
        		$subquery->orWhere('tabla', 'LIKE', '%'.$name.'%');
        	}
        })
		->orderBy('created_at', 'DESC');
    }

    public function detallepago()
	{
		return $this->belongsTo('App\Models\Detallepago', 'detallepago_id');
	}

	public function usuario()
	{
		return $this->belongsTo('App\Models\Usuario', 'usuario_id');
	}
}
