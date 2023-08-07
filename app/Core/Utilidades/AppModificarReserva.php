<?php

namespace App\Core\Utilidades;

use Session;

/**
 * Class AppModificarReserva
 * @package App\Core\Utilidades
 */
class AppModificarReserva
{
    /**
     * Nombre de la variable de sesion para la cuenta del back
     * @var string $_name
     */
    private $_name;

    /**
     * AppUsuario constructor.
     */
    public function __construct()
    {
        $this->_name = 'bookModify';
    }

    /**
     * Verifica la existencia de una sesion en el back
     * @return bool
     */
    public function existeSesion()
    {
        return Session::has($this->_name);
    }

    /**
     * Almacena la reserva a modificar para la sesion
     * @param $cuenta
     * @return mixed
     */
    public function guardarSesion($cuenta)
    {
        Session::put($this->_name, $cuenta);
        return $cuenta;
    }

    /**
     * Recupera la cuenta del usuario en el back
     * @return Session | null
     */
    public function recuperarSesion()
    {
        return Session::get($this->_name, null);
    }

    /**
     *  Termina la sesion en el back
     */
    public function terminarSesion()
    {
        if (Session::has($this->_name)):
            Session::forget($this->_name);
        endif;
    }
}
