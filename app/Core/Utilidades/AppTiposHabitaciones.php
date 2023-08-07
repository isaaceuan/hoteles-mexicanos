<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetTiposHabitaciones;
use Cache;
use Illuminate\Support\Facades\Log;
use Request;

/**
 * Class AppTiposHabitaciones
 * @package App\Core\Utilidades
 */
class AppTiposHabitaciones
{
	/**
	 */
	public function listarIndexado()
	{
		$tiposHabitaciones = $this->listar();
		$tiposHabitacionesIdx = [];
		foreach ($tiposHabitaciones as $tipoHabitacion):
			$tiposHabitacionesIdx[$tipoHabitacion->id] = $tipoHabitacion;
		endforeach;
		return $tiposHabitacionesIdx;
	}
	
	/**
	 */
	public function listar()
	{
		$prefijo = 'thabitacionesv1';
		$minutos = 5;
		$idioma = App::getLocale();
		$host = Request::getHost();
		
		$nombreCache = md5($prefijo . $idioma . $host);
		$tiposHabitaciones = Cache::get($nombreCache);
		
		if ($tiposHabitaciones):
			Log::debug('AppTiposHabitaciones -> listar -> Cache');
			return $tiposHabitaciones;
		endif;
		
		Log::debug('AppTiposHabitaciones -> listar -> SDK');
		$tiposHabitaciones = GetTiposHabitaciones::ejecutar($idioma);
		Cache::put($nombreCache, $tiposHabitaciones, $minutos * 60);
		return $tiposHabitaciones;
	}
}