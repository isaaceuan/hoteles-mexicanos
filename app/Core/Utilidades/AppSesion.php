<?php

namespace App\Core\Utilidades;

use Session;

/**
 * Class AppSesion
 * @package App\Core\Utilidades
 */
class AppSesion
{
	/**
	 * @var string
	 */
	private $_nombreSesion;

	/**
	 * @var string
	 */
	private $_minutosInactividad;

	/**
	 * AppSesion constructor.
	 */
	public function __construct()
	{
		$this->_nombreSesion = 'sesionv1';
		$this->_minutosInactividad = 30;
	}

	/**
	 */
	public function renovar()
	{
		Session::put('ultima_actividad', time());
	}

	/**
	 */
	public function estado()
	{
		if (Session::has('ultima_actividad')):
			$segundosInactividad = $this->_minutosInactividad * 60;
			$horaActual = time();
			$tiempo = $horaActual - Session::get('ultima_actividad');
			return [
				'existe'                 => true,
				'vigente'                => $segundosInactividad > $tiempo,
				'segundos_transcurridos' => $tiempo,
				'segundos_maximo'        => $segundosInactividad
			];
		endif;
		return [
			'existe'                 => false,
			'vigente'                => false,
			'segundos_transcurridos' => null,
			'segundos_maximo'        => null
		];
	}
}
