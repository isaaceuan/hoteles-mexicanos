<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetFormasPago
 * @package App\Core\EasyRez\Solicitudes
 */
class GetFormasPago extends EasyRez
{
    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public static function ejecutar($idiomaId = 'es')
    {
        $temp = new self();
        return $temp->get('formas-pago', $idiomaId, ['with' => 'pasarela_pago']);
    }
}
