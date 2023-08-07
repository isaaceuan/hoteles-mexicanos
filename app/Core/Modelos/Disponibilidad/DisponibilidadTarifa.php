<?php

namespace App\Core\Modelos\Disponibilidad;

use App\Core\Modelos\Promocion\Promocion;
use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class DisponibilidadTarifa
 * @package App\Core\Modelos\Disponibilidad
 */
class DisponibilidadTarifa
{
	/**
	 * @var int
	 */
	private $_id;
	
	/**
	 * @var int
	 */
	private $_monedaId;
	
	/**
	 * @var DisponibilidadTipoHabitacion
	 */
	private $_tipoHabitacion;
	
	/**
	 * @var DisponibilidadTipoHabitacion[]
	 */
	private $_tiposHabitaciones;
	
	/**
	 * @var Promocion[]
	 */
	private $_promociones;
	
	/**
	 * @var Cotizacion
	 */
	private $_cotizacion;
	
	/**
	 * DisponibilidadTarifa constructor.
	 *
	 * @param mixed $tarifa
	 */
	public function __construct($tarifa)
	{
		$this->_id = (int) $tarifa->id;
		$this->_monedaId = $tarifa->moneda_id;
		$this->_tipoHabitacion = null;
		$this->_tiposHabitaciones = [];
		$this->_promociones = [];
		if (isset($tarifa->tipo_habitacion)) {
			$this->cargarTipoHabitacion($tarifa->tipo_habitacion);
		}
		if (isset($tarifa->tipos_habitaciones)) {
			$this->cargarTiposHabitaciones($tarifa->tipos_habitaciones);
		}
		if (isset($tarifa->promociones)) {
			$this->cargarPromociones($tarifa->promociones);
		}
		if (isset($tarifa->cotizacion)) {
			$this->_cotizacion = new Cotizacion($tarifa->cotizacion);
		}
	}
	
	/**
	 */
	public function cargarTipoHabitacion($tipoHabitacion)
	{
		$this->_tipoHabitacion = new DisponibilidadTipoHabitacion($tipoHabitacion);
	}
	
	/**
	 */
	public function cargarTiposHabitaciones($tiposHabitaciones)
	{
		foreach ($tiposHabitaciones as $tipoHabitacion) {
			$this->_tiposHabitaciones[] = new DisponibilidadTipoHabitacion($tipoHabitacion);
		}
	}
	
	/**
	 */
	public function cargarPromociones($promociones)
	{
		foreach ($promociones as $promocion) {
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
	public function getMonedaId()
	{
		return $this->_monedaId;
	}
	
	/**
	 * @return DisponibilidadTipoHabitacion
	 */
	public function getTipoHabitacion()
	{
		return $this->_tipoHabitacion;
	}
	
	/**
	 * @return DisponibilidadTipoHabitacion[]
	 */
	public function getTiposHabitaciones()
	{
		return $this->_tiposHabitaciones;
	}
	
	/**
	 * @return int
	 */
	public function getCantidadTiposHabitaciones()
	{
		return count($this->_tiposHabitaciones);
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
