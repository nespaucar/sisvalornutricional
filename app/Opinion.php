<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opinion extends Model
{
    use SoftDeletes;
    protected $table = 'opinion';
    protected $dates = ['deleted_at'];
}
