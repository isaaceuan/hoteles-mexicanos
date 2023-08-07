<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppCarrito extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'appcarrito';
	}
}
