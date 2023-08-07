<?php


namespace App\Core\FormasPagos\Pasarelas\Stripe;

use App\Core\FormasPagos\Pasarelas\InstrumentoPago;


final class Tokenizado extends InstrumentoPago
{
    public function completarParametros(array &$parametros): void
    {
        $parametros['aprobacion_url'] = $this->getUrlDestino('finish');
        $parametros['cancelacion_url'] = $this->getUrlDestino('cancel');
    }

    public function getRedireccion($transaccion): string
    {
        if ($transaccion->estado == 'pendiente') {
            return $transaccion->metadatos->pago_url;
        }
        else {
            return $this->getUrlDestino('finish');
        }
    }
}
