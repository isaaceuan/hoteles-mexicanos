<?php

namespace App\Core\EasyRez;

use Exception;

/**
 * Class EasyRezApp
 *
 * @package App\Core\EasyRez
 */
class EasyRezRequest
{
	/**
	 *
	 * @var string
	 */
	protected $metodo;

	/**
	 *
	 * @var string
	 */
	protected $recurso;

	/**
	 *
	 * @var array
	 */
	protected $encabezados = [];

	/**
	 *
	 * @var array
	 */
	protected $datos = [];

	/**
	 * @param EasyRezApp $app
	 * @param string     $metodo
	 * @param string     $recurso
	 * @param string     $idioma
	 * @param array      $datos
	 *
	 * @throws Exception
	 */
	public function __construct(EasyRezApp $app, $metodo, $recurso, $idioma, array $datos = [])
	{
		$this->setEncabezados($app->getId(), $app->getKey(), $app->getRefer(), $idioma);
		$this->setMetodo($metodo);
		$this->setRecurso($recurso);
		$this->setDatos($datos);
	}

	/**
	 * @param string $id
	 * @param string $secret
	 * @param string $idioma
	 *
	 * @return EasyRezRequest
	 */
	public function setEncabezados($id, $secret, $refer, $idioma)
	{
		$this->encabezados = [
			'Referer'         => $refer,
			'X-CLIENT-ID'     => $id,
			'X-CLIENT-SECRET' => $secret,
			'X-IDIOMA'        => $idioma,
		];
		return $this;
	}

	/**
	 * @return array
	 */
	public function getEncabezados()
	{
		return $this->encabezados;
	}

	/**
	 * @param string $metodo
	 *
	 * @return EasyRezRequest
	 *
	 * @throws Exception
	 */
	public function setMetodo($metodo)
	{
		$this->metodo = strtoupper($metodo);
		if (!$this->metodo):
			throw new Exception('Método HTTP no especificado.');
		endif;
		if (!in_array($this->metodo, ['GET', 'POST', 'PUT', 'PATCH'])):
			throw new Exception('Método HTTP inválido.');
		endif;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMetodo()
	{
		return $this->metodo;
	}

	/**
	 * @param string $recurso
	 *
	 * @return EasyRezRequest
	 */
	public function setRecurso($recurso)
	{
		$this->recurso = $recurso;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRecurso()
	{
		return $this->recurso;
	}

	/**
	 * @param array $datos
	 *
	 * @return EasyRezRequest
	 */
	public function setDatos($datos)
	{
		$this->datos = $datos;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getDatos()
	{
		switch ($this->metodo) {
			case 'GET':
				return [
					'query'   => $this->datos,
					'headers' => $this->getEncabezados()
				];
				break;
				
			default:
				return [
					'json'    => ($this->datos),
					'headers' => $this->getEncabezados()
				];
				break;
		}
	}
}
