<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Usertype;
use App\Permission;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TipousuarioController extends Controller
{
    protected $folderview      = 'app.tipousuario';
    protected $tituloAdmin     = 'Tipos de usuario';
    protected $tituloRegistrar = 'Registrar tipo de usuario';
    protected $tituloModificar = 'Modificar tipo de usuario';
    protected $tituloEliminar  = 'Eliminar tipo de usuario';
    protected $rutas           = array('create' => 'tipousuario.create', 
            'edit'     => 'tipousuario.edit', 
            'delete'   => 'tipousuario.eliminar',
            'search'   => 'tipousuario.buscar',
            'index'    => 'tipousuario.index',
            'permisos' => 'tipousuario.obtenerpermisos',
        );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Tipousuario';
        $name             = Libreria::getParam($request->input('name'));
        $resultado        = Usertype::listar($name);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nombre', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Operaciones', 'numero' => '3');
        
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
        $entidad          = 'Tipousuario';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request)
    {
        $listar       = Libreria::getParam($request->input('listar'), 'NO');
        $entidad      = 'Tipousuario';
        $tipousuario  = null;
        $formData     = array('tipousuario.store');
        $formData     = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton        = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('tipousuario', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $validacion = Validator::make($request->all(),
            array(
                'nombre' => 'required|max:60'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $tipousuario       = new Usertype();
            $tipousuario->nombre = $request->input('nombre');
            $tipousuario->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function show($id)
    {
        //
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'usertype');
        if ($existe !== true) {
            return $existe;
        }
        $listar       = Libreria::getParam($request->input('listar'), 'NO');
        $tipousuario  = Usertype::find($id);
        $entidad      = 'Tipousuario';
        $formData     = array('tipousuario.update', $id);
        $formData     = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton        = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('tipousuario', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'usertype');
        if ($existe !== true) {
            return $existe;
        }
        $validacion = Validator::make($request->all(),
            array(
                'nombre' => 'required|max:60'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $tipousuario       = Usertype::find($id);
            $tipousuario->nombre = $request->input('nombre');
            $tipousuario->save();

        });
        return is_null($error) ? "OK" : $error;
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'usertype');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $tipousuario = Usertype::find($id);
            $tipousuario->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'usertype');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Usertype::find($id);
        $entidad  = 'Tipousuario';
        $formData = array('route' => array('tipousuario.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function obtenerpermisos($listarParam, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'usertype');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        $entidad = 'Permiso';
        if (isset($listarParam)) {
            $listar = $listarParam;
        }
        $tipousuario = Usertype::find($id);
        return view($this->folderview.'.permisos')->with(compact('tipousuario', 'listar', 'entidad'));
    }
    
    public function guardarpermisos(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'usertype');
        if ($existe !== true) {
            return $existe;
        }
        $listar        = Libreria::getParam($request->input('listar'), 'NO');
        $estados       = $request->input('estado');
        $idopcionmenus = $request->input('idopcionmenu');
        $cantAux       = count($estados);
        $respuesta     = true;
        $error         = DB::transaction(function() use ($id, $idopcionmenus, $estados, $cantAux)
        {
            Permission::where('usertype_id', '=', $id)->delete();
            for ($i=0; $i < $cantAux; $i++) {
                $exito = true;
                if($estados[$i] === 'H'){
                    $permiso = new Permission();
                    $permiso->usertype_id = $id;
                    $permiso->menuoption_id = $idopcionmenus[$i];
                    $permiso->save();
                }
            }
        });
        return is_null($error) ? "OK" : $error;
            
    }
}
