<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Local extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'local';
    protected $dates = ['deleted_at'];

    public function scopelistar($query, $nombre)
    {
        return $query->where(function($subquery) use($nombre)
        {
            if (!is_null($nombre)) {
                $subquery->where('nombre', 'LIKE', '%'.$nombre.'%');
            }
        })
        ->orderBy('id', 'ASC');
    }
}
