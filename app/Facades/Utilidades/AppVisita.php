<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

/**
 * Class AppVisita
 * @package App\Facades\Utilidades
 */
class AppVisita extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'appvisita';
	}
}