<?php


namespace App\Core\FormasPagos\Pasarelas\Openpay;

use App\Core\FormasPagos\Pasarelas\InstrumentoPago;

final class Secure3d extends InstrumentoPago
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
