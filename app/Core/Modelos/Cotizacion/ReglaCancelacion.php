<?php

namespace App\Core\Modelos\Cotizacion;

use App\Core\Modelos\Cotizacion\ReglaCancelacion\Restriccion;

/**
 * Class ReglaCancelacion
 * @package App\Core\Modelos\Cotizacion
 */
class ReglaCancelacion
{
	/**
	 * @var int
	 */
	private $_reglaCancelacionId;
	
	/**
	 * @var boolean
	 */
	private $_esReembolsable;
	
	/**
	 * @var Restriccion[]
	 */
	private $_restricciones;
	
	/**
	 * ReglaCancelacion constructor.
	 *
	 * @param mixed $reglaCancelacion
	 */
	public function __construct($reglaCancelacion)
	{
		$this->_reglaCancelacionId = (int) $reglaCancelacion->regla_cancelacion_id;
		$this->_esReembolsable = (bool) $reglaCancelacion->es_reembolsable;
		$this->_restricciones = [];
		$this->_cargarRestricciones($reglaCancelacion->restricciones);
	}
	
	/**
	 * @param mixed $restricciones
	 */
	private function _cargarRestricciones($restricciones)
	{
		foreach ($restricciones as $restriccion) {
			$this->_restricciones[] = new Restriccion($restriccion);
		}
	}
	
	/**
	 * @return int
	 */
	public function getReglaCancelacionId()
	{
		return $this->_reglaCancelacionId;
	}
	
	/**
	 * @return bool
	 */
	public function esReembolsable()
	{
		return $this->_esReembolsable;
	}
	
	/**
	 * @return boolean
	 */
	public function tieneRestricciones()
	{
		return count($this->_restricciones) > 0;
	}
	
	/**
	 * @return Restriccion[]
	 */
	public function getRestricciones()
	{
		return $this->_restricciones;
	}
}
