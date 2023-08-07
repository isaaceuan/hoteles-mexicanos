<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetDisponibilidad
 * @package App\Core\EasyRez\Solicitudes
 */
class GetDisponibilidad extends EasyRez
{
	/**
	 * @param string      $fechaEntrada
	 * @param int         $noches
	 * @param int|null    $adultos
	 * @param int|null    $ninos1
	 * @param int|null    $ninos2
	 * @param int|null    $ninos3
	 * @param string|null $promoCode
	 * @param bool        $porTarifa
	 * @param int|null    $tarifaId
	 * @param int|null    $tipoHabitacionId
	 * @param int|null    $reservacionId
	 * @param string      $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar($fechaEntrada, $noches, $adultos = null, $ninos1 = null, $ninos2 = null, $ninos3 = null, $promoCode = null, $porTarifa = false, $tarifaId = null, $tipoHabitacionId = null, $reservacionId= null, $idiomaId = 'es')
	{
		$temp = new self();

		$data = [
			'fecha_entrada' => $fechaEntrada,
			'noches'        => (int) $noches,
			'por_tarifa'    => $porTarifa
		];

		if ($adultos !== null): $data['adultos'] = (int) $adultos; endif;
		if ($ninos1 !== null): $data['ninos1'] = (int) $ninos1; endif;
		if ($ninos2 !== null): $data['ninos2'] = (int) $ninos2; endif;
		if ($ninos3 !== null): $data['ninos3'] = (int) $ninos3; endif;
		if ($promoCode !== null): $data['promo_code'] = $promoCode; endif;
		if ($tarifaId !== null): $data['tarifa_id'] = (int) $tarifaId; endif;
		if ($tipoHabitacionId !== null): $data['tipo_habitacion_id'] = (int) $tipoHabitacionId; endif;
		if ($reservacionId !== null): $data['reservacion_id'] = (int) $reservacionId; endif;

		return $temp->get('disponibilidad', $idiomaId, $data);
	}
}
