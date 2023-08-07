<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppMonedas extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appmonedas';
    }
}