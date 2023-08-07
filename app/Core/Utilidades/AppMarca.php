<?php

namespace App\Core\Utilidades;

use AppColores;
use App;
use App\Core\EasyRez\Solicitudes\GetMarca;
use Cache;
use Request;

/**
 * Class AppMarca
 * @package App\Core\Traducciones
 */
class AppMarca
{
	/**
	 * @deprecated
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function getMarca()
	{
		return $this->recuperar();
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function recuperar()
	{

		$idioma = App::getLocale();
		\Log::debug('AppMarca -> recuperar -> SDK');
		$marca = GetMarca::ejecutar($idioma);
		return $marca;
	}

	public function getEstilosMarca()
	{
		$marca = $this->recuperar();
		$marcaAux = new \stdClass();
		$marcaAux->color_acento = $marca->color_acento;
		$marcaAux->color_claro = $marca->color_claro;
		$marcaAux->color_acento_hover = AppColores::hexRgbHex($marca->color_acento, 18);
		$marcaAux->color_acento_restriccion_entrada = AppColores::hexRgbHex($marca->color_acento, 80);
		$marcaAux->color_acento_restriccion_salida = AppColores::hexRgbHex($marca->color_acento, 50);
		$marcaAux->mobilscroll_acento_hover = AppColores::hexRgbHex($marca->color_acento, 90);
		return $marcaAux;
	}
}
