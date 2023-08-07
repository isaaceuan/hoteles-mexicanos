<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetTarifas;
use Cache;
use Illuminate\Support\Facades\Log;
use Request;

/**
 * Class AppPlanesAlimentos
 * @package App\Core\Utilidades
 */
class AppPlanesAlimentos
{
	/**
	 */
	public function listar()
	{
		$idioma = App::getLocale();
		Log::debug('AppPlanesAlimentos -> listar -> SDK');
		$planesAlimentos = GetTarifas::ejecutar($idioma);
		return $planesAlimentos;
	}
}
