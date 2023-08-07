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
 * Class OpenPayController
 * @package App\Http\Controllers
 */
class OpenPayController extends Controller
{

    /**
     * Página de confirmacion de la reservacion creada con éxito tokenizada
     *
     * @return mixed
     */
    public function tokenConfirmada(Request $request)
    {

        \Log::debug('********************** OpenPayController -> tokenConfirmada');
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
     * Página de confirmacion de la reservacion creada con éxito tokenizada con 3d secure
     *
     * @return mixed
     */
    public function secure3dConfirmada(Request $request)
    {

        \Log::debug('********************** OpenPayController -> secure3dConfirmada');
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
                'redireccion' => $redireccion
            ]
        );
    }

    /**
     * Página de cancelacion de 3d secure
     *
     * @return mixed
     */
    public function secure3dCancelada(Request $request)
    {

        \Log::debug('********************** OpenPayController -> secure3dCancelada');
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
     * Página de generacion de ficha
     *
     * @return mixed
     */
    public function tiendaConfirmada(Request $request)
    {

        \Log::debug('********************** OpenPayController -> tiendaConfirmada');
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
            $this->enviarCorreoNotificacionReferencia('tienda', $formaPago, $marca, $propiedad, $configuracion->correos, $reservas);
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
    public function bancoConfirmada(Request $request)
    {

        \Log::debug('********************** OpenPayController -> bancoConfirmada');
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
            $this->enviarCorreoNotificacionReferencia('banco', $formaPago, $marca, $propiedad, $configuracion->correos, $reservas);
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
        AppCorreos::enviarCorreoPagoTienda($tipo, $formaPago, $marca, $propiedad, $correos, $reservaciones[0]);
    }
}
