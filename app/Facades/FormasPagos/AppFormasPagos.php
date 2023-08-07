<?php

namespace App\Facades\FormasPagos;

use Illuminate\Support\Facades\Facade;

/**
 * Class AppFormasPagos
 * @package App\Facades\Utilidades
 */
class AppFormasPagos extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'appformaspagos';
	}
}
