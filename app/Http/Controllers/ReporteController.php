<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Bitacora;
use App\Models\Detalleconceptopago;
use App\Models\Detallepago;
use App\Models\Persona;
use App\Models\Mercader;
use App\Models\Conceptopago;
use App\Http\Requests;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
	protected $folderview      = 'reporte.';
	protected $rutas           = array(
        'listarbitacorareporte'  => 'reporte.listarbitacorareporte',
        'listarmercaderreporte'  => 'reporte.listarmercaderreporte',
        'listaringresoreporte'  => 'reporte.listaringresoreporte',
        'listarestadocuentareporte'  => 'reporte.listarestadocuentareporte',
    );

    public function __construct() {
        $this->middleware('auth');
    }

    public function show($id) {
        //
    }

    //BITACORA
    public function bitacorareporte(Request $request) {
    	$title   = 'Reporte de Bitácora';
        $entidad = 'bitacorareporte';
        $listar  = Libreria::getParam($request->input('listar'), 'NO');
        $ruta    = $this->rutas;
        $cboPersonas = array('' => '-- Todos --');
        $personas = Persona::select('usuario.id', 'persona.nombre', 'persona.dni')->join('usuario', 'usuario.persona_id', 'persona.id')->get();

       	foreach ($personas as $per) {
       		$cboPersonas += array($per->id => $per->dni . ' - ' . $per->nombre);
       	}

        return view($this->folderview.'.bitacora.admin')->with(compact('title', 'entidad', 'listar', 'ruta', 'cboPersonas'));
    }

    public function listarbitacorareporte(Request $request) {
    	$pagina                = Libreria::getParam($request->input('page'));
        $filas                 = Libreria::getParam($request->input('filas'));
        $entidad               = 'bitacorareporte';
        $name                  = Libreria::getParam($request->input('name'));
        $fecha                 = Libreria::getParam($request->input('fecha'));
        $usuario_id            = Libreria::getParam($request->input('usuario_id'));
        $resultado             = Bitacora::listar($name);
        if($this->validar_fecha($fecha) && !is_null($fecha)) {
            $resultado         = $resultado->where('fecha', '=', date('Y-m-d', strtotime($fecha)));
        }	        
        $user                  = Auth::user();
        if($user->usertype_id > 1) {
            $resultado         = $resultado->where('usuario_id', '=', $user->id);
        } else {
        	if($usuario_id!==NULL) {
	        	$resultado     = $resultado->where('usuario_id', '=', $usuario_id);
	        }
        }
        $lista                 = $resultado->get();
        $cabecera              = array();
        $cabecera[]            = array('valor' => '#', 'numero' => '1');
        $cabecera[]            = array('valor' => 'Fecha', 'numero' => '1');
        $cabecera[]            = array('valor' => 'Descripción', 'numero' => '1');
        if($user->usertype_id === 1) {
            $cabecera[]            = array('valor' => 'Tabla', 'numero' => '1');
            $cabecera[]            = array('valor' => 'ID Referencia', 'numero' => '1');
        }
        $cabecera[]            = array('valor' => 'Usuario', 'numero' => '1');

        $ruta                  = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.bitacora.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'ruta', 'user'));
        }
        return view($this->folderview.'.bitacora.list')->with(compact('lista', 'entidad'));
    }

    //MERCADERES
    public function mercaderreporte(Request $request) {
        $title   = 'Reporte de Mercaderes';
        $entidad = 'mercaderreporte';
        $listar  = Libreria::getParam($request->input('listar'), 'NO');
        $ruta    = $this->rutas;
        $cboMercaderes = array('' => '-- Todos --');
        $cboConceptos = array('' => '-- Todos --');
        $mercaderes = Persona::select('mercader.id', 'nombre', 'dni')
            ->join('mercader', 'mercader.persona_id', 'persona.id')
            ->where('tipo', '=', 'V') //Mercaderes
            ->get();
        $conceptos = Conceptopago::select('id', 'nombre')->get();

        foreach ($mercaderes as $per) {
            $cboMercaderes += array($per->id => $per->dni . ' - ' . $per->nombre);
        }

        foreach ($conceptos as $con) {
            $cboConceptos += array($con->id => $con->nombre);
        }

        return view($this->folderview.'.mercader.admin')->with(compact('title', 'entidad', 'listar', 'ruta', 'cboMercaderes', 'cboConceptos'));
    }

    public function listarmercaderreporte(Request $request) {
        $pagina          = Libreria::getParam($request->input('page'));
        $filas           = Libreria::getParam($request->input('filas'));
        $entidad         = 'mercaderreporte';
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

        $ruta            = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.mercader.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'ruta'));
        }
        return view($this->folderview.'.mercader.list')->with(compact('lista', 'entidad'));
    }

    //INGRESOS
    public function ingresoreporte(Request $request) {
        $title   = 'Reporte de Ingresos';
        $entidad = 'ingresoreporte';
        $listar  = Libreria::getParam($request->input('listar'), 'NO');
        $ruta    = $this->rutas;
        $cboMercaderes = array('' => '-- Todos --');
        $cboComisionistas = array('' => '-- Todos --');
        $cboConceptos = array('' => '-- Todos --');
        $mercaderes = Persona::select('mercader.id', 'nombre', 'dni')
            ->join('mercader', 'mercader.persona_id', 'persona.id')
            ->where('tipo', '=', 'V') //Mercaderes
            ->get();

        $comisionistas = Persona::select('comisionista.id', 'nombre', 'dni')
            ->join('comisionista', 'comisionista.persona_id', 'persona.id')
            ->where('tipo', '=', 'C') //Cobradores
            ->get();

        $conceptos = Conceptopago::select('id', 'nombre')->get();

        foreach ($mercaderes as $per) {
            $cboMercaderes += array($per->id => $per->dni . ' - ' . $per->nombre);
        }

        foreach ($comisionistas as $per) {
            $cboComisionistas += array($per->id => $per->dni . ' - ' . $per->nombre);
        }

        foreach ($conceptos as $con) {
            $cboConceptos += array($con->id => $con->nombre);
        }

        return view($this->folderview.'.ingreso.admin')->with(compact('title', 'entidad', 'listar', 'ruta', 'cboMercaderes', 'cboComisionistas', 'cboConceptos'));
    }

    public function listaringresoreporte(Request $request) {
        $pagina          = Libreria::getParam($request->input('page'));
        $filas           = Libreria::getParam($request->input('filas'));
        $entidad         = 'ingresoreporte';
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

        $ruta            = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.ingreso.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'ruta'));
        }
        return view($this->folderview.'.ingreso.list')->with(compact('lista', 'entidad'));
    }

    //ESTADO CUENTA
    public function estadocuentareporte(Request $request) {
        $title   = 'Estado de Cuenta';
        $entidad = 'estadocuentareporte';
        $listar  = Libreria::getParam($request->input('listar'), 'NO');
        $ruta    = $this->rutas;
        $cboMercaderes = array('' => '-- Selecciona --');
        $cboConceptos = array('' => '-- Selecciona --');
        $mercaderes = Persona::select('mercader.id', 'nombre', 'dni')
            ->join('mercader', 'mercader.persona_id', 'persona.id')
            ->where('tipo', '=', 'V') //Mercaderes
            ->get();

        foreach ($mercaderes as $per) {
            $cboMercaderes += array($per->id => $per->dni . ' - ' . $per->nombre);
        }

        return view($this->folderview.'.estadocuenta.admin')->with(compact('title', 'entidad', 'listar', 'ruta', 'cboMercaderes', 'cboConceptos'));
    }

    public function listarestadocuentareporte(Request $request) {
        $entidad         = 'estadocuentareporte';
        $mercader_id     = Libreria::getParam($request->input('mercader_id'));
        $anno            = Libreria::getParam($request->input('anno'));
        $conceptopago_id = Libreria::getParam($request->input('conceptopago_id'));

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
        $cabecera[]      = array('valor' => 'Acciones', 'numero' => '1');

        $ruta                  = $this->rutas;

        return view($this->folderview.'.estadocuenta.list')->with(compact('entidad', 'anno', 'detconceptopago', 'mercader', 'ruta', 'cabecera'));
    }

    public function validar_fecha($fecha){
        $valores = explode('-', $fecha);
        if(count($valores) === 3 && checkdate($valores[1], $valores[2], $valores[0])){
            return true;
        }
        return false;
    }
}
