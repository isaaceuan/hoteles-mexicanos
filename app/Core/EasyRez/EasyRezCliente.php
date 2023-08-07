<?php

namespace App\Core\EasyRez;

use Exception;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class EasyRezClient
 *
 * @package App\Core\EasyRez
 */
class EasyRezCliente
{
	/**
	 *
	 * @const string
	 */
	const URL_PRODUCTION = 'https://pms.app-webservices.net/booking-engine/v1/';
	/**
	 *
	 * @const string
	 */
	const URL_SANDBOX = 'https://pms.sbx.app-webservices.net/booking-engine/v1/';
	/**
	 *
	 * @const string
	 */
	const URL_DEVELOPER = 'https://pms.dev.app-webservices.net/booking-engine/v1/';

	/**
	 * @var bool
	 */
	protected $_entorno = 'developer';

	/**
	 * @var Client.
	 */
	protected Client $_httpClientHandler;

	/**
	 * @param string $entorno
	 *
	 * @throws Exception
	 */
	public function __construct($entorno)
	{
		$this->_entorno = $entorno;
		$this->_httpClientHandler = new Client(
			[
				'verify' => false
			]
		);
	}

	/**
	 * @return string
	 */
	public function getApiUrl()
	{
		if ($this->_entorno === 'production'):
			return static::URL_PRODUCTION;
		endif;

		if ($this->_entorno === 'sandbox'):
			return static::URL_SANDBOX;
		endif;

		return static::URL_DEVELOPER;
	}

	/**
	 * @param EasyRezRequest $request
	 *
	 * @return array
	 */
	private function _prepareRequestMessage(EasyRezRequest $request)
	{
		return [
			$this->getApiUrl() . $request->getRecurso(),
			$request->getMetodo(),
			$request->getDatos(),
		];
	}

	/**
	 * @param EasyRezRequest $request
	 *
	 * @return mixed
	 *
	 * @throws Exception|GuzzleException
	 */
	public function sendRequest(EasyRezRequest $request)
	{
		[$url, $method, $body] = $this->_prepareRequestMessage($request);
		return $this->_httpClientHandler->request($method, $url, $body);
	}
}
