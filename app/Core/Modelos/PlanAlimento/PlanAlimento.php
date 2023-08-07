<?php

namespace App\Core\Modelos\PlanAlimento;

/**
 * Class PlanAlimento
 * @package App\Core\Modelos\PlanAlimento
 */
class PlanAlimento
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
	 * PlanAlimento constructor.
	 *
	 * @param mixed $planAlimento
	 */
	public function __construct($planAlimento)
	{
		$this->_id = $planAlimento->id;
		$this->_nombre = $planAlimento->nombre;
		$this->_descripcion = $planAlimento->descripcion;
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
}
