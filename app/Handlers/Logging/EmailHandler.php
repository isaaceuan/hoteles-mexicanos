<?php namespace App\Handlers\Logging;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Monolog\Logger;
use Monolog\LogRecord;

final class EmailHandler extends LoggingHandler
{
	public function __invoke(array $config): Logger
	{
		$this->setLevel($config['level']);
		$logger = new Logger('LoggingEmailHandler');
		return $logger->pushHandler($this);
	}
	
	protected function write(LogRecord $record): void
	{
		static $longitudResumen = 35;
		$resumen = $record['message'];
		if (Str::length($record['message']) > $longitudResumen) $resumen = Str::substr($resumen, 0, $longitudResumen) . '...';

		//$record['origin'] = $this->getOrigen();
		//unset($record['formatted']);

		$asunto = '¡Emergencia! Problema encontrado: ' . $resumen;
		$mensaje = "Si está recibiendo este correo, es porque el sistema ha detectado un error crítico que requiere atención inmediata:\n\n";
		$mensaje .= json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		
		/*Mail::raw($mensaje, function (Message $correo) use ($asunto) {
			$correo
				->priority(2)
				->to(env('LOG_EMAIL_EMERGENCY'))
				->subject($asunto);
		});*/
	}

	/*protected function write(array $record): void
	{
		static $longitudResumen = 35;
		$resumen = $record['message'];
		if (Str::length($record['message']) > $longitudResumen) $resumen = Str::substr($resumen, 0, $longitudResumen) . '...';
		
		$record['origin'] = $this->getOrigen();
		unset($record['formatted']);
		
		$asunto = '¡Emergencia! Problema encontrado: ' . $resumen;
		$mensaje = "Si está recibiendo este correo, es porque el sistema ha detectado un error crítico que requiere atención inmediata:\n\n";
		$mensaje .= json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		
		Mail::raw($mensaje, function (Message $correo) use ($asunto) {
			$correo
				->priority(2)
				->to(env('LOG_EMAIL_EMERGENCY'))
				->subject($asunto);
		});
	}*/
}