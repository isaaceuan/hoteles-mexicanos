<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetMonedas
 * @package App\Core\EasyRez\Solicitudes
 */
class GetMonedas extends EasyRez
{
	/**
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar()
	{
		$temp = new self();
		return $temp->get('monedas', 'es');
	}
}