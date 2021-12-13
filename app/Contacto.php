<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use SoftDeletes;
    protected $table = 'contacto';
    protected $dates = ['deleted_at'];
}
