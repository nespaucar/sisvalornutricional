<?php
use App\Models\Menuoptioncategory;
use App\Models\Menuoption;
use App\Models\Permission;
use App\Models\User;
use App\Models\Persona;
use Jenssegers\Date\Date;
$user                  = Auth::user();
session(['usertype_id' => $user->usertype_id]);
$tipousuario_id        = session('usertype_id');
$menu2                 = generarMenuHorizontal($tipousuario_id);
$person                = Persona::find($user->persona_id);
$nombrelocal           = $person->local->descripcion;
$date                  = Date::instance($user->created_at)->format('l j F Y');

?>
<!-- Begin page -->
    <style>
        .boxfondo {
            background: rgba(51,122,183,0.10);
        }
        .labelr {
            color: blue;
        }
        .requerido:after, .requerido2:after {
            content: ' (*)';
        }
        .requerido {
            color: red;
        }
        .requerido2 {
            color: blue;
        }
    </style>
        <div id="wrapper">
        
            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="#" class="logo"><i class="fa fa-calculator"></i> <span>Calculadora Nutricional</span> </a>
                    </div>
                </div>

                <!-- Navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="md md-chevron-left"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                            {!! $menu2 !!}

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light">
                                        <i class="md md-home"></i>
                                        <b id="nombreGeneralLocal">{{$nombrelocal}}</b>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                        <font id="imgProfile1">
                                            <img src="{{ asset('avatar/' . $user->avatar) }}?t={{time()}}" alt="user-img" class="img-circle" height="40px" width="40px" style="border-color: red; border: #3F51B5 2px solid;">
                                        </font>
                                        <font class="hidden-xs">
                                            {{explode(' ', $person->nombres)[0]}} - {{$user->usertype->nombre}}
                                        </font>
                                        <font class="hidden-sm hidden-md hidden-lg">
                                            {{explode(' ', $person->nombres)[0]}}
                                        </font>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="text-center notifi-title">{{$person->nombres}} - {{$user->usertype->nombre}}</li>
                                        <li class="text-center notifi-title" id="imgProfile2">
                                            <img style="cursor:pointer" onclick="cargarRuta('actualizardatos', 'container');" src="{{ asset('avatar/' . $user->avatar) }}?t={{time()}}" alt="user-img" class="img-circle" height="90px" width="90px" style="border-color: red; border: #3F51B5 2px solid;">
                                        </li>
                                        <li class="text-center notifi-title"><p style="color: #32408F; font-size: 14px; margin-bottom: -4px;">Miembro desde el {{$date}}</p></li>
                                        <li class="list-group nicescroll notification-list">
                                            <a style="cursor:pointer" href="javascript:void(0);" onclick="cargarRuta('actualizardatos', 'container');" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                        <em class="md md-face-unlock noti-primary"></em>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading">Mi Perfil</h5>
                                                        <p class="m-0">
                                                            <small>Actualiza Tus Datos</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>

                                            <a style="cursor:pointer" href="javascript:void(0);" onclick="cargarRuta('updatepassword', 'container');" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                        <em class="md md-vpn-key noti-warning"></em>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading">Cambiar Contraseña</h5>
                                                        <p class="m-0">
                                                            <small>Cambia Tu Contraseña</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>

                                            <a style="cursor:pointer" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                        <em class="md md-settings-power noti-danger"></em>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading">Cerrar Sesión</h5>
                                                        <p class="m-0">
                                                            <small>Hasta Pronto</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>                                        
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            @include('principal.left_sidebar')
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container" id="container">

