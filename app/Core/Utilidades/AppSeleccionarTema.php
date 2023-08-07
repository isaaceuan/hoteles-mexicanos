<?php

namespace App\Core\Utilidades;

use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use Session;
use App;

/**
 * Class AppSeleccionarTema
 * @package App\Core\Utilidades
 */
class AppSeleccionarTema
{
    /**
     * @var string
     */
    private $_sdk;

    /**
     * @var Agent
     */
    private $_agent;

    public function __construct()
    {
        $this->_sdk = 'basico';
        $this->_agent = new Agent();
    }

    /**
     * @param string $prefix Concatenar carpeta, por default "/"
     * @return string
     */
    public function getURL($prefix = '/')
    {
        return $this->_sdk . $prefix . $this->getDevice();
    }

    /**
     * @param string $prefix Concatenar carpeta, por default "/"
     * @return string
     */
    public function getURLPublic($prefix = '/')
    {
        return App::make('url')->to('/') . $prefix . $this->_sdk . $prefix . $this->getDevice();
    }

    /**
     * @param
     * @return string
     */
    public function getURLRoute()
    {
        return App::make('url')->to('/') . '/' . app()->getLocale();
    }

    private function getDevice()
    {
//        return 'mobile';
        return $this->_agent->isDesktop() || $this->_agent->isTablet() ? 'desktop' : 'mobile';
    }

}
