<?php namespace App\Mail;

use App;
use Illuminate\Mail\Mailable;

class ReservacionCopia extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $_reserva;
    private $_marca;
    private $_propiedad;
    private $_tipoReservacion;

    public function __construct($tipo, $marca, $propiedad, $reserva)
    {
        $this->_reserva = $reserva;
        $this->_tipoReservacion = $tipo;
        $this->_propiedad = $propiedad;
        $this->_marca = $marca;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tituloCorreo = '';
        $plantilla = '';

        switch ($this->_tipoReservacion) {
            case 'Nuevo':
                $tituloCorreo = __('email.nueva_reservacion');
                $plantilla = 'plantilla.reserva_nueva_copia';
                break;
           case 'Modificado':
                $tituloCorreo = __('email.modificada_reservacion');
                $plantilla = 'plantilla.reserva_modificada_copia';
                break;
            case 'Cancelado':
                $tituloCorreo = __('email.cancelacion_reservacion');
                $plantilla = 'plantilla.reserva_cancelada_copia';
                break;
        }
        $subject = $tituloCorreo. ' - ' . $this->_propiedad->nombre . ' (' . $this->_reserva->fecha_entrada . ') - ' . $this->_reserva->folio;

        $detalleReserva = $this->_reserva;
        $complementosIncluidos = [];
        $complementosAdicionales = [];
        $promociones = [];
        $habitacion = [];
        $habitacion['moneda_id'] = $this->_reserva->moneda_id;
        $habitacion['nombre'] = $detalleReserva->detalle_actual->tipo_habitacion->nombre;
        $habitacion['total_sin_imp'] = $detalleReserva->total_hospedaje + $detalleReserva->total_alimentos;
        $habitacion['total_anticipo'] = $detalleReserva->total_anticipo;
        $habitacion['total'] = $detalleReserva->total;
        $habitacion['saldo'] = $detalleReserva->total - $detalleReserva->total_anticipo;
        $habitacion['total_impuestos'] = $detalleReserva->total_impuestos + $detalleReserva->total_propinas;


        $tarifa = [];
        $tarifa['nombre'] = $detalleReserva->tarifa->nombre;
        $tarifa['descripcion'] = $detalleReserva->tarifa->descripcion;
        $tarifa['plan_alimento_id'] = $detalleReserva->plan_alimento_id;

        $tarifa['plan_alimento']['nombre'] = ($detalleReserva->plan_alimento) ? $detalleReserva->plan_alimento->nombre : null;
        $tarifa['plan_alimento']['descripcion'] = ($detalleReserva->plan_alimento) ? $detalleReserva->plan_alimento->descripcion : null;
        $tarifa['regla_cancelacion'] = $detalleReserva->regla_cancelacion;
        $tarifa['regla_modificacion'] = $detalleReserva->regla_modificacion;
        $totalComplementosIncluidos = 0;
        $totalComplementosAdicionales = 0;
        foreach ($detalleReserva->complementos as $complemento):
            if ($complemento->incluido):
                $complementosIncluidos[$complemento->complemento_id] = $complemento;
                $totalComplementosIncluidos += $complemento->importe;
            else:
                if (isset($complementosAdicionales[$complemento->complemento_id])) {
                    $complementosAdicionales[$complemento->complemento_id]['total_sin_imp'] += $complemento->importe;
                    $complementosAdicionales[$complemento->complemento_id]['nombre'] = $complemento->complemento->nombre;
                    $complementosAdicionales[$complemento->complemento_id]['cantidad'] += $complemento->cantidad;
                } else {
                    $complementosAdicionales[$complemento->complemento_id] = [
                        'total_sin_imp' => $complemento->importe,
                        'nombre' => $complemento->complemento->nombre,
                        'cantidad' => $complemento->cantidad,
                    ];
                }
                $totalComplementosAdicionales += $complemento->importe;
            endif;
        endforeach;
        if ($detalleReserva->total_descuentos > 0) {
            foreach ($detalleReserva->detalles as $detalle) {
                if ($detalle->promocion_id > 0) {
                    $promociones[$detalle->promocion_id] = $detalle->promocion;
                }
            }
        }
        $habitacion['total_sin_imp'] += $totalComplementosIncluidos;
        $habitacion['subtotal'] = $habitacion['total_sin_imp'] + $totalComplementosAdicionales;

        return $this
			->subject($subject)
			->from(env('MAIL_FROM_ADDRESS'),   'Easy-Rez® via ' . env('MAIL_FROM_NAME'))
            ->markdown($plantilla)
            ->with([
                'propiedad' => $this->_propiedad,
                'marca' => $this->_marca,
                'reserva' => $this->_reserva,
                'complementosIncluidos' => $complementosIncluidos,
                'complementosAdicionales' => $complementosAdicionales,
                'detalle' => $habitacion,
                'promociones' => $promociones,
                'tarifa' => $tarifa]);
    }
}
