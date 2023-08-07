<?php

namespace Tests\Feature;

use App\Core\EasyRez\Solicitudes\GetPropiedad;
use Tests\TestCase;

/**
 * Class PropiedadTest
 * @package Tests\Feature
 */
class PropiedadTest extends TestCase
{
	/**
	 * @throws \Exception
	 */
	public function testExample()
	{
		$response = GetPropiedad::ejecutar();
		dd($response);
		$this->assertTrue(true);
	}
}
