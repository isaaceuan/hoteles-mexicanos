<?php

namespace Tests\Feature;

use App\Core\EasyRez\Solicitudes\GetDisponibilidad;
use Tests\TestCase;

class DisponibilidadTest extends TestCase
{
	/**
	 * @throws \Exception
	 */
	public function testExample()
	{
		$response = GetDisponibilidad::ejecutar('2020-03-11', 5, true);
		dd($response);
		$this->assertTrue(true);
	}
}
