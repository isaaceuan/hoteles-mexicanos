<?php

namespace App\Core\Modelos\Tarifa;

use App\Core\Modelos\PlanAlimento\PlanAlimento;

/**
 * Class Tarifa
 * @package App\Core\Modelos\Tarifa
 */
class Tarifa
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
	 * @var PlanAlimento
	 */
	private $_planAlimento;
	
	/**
	 * Tarifa constructor.
	 *
	 * @param mixed $tarifa
	 */
	public function __construct($tarifa)
	{
		$this->_id = $tarifa->id;
		$this->_nombre = $tarifa->nombre;
		$this->_descripcion = $tarifa->descripcion;
		$this->_planAlimento = null;
		if (isset($tarifa->plan_alimento)):
			$this->_cargarPlanAlimento($tarifa->plan_alimento);
		endif;
	}
	
	/**
	 * @param mixed $planAlimento
	 */
	private function _cargarPlanAlimento($planAlimento)
	{
		$this->_planAlimento = new PlanAlimento($planAlimento);
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
	 * @return PlanAlimento
	 */
	public function getPlanAlimento()
	{
		return $this->_planAlimento;
	}
	
	/**
	 * @return bool
	 */
	public function tienePlanAlimento()
	{
		return $this->_planAlimento !== null;
	}
}
