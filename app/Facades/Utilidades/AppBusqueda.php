<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

/**
 * Class AppBusqueda
 * @package App\Facades\Utilidades
 */
class AppBusqueda extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'appbusqueda';
	}
}