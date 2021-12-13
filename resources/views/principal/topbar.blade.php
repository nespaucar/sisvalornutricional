<?php
use App\Menuoptioncategory;
use App\Menuoption;
use App\Permission;
use App\User;
use App\Persona;
$user                  = Auth::user();
session(['usertype_id' => $user->usertype_id]);
$tipousuario_id        = session('usertype_id');
$menu2                 = generarMenuHorizontal($tipousuario_id);
$person                = Persona::find($user->persona_id);
$nombrelocal           = mb_strtoupper($user->local->descripcion);

?>
<!-- Begin page -->
    <style>
        .boxfondo {
            background: rgba(51,122,183,0.10);
        }
        .labelr {
            color: blue;
        }
    </style>
        <div id="wrapper">
        
            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="#" class="logo"><i class="md md-equalizer"></i> <span>Requerimientos</span> </a>
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

                            <!--<div class="topbar-left">
                                <div class="text-center">
                                    <a href="#" onclick="cargarRutaMenu('alumno', 'container', '14');" class="logo"><i class="glyphicon glyphicon-user"></i> <span>ALUMNOS</span> </a>
                                </div>
                            </div>

                            <div class="topbar-left">
                                <div class="text-center">
                                    <a href="#" onclick="cargarRutaMenu('apoderado', 'container', '14');" class="logo"><i class="glyphicon glyphicon-user"></i> <span>APODERADOS</span> </a>
                                </div>
                            </div>

                            <div class="topbar-left">
                                <div class="text-center">
                                    <a href="#" onclick="cargarRutaMenu('alumnoseccion', 'container', '14');" class="logo"><i class="glyphicon glyphicon-expand"></i> <span>MATRICULA</span> </a>
                                </div>
                            </div>

                            <div class="topbar-left">
                                <div class="text-center">
                                    <a href="#" onclick="cargarRutaMenu('mensualidad', 'container', '14');" class="logo"><i class="glyphicon glyphicon-expand"></i> <span>MENSUALIDAD</span> </a>
                                </div>
                            </div>-->

                            <ul class="nav navbar-nav navbar-right pull-right">

                                <!--<li class="dropdown hidden-xs">
                                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light"
                                       data-toggle="dropdown" aria-expanded="true">
                                        <i class="md md-notifications"></i> <span
                                            class="badge badge-xs badge-pink">3</span>
                                            lol
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg">
                                        <li class="text-center notifi-title">Notification</li>
                                        <li class="list-group nicescroll notification-list">
                                            <a href="javascript:void(0);" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                        <em class="fa fa-diamond noti-primary"></em>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading">A new order has been placed A new
                                                            order has been placed</h5>
                                                        <p class="m-0">
                                                            <small>There are new settings available</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="javascript:void(0);" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                        <em class="fa fa-cog noti-warning"></em>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading">New settings</h5>
                                                        <p class="m-0">
                                                            <small>There are new settings available</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="javascript:void(0);" class="list-group-item">
                                                <div class="media">
                                                    <div class="pull-left p-r-10">
                                                        <em class="fa fa-bell-o noti-success"></em>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="media-heading">Updates</h5>
                                                        <p class="m-0">
                                                            <small>There are <span class="text-primary">2</span> new
                                                                updates available
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>

                                        </li>

                                        <li>
                                            <a href="javascript:void(0);" class=" text-right">
                                                <small><b>See all notifications</b></small>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light"><i
                                            class="md md-settings"></i>gagagag</a>
                                </li>-->
                                <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect waves-light">
                                        <i class="md md-home"></i>
                                        <b id="nombreGeneralLocal">{{$nombrelocal}}</b>
                                    </a>
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