<?php

namespace App\Core\Utilidades;

use App;
use App\Core\EasyRez\Solicitudes\CreateVisita;
use Request;
use Session;

/**
 * Class AppVisita
 * @package App\Core\Utilidades
 */
class AppVisita
{
	/**
	 * @var string
	 */
	private string $_nombreSesion;
	
	/**
	 * AppVisita constructor.
	 */
	public function __construct()
	{
		$this->_nombreSesion = 'visitaV1';
	}
	
	/**
	 * @return int
	 */
	public function crearVisita(): int
	{
		if ($this->_existeSesion()) {
			return (int) $this->_recuperarSesion();
		}
		
		$ip = $this->_getIp();
		
		$visitaId = CreateVisita::crear(
			App::getLocale(),
			$ip,
			Request::userAgent(),
			Request::server('HTTP_REFERER')
		);
		
		$this->_guardarSesion($visitaId);
		return $visitaId;
	}
	
	/**
	 */
	public function vistandoDisponibilidad(): void
	{
		CreateVisita::actualizar(
			App::getLocale(),
			$this->crearVisita(),
			true
		);
	}
	
	/**
	 */
	public function vistandoComplementos(): void
	{
		CreateVisita::actualizar(
			App::getLocale(),
			$this->crearVisita(),
			null,
			true
		);
	}
	
	/**
	 */
	public function vistandoInformacion(): void
	{
		CreateVisita::actualizar(
			App::getLocale(),
			$this->crearVisita(),
			null,
			null,
			true
		);
	}
	
	public function capturandoCliente(
		string $nombres,
		string $apellidos,
		string $correo,
		?string $titulo = null,
		?string $telefono = null,
		?string $telefonoOtro = null,
		?string $direccion = null,
		?string $codigoPostal = null,
		?string $ciudad = null,
		?string $estado = null,
		?string $pais = null
	): void
	{
		CreateVisita::setCliente(
			App::getLocale(),
			$this->crearVisita(),
			$nombres,
			$apellidos,
			$correo,
			$titulo,
			$telefono,
			$telefonoOtro,
			$direccion,
			$codigoPostal,
			$ciudad,
			$estado,
			$pais
		);
	}
	
	/**
	 *
	 */
	public function visitandoCompletado(): void
	{
		CreateVisita::actualizar(
			App::getLocale(),
			$this->crearVisita(),
			null,
			null,
			null,
			true
		);
	}
	
	/**
	 * @param $fechaEntrada
	 * @param $noches
	 * @param $adultos
	 * @param $ninos1
	 * @param $ninos2
	 * @param $ninos3
	 * @param $codigoPromocional
	 */
	public function consultandoDisponibilidad($fechaEntrada, $noches, $adultos, $ninos1, $ninos2, $ninos3, $codigoPromocional): void
	{
		CreateVisita::addConsulta(
			App::getLocale(),
			$this->crearVisita(),
			$fechaEntrada,
			$noches,
			$adultos,
			$ninos1,
			$ninos2,
			$ninos3,
			$codigoPromocional
		);
	}
	
	/**
	 * @return bool
	 */
	private function _existeSesion(): bool
	{
		return Session::has($this->_nombreSesion);
	}
	
	/**
	 * @param mixed $datos
	 *
	 * @return mixed
	 */
	private function _guardarSesion($datos)
	{
		Session::put($this->_nombreSesion, $datos);
		return $datos;
	}
	
	/**
	 * @return mixed|null
	 */
	private function _recuperarSesion()
	{
		return Session::get($this->_nombreSesion);
	}
	
	/**
	 *
	 */
	private function _terminarSesion(): void
	{
		if (Session::has($this->_nombreSesion)) {
			Session::forget($this->_nombreSesion);
		}
	}
	
	/**
	 * @return string
	 */
	private function _getIp(): string
	{
		return Request::header('X-FORWARDED-FOR') ?: Request::getClientIp();
	}
}