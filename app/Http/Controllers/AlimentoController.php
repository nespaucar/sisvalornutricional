<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Alimento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AlimentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cargarSelectAlimentos(Request $request) {
        $cboAlimentos = '<option value="">-- Seleccione un Alimento --</option>';
        $alimentos    = Alimento::select("alimento.id", DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion) AS descr"), 'alimento.estrato')
            ->join('grupo', 'alimento.grupo_id', 'grupo.id')
            ->where('alimento.estado', '=', 1)
            ->get();
        foreach ($alimentos as $alim) {
            $cboAlimentos .= '<option value="' . $alim->id . '">' . $alim->descr . ($alim->estrato===NULL||$alim->estrato===""||$alim->estrato==="-"?"":" - ".$alim->estrato) . '</option>';
        }
        return $cboAlimentos;
    }
}
