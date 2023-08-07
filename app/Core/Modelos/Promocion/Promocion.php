<?php

namespace App\Core\Modelos\Promocion;

/**
 * Class Promocion
 * @package App\Core\Modelos\Promocion
 */
class Promocion
{
	/**
	 * @var int
	 */
	private $_id;
	
	/**
	 * @var string
	 */
	private $_nombre;
	
	/**
	 * @var string
	 */
	private $_descripcion;
	
	/**
	 * @var bool
	 */
	private $_esTasa;
	
	/**
	 * @var float
	 */
	private $_descuento;
	
	/**
	 * Promocion constructor.
	 *
	 * @param mixed $promocion
	 */
	public function __construct($promocion)
	{
		$this->_id = $promocion->id;
		$this->_nombre = $promocion->nombre;
		$this->_descripcion = $promocion->descripcion;
		$this->_esTasa = $promocion->es_tasa;
		$this->_descuento = $promocion->descuento;
	}
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->_id;
	}
	
	/**
	 * @return string
	 */
	public function getNombre()
	{
		return $this->_nombre;
	}
	
	/**
	 * @return string
	 */
	public function getDescripcion()
	{
		return $this->_descripcion;
	}
	
	/**
	 * @return bool
	 */
	public function esTasa()
	{
		return $this->_esTasa;
	}
	
	/**
	 * @return float
	 */
	public function getDescuento()
	{
		return $this->_descuento;
	}
}
