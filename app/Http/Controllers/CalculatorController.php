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
        $alimento = Alimento::select("alimento.energia_kcal", "alimento.energia_kJ", "alimento.agua", "alimento.proteina", "alimento.grasa", "alimento.carbohidrato_total", "alimento.carbohidrato_disponible", "alimento.fibra_dietaria", "alimento.ceniza", "alimento.calcio", "alimento.fosforo", "alimento.zinc", "alimento.hierro", "alimento.bcaroteno", "alimento.vitaminaA", "alimento.tiamina", "alimento.riboflavina", "alimento.niacina", "alimento.vitaminaC", "alimento.acido_folico", "alimento.sodio", "alimento.potasio", "alimento.id", DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion) AS descr"), 'alimento.estrato')
            ->join('grupo', 'alimento.grupo_id', 'grupo.id')
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
                'descripcion' => $alimento->descr . ($alimento->estrato===NULL||$alimento->estrato===""||$alimento->estrato==="-"?"":" - ".$alimento->estrato),
                'energia_kcal' => ($alimento->energia_kcal===NULL?"-":$alimento->energia_kcal),
                'energia_kJ' => ($alimento->energia_kJ===NULL?"-":$alimento->energia_kJ),
                'agua' => ($alimento->agua===NULL?"-":$alimento->agua),
                'proteina' => ($alimento->proteina===NULL?"-":$alimento->proteina),
                'grasa' => ($alimento->grasa===NULL?"-":$alimento->grasa),
                'carbohidrato_total' => ($alimento->carbohidrato_total===NULL?"-":$alimento->carbohidrato_total),
                'carbohidrato_disponible' => ($alimento->carbohidrato_disponible===NULL?"-":$alimento->carbohidrato_disponible),
                'fibra_dietaria' => ($alimento->fibra_dietaria===NULL?"-":$alimento->fibra_dietaria),
                'ceniza' => ($alimento->ceniza===NULL?"-":$alimento->ceniza),
                'calcio' => ($alimento->calcio===NULL?"-":$alimento->calcio),
                'fosforo' => ($alimento->fosforo===NULL?"-":$alimento->fosforo),
                'zinc' => ($alimento->zinc===NULL?"-":$alimento->zinc),
                'hierro' => ($alimento->hierro===NULL?"-":$alimento->hierro),
                'bcaroteno' => ($alimento->bcaroteno===NULL?"-":$alimento->bcaroteno),
                'vitaminaA' => ($alimento->vitaminaA===NULL?"-":$alimento->vitaminaA),
                'tiamina' => ($alimento->tiamina===NULL?"-":$alimento->tiamina),
                'riboflavina' => ($alimento->riboflavina===NULL?"-":$alimento->riboflavina),
                'niacina' => ($alimento->niacina===NULL?"-":$alimento->niacina),
                'vitaminaC' => ($alimento->vitaminaC===NULL?"-":$alimento->vitaminaC),
                'acido_folico' => ($alimento->acido_folico===NULL?"-":$alimento->acido_folico),
                'sodio' => ($alimento->sodio===NULL?"-":$alimento->sodio),
                'potasio' => ($alimento->potasio===NULL?"-":$alimento->potasio),
            );
        }
            
        return json_encode($data);
    }
}
