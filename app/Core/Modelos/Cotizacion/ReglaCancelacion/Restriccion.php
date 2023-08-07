<?php

namespace App\Core\Modelos\Cotizacion\ReglaCancelacion;

/**
 * Class Restriccion
 * @package App\Core\Modelos\Cotizacion\ReglaCancelacion;
 */
class Restriccion
{
	/**
	 * @var int
	 */
	private $_diasEntrada;
	
	/**
	 * @var float
	 */
	private $_tasa;
	
	/**
	 * @var string
	 */
	private $_fechaLimite;
	
	/**
	 * @var float
	 */
	private $_reembolso;
	
	/**
	 * Restriccion constructor.
	 *
	 * @param mixed $restriccion
	 */
	public function __construct($restriccion)
	{
		$this->_diasEntrada = (int) $restriccion->dias_entrada;
		$this->_tasa = (float) $restriccion->tasa;
		$this->_fechaLimite = $restriccion->fecha_limite;
		$this->_reembolso = (float) $restriccion->reembolso;
	}
	
	/**
	 * @return int
	 */
	public function getDiasEntrada()
	{
		return $this->_diasEntrada;
	}
	
	/**
	 * @return float
	 */
	public function getTasa()
	{
		return $this->_tasa;
	}
	
	/**
	 * @return string
	 */
	public function getFechaLimite()
	{
		return $this->_fechaLimite;
	}
	
	/**
	 * @return float
	 */
	public function getReembolso()
	{
		return $this->_reembolso;
	}
}
