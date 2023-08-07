<?php

namespace App\Core\Utilidades;

use Session;

/**
 * Class AppCarrito
 * @package App\Core\Utilidades
 */
class AppCarrito
{
	/**
	 * @var string
	 */
	private $_nombreSesion;
	
	/**
	 * AppCarrito constructor.
	 */
	public function __construct()
	{
		$this->_nombreSesion = 'carritov1';
	}
	
	/**
	 * @return \App\Core\Carrito\Carrito
	 */
	public function recuperar()
	{
		if ($this->_existeSesion()):
			return $this->_recuperarSesion();
		else:
			$carrito = new \App\Core\Carrito\Carrito();
			$this->_guardarSesion($carrito);
			return $carrito;
		endif;
	}
	
	/**
	 * @param int                                     $tarifaId
	 * @param int                                     $tipoHabitacionId
	 * @param \App\Core\Modelos\Promocion\Promocion[] $promociones
	 * @param \App\Core\Modelos\Cotizacion\Cotizacion $cotizacion
	 *
	 * @return \App\Core\Carrito\Elemento\Elemento
	 */
	public function agregarElemento($tarifaId, $tipoHabitacionId, $promociones, $cotizacion)
	{
		$carrito = $this->recuperar();
		$elemento = $carrito->agregarElemento($tarifaId, $tipoHabitacionId, $promociones, $cotizacion);
		$this->_guardarSesion($carrito);
		return $elemento;
	}
	
	/**
	 * @param int $indice
	 *
	 * @return \App\Core\Carrito\Elemento\Elemento|null
	 */
	public function removerElemento($indice)
	{
		$carrito = $this->recuperar();
		$elemento = $carrito->removerElemento($indice);
		$this->_guardarSesion($carrito);
		return $elemento;
	}
	
	/**
	 * @param int   $indice
	 * @param int   $complementoId
	 * @param mixed $cotizacion
	 *
	 * @return \App\Core\Carrito\Elemento\ElementoAdicional[]
	 */
	public function agregarAdicional($indice, $complementoId, $cotizacion)
	{
		$carrito = $this->recuperar();
		$elementos = $carrito->agregarAdicional($indice, $complementoId, $cotizacion);
		$this->_guardarSesion($carrito);
		return $elementos;
	}
	
	/**
	 * @param int $indice
	 * @param int $complementoId
	 *
	 * @return \App\Core\Carrito\Elemento\ElementoAdicional[]
	 */
	public function removerAdicional($indice, $complementoId)
	{
		$carrito = $this->recuperar();
		$elementos = $carrito->removerAdicional($indice, $complementoId);
		$this->_guardarSesion($carrito);
		return $elementos;
	}
	
	/**
	 * @param int $complementoId
	 *
	 * @return \App\Core\Carrito\Elemento\ElementoAdicional[]
	 */
	public function removerAdicionales($complementoId)
	{
		$carrito = $this->recuperar();
		$elementos = $carrito->removerAdicionales($complementoId);
		$this->_guardarSesion($carrito);
		return $elementos;
	}
	
	/**
	 * @param int $tipoHabitacionId
	 *
	 * @return int
	 */
	public function existencias($tipoHabitacionId)
	{
		$carrito = $this->recuperar();
		return $carrito->existencias($tipoHabitacionId);
	}
	
	/**
	 * @param int $tarifaId
	 * @param int $tipoHabitacionId
	 *
	 * @return boolean
	 */
	public function existeTarifaTipoHabitacion($tarifaId, $tipoHabitacionId)
	{
		$carrito = $this->recuperar();
		return $carrito->existeTarifaTipoHabitacion($tarifaId, $tipoHabitacionId);
	}
	
	/**
	 */
	public function limpiar()
	{
		$carrito = $this->recuperar();
		$carrito->limpiar();
		$this->_guardarSesion($carrito);
	}
	
	/**
	 */
	public function limpiarComplementos()
	{
		$carrito = $this->recuperar();
		$carrito->limpiarComplementos();
		$this->_guardarSesion($carrito);
	}
	
	/**
	 * @return bool
	 */
	private function _existeSesion()
	{
		return Session::has($this->_nombreSesion);
	}
	
	/**
	 * @param \App\Core\Carrito\Carrito $datos
	 *
	 * @return \App\Core\Carrito\Carrito
	 */
	private function _guardarSesion(\App\Core\Carrito\Carrito $datos)
	{
		Session::put($this->_nombreSesion, $datos);
		return $datos;
	}
	
	/**
	 * @return \App\Core\Carrito\Carrito|null
	 */
	private function _recuperarSesion()
	{
		return Session::get($this->_nombreSesion);
	}
	
	/**
	 */
	private function _terminarSesion()
	{
		if (Session::has($this->_nombreSesion)):
			Session::forget($this->_nombreSesion);
		endif;
	}
}
