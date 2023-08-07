<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppSesion extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appsesion';
    }
}