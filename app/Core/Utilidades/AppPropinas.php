<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetPropinas;
use Cache;
use Illuminate\Support\Facades\Log;
use Request;

/**
 * Class AppPropinas
 * @package App\Core\Utilidades
 */
class AppPropinas
{
	/**
	 */
	public function listarIndexado()
	{
		$propinas = $this->listar();
		$propinasIdx = [];
		foreach ($propinas as $propina):
			$propinasIdx[$propina->id] = $propina;
		endforeach;
		return $propinasIdx;
	}

	/**
	 */
	public function listar()
	{
		$idioma = App::getLocale();
		Log::debug('AppPropinas -> listar -> SDK');
		$propinas = GetPropinas::ejecutar($idioma);
		return $propinas;
	}
}
