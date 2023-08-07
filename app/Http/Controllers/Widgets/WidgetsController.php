<?php namespace App\Http\Controllers\Widgets;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Widgets\Basico\BasicoController;
use AppMarca;
use AppPropiedad;
use Illuminate\Support\Facades\Response;
use Jenssegers\Agent\Agent;

use Illuminate\Http\Request;

/**
 * Class WidgetsController
 * @package App\Http\Controllers\Widgets
 */
class WidgetsController extends Controller
{

    /**
     * @var Agent
     */
    private $_agent;

    public function __construct()
    {
        $this->_agent = new Agent();
    }

    public function boot(Request $request, $idioma, $tema)
    {
        app()->setLocale($idioma);
        $id = $request->get('id');
        $config=AppPropiedad::recuperarConfiguracion();
        $host = str_replace("/es", "",$config->url);
        $marca = AppMarca::getEstilosMarca();
        $color = $request->get('color');
        $color2 = $request->get('color2');
        $bgcolor = $request->get('bgcolor');
        $colorPrimario = ltrim($color ?? $color ?? $marca->color_acento, '#');
        $colorSecundario = ltrim($color2 ?? $color2 ?? $marca->color_acento_hover, '#');
        $colorFondo = ltrim($bgcolor ?? $bgcolor ?? $marca->color_claro, '#');
        $recursos = app(BasicoController::class)->getRecursos($host, $tema, $idioma, $id, $colorPrimario, $colorSecundario, $colorFondo);
        $url = $host . '/' . $idioma . '/widgets/' . $tema . '/template?id=' . $request->get('id');
        $urlLoading = $host . '/' . 'imagenes/loading.gif';

        $statusCode = 200;
        $boot = 'widgets.' . $tema . '.boot';
        $content = view($boot, [
            'recursos' => json_encode($recursos, JSON_UNESCAPED_SLASHES),
            'url' => $url,
            'urlLoading' => $urlLoading,
        ]);
        $response = Response::make($content, $statusCode);
        $response->header('Content-Type', 'text/html');
        return $response;
    }


    public function template(Request $request, $idioma, $tema)
    {

        app()->setLocale($idioma);
        $propiedad = AppPropiedad::recuperar();
        $tema = 'widgets.' . $tema . '.index';
        $contents = view($tema, [
            'propiedad' => $propiedad,
            'id' => $request->get('id'),
        ]);
        return response($contents)->header('Content-Type', 'text/html; charset: UTF-8');
    }


    public function script(Request $request, $idioma, $tema)
    {

        $device = $this->_agent->isDesktop() || $this->_agent->isTablet() ? 'bubble' : 'bottom';
        app()->setLocale($idioma);
        $tema = 'widgets.' . $tema . '.script';
        $propiedad = AppPropiedad::recuperar();
        $contents = view($tema, [
            'propiedad' => $propiedad,
            'id' => $request->get('id'),
            'device' => $device,
        ]);
        return response($contents)->header('Content-Type', 'application/javascript; charset: UTF-8');
    }

    public function style(Request $request, $idioma, $tema)
    {

        $colorPrimario = $request->get('color');
        $colorSecundario = $request->get('color2');
        $colorFondo = $request->get('bgcolor');
        app()->setLocale($idioma);
        $tema = 'widgets.' . $tema . '.style';
        if (strpos($colorFondo, 'rgb') !== false) {
            $colorFondoValido = $colorFondo;
        } else {
            $colorFondoValido = '#' . $colorFondo;
        }
        $contents = view($tema, [
            'color_primario' => '#' . $colorPrimario,
            'color_secundario' => '#' . $colorSecundario,
            'color_fondo' => $colorFondoValido,
            'id' => $request->get('id'),
        ]);
        return response($contents)->header('Content-Type', 'text/css; charset: UTF-8');
    }
}
