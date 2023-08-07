<?php

namespace App\Providers;

use App\Core\Utilidades\AppBusqueda;
use App\Core\Utilidades\AppCarrito;
use App\Core\Utilidades\AppColores;
use App\Core\Utilidades\AppComplementos;
use App\Core\Utilidades\AppCorreos;
use App\Core\Utilidades\AppDisponibilidad;
use App\Core\Utilidades\AppIdiomas;
use App\Core\Utilidades\AppImpuestos;
use App\Core\Utilidades\AppMarca;
use App\Core\Utilidades\AppMonedas;
use App\Core\Utilidades\AppPaises;
use App\Core\Utilidades\AppPasos;
use App\Core\Utilidades\AppPlanesAlimentos;
use App\Core\Utilidades\AppPropiedad;
use App\Core\Utilidades\AppPropinas;
use App\Core\Utilidades\AppReservas;
use App\Core\Utilidades\AppSesion;
use App\Core\Utilidades\AppTarifas;
use App\Core\Utilidades\AppTiposHabitaciones;
use App\Core\Utilidades\AppTitulos;
use App\Core\Utilidades\AppModificarReserva;
use App\Core\Utilidades\AppTitular;

use App\Core\Utilidades\AppSeleccionarTema;
use App\Core\FormasPagos\AppFormasPagos;


use App\Core\Utilidades\AppTransaccion;
use App\Core\Utilidades\AppUbicacion;
use App\Core\Utilidades\AppVisita;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('appbusqueda', function ($app) {
            return new AppBusqueda();
        });

        $this->app->singleton('appcarrito', function ($app) {
            return new AppCarrito();
        });

        $this->app->singleton('appcolores', function ($app) {
            return new AppColores();
        });

        $this->app->singleton('appcomplementos', function ($app) {
            return new AppComplementos();
        });

        $this->app->singleton('appdisponibilidad', function ($app) {
            return new AppDisponibilidad();
        });

        $this->app->singleton('appidiomas', function ($app) {
            return new AppIdiomas();
        });

        $this->app->singleton('appimpuestos', function ($app) {
            return new AppImpuestos();
        });

        $this->app->singleton('appmarca', function ($app) {
            return new AppMarca();
        });

        $this->app->singleton('appmonedas', function ($app) {
            return new AppMonedas();
        });

        $this->app->singleton('apppaises', function ($app) {
            return new AppPaises();
        });

        $this->app->singleton('apppasos', function ($app) {
            return new AppPasos();
        });

        $this->app->singleton('appplanesalimentos', function ($app) {
            return new AppPlanesAlimentos();
        });

        $this->app->singleton('apppropiedad', function ($app) {
            return new AppPropiedad();
        });

        $this->app->singleton('apppropinas', function ($app) {
            return new AppPropinas();
        });

        $this->app->singleton('appreservas', function ($app) {
            return new AppReservas();
        });

        $this->app->singleton('appsesion', function ($app) {
            return new AppSesion();
        });

        $this->app->singleton('apptarifas', function ($app) {
            return new AppTarifas();
        });

        $this->app->singleton('apptiposhabitaciones', function ($app) {
            return new AppTiposHabitaciones();
        });

        $this->app->singleton('apptitulos', function ($app) {
            return new AppTitulos();
        });

        $this->app->singleton('appcorreos', function ($app) {
            return new AppCorreos();
        });

        $this->app->singleton('appseleccionartema', function ($app) {
            return new AppSeleccionarTema();
        });

        $this->app->singleton('appformaspagos', function ($app) {
            return new AppFormasPagos();
        });

        $this->app->singleton('apptransaccion', function ($app) {
            return new AppTransaccion();
        });

        $this->app->singleton('appubicacion', function ($app) {
        	return new AppUbicacion();
		});

		$this->app->singleton('appvisita', function ($app) {
			return new AppVisita();
		});

        $this->app->singleton('appmodificarreserva', function ($app) {
            return new AppModificarReserva();
        });

        $this->app->singleton('apptitular', function ($app) {
            return new AppTitular();
        });
    }
}
