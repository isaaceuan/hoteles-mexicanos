<?php

namespace App\Core\Modelos\Cotizacion;

/**
 * Class ReglaPago
 * @package App\Core\Modelos\Cotizacion
 */
class ReglaPago
{
	/**
	 * @var int
	 */
	private $_reglaPagoId;
	
	/**
	 * @var string
	 */
	private $_modo;
	
	/**
	 * @var string
	 */
	private $_valor;
	
	/**
	 * @var string
	 */
	private $_anticipo;
	
	/**
	 * ReglaPago constructor.
	 *
	 * @param mixed $reglaPago
	 */
	public function __construct($reglaPago)
	{
		$this->_reglaPagoId = (int) $reglaPago->regla_pago_id;
		$this->_modo = $reglaPago->modo;
		$this->_valor = $reglaPago->valor;
		$this->_anticipo = $reglaPago->anticipo;
	}
	
	/**
	 * @return int
	 */
	public function getReglaPagoId()
	{
		return $this->_reglaPagoId;
	}
	
	/**
	 * @return string
	 */
	public function getModo()
	{
		return $this->_modo;
	}
	
	/**
	 * @return string
	 */
	public function getValor()
	{
		return $this->_valor;
	}
	
	/**
	 * @return string
	 */
	public function getAnticipo()
	{
		return $this->_anticipo;
	}
}
