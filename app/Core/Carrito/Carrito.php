<?php

namespace App\Core\Carrito;

use App\Core\Carrito\Elemento\Elemento;
use App\Core\Carrito\Elemento\ElementoAdicional;
use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class Carrito
 * @package App\Core\Carrito
 */
class Carrito
{
	/**
	 * @var int
	 */
	private $_indice;
	
	/**
	 * @var Elemento[]
	 */
	protected $_elementos;
	
	/**
	 * Carrito constructor.
	 */
	public function __construct()
	{
		$this->_indice = 1;
		$this->_elementos = [];
	}
	
	/**
	 * @param int                                     $tarifa
	 * @param int                                     $tipoHabitacion
	 * @param \App\Core\Modelos\Promocion\Promocion[] $promociones
	 * @param Cotizacion                              $cotizacion
	 *
	 * @return Elemento
	 */
	public function agregarElemento($tarifa, $tipoHabitacion, $promociones, $cotizacion)
	{
		$elemento = new Elemento($this->_indice++, $tarifa, $tipoHabitacion, $promociones, $cotizacion);
		$this->_elementos[] = $elemento;
		return $elemento;
	}
	
	/**
	 * @param int $indice
	 *
	 * @return Elemento|null
	 */
	public function removerElemento($indice)
	{
		$elementoAux = null;
		$elementosAux = [];
		foreach ($this->_elementos as $elemento) {
			if ($elemento->getIndice() !== $indice) {
				$elementosAux[] = $elemento;
			}
			else {
				$elementoAux = $elemento;
			}
		}
		$this->_indice = 1;
		foreach ($elementosAux as $elemento) {
			$elemento->setIndice($this->_indice++);
		}
		$this->_elementos = $elementosAux;
		return $elementoAux;
	}
	
	/**
	 * @return Elemento[]
	 */
	public function elementos()
	{
		return $this->_elementos;
	}
	
	/**
	 * @return Elemento[]
	 */
	public function limpiar()
	{
		$this->_indice = 1;
		$this->_elementos = [];
		return $this->_elementos;
	}
	
	/**
	 * @return boolean
	 */
	public function tieneElementos()
	{
		return count($this->_elementos) > 0;
	}
	
	/**
	 * @return Elemento[]
	 */
	public function limpiarComplementos()
	{
		foreach ($this->_elementos as &$elemento) {
			$elemento->removerAdicionales();
		}
		return $this->_elementos;
	}
	
	/**
	 * @param int   $indice
	 * @param int   $complementoId
	 * @param mixed $cotizacion
	 *
	 * @return ElementoAdicional[]
	 */
	public function agregarAdicional($indice, $complementoId, $cotizacion)
	{
		$adicionales = [];
		foreach ($this->_elementos as $elemento) {
			if ($elemento->getIndice() == $indice) {
				$adicionales = $elemento->agregarAdicional($complementoId, $cotizacion);
				break;
			}
		}
		return $adicionales;
	}
	
	/**
	 * @param int $indice
	 * @param int $complementoId
	 *
	 * @return ElementoAdicional[]
	 */
	public function removerAdicional($indice, $complementoId)
	{
		$adicionales = [];
		foreach ($this->_elementos as $elemento) {
			if ($elemento->getIndice() === $indice) {
				$adicionales = $elemento->removerAdicional($complementoId);
				break;
			}
		}
		return $adicionales;
	}
	
	/**
	 * @param int $complementoId
	 *
	 * @return ElementoAdicional[]
	 */
	public function removerAdicionales($complementoId)
	{
		$adicionales = [];
		foreach ($this->_elementos as $elemento) {
			$adicionalesAux = $elemento->removerAdicional($complementoId);
			$adicionales = array_merge($adicionales, $adicionalesAux);
		}
		return $adicionales;
	}
	
	/**
	 * @param int $tipoHabitacionId
	 *
	 * @return int
	 */
	public function existencias($tipoHabitacionId)
	{
		$existencias = 0;
		foreach ($this->_elementos as $elemento) {
			if ($elemento->getTipoHabitacionId() == $tipoHabitacionId) {
				$existencias++;
			}
		}
		return $existencias;
	}
	
	/**
	 * @param int $tarifaId
	 * @param int $tipoHabitacionId
	 *
	 * @return boolean
	 */
	public function existeTarifaTipoHabitacion($tarifaId, $tipoHabitacionId)
	{
		$existe = false;
		foreach ($this->_elementos as $elemento) {
			if ($elemento->getTarifaId() == $tarifaId && $elemento->getTipoHabitacionId() == $tipoHabitacionId) {
				$existe = true;
				break;
			}
		}
		return $existe;
	}
	
	/**
	 * @param mixed $tiposHabitacionesIndexadas
	 * @param mixed $tarifasIndexadas
	 *
	 * @return mixed
	 */
	public function getResumenAnticipo($tiposHabitacionesIndexadas, $tarifasIndexadas)
	{
		$resumenAnticipo = [];
		foreach ($this->_elementos as $elemento) {
			$tarifa = $tarifasIndexadas[$elemento->getTarifaId()];
			$tipoHabitacion = $tiposHabitacionesIndexadas[$elemento->getTipoHabitacionId()];
			$resumenAnticipo[] = [
				'tipo_habitacion' => $tipoHabitacion->nombre,
				'tarifa'          => $tarifa->nombre,
				'modo'   		  => $elemento->getCotizacion()->getReglaPago()->getModo(),
				'valor'  		  => $elemento->getCotizacion()->getReglaPago()->getValor(),
				'anticipo'  	  => $elemento->getTotalAnticipo(),
				'total_anticipo'  => $elemento->getTotalAnticipo(),
			];
		}
		return $resumenAnticipo;
	}
	
	/**
	 * @return float
	 */
	public function getTotalAnticipo()
	{
		$importe = 0;
		foreach ($this->_elementos as $elemento) {
			$importe += $elemento->getTotalAnticipo();
		}
		return $importe;
	}
	
	/**
	 * @return float
	 */
	public function getTotal()
	{
		$importe = 0;
		foreach ($this->_elementos as $elemento) {
			$importe += $elemento->getCotizacion()->getTotal();
			foreach ($elemento->getAdicionales() as $adicional) {
				$importe += $adicional->getTotal();
			}
		}
		return $importe;
	}
	
	/**
	 * @return float
	 */
	public function getTotalSaldo()
	{
		return $this->getTotal() - $this->getTotalAnticipo();
	}
}
