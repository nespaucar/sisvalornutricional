<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagen extends Model
{
    use SoftDeletes;
    protected $table = 'imagen';
    protected $dates = ['deleted_at'];
}
