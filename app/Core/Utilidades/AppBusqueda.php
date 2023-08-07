<?php

namespace App\Core\Utilidades;

use Illuminate\Support\Carbon;
use Session;

/**
 * Class AppBusqueda
 * @package App\Core\Utilidades
 */
class AppBusqueda
{
	/**
	 * @var string
	 */
	private $_nombreSesion;
	
	/**
	 * AppBusqueda constructor.
	 */
	public function __construct()
	{
		$this->_nombreSesion = 'busquedav1';
	}
	
	/**
	 * @deprecated
	 *
	 * @return \App\Core\Busqueda\Busqueda
	 */
	public function recuperarBusqueda()
	{
		return $this->recuperar();
	}
	
	/**
	 * @return \App\Core\Busqueda\Busqueda
	 */
	public function recuperar()
	{
		if ($this->_existeSesion()):
			return $this->_recuperarSesion();
		else:
			$fecha = Carbon::now();
			$llegada = $fecha->addDays(1)->format('Y-m-d');
			$salida = $fecha->addDays(2)->format('Y-m-d');
			$busqueda = new \App\Core\Busqueda\Busqueda($llegada, $salida, 1, 2, 0, 0, 0, '');
			$this->_guardarSesion($busqueda);
			return $busqueda;
		endif;
	}
	
	public function cambioBusqueda($llegada, $salida, $noches = null, $adultos = null, $ninos1 = null, $ninos2 = null, $ninos3 = null, $promoCode = null)
	{
		$busqueda = $this->recuperar();
		if ($busqueda->getLlegada() !== $llegada) return true;
		if ($busqueda->getSalida() !== $salida) return true;
		if ($busqueda->getNoches() !== (int) $noches) return true;
		if ($busqueda->getAdultos() !== (int) $adultos) return true;
		if ($busqueda->getNinos1() !== (int) $ninos1) return true;
		if ($busqueda->getNinos2() !== (int) $ninos2) return true;
		if ($busqueda->getNinos3() !== (int) $ninos3) return true;
		if ($busqueda->getPromoCode() !== $promoCode) return true;
		
		return false;
	}
	
	/**
	 * @param string      $llegada
	 * @param string      $salida
	 * @param int|null    $noches
	 * @param int|null    $adultos
	 * @param int|null    $ninos1
	 * @param int|null    $ninos2
	 * @param int|null    $ninos3
	 * @param string|null $promoCode
	 *
	 * @return \App\Core\Busqueda\Busqueda
	 */
	public function actualizarBusqueda($llegada, $salida, $noches = null, $adultos = null, $ninos1 = null, $ninos2 = null, $ninos3 = null, $promoCode = null)
	{
		$busqueda = $this->recuperar();
		$llegadaAux = $busqueda->getLlegada();
		$salidaAux = $busqueda->getSalida();
		$nochesAux = $busqueda->getNoches();
		$adultosAux = $busqueda->getAdultos();
		$ninos1Aux = $busqueda->getNinos1();
		$ninos2Aux = $busqueda->getNinos2();
		$ninos3Aux = $busqueda->getNinos3();
		$promoCodeAux = $busqueda->getPromoCode();
		
		if ($llegada): $llegadaAux = $llegada; endif;
		if ($salida): $salidaAux = $salida; endif;
		if ($noches !== null): $nochesAux = (int) $noches; endif;
		if ($adultos !== null): $adultosAux = (int) $adultos; endif;
		if ($ninos1 !== null): $ninos1Aux = (int) $ninos1; endif;
		if ($ninos2 !== null): $ninos2Aux = (int) $ninos2; endif;
		if ($ninos3 !== null): $ninos3Aux = (int) $ninos3; endif;
		if ($promoCode !== null): $promoCodeAux = $promoCode; endif;
		$busquedaAux = new \App\Core\Busqueda\Busqueda($llegadaAux, $salidaAux, $nochesAux, $adultosAux, $ninos1Aux, $ninos2Aux, $ninos3Aux, $promoCodeAux);
		$this->_guardarSesion($busquedaAux);
		return $busquedaAux;
	}
	
	/**
	 * @return bool
	 */
	private function _existeSesion()
	{
		return Session::has($this->_nombreSesion);
	}
	
	/**
	 * @param \App\Core\Busqueda\Busqueda $datos
	 *
	 * @return \App\Core\Busqueda\Busqueda
	 */
	private function _guardarSesion($datos)
	{
		Session::put($this->_nombreSesion, $datos);
		return $datos;
	}
	
	/**
	 * @return \App\Core\Busqueda\Busqueda|null
	 */
	private function _recuperarSesion()
	{
		return Session::get($this->_nombreSesion);
	}
}