<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppDisponibilidad extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appdisponibilidad';
    }
}