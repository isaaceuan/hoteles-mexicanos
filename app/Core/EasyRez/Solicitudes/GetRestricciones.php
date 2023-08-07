<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetRestricciones
 * @package App\Core\EasyRez\Solicitudes
 */
class GetRestricciones extends EasyRez
{
	/**
	 * @param string $fechaEntrada
	 * @param int    $noches
	 * @param string $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar($fechaEntrada, $noches, $idiomaId = 'es')
	{
		$temp = new self();
		$data = [
			'fecha_entrada' => $fechaEntrada,
			'noches'        => $noches
		];
		return $temp->get('restricciones', $idiomaId, $data);
	}
}