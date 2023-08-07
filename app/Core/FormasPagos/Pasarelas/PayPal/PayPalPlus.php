<?php


namespace App\Core\FormasPagos\Pasarelas\PayPal;

use App\Core\FormasPagos\Pasarelas\Cargo;
use App\Core\FormasPagos\Pasarelas\CargoResultado;
use App\Core\FormasPagos\Pasarelas\InstrumentoPago;


final class PayPalPlus extends InstrumentoPago
{
    public function prepararCargo(Cargo $cargo): CargoResultado
    {
        $solicitud = $cargo->getSolicitud(['accion' => 'crear-pago']);
        $respuesta = $this->enviarCargo($solicitud);
        return new CargoResultado($respuesta, '');
    }

    public function completarParametros(array &$parametros): void
    {
        $parametros['accion'] = 'ejecutar-pago';
    }

    public function getRedireccion($transaccion): string
    {
        return $this->getUrlDestino('finish');
    }
}
