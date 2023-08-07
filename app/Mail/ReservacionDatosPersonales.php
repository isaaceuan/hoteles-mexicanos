<?php namespace App\Mail;

use App;
use Illuminate\Mail\Mailable;

class ReservacionDatosPersonales extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $_reservacion;
    private $_datosActualizados;
    private $_datosAnteriores;
    private $_marca;
    private $_propiedad;
    private $_tipo;

    /**
     * ReservacionDatosPersonales constructor.
     *
     * @param $tipo
     * @param $marca
     * @param $propiedad
     * @param $reservacion
     * @param $datosActualizados
     * @param $datosAnteriores
     */
    public function __construct($tipo, $marca, $propiedad, $reservacion, $datosActualizados, $datosAnteriores)
    {
        $this->_tipo = $tipo;
        $this->_propiedad = $propiedad;
        $this->_marca = $marca;
        $this->_reservacion = $reservacion;
        $this->_datosActualizados = $datosActualizados;
        $this->_datosAnteriores = $datosAnteriores;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tituloCorreo = __('email.datos_modificados');

        if ($this->_tipo === 'huesped') {
            $via = $this->_propiedad->nombre;
            $vista = 'plantilla.reserva_datos_modificados';
        } else {
            $via = 'Easy-Rez®';
            $vista = 'plantilla.reserva_datos_modificados_copia';
        }
        $subject = $tituloCorreo . ' - ' . $this->_propiedad->nombre;
        $correo = $this->subject($subject)
            ->markdown($vista)
            ->from(env('MAIL_FROM_ADDRESS'), $via . ' via ' . env('MAIL_FROM_NAME'));

 
        $correo->with([
            'propiedad' => $this->_propiedad,
            'marca' => $this->_marca,
            'datosActualizado' => $this->_datosActualizados,
            'datosAnteriores' => $this->_datosAnteriores,
            'reserva' => $this->_reservacion,
            'dominio' => url('/') . '/' . app()->getLocale(),
        ]);

        return $correo;
    }
}
