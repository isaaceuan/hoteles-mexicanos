<?php

namespace App\Core\Carrito\Elemento;

use App\Core\Modelos\Cotizacion\Complemento\Complemento;

/**
 * Class ElementoAdicional
 * @package App\Core\Carrito\Elemento
 */
class ElementoAdicional extends Complemento
{
	/**
	 * ElementoAdicional constructor.
	 *
	 * @param mixed $complemento
	 */
	public function __construct($complemento)
	{
		$complemento->incluido = false;
		parent::__construct($complemento);
	}
}