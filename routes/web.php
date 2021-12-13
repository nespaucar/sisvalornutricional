<?php

use Illuminate\Support\Facades\Auth;

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::get('logout', 'Auth\LoginController@logout');

//other routes

Route::group(['middleware' => 'guest'], function() {    
    //Password reset routes
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password','Auth\ResetPasswordController@showPasswordReset');
    Route::get('registro','Auth\RegisterController@showRegistrationForm');
    Route::post('registro', 'Auth\RegisterController@register');

    Route::get('/', function(){
        return View::make('principal.home');
    });
});

Route::get('mensualidad/envioBoletas', 'MensualidadController@envioBoletas')->name('mensualidad.envioBoletas');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function(){
        return View::make('principal.home');
    });

    /* CAMBIAR CONTRASEÑA*/
    Route::resource('updatepassword', 'UpdatePasswordController', array('except' => array('show')));

    /*ACTUALIZAR DATOS*/
    Route::resource('actualizardatos', 'ActualizarDatosController');

    /*USUARIO*/
    Route::post('usuario/buscar', 'UsuarioController@buscar')->name('usuario.buscar');
    Route::get('usuario/eliminar/{id}/{listarluego}', 'UsuarioController@eliminar')->name('usuario.eliminar');
    Route::resource('usuario', 'UsuarioController', array('except' => array('show')));

    /*CATEGORIA OPCION MENU*/
    Route::post('categoriaopcionmenu/buscar', 'CategoriaopcionmenuController@buscar')->name('categoriaopcionmenu.buscar');
    Route::get('categoriaopcionmenu/eliminar/{id}/{listarluego}', 'CategoriaopcionmenuController@eliminar')->name('categoriaopcionmenu.eliminar');
    Route::resource('categoriaopcionmenu', 'CategoriaopcionmenuController', array('except' => array('show')));

    /*OPCION MENU*/
    Route::post('opcionmenu/buscar', 'OpcionmenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionmenuController@eliminar')->name('opcionmenu.eliminar');
    Route::resource('opcionmenu', 'OpcionmenuController', array('except' => array('show')));

    /*TIPO DE USUARIO*/
    Route::post('tipousuario/buscar', 'TipousuarioController@buscar')->name('tipousuario.buscar');
    Route::get('tipousuario/obtenerpermisos/{listar}/{id}', 'TipousuarioController@obtenerpermisos')->name('tipousuario.obtenerpermisos');
    Route::post('tipousuario/guardarpermisos/{id}', 'TipousuarioController@guardarpermisos')->name('tipousuario.guardarpermisos');
    Route::get('tipousuario/eliminar/{id}/{listarluego}', 'TipousuarioController@eliminar')->name('tipousuario.eliminar');
    Route::resource('tipousuario', 'TipousuarioController', array('except' => array('show')));

    /* REPORTES */   
    Route::get('/generarcurriculum', 'PdfController@generarcurriculum')->name('generarcurriculum');

    /*LOCAL*/
    Route::post('local/buscar', 'LocalController@buscar')->name('local.buscar');
    Route::post('local/confirmaralterarestado', 'LocalController@confirmaralterarestado')->name('local.confirmaralterarestado');
    Route::get('local/alterarestado/{id}/{listarluego}/{estado}', 'LocalController@alterarestado')->name('local.alterarestado');
    Route::resource('local', 'LocalController', array('except' => array('show')));

    Route::get('setearlocal', 'UsuarioController@escogerlocal')->name('usuario.escogerlocal');
    Route::post('guardarlocal', 'UsuarioController@guardarlocal')->name('usuario.guardarlocal');
});

Route::get('storage/{archivo}', function ($archivo) {
     $public_path = storage_path();
     $url = $public_path.'/app/'.$archivo;print_r($url);
     //verificamos si el archivo existe y lo retornamos
     if (Storage::exists($archivo))
     {
       return response()->download($url);
     }
     //si no se encuentra lanzamos un error 404.
     abort(404);

});
