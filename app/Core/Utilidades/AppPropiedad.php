<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetPropiedad;
use App\Core\EasyRez\Solicitudes\GetPropiedadMotor;
use Cache;
use Request;

/**
 * Class AppPropiedad
 * @package App\Core\Utilidades
 */
class AppPropiedad
{
	/**
	 * @return mixed
	 * @throws \Exception
	 * @deprecated
	 *
	 */
	public function getPropiedad()
	{
		return $this->recuperar();
	}

	/**
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function recuperarConfiguracion()
	{
		$idioma = App::getLocale();
		\Log::debug('AppPropiedad -> recuperarConfiguracion -> Cache');
		$propiedad = GetPropiedadMotor::ejecutar($idioma);
		return $propiedad;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function recuperar()
	{

		$idiomaId = App::getLocale();
		\Log::debug('AppPropiedad -> recuperar -> SDK');
		$propiedad = GetPropiedad::ejecutar($idiomaId);
		\Log::debug('AppPropiedad -> recuperar -> finalizado');
		return $propiedad;
	}
}
