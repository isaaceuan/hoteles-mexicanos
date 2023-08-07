<?php

namespace App\Core\Modelos\Formato;

use App\Core\Modelos\Cotizacion\Cotizacion;
use App\Core\Modelos\Promocion\Promocion;

/**
 * Class FormatoPromociones
 * @package App\Core\Modelos\Formato
 */
class FormatoPromociones
{
	/**
	 * FormatoPromociones constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param Promocion[] $promociones
	 *
	 * @return boolean
	 */
	
	public function tienePromociones($promociones)
	{
		return count($promociones) > 0;
	}
	
	/**
	 * @param Promocion[] $promociones
	 *
	 * @return mixed
	 */
	public function getFormato($promociones)
	{
		$promocionesAux = [];
		foreach ($promociones as $promocion):
			$promocionesAux[] = [
				'id'     => $promocion->getId(),
				'nombre' => $promocion->getNombre(),
				'descripcion' => $promocion->getDescripcion(),
				'es_tasa' => $promocion->esTasa(),
				'descuento' => $promocion->getDescuento()
			];
		endforeach;
		return $promocionesAux;
	}
}
