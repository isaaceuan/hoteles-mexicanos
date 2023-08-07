<?php

namespace App\Core\Carrito\Elemento;

use App\Core\Modelos\Cotizacion\Complemento\Complemento;
use App\Core\Modelos\Cotizacion\Cotizacion;
use App\Core\Modelos\Promocion\Promocion;

/**
 * Class Elemento
 * @package App\Core\Carrito\Elemento
 */
class Elemento
{
	/**
	 * @var int
	 */
	private $_indice;
	
	/**
	 * @var int
	 */
	private $_tarifaId;
	
	/**
	 * @var int
	 */
	private $_tipoHabitacionId;
	
	/**
	 * @var Promocion[]
	 */
	private $_promociones;
	
	/**
	 * @var Cotizacion
	 */
	protected $_cotizacion;
	
	/**
	 * @var Complemento[]
	 */
	protected $_adicionales;
	
	/**
	 * Elemento constructor.
	 *
	 * @param int                                     $indice
	 * @param int                                     $tarifaId
	 * @param int                                     $tipoHabitacionId
	 * @param \App\Core\Modelos\Promocion\Promocion[] $promociones
	 * @param Cotizacion                              $cotizacion
	 */
	public function __construct($indice, $tarifaId, $tipoHabitacionId, $promociones, $cotizacion)
	{
		$this->_indice = $indice;
		$this->_tarifaId = (int) $tarifaId;
		$this->_tipoHabitacionId = (int) $tipoHabitacionId;
		$this->_promociones = $promociones;
		$this->_cotizacion = $cotizacion;
		$this->_adicionales = [];
	}
	
	/**
	 * @return int
	 */
	public function getIndice()
	{
		return $this->_indice;
	}
	
	/**
	 * @param int $indice
	 */
	public function setIndice($indice)
	{
		$this->_indice = $indice;
	}
	
	/**
	 * @return int
	 */
	public function getTarifaId()
	{
		return $this->_tarifaId;
	}
	
	/**
	 * @return int
	 */
	public function getTipoHabitacionId()
	{
		return $this->_tipoHabitacionId;
	}
	
	/**
	 * @return Promocion[]
	 */
	public function getPromociones()
	{
		return $this->_promociones;
	}
	
	/**
	 * @return Cotizacion
	 */
	public function getCotizacion()
	{
		return $this->_cotizacion;
	}
	
	/**
	 * @return ElementoAdicional[]
	 */
	public function getAdicionales()
	{
		return $this->_adicionales;
	}
	
	/**
	 * @return float
	 */
	public function getTotalAnticipo()
	{
		$total = $this->getCotizacion()->getTotal();
		foreach ($this->_adicionales as $adicionales) {
			$total += $adicionales->getTotal();
		}

		$reglaPago = $this->getCotizacion()->getReglaPago();

		if ($reglaPago === null) return $total;

		if ($reglaPago->getModo() === 'tasa') {
			$tasa = $reglaPago->getValor() / 100;
			$anticipo = $total * $tasa;
			return $anticipo;
		}
		
		if ($reglaPago->getModo() === 'noche') {
			$noches = count($this->_cotizacion->getDetalles());
			$totalNoche = $total / $noches;
			$anticipo = $totalNoche * $reglaPago->getValor();
			return $anticipo;
		}

		return 0;
	}
	
	/**
	 * @param int   $complementoId
	 * @param mixed $cotizacion
	 *
	 * @return ElementoAdicional[]
	 */
	public function agregarAdicional($complementoId, $cotizacion)
	{
		$complementos = [];
		foreach ($cotizacion as $complemento) {
			$complementos[] = new ElementoAdicional($complemento);
		}
		$elementosAux = [];
		foreach ($this->_adicionales as $adicional) {
			if ($adicional->getComplementoId() !== $complementoId) {
				$elementosAux[] = $adicional;
			}
		}
		foreach ($complementos as $complemento) {
			$elementosAux[] = $complemento;
		}
		$this->_adicionales = $elementosAux;
		return $complementos;
	}
	
	/**
	 * @param int $complementoId
	 *
	 * @return ElementoAdicional[]
	 */
	public function removerAdicional($complementoId)
	{
		$adicionalesAux = [];
		$adicionales = [];
		foreach ($this->_adicionales as $adicional) {
			if ($adicional->getComplementoId() !== $complementoId) {
				$adicionales[] = $adicional;
			}
			else {
				$adicionalesAux[] = $adicional;
			}
		}
		$this->_adicionales = $adicionales;
		return $adicionalesAux;
	}
	
	/**
	 * @param int $complementoId
	 *
	 * @return boolean
	 */
	public function tieneAdicional($complementoId)
	{
		$existe = false;
		foreach ($this->_adicionales as $complemento) {
			if ($complemento->getComplementoId() == $complementoId) {
				$existe = true;
				break;
			}
		}
		return $existe;
	}
	
	/**
	 * @param int $complementoId
	 *
	 * @return boolean
	 */
	public function tieneUnidadesAdicional($complementoId)
	{
		$unidades = 1;
		foreach ($this->_adicionales as $complemento) {
			if ($complemento->getComplementoId() == $complementoId) {
				$unidades = $complemento->getCantidad();
				break;
			}
		}
		return $unidades;
	}
	
	/**
	 *
	 */
	public function removerAdicionales()
	{
		$this->_adicionales = [];
	}
}
