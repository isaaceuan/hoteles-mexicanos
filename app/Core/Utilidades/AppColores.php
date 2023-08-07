<?php

namespace App\Core\Utilidades;


/**
 * Class AppColores
 * @package App\Core\Utilidades
 */
class AppColores
{
	/**
	 * Descompone un color en formato hexadecimal en sus canales rojo, verde y azul.
	 *
	 * @param string $color Representación en hexadecimal del color a descomponer.
	 * @param int $red (Salida) Valor del canal rojo.
	 * @param int $green (Salida) Valor del canal verde.
	 * @param int $blue (Salida) Valor del canal azul.
	 */
	public function hexToRgb($color, &$red, &$green, &$blue)
	{
		$color = preg_replace('/^\#([a-f0-9]{3,6})$/', '$1', strtolower($color));
		if (strlen($color) == 3) $color = preg_replace('/^([a-f0-9])([a-f0-9])([a-f0-9])$/', '$1$1$2$2$3$3', $color);
		$color = (int)hexdec($color);
		$red = ($color & 0xff0000) >> 16;
		$green = ($color & 0xff00) >> 8;
		$blue = ($color & 0xff);
	}

	/**
	 * Convierte los canales de un color en formato hexadecimal.
	 *
	 * @param int $red
	 * @param int $green
	 * @param int $blue
	 *
	 * @return string
	 */
	public function rgbToHex($red, $green, $blue)
	{
		$red = dechex($this->normalizeColorChannel($red));
		$green = dechex($this->normalizeColorChannel($green));
		$blue = dechex($this->normalizeColorChannel($blue));
		return "#{$red}{$green}{$blue}";
	}

	/**
	 * Normaliza un canal de color, restringiendo que no sea
	 * menor a 0 o mayor a 255.
	 *
	 * @param int $value
	 *
	 * @return int
	 */
	public function normalizeColorChannel($value)
	{
		if ($value < 0) {
			$value = 0;
		} else if ($value > 255) {
			$value = 255;
		}
		return $value;
	}

	/**
	 * Descompone un color en formato hexadecimal en sus canales rojo, verde y azul para bajarle el tono y
	 * lo convierte nuevamente en hexadecimal.
	 *
	 * @param $color
	 * @param $offset
	 * @return string
	 */

	public function hexRgbHex($color, $offset)
	{
		$red = $green = $blue = 0;
		$this->hexToRgb($color, $red, $green, $blue);
		$red += $offset;
		$green += $offset;
		$blue += $offset;
		return $this->rgbToHex($red, $green, $blue);
	}
}