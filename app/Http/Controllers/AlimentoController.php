<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Alimento;
use App\Models\Grupo;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AlimentoController extends Controller
{
    protected $folderview      = 'app.alimento';
    protected $tituloAdmin     = 'Alimento';
    protected $tituloRegistrar = 'Registrar Alimento (Composición en 1g)';
    protected $tituloModificar = 'Modificar Alimento (Composición en 1g)';
    protected $tituloEliminar  = 'Eliminar Alimento';
    protected $rutas           = array('create' => 'alimento.create', 
        'edit'   => 'alimento.edit', 
        'delete' => 'alimento.eliminar',
        'search' => 'alimento.buscar',
        'index'  => 'alimento.index',
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina                = $request->input('page');
        $filas                 = $request->input('filas');
        $entidad               = 'Alimento';
        $name                  = Libreria::getParam($request->input('nombre'));
        $resultado             = Alimento::select("alimento.energia_kcal", "alimento.energia_kJ", "alimento.agua", "alimento.proteina", "alimento.grasa", "alimento.carbohidrato_total", "alimento.carbohidrato_disponible", "alimento.fibra_dietaria", "alimento.ceniza", "alimento.calcio", "alimento.fosforo", "alimento.zinc", "alimento.hierro", "alimento.bcaroteno", "alimento.vitaminaA", "alimento.tiamina", "alimento.riboflavina", "alimento.niacina", "alimento.vitaminaC", "alimento.acido_folico", "alimento.sodio", "alimento.potasio", "alimento.id", DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion) AS descr"), 'alimento.estrato', 'alimento.estado')
        ->join('grupo', 'grupo.id', '=', 'alimento.grupo_id')
        ->where(DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion)"), 'LIKE', "%".$name."%");

        $lista           = $resultado->get();
        $cabecera        = array();
        $cabecera[]      = array('valor' => '#', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Descripcion', 'numero' => '1');
        $cabecera[]      = array('valor' => 'ENERC', 'numero' => '1');
        $cabecera[]      = array('valor' => 'ENERC', 'numero' => '1');
        $cabecera[]      = array('valor' => 'WATER', 'numero' => '1');
        $cabecera[]      = array('valor' => 'PROCNT', 'numero' => '1');
        $cabecera[]      = array('valor' => 'FAT', 'numero' => '1');
        $cabecera[]      = array('valor' => 'CHOCDF', 'numero' => '1');
        $cabecera[]      = array('valor' => 'CHOAVL', 'numero' => '1');
        $cabecera[]      = array('valor' => 'FIBTG', 'numero' => '1');
        $cabecera[]      = array('valor' => 'ASH', 'numero' => '1');
        $cabecera[]      = array('valor' => 'CA', 'numero' => '1');
        $cabecera[]      = array('valor' => 'P', 'numero' => '1');
        $cabecera[]      = array('valor' => 'ZN', 'numero' => '1');
        $cabecera[]      = array('valor' => 'FE', 'numero' => '1');
        $cabecera[]      = array('valor' => 'CARTBQ', 'numero' => '1');
        $cabecera[]      = array('valor' => 'VITA', 'numero' => '1');
        $cabecera[]      = array('valor' => 'THIA', 'numero' => '1');
        $cabecera[]      = array('valor' => 'RIBF', 'numero' => '1');
        $cabecera[]      = array('valor' => 'NIA', 'numero' => '1');
        $cabecera[]      = array('valor' => 'VITC', 'numero' => '1');
        $cabecera[]      = array('valor' => 'AF', 'numero' => '1');
        $cabecera[]      = array('valor' => 'NA', 'numero' => '1');
        $cabecera[]      = array('valor' => 'K', 'numero' => '1');
        $cabecera[]      = array('valor' => 'Operaciones', 'numero' => '2');

        $ruta            = $this->rutas;
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar = $this->tituloEliminar;

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
        $entidad          = 'Alimento';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'ruta', 'titulo_registrar'));
    }

    public function create(Request $request)
    {
        $listar    = Libreria::getParam($request->input('listar'), 'NO');
        $entidad   = 'Alimento';
        $cboGrupo  = [''=>'-- Seleccione un grupo --'] + Grupo::pluck('descripcion', 'id')->all();
        $alimento  = null;
        $formData  = array('alimento.store');
        $formData  = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton     = 'Registrar';
        return view($this->folderview.'.mant')->with(compact('alimento', 'formData', 'entidad', 'boton', 'cboGrupo', 'listar'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $validacion = Validator::make($request->all(),
            array(
                    'grupo_id' => 'required',
                    'numero' => 'required',
                    'descripcion' => 'required'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $alimento = new Alimento();
            $alimento->grupo_id = $request->input('grupo_id');
            $alimento->descripcion = $request->input('descripcion');
            $alimento->estrato = $request->input('estrato');
            $alimento->numero = $request->input('numero');
            $alimento->energia_kcal = $request->input('energia_kcal');
            $alimento->energia_kJ = $request->input('energia_kJ');
            $alimento->agua = $request->input('agua');
            $alimento->proteina = $request->input('proteina');
            $alimento->grasa = $request->input('grasa');
            $alimento->carbohidrato_total = $request->input('carbohidrato_total');
            $alimento->carbohidrato_disponible = $request->input('carbohidrato_disponible');
            $alimento->fibra_dietaria = $request->input('fibra_dietaria');
            $alimento->ceniza = $request->input('ceniza');
            $alimento->calcio = $request->input('calcio');
            $alimento->fosforo = $request->input('fosforo');
            $alimento->zinc = $request->input('zinc');
            $alimento->hierro = $request->input('hierro');
            $alimento->bcaroteno = $request->input('bcaroteno');
            $alimento->vitaminaA = $request->input('vitaminaA');
            $alimento->tiamina = $request->input('tiamina');
            $alimento->riboflavina = $request->input('riboflavina');
            $alimento->niacina = $request->input('niacina');
            $alimento->vitaminaC = $request->input('vitaminaC');
            $alimento->acido_folico = $request->input('acido_folico');
            $alimento->sodio = $request->input('sodio');
            $alimento->potasio = $request->input('potasio');
            $alimento->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'alimento');
        if ($existe !== true) {
            return $existe;
        }
        $listar   = Libreria::getParam($request->input('listar'), 'NO');
        $alimento = Alimento::find($id);
        $entidad  = 'Alimento';
        $cboGrupo = [''=>'-- Seleccione un grupo --'] + Grupo::pluck('descripcion', 'id')->all();
        $formData = array('alimento.update', $id);
        $formData = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton        = 'Modificar';
        return view($this->folderview.'.mant')->with(compact('alimento', 'formData', 'entidad', 'boton', 'cboGrupo', 'listar'));
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'alimento');
        if ($existe !== true) {
            return $existe;
        }
        $validacion = Validator::make($request->all(),
            array(
                    'grupo_id' => 'required',
                    'numero' => 'required',
                    'descripcion' => 'required'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $alimento = Alimento::find($id);
            $alimento->grupo_id = $request->input('grupo_id');
            $alimento->descripcion = $request->input('descripcion');
            $alimento->estrato = $request->input('estrato');
            $alimento->numero = $request->input('numero');
            $alimento->energia_kcal = $request->input('energia_kcal');
            $alimento->energia_kJ = $request->input('energia_kJ');
            $alimento->agua = $request->input('agua');
            $alimento->proteina = $request->input('proteina');
            $alimento->grasa = $request->input('grasa');
            $alimento->carbohidrato_total = $request->input('carbohidrato_total');
            $alimento->carbohidrato_disponible = $request->input('carbohidrato_disponible');
            $alimento->fibra_dietaria = $request->input('fibra_dietaria');
            $alimento->ceniza = $request->input('ceniza');
            $alimento->calcio = $request->input('calcio');
            $alimento->fosforo = $request->input('fosforo');
            $alimento->zinc = $request->input('zinc');
            $alimento->hierro = $request->input('hierro');
            $alimento->bcaroteno = $request->input('bcaroteno');
            $alimento->vitaminaA = $request->input('vitaminaA');
            $alimento->tiamina = $request->input('tiamina');
            $alimento->riboflavina = $request->input('riboflavina');
            $alimento->niacina = $request->input('niacina');
            $alimento->vitaminaC = $request->input('vitaminaC');
            $alimento->acido_folico = $request->input('acido_folico');
            $alimento->sodio = $request->input('sodio');
            $alimento->potasio = $request->input('potasio');
            $alimento->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'alimento');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $alimento = Alimento::find($id);
            $alimento->delete();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'alimento');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Alimento::find($id);
        $entidad  = 'Alimento';
        $formData = array('route' => array('alimento.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar'));
    }

    public function cargarSelectAlimentos(Request $request) {
        $cboAlimentos = '<option value="">-- Seleccione un Alimento --</option>';
        $alimentos    = Alimento::select("alimento.id", DB::raw("CONCAT(grupo.codigo, ' - ', grupo.descripcion,': ', alimento.descripcion) AS descr"), 'alimento.estrato')
            ->join('grupo', 'alimento.grupo_id', 'grupo.id')
            ->where('alimento.estado', '=', 1)
            ->get();
        foreach ($alimentos as $alim) {
            $cboAlimentos .= '<option value="' . $alim->id . '">' . $alim->descr . ($alim->estrato===NULL||$alim->estrato===""||$alim->estrato==="-"?"":" - ".$alim->estrato) . '</option>';
        }
        return $cboAlimentos;
    }
}
