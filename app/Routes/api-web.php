<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post(
	'/busqueda',
	'Api\BusquedaController@busqueda'
)->name('api.busqueda');

Route::post(
	'/impuestos',
	'Api\CatalogoController@impuestos'
)->name('api.impuestos');

Route::post(
	'/propinas',
	'Api\CatalogoController@propinas'
)->name('api.propinas');

Route::post(
	'/titulos',
	'Api\CatalogoController@titulos'
)->name('api.titulos');

Route::get(
	'/paises',
	'Api\CatalogoController@paises'
)->name('api.paises');

Route::post(
	'/reserva-crear',
	'Api\ReservaController@crear'
)->name('api.reserva.crear');

Route::post(
    '/reserva-modificar',
    'Api\ReservaController@modificar'
)->name('api.reserva.modificar');

Route::get(
    '/detalle-reserva/{id}',
    'Api\ReservaController@detalle'
)->name('api.reserva.detalle');

Route::get(
    '/detalle-reserva-modificada/{id}',
    'Api\ReservaController@detalleModificada'
)->name('api.reserva.detalle.modificada');

Route::post(
    '/reenviar-reservacion',
    'Api\ReservaController@reenviarReserva'
)->name('api.reserva.reenviar.correo');


Route::post(
    '/datos-personales',
    'Api\ReservaController@actualizarDatosPersonales'
)->name('api.reserva.actualizar.datos.personales');


Route::post(
	'/restricciones',
	'Api\RestriccionController@restricciones'
)->name('api.restricciones');

Route::post(
	'/restricciones-calendario',
	'Api\RestriccionController@restriccionesCalendario'
)->name('api.restricciones-calendario');

Route::post(
	'/cotizacion-multiple',
	'Api\CotizacionController@multiple'
)->name('api.cotizacion.multiple');

Route::post(
	'/cotizacion',
	'Api\CotizacionController@simple'
)->name('api.cotizacion.simple');

Route::post(
	'/carrito-resumen',
	'Api\CarritoController@resumen'
)->name('api.carrito.resumen');

Route::post(
	'/carrito-lista',
	'Api\CarritoController@lista'
)->name('api.carrito.lista');

Route::post(
	'/carrito-elemento-agregar',
	'Api\CarritoController@agregarElemento'
)->name('api.carrito.elemento.agregar');

Route::post(
	'/carrito-elemento-remover',
	'Api\CarritoController@removerElemento'
)->name('api.carrito.elemento.remover');

Route::post(
	'/carrito-complemento-agregar',
	'Api\CarritoController@agregarComplemento'
)->name('api.carrito.complemento.agregar');

Route::post(
	'/carrito-complemento-remover',
	'Api\CarritoController@removerComplemento'
)->name('api.carrito.complemento.remover');

Route::post(
	'/carrito-limpiar',
	'Api\CarritoController@limpiar'
)->name('api.carrito.remover.limpiar');

Route::post(
	'/complementos',
	'Api\ComplementoController@lista'
)->name('api.carrito.complemento');

Route::post(
	'/complemento-cotizar',
	'Api\ComplementoController@cotizar'
)->name('api.carrito.complemento.cotizar');

Route::get(
	'/moneda-actual',
	'Api\MonedaController@monedaActual'
)->name('api.moneda.actual');

Route::post(
	'/moneda-actual',
	'Api\MonedaController@cambiarMonedaActual'
)->name('api.cambiar.moneda.actual');

Route::post(
    '/preparar',
    'Api\PrepararController@prepararPago'
)->name('api.preparar.pago');


