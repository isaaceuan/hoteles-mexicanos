<?php
namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetTiposHabitaciones
 * @package App\Core\EasyRez\Solicitudes
 */
class GetTiposHabitaciones extends EasyRez
{
	/**
	 * @param string $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar($idiomaId = 'es')
	{
		$temp = new self();
		$data = [];
		return $temp->get('tipos-habitaciones', $idiomaId, $data);
	}
}