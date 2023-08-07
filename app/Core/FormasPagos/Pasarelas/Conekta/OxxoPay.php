<?php

namespace App\Core\FormasPagos\Pasarelas\Conekta;

use App\Core\FormasPagos\Pasarelas\InstrumentoPago;
use Illuminate\Support\Facades\Facade;

final class OxxoPay extends InstrumentoPago
{
    private const HORAS_VIGENCIA = 3;

    public function completarParametros(array &$parametros): void
    {
        $parametros['caducidad'] = date('c', time() + (self::HORAS_VIGENCIA * 60 * 60));
    }

    public function getRedireccion($transaccion): string
    {
        return $this->getUrlDestino('finish');
    }
}
