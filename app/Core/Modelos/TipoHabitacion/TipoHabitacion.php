<?php

namespace App\Core\Modelos\TipoHabitacion;

/**
 * Class TipoHabitacion
 * @package App\Core\Modelos\TipoHabitacion
 */
class TipoHabitacion
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
	 * @var array
	 */
	private $_imagenes;
	
	/**
	 * @var int
	 */
	private $_ocupacion;
	
	/**
	 * TipoHabitacion constructor.
	 *
	 * @param mixed $tipoHabitacion
	 */
	public function __construct($tipoHabitacion)
	{
		$this->_id = $tipoHabitacion->id;
		$this->_nombre = $tipoHabitacion->nombre;
		$this->_descripcion = $tipoHabitacion->descripcion;
		$this->_imagenes = $tipoHabitacion->imagenes;
		$this->_ocupacion = $tipoHabitacion->ocupacion;
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
	 * @return array
	 */
	public function getImagenes()
	{
		return $this->_imagenes;
	}
	
	/**
	 * @return int
	 */
	public function getOcupacion()
	{
		return $this->_ocupacion;
	}
}
