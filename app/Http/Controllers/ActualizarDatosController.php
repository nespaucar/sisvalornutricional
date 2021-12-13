<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Bitacora;
use App\Librerias\Libreria;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class ActualizarDatosController extends Controller
{

    protected $folderview      = 'app.actualizardatos';
    protected $tituloAdmin     = 'Actualizar Datos';
    protected $rutas           = array(
            'update'   => 'actualizardatos.update',
            'index'  => 'actualizardatos.index',
        );

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $title            = $this->tituloAdmin;
        $ruta             = $this->rutas;

        $user             = Auth::user();

        if($user->persona_id !== null){

            $entidad          = 'Persona';
            $persona        = Persona::find($user->persona_id);
            $existe = Libreria::verificarExistencia($user->persona_id, 'persona');
            if ($existe !== true) {
                return $existe;
            }
            $listar         = Libreria::getParam($request->input('listar'), 'NO');
            $formData       = array('actualizardatos.update', $user->persona_id);
            $formData       = array('route' => $formData, 'method' => 'PUT','class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
            $boton          = 'Modificar';

            return view($this->folderview.'.user')->with(compact('persona', 'title', 'ruta', 'formData', 'entidad', 'boton', 'listar'));
        }

    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        $user   = Auth::user();

        if($user->persona_id !== null){

            $existe = Libreria::verificarExistencia($id, 'persona');
            if ($existe !== true) {
                return $existe;
            }
            $reglas = array(
                'direccion' => 'required|max:100',
                'email' => 'required|email|max:50',
                'email' => [
                    'required',
                    Rule::unique('usuario')->ignore($user->id),
                ],
                'imageProfile' => 'image|mimes:jpg,png,jpeg,JPG,PNG,JPEG|max:500000',
                );
            $validacion = Validator::make($request->all(),$reglas);
            if ($validacion->fails()) {
                return $validacion->messages()->toJson();
            } 
            $error = DB::transaction(function() use($request, $id){
                $user               = Auth::user();
                $persona            = Persona::find($id);
                $persona->direccion = $request->input('direccion');
                $usuario            = Usuario::find($user->id);
                $usuario->email     = $request->input('email');
                $persona->save();
                $usuario->save();

                $bitacora = new Bitacora();
                $bitacora->fecha = date('Y-m-d');
                $bitacora->descripcion = 'Se ACTUALIZAN LOS DATOS del ' . ($persona->tipo==='A'?'ADMINISTRADOR':($persona->tipo==='C'?'COMISIONISTA':'VENDEDOR')) . ' ' . $persona->nombres;
                $bitacora->tabla = 'PERSONA';
                $bitacora->tabla_id = $persona->id;
                $bitacora->usuario_id = $user->id;
                $bitacora->save();
            });

            $path = '';
            
            if ($request->hasFile('imageProfile')){
                if ($request->file('imageProfile')->isValid()) {

                    $user = Auth::user();
                    $usuario = Usuario::find($user->id);

                    if(\File::exists('avatar/'.$usuario->avatar) && $usuario->avatar !== 'admin.jpg') {
                        \File::delete('avatar/'.$usuario->avatar);
                    }
                    
                    $filename = $user->id.'_'.time().'.'.$request->imageProfile->getClientOriginalExtension();
                    $path = public_path('avatar/'.$filename);

                    $file = $request->file('imageProfile');
                    Image::make($file)->fit(144, 144);//->save($path);
                    $file->move('avatar', $filename);
                    
                    $usuario->avatar = $filename;
                    $usuario->save();
                }
            }

            return is_null($error) ? 'OK' : $error;

        }

    }

    public function actualizardatosavatar(Request $request){
        $user = Auth::user();
        $usuario = Usuario::find($user->id);
        return $usuario->avatar;
    }

}
