<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class EnviarCargo
 *
 * @package App\Core\EasyRez\Solicitudes
 */
class EnviarCargo extends EasyRez
{
    /**
     * @param string $pasarela
     * @param string $instrumento
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function ejecutar($pasarela, $instrumento, $data)
    {
        $temp = new self();
        return $temp->post('pasarelas-pago/' . $pasarela . '/' . $instrumento, 'es', $data);
    }
}
