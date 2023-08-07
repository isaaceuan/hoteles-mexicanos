<?php

Route::get('/estilos', 'BasicoController@estilos')->name('app.estilos');

Route::group(
    ['middleware' => 'preventBackHistory'],
    function ($route) {
        Route::get('/', 'BasicoController@inicio')->name('app.inicio');
        Route::get('/summary', 'BasicoController@resumen')->name('app.resumen');
        Route::get('/guest', 'BasicoController@informacion')->name('app.informacion');
        Route::post('/guest/save', 'BasicoController@informacionGuardar')->name('app.informacion.guardar');
        Route::get('/availability', 'BasicoController@disponibilidad')->name('app.disponibilidad');
        Route::get('/addons', 'BasicoController@complementos')->name('app.complementos');
    }
);

Route::group(
    ['middleware' => 'auth.modificar', 'prefix' => 'modify', 'preventBackHistory'],
    function ($route) {
        Route::get('/menu', 'ModificarController@menu')->name('modificar.menu');
        Route::get('/summary', 'ModificarController@resumenReserva')->name('modificar.resumen.reserva');
        Route::get('/guest', 'ModificarController@datosPersonales')->name('modificar.datos.personales');
        Route::get('/availability', 'ModificarController@disponibilidad')->name('modificar.disponibilidad');
        Route::get('/addons', 'ModificarController@complementos')->name('modificar.complementos');
        Route::get('/confirm', 'ModificarController@informacion')->name('modificar.informacion');
        Route::get('/cancel', 'ModificarController@reservaCancelar')->name('modificar.reserva.cancelar');
        Route::get('/cancelled', 'ModificarController@reservaCancelada')->name('modificar.reserva.cancelada');
        Route::get('/finish', 'ModificarController@reservaGuardada')->name('modificar.reserva.guardada');
    }
);
