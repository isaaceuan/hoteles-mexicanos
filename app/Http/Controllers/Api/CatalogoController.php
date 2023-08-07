<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use AppImpuestos;
use AppPropinas;
use AppPaises;
use AppTitulos;
use Illuminate\Http\Request;

/**
 * Class CatalogoController
 * @package App\Http\Controllers\Api
 */
class CatalogoController extends Controller
{
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function impuestos(Request $request)
	{
		return AppImpuestos::listar();
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function propinas(Request $request)
	{
		return AppPropinas::listar();
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function titulos(Request $request)
	{
		return AppTitulos::listar();
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function paises(Request $request)
	{
		return AppPaises::listar();
	}
}
