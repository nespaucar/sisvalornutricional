<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diseno extends Model
{
    use SoftDeletes;
    protected $table = 'diseno';
    protected $dates = ['deleted_at'];
}
