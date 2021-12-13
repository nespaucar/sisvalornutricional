<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
	use SoftDeletes;
	use HasFactory;
	protected $table = 'permission';
    protected $dates = ['deleted_at'];    
}