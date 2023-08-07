<?php

namespace App\Core\Modelos\Formato;

use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class FormatoReglaModificacion
 * @package App\Core\Modelos\Formato
 */
class FormatoReglaModificacion
{
	/**
	 * FormatoReglaModificacion constructor.
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
		if ($cotizacion->tieneReglaModificacion()) :
			if ($soloVigentes) {
				if (strtotime($cotizacion->getReglaModificacion()->getFechaLimite()) >= strtotime("now")) {
					return [
						'regla_modificacion_id' => $cotizacion->getReglaModificacion()->getReglaModificacionId(),
						'modo'                  => $cotizacion->getReglaModificacion()->getModo(),
						'dias_anticipacion'     => $cotizacion->getReglaModificacion()->getDiasAnticipacion(),
						'modificaciones'        => $cotizacion->getReglaModificacion()->getModificaciones(),
						'fecha_limite'          => $cotizacion->getReglaModificacion()->getFechaLimite()
					];
				}
			} else {
				return [
					'regla_modificacion_id' => $cotizacion->getReglaModificacion()->getReglaModificacionId(),
					'modo'                  => $cotizacion->getReglaModificacion()->getModo(),
					'dias_anticipacion'     => $cotizacion->getReglaModificacion()->getDiasAnticipacion(),
					'modificaciones'        => $cotizacion->getReglaModificacion()->getModificaciones(),
					'fecha_limite'          => $cotizacion->getReglaModificacion()->getFechaLimite()
				];
			}
		endif;
		return null;
	}
}
