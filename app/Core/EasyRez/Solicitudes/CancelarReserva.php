<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class CancelarReserva
 *
 * @package App\Core\EasyRez\Solicitudes
 */
class CancelarReserva extends EasyRez
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
        return $temp->post('cancelar-reserva', 'es', $data);
    }
}
