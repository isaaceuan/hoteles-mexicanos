<?php

namespace App\Facades\Utilidades;

use Illuminate\Support\Facades\Facade;

class AppMarca extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appmarca';
    }
}