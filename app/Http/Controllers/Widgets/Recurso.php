<?php namespace App\Http\Controllers\Widgets;

/**
 * Representa un recurso de un widget.
 *
 * @package App\Models\Widgets
 */
final class Recurso {

	/**
	 * Tipo de recurso: js o css
	 *
	 * @var string
	 */
	public $type;

	/**
	 * URL al recurso.
	 *
	 * @var string
	 */
	public $src;

	/**
	 * Orden de carga del recurso.
	 *
	 * @var int
	 */
	public $order;

	/**
	 * Crea una nueva instancia a un recurso.
	 *
	 * @param string $type
	 * @param string $src
	 * @param int $order (Opcional)
	 */
	public function __construct($type, $src, $order = 999) {
		$this->type = $type;
		$this->src = $src;
		$this->order = $order;
	}

}
