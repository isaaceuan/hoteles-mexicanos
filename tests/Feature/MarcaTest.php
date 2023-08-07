<?php

namespace Tests\Feature;

use App\Core\EasyRez\Solicitudes\GetMarca;
use Tests\TestCase;

class MarcaTest extends TestCase
{
	/**
	 * @throws \Exception
	 */
    public function testExample()
    {
		$response = GetMarca::ejecutar();
		dd($response);
		$this->assertTrue(true);
    }
}
