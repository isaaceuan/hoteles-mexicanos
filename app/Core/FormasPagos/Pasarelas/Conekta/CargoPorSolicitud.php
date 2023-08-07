<?php

namespace App\Core\FormasPagos\Pasarelas\Conekta;

use App\Core\FormasPagos\Pasarelas\InstrumentoPago;
use Illuminate\Support\Facades\Facade;

/**
 * Class CargoPorSolicitud
 * @package App\Facades\FormasPagos\Pasarelas\Conekta
 */
final class CargoPorSolicitud extends InstrumentoPago
{
    public function getRedireccion(object $transaccion): string
    {
        return $this->getUrlDestino('finish');
    }
}
