<?php

namespace App\Core\Modelos\Cotizacion\Detalle;

/**
 * Class Propina
 * @package App\Core\Modelos\Cotizacion\Detalle
 */
class Propina
{
	/**
	 * @var int
	 */
	private $_propinaId;
	
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
	 * Propina constructor.
	 *
	 * @param mixed $propina
	 */
	public function __construct($propina)
	{
		$this->_propinaId = (int) $propina->propina_id;
		$this->_tipo = $propina->tipo;
		$this->_importeAdultos = (float) $propina->importe_adultos;
		$this->_importeNinos = empty($propina->importe_ninos) ? 0 :(float) $propina->importe_ninos;
	}
	
	/**
	 * @return int
	 */
	public function getPropinaId()
	{
		return $this->_propinaId;
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
			'propina_id'      => $this->getPropinaId(),
			'tipo'            => $this->getTipo(),
			'importe_adultos' => $this->getImporteAdultos(),
			'importe_ninos'   => $this->getImporteNinos(),
		];
	}
}
