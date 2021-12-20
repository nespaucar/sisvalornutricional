<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Bitacora;
use App\Models\Alimento;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalculatorController extends Controller
{
    protected $folderview      = 'app.calculator';
    protected $tituloAdmin     = 'Calculadora Nutricional';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $entidad      = 'Calculator';
        $title        = $this->tituloAdmin;        

        $cards = array();

        $cards[] = array('abrev' => 'energia_kcal', 'name' => 'Energía', 'unity' => 'kcal', 'id' => '<ENERC>', 'color' => '#00A59A');
        $cards[] = array('abrev' => 'energia_kJ', 'name' => 'Energía', 'unity' => 'kJ', 'id' => '<ENERC>', 'color' => '#5C5999');
        $cards[] = array('abrev' => 'agua', 'name' => 'Agua', 'unity' => 'g', 'id' => '<WATER>', 'color' => '#313911');
        $cards[] = array('abrev' => 'proteina', 'name' => 'Proteínas', 'unity' => 'g', 'id' => '<PROCNT>', 'color' => '#295083');
        $cards[] = array('abrev' => 'grasa', 'name' => 'Grasa total', 'unity' => 'g', 'id' => '<FAT>', 'color' => '#C3796B');
        $cards[] = array('abrev' => 'carbohidrato_total', 'name' => 'Carbohidratos totales', 'unity' => 'g', 'id' => '<CHOCDF>', 'color' => '#452115');
        $cards[] = array('abrev' => 'carbohidrato_disponible', 'name' => 'Carbohidratos disponibles', 'unity' => 'g', 'id' => '<CHOAVL>', 'color' => '#609477');
        $cards[] = array('abrev' => 'fibra_dietaria', 'name' => 'Fibra dietaria', 'unity' => 'g', 'id' => '<FIBTG>', 'color' => '#1B9714');
        $cards[] = array('abrev' => 'ceniza', 'name' => 'Cenizas', 'unity' => 'g', 'id' => '<ASH>', 'color' => '#D2A100');
        $cards[] = array('abrev' => 'calcio', 'name' => 'Calcio', 'unity' => 'mg', 'id' => '<CA>', 'color' => '#741DD7');
        $cards[] = array('abrev' => 'fosforo', 'name' => 'Fósforo', 'unity' => 'mg', 'id' => '<P>', 'color' => '#E312EA');
        $cards[] = array('abrev' => 'zinc', 'name' => 'Zinc', 'unity' => 'mg', 'id' => '<ZN>', 'color' => '#5EEA12');
        $cards[] = array('abrev' => 'hierro', 'name' => 'Hierro', 'unity' => 'mg', 'id' => '<FE>', 'color' => '#1912EA');
        $cards[] = array('abrev' => 'bcaroteno', 'name' => 'Β caroteno equivalentes totales', 'unity' => 'µg', 'id' => '<CARTBQ>', 'color' => '#EA1212');
        $cards[] = array('abrev' => 'vitaminaA', 'name' => 'Vitamina A equivalentes totales', 'unity' => 'µg', 'id' => '<VITA>', 'color' => '#EA5712');
        $cards[] = array('abrev' => 'tiamina', 'name' => 'Tiamina', 'unity' => 'mg', 'id' => '<THIA>', 'color' => '#EAB812');
        $cards[] = array('abrev' => 'riboflavina', 'name' => 'Riboflavina', 'unity' => 'mg', 'id' => '<RIBF>', 'color' => '#12EACA');
        $cards[] = array('abrev' => 'niacina', 'name' => 'Niacina', 'unity' => 'mg', 'id' => '<NIA>', 'color' => '#350E22');
        $cards[] = array('abrev' => 'vitaminaC', 'name' => 'Vitamina C', 'unity' => 'mg', 'id' => '<VITC>', 'color' => '#000000');
        $cards[] = array('abrev' => 'acido_folico', 'name' => 'Ácido fólico', 'unity' => 'µg', 'id' => '', 'color' => '#8B990C');
        $cards[] = array('abrev' => 'sodio', 'name' => 'Sodio', 'unity' => 'mg', 'id' => '<NA>', 'color' => '#A52A2A');
        $cards[] = array('abrev' => 'potasio', 'name' => 'Potasio', 'unity' => 'mg', 'id' => '<K>', 'color' => '#008000');

        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'cards'));
    }

    public function show($id)
    {
        //
    }

    public function addAlimento(Request $request) {
        $id = $request->input('id');
        $cantidad = $request->input('cantidad');
        $alimento = Alimento::select("alimento.energia_kcal", "alimento.energia_kJ", "alimento.agua", "alimento.proteina", "alimento.grasa", "alimento.carbohidrato_total", "alimento.carbohidrato_disponible", "alimento.fibra_dietaria", "alimento.ceniza", "alimento.calcio", "alimento.fosforo", "alimento.zinc", "alimento.hierro", "alimento.bcaroteno", "alimento.vitaminaA", "alimento.tiamina", "alimento.riboflavina", "alimento.niacina", "alimento.vitaminaC", "alimento.acido_folico", "alimento.sodio", "alimento.potasio", "alimento.id", DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion) AS descr"), 'alimento.estrato')
        ->join('grupo', 'grupo.id', '=', 'alimento.grupo_id')
        ->where('alimento.estado', '=', 1)
        ->where('alimento.id', '=', $id)
        ->first();
        $existe = 'S';
        if($alimento === NULL) {
            $existe = 'N';
            $data = array(
                'existe' => $existe . $id
            );
        } else {
            $data = array(
                'existe' => $existe,
                'id' => $alimento->id,
                'cantidad' => number_format($cantidad, 2, '.', ''),
                'descripcion' => $alimento->descr . ($alimento->estrato===NULL||$alimento->estrato===""||$alimento->estrato==="-"?"":" - ".$alimento->estrato),
                'energia_kcal' => ($alimento->energia_kcal===NULL?"-":number_format($alimento->energia_kcal*$cantidad, 2, '.', '')),
                'energia_kJ' => ($alimento->energia_kJ===NULL?"-":number_format($alimento->energia_kJ*$cantidad, 2, '.', '')),
                'agua' => ($alimento->agua===NULL?"-":number_format($alimento->agua*$cantidad, 2, '.', '')),
                'proteina' => ($alimento->proteina===NULL?"-":number_format($alimento->proteina*$cantidad, 2, '.', '')),
                'grasa' => ($alimento->grasa===NULL?"-":number_format($alimento->grasa*$cantidad, 2, '.', '')),
                'carbohidrato_total' => ($alimento->carbohidrato_total===NULL?"-":number_format($alimento->carbohidrato_total*$cantidad, 2, '.', '')),
                'carbohidrato_disponible' => ($alimento->carbohidrato_disponible===NULL?"-":number_format($alimento->carbohidrato_disponible*$cantidad, 2, '.', '')),
                'fibra_dietaria' => ($alimento->fibra_dietaria===NULL?"-":number_format($alimento->fibra_dietaria*$cantidad, 2, '.', '')),
                'ceniza' => ($alimento->ceniza===NULL?"-":number_format($alimento->ceniza*$cantidad, 2, '.', '')),
                'calcio' => ($alimento->calcio===NULL?"-":number_format($alimento->calcio*$cantidad, 2, '.', '')),
                'fosforo' => ($alimento->fosforo===NULL?"-":number_format($alimento->fosforo*$cantidad, 2, '.', '')),
                'zinc' => ($alimento->zinc===NULL?"-":number_format($alimento->zinc*$cantidad, 2, '.', '')),
                'hierro' => ($alimento->hierro===NULL?"-":number_format($alimento->hierro*$cantidad, 2, '.', '')),
                'bcaroteno' => ($alimento->bcaroteno===NULL?"-":number_format($alimento->bcaroteno*$cantidad, 2, '.', '')),
                'vitaminaA' => ($alimento->vitaminaA===NULL?"-":number_format($alimento->vitaminaA*$cantidad, 2, '.', '')),
                'tiamina' => ($alimento->tiamina===NULL?"-":number_format($alimento->tiamina*$cantidad, 2, '.', '')),
                'riboflavina' => ($alimento->riboflavina===NULL?"-":number_format($alimento->riboflavina*$cantidad, 2, '.', '')),
                'niacina' => ($alimento->niacina===NULL?"-":number_format($alimento->niacina*$cantidad, 2, '.', '')),
                'vitaminaC' => ($alimento->vitaminaC===NULL?"-":number_format($alimento->vitaminaC*$cantidad, 2, '.', '')),
                'acido_folico' => ($alimento->acido_folico===NULL?"-":number_format($alimento->acido_folico*$cantidad, 2, '.', '')),
                'sodio' => ($alimento->sodio===NULL?"-":number_format($alimento->sodio*$cantidad, 2, '.', '')),
                'potasio' => ($alimento->potasio===NULL?"-":number_format($alimento->potasio*$cantidad, 2, '.', '')),
            );
        }
            
        return json_encode($data);
    }

    public function cambiarValoresSesion(Request $request) {
        $cadenaAlimentos = $request->input('cadenaAlimentos');
        $cadenaCantidades = $request->input('cadenaCantidades');
        $request->session()->put('cadenaAlimentos', $cadenaAlimentos);
        $request->session()->put('cadenaCantidades', $cadenaCantidades);
        return $request->session()->get('cadenaAlimentos')."---".$request->session()->get('cadenaCantidades');
    }

    public function precargarTablaAlimentos(Request $request) {
        $cadenaAlimentos = $request->session()->get('cadenaAlimentos');
        $cadenaCantidades = $request->session()->get('cadenaCantidades');
        $tabla = '<tr id="emptyRow" data-id="" data-cantidad="">
            <td class="text-primary text-center" colspan="25">Seleccione al menos un alimento.</td>
        </tr>';
        if($cadenaAlimentos!==NULL&&$cadenaAlimentos!=='') {
            $tabla = '';
            $alimentos = explode(";", $cadenaAlimentos);
            $cantidades = explode(";", $cadenaCantidades);
            for ($i = 0; $i < count($alimentos); $i++) {
                $alimento = Alimento::select("alimento.energia_kcal", "alimento.energia_kJ", "alimento.agua", "alimento.proteina", "alimento.grasa", "alimento.carbohidrato_total", "alimento.carbohidrato_disponible", "alimento.fibra_dietaria", "alimento.ceniza", "alimento.calcio", "alimento.fosforo", "alimento.zinc", "alimento.hierro", "alimento.bcaroteno", "alimento.vitaminaA", "alimento.tiamina", "alimento.riboflavina", "alimento.niacina", "alimento.vitaminaC", "alimento.acido_folico", "alimento.sodio", "alimento.potasio", "alimento.id", DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion) AS descr"), 'alimento.estrato')
                ->join('grupo', 'grupo.id', '=', 'alimento.grupo_id')
                ->where('alimento.id', '=', $alimentos[$i])
                ->first();
                if($alimento !== NULL) {
                    $cantidad = $cantidades[$i];
                    $tabla .= '<tr data-cantidad="' . $cantidad . '" data-id="' . $alimentos[$i] . '" id="' . $alimentos[$i] . '" align="center">
                        <td class="text-left num">' . ($i + 1) . '</td>
                        <td class="text-left descripcion">' . 
                            ($alimento->descr . ($alimento->estrato===NULL||$alimento->estrato===""||$alimento->estrato==="-"?"":" - ".$alimento->estrato)) . 
                        '</td>
                        <td class="text-left cantidad">' . $cantidad . '</td>
                        <td class="text-left energia_kcal">' . 
                            ($alimento->energia_kcal===NULL?"-":number_format($alimento->energia_kcal*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left energia_kJ">' . 
                            ($alimento->energia_kJ===NULL?"-":number_format($alimento->energia_kJ*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left agua">' . 
                            ($alimento->agua===NULL?"-":number_format($alimento->agua*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left proteina">' . 
                            ($alimento->proteina===NULL?"-":number_format($alimento->proteina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left grasa">' . 
                            ($alimento->grasa===NULL?"-":number_format($alimento->grasa*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left carbohidrato_total">' . 
                            ($alimento->carbohidrato_total===NULL?"-":number_format($alimento->carbohidrato_total*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left carbohidrato_disponible">' . 
                            ($alimento->carbohidrato_disponible===NULL?"-":number_format($alimento->carbohidrato_disponible*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left fibra_dietaria">' . 
                            ($alimento->fibra_dietaria===NULL?"-":number_format($alimento->fibra_dietaria*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left ceniza">' . 
                            ($alimento->ceniza===NULL?"-":number_format($alimento->ceniza*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left calcio">' . 
                            ($alimento->calcio===NULL?"-":number_format($alimento->calcio*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left fosforo">' . 
                            ($alimento->fosforo===NULL?"-":number_format($alimento->fosforo*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left zinc">' . 
                            ($alimento->zinc===NULL?"-":number_format($alimento->zinc*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left hierro">' . 
                            ($alimento->hierro===NULL?"-":number_format($alimento->hierro*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left bcaroteno">' . 
                            ($alimento->bcaroteno===NULL?"-":number_format($alimento->bcaroteno*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left vitaminaA">' . 
                            ($alimento->vitaminaA===NULL?"-":number_format($alimento->vitaminaA*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left tiamina">' . 
                            ($alimento->tiamina===NULL?"-":number_format($alimento->tiamina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left riboflavina">' . 
                            ($alimento->riboflavina===NULL?"-":number_format($alimento->riboflavina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left niacina">' . 
                            ($alimento->niacina===NULL?"-":number_format($alimento->niacina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left vitaminaC">' . 
                            ($alimento->vitaminaC===NULL?"-":number_format($alimento->vitaminaC*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left acido_folico">' . 
                            ($alimento->acido_folico===NULL?"-":number_format($alimento->acido_folico*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left sodio">' . 
                            ($alimento->energia_kcal===NULL?"-":number_format($alimento->energia_kcal*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-left potasio">' . 
                            ($alimento->potasio===NULL?"-":number_format($alimento->potasio*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td class="text-center">
                            <a onclick="eliminarAlimento(this, ' . $alimentos[$i] . ');" class="btn btn-xs btn-danger" type="button">
                                <div class="glyphicon glyphicon-remove"></div>
                            </a>
                        </td>
                    </tr>';
                }                    
            }
        }
        $data = array(
            'cadenaAlimentos' => ($cadenaAlimentos===NULL?'':$cadenaAlimentos),
            'cadenaCantidades' => ($cadenaCantidades===NULL?'':$cadenaCantidades),
            'tabla' => $tabla,
        );
        return json_encode($data);
    }
}
