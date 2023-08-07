<?php

namespace App\Core\Modelos\Cotizacion\Detalle;

/**
 * Class Detalle
 * @package App\Core\Modelos\Cotizacion\Detalle
 */
class Detalle
{
	/**
	 * @var int
	 */
	private $_tipoHabitacionId;
	
	/**
	 * @var int
	 */
	private $_habitacionId;
	
	/**
	 * @var int
	 */
	private $_promocionId;
	
	/**
	 * @var string
	 */
	private $_fecha;
	
	/**
	 * @var int
	 */
	private $_adultos;
	
	/**
	 * @var float
	 */
	private $_adultosHospedaje;
	
	/**
	 * @var float
	 */
	private $_adultosHospedajeDescuento;
	
	/**
	 * @var float
	 */
	private $_adultosAlimentos;
	
	/**
	 * @var float
	 */
	private $_adultosAlimentosDescuento;
	
	/**
	 * @var int
	 */
	private $_ninos1;
	
	/**
	 * @var int
	 */
	private $_ninos2;
	
	/**
	 * @var int
	 */
	private $_ninos3;
	
	/**
	 * @var float
	 */
	private $_ninosHospedaje;
	
	/**
	 * @var float
	 */
	private $_ninosHospedajeDescuento;
	
	/**
	 * @var float
	 */
	private $_ninosAlimentos;
	
	/**
	 * @var float
	 */
	private $_ninosAlimentosDescuento;
	
	/**
	 * @var float
	 */
	private $_totalHospedaje;
	
	/**
	 * @var float
	 */
	private $_totalAlimentos;
	
	/**
	 * @var float
	 */
	private $_totalDescuentos;
	
	/**
	 * @var float
	 */
	private $_totalImpuestos;
	
	/**
	 * @var float
	 */
	private $_totalPropinas;
	
	/**
	 * @var float
	 */
	private $_total;
	
	/**
	 * @var Impuesto[]
	 */
	private $_impuestos;
	
	/**
	 * @var Propina[]
	 */
	private $_propinas;
	
	/**
	 * Detalle constructor.
	 *
	 * @param mixed $detalle
	 */
	public function __construct($detalle)
	{
		$this->_tipoHabitacionId = (int) $detalle->tipo_habitacion_id;
		$this->_habitacionId = empty($detalle->habitacion_id) ? null : (int) $detalle->habitacion_id;
		$this->_promocionId = empty($detalle->promocion_id) ? null : (int) $detalle->promocion_id;
		$this->_fecha = $detalle->fecha;
		$this->_adultos = (int) $detalle->adultos;
		$this->_adultosHospedaje = (float) $detalle->adultos_hospedaje;
		$this->_adultosHospedajeDescuento = (float) $detalle->adultos_hospedaje_descuento;
		$this->_adultosAlimentos = (float) $detalle->adultos_alimentos;
		$this->_adultosAlimentosDescuento = (float) $detalle->adultos_alimentos_descuento;
		$this->_ninos1 = (int) $detalle->ninos1;
		$this->_ninos2 = (int) $detalle->ninos2;
		$this->_ninos3 = (int) $detalle->ninos3;
		$this->_ninosHospedaje = (float) $detalle->ninos_hospedaje;
		$this->_ninosHospedajeDescuento = (float) $detalle->ninos_hospedaje_descuento;
		$this->_ninosAlimentos = (float) $detalle->ninos_alimentos;
		$this->_ninosAlimentosDescuento = (float) $detalle->ninos_alimentos_descuento;
		$this->_totalHospedaje = (float) $detalle->total_hospedaje;
		$this->_totalAlimentos = (float) $detalle->total_alimentos;
		$this->_totalDescuentos = (float) $detalle->total_descuentos;
		$this->_totalImpuestos = (float) $detalle->total_impuestos;
		$this->_totalPropinas = (float) $detalle->total_propinas;
		$this->_total = (float) $detalle->total;
		$this->_impuestos = [];
		$this->_propinas = [];
		$this->_cargarImpuestos($detalle->impuestos);
		$this->_cargarPropinas($detalle->propinas);
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
	 * @return int
	 */
	public function getTipoHabitacionId()
	{
		return $this->_tipoHabitacionId;
	}
	
	/**
	 * @return int|null
	 */
	public function getHabitacionId()
	{
		return $this->_habitacionId;
	}
	
	/**
	 * @return int
	 */
	public function getPromocionId()
	{
		return $this->_promocionId;
	}
	
	/**
	 * @return string
	 */
	public function getFecha()
	{
		return $this->_fecha;
	}
	
	/**
	 * @return int
	 */
	public function getAdultos()
	{
		return $this->_adultos;
	}
	
	/**
	 * @return float
	 */
	public function getAdultosHospedaje()
	{
		return $this->_adultosHospedaje;
	}
	
	/**
	 * @return float
	 */
	public function getAdultosHospedajeDescuento()
	{
		return $this->_adultosHospedajeDescuento;
	}
	
	/**
	 * @return float
	 */
	public function getAdultosAlimentos()
	{
		return $this->_adultosAlimentos;
	}
	
	/**
	 * @return float
	 */
	public function getAdultosAlimentosDescuento()
	{
		return $this->_adultosAlimentosDescuento;
	}
	
	/**
	 * @return int
	 */
	public function getNinos1()
	{
		return $this->_ninos1;
	}
	
	/**
	 * @return int
	 */
	public function getNinos2()
	{
		return $this->_ninos2;
	}
	
	/**
	 * @return int
	 */
	public function getNinos3()
	{
		return $this->_ninos3;
	}
	
	/**
	 * @return float
	 */
	public function getNinosHospedaje()
	{
		return $this->_ninosHospedaje;
	}
	
	/**
	 * @return float
	 */
	public function getNinosHospedajeDescuento()
	{
		return $this->_ninosHospedajeDescuento;
	}
	
	/**
	 * @return float
	 */
	public function getNinosAlimentos()
	{
		return $this->_ninosAlimentos;
	}
	
	/**
	 * @return float
	 */
	public function getNinosAlimentosDescuento()
	{
		return $this->_ninosAlimentosDescuento;
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
	public function getTotalAlimentos()
	{
		return $this->_totalAlimentos;
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
	 * @param bool $conDescuentos
	 * @param bool $conImpuestos
	 * @param bool $conPropinas
	 *
	 * @return float
	 */
	public function getTotalPersonalizado($conDescuentos = false, $conImpuestos = false, $conPropinas = false)
	{
		$total = $this->_totalHospedaje + $this->_totalAlimentos;
		if (!$conDescuentos) $total += $this->_totalDescuentos;
		if ($conImpuestos) $total += $this->_totalImpuestos;
		if ($conPropinas) $total += $this->_totalPropinas;
		return $total;
	}
	
	/**
	 * @return float
	 */
	public function getTotal()
	{
		return $this->_total;
	}
	
	/**
	 * @return Impuesto[]
	 */
	public function getImpuestos()
	{
		return $this->_impuestos;
	}
	
	/**
	 * @return Propina[]
	 */
	public function getPropinas()
	{
		return $this->_propinas;
	}
	
	/**
	 * @return mixed
	 */
	public function getImpuestosGuardado()
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
	public function getPropinasGuardado()
	{
		$propinas = [];
		foreach ($this->getPropinas() as $propina) {
			$propinas[] = $propina->getGuardado();
		}
		return $propinas;
	}
}
