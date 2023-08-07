<?php

namespace App\Core\Modelos\Cotizacion\Complemento;

/**
 * Class Impuesto
 * @package App\Core\Modelos\Cotizacion\Complemento
 */
class Impuesto
{
	/**
	 * @var float
	 */
	private $_importe;
	
	/**
	 * @var int
	 */
	private $_impuestoId;
	
	/**
	 * Impuesto constructor.
	 *
	 * @param mixed $impuesto
	 */
	public function __construct($impuesto)
	{
		$this->_importe = (float) $impuesto->importe;
		$this->_impuestoId = (int) $impuesto->impuesto_id;
	}
	
	/**
	 * @return float
	 */
	public function getImporte()
	{
		return $this->_importe;
	}
	
	/**
	 * @return int
	 */
	public function getImpuestoId()
	{
		return $this->_impuestoId;
	}
	
	/**
	 * @return mixed
	 */
	public function getGuardado()
	{
		return [
			'impuesto_id' => $this->getImpuestoId(),
			'importe'     => $this->getImporte()
		];
	}
}
