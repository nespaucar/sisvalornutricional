<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Bitacora;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BitacoraController extends Controller
{
    protected $folderview      = 'app.bitacora';
    protected $tituloAdmin     = 'Bitácora';
    protected $rutas           = array(
            'search' => 'bitacora.buscar',
            'index'  => 'bitacora.index',
        );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina                = $request->input('page');
        $filas                 = $request->input('filas');
        $entidad               = 'Bitacora';
        $name                  = Libreria::getParam($request->input('name'));
        $fecha                 = Libreria::getParam($request->input('fecha'));
        $resultado             = Bitacora::listar($name);
        if($this->validar_fecha($fecha) && !is_null($fecha)) {
            $resultado         = $resultado->where('fecha', '=', date('Y-m-d', strtotime($fecha)));
        }
        $user                  = Auth::user();
        if($user->usertype_id > 1) {
            $resultado         = $resultado->where('usuario_id', '=', $user->id);
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
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'ruta', 'user'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'Bitacora';
        $title            = $this->tituloAdmin;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'ruta'));
    }

    public function show($id)
    {
        //
    }

    public function validar_fecha($fecha){
        $valores = explode('-', $fecha);
        if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
            return true;
        }
        return false;
    }
}
