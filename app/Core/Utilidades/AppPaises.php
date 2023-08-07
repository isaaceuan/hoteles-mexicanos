<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetPaises;
use Cache;
use Request;

/**
 * Class AppPaises
 * @package App\Core
 */
class AppPaises
{
	/**
	 * @deprecated
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getPaises()
	{
		return $this->listar();
	}
	
	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function listar()
	{
		$prefijo = 'paisesv1';
		$minutos = 120;
		$host = Request::getHost();
		
		$nombreCahe =  md5($prefijo . $host);
		$paises = Cache::get($nombreCahe);
		
		if ($paises):
			\Log::debug('AppPaises -> listar -> Cache');
			return $paises;
		endif;
		
		\Log::debug('AppPaises -> listar -> SDK');
		$paises = GetPaises::ejecutar();
		Cache::put($nombreCahe, $paises, $minutos * 60);
		return $paises;
	}
}