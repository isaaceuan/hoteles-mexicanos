<?php namespace App\Handlers\Logging;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Monolog\LogRecord;

final class DatabaseHandler extends LoggingHandler
{
	public function __invoke(array $config): Logger
	{
		$this->setLevel($config['level']);
		$logger = new Logger('LoggingDatabaseHandler');
		return $logger->pushHandler($this);
	}

	protected function write(LogRecord $record): void
	{
		static $niveles = [
			Logger::DEBUG => 'depuracion',
			Logger::INFO => 'informacion',
			Logger::NOTICE => 'noticia',
			Logger::WARNING => 'advertencia',
			Logger::ERROR => 'error',
			Logger::CRITICAL => 'critico',
			Logger::ALERT => 'alerta',
			Logger::EMERGENCY => 'emergencia'
		];
		
		$data = [
			'aplicacion' => env('APP_NAME'),
			'origen' => $this->getOrigen(),
			'nivel' => $niveles[$record['level']],
			'mensaje' => $record['message'],
			'datos' => empty($record['context']) ? null : json_encode($record['context'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
		];
		
		try {
			DB
				::connection('mysql')
				->table('auditoria.bitacora')
				->insert($data);
		}
		catch (Exception $ex) {
			//unset($record['formatted']);
			Log::channel('email')->log('critical', 'Ocurrió un error y no fue posible registrar el mensaje en la bitácora.', [
				'source' => $record,
				'exception' => [
					'message' => $ex->getMessage(),
					'stack' => get_excepcion_pila($ex)
				]
			]);
		}
	}
	
	/*
	protected function write(array $record): void
	{
		static $niveles = [
			Logger::DEBUG => 'depuracion',
			Logger::INFO => 'informacion',
			Logger::NOTICE => 'noticia',
			Logger::WARNING => 'advertencia',
			Logger::ERROR => 'error',
			Logger::CRITICAL => 'critico',
			Logger::ALERT => 'alerta',
			Logger::EMERGENCY => 'emergencia'
		];
		
		$data = [
			'aplicacion' => env('APP_NAME'),
			'origen' => $this->getOrigen(),
			'nivel' => $niveles[$record['level']],
			'mensaje' => $record['message'],
			'datos' => empty($record['context']) ? null : json_encode($record['context'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
		];
		
		try {
			DB
				::connection('mysql')
				->table('auditoria.bitacora')
				->insert($data);
		}
		catch (Exception $ex) {
			unset($record['formatted']);
			Log::channel('email')->log('critical', 'Ocurrió un error y no fue posible registrar el mensaje en la bitácora.', [
				'source' => $record,
				'exception' => [
					'message' => $ex->getMessage(),
					'stack' => get_excepcion_pila($ex)
				]
			]);
		}
	} */
}