<?php

namespace App\Core\Modelos\Disponibilidad;

use App\Core\Modelos\Cotizacion\Cotizacion;
use App\Core\Modelos\Promocion\Promocion;

/**
 * Class DisponibilidadTipoHabitacion
 * @package App\Core\Modelos\Disponibilidad
 */
class DisponibilidadTipoHabitacion
{
	/**
	 * @var int
	 */
	private $_id;
	
	/**
	 * @var int
	 */
	private $_ocupacion;
	
	/**
	 * @var int
	 */
	private $_disponibles;
	
	/**
	 * @var DisponibilidadTarifa
	 */
	private $_tarifa;
	
	/**
	 * @var DisponibilidadTarifa[]
	 */
	private $_tarifas;
	
	/**
	 * @var Promocion[]
	 */
	private $_promociones;
	
	/**
	 * @var Cotizacion
	 */
	private $_cotizacion;
	
	/**
	 * DisponibilidadTipoHabitacion constructor.
	 *
	 * @param mixed $tipoHabitacion
	 */
	public function __construct($tipoHabitacion)
	{
		$this->_id = (int) $tipoHabitacion->id;
		$this->_ocupacion = (int) $tipoHabitacion->ocupacion;
		$this->_disponibles = (int) $tipoHabitacion->disponibles;
		$this->_tarifa = null;
		$this->_tarifas = [];
		$this->_promociones = [];
		$this->_cotizacion = null;
		if (isset($tipoHabitacion->tarifa)){
			$this->cargarTarifa($tipoHabitacion->tarifa);
		}
		if (isset($tipoHabitacion->tarifas)){
			$this->cargarTarifas($tipoHabitacion->tarifas);
		}
		if (isset($tipoHabitacion->promociones)){
			$this->cargarPromociones($tipoHabitacion->promociones);
		}
		if (isset($tipoHabitacion->cotizacion)){
			$this->_cotizacion = new Cotizacion($tipoHabitacion->cotizacion);
		}
	}
	
	/**
	 */
	public function cargarTarifa($tarifa)
	{
		$this->_tarifa = new DisponibilidadTarifa($tarifa);
	}
	
	/**
	 */
	public function cargarTarifas($tarifas)
	{
		foreach ($tarifas as $tarifa){
			$this->_tarifas[] = new DisponibilidadTarifa($tarifa);
		}
	}
	
	/**
	 */
	public function cargarPromociones($promociones)
	{
		foreach ($promociones as $promocion){
			$this->_promociones[] = new Promocion($promocion);
		}
	}
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->_id;
	}
	
	/**
	 * @return int
	 */
	public function getOcupacion()
	{
		return $this->_ocupacion;
	}
	
	/**
	 * @return int
	 */
	public function getDisponibles()
	{
		return $this->_disponibles;
	}
	
	/**
	 * @return DisponibilidadTarifa
	 */
	public function getTarifa()
	{
		return $this->_tarifa;
	}
	
	/**
	 * @return DisponibilidadTarifa[]
	 */
	public function getTarifas()
	{
		return $this->_tarifas;
	}
	
	/**
	 * @return int
	 */
	public function getCantidadTarifas()
	{
		return count($this->_tarifas);
	}
	
	/**
	 * @return boolean
	 */
	public function tienePromociones()
	{
		return count($this->_promociones) > 0;
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
}
