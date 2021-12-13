<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Maatwebsite\Excel\Excel;
use App\Models\Bitacora;
use App\Models\Mercader;
use App\Models\Detalleconceptopago;
use App\Models\Detallepago;
use App\Exports\BitacoraExport;
use App\Exports\MercaderExport;
use App\Exports\IngresoExport;
use App\Exports\EstadoCuentaExport;
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

    //Documentation
    public function exportarExcelAlgo(Request $request) {
        $variable1 = '';
        $variable2 = '';
		/*Excel::queue('Nombre Excel', function($excel) use($variable1, $variable2) {
            $excel->sheet("Nombre Pestaña de Excel", function ($sheet) use ($variable1, $variable2) {
                $sheet->loadView('alguna.vista')->with(compact('variable1', 'variable2'));
            });
        })->export('xls');*/
    }

    public function show(Request $request) {
        //
    }

    public function exportarbitacorareporteE(Request $request) {
        $name                  = Libreria::getParam($request->input('name'));
        $fecha                 = Libreria::getParam($request->input('fecha'));
        $usuario_id            = Libreria::getParam($request->input('usuario_id'));
        $resultado             = Bitacora::listar($name);
        if($this->validar_fecha($fecha) && !is_null($fecha)) {
            $resultado         = $resultado->where('fecha', '=', date('Y-m-d', strtotime($fecha)));
        }
        if($usuario_id!==NULL&&$usuario_id!=='') {
            $resultado     = $resultado->where('usuario_id', '=', $usuario_id);
        }
        $lista                 = $resultado->get();

        $cabecera              = array();
        $cabecera[]            = array('valor' => '#', 'numero' => '1');
        $cabecera[]            = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]            = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]            = array('valor' => 'Tabla', 'numero' => '1');
        $cabecera[]            = array('valor' => 'ID Referencia', 'numero' => '1');
        $cabecera[]            = array('valor' => 'Usuario', 'numero' => '1');

        //return $this->excel->download(new BitacoraExport($name, $fecha, $lista, $cabecera), 'bitacora.pdf', Excel::TCPDF);
        return $this->excel->download(new BitacoraExport($name, $fecha, $lista, $cabecera), 'bitacora.xlsx');
    }

    public function exportarmercaderreporteE(Request $request) {
        $mercader_id     = Libreria::getParam($request->input('mercader_id'));
        $tipo            = Libreria::getParam($request->input('tipo'));
        $conceptopago_id = Libreria::getParam($request->input('conceptopago_id'));
        $tipocobro       = Libreria::getParam($request->input('cobro'));
        $resultado       = Detalleconceptopago::listarmercaderes($mercader_id, $tipo, $conceptopago_id, $tipocobro);
        $lista           = $resultado->get();

        $cabecera        = array();
        $cabecera[]      = array('valor' => '#', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Mercader', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Estado', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Dirección', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Teléfono', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Concepto Pago', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Monto (S/)', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Cobros', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Tipo', 'numero' => '1');

        return $this->excel->download(new MercaderExport($lista, $cabecera), 'mercaderes.xlsx');
    }

    public function exportaringresoreporteE(Request $request) {
        $ingresosTotal   = Libreria::getParam($request->input('ingresosTotal'));
        $mercader_id     = Libreria::getParam($request->input('mercader_id'));
        $comisionista_id = Libreria::getParam($request->input('comisionista_id'));
        $tipo            = Libreria::getParam($request->input('tipo'));
        $conceptopago_id = Libreria::getParam($request->input('conceptopago_id'));
        $mes             = Libreria::getParam($request->input('mes'));
        $anno            = Libreria::getParam($request->input('anno'));
        $fechai          = NULL;
        $fechaf          = NULL;
        $fecha           = NULL;
        $mes             = NULL;
        $anno            = NULL;
        switch ($tipo) {
            case 'D':
                $ft      = Libreria::getParam($request->input('fechai'));
                $fecha   = (($this->validar_fecha(date('Y-m-d', strtotime($ft)))&&!is_null($ft))?date('Y-m-d', strtotime($ft)):NULL);
                break;
            case 'M':
                $mes     = Libreria::getParam($request->input('mes'));
                $anno    = Libreria::getParam($request->input('anno'));
                break;
            case 'R':
                $fi      = Libreria::getParam($request->input('fechai'));
                $ff      = Libreria::getParam($request->input('fechaf'));
                $fechai  = (($this->validar_fecha(date('Y-m-d', strtotime($fi)))&&!is_null($fi))?date('Y-m-d', strtotime($fi)):NULL);
                $fechaf  = (($this->validar_fecha(date('Y-m-d', strtotime($ff)))&&!is_null($ff))?date('Y-m-d', strtotime($ff)):NULL);
                break;
        }
        $resultado       = Detallepago::listar($fecha, $fechai, $fechaf, $mes, $anno, $comisionista_id, $mercader_id, NULL, NULL, $conceptopago_id);
        $lista           = $resultado->get();

        $cabecera        = array();
        $cabecera[]      = array('valor' => '#', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]      = array('valor' => 'N° Recibo', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Monto (S/)', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Concepto Pago', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Tipo Cobro', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Periodo', 'numero' => '1');        
        $cabecera[]      = array('valor' => 'Estado Pago', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Mercader', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Comisionista', 'numero' => '1');

        return $this->excel->download(new IngresoExport($fecha, $fechai, $fechaf, $mes, $anno, $ingresosTotal, $lista, $cabecera), 'mercaderes.xlsx');
    }

    public function exportarestadocuentareporteE(Request $request) {
        $mercader_id     = Libreria::getParam($request->input('mercader_id'));
        $anno            = Libreria::getParam($request->input('anno'));
        $conceptopago_id = Libreria::getParam($request->input('conceptopago_id'));
        $totPagar = Libreria::getParam($request->input('totPagar'));
        $totPagado = Libreria::getParam($request->input('totPagado'));
        $totDeuda = Libreria::getParam($request->input('totDeuda'));

        $mercader        = Mercader::find($mercader_id);
        $detconceptopago = Detalleconceptopago::find($conceptopago_id);

        $cabecera        = array();
        $cabecera[]      = array('valor' => '#', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Concepto de Pago', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Tipo Cobro', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Pagado (S/)', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Deuda (S/)', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Estado', 'numero' => '1');

        return $this->excel->download(new EstadoCuentaExport($totPagar, $totPagado, $totDeuda, $anno, $detconceptopago, $mercader, $cabecera), 'estadocuenta.xlsx');
    }

    public function validar_fecha($fecha){
        $valores = explode('-', $fecha);
        if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
            return true;
        }
        return false;
    }
}
