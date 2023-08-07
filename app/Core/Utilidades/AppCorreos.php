<?php

namespace App\Core\Utilidades;


use App\Mail\ReferenciasConekta;
use App\Mail\ReferenciasOpenOpay;
use App\Mail\Reservacion;
use App\Mail\ReservacionCopia;
use App\Mail\ReservacionDatosPersonales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use stdClass;

/**
 * Class AppCorreos
 * @package App\Core\Utilidades
 */
class AppCorreos
{
    public function mail(Request $request)
    {
        Mail::raw('mensaje', function (Message $message) use ($request) {
            $message
                ->to('mikebizne@gmail.com')
                ->subject('asunto');
        });
    }


    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @return mixed|string
     */
    public function enviarCorreoReservaNueva($marca, $propiedad, $reserva)
    {
        $peticion = null;
        $receptores = [];
        $receptores[] = $reserva->huesped->contacto->correo;
        try {
            $peticion = Mail::to($receptores);
            $peticion->send(new Reservacion('Nuevo', $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $receptores);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @param $correos
     * @return mixed|string
     */
    public function enviarCorreoReservaNuevaCopia($marca, $propiedad, $reserva, $correos)
    {
        $peticion = null;
        $copias = [];
        $cont = 0;
        if (!empty($correos)):
            foreach ($correos as $correo):
                $copias[] = $correo->correo;
                $cont++;
            endforeach;
        endif;
        try {
            $peticion = Mail::to($copias);
            $peticion->send(new ReservacionCopia('Nuevo', $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $copias);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @return mixed|string
     */
    public function enviarCorreoReservaModificada($marca, $propiedad, $reserva)
    {
        $peticion = null;
        $receptores = [];
        $receptores[] = $reserva->huesped->contacto->correo;
        try {
            $peticion = Mail::to($receptores);
            $peticion->send(new Reservacion('Modificado', $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $receptores);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @param $correos
     * @return mixed|string
     */
    public function enviarCorreoReservaModificadaCopia($marca, $propiedad, $reserva, $correos)
    {
        $peticion = null;
        $copias = [];
        $cont = 0;
        if (!empty($correos)):
            foreach ($correos as $correo):
                $copias[] = $correo->correo;
                $cont++;
            endforeach;
        endif;
        try {
            $peticion = Mail::to($copias);
            $peticion->send(new ReservacionCopia('Modificado', $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $copias);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @return mixed|string
     */
    public function enviarCorreoReservaCancelada($marca, $propiedad, $reserva)
    {
        $peticion = null;
        $receptores = [];
        $receptores[] = $reserva->huesped->contacto->correo;
        try {
            $peticion = Mail::to($receptores);
            $peticion->send(new Reservacion('Cancelado', $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $receptores);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @param $correos
     * @return mixed|string
     */
    public function enviarCorreoReservaCanceladaCopia($marca, $propiedad, $reserva, $correos)
    {
        $peticion = null;
        $copias = [];
        $cont = 0;
        if (!empty($correos)):
            foreach ($correos as $correo):
                $copias[] = $correo->correo;
                $cont++;
            endforeach;
        endif;
        try {
            $peticion = Mail::to($copias);
            $peticion->send(new ReservacionCopia('Cancelado', $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $copias);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }


    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @param $datosActualizados
     * @param $datosAnteriores
     * @return mixed|string
     */
    public function enviarCorreoReservaDatosModificados($marca, $propiedad, $reserva, $datosActualizados, $datosAnteriores)
    {
        $peticion = null;
        $receptores = [];
        $receptores[] = $reserva->huesped->contacto->correo;
        try {
            $peticion = Mail::to($receptores);
            $peticion->send(new ReservacionDatosPersonales('huesped', $marca, $propiedad, $reserva, $datosActualizados, $datosAnteriores));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $receptores);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $marca
     * @param $propiedad
     * @param $reserva
     * @param $datosActualizados
     * @param $datosAnteriores
     * @param $correos
     * @return mixed|string
     */
    public function enviarCorreoReservaDatosModificadosCopias($marca, $propiedad, $reserva, $datosActualizados, $datosAnteriores, $correos)
    {
        $peticion = null;
        $copias = [];
        $cont = 0;
        if (!empty($correos)):
            foreach ($correos as $correo):
                $copias[] = $correo->correo;
                $cont++;
            endforeach;
        endif;
        try {
            $peticion = Mail::to($copias);
            $peticion->send(new ReservacionDatosPersonales('propiedad', $marca, $propiedad, $reserva, $datosActualizados, $datosAnteriores));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), $copias);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $tipo
     * @param $formaPago
     * @param $marca
     * @param $propiedad
     * @param $correos
     * @param $reserva
     * @return mixed|string
     */
    public function enviarCorreoPago($tipo, $formaPago, $marca, $propiedad, $reserva)
    {
        $peticion = null;
        $receptores = [];
        $receptores[] = $reserva->huesped->contacto->correo;
        try {
            $peticion = Mail::to($receptores);
            $peticion->send(new ReferenciasConekta($tipo, $formaPago, $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), ["receptores" => $receptores, "tipo" => $tipo]);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    /**
     * @param $tipo
     * @param $formaPago
     * @param $marca
     * @param $propiedad
     * @param $correos
     * @param $reserva
     * @return mixed|string
     */
    public function enviarCorreoPagoTienda($tipo, $formaPago, $marca, $propiedad, $reserva)
    {
        $peticion = null;
        $receptores = [];
        $receptores[] = $reserva->huesped->contacto->correo;
        try {
            $peticion = Mail::to($receptores);
            $peticion->send(new ReferenciasOpenOpay($tipo, $formaPago, $marca, $propiedad, $reserva));
            $this->_mailFailed();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage(), ["receptores" => $receptores, "tipo" => $tipo]);
            $peticion = $e->getMessage();
        }
        return $peticion;
    }

    private function _mailFailed()
    {
        if (!empty(Mail::failures())) {
            \Log::warning('Error mandar correo', Mail::failures());
        }
    }
}
