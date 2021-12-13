<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disenador extends Model
{
    use SoftDeletes;
    protected $table = 'disenador';
    protected $dates = ['deleted_at'];
}
