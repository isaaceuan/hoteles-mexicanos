<?php

namespace App\Core\Modelos\Cotizacion;

/**
 * Class ReglaModificacion
 * @package App\Core\Modelos\Cotizacion
 */
class ReglaModificacion
{
	/**
	 * @var int
	 */
	private $_reglaModificacionId;
	
	/**
	 * @var string
	 */
	private $_modo;
	
	/**
	 * @var int
	 */
	private $_diasAnticipacion;
	
	/**
	 * @var int
	 */
	private $_modificaciones;
	
	/**
	 * @var string
	 */
	private $_fechaLimite;
	
	/**
	 * ReglaModificacion constructor.
	 *
	 * @param mixed $reglaModificacion
	 */
	public function __construct($reglaModificacion)
	{
		$this->_reglaModificacionId = (int) $reglaModificacion->regla_modificacion_id;
		$this->_modo = $reglaModificacion->modo;
		$this->_diasAnticipacion = (int) $reglaModificacion->dias_anticipacion;
		$this->_modificaciones = (int) $reglaModificacion->modificaciones;
		$this->_fechaLimite = $reglaModificacion->fecha_limite;
	}
	
	/**
	 * @return int
	 */
	public function getReglaModificacionId()
	{
		return $this->_reglaModificacionId;
	}
	
	/**
	 * @return string
	 */
	public function getModo()
	{
		return $this->_modo;
	}
	
	/**
	 * @return int
	 */
	public function getDiasAnticipacion()
	{
		return $this->_diasAnticipacion;
	}
	
	/**
	 * @return int
	 */
	public function getModificaciones()
	{
		return $this->_modificaciones;
	}
	
	/**
	 * @return string
	 */
	public function getFechaLimite()
	{
		return $this->_fechaLimite;
	}
}
