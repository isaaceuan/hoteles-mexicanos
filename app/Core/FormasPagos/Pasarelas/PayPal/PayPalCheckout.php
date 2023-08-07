<?php


namespace App\Core\FormasPagos\Pasarelas\PayPal;

use App\Core\FormasPagos\Pasarelas\InstrumentoPago;

final class PayPalCheckout extends InstrumentoPago
{
    public function completarParametros(array &$parametros): void
    {
        $parametros['aprobacion_url'] = $this->getUrlDestino('finish');
        $parametros['cancelacion_url'] = $this->getUrlDestino('cancel');
    }

    public function getRedireccion($transaccion): string
    {
        return $transaccion->metadatos->pago_url;
    }
}
