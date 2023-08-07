<?php

namespace App\Core\Utilidades;

use Session;

/**
 * Class AppTitular
 * @package App\Core\Utilidades
 */
class AppTitular
{
	/**
	 * @var string
	 */
	private string $_nombreSesion;

	/**
	 * AppVisita constructor.
	 */
	public function __construct()
	{
		$this->_nombreSesion = 'titularV1';
	}

	/**
	 * @return bool
	 */
	public function _existeSesion()
	{
		return Session::has($this->_nombreSesion);
	}

	/**
	 * @param mixed $datos
	 *
	 * @return int
	 */
	public function _guardarSesion($datos)
	{
		Session::put($this->_nombreSesion, $datos);
		return $datos;
	}

	/**
	 * @return mixed|null
	 */
	public function _recuperarSesion()
	{
		return Session::get($this->_nombreSesion);
	}

	/**
	 */
	public function _terminarSesion()
	{
		if (Session::has($this->_nombreSesion)):
			Session::forget($this->_nombreSesion);
		endif;
	}
}
