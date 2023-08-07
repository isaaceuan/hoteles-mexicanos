<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetPropinas
 * @package App\Core\EasyRez\Solicitudes
 */
class GetPropinas extends EasyRez
{
    /**
     * @param string $idiomaId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function ejecutar($idiomaId = 'es')
    {
        $temp = new self();
        return $temp->get('propinas', $idiomaId);
    }
}
