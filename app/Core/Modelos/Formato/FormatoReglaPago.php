<?php

namespace App\Core\Modelos\Formato;

use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class FormatoReglaPago
 * @package App\Core\Modelos\Formato
 */
class FormatoReglaPago
{
	/**
	 * FormatoReglaModificacion constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param Cotizacion $cotizacion
	 * @param float      $nuevoAnticipo
	 *
	 * @return mixed
	 */
	public function getFormato($cotizacion, $nuevoAnticipo = null)
	{
		if ($cotizacion->tieneReglaPago()):
			$anticipo = $cotizacion->getReglaPago()->getAnticipo();
			if ($nuevoAnticipo !== null) $anticipo = $nuevoAnticipo;
			return [
				'regla_pago_id' => $cotizacion->getReglaPago()->getReglaPagoId(),
				'modo'          => $cotizacion->getReglaPago()->getModo(),
				'valor'         => $cotizacion->getReglaPago()->getValor(),
				'anticipo'      => $anticipo,
			];
		endif;
		return null;
	}
}
