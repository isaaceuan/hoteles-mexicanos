<?php


namespace App\Core\FormasPagos\Pasarelas\Openpay;

use App\Core\FormasPagos\Pasarelas\InstrumentoPago;



final class PagoEnBanco extends InstrumentoPago
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
