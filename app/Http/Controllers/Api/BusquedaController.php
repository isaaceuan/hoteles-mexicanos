<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use AppBusqueda;
use AppSesion;

/**
 * Class BusquedaController
 * @package App\Http\Controllers\Api
 */
class BusquedaController extends Controller
{
	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function sesion()
	{
		return AppSesion::estado();
	}
	
	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function busqueda()
	{
		$busqueda = AppBusqueda::recuperar();
		return [
			'fecha_actual'  => $busqueda->getActual(),
			'fecha_entrada' => $busqueda->getLlegada(),
			'fecha_salida'  => $busqueda->getSalida(),
			'noches'        => $busqueda->getNoches(),
			'adultos'       => $busqueda->getAdultos(),
			'ninos1'        => $busqueda->getNinos1(),
			'ninos2'        => $busqueda->getNinos2(),
			'ninos3'        => $busqueda->getNinos3(),
			'promo_code'    => $busqueda->getPromoCode()
		];
	}
}
