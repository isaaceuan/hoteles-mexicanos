<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetRestriccionesCalendario
 * @package App\Core\EasyRez\Solicitudes
 */
class GetRestriccionesCalendario extends EasyRez
{
	/**
	 * @param int    $anio
	 * @param int    $mes
	 * @param int    $noches
	 * @param string $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar($anio, $mes, $noches, $idiomaId = 'es')
	{
		$temp = new self();
		$data = [
			'anio'   => $anio,
			'mes'    => $mes,
			'noches' => $noches
		];
		return $temp->get('restricciones-calendario', $idiomaId, $data);
	}
}