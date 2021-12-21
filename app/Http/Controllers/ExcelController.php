<?php

# Aquí mismo podemos usar PDF y Excel

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use PDF;
use Maatwebsite\Excel\Excel;
use App\Models\Alimento;
# use App\Exports\EjemploExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Librerias\Libreria;

class ExcelController extends Controller
{
	public function __construct(Excel $excel)
    {
        $this->middleware('auth');
        $this->excel = $excel;
    }

    // Documentacion Para Jalar una vista y exportar a Excel
    public function exportarExcelAlgo(Request $request) {
        $variable1 = '';
        $variable2 = '';
		/*Excel::queue('Nombre Excel', function($excel) use($variable1, $variable2) {
            $excel->sheet("Nombre Pestaña de Excel", function ($sheet) use ($variable1, $variable2) {
                $sheet->loadView('alguna.vista')->with(compact('variable1', 'variable2'));
            });
        })->export('xls');*/
    }

    // Documntacion Para Exportar un PDF desde alguna vista
    public function exportarPdfAlgo(Request $request)
    {
        $variable1 = '';
        $variable2 = '';
        $view = \View::make('alguna.vista')->with(compact('variable1', 'variable2'));
        $html_content = $view->render();      
 
        PDF::SetTitle("Nombre PDF");
        PDF::AddPage(); 

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        PDF::writeHTML($html_content, true, true, true, true, '');

        PDF::Output("Nombre PDF".'.pdf', 'I');
    }

    // Documentacion Usando Exports Tanto para PDF y Excel
    public function exportarReporteE(Request $request) {
        $variable1 = '';
        $variable2 = '';
        $cabecera   = array();
        $cabecera[] = array('valor' => '#', 'numero' => '1');
        $cabecera[] = array('valor' => 'Dato', 'numero' => '1');

        # PDF
        # return $this->excel->download(new EjemploExport($variable1, $variable2, $cabecera), 'reporte.pdf', Excel::TCPDF);

        # Excel
        return $this->excel->download(new EjemploExport($variable1, $variable2, $cabecera), 'reporte.xlsx');
    }

    public function show(Request $request) {
        //
    }

    ## METODOS REALES ##

    public function exportarInformacionNutricionalPDF(Request $request)
    {
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
        $cards[] = array('abrev' => 'bcaroteno', 'name' => 'B caroteno equivalentes totales', 'unity' => 'µg', 'id' => '<CARTBQ>', 'color' => '#EA1212');
        $cards[] = array('abrev' => 'vitaminaA', 'name' => 'Vitamina A equivalentes totales', 'unity' => 'µg', 'id' => '<VITA>', 'color' => '#EA5712');
        $cards[] = array('abrev' => 'tiamina', 'name' => 'Tiamina', 'unity' => 'mg', 'id' => '<THIA>', 'color' => '#EAB812');
        $cards[] = array('abrev' => 'riboflavina', 'name' => 'Riboflavina', 'unity' => 'mg', 'id' => '<RIBF>', 'color' => '#12EACA');
        $cards[] = array('abrev' => 'niacina', 'name' => 'Niacina', 'unity' => 'mg', 'id' => '<NIA>', 'color' => '#350E22');
        $cards[] = array('abrev' => 'vitaminaC', 'name' => 'Vitamina C', 'unity' => 'mg', 'id' => '<VITC>', 'color' => '#000000');
        $cards[] = array('abrev' => 'acido_folico', 'name' => 'Ácido fólico', 'unity' => 'µg', 'id' => '', 'color' => '#8B990C');
        $cards[] = array('abrev' => 'sodio', 'name' => 'Sodio', 'unity' => 'mg', 'id' => '<NA>', 'color' => '#A52A2A');
        $cards[] = array('abrev' => 'potasio', 'name' => 'Potasio', 'unity' => 'mg', 'id' => '<K>', 'color' => '#008000');

        # Armamos la tabla de nutrición
        $cadenaAlimentos = $request->session()->get('cadenaAlimentos');
        $cadenaCantidades = $request->session()->get('cadenaCantidades');

        $sumas = array();

        $tabla = '<tr>
            <td align="center" colspan="25" style="font-size:13px;">Seleccione al menos un alimento.</td>
        </tr>';

        if($cadenaAlimentos!==NULL&&$cadenaAlimentos!=='') {
            $tabla = '';
            $alimentos = explode(";", $cadenaAlimentos);
            $cantidades = explode(";", $cadenaCantidades);
            $energia_kcal = 0.00;
            $energia_kJ = 0.00;
            $agua = 0.00;
            $proteina = 0.00;
            $grasa = 0.00;
            $carbohidrato_total = 0.00;
            $carbohidrato_disponible = 0.00;
            $fibra_dietaria = 0.00;
            $ceniza = 0.00;
            $calcio = 0.00;
            $fosforo = 0.00;
            $zinc = 0.00;
            $hierro = 0.00;
            $bcaroteno = 0.00;
            $vitaminaA = 0.00;
            $tiamina = 0.00;
            $riboflavina = 0.00;
            $niacina = 0.00;
            $vitaminaC = 0.00;
            $acido_folico = 0.00;
            $sodio = 0.00;
            $potasio = 0.00;
            for ($i = 0; $i < count($alimentos); $i++) {
                $idalimento = $alimentos[$i];
                $cantidad = $cantidades[$i];
                $alimento = Alimento::select("alimento.energia_kcal", "alimento.energia_kJ", "alimento.agua", "alimento.proteina", "alimento.grasa", "alimento.carbohidrato_total", "alimento.carbohidrato_disponible", "alimento.fibra_dietaria", "alimento.ceniza", "alimento.calcio", "alimento.fosforo", "alimento.zinc", "alimento.hierro", "alimento.bcaroteno", "alimento.vitaminaA", "alimento.tiamina", "alimento.riboflavina", "alimento.niacina", "alimento.vitaminaC", "alimento.acido_folico", "alimento.sodio", "alimento.potasio", "alimento.id", DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion) AS descr"), 'alimento.estrato')
                ->join('grupo', 'grupo.id', '=', 'alimento.grupo_id')
                ->where('alimento.id', '=', $idalimento)
                ->first();
                if($alimento !== NULL) {
                    $tabla .= '<tr align="center">
                        <td align="center">' . ($i + 1) . '</td>
                        <td align="left">' . 
                            ($alimento->descr . ($alimento->estrato===NULL||$alimento->estrato===""||$alimento->estrato==="-"?"":" - ".$alimento->estrato)) . 
                        '</td>
                        <td align="center">' . $cantidad . '</td>
                        <td align="center">' . 
                            ($alimento->energia_kcal===NULL?"-":number_format($alimento->energia_kcal*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->energia_kJ===NULL?"-":number_format($alimento->energia_kJ*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->agua===NULL?"-":number_format($alimento->agua*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->proteina===NULL?"-":number_format($alimento->proteina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->grasa===NULL?"-":number_format($alimento->grasa*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->carbohidrato_total===NULL?"-":number_format($alimento->carbohidrato_total*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->carbohidrato_disponible===NULL?"-":number_format($alimento->carbohidrato_disponible*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->fibra_dietaria===NULL?"-":number_format($alimento->fibra_dietaria*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->ceniza===NULL?"-":number_format($alimento->ceniza*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->calcio===NULL?"-":number_format($alimento->calcio*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->fosforo===NULL?"-":number_format($alimento->fosforo*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->zinc===NULL?"-":number_format($alimento->zinc*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->hierro===NULL?"-":number_format($alimento->hierro*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->bcaroteno===NULL?"-":number_format($alimento->bcaroteno*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->vitaminaA===NULL?"-":number_format($alimento->vitaminaA*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->tiamina===NULL?"-":number_format($alimento->tiamina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->riboflavina===NULL?"-":number_format($alimento->riboflavina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->niacina===NULL?"-":number_format($alimento->niacina*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->vitaminaC===NULL?"-":number_format($alimento->vitaminaC*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->acido_folico===NULL?"-":number_format($alimento->acido_folico*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->sodio===NULL?"-":number_format($alimento->sodio*$cantidad, 2, '.', '')) . 
                        '</td>
                        <td align="center">' . 
                            ($alimento->potasio===NULL?"-":number_format($alimento->potasio*$cantidad, 2, '.', '')) . 
                        '</td>
                    </tr>';
                    // SUMAMOS
                    $energia_kcal += ($alimento->energia_kcal===NULL?0.00:number_format($alimento->energia_kcal*$cantidad, 2, '.', ''));
                    $energia_kJ += ($alimento->energia_kJ===NULL?0.00:number_format($alimento->energia_kJ*$cantidad, 2, '.', ''));
                    $agua += ($alimento->agua===NULL?0.00:number_format($alimento->agua*$cantidad, 2, '.', ''));
                    $proteina += ($alimento->proteina===NULL?0.00:number_format($alimento->proteina*$cantidad, 2, '.', ''));
                    $grasa += ($alimento->grasa===NULL?0.00:number_format($alimento->grasa*$cantidad, 2, '.', ''));
                    $carbohidrato_total += ($alimento->carbohidrato_total===NULL?0.00:number_format($alimento->carbohidrato_total*$cantidad, 2, '.', ''));
                    $carbohidrato_disponible += ($alimento->carbohidrato_disponible===NULL?0.00:number_format($alimento->carbohidrato_disponible*$cantidad, 2, '.', ''));
                    $fibra_dietaria += ($alimento->fibra_dietaria===NULL?0.00:number_format($alimento->fibra_dietaria*$cantidad, 2, '.', ''));
                    $ceniza += ($alimento->ceniza===NULL?0.00:number_format($alimento->ceniza*$cantidad, 2, '.', ''));
                    $calcio += ($alimento->calcio===NULL?0.00:number_format($alimento->calcio*$cantidad, 2, '.', ''));
                    $fosforo += ($alimento->fosforo===NULL?0.00:number_format($alimento->fosforo*$cantidad, 2, '.', ''));
                    $zinc += ($alimento->zinc===NULL?0.00:number_format($alimento->zinc*$cantidad, 2, '.', ''));
                    $hierro += ($alimento->hierro===NULL?0.00:number_format($alimento->hierro*$cantidad, 2, '.', ''));
                    $bcaroteno += ($alimento->bcaroteno===NULL?0.00:number_format($alimento->bcaroteno*$cantidad, 2, '.', ''));
                    $vitaminaA += ($alimento->vitaminaA===NULL?0.00:number_format($alimento->vitaminaA*$cantidad, 2, '.', ''));
                    $tiamina += ($alimento->tiamina===NULL?0.00:number_format($alimento->tiamina*$cantidad, 2, '.', ''));
                    $riboflavina += ($alimento->riboflavina===NULL?0.00:number_format($alimento->riboflavina*$cantidad, 2, '.', ''));
                    $niacina += ($alimento->niacina===NULL?0.00:number_format($alimento->niacina*$cantidad, 2, '.', ''));
                    $vitaminaC += ($alimento->vitaminaC===NULL?0.00:number_format($alimento->vitaminaC*$cantidad, 2, '.', ''));
                    $acido_folico += ($alimento->acido_folico===NULL?0.00:number_format($alimento->acido_folico*$cantidad, 2, '.', ''));
                    $sodio += ($alimento->sodio===NULL?0.00:number_format($alimento->sodio*$cantidad, 2, '.', ''));
                    $potasio += ($alimento->potasio===NULL?0.00:number_format($alimento->potasio*$cantidad, 2, '.', ''));
                }
                if($i === (count($alimentos) - 1)) {
                    $sumas[] = number_format($energia_kcal, 2, '.', '');
                    $sumas[] = number_format($energia_kJ, 2, '.', '');
                    $sumas[] = number_format($agua, 2, '.', '');
                    $sumas[] = number_format($proteina, 2, '.', '');
                    $sumas[] = number_format($grasa, 2, '.', '');
                    $sumas[] = number_format($carbohidrato_total, 2, '.', '');
                    $sumas[] = number_format($carbohidrato_disponible, 2, '.', '');
                    $sumas[] = number_format($fibra_dietaria, 2, '.', '');
                    $sumas[] = number_format($ceniza, 2, '.', '');
                    $sumas[] = number_format($calcio, 2, '.', '');
                    $sumas[] = number_format($fosforo, 2, '.', '');
                    $sumas[] = number_format($zinc, 2, '.', '');
                    $sumas[] = number_format($hierro, 2, '.', '');
                    $sumas[] = number_format($bcaroteno, 2, '.', '');
                    $sumas[] = number_format($vitaminaA, 2, '.', '');
                    $sumas[] = number_format($tiamina, 2, '.', '');
                    $sumas[] = number_format($riboflavina, 2, '.', '');
                    $sumas[] = number_format($niacina, 2, '.', '');
                    $sumas[] = number_format($vitaminaC, 2, '.', '');
                    $sumas[] = number_format($acido_folico, 2, '.', '');
                    $sumas[] = number_format($sodio, 2, '.', '');
                    $sumas[] = number_format($potasio, 2, '.', '');
                }
            }
        }
 
        PDF::SetTitle("Información Nutricional");
        PDF::AddPage('L');

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        $view = \View::make('pdf.alimentos')->with(compact('tabla'));
        $html_content = $view->render();
        PDF::writeHTML($html_content, true, true, true, true, '');

        $view = \View::make('pdf.infonutricional')->with(compact('cards', 'sumas'));
        $html_content = $view->render();
        PDF::AddPage('P');
        PDF::writeHTML($html_content, true, true, true, true, '');

        PDF::Output("Información Nutricional.pdf", 'I');
    }
}
