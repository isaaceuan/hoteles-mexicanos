<?php

namespace App\Core\Utilidades;

use App;
use AppBusqueda;
use App\Core\EasyRez\Solicitudes\GetComplemento;
use App\Core\EasyRez\Solicitudes\GetComplementos;
use Cache;
use Illuminate\Support\Facades\Log;
use Request;

/**
 * Class AppComplementos
 * @package App\Core\Utilidades
 */
class AppComplementos
{
	/**
	 */
	public function listarIndexado(){
		$complementos = $this->listar();
		$complementosIdx = [];
		foreach ($complementos as $complemento):
			$complementosIdx[$complemento->id] = $complemento;
		endforeach;
		return $complementosIdx;
	}

	/**
	 */
	public function listar()
	{
		$idioma = App::getLocale();
		Log::debug('AppComplementos -> listar -> SDK');
		$complementos = GetComplementos::ejecutar($idioma);
		return $complementos;
	}

	/**
	 */
	public function cotizar($complementoId, $adultos, $ninos1, $ninos2, $ninos3, $unidades)
	{
		Log::debug('AppComplementos -> cotizar -> SDK');
		$busqueda = AppBusqueda::recuperar();
		return GetComplemento::cotizar(
			$complementoId,
			$busqueda->getLlegada(),
			$busqueda->getNoches(),
			$adultos,
			$ninos1,
			$ninos2,
			$ninos3,
			$unidades,
			App::getLocale()
		);
	}
}
