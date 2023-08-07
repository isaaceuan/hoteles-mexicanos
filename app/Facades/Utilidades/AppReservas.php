<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppReservas extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'appreservas';
	}
}
