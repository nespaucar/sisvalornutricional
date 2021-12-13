<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Usertype;
use App\Models\Permission;
use App\Models\Bitacora;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsertypeController extends Controller
{
    protected $folderview      = 'app.usertype';
    protected $tituloAdmin     = 'Tipos de usuario';
    protected $tituloRegistrar = 'Registrar tipo de usuario';
    protected $tituloModificar = 'Modificar tipo de usuario';
    protected $tituloEliminar  = 'Eliminar tipo de usuario';
    protected $rutas           = array('create' => 'usertype.create', 
            'edit'     => 'usertype.edit', 
            'delete'   => 'usertype.eliminar',
            'search'   => 'usertype.buscar',
            'index'    => 'usertype.index',
            'permisos' => 'usertype.obtenerpermisos',
        );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Usertype';
        $name             = Libreria::getParam($request->input('name'));
        $resultado        = Usertype::listar($name);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nombre', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Acciones', 'numero' => '3');
        
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
        $entidad          = 'Usertype';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request)
    {
        $listar       = Libreria::getParam($request->input('listar'), 'NO');
        $entidad      = 'Usertype';
        $usertype  = null;
        $formData     = array('usertype.store');
        $formData     = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton        = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('usertype', 'formData', 'entidad', 'boton', 'listar'));
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
            $usertype       = new Usertype();
            $usertype->nombre = $request->input('nombre');
            $usertype->save();

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se CREA el Tipo de Usuario ' . $request->input('nombre');
            $bitacora->tabla = 'TIPO DE USUARIO';
            $bitacora->tabla_id = $usertype->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
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
        $usertype  = Usertype::find($id);
        $entidad      = 'Usertype';
        $formData     = array('usertype.update', $id);
        $formData     = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton        = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('usertype', 'formData', 'entidad', 'boton', 'listar'));
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
            $usertype       = Usertype::find($id);
            $usertype->nombre = $request->input('nombre');
            $usertype->save();

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se MODIFICA el Tipo de Usuario ' . $request->input('nombre');
            $bitacora->tabla = 'TIPO DE USUARIO';
            $bitacora->tabla_id = $usertype->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
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
            $usertype = Usertype::find($id);

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se ELIMINA el Tipo de Usuario ' . $usertype->nombre;
            $bitacora->tabla = 'TIPO DE USUARIO';
            $bitacora->tabla_id = $usertype->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();

            $usertype->delete();
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
        $entidad  = 'Usertype';
        $formData = array('route' => array('usertype.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
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
        $usertype = Usertype::find($id);
        return view($this->folderview.'.permisos')->with(compact('usertype', 'listar', 'entidad'));
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

            $usertype = Usertype::find($id);

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se MODIFICAN LOS PERMISOS del Tipo de usuario ' . $usertype->nombre;
            $bitacora->tabla = 'TIPO DE USUARIO';
            $bitacora->tabla_id = $usertype->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
        });
        return is_null($error) ? "OK" : $error;
            
    }
}
