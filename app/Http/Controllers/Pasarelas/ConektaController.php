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
 * Class ConektaController
 * @package App\Http\Controllers\Pasarelas
 */
class ConektaController extends Controller
{


    /**
     * Página de confirmacion de la reservacion creada con éxito tokenizada
     *
     * @return mixed
     */
    public function tokenConfirmada(Request $request)
    {

        \Log::debug('********************** ConektaController -> tokenConfirmada');
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
     * Página de generacion de ficha
     *
     * @return mixed
     */
    public function oxxoConfirmada(Request $request)
    {

        \Log::debug('********************** ConektaController -> oxxoConfirmada');
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
            $this->enviarCorreoNotificacionReferencia('oxxo', $formaPago, $marca, $propiedad, $configuracion->correos, $reservas);
            AppReservas::marcarCorreoEnviado();
        endif;
        return view(
            $url,
            [
                'propiedad' => $propiedad,
                'propiedadMotor' => $configuracion,
                'marca' => $marca,
                'monedas' => $monedas,
                'idiomas' => $idiomas,
                'reservas' => $reservas,
                'formapago' => $formaPago,
                'redireccion' => $redireccion,
            ]
        );
    }

    /**
     * Página de generacion de ficha
     *
     * @return mixed
     */
    public function speiConfirmada(Request $request)
    {

        \Log::debug('********************** ConektaController -> speiConfirmada');
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
            $this->enviarCorreoNotificacionReferencia('spei', $formaPago, $marca, $propiedad, $configuracion->correos, $reservas);
            AppReservas::marcarCorreoEnviado();
        endif;
        return view(
            $url,
            [
                'propiedad' => $propiedad,
                'propiedadMotor' => $configuracion,
                'marca' => $marca,
                'monedas' => $monedas,
                'idiomas' => $idiomas,
                'reservas' => $reservas,
                'formapago' => $formaPago,
                'redireccion' => $redireccion,
            ]
        );
    }

    /**
     * Página de confirmacion de la reservacion cancelada
     *
     * @return mixed
     */
    public function reservacionCancelada(Request $request)
    {
        \Log::debug('********************** PasarelaController -> reservacionCancelada');
        if (!AppReservas::existeSesion()):
            return redirect()->route('app.inicio');
        endif;
        AppCarrito::limpiar();
        AppReservas::terminarSesion();
        AppReservas::marcarCorreoEnviado();
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $monedas = AppMonedas::listar();
        $idiomas = AppIdiomas::listar();
        return view(
            AppSeleccionarTema::getURL('.') . '.reserva.cancelada',
            [
                'propiedad' => $propiedad,
                'marca' => $marca,
                'monedas' => $monedas,
                'idiomas' => $idiomas,
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

    /**
     * Obtiene la forma de pago para obtener su ficha de referencia para pagar
     *
     * @param $tipo
     * @param $formaPago
     * @param $marca
     * @param $propiedad
     * @param $correos
     * @param $reservaciones
     *
     * @throws \Exception
     */
    private function enviarCorreoNotificacionReferencia($tipo, $formaPago, $marca, $propiedad, $correos, $reservaciones)
    {
        AppCorreos::enviarCorreoPago($tipo, $formaPago, $marca, $propiedad, $correos, $reservaciones[0]);
    }
}
