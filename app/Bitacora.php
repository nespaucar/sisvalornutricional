<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bitacora extends Model
{
    use SoftDeletes;
    protected $table = 'bitacora';
    protected $dates = ['deleted_at'];

    public function detallepago()
	{
		return $this->belongsTo('App\Detallepago', 'detallepago_id');
	}
}
