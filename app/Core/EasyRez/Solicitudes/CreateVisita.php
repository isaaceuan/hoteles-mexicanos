<?php

namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;
use App\Core\Utilidades\AppUbicacion;
use DeviceDetector\Cache\StaticCache;
use DeviceDetector\DeviceDetector;

/**
 * Class CreateVisita
 *
 * @package App\Core\EasyRez\Solicitudes
 */
class CreateVisita extends EasyRez
{
	static private self $_instancia;
	static private DeviceDetector $_detector;
	static private AppUbicacion $_ubicacion;

	static public function crear(
		string $idioma,
		string $ip,
		string $agenteUsuario,
		?string $referente,
		bool $paso1 = false,
		bool $paso2 = false,
		bool $paso3 = false,
		bool $paso4 = false
	): int
	{
		$ubicacion = self::_getUbicacion();
		$detector = self::_getDispositivo($agenteUsuario);

		$resultado = self::_getInstancia()->post('visitas', $idioma, [
			'pais_id' => $ubicacion->getPaisCodigo($ip),
			'dispositivo' => $detector->getDeviceName(),
			'sistema_operativo' => $detector->getOs('name'),
			'referente' => $referente,
			'paso_1' => $paso1,
			'paso_2' => $paso2,
			'paso_3' => $paso3,
			'paso_4' => $paso4
		]);

		return $resultado->id;
	}

	static public function actualizar(
		string $idioma,
		int $visitaId,
		?bool $paso1 = null,
		?bool $paso2 = null,
		?bool $paso3 = null,
		?bool $paso4 = null
	): void
	{
		$body = [];
		if ($paso1 !== null) $body['paso_1'] = $paso1;
		if ($paso2 !== null) $body['paso_2'] = $paso2;
		if ($paso3 !== null) $body['paso_3'] = $paso3;
		if ($paso4 !== null) $body['paso_4'] = $paso4;
		self::_getInstancia()->patch("visitas/{$visitaId}", $idioma, $body);
	}

	static public function addConsulta(
		string $idioma,
		int $visitaId,
		string $fechaEntrada,
		int $noches,
		int $adultos,
		?int $ninos1 = null,
		?int $ninos2 = null,
		?int $ninos3 = null,
		?string $codigoPromocional = null
	): void
	{
		if (empty($ninos1)) $ninos1 = null;
		if (empty($ninos2)) $ninos2 = null;
		if (empty($ninos3)) $ninos3 = null;
		if (empty(trim($codigoPromocional))) $codigoPromocional = null;
		self::_getInstancia()->post("visitas/{$visitaId}/consultas", $idioma, [
			'fecha_entrada' => $fechaEntrada,
			'noches' => $noches,
			'adultos' => $adultos,
			'ninos1' => $ninos1,
			'ninos2' => $ninos2,
			'ninos3' => $ninos3,
			'codigo_promocional' => $codigoPromocional
		]);
	}

	static public function setCliente(
		string $idioma,
		int $visitaId,
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
		self::_getInstancia()->put("visitas/{$visitaId}/cliente", $idioma, [
			'titulo' => $titulo,
			'nombre' => $nombres,
			'apellido' => $apellidos,
			'correo' => $correo,
			'telefono_1' => $telefono,
			'telefono_2' => $telefonoOtro,
			'direccion' => $direccion,
			'codigo_postal' => $codigoPostal,
			'ciudad' => $ciudad,
			'estado' => $estado,
			'pais_id' => $pais
		]);
	}

	static private function _getInstancia(): self
	{
		if (empty(self::$_instancia)) self::$_instancia = new self();
		return self::$_instancia;
	}

	static private function _getDispositivo(string $agenteUsuario): DeviceDetector
	{
		if (empty(self::$_detector)) {
			self::$_detector = new DeviceDetector($agenteUsuario);
			self::$_detector->setCache(new StaticCache());
			self::$_detector->discardBotInformation(true);
			self::$_detector->parse();
		}
		return self::$_detector;
	}

	static private function _getUbicacion(): AppUbicacion
	{
		if (empty(self::$_ubicacion)) self::$_ubicacion = new AppUbicacion();
		return self::$_ubicacion;
	}
}
