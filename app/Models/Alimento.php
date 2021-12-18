<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alimento extends Model
{
    use SoftDeletes;
    protected $table = 'alimento';
    protected $dates = ['deleted_at'];

    public function detallepago()
    {
        return $this->belongsTo('App\Models\Grupo', 'grupo_id');
    }
}
