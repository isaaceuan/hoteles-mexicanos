<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppTarifas extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apptarifas';
    }
}