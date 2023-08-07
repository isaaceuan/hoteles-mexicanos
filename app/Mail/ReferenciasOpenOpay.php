<?php namespace App\Mail;

use App;
use Illuminate\Mail\Mailable;

class ReferenciasOpenOpay extends Mailable
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $_formaPago;
    private $_reserva;
    private $_marca;
    private $_propiedad;
    private $_tipo;


    public function __construct($tipo, $formaPago, $marca, $propiedad, $reserva)
    {
        $this->_tipo = $tipo;
        $this->_formaPago = $formaPago;
        $this->_marca = $marca;
        $this->_propiedad = $propiedad;
        $this->_reserva = $reserva;

    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Referencia de pago - ' . $this->_propiedad->nombre;

        return $this->subject($subject)
			->from(env('MAIL_FROM_ADDRESS'), $this->_propiedad->nombre . ' via ' . env('MAIL_FROM_NAME'))
            ->markdown('plantilla.openpay.email_' . $this->_tipo)
            ->with([
                'propiedad' => $this->_propiedad,
                'marca' => $this->_marca,
                'formapago' => $this->_formaPago
            ]);
    }
}
