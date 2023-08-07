<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AppCorreos;
use AppMarca;
use AppPropiedad;

class WebHookController extends Controller
{
    const ACEPTADO = 'aceptado';
    const PENDIENTE = 'pendiente';
    const RECHAZADO = 'rechazado';

    const CONEKTA = 'conekta';
    const OPENPAY = 'openpay';
    const STRIPE = 'stripe';
    const PAYPAL = 'paypal';

    const TARJETA = 'tarjeta';
    const EFECTIVO = 'efectivo';
    const TRANSFERENCIA = 'transferencia';
//    const PAYPAL = 'paypal';


    /**
     * @param Request $request
     *
     */
    public function compras(Request $request)
    {
        $data = $request->all();
        $transaccion = json_decode(json_encode($data));
        $formaPago = $transaccion->transaccion->forma_pago->codigo;
        $estado = $transaccion->transaccion->estado;
        $pasararela = $transaccion->transaccion->pasarela_pago->codigo;

        if ($formaPago === self::EFECTIVO || $formaPago === self::TRANSFERENCIA || $formaPago === self::PAYPAL):
            if ($estado === self::ACEPTADO):
                $this->enviarCorreoConfirmacion($transaccion->reservaciones);
            elseif ($estado === self::RECHAZADO):
                \Log::debug('********************** WebHookController -> webhook -> enviar correo de cancelacion o falta de pago');
            endif;
        endif;
        \Log::debug('********************** WebHookController -> webhook' . json_encode($data));
        return response()->json('', 200);
    }


    public function enviarCorreoConfirmacion($reservaciones)
    {
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        foreach ($reservaciones as $reservacion):
            AppCorreos::enviarCorreoReservaNueva($marca, $propiedad, $reservacion);
            AppCorreos::enviarCorreoReservaNuevaCopia($marca, $propiedad, $reservacion, $configuracion->correos);
        endforeach;
        \Log::debug('********************** WebHookController -> enviarCorreoConfirmacion');
    }

    public function enviarCorreoExpiracion($transaccion)
    {
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $configuracion = AppPropiedad::recuperarConfiguracion();

//        AppCorreos::enviarCorreoReferenciaExpirada($marca, $propiedad, $reservacion, $configuracion->correos);

        \Log::debug('********************** WebHookController -> enviarCorreoExpiracion');
    }

}
