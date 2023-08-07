<?php

if (!function_exists('config_path')) {
	/**
	 * Get the configuration path.
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	function config_path($path = '')
	{
		return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
	}
}

if (!function_exists('enmascarar_cadena')) {
	/**
	 * Enmascara una cadena de texto, solamente
	 * mostrando los últimos caractéres.
	 *
	 * @param string  $cadena   Cadena de texto a enmascarar.
	 * @param string  $caracter (Opcional) Caracter mascara.
	 * @param integer $longitud (Opcional) Cantidad de caracteres a mostrar.
	 *
	 * @return string Cadena enmascarada.
	 */
	function enmascarar_cadena(string $cadena, string $caracter = 'X', int $longitud = 4): string
	{
		$cadena = trim($cadena);
		if (empty($cadena)) return '';
		$longitudMascara = strlen($cadena) - $longitud;
		return str_pad('', $longitudMascara, $caracter) . substr($cadena, $longitudMascara, $longitud);
	}
}

if (!function_exists('validar_arreglo_tipos')) {
	/**
	 * Valida que los elementos de un arreglo de objetos sean de un tipo específico.
	 *
	 * @param array  $arreglo
	 * @param string $tipo
	 */
	function validar_arreglo_objetos(array $arreglo, string $tipo): void
	{
		foreach ($arreglo as $elemento) {
			if (is_object($elemento) && $elemento instanceof $tipo) continue;
			throw new RuntimeException("Se esperaba un elemento de tipo {$tipo}");
		}
	}
}

if (!function_exists('construir_url')) {
	/**
	 * Construye una URL a partir de la estructura devuelta por parse_url.
	 *
	 * @param array $partes Diccionario con las partes de la URL.
	 *
	 * @return string URL resultante
	 */
	function construir_url(array $partes): string {
		return
			(isset($partes['scheme']) ? "{$partes['scheme']}:" : '') .
			((isset($partes['user']) || isset($partes['host'])) ? '//' : '') .
			(isset($partes['user']) ? "{$partes['user']}" : '') .
			(isset($partes['pass']) ? ":{$partes['pass']}" : '') .
			(isset($partes['user']) ? '@' : '') .
			(isset($partes['host']) ? "{$partes['host']}" : '') .
			(isset($partes['port']) ? ":{$partes['port']}" : '') .
			(isset($partes['path']) ? "{$partes['path']}" : '') .
			(isset($partes['query']) ? "?{$partes['query']}" : '') .
			(isset($partes['fragment']) ? "#{$partes['fragment']}" : '');
	}
}

if (!function_exists('redondear')) {
	/**
	 * Redondea un valor flotante a un cierto número de decimales, utilizando
	 * el método de multiplicar y dividir.
	 *
	 * @param float $valor
	 * @param int   $decimales
	 *
	 * @return float
	 */
	function redondear(float $valor, int $decimales = 0): float
	{
		$potencia = pow(10, $decimales);
		$producto = round($valor * $potencia);
		return $producto / $potencia;
	}
}

if (!function_exists('generar_codigo_amigable')) {
	/**
	 * @param int $longitud
	 *
	 * @return string
	 */
	function generar_codigo_amigable(int $longitud = 8): string
	{
		static $simbolos = 'aAbB0cCdD1eEfF2gGhH3iIjJ4kKlL5mMnN6oOpP7qQrR8sStT9uUvVwWxXyYzZ';
		$maximo = strlen($simbolos) - 1;
		$codigo = '';
		
		for ($posicion = 0; $posicion < $longitud; $posicion++) {
			$codigo .= $simbolos[rand(0, $maximo)];
		}

		return $codigo;
	}
}

if (!function_exists('get_excepcion_pila')) {
	/**
	 * Recupera la pila de llamadas de una excepción como un arreglo.
	 *
	 * @param Throwable $excepcion
	 *
	 * @return array
	 */
	function get_excepcion_pila(Throwable $excepcion): array
	{
		$directorioProyecto = realpath(dirname(__DIR__));
		$pilaLlamadas = str_replace([$directorioProyecto, '\\'], ['', '/'], $excepcion->getTraceAsString());
		return explode("\n", $pilaLlamadas);
	}
}