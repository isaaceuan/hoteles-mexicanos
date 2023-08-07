<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppPlanesAlimentos extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appplanesalimentos';
    }
}