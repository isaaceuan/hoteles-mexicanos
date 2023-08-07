<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppImpuestos extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appimpuestos';
    }
}