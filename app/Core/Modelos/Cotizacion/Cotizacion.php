<?php

namespace App\Core\Modelos\Cotizacion;

use App\Core\Modelos\Cotizacion\Complemento\Complemento;
use App\Core\Modelos\Cotizacion\Detalle\Detalle;

/**
 * Class Cotizacion
 * @package App\Core\Modelos\Cotizacion
 */
class Cotizacion
{
	/**
	 * @var float
	 */
	private $_tipoCambioCompra;
	
	/**
	 * @var float
	 */
	private $_total;
	
	/**
	 * @var float
	 */
	private $_totalAlimentos;
	
	/**
	 * @var float
	 */
	private $_totalAnticipo;
	
	/**
	 * @var float
	 */
	private $_totalComplementos;
	
	/**
	 * @var float
	 */
	private $_totalDescuentos;
	
	/**
	 * @var float
	 */
	private $_totalHospedaje;
	
	/**
	 * @var float
	 */
	private $_totalImpuestos;
	
	/**
	 * @var float
	 */
	private $_totalPropinas;
	
	/**
	 * @var Complemento[]
	 */
	private $_complementos;
	
	/**
	 * @var Detalle[]
	 */
	private $_detalles;
	
	/**
	 * @var ReglaCancelacion
	 */
	private $_reglaCancelacion;
	
	/**
	 * @var ReglaModificacion
	 */
	private $_reglaModificacion;
	
	/**
	 * @var ReglaPago
	 */
	private $_reglaPago;
	
	/**
	 * @var mixed
	 */
	private $_cotizacion;
	
	/**
	 * Cotizacion constructor.
	 *
	 * @param mixed $cotizacion
	 */
	public function __construct($cotizacion)
	{
		$this->_tipoCambioCompra = (float) $cotizacion->tipo_cambio_compra;
		$this->_total = (float) $cotizacion->total;
		$this->_totalAlimentos = (float) $cotizacion->total_alimentos;
		$this->_totalAnticipo = (float) $cotizacion->total_anticipo;
		$this->_totalComplementos = (float) $cotizacion->total_complementos;
		$this->_totalDescuentos = (float) $cotizacion->total_descuentos;
		$this->_totalHospedaje = (float) $cotizacion->total_hospedaje;
		$this->_totalImpuestos = (float) $cotizacion->total_impuestos;
		$this->_totalPropinas = (float) $cotizacion->total_propinas;
		$this->_complementos = [];
		$this->_detalles = [];
		$this->_reglaCancelacion = null;
		$this->_reglaModificacion = null;
		$this->_reglaPago = null;
		$this->_cotizacion = $cotizacion;
		$this->_cargarDetalles((array) $cotizacion->detalles);
		$this->_cargarComplementos((array) $cotizacion->complementos);
		if (isset($cotizacion->regla_cancelacion)) $this->_cargarReglaCancelacion($cotizacion->regla_cancelacion);
		if (isset($cotizacion->regla_modificacion)) $this->_cargarReglaModificacion($cotizacion->regla_modificacion);
		if (isset($cotizacion->regla_pago)) $this->_cargarReglaPago($cotizacion->regla_pago);
	}
	
