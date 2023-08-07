<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

/**
 * Class AppSeleccionarTema
 * @package App\Facades\Utilidades
 */
class AppSeleccionarTema extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'appseleccionartema';
	}
}
