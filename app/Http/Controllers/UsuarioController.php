<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Validator;
use App\Http\Requests;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Local;
use App\Models\Usertype;
use App\Models\Bitacora;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller {
    protected $folderview      = 'app.usuario';
    protected $tituloAdmin     = 'Usuario';
    protected $tituloRegistrar = 'Registrar usuario';
    protected $tituloModificar = 'Modificar usuario';
    protected $tituloEliminar  = 'Eliminar usuario';
    protected $rutas           = array('create' => 'usuario.create', 
        'edit'         => 'usuario.edit', 
        'escogerlocal' => 'usuario.escogerlocal', 
        'guardarlocal' => 'usuario.guardarlocal', 
        'delete'       => 'usuario.eliminar',
        'search'       => 'usuario.buscar',
        'index'        => 'usuario.index',
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Usuario';
        $login            = Libreria::getParam($request->input('login'));
        $tipousuario_id   = Libreria::getParam($request->input('tipousuario_id'));
        $resultado        = Usuario::listar($login,$tipousuario_id);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nombre', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Usuario', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Tipo Usuario', 'numero' => '1');
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
        $entidad          = 'Usuario';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        $cboUsertype   = array('' => '-- Todos --') + Usertype::pluck('nombre', 'id')->all();
        return view($this->folderview.'.admin')->with(compact('entidad', 'cboUsertype' , 'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request)
    {
        $listar         = Libreria::getParam($request->input('listar'), 'NO');
        $entidad        = 'Usuario';
        $usuario        = null;
        // Solo puedo crear un administrador principal, los otros tipos se crean automáticamente
        $cboUsertype = array('1' => 'ADMINISTRADOR PRINCIPAL');
        $formData       = array('usuario.store');
        $formData       = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton          = 'Registrar'; 
        return view($this->folderview.'.mant')->with(compact('usuario', 'formData', 'entidad', 'boton', 'listar', 'cboUsertype'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $reglas = array(
            'usertype_id' => 'required|integer|exists:usertype,id,deleted_at,NULL',            
            'nombre'    => 'required|max:100',
            'telefono' => 'required|max:9',            
            'email' => 'required|email|max:100|unique:usuario,email,NULL,id,deleted_at,NULL',
            'login' => 'required|max:20|unique:usuario,login,NULL,id,deleted_at,NULL',
            'password' => 'required|min:6|max:18',
        );
        $validacion = Validator::make($request->all(),$reglas);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request) {
            $user     = Auth::user();

            $persona = new Persona();
            $persona                  = new Persona();
            $persona->nombre          = $request->input('nombre');
            $persona->dni             = $request->input('login');
            $persona->tipo            = 'A'; // Comisionista
            $persona->usuario_id      = 0;
            $persona->local_id        = $user->persona->local_id;
            $persona->telefono        = $request->input('telefono');
            $persona->direccion       = $request->input('direccion');
            $persona->save();

            $usuario               = new Usuario();
            $usuario->login        = $request->input('login');
            $usuario->email        = $request->input('email');
            $usuario->password     = Hash::make($request->input('password'));
            $usuario->usertype_id  = $request->input('usertype_id');
            $usuario->persona_id  = $persona->id;
            $usuario->local_id  = $user->local_id;
            $usuario->save();

            $persona->usuario_id = $usuario->id;
            $persona->save();

            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se CREA el Usuario ' . $usuario->login;
            $bitacora->tabla = 'USUARIO';
            $bitacora->tabla_id = $usuario->id;
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
        $existe = Libreria::verificarExistencia($id, 'usuario');
        if ($existe !== true) {
            return $existe;
        }
        $listar         = Libreria::getParam($request->input('listar'), 'NO');
        $cboUsertype = Usertype::pluck('nombre', 'id')->all();
        $usuario        = Usuario::find($id);
        $entidad        = 'Usuario';
        $formData       = array('usuario.update', $id);
        $formData       = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton          = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('usuario', 'formData', 'entidad', 'boton', 'listar', 'cboUsertype'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'usuario');
        if ($existe !== true) {
            return $existe;
        }
        $reglas = array(
            'nombre'    => 'required|max:100',
            'telefono' => 'required|max:9',
            'email' => 'required|email|max:100|unique:usuario,email,'.$id.',id,deleted_at,NULL',
            'login'=> 'required|max:20|unique:usuario,login,'.$id.',id,deleted_at,NULL',
            'password' => 'required|min:6|max:18',
        );
        $validacion = Validator::make($request->all(),$reglas);
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $user     = Auth::user();

            $usuario                 = Usuario::find($id);
            $usuario->login          = $request->input('login');
            $usuario->email          = $request->input('email');
            if ($request->input('password') != null && $request->input('password') != '') {
                $usuario->password   = Hash::make($request->input('password'));
            }
            $usuario->save();

            $persona              = $usuario->persona;
            $persona->nombre      = $request->input('nombre');
            $persona->dni         = $request->input('login');
            $persona->telefono    = $request->input('telefono');
            $persona->direccion   = $request->input('direccion');
            $persona->save();
            
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se MODIFICA el Usuario ' . $usuario->login;
            $bitacora->tabla = 'USUARIO';
            $bitacora->tabla_id = $usuario->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'usuario');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $usuario = Usuario::find($id);            

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se ELIMINA el Usuario ' . $usuario->login;
            $bitacora->tabla = 'OPCIÓN DE MENÚ';
            $bitacora->tabla_id = $usuario->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();

            $usuario->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'usuario');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Usuario::find($id);
        $entidad  = 'Usuario';
        $formData = array('route' => array('usuario.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function escogerlocal(Request $request)
    {
        $user             = Auth::user();
        $local_id         = $user->persona->local_id;
        $entidad          = 'Usuario';
        $title            = 'Setear Local';
        $ruta             = $this->rutas;
        $cboLocales         = Local::pluck('nombre', 'id')->all();
        return view($this->folderview.'.escogerlocal')->with(compact('cboLocales','entidad', 'local_id', 'title', 'ruta'));
    }

    public function guardarlocal(Request $request)
    {
        $dat = "";
        $error = DB::transaction(function() use($request, &$dat){
            $local_id          = $request->input('local_id');
            $user              = Auth::user();
            $persona           = $user->persona;
            $persona->local_id = $local_id;
            $persona->save();
            $dat               = mb_strtoupper($persona->local->nombre);
        });
        return is_null($error) ? $dat : $error;   
    }
}
