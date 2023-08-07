<?php

namespace App\Core\Modelos\Formato;

use App\Core\Busqueda\Busqueda;
use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class FormatoBusqueda
 * @package App\Core\Modelos\Formato
 */
class FormatoBusqueda
{
	/**
	 * FormatoBusqueda constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param Busqueda $busqueda
	 *
	 * @return mixed
	 */
	public function getFormato($busqueda)
	{
		return [
			'llegada'    => $busqueda->getLlegada(),
			'salida'     => $busqueda->getSalida(),
			'noches'     => $busqueda->getNoches(),
			'adultos'    => $busqueda->getAdultos(),
			'ninos'      => $busqueda->getNinos1() + $busqueda->getNinos2() + $busqueda->getNinos3(),
			'ninos1'     => $busqueda->getNinos1(),
			'ninos2'     => $busqueda->getNinos2(),
			'ninos3'     => $busqueda->getNinos3(),
			'promo_code' => $busqueda->getPromoCode()
		];
	}
	
	/**
	 * @param Busqueda   $busqueda
	 * @param Cotizacion $cotizacion
	 *
	 * @return mixed
	 */
	public function getFormatoCotizacion($busqueda, $cotizacion)
	{
		return [
			'llegada' => $busqueda->getLlegada(),
			'salida'  => $busqueda->getSalida(),
			'noches'  => $busqueda->getNoches(),
			'adultos' => $cotizacion->getAdultos(),
			'ninos'   => $cotizacion->getNinos(),
			'ninos1'  => $cotizacion->getNinos1(),
			'ninos2'  => $cotizacion->getNinos2(),
			'ninos3'  => $cotizacion->getNinos3()
		];
	}
}
