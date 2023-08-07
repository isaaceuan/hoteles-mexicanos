<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class ActualizarReserva
 *
 * @package App\Core\EasyRez\Solicitudes
 */
class ActualizarReserva extends EasyRez
{
    /**
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function ejecutar($data)
    {
        $temp = new self();
        return $temp->post('actualizar-reserva', 'es', $data);
    }
}
