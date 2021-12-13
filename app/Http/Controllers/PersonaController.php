<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Persona;
use App\Models\Mercader;
use App\Models\Detalleconceptopago;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PersonaController extends Controller
{
    public function personasautocompleting($searching) {
        $user      = Auth::user();
        $local_id  = $user->persona->local_id;
        $resultado = Persona::select('nombres', 'id', 'dni')
            ->where('nombres', 'LIKE', '%'.$searching.'%')
            ->where('local_id', '=', $local_id)
            ->where('tipo', '=', 'A') // Solo administradores
            ->orderBy('nombres', 'ASC');
        $list      = $resultado->get();
        $data = array();
        foreach ($list as $key => $value) {
            $data[] = array(
                'label' => $value->nombres,
                'id'    => $value->id,
                'value' => $value->nombres,
                'dni'   => $value->dni,
            );
        }
        return json_encode($data);
    }

    public function buscarDNIMercader(Request $request) {
        $dni = $request->input('dni');
        $resultado = Persona::select('nombres', 'id')
            ->where('dni', '=', $dni)
            ->where('tipo', '=', 'V') // Solo mercaderes
            ->first();
        $estado = 'ERROR';
        $nombres = '';
        $id = 0;
        if($resultado!==NULL) {
            $estado = 'OK';
            $nombres = $resultado->nombres;            
            $mercader = Mercader::where('persona_id', '=', $resultado->id)->first();
            if($mercader!==NULL) {
                $id = $mercader->id;
            }
        }
        $retorno = array(
            'estado' => $estado,
            'nombres' => $nombres,
            'id' => $id,
        );
        return json_encode($retorno);
    }

    public function cargarDetallesConceptosPagosDeMercader(Request $request) {
        $id = $request->input('id');
        $mercader = Mercader::find($id);
        $opciones = '<option value="">--- Selecciona ---</option>';
        $estado = 'ERROR';
        if($mercader!==NULL) {
            $estado = 'OK';
            $detalles = Detalleconceptopago::where('mercader_id', '=', $id)->get();
            //if(count($detalles)>0) {
                foreach ($detalles as $det) {
                    $opciones .= '<option value="' . $det->id . '">#' . $det->comentario . ' - ' . $det->conceptopago->nombre . '</option>';
                }
            //}
        }
        $retorno = array(
            'estado' => $estado,
            'opciones' => $opciones,
        );
        return json_encode($retorno);
    }
}
