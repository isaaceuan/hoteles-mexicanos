<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AppFormasPagos;
use Validator;

/**
 * Class PrepararController
 * @package App\Http\Controllers\Api
 */
class PrepararController extends Controller
{
	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function prepararPago(Request $request)
	{
		$validation_rules = [
			'titular.nombres'   => 'required',
			'titular.apellidos' => 'required',
			'titular.correo'    => 'required|email',
			'forma_pago'        => 'required',
			'titular.telefono'  => 'required',
		];
		
		$validator = Validator::make($request->all(), $validation_rules);
		
		if ($validator->fails()) {
			return response()->json(
				[
					'success' => false,
					'message' => $validator->errors()
				],
				422
			);
		}
		
		$formaPago = $request->get('forma_pago');
		$parametros = $request->get('parametros');
		$titular = $request->get('titular');
		$respuesta = AppFormasPagos::prepararPago($formaPago, $parametros, $titular);
		return response()->json($respuesta);
	}
}
