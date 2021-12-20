<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Grupo;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
{
    protected $folderview      = 'app.grupo';
    protected $tituloAdmin     = 'Grupo';
    protected $tituloRegistrar = 'Registrar Grupo';
    protected $tituloModificar = 'Modificar Grupo';
    protected $tituloEliminar  = 'Eliminar Grupo';
    protected $rutas           = array('create' => 'grupo.create', 
        'edit'   => 'grupo.edit', 
        'delete' => 'grupo.eliminar',
        'search' => 'grupo.buscar',
        'index'  => 'grupo.index',
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Grupo';
        $name             = Libreria::getParam($request->input('nombre'));
        $resultado        = Grupo::select('id', 'codigo', 'descripcion');

        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Código', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Descripción', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '2');

        $ruta             = $this->rutas;
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;

        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'ruta', 'titulo_modificar', 'titulo_eliminar'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'Grupo';
        $title            = $this->tituloAdmin;
        $ruta             = $this->rutas;
        $titulo_registrar = $this->tituloRegistrar;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'ruta', 'titulo_registrar'));
    }

    public function show($id)
    {
        //
    }

    public function create(Request $request)
    {
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $entidad  = 'Grupo';
        $grupo     = null;
        $formData = array('grupo.store');
        $formData = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Registrar';
        return view($this->folderview.'.mant')->with(compact('grupo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $validacion = Validator::make($request->all(),
            array(
                'codigo'      => 'required|unique:grupo,codigo,NULL,id',
                'descripcion' => 'required'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $grupo              = new Grupo();
            $grupo->codigo      = $request->input('codigo');
            $grupo->descripcion = $request->input('descripcion');
            $grupo->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'grupo');
        if ($existe !== true) {
            return $existe;
        }
        $listar       = Libreria::getParam($request->input('listar'), 'NO');
        $grupo        = Grupo::find($id);
        $entidad      = 'Grupo';
        $formData     = array('grupo.update', $id);
        $formData     = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton               = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('grupo', 'formData', 'entidad', 'boton', 'listar'));        
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'grupo');
        if ($existe !== true) {
            return $existe;
        }
        $validacion = Validator::make($request->all(),
            array(
                'codigo'      => 'required|unique:grupo,codigo,'.$id.',id',
                'descripcion' => 'required'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $grupo              = Grupo::find($id);
            $grupo->codigo      = $request->input('codigo');
            $grupo->descripcion = $request->input('descripcion');
            $grupo->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'grupo');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $grupo = Grupo::find($id);
            $grupo->delete();
        });
        return is_null($error) ? "OK" : $error;
    }
    
    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'grupo');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Grupo::find($id);
        $entidad  = 'Grupo';
        $formData = array('route' => array('grupo.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }
}
