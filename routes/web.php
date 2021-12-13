<?php

use Illuminate\Support\Facades\Auth;

//other routes

Route::group(['middleware' => 'guest'], function() {
    //Password reset routes
    Route::get('/', function() {
        return view('auth.login');
    });
    Route::get('password/reset', function() {
        return view('auth.forgotPassword');
    });
    Route::post('password/recuperarPassword', 'RecuperarContrasenaController@recuperarPassword');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function(){
        return View::make('principal.home');
    });

    /*GENERALES*/
    Route::get('persona/personasautocompleting/{searching}', 'PersonaController@personasautocompleting')->name('persona.personasautocompleting');
    Route::get('setearlocal', 'UsuarioController@escogerlocal')->name('usuario.escogerlocal');
    Route::post('guardarlocal', 'UsuarioController@guardarlocal')->name('usuario.guardarlocal');
    Route::get('persona/buscarDNIMercader', 'PersonaController@buscarDNIMercader')->name('persona.buscarDNIMercader');
    Route::get('persona/cargarDetallesConceptosPagosDeMercader', 'PersonaController@cargarDetallesConceptosPagosDeMercader')->name('persona.cargarDetallesConceptosPagosDeMercader');   

    /*CAMBIAR CONTRASEÑA*/
    Route::resource('updatepassword', 'UpdatePasswordController', array('except' => array('show')));

    /*ACTUALIZAR DATOS*/
    Route::resource('actualizardatos', 'ActualizarDatosController');
    Route::get('actualizardatosavatar', 'ActualizarDatosController@actualizardatosavatar');

    /*USUARIO*/
    Route::post('usuario/buscar', 'UsuarioController@buscar')->name('usuario.buscar');
    Route::get('usuario/eliminar/{id}/{listarluego}', 'UsuarioController@eliminar')->name('usuario.eliminar');
    Route::resource('usuario', 'UsuarioController', array('except' => array('show')));

    /*CATEGORIA OPCION MENU*/
    Route::post('menuoptioncategory/buscar', 'MenuoptioncategoryController@buscar')->name('menuoptioncategory.buscar');
    Route::get('menuoptioncategory/eliminar/{id}/{listarluego}', 'MenuoptioncategoryController@eliminar')->name('menuoptioncategory.eliminar');
    Route::resource('menuoptioncategory', 'MenuoptioncategoryController', array('except' => array('show')));

    /*OPCION MENU*/
    Route::post('menuoption/buscar', 'MenuoptionController@buscar')->name('menuoption.buscar');
    Route::get('menuoption/eliminar/{id}/{listarluego}', 'MenuoptionController@eliminar')->name('menuoption.eliminar');
    Route::resource('menuoption', 'MenuoptionController', array('except' => array('show')));

    /*BITÁCORA*/
    Route::post('bitacora/buscar', 'BitacoraController@buscar')->name('bitacora.buscar');
    Route::resource('bitacora', 'BitacoraController', array('except' => array('show')));

    /*TIPO DE USUARIO*/
    Route::post('usertype/buscar', 'UsertypeController@buscar')->name('usertype.buscar');
    Route::get('usertype/obtenerpermisos/{listar}/{id}', 'UsertypeController@obtenerpermisos')->name('usertype.obtenerpermisos');
    Route::post('usertype/guardarpermisos/{id}', 'UsertypeController@guardarpermisos')->name('usertype.guardarpermisos');
    Route::get('usertype/eliminar/{id}/{listarluego}', 'UsertypeController@eliminar')->name('usertype.eliminar');
    Route::resource('usertype', 'UsertypeController', array('except' => array('show')));

    /*LOCAL*/
    Route::post('local/buscar', 'LocalController@buscar')->name('local.buscar');
    Route::post('local/confirmaralterarestado', 'LocalController@confirmaralterarestado')->name('local.confirmaralterarestado');
    Route::get('local/alterarestado/{id}/{listarluego}/{estado}', 'LocalController@alterarestado')->name('local.alterarestado');
    Route::resource('local', 'LocalController', array('except' => array('show')));    

    /*CONCEPTO DE PAGO*/
    Route::post('conceptopago/buscar', 'ConceptopagoController@buscar')->name('conceptopago.buscar');
    Route::get('conceptopago/eliminar/{id}/{listarluego}', 'ConceptopagoController@eliminar')->name('conceptopago.eliminar');
    Route::resource('conceptopago', 'ConceptopagoController', array('except' => array('show')));

    /*COMISIONISTA*/
    Route::post('comisionista/buscar', 'ComisionistaController@buscar')->name('comisionista.buscar');
    Route::get('comisionista/eliminar/{id}/{listarluego}', 'ComisionistaController@eliminar')->name('comisionista.eliminar');
    Route::resource('comisionista', 'ComisionistaController', array('except' => array('show')));

    /*MERCADER*/
    Route::post('mercader/buscar', 'MercaderController@buscar')->name('mercader.buscar');
    Route::get('mercader/eliminar/{id}/{listarluego}', 'MercaderController@eliminar')->name('mercader.eliminar');
    Route::get('mercader/getMonto', 'MercaderController@getMonto')->name('mercader.getMonto');
    Route::resource('mercader', 'MercaderController', array('except' => array('show')));

    /*COBRO*/
    Route::post('cobro/buscar', 'CobroController@buscar')->name('cobro.buscar');
    Route::get('cobro/eliminar/{id}', 'CobroController@eliminar')->name('cobro.eliminar');
    Route::get('cobro/getMonto', 'CobroController@getMonto')->name('cobro.getMonto');
    Route::resource('cobro', 'CobroController', array('except' => array('show')));
    Route::post('cobro/addPagoCuota', 'CobroController@addPagoCuota')->name('cobro.addPagoCuota');
    Route::post('cobro/deletePagoCuota', 'CobroController@deletePagoCuota')->name('cobro.deletePagoCuota');
    Route::post('cobro/editPagoCuota', 'CobroController@editPagoCuota')->name('cobro.editPagoCuota');
    Route::get('cobro/verDetalles', 'CobroController@verDetalles')->name('cobro.verDetalles');

    /*PAGO*/
    Route::post('pago/buscar', 'PagoController@buscar')->name('pago.buscar');
    Route::resource('pago', 'PagoController', array('except' => array('show')));

    /*DEUDA*/
    Route::post('deuda/buscar', 'DeudaController@buscar')->name('deuda.buscar');
    Route::resource('deuda', 'DeudaController', array('except' => array('show')));

    /*REPORTES*/
    Route::get('bitacorareporte', 'ReporteController@bitacorareporte', array('except' => array('show')));
    Route::post('reporte/listarbitacorareporte', 'ReporteController@listarbitacorareporte')->name('reporte.listarbitacorareporte');
    Route::get('mercaderreporte', 'ReporteController@mercaderreporte', array('except' => array('show')));
    Route::post('reporte/listarmercaderreporte', 'ReporteController@listarmercaderreporte')->name('reporte.listarmercaderreporte');
    Route::get('ingresoreporte', 'ReporteController@ingresoreporte', array('except' => array('show')));
    Route::post('reporte/listaringresoreporte', 'ReporteController@listaringresoreporte')->name('reporte.listaringresoreporte');
    Route::get('estadocuentareporte', 'ReporteController@estadocuentareporte', array('except' => array('show')));
    Route::post('reporte/listarestadocuentareporte', 'ReporteController@listarestadocuentareporte')->name('reporte.listarestadocuentareporte');

    /*REPORTES EXCEL Y PDF*/
    Route::get('exportarbitacorareporteE', 'ExcelController@exportarbitacorareporteE')->name('excel.exportarbitacorareporteE');
    Route::get('exportarbitacorareporteP', 'PdfController@exportarbitacorareporteP')->name('pdf.exportarbitacorareporteP');
    Route::get('exportarmercaderreporteE', 'ExcelController@exportarmercaderreporteE')->name('excel.exportarmercaderreporteE');
    Route::get('exportarmercaderreporteP', 'PdfController@exportarmercaderreporteP')->name('pdf.exportarmercaderreporteP');
    Route::get('exportaringresoreporteE', 'ExcelController@exportaringresoreporteE')->name('excel.exportaringresoreporteE');
    Route::get('exportaringresoreporteP', 'PdfController@exportaringresoreporteP')->name('pdf.exportaringresoreporteP');
    Route::get('exportarestadocuentareporteE', 'ExcelController@exportarestadocuentareporteE')->name('excel.exportarestadocuentareporteE');
    Route::get('exportarestadocuentareporteP', 'PdfController@exportarestadocuentareporteP')->name('pdf.exportarestadocuentareporteP');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('principal.home');
})->name('principal.home');
