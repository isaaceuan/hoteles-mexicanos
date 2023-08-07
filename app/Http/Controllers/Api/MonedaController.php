<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use AppMonedas;
use Illuminate\Http\Request;

/**
 * Class MonedaController
 * @package App\Http\Controllers\Api
 */
class MonedaController extends Controller
{
	public function monedaActual()
	{
		return response()->json(AppMonedas::getMonedaActual());
	}
	
	public function cambiarMonedaActual(Request $request)
	{
		$result = AppMonedas::setMonedaActual($request->all());
		return response()->json([$result], 200);
	}
}