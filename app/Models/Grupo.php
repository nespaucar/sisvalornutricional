<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;
    protected $table = 'grupo';
    protected $dates = ['deleted_at'];

    public function menuoptions()
    {
        return $this->hasMany('App\Models\Alimento');
    }
}