<?php
function generarMenuHorizontal($idtipousuario)
{
    $menu = array();
    #Paso 1°: Buscar las categorias principales
    $categoriaopcionmenu = new Menuoptioncategory();
    $opcionmenu          = new Menuoption();
    $permiso             = new Permission();
    $catPrincipales      = $categoriaopcionmenu->where('position','=','H')->whereNull('menuoptioncategory_id')->orderBy('order', 'ASC')->get();
    $cadenaMenu          = '<ul class="nav navbar-nav hidden-xs">';
    $hijos='';
    foreach ($catPrincipales as $key => $catPrincipal) {
        #Buscamos a las categorias hijo
        //$hijos = buscarHijosHorizontal($catPrincipal->id, $idtipousuario);
        $usar = false;
        $aux = array();
        $opciones = $opcionmenu->where('menuoptioncategory_id', '=', $catPrincipal->id)->orderBy('order', 'ASC')->get();
        if ($opciones->count()) {               
            foreach ($opciones as $key => $opcion) {
                $permisos = $permiso->where('menuoption_id', '=', $opcion->id)->where('usertype_id', '=', $idtipousuario)->first();
                if ($permisos) {
                    $usar  = true;
                    $aux2  = $opcionmenu->find($permisos->menuoption_id);
                    $aux[] = array(
                        'id'     => $aux2->id,
                        'nombre' => $aux2->name,
                        'link'   => $aux2->link,
                        'icono'  => $aux2->icon
                        );
                }
            }           
        }
        //if ($hijos != '' || $usar === true ) {
        if ($usar === true ) {
            $cadenaMenu .= '<li class="dropdown">';
            $cadenaMenu .= '<a href="javascript:void(0);" class="dropdown-toggle waves-effect" data-toggle="dropdown"
                                       role="button" aria-haspopup="true" aria-expanded="false"><i class="'.$catPrincipal->icon.'"></i> <span>'.$catPrincipal->name.'</span> <span class="caret"></span></a>';
            $cadenaMenu .= '<ul class="dropdown-menu">';
            for ($i=0; $i < count($aux); $i++) { 
                if (strtoupper($aux[$i]['nombre']) === 'SEPARADOR') {
                    //$cadenaMenu .= '<li class="divider"></li>';
                }else{
                    $cadenaMenu .= '<li id="'.$aux[$i]['id'].'"><a href="#" onclick="cargarRutaMenu(\''.URL::to($aux[$i]['link']).'\', \'container\', \''.$aux[$i]['id'].'\');"><i class="'.$aux[$i]['icono'].'"></i> '.$aux[$i]['nombre'].'</a></li>';
                }
            }
            if (count($aux) > 0 && $hijos != '' ) {
                //$cadenaMenu .= '<li class="divider"></li>';
            }
            /*if ($hijos != '') {
                $cadenaMenu .= $hijos;
            }*/
            $cadenaMenu .= '</ul>';
            $cadenaMenu .= '</li>';
        }
    }
    $cadenaMenu .= '</ul>';
    return $cadenaMenu;
}

function buscarHijosHorizontal($categoriaopcionmenu_id, $tipousuario_id)
{
    $menu = array();
    $categoriaopcionmenu = new Menuoptioncategory();
    $opcionmenu          = new Menuoption();
    $permiso             = new Permission();

    $catHijos = $categoriaopcionmenu->where('position','=','H')->where('menuoptioncategory_id', '=', $categoriaopcionmenu_id)->orderBy('order', 'ASC')->get();
    $cadenaMenu = '';
    foreach ($catHijos as $key => $catHijo) {
        $usar = false;
        $aux = array();
        $hijos = buscarHijosHorizontal($catHijo->id, $tipousuario_id);
        $opciones = $opcionmenu->where('menuoptioncategory_id', '=', $catHijo->id)->orderBy('order', 'ASC')->get();
        if ($opciones->count()) {

            foreach ($opciones as $key => $opcion) {
                $permisos = $permiso->where('menuoption_id', '=', $opcion->id)->where('usertype_id', '=', $tipousuario_id)->first();
                if ($permisos) {
                    $usar = true;
                    $aux2 = $opcionmenu->find($permisos->menuoption_id);
                    $aux[] = array(
                        'id'     => $aux2->id,
                        'nombre' => $aux2->name,
                        'link'   => $aux2->link,
                        'icono'  => $aux2->icon
                        );
                }
            }

        }
        if ($hijos != '' || $usar === true ) {

            $cadenaMenu .= '<li class="has_sub">';
            $cadenaMenu .= '<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="'.$catHijo->icon.'"></i> <span> '.$catHijo->name.' </span>
                    <span class="menu-arrow"></span></a>';
            $cadenaMenu .= '<ul class="list-unstyled">';
            for ($i=0; $i < count($aux); $i++) { 
                if (strtoupper($aux[$i]['nombre']) === 'SEPARADOR') {
                    //$cadenaMenu .= '<li class="divider"></li>';
                } else {
                    $cadenaMenu .= '<li id="'.$aux[$i]['id'].'"><a onclick="cargarRutaMenu(\''.URL::to($aux[$i]['link']).'\', \'container\', \''.$aux[$i]['id'].'\');"><i class="'.$aux[$i]['icono'].'" ></i> '.$aux[$i]['nombre'].'</a></li>';
                }
            }
            if (count($aux) > 0 && $hijos != '' ) {
                //$cadenaMenu .= '<li class="divider"></li>';
            }
            if ($hijos != '') {
                $cadenaMenu .= $hijos;
            }
            $cadenaMenu .= '</ul>';
            $cadenaMenu .= '</li>';
        }
    }
    return $cadenaMenu;
}
?>