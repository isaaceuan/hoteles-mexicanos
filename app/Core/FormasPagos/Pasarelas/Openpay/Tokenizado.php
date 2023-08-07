<?php


namespace App\Core\FormasPagos\Pasarelas\Openpay;

use App\Core\FormasPagos\Pasarelas\InstrumentoPago;


final class Tokenizado extends InstrumentoPago
{
    public function getRedireccion($transaccion): string
    {
        return $this->getUrlDestino('finish');
    }
}
