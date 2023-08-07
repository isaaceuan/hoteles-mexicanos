<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetIdiomas;
use Cache;
use Request;

/**
 * Class AppIdiomas
 * @package App\Core\Traducciones
 */
class AppIdiomas
{

    /**
     * @return string
     */
    public function getCodigoDefault()
    {
        return App::getLocale();
    }
	
	/**
	 * @param string $idioma
	 */
	public function setCodigoDefault($idioma = 'es')
    {
        App::setLocale($idioma);
    }

    /**
	 * @deprecated
	 *
	 * @return mixed
	 * @throws \Exception
     */
    public function getIdiomas()
    {
		return $this->listar();
    }
	
	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function listar()
	{
		$prefijo = 'idiomasv1';
		$minutos = 120;
		$host = Request::getHost();
		
		$nombreCahe = $prefijo . $host;
		$idiomas = Cache::get($nombreCahe);
		
		if ($idiomas):
			\Log::debug('AppIdiomas -> listar -> Cache');
			return $idiomas;
		endif;
		
		\Log::debug('AppIdiomas -> listar -> SDK');
		$idiomas = GetIdiomas::ejecutar();
		Cache::put('idi' . $host, $idiomas, $minutos * 60);
		return $idiomas;
	}
}