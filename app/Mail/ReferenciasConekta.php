<?php namespace App\Mail;

use App;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Mail\Mailable;

class ReferenciasConekta extends Mailable
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

        $pdf = PDF::loadView('plantilla.conekta.pdf_' . $this->_tipo,
            [
                'propiedad' => $this->_propiedad,
                'marca' => $this->_marca,
                'formapago' => $this->_formaPago
            ]);

        return $this
			->subject($subject)
            ->from(env('MAIL_FROM_ADDRESS'), $this->_propiedad->nombre . ' via ' . env('MAIL_FROM_NAME'))
            ->markdown('plantilla.conekta.email_' . $this->_tipo)
            ->attachData($pdf->output(), "referencia_" . $this->_tipo . ".pdf")
            ->with([
                'propiedad' => $this->_propiedad,
                'marca' => $this->_marca,
                'formapago' => $this->_formaPago
            ]);
    }
}
