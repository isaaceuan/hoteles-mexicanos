<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use AppFechas;
use Illuminate\Support\Carbon;
use stdClass;

class SesionFechas extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
		$fecha = Carbon::now();
		$datos = new StdClass();
		$datos->fecha_entrada = $fecha->format('Y-m-d');
		$datos->fecha_salida = $fecha->addDays(1)->format('Y-m-d');
		$datos->noches = 1;
		$datos->codigo_promocion = null;

    	AppFechas::guardarSesion($datos);
    	$sesion= AppFechas::recuperarSesion();

    	if($sesion){
    		dd($sesion);
			$this->assertTrue(true);
		} else{
			$this->assertTrue(false);
		}




    }
}
