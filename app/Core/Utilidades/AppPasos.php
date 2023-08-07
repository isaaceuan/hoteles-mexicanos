<?php

namespace App\Core\Utilidades;

use Session;

/**
 * Class AppPasos
 * @package App\Core\Utilidades
 */
class AppPasos
{
	/**
	 * @var string $_nombreSesion
	 */
	private $_nombreSesion;
	
	/**
	 * AppCarrito constructor.
	 */
	public function __construct()
	{
		$this->_nombreSesion = 'pasos';
	}
	
	public function marcarPaso0()
	{
		Session::put($this->_nombreSesion, '0');
	}
	
	public function marcarPaso1()
	{
		Session::put($this->_nombreSesion, '1');
	}
	
	public function marcarPaso2()
	{
		Session::put($this->_nombreSesion, '2');
	}
	
	public function marcarPaso3()
	{
		Session::put($this->_nombreSesion, '3');
	}
	
	public function marcarPaso4()
	{
		Session::put($this->_nombreSesion, '4');
	}
	
	public function enPaso0()
	{
		if (!$this->_existeSesion()) return false;
		return $this->_recuperarSesion() === '0';
	}
	
	public function enPaso1()
	{
		if (!$this->_existeSesion()) return false;
		return $this->_recuperarSesion() === '1';
	}
	
	public function enPaso2()
	{
		if (!$this->_existeSesion()) return false;
		return $this->_recuperarSesion() === '2';
	}
	
	public function enPaso3()
	{
		if (!$this->_existeSesion()) return false;
		return $this->_recuperarSesion() === '3';
	}
	
	public function enPaso4()
	{
		if (!$this->_existeSesion()) return false;
		return $this->_recuperarSesion() === '4';
	}
	
	/**
	 * @return bool
	 */
	private function _existeSesion()
	{
		return Session::has($this->_nombreSesion);
	}
	
	/**
	 * @return string
	 */
	private function _recuperarSesion()
	{
		return Session::get($this->_nombreSesion);
	}
}
