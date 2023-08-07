<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetTarifas;
use Cache;
use Illuminate\Support\Facades\Log;
use Request;

/**
 * Class AppTarifas
 * @package App\Core\Utilidades
 */
class AppTarifas
{
	/**
	 */
	public function listarIndexado()
	{
		$tarifas = $this->listar();
		$tarifasIdx = [];
		foreach ($tarifas as $tarifa):
			$tarifasIdx[$tarifa->id] = $tarifa;
		endforeach;
		return $tarifasIdx;
	}
	
	/**
	 */
	public function listar()
	{
		$prefijo = 'tarifasv1';
		$minutos = 5;
		$idioma = App::getLocale();
		$host = Request::getHost();
		
		$nombreCache = md5($prefijo . $idioma . $host);
		$tarifas = Cache::get($nombreCache);
		
		if ($tarifas):
			Log::debug('AppTarifas -> listar -> Cache');
			return $tarifas;
		endif;
		
		Log::debug('AppTarifas -> listar -> SDK');
		$tarifas = GetTarifas::ejecutar($idioma);
		Cache::put($nombreCache, $tarifas, $minutos * 60);
		return $tarifas;
	}
}