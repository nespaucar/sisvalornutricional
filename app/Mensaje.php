<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mensaje extends Model
{
    use SoftDeletes;
    protected $table = 'mensaje';
    protected $dates = ['deleted_at'];
}
