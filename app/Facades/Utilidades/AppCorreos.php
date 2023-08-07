<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppCorreos extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'appcorreos';
	}
}
