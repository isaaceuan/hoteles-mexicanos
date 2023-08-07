<?php

namespace App\Core\Modelos\Cotizacion\Complemento;

/**
 * Class Complemento
 * @package App\Core\Modelos\Cotizacion\Complemento
 */
class Complemento
{
	/**
	 * @var int
	 */
	private $_cantidad;
	
	/**
	 * @var int
	 */
	private $_complementoId;
	
	/**
	 * @var string
	 */
	private $_fecha;
	
	/**
	 * @var float
	 */
	private $_importe;
	
	/**
	 * @var Impuesto[]
	 */
	private $_impuestos;
	
	/**
	 * @var bool
	 */
	private $_incluido;
	
	/**
	 * @var float
	 */
	private $_precio;
	
	/**
	 * @var int
	 */
	private $_productoId;
	
	/**
	 * @var Propina[]
	 */
	private $_propinas;
	
	/**
	 * @var string
	 */
	private $_tipo;
	
	/**
	 * @var float
	 */
	private $_total;
	
	/**
	 * @var float
	 */
	private $_totalImpuestos;
	
	/**
	 * @var float
	 */
	private $_totalPropinas;
	
	/**
	 * Complemento constructor.
	 *
	 * @param mixed $complemento
	 */
	public function __construct($complemento)
	{
		$this->_cantidad = (int) $complemento->cantidad;
		$this->_complementoId = (int) $complemento->complemento_id;
		$this->_fecha = $complemento->fecha;
		$this->_importe = (float) $complemento->importe;
		$this->_impuestos = [];
		$this->_incluido = (bool) $complemento->incluido;
		$this->_precio = (float) $complemento->precio;
		$this->_productoId = (int) $complemento->producto_id;
		$this->_propinas = [];
		$this->_tipo = $complemento->tipo;
		$this->_total = (float) $complemento->total;
		$this->_totalImpuestos = (float) $complemento->total_impuestos;
		$this->_totalPropinas = (float) $complemento->total_propinas;
		$this->_cargarImpuestos($complemento->impuestos);
		$this->_cargarPropinas($complemento->propinas);
	}
	
	/**
	 * @return int
	 */
	public function getCantidad()
	{
		return $this->_cantidad;
	}
	
	/**
	 * @return int
	 */
	public function getComplementoId()
	{
		return $this->_complementoId;
	}
	
	/**
	 * @return string
	 */
	public function getFecha()
	{
		return $this->_fecha;
	}
	
	/**
	 * @return float
	 */
	public function getImporte()
	{
		return $this->_importe;
	}
	
	/**
	 * @return Impuesto[]
	 */
	public function getImpuestos()
	{
		return $this->_impuestos;
	}
	
	/**
	 * @return bool
	 */
	public function getIncluido()
	{
		return $this->_incluido;
	}
	
	/**
	 * @return float
	 */
	public function getPrecio()
	{
		return $this->_precio;
	}
	
	/**
	 * @return int
	 */
	public function getProductoId()
	{
		return $this->_productoId;
	}
	
	/**
	 * @return Propina[]
	 */
	public function getPropinas()
	{
		return $this->_propinas;
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
	public function getTotal()
	{
		return $this->_total;
	}
	
	/**
	 * @return float
	 */
	public function getTotalImpuestos()
	{
		return $this->_totalImpuestos;
	}
	
	/**
	 * @return float
	 */
	public function getTotalPropinas()
	{
		return $this->_totalPropinas;
	}
	
	/**
	 * @param mixed $impuestos
	 */
	private function _cargarImpuestos($impuestos)
	{
		foreach ($impuestos as $impuesto) {
			$this->_impuestos[] = new Impuesto($impuesto);
		}
	}
	
	/**
	 * @param mixed $propinas
	 */
	private function _cargarPropinas($propinas)
	{
		foreach ($propinas as $propina) {
			$this->_propinas[] = new Propina($propina);
		}
	}
	
	/**
	 * @return mixed
	 */
	private function _getImpuestosGuardado()
	{
		$impuestos = [];
		foreach ($this->getImpuestos() as $impuesto) {
			$impuestos[] = $impuesto->getGuardado();
		}
		return $impuestos;
	}
	
	/**
	 * @return mixed
	 */
	private function _getPropinasGuardado()
	{
		$propinas = [];
		foreach ($this->getPropinas() as $propina) {
			$propinas[] = $propina->getGuardado();
		}
		return $propinas;
	}
	
	/**
	 * @return mixed
	 */
	public function getGuardado()
	{
		return [
			'complemento_id' => $this->getComplementoId(),
			'fecha'          => $this->getFecha(),
			'tipo'           => $this->getTipo(),
			'producto_id'    => $this->getProductoId(),
			'precio'         => $this->getPrecio(),
			'cantidad'       => $this->getCantidad(),
			'importe'        => $this->getImporte(),
			'incluido'       => $this->getIncluido(),
			'impuestos'      => $this->_getImpuestosGuardado(),
			'propinas'       => $this->_getPropinasGuardado()
		];
	}
}
