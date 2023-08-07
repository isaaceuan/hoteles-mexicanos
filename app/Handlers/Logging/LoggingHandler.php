<?php namespace App\Handlers\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

abstract class LoggingHandler extends AbstractProcessingHandler
{
	final protected function getOrigen(): ?string
	{
		static $limitePila = 10;
		$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $limitePila);
		if (count($trace) < $limitePila) return null;
		$info = end($trace);
		$info['class'] = str_replace('\\', '.', $info['class']);
		return "{$info['class']}::{$info['function']}";
	}
	
	abstract public function __invoke(array $config): Logger;
}