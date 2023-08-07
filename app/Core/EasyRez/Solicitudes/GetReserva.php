<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetReserva
 * @package App\Core\EasyRez\Solicitudes
 */
class GetReserva extends EasyRez
{
	/**
	 * @param int    $reservaId
	 * @param string $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar($reservaId, $idiomaId = 'es')
	{
		$relaciones = [
			'detalles',
			'detalles.promocion',
			'tarifa',
			'huesped.contacto',
			'huesped.domicilio',
			'huesped.preferencias',
			'plan_alimento',
			'complementos.complemento',
			'regla_modificacion',
			'regla_cancelacion.restricciones'
		];
		$data = [
			'reserva_id' => $reservaId,
			'with'       => implode(',', $relaciones)
		];
		$temp = new self();
		return $temp->get('reserva', $idiomaId, $data);
	}
	
	/**
	 * @param string $folio
	 * @param string $correo
	 * @param string $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutarPorFolioCorreo($folio, $correo, $idiomaId = 'es')
	{
		$relaciones = [
			'detalles',
			'detalles.promocion',
			'tarifa',
			'huesped.contacto',
			'huesped.domicilio',
			'huesped.preferencias',
			'plan_alimento',
			'complementos.complemento',
			'regla_modificacion',
			'regla_cancelacion.restricciones'
		];
		$data = [
			'folio'  => $folio,
			'correo' => $correo,
			'with'   => implode(',', $relaciones)
		];
		$temp = new self();
		return $temp->get('reserva', $idiomaId, $data);
	}
}
