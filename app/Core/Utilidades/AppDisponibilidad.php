<?php

namespace App\Core\Utilidades;

use App;
use App\Core\Modelos\Disponibilidad\DisponibilidadTarifa;
use App\Core\Modelos\Disponibilidad\DisponibilidadTipoHabitacion;
use AppBusqueda;
use AppVisita;
use AppModificarReserva;
use App\Core\EasyRez\Solicitudes\GetDisponibilidad;
use Illuminate\Support\Facades\Log;

/**
 * Class AppDisponibilidad
 * @package App\Core\Utilidades
 */
class AppDisponibilidad
{
    /**
     * AppDisponibilidad constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param mixed $disponibilidad
     * @param boolean $porTarifa
     *
     * @return DisponibilidadTarifa[]|DisponibilidadTipoHabitacion[]
     */
    private function _cargarDisponibilidad($disponibilidad, $porTarifa)
    {
        $disponibilidadLista = [];
        if ($porTarifa):
            foreach ($disponibilidad as $tarifa):
                $disponibilidadLista[] = new DisponibilidadTarifa($tarifa);
            endforeach;
        else:
            foreach ($disponibilidad as $tipoHabitacion):
                $disponibilidadLista[] = new DisponibilidadTipoHabitacion($tipoHabitacion);
            endforeach;
        endif;
        return $disponibilidadLista;
    }

    /**
     * @param boolean $porTarifa
     *
     * @return App\Core\Modelos\Disponibilidad\DisponibilidadTarifa[]|App\Core\Modelos\Disponibilidad\DisponibilidadTipoHabitacion[]
     */
    private function _consultaMultiple($porTarifa)
    {
        $busqueda = AppBusqueda::recuperar();
        $reservaId = null;
        if (AppModificarReserva::existeSesion()) {
            $reservaId = AppModificarReserva::recuperarSesion()->id;
        }
        $disponibilidad = GetDisponibilidad::ejecutar(
            $busqueda->getLlegada(),
            $busqueda->getNoches(),
            $busqueda->getAdultos(),
            $busqueda->getNinos1(),
            $busqueda->getNinos2(),
            $busqueda->getNinos3(),
            $busqueda->getPromoCode(),
            $porTarifa,
            null,
            null,
            $reservaId,
            App::getLocale()
        );
        AppVisita::consultandoDisponibilidad(
            $busqueda->getLlegada(),
            $busqueda->getNoches(),
            $busqueda->getAdultos(),
            $busqueda->getNinos1(),
            $busqueda->getNinos2(),
            $busqueda->getNinos3(),
            $busqueda->getPromoCode()
        );
        return $this->_cargarDisponibilidad($disponibilidad, $porTarifa);
    }

    /**
     * @return App\Core\Modelos\Disponibilidad\DisponibilidadTarifa[]
     */
    public function consultaMultiplePorTarifa()
    {
        Log::debug('AppDisponibilidad -> consultaMultiplePorTarifa -> SDK');
        return $this->_consultaMultiple(true);
    }

    /**
     * @return App\Core\Modelos\Disponibilidad\DisponibilidadTipoHabitacion[]
     */
    public function consultaMultiplePorTipoHabitacion()
    {
        Log::debug('AppDisponibilidad -> consultaMultiplePorTipoHabitacion -> SDK');
        return $this->_consultaMultiple(false);
    }

    /**
     * @param int $adultos
     * @param int $ninos1
     * @param int $ninos2
     * @param int $ninos3
     * @param string $promoCode
     * @param int $tarifaId
     * @param int $tipoHabitacionId
     *
     * @return App\Core\Modelos\Disponibilidad\DisponibilidadTarifa[]
     * @throws \Exception
     */
    public function consultaSimplePorTarifa($adultos, $ninos1, $ninos2, $ninos3, $promoCode, $tarifaId, $tipoHabitacionId)
    {
        Log::debug('AppDisponibilidad -> consultaSimplePorTarifa -> SDK');
        $reservaId = null;
        if (AppModificarReserva::existeSesion()) {
            $reservaId = AppModificarReserva::recuperarSesion()->id;
        }
        $busqueda = AppBusqueda::recuperar();
        $disponibilidad = GetDisponibilidad::ejecutar(
            $busqueda->getLlegada(),
            $busqueda->getNoches(),
            $adultos,
            $ninos1,
            $ninos2,
            $ninos3,
            $promoCode,
            true,
            $tarifaId,
            $tipoHabitacionId,
            $reservaId,
            App::getLocale()
        );
        return $this->_cargarDisponibilidad($disponibilidad, true);
    }
}
