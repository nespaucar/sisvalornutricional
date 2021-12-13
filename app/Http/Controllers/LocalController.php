<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Hash;
use File;
use App\Models\Local;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Conceptopago;
use App\Models\Bitacora;
use App\Http\Requests;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LocalController extends Controller
{
    protected $folderview      = 'app.local';
    protected $tituloAdmin     = 'Local';
    protected $tituloRegistrar = 'Registrar Local';
    protected $tituloModificar = 'Modificar Local';
    protected $tituloEliminar  = 'Eliminar Local';
    protected $rutas           = array('create' => 'local.create', 
            'edit'   => 'local.edit', 
            'alterarestado' => 'local.alterarestado',
            'search' => 'local.buscar',
            'index'  => 'local.index',
        );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $user             = Auth::user();
        $id               = $user->persona_id;
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Local';
        $nombre           = Libreria::getParam($request->input('nombre'));
        $resultado        = Local::listar($nombre);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Estado', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Acciones', 'numero' => '2');

        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $ruta             = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'Local';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request)
    {
        $listar              = Libreria::getParam($request->input('listar'), 'NO');
        $entidad             = 'Local';
        $local               = null;
        $formData            = array('local.store');
        $formData            = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton               = 'Registrar'; 
        $infoNiveles         = "";
        return view($this->folderview.'.mant')->with(compact('local', 'formData', 'entidad', 'boton', 'listar', 'infoNiveles'));
    }

    public function store(Request $request)
    {
        $now        = new \DateTime();
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $validacion = Validator::make($request->all(),
            array(
                'descripcion' => 'required|max:120',
            )
        );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request, $now){
            $local                = new Local();
            $local->descripcion   = $request->input('descripcion');
            $local->logo          = "123";
            $local->estado        = "A";
            $local->save();

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se CREA el Local ' . $request->input('descripcion');
            $bitacora->tabla = 'LOCAL';
            $bitacora->tabla_id = $local->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function show(Local $local)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'local');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $local    = Local::find($id);
        $entidad  = 'Local';
        $formData = array('local.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('local', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'local');
        if ($existe !== true) {
            return $existe;
        }
        $validacion = Validator::make($request->all(),
            array(
                'descripcion' => 'required|max:120',
            )
        );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request, $id){
            $local                = Local::find($id);
            $local->descripcion   = $request->input('descripcion');
            $local->save();

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se MODIFICA el Local ' . $request->input('descripcion');
            $bitacora->tabla = 'LOCAL';
            $bitacora->tabla_id = $local->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function confirmaralterarestado(Request $request)
    {
        $existe = Libreria::verificarExistencia($request->id, 'local');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($request){
            $local = Local::find($request->id);
            $local->estado = strtoupper($request->estado);
            $local->save();

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se CAMBIA EL ESTADO de Local ' . $local->descripcion . ' a ' . ($request->estado === 'A'?'ACTIVO':'INACTIVO');
            $bitacora->tabla = 'LOCAL';
            $bitacora->tabla_id = $local->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function alterarestado($id, $listarLuego, $estado)
    {
        $existe = Libreria::verificarExistencia($id, 'local');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Local::find($id);
        $entidad  = 'Local';
        $formData = array('route' => array('local.confirmaralterarestado', "id=" . $id, "estado=" . $estado), 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarAlterarestado')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
}
