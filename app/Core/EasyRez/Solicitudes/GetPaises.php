<?php
namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetPaises
 * @package App\Core\EasyRez\Solicitudes
 */
class GetPaises extends EasyRez
{
	/**
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar()
	{
		$temp = new self();
		return $temp->get('paises', 'es');
	}
}