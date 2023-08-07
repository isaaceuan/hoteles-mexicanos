<?php

namespace App\Http\Controllers\Pasarelas;


use App\Core\EasyRez\Solicitudes\GetReserva;
use App\Http\Controllers\Controller;
use AppPropiedad;
use AppCarrito;
use AppCorreos;
use AppIdiomas;
use AppMarca;
use AppMonedas;
use AppReservas;
use AppTransaccion;
use AppSeleccionarTema;
use AppTitular;
use AppVisita;
use Illuminate\Http\Request;

/**
 * Class PasarelasController
 * @package App\Http\Controllers
 */
class PasarelasController extends Controller
{

    const SITIO = 'sitio';
    const ENLACE = 'url';
    const INICIO = 'sitio';


    public function getUrlRedireccion($configuracion, $propiedad)
    {

        if ($configuracion->redireccion_tipo === self::SITIO):
            return $propiedad->pagina_web;
        endif;
        if ($configuracion->redireccion_tipo === self::ENLACE):
            return $configuracion->redireccion_url;
        endif;
        return route('app.inicio', app()->getLocale(), false);
    }

    /**
     * valida la pasarela de pago para enviarte a la vista correspondiente.
     */
    public function reservacionConfirmada()
    {

        \Log::debug('********************** PasarelaController -> reservacionConfirmada');
        if (!AppReservas::existeSesion()):
            return redirect()->route('app.inicio');
        endif;

        AppCarrito::limpiar();
        AppTitular::_terminarSesion();
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $monedas = AppMonedas::listar();
        $idiomas = AppIdiomas::listar();
        $reservas = AppReservas::recuperarSesion();
        $configuracion = AppPropiedad::recuperarConfiguracion();

        $redireccion = $this->getUrlRedireccion($configuracion, $propiedad);

        $tipo = null;
        $formaPago = null;
        if (AppTransaccion::existeSesion()):
            $formaPago = AppTransaccion::recuperarSesion();
            $pasarela = $formaPago->pasarela_pago->codigo;
            $instrumento = $formaPago->instrumento_pago->codigo;
            $tipo = $formaPago->instrumento_pago->codigo;
            $url = AppSeleccionarTema::getURL('.') . '.formas_pagos.' . $pasarela . '.' . $instrumento . '.completado';
        else:
            $url = AppSeleccionarTema::getURL('.') . '.formas_pagos.garantia.completado';
        endif;
        if (AppReservas::correoNoEnviado()) {
            switch ($tipo) {
                case 'spei':
                case 'oxxo':
                    AppCorreos::enviarCorreoPago($tipo, $formaPago, $marca, $propiedad, $reservas[0]);
                    break;
                case 'banco':
                case 'tienda':
                    AppCorreos::enviarCorreoPagoTienda($tipo, $formaPago, $marca, $propiedad, $reservas[0]);
                    break;
                default:
                    $this->enviarCorreoNotificacion($reservas, $marca, $propiedad);
                    if (count($configuracion->correos) > 0):
                        $this->enviarCorreoNotificacionCopias($reservas, $marca, $propiedad, $configuracion->correos);
                    endif;
            }
            AppReservas::marcarCorreoEnviado();
        }

        AppVisita::visitandoCompletado();


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
     * Página de cancelacion reservacion
     *
     * @return mixed
     */
    public function reservacionCancelada(Request $request)
    {

        \Log::debug('********************** PasarelasController -> reservacionCancelada');
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
                'propiedadMotor' => $configuracion,
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
    private function enviarCorreoNotificacion($reservaciones, $marca, $propiedad)
    {
        foreach ($reservaciones as $reservacion):
            $detalleReserva = GetReserva::ejecutar($reservacion->id, app()->getLocale());
            AppCorreos::enviarCorreoReservaNueva($marca, $propiedad, $detalleReserva);
        endforeach;
    }

    /**
     * Obtiene las reservas id's para obtener su detalle y enviar las copias de los correos.
     *
     * @param $reservaciones
     * @param $marca
     * @param $propiedad
     * @param $correos
     *
     * @throws \Exception
     */
    private function enviarCorreoNotificacionCopias($reservaciones, $marca, $propiedad, $correos)
    {
        foreach ($reservaciones as $reservacion):
            $detalleReserva = GetReserva::ejecutar($reservacion->id, app()->getLocale());
            AppCorreos::enviarCorreoReservaNuevaCopia($marca, $propiedad, $detalleReserva, $correos);
        endforeach;
    }

}
