<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppTransaccion extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'apptransaccion';
	}
}
