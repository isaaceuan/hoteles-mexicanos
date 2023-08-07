<?php

namespace App\Core\Modelos\Formato;

use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class FormatoReglaCancelacion
 * @package App\Core\Modelos\Formato
 */
class FormatoReglaCancelacion
{
	/**
	 * FormatoReglaCancelacion constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * @param Cotizacion $cotizacion
	 * @param bool 		 $soloVigentes
	 *
	 * @return mixed
	 */
	public function getFormato($cotizacion, $soloVigentes = false)
	{
		if ($cotizacion->tieneReglaCancelacion()) :
			$restricciones = [];
			if ($cotizacion->getReglaCancelacion()->tieneRestricciones()) :
				foreach ($cotizacion->getReglaCancelacion()->getRestricciones() as $restriccion) :
					if ($soloVigentes) {
						if (strtotime($restriccion->getFechaLimite()) >= strtotime("now")) {
							$restricciones[] = [
								'dias_entrada' => $restriccion->getDiasEntrada(),
								'tasa'         => $restriccion->getTasa(),
								'fecha_limite' => $restriccion->getFechaLimite(),
								'reembolso'    => $restriccion->getReembolso()
							];
						}
					} else {
						$restricciones[] = [
							'dias_entrada' => $restriccion->getDiasEntrada(),
							'tasa'         => $restriccion->getTasa(),
							'fecha_limite' => $restriccion->getFechaLimite(),
							'reembolso'    => $restriccion->getReembolso()
						];
					}
				endforeach;
			endif;
			return [
				'regla_cancelacion_id' => $cotizacion->getReglaCancelacion()->getReglaCancelacionId(),
				'es_reembolsable'      => $cotizacion->getReglaCancelacion()->esReembolsable(),
				'restricciones'        => $restricciones
			];
		endif;
		return null;
	}
}
