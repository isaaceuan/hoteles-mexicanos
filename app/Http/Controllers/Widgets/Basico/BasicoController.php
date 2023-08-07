<?php namespace App\Http\Controllers\Widgets\Basico;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Widgets\Recurso;

/**
 * Class BasicoController
 * @package App\Http\Controllers\Widgets
 */
class BasicoController extends Controller
{

    public function getRecursos($host, $widget, $lang, $id, $colorPrimario, $colorSecundario, $colorFondo)
    {
        return [
            new Recurso('js', $host . '/recursos/js/jquery-3.5.1.js', -2),
            new Recurso('js', $host . '/recursos/mobiscroll/mobiscroll.min.js', -1),
            new Recurso('js', $host . '/' . $lang . '/widgets/' . $widget . '/script?id='.$id, 0),
            new Recurso('css', $host . '/' . $lang . '/widgets/' . $widget . '/style?id='.$id.'&bgcolor='.$colorFondo.'&color='.$colorPrimario.'&color2='.$colorSecundario, 1),
            new Recurso('css', $host . '/recursos/mobiscroll/mobiscroll.min.css', 2),
        ];
    }
}
