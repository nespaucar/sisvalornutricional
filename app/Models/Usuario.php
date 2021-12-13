<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\UsuarioResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasFactory;
    protected $table = 'usuario';

    protected $fillable = [
       'id','login', 'password', 'state','email','usertype_id','empresa_id','alumno_id','avatar'
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopelistar($query, $login, $tipousuario_id)
    {
        $query->join('persona', 'persona.id', 'usuario.persona_id');
        return $query->where(function($subquery) use($login, $tipousuario_id)
        {
            if (!is_null($login)) {
                $subquery->where(function($subq) use ($login) {
                    $subq->orWhere('login', 'LIKE', '%'.$login.'%');
                    $subq->orWhere('nombres', 'LIKE', '%'.$login.'%');
                });                    
            }
            if (!is_null($tipousuario_id)) {
                $subquery->where('usertype_id', '=', $tipousuario_id);
            }
        })
        ->select('usuario.*')
        ->orderBy('login', 'ASC');
    }

    public function usertype()
    {
        return $this->belongsTo('App\Models\Usertype', 'usertype_id');
    }

    public function persona(){
        return $this->belongsTo('App\Models\Persona', 'persona_id');
    }

    public function sendPasswordResetNotification($token)
    {
      $this->notify(new UsuarioResetPasswordNotification($token));
    }
}
