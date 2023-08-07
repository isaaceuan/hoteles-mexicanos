<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/', 'modify/menu');
Route::get('/login', 'ModificarController@autenticacion')->name('modificar.login');
Route::post('/validacion', 'ModificarController@validacion')->name('modificar.validacion');

Route::group(['middleware' => 'auth.modificar'],
    function ($route) {
        Route::get('/salir', 'ModificarController@salir')->name('modificar.salir');
    }
);
