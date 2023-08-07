<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';


    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapWidgetRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group(
            [
                'middleware' => ['web', 'setlocale', 'sesionRuta'],
                'namespace' => $this->namespace,
                'prefix' => '{locale?}',
            ],
            function ($router) {
                require base_path('app/Routes/basico.php');
                require base_path('app/Routes/pasarelas.php');
            }
        );
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group(
            [
                'middleware' => ['web', 'setlocale', 'sesionRuta'],
                'namespace' => $this->namespace,
                'prefix' => '{locale?}/api',
            ],
            function ($router) {
                require base_path('app/Routes/api-web.php');
            }
        );
        Route::group(
            [
                'middleware' => ['web'],
                'namespace' => $this->namespace,
                'prefix' => 'api',
            ],
            function ($router) {
                require base_path('app/Routes/api-sesion.php');
            }
        );
        Route::group(
            [
                'middleware' => 'api',
                'namespace' => $this->namespace,
                'prefix' => 'api',
            ],
            function ($router) {
                require base_path('app/Routes/api.php');
            }
        );
        Route::group(
            [
                'middleware' => ['auth.webhook'],
                'namespace' => $this->namespace,
                'prefix' => 'webhook',
            ],
            function ($router) {
                require base_path('app/Routes/webhook.php');
            }
        );
    }

    protected function mapAdminRoutes()
    {
        Route::group(
            [
                'middleware' => ['web'],
                'namespace' => $this->namespace,
                'prefix' => '{locale?}/modify',
            ],
            function ($router) {
                require base_path('app/Routes/modificar/autenticacion.php');
            }
        );
    }

    protected function mapWidgetRoutes()
    {
        Route::group(
            [
                'namespace' => $this->namespace,
                'prefix' => '{locale}/widgets',
            ],
            function ($router) {
                require base_path('app/Routes/widget.php');
            }
        );
    }
}
