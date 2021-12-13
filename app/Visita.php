<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visita extends Model
{
    use SoftDeletes;
    protected $table = 'visita';
    protected $dates = ['deleted_at'];
}