	/**
	 * @return float
	 */
	public function getTipoCambioCompra()
	{
		return $this->_tipoCambioCompra;
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
	public function getTotalAlimentos()
	{
		return $this->_totalAlimentos;
	}
	
	/**
	 * @return float
	 */
	public function getTotalAnticipo()
	{
		return $this->_totalAnticipo;
	}
	
	/**
	 * @return float
	 */
	public function getTotalComplementos()
	{
		return $this->_totalComplementos;
	}
	
	/**
	 * @return float
	 */
	public function getTotalDescuentos()
	{
		return $this->_totalDescuentos;
	}
	
	/**
	 * @return boolean
	 */
	public function conDescuentos()
	{
		return $this->_totalDescuentos > 0;
	}
	
	/**
	 * @return float
	 */
	public function getTotalHospedaje()
	{
		return $this->_totalHospedaje;
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
	 * @return Complemento[]
	 */
	public function getComplementos()
	{
		return $this->_complementos;
	}
	
	/**
	 * @return Detalle[]
	 */
	public function getDetalles()
	{
		return $this->_detalles;
	}
	
	/**
	 * @param mixed $detalles
	 */
	private function _cargarDetalles($detalles)
	{
		foreach ($detalles as $detalle) {
			$this->_detalles[] = new Detalle($detalle);
		}
	}
	
	/**
	 * @return ReglaCancelacion
	 */
	public function getReglaCancelacion()
	{
		return $this->_reglaCancelacion;
	}
	
	/**
	 * @return boolean
	 */
	public function tieneReglaCancelacion()
	{
		return $this->_reglaCancelacion !== null;
	}
	
	/**
	 * @return ReglaModificacion
	 */
	public function getReglaModificacion()
	{
		return $this->_reglaModificacion;
	}
	
	/**
	 * @return boolean
	 */
	public function tieneReglaModificacion()
	{
		return $this->_reglaModificacion !== null;
	}
	
	/**
	 * @return ReglaPago
	 */
	public function getReglaPago()
	{
		return $this->_reglaPago;
	}
	
	/**
	 * @return boolean
	 */
	public function tieneReglaPago()
	{
		return $this->_reglaPago !== null;
	}
	
	/**
	 * @param mixed $complementos
	 */
	private function _cargarComplementos($complementos)
	{
		foreach ($complementos as $complemento) {
			$this->_complementos[] = new Complemento($complemento);
		}
	}
	
	/**
	 * @param mixed $reglaCancelacion
	 */
	private function _cargarReglaCancelacion($reglaCancelacion)
	{
		$this->_reglaCancelacion = new ReglaCancelacion($reglaCancelacion);
	}
	
	/**
	 * @param mixed $reglaModificacion
	 */
	private function _cargarReglaModificacion($reglaModificacion)
	{
		$this->_reglaModificacion = new ReglaModificacion($reglaModificacion);
	}
	
	/**
	 * @param mixed $reglaPago
	 */
	private function _cargarReglaPago($reglaPago)
	{
		$this->_reglaPago = new ReglaPago($reglaPago);
	}
	
	/**
	 * @return mixed
	 */
	public function getCotizacion()
	{
		return $this->_cotizacion;
	}
	
	/**
	 * @param $cantidad
	 *
	 * @return string[]
	 */
	public function getFechas($cantidad)
	{
		$fechas = [];
		$conteo = 0;
		foreach ($this->_detalles as $detalle) {
			$fechas[] = $detalle->getFecha();
			if (++$conteo === $cantidad) break;
		}
		return $fechas;
	}
	
	/**
	 * @return Detalle|null
	 */
	public function getPrimerDetalle()
	{
		$detalleAux = null;
		foreach ($this->_detalles as $detalle) {
			$detalleAux = $detalle;
			break;
		}
		return $detalleAux;
	}
	
	/**
	 * @param int $complementoId
	 *
	 * @return boolean
	 */
	public function tieneComplemento($complementoId)
	{
		$existe = false;
		foreach ($this->_complementos as $complemento) {
			if ($complemento->getComplementoId() == $complementoId) {
				$existe = true;
				break;
			}
		}
		return $existe;
	}
	
	/**
	 * @return int
	 */
	public function getAdultos()
	{
		if ($this->getPrimerDetalle() === null) return 0;
		return $this->getPrimerDetalle()->getAdultos();
	}
	
	/**
	 * @return int
	 */
	public function getNinos1()
	{
		if ($this->getPrimerDetalle() === null) return 0;
		return $this->getPrimerDetalle()->getNinos1();
	}
	
	/**
	 * @return int
	 */
	public function getNinos2()
	{
		if ($this->getPrimerDetalle() === null) return 0;
		return $this->getPrimerDetalle()->getNinos2();
	}
	
	/**
	 * @return int
	 */
	public function getNinos3()
	{
		if ($this->getPrimerDetalle() == null) return 0;
		return $this->getPrimerDetalle()->getNinos3();
	}
	
	/**
	 * @return int
	 */
	public function getNinos()
	{
		if ($this->getPrimerDetalle() == null) return 0;
		return $this->getPrimerDetalle()->getNinos1() + $this->getPrimerDetalle()->getNinos2() + $this->getPrimerDetalle()->getNinos3();
	}
}
