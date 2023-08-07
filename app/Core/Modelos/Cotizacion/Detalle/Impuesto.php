<?php

namespace App\Core\Modelos\Cotizacion\Detalle;

/**
 * Class Impuesto
 * @package App\Core\Modelos\Cotizacion\Detalle
 */
class Impuesto
{
	/**
	 * @var int
	 */
	private $_impuestoId;
	
	/**
	 * @var string
	 */
	private $_tipo;
	
	/**
	 * @var float
	 */
	private $_importeAdultos;
	
	/**
	 * @var float
	 */
	private $_importeNinos;
	
	/**
	 * Impuesto constructor.
	 *
	 * @param mixed $impuesto
	 */
	public function __construct($impuesto)
	{
		$this->_impuestoId = (int) $impuesto->impuesto_id;
		$this->_tipo = $impuesto->tipo;
		$this->_importeAdultos = (float) $impuesto->importe_adultos;
		$this->_importeNinos = empty($impuesto->importe_ninos) ? 0 : (float) $impuesto->importe_ninos;
	}
	
	/**
	 * @return int
	 */
	public function getImpuestoId()
	{
		return $this->_impuestoId;
	}
	
	/**
	 * @return string
	 */
	public function getTipo()
	{
		return $this->_tipo;
	}
	
	/**
	 * @return float
	 */
	public function getImporteAdultos()
	{
		return $this->_importeAdultos;
	}
	
	/**
	 * @return float
	 */
	public function getImporteNinos()
	{
		return $this->_importeNinos;
	}
	
	/**
	 * @return float
	 */
	public function getImporte()
	{
		return $this->_importeAdultos + $this->_importeNinos;
	}
	
	/**
	 * @return mixed
	 */
	public function getGuardado()
	{
		return [
			'impuesto_id'     => $this->getImpuestoId(),
			'tipo'            => $this->getTipo(),
			'importe_adultos' => $this->getImporteAdultos(),
			'importe_ninos'   => $this->getImporteNinos(),
		];
	}
}
