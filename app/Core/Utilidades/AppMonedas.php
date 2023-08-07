<?php

namespace App\Core\Utilidades;

use Cache;
use Request;
use Session;

use App\Core\EasyRez\Solicitudes\GetMonedas;
use App\Core\EasyRez\Solicitudes\GetPropiedad;

/**
 * Class AppMonedas
 * @package App\Core\Utilidades
 */
class AppMonedas
{
	/**
	 * @var string $_name
	 */
	private $_name;

	/**
	 */
	public function establecerMonedaDefault()
	{
		$propiedad = GetPropiedad::ejecutar();
		$monedas = $this->listar();
		if (!$this->existeSesion()):
			$monedasLista = $monedas;
			$monedaDefault = new \stdClass;
			$monedaDefault->id = $propiedad->moneda_id;
			$monedaDefault->tipo_cambiario = 0;
			foreach ($monedasLista as $key => $value):
				if ($key == $propiedad->moneda_id):
					$monedaDefault->id = $key;
					$monedaDefault->tipo_cambiario = $value->tipo_cambio;
				endif;
			endforeach;
			$this->setMonedaActual($monedaDefault);
		endif;
	}

	/**
	 * AppMonedas constructor.
	 */
	public function __construct()
	{
		$this->_name = 'monedaActual';
	}

	/**
	 * @return bool
	 */
	public function existeSesion()
	{
		return Session::has($this->_name);
	}

	/**
	 * @return string
	 */
	public function getMonedaActual()
	{
		return Session::get($this->_name, null);
	}

	/**
	 * @param $moneda
	 *
	 * @return mixed
	 */
	public function setMonedaActual($moneda)
	{
		Session::put($this->_name, $moneda);
		return $moneda;
	}

	/**
	 *
	 */
	public function terminarSesion()
	{
		if (Session::has($this->_name)):
			Session::forget($this->_name);
		endif;
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 * @deprecated
	 *
	 */
	public function getMonedas()
	{
		return $this->listar();
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function listar()
	{
		$prefijo = 'monedasv1';
		$minutos = 60;
		$host = Request::getHost();

		$nombreCahe = md5($prefijo . $host);
		$monedas = Cache::get($nombreCahe);

		if ($monedas):
			\Log::debug('AppMonedas -> listar -> Cache');
			return $monedas;
		endif;

		\Log::debug('AppMonedas -> listar -> SDK');
		$monedas = GetMonedas::ejecutar();
		Cache::put($nombreCahe, $monedas, $minutos * 60);
		return $monedas;
	}
}
