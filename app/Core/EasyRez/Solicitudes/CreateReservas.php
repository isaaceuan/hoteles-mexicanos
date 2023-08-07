<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class CreateReservas
 *
 * @package App\Core\EasyRez\Solicitudes
 */
class CreateReservas extends EasyRez
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
        return $temp->post('crear-reservas', 'es', $data);
    }
}
