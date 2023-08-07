<?php

namespace App\Core\Busqueda;

use Illuminate\Support\Carbon;

/**
 * Class Busqueda
 * @package App\Core\Busqueda
 */
class Busqueda
{
	/**
	 * @var string
	 */
	private $_actual;

	/**
	 * @var string
	 */
	private $_llegada;
	
	/**
	 * @var string
	 */
	private $_salida;
	
	/**
	 * @var int
	 */
	private $_noches;
	
	/**
	 * @var int
	 */
	private $_adultos;
	
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
	 * @var string
	 */
	private $_promoCode;
	
	/**
	 * Busqueda constructor.
	 *
	 * @param string $llegada
	 * @param string $salida
	 * @param int    $noches
	 * @param int    $adultos
	 * @param int    $ninos1
	 * @param int    $ninos2
	 * @param int    $ninos3
	 * @param string $promoCode
	 */
	public function __construct($llegada, $salida, $noches, $adultos, $ninos1, $ninos2, $ninos3, $promoCode)
	{
		$fechaActual = Carbon::now();
		$this->_actual = $fechaActual->addDays(1)->format('Y-m-d');
		$this->_llegada = $llegada;
		$this->_salida = $salida;
		$this->_noches = (int) $noches;
		$this->_adultos = (int) $adultos;
		$this->_ninos1 = (int) $ninos1;
		$this->_ninos2 = (int) $ninos2;
		$this->_ninos3 = (int) $ninos3;
		$this->_promoCode = $promoCode;
	}
	
	/**
	 * @return string
	 */
	public function getActual()
	{
		return $this->_actual;
	}
	
	/**
	 * @return string
	 */
	public function getLlegada()
	{
		return $this->_llegada;
	}
	
	/**
	 * @return string
	 */
	public function getSalida()
	{
		return $this->_salida;
	}
	
	/**
	 * @return int
	 */
	public function getNoches()
	{
		return $this->_noches;
	}
	
	/**
	 * @return int
	 */
	public function getAdultos()
	{
		return $this->_adultos;
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
	 * @return string
	 */
	public function getPromoCode()
	{
		return $this->_promoCode;
	}
}
