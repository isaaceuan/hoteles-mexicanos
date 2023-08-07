<?php

namespace App\Http\Controllers\Api;

use App\Core\EasyRez\Solicitudes\GetRestricciones;
use App\Core\EasyRez\Solicitudes\GetRestriccionesCalendario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class RestriccionController
 * @package App\Http\Controllers\Api
 */
class RestriccionController extends Controller
{
	public function restricciones(Request $request)
	{
		$restricciones = GetRestricciones::ejecutar(
			$request->input('fecha_entrada'),
			$request->input('noches'),
			$request->input('idioma_id', 'es')
		);
		return response()->json($restricciones, 200);
	}
	
	public function restriccionesCalendario(Request $request)
	{
		$restricciones = GetRestriccionesCalendario::ejecutar(
			$request->input('anio'),
			$request->input('mes'),
			$request->input('noches'),
			$request->input('idioma_id', 'es')
		);
		return response()->json($restricciones, 200);
	}
}
