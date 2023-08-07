<?php

namespace App\Core\Modelos\Cotizacion\Complemento;

/**
 * Class Propina
 * @package App\Core\Modelos\Cotizacion\Complemento
 */
class Propina
{
	/**
	 * @var float
	 */
	private $_importe;
	
	/**
	 * @var int
	 */
	private $_propinaId;
	
	/**
	 * Propina constructor.
	 *
	 * @param mixed $propina
	 */
	public function __construct($propina)
	{
		$this->_importe = (float) $propina->importe;
		$this->_propinaId = (int) $propina->propina_id;
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
	public function getPropinaId()
	{
		return $this->_propinaId;
	}
	
	/**
	 * @return mixed
	 */
	public function getGuardado()
	{
		return [
			'propina_id' => $this->getPropinaId(),
			'importe'    => $this->getImporte()
		];
	}
}
