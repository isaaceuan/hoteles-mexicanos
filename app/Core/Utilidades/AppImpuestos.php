<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\GetImpuestos;
use Cache;
use Illuminate\Support\Facades\Log;
use Request;

/**
 * Class AppImpuestos
 * @package App\Core\Utilidades
 */
class AppImpuestos
{
	/**
	 */
	public function listarIndexado()
	{
		$impuestos = $this->listar();
		$impuestosIdx = [];
		foreach ($impuestos as $impuesto):
			$impuestosIdx[$impuesto->id] = $impuesto;
		endforeach;
		return $impuestosIdx;
	}

	/**
	 */
	public function listar()
	{
		$idioma = App::getLocale();
		$impuestos = GetImpuestos::ejecutar($idioma);
		return $impuestos;
	}
}
