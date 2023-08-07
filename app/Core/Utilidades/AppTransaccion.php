<?php

namespace App\Core\Utilidades;

use Session;

/**
 * Class AppTransaccion
 * @package App\Core
 */
class AppTransaccion
{
	private $_name;

	private $_nameEmail;

	/**
	 * AppUsuario constructor.
	 */
	public function __construct()
	{
		$this->_name = 'transaccion';
	}

	/**
	 * Verifica la existencia de una sesion
	 * @return bool
	 */
	public function existeSesion()
	{
		return Session::has($this->_name);
	}

	/**
	 * Almacena un usuario para la sesion
	 * @return mixed
	 */
	public function guardarSesion($datos)
	{
		Session::put($this->_name, $datos);
		return $datos;
	}

	/**
	 * Recupera la informacion del calendario
	 * @return mixed
	 */
	public function recuperarSesion()
	{
		return Session::get($this->_name, null);
	}

	/**
	 *  Termina la sesion
	 */
	public function terminarSesion()
	{
		if (Session::has($this->_name)):
			Session::forget($this->_name);
		endif;
	}
}
