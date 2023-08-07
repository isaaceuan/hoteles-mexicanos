<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetTitulos;
use Cache;
use Illuminate\Support\Facades\Log;
use Request;

/**
 * Class AppTitulos
 * @package App\Core
 */
class AppTitulos
{
	/**
	 * @return mixed
	 * @throws \Exception
	 * @deprecated
	 *
	 */
	public function getTitulos()
	{
		return $this->listar();
	}
	
	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function listar()
	{
		$prefijo = 'titulosv1';
		$minutos = 5;
		$idioma = App::getLocale();
		$host = Request::getHost();
		
		$nombreCahe = md5($prefijo . $idioma . $host);
		$titulos = Cache::get($nombreCahe);
		
		if ($titulos):
			Log::debug('AppTitulos -> listar -> Cache');
			return $titulos;
		endif;
		
		Log::debug('AppTitulos -> listar -> Cache');
		$titulos = GetTitulos::ejecutar($idioma);
		Cache::put($nombreCahe, $titulos, $minutos * 60);
		return $titulos;
	}
}