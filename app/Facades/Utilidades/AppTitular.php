<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

/**
 * Class AppTitular
 * @package App\Facades\Utilidades
 */
class AppTitular extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'apptitular';
	}
}
