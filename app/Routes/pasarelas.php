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

//PASARELAS CONFIRMACIONES


Route::get(
    '/finish',
    'Pasarelas\PasarelasController@reservacionConfirmada'
)->name('app.reservacion.confirmada');




Route::get(
    '/cancel',
    'Pasarelas\PasarelasController@reservacionCancelada'
)->name('app.reservacion.cancelada');

//
//Route::get(
//    '/finish/garantia/success',
//    'Pasarelas\GarantiaController@garantiaConfirmada'
//)->name('app.reservacion.garantia.confirmada');

//CONEKTA

//Route::get(
//    '/finish/conekta/token/success',
//    'Pasarelas\ConektaController@tokenConfirmada'
//)->name('app.reservacion.conekta.token.confirmada');
//
//
//Route::get(
//    '/finish/conekta/oxxo/success',
//    'Pasarelas\ConektaController@oxxoConfirmada'
//)->name('app.reservacion.conekta.oxxo.confirmada');
//
//Route::get(
//    '/finish/conekta/spei/success',
//    'Pasarelas\ConektaController@speiConfirmada'
//)->name('app.reservacion.conekta.spei.confirmada');

//OPENPAY

//
//Route::get(
//    '/finish/openpay/token/success',
//    'Pasarelas\OpenPayController@tokenConfirmada'
//)->name('app.reservacion.openpay.token.confirmada');
//
//Route::get(
//    '/finish/openpay/3dsecure/success',
//    'Pasarelas\OpenPayController@secure3dConfirmada'
//)->name('app.reservacion.openpay.3dsecure.confirmada');
//
//Route::get(
//    '/finish/openpay/3dsecure/cancel',
//    'Pasarelas\OpenPayController@secure3dCancelada'
//)->name('app.reservacion.openpay.3dsecure.cancelada');
//
//
//Route::get(
//    '/finish/openpay/tienda/success',
//    'Pasarelas\OpenPayController@tiendaConfirmada'
//)->name('app.reservacion.openpay.tienda.confirmada');
//
//
//Route::get(
//    '/finish/openpay/banco/success',
//    'Pasarelas\OpenPayController@bancoConfirmada'
//)->name('app.reservacion.openpay.banco.confirmada');


//STRIPE
//
//
//Route::get(
//    '/finish/stripe/token/success',
//    'Pasarelas\StripeController@tokenConfirmada'
//)->name('app.reservacion.stripe.token.confirmada');


//PAYPAL
//Route::get(
//    '/finish/paypal/paypal-plus/success',
//    'Pasarelas\PayPalController@plusConfirmada'
//)->name('app.reservacion.paypal.plus.confirmada');
//
//Route::get(
//    '/finish/paypal/paypal-checkout/success',
//    'Pasarelas\PayPalController@chekoutConfirmada'
//)->name('app.reservacion.paypal.chekout.confirmada');
//
//
//Route::get(
//    '/finish/paypal/paypal-checkout/cancel',
//    'Pasarelas\PayPalController@chekoutCancelada'
//)->name('app.reservacion.paypal.chekout.cancelada');

