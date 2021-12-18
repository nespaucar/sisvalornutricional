<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'persona';
    protected $dates = ['deleted_at'];

    public function local(){
        return $this->belongsTo('App\Models\Local', 'local_id');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }

    public function scopelistarpersonas($query, $nombre, $dni, $usertype_id, $local_id)
    {
        return $query->where(function($subquery) use($nombre, $dni, $usertype_id, $local_id)
        {
            if (!is_null($nombre)) {
                $subquery->where(DB::raw('CONCAT(persona.apellidopaterno, " ", persona.apellidomaterno, " ", persona.nombres)'), 'LIKE', '%'.$nombre.'%');
            }
            if (!is_null($dni)) {
                $subquery->where('dni', 'LIKE', '%'.$dni.'%');
            }
            if (!is_null($usertype_id)) {
                $subquery->where('usuario.usertype_id', '=', $usertype_id);
            }
            if (!is_null($local_id)) {
                $subquery->where('persona.local_id', '=', $local_id);
            }
        })
        ->join("usuario", "usuario.persona_id", "=", "persona.id")
        ->join("usertype", "usuario.usertype_id", "=", "usertype.id")
        ->where("usertype_id", "=", $usertype_id) //2 ALUMNO, 5 APODERADO
        ->select("persona.*", "usuario.state as estado", "usuario.email")
        ->orderBy(DB::raw('CONCAT(persona.apellidopaterno, " ", persona.apellidomaterno, " ", persona.nombres)'), 'ASC');
    }
}
