<?php

namespace App\Core\EasyRez;

use Exception;

/**
 * Class EasyRez
 *
 * @package App\Core\EasyRez
 */
class EasyRez
{
	const ENV_DEV = 'developer';
	const ENV_SBX = 'sandbox';
	const ENV_PRD = 'production';
	/**
	 *
	 * @const string
	 */
	const VERSION = '1.0.0';
	/**
	 *
	 * @const string
	 */
	const APP_VERSION = '1';
	/**
	 *
	 * @const string
	 */
	const APP_ID = 'EASY_REZ_ID';
	/**
	 *
	 * @const string
	 */
	const APP_KEY = 'EASY_REZ_KEY';
	/**
	 *
	 * @const string
	 */
	const APP_ENV = 'EASY_REZ_ENV';
	/**
	 *
	 * @const string
	 */
	const APP_REFER = 'EASY_REZ_REFER';

	/**
	 * Entidad Easy-Rez
	 *
	 * @var EasyRezApp
	 */
	protected $app;

	/**
	 *
	 * @var EasyRezCliente
	 */
	protected $_client;

	/**
	 *
	 * @var mixed
	 */
	protected $_lastResponse;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$config = array_merge(
			[
				'app_id'      => env(static::APP_ID, null),
				'app_key'     => env(static::APP_KEY, null),
				'app_version' => static::APP_VERSION,
				'app_env'     => env(static::APP_ENV, null),
				'app_refer'     => env(static::APP_REFER, \Request::getHost()),
			]
		);

		if (!$config['app_id']) {
			throw new Exception('El "app_id" es requerido, asignalo a la variable de entorno "' . static::APP_ID . '"');
		}
		if (!$config['app_key']) {
			throw new Exception('El "app_key" es requerido, asignalo a la variable de entorno "' . static::APP_KEY . '"');
		}
		if (!$config['app_env']) {
			throw new Exception(
				'El "app_env" es requerido, asignalo a la variable de entorno "' . static::APP_ENV . '" posibles valores: "' . self::ENV_DEV . '", "' . self::ENV_SBX . '", "' . self::ENV_PRD . '"'
			);
		}
		if (!in_array($config['app_env'], [self::ENV_DEV, self::ENV_SBX, self::ENV_PRD])) {
			throw new Exception('Los valores permitidor para "' . static::APP_ENV . 'son: "' . self::ENV_DEV . '", "' . self::ENV_SBX . '", "' . self::ENV_PRD . '"');
		}

		$this->app = new EasyRezApp($config['app_id'], $config['app_key'], $config['app_refer']);

		$this->_client = new EasyRezCliente($config['app_env']);

		$this->_lastResponse = null;
	}

	/**
	 * @param string $endpoint
	 * @param string $idioma
	 * @param array  $params
	 *
	 * @return mixed
	 * @throws Exception
	 */
	protected function get($endpoint, $idioma, array $params = [])
	{
		return $this->_sendRequest(
			'GET',
			$endpoint,
			$idioma,
			$params
		);
	}

	/**
	 * @param string $endpoint
	 * @param string $idioma
	 * @param array  $body
	 *
	 * @return object
	 * @throws Exception
	 */
	protected function post($endpoint, $idioma, array $body = [])
	{
		return $this->_sendRequest(
			'POST',
			$endpoint,
			$idioma,
			$body
		);
	}
	
	/**
	 * @param string $endpoint
	 * @param string $idioma
	 * @param array  $body
	 *
	 * @return object
	 * @throws Exception
	 */
	protected function put(string $endpoint, string $idioma, array $body)
	{
		return $this->_sendRequest(
			'PUT',
			$endpoint,
			$idioma,
			$body
		);
	}
	
	/**
	 * @param string $endpoint
	 * @param string $idioma
	 * @param array  $body
	 *
	 * @return object
	 * @throws Exception
	 */
	protected function patch(string $endpoint, string $idioma, array $body)
	{
		return $this->_sendRequest(
			'PATCH',
			$endpoint,
			$idioma,
			$body
		);
	}

	/**
	 * @param string $method
	 * @param string $endpoint
	 * @param string $idioma
	 * @param array  $params
	 *
	 * @return object
	 *
	 * @throws Exception
	 */
	private function _sendRequest($method, $endpoint, $idioma, array $params = [])
	{
		$request = $this->_request($method, $endpoint, $idioma, $params);
		$this->_lastResponse = $this->_client->sendRequest($request);
		return json_decode($this->_lastResponse->getBody());
	}

	/**
	 * @param string $method
	 * @param string $endpoint
	 * @param string $idioma
	 * @param array  $params
	 *
	 * @return EasyRezRequest
	 *
	 * @throws Exception
	 */
	private function _request($method, $endpoint, $idioma, array $params = [])
	{
		return new EasyRezRequest(
			$this->app, $method, $endpoint, $idioma, $params
		);
	}
}
