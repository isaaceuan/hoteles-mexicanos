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
 * Class GarantiaController
 * @package App\Http\Controllers\Pasarelas
 */
class GarantiaController extends Controller
{


    /**
     * Página de confirmacion de la reservacion creada con éxito tokenizada
     *
     * @return mixed
     */
    public function garantiaConfirmada(Request $request)
    {

        \Log::debug('********************** GarantiaController -> garantiaConfirmada');
        if (!AppReservas::existeSesion()):
            return redirect()->route('app.inicio');
        endif;

        $url = AppSeleccionarTema::getURL('.') . '.formas_pagos.garantia.completado';
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
//            $detalleReserva = GetReserva::ejecutar($reservacion->id, app()->getLocale());
            AppCorreos::enviarCorreoReservaNueva($marca, $propiedad, $reservacion, $correos);
        endforeach;
    }
}
