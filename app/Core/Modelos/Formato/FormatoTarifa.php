<?php

namespace App\Core\Modelos\Formato;

/**
 * Class FormatoTarifa
 * @package App\Core\Modelos\Formato
 */
class FormatoTarifa
{
	/**
	 * FormatoTarifa constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param int   $tarifaId
	 * @param mixed $tarifasIndexadas
	 *
	 * @return mixed
	 */
	public function getFormato($tarifaId, $tarifasIndexadas)
	{
		if (isset($tarifasIndexadas[$tarifaId])):
			$tarifa = $tarifasIndexadas[$tarifaId];
			$planAlimento = null;
			$conPlanAlimento = false;
			if (isset($tarifa->plan_alimento)):
				$conPlanAlimento = true;
				$planAlimento = [
					'id'          => $tarifa->plan_alimento->id,
					'nombre'      => $tarifa->plan_alimento->nombre,
					'descripcion' => $tarifa->plan_alimento->descripcion
				];
			endif;
			return [
				'id'                => $tarifa->id,
				'nombre'            => $tarifa->nombre,
				'descripcion'       => $tarifa->descripcion,
				'con_plan_alimento' => $conPlanAlimento,
				'plan_alimento'     => $planAlimento
			];
		endif;
		return null;
	}
}
