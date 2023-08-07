<?php

namespace App\Core\Utilidades;

use Exception;
use GeoIp2\Database\Reader;
use Log;

class AppUbicacion
{
	private Reader $_reader;
	
	public function __construct()
	{
		try {
			$this->_reader = new Reader(storage_path('maxmind/GeoLite2-Country.mmdb'));
		}
		catch (Exception $ex) {
			Log::warning('No fue posible cargar la base de datos de MaxMind -> ' . $ex->getMessage());
		}
	}
	
	public function getPaisCodigo(string $ip): ?string
	{
		if (empty($this->_reader)) return null;
		try {
			$registro = $this->_reader->country($ip);
			return $registro->country->isoCode;
		}
		catch (Exception $ex) {
			Log::warning('No fue posible recuperar la ubicación de la IP ' . $ip . ' -> ' . $ex->getMessage());
			return null;
		}
	}
}