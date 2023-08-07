<?php
/**
 * Created by PhpStorm.
 * User: Elvira
 * Date: 17/04/2020
 * Time: 11:31 AM
 */

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetIdiomas
 * @package App\Core\EasyRez\Solicitudes
 */
class GetIdiomas extends EasyRez
{
	/**
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar()
	{
		$temp = new self();
		return $temp->get('idiomas', 'es');
	}
}