<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorito extends Model
{
    use SoftDeletes;
    protected $table = 'favorito';
    protected $dates = ['deleted_at'];
}
