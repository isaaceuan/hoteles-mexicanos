<?php
namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetTarjetasCredito
 * @package App\Core\EasyRez\Solicitudes
 */
class GetTarjetasCredito extends EasyRez
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
		return $temp->get('tarjetas-credito', $idiomaId, $data);
	}
}
