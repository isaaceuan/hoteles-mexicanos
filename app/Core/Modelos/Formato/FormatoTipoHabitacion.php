<?php

namespace App\Core\Modelos\Formato;

/**
 * Class FormatoTipoHabitacion
 * @package App\Core\Modelos\Formato
 */
class FormatoTipoHabitacion
{
	/**
	 * FormatoTipoHabitacion constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param int   $tipoHabitacionId
	 * @param mixed $tiposHabitacionesIndexadas
	 *
	 * @return mixed
	 */
	public function getFormato($tipoHabitacionId, $tiposHabitacionesIndexadas)
	{
		if (isset($tiposHabitacionesIndexadas[$tipoHabitacionId])):
			$tipoHabitacion = $tiposHabitacionesIndexadas[$tipoHabitacionId];
			return [
				'id'          => $tipoHabitacion->id,
				'nombre'      => $tipoHabitacion->nombre,
				'descripcion' => $tipoHabitacion->descripcion,
				'imagenes'    => $tipoHabitacion->imagenes,
				'ocupacion'   => $tipoHabitacion->ocupacion,
				'adultos'     => $tipoHabitacion->adultos,
				'ninos'       => $tipoHabitacion->ninos
			];
		endif;
		return null;
	}
}
