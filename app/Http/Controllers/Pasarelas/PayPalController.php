<?php

namespace App\Http\Controllers\Pasarelas;

use App\Http\Controllers\Controller;
use AppCarrito;
use AppCorreos;
use AppIdiomas;
use AppMarca;
use AppMonedas;
use AppPropiedad;
use AppReservas;
use AppTransaccion;
use AppSeleccionarTema;

use App\Core\EasyRez\Solicitudes\GetReserva;
use Illuminate\Http\Request;

/**
 * Class PayPalController
 * @package App\Http\Controllers
 */
class PayPalController extends Controller
{

    /**
     * Página de confirmacion de la reservacion creada con éxito paypal plus
     *
     * @return mixed
     */
    public function plusConfirmada(Request $request)
    {

        \Log::debug('********************** PayPalController -> plusConfirmada');
        if (!AppReservas::existeSesion()):
            return redirect()->route('app.inicio');
        endif;

        $formaPago = AppTransaccion::recuperarSesion();
        $pasarela = $formaPago->pasarela_pago->codigo;
        $instrumento = $formaPago->instrumento_pago->codigo;
        $url = AppSeleccionarTema::getURL('.') . '.formas_pagos.' . $pasarela . '.' . $instrumento . '.completado';
        AppCarrito::limpiar();
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $monedas = AppMonedas::listar();
        $idiomas = AppIdiomas::listar();
        $reservas = AppReservas::recuperarSesion();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $redireccion = app(PasarelasController::class)->getUrlRedireccion($configuracion);
        if (AppReservas::correoNoEnviado()):
            $this->enviarCorreoNotificacion($reservas, $marca, $propiedad, $configuracion->correos);
            AppReservas::marcarCorreoEnviado();
        endif;
        return view(
            $url,
            [
                'propiedad' => $propiedad,
                'configuracion' => $configuracion,
                'marca' => $marca,
                'monedas' => $monedas,
                'idiomas' => $idiomas,
                'reservas' => $reservas,
                'redireccion' => $redireccion,
            ]
        );
    }

 /**
     * Página de confirmacion de la reservacion creada con éxito paypal checkout
     *
     * @return mixed
     */
    public function chekoutConfirmada(Request $request)
    {

        \Log::debug('********************** PayPalController -> chekoutConfirmada');
        if (!AppReservas::existeSesion()):
            return redirect()->route('app.inicio');
        endif;

        $formaPago = AppTransaccion::recuperarSesion();
        $pasarela = $formaPago->pasarela_pago->codigo;
        $instrumento = $formaPago->instrumento_pago->codigo;
        $url = AppSeleccionarTema::getURL('.') . '.formas_pagos.' . $pasarela . '.' . $instrumento . '.completado';
        AppCarrito::limpiar();
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $monedas = AppMonedas::listar();
        $idiomas = AppIdiomas::listar();
        $reservas = AppReservas::recuperarSesion();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $redireccion = app(PasarelasController::class)->getUrlRedireccion($configuracion);
        if (AppReservas::correoNoEnviado()):
            $this->enviarCorreoNotificacion($reservas, $marca, $propiedad, $configuracion->correos);
            AppReservas::marcarCorreoEnviado();
        endif;
        return view(
            $url,
            [
                'propiedad' => $propiedad,
                'configuracion' => $configuracion,
                'marca' => $marca,
                'monedas' => $monedas,
                'idiomas' => $idiomas,
                'reservas' => $reservas,
                'redireccion' => $redireccion,
            ]
        );
    }


    /**
     * Página de cancelacion de paypal checkOut
     *
     * @return mixed
     */
    public function chekoutCancelada(Request $request)
    {

        \Log::debug('********************** PayPalController -> chekoutCancelada');
        if (!AppReservas::existeSesion()):
            return redirect()->route('app.inicio');
        endif;

        $formaPago = AppTransaccion::recuperarSesion();
        $pasarela = $formaPago->pasarela_pago->codigo;
        $instrumento = $formaPago->instrumento_pago->codigo;
        $url = AppSeleccionarTema::getURL('.') . '.formas_pagos.' . $pasarela . '.' . $instrumento . '.cancelada';
        AppCarrito::limpiar();
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $monedas = AppMonedas::listar();
        $idiomas = AppIdiomas::listar();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        return view(
            $url,
            [
                'propiedad' => $propiedad,
                'configuracion' => $configuracion,
                'marca' => $marca,
                'monedas' => $monedas,
                'idiomas' => $idiomas
            ]
        );
    }


    /**
     * Obtiene las reservas id's para obtener su detalle y enviar por separado los correos.
     *
     * @param $reservaciones
     * @param $marca
     * @param $propiedad
     * @param $correos
     *
     * @throws \Exception
     */
    private function enviarCorreoNotificacion($reservaciones, $marca, $propiedad, $correos)
    {
        foreach ($reservaciones as $reservacion):
            $detalleReserva = GetReserva::ejecutar($reservacion->id, app()->getLocale());
            AppCorreos::enviarCorreoReservaNueva($marca, $propiedad, $detalleReserva, $correos);
        endforeach;
    }

}
