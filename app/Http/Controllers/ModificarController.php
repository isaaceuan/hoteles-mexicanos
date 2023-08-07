<?php

namespace App\Http\Controllers;

use App\Core\EasyRez\Solicitudes\CancelarReserva;
use App\Core\EasyRez\Solicitudes\GetReserva;
use App\Http\Controllers\Pasarelas\PasarelasController;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use AppSeleccionarTema;

use AppModificarReserva;
use Validator;

use AppMarca;
use AppIdiomas;
use AppMonedas;
use AppPropiedad;
use AppComplementos;

use AppPaises;
use AppTitulos;


use AppBusqueda;
use AppCarrito;
use AppPasos;
use AppReservas;
use AppCorreos;
use AppTitular;

/**
 * Class ModificarController
 * @package App\Http\Controllers
 */
class ModificarController extends Controller
{
    // /**
    //  * @return ApplicationAlias|Factory|View
    //  */
    // public function inicio()
    // {
    //     AppNavegacion::setTitulo('Inicio')
    //         ->addOpcion('Hoteles Mexicanos', 'back.hoteles', [], true);
    //     return view('backend.inicio');
    // }

    /**
     * @return ApplicationAlias|Factory|RedirectResponse|View
     */
    public function autenticacion()
    {
        if (AppModificarReserva::existeSesion()):
            return redirect()
                ->route('modificar.menu', app()->getLocale());
        endif;

        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $propiedad = AppPropiedad::recuperar();
        AppModificarReserva::terminarSesion();
        AppTitular::_terminarSesion();

        return view(AppSeleccionarTema::getURL() . '/modificar/autenticacion', [
            'marca' => $marca,
            'idiomas' => $idiomas,
            'monedas' => $monedas,
            'propiedad' => $propiedad,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function validacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'code' => 'required|max:80'
        ], [
            'email.required' => 'El correo electrónico es requerido.',
            'code.required' => 'La clave de reservación es requerida.'
        ]);

        if ($validator->fails()):
            return redirect()
                ->route('modificar.login', app()->getLocale())
                ->withErrors($validator)
                ->withInput();
        endif;

        $email = $request->input('email');
        $folio = $request->input('code');

        try {
            $reserva = GetReserva::ejecutarPorFolioCorreo($folio, $email, app()->getLocale());
        } catch (\Exception $e) {

            return redirect()
                ->route('modificar.login', app()->getLocale())
                ->with('reserva', 'No existe ninguna reservación con los datos especificados en nuestros registros.');
        }

        if ($reserva):
            AppModificarReserva::guardarSesion($reserva);
            return redirect()
                ->route('modificar.menu', app()->getLocale());
        endif;

        return redirect()
            ->route('modificar.login')
            ->with('reserva', 'No existe ninguna reservación con los datos especificados en nuestros registros.');
    }

    /**
     * @return RedirectResponse
     */
    public function salir()
    {
        AppModificarReserva::terminarSesion();
        return redirect()
            ->route('modificar.login', app()->getLocale());
    }

    /**
     *
     * Menu devuelve en la vista.
     *
     * @return Factory|View|mixed
     *
     * @throws \Exception
     */
    public function menu()
    {
        $reservaSesion = AppModificarReserva::recuperarSesion();
        if (!$reservaSesion) {
            return redirect()->route('modificar.login');
        }

        AppCarrito::limpiar();
        AppReservas::terminarSesion();
        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $propiedad = AppPropiedad::recuperar();
        $reserva = GetReserva::ejecutar(AppModificarReserva::recuperarSesion()->id, app()->getLocale());
        $permitirModificar = $this->permitirModificar($reserva);
        $permitirCancelar = $this->permitirCancelar($reserva);

        return view(
            AppSeleccionarTema::getURL() . '/modificar/menu',
            [
                'marca' => $marca,
                'idiomas' => $idiomas,
                'monedas' => $monedas,
                'propiedad' => $propiedad,
                'reserva' => $reserva,
                'permitirModificar' => $permitirModificar,
                'permitirCancelar' => $permitirCancelar
            ]
        );
    }

    /**
     *
     * Menu devuelve en la vista.
     *
     * @return Factory|View
     *
     * @throws \Exception
     */
    public function resumenReserva()
    {

        $detalleReserva = GetReserva::ejecutar(AppModificarReserva::recuperarSesion()->id, app()->getLocale());
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $promociones = [];
        $complementosIncluidos = [];
        $complementosAdicionales = [];
        $habitacion = [];
        $habitacion['moneda_id'] = $detalleReserva->moneda_id;
        $habitacion['nombre'] = $detalleReserva->detalle_actual->tipo_habitacion->nombre;
        $habitacion['total_sin_imp'] = $detalleReserva->total_hospedaje + $detalleReserva->total_alimentos;
        $habitacion['total_anticipo'] = $detalleReserva->total_anticipo;
        $habitacion['total'] = $detalleReserva->total;
        $habitacion['saldo'] = $detalleReserva->total - $detalleReserva->total_anticipo;
        $habitacion['total_impuestos'] = $detalleReserva->total_impuestos + $detalleReserva->total_propinas;

        $tarifa = [];
        $tarifa['nombre'] = $detalleReserva->tarifa->nombre;
        $tarifa['descripcion'] = $detalleReserva->tarifa->descripcion;
        $tarifa['plan_alimento_id'] = $detalleReserva->plan_alimento_id;
        $tarifa['plan_alimento']['nombre'] = ($detalleReserva->plan_alimento) ? $detalleReserva->plan_alimento->nombre : null;
        $tarifa['plan_alimento']['descripcion'] = ($detalleReserva->plan_alimento) ? $detalleReserva->plan_alimento->descripcion : null;
        $tarifa['regla_cancelacion'] = $detalleReserva->regla_cancelacion;
        $tarifa['regla_modificacion'] = $detalleReserva->regla_modificacion;

        $totalComplementosIncluidos = 0;
        $totalComplementosAdicionales = 0;
        foreach ($detalleReserva->complementos as $complemento):
            if ($complemento->incluido):
                $complementosIncluidos[$complemento->complemento_id] = $complemento;
                $totalComplementosIncluidos += $complemento->importe;
            else:
                if (isset($complementosAdicionales[$complemento->complemento_id])) {
                    $complementosAdicionales[$complemento->complemento_id]['total_sin_imp'] += $complemento->importe;
                    $complementosAdicionales[$complemento->complemento_id]['nombre'] = $complemento->complemento->nombre;
                    $complementosAdicionales[$complemento->complemento_id]['cantidad'] += $complemento->cantidad;
                } else {
                    $complementosAdicionales[$complemento->complemento_id] = [
                        'total_sin_imp' => $complemento->importe,
                        'nombre' => $complemento->complemento->nombre,
                        'cantidad' => $complemento->cantidad,
                    ];
                }
                $totalComplementosAdicionales += $complemento->importe;
            endif;
        endforeach;
        if ($detalleReserva->total_descuentos > 0) {
            foreach ($detalleReserva->detalles as $detalle) {
                if ($detalle->promocion_id > 0) {
                    $promociones[$detalle->promocion_id] = $detalle->promocion;
                }
            }
        }
        $habitacion['total_sin_imp'] += $totalComplementosIncluidos;
        $habitacion['subtotal'] = $habitacion['total_sin_imp'] + $totalComplementosAdicionales;

        $permitirModificar = $this->permitirModificar($detalleReserva);
        $permitirCancelar = $this->permitirCancelar($detalleReserva);

        return view(
            AppSeleccionarTema::getURL() . '/modificar/resumen-reserva',
            [
                'propiedad' => $propiedad,
                'marca' => $marca,
                'idiomas' => $idiomas,
                'monedas' => $monedas,
                'reserva' => $detalleReserva,
                'complementosIncluidos' => $complementosIncluidos,
                'complementosAdicionales' => $complementosAdicionales,
                'promociones' => $promociones,
                'detalle' => $habitacion,
                'tarifa' => $tarifa,
                'permitirModificar' => $permitirModificar,
                'permitirCancelar' => $permitirCancelar
            ]
        );
    }

    /**
     *
     * Menu devuelve en la vista.
     *
     * @return Factory|View
     *
     * @throws \Exception
     */
    public function datosPersonales()
    {

        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $paises = AppPaises::listar();
        $titulos = AppTitulos::listar();
        $reserva = GetReserva::ejecutar(AppModificarReserva::recuperarSesion()->id, app()->getLocale());
        $titulo = $reserva->huesped->preferencias->titulo;
        $titular = $reserva->huesped;
        $comentarios = $reserva->comentarios;

        return view(
            AppSeleccionarTema::getURL() . '/modificar/datos-personales',
            [
                'propiedad' => $propiedad,
                'marca' => $marca,
                'idiomas' => $idiomas,
                'monedas' => $monedas,
                'propiedadMotor' => $configuracion,
                'paises' => $paises,
                'titulos' => $titulos,
                'titular' => $titular,
                'titulo' => $titulo,
                'comentarios' => $comentarios,
            ]
        );
    }

    /**
     *
     * Menu devuelve en la vista.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function reservaCancelar()
    {
        try {
            $data = null;
            $data['reserva_id'] = AppModificarReserva::recuperarSesion()->id;
            CancelarReserva::ejecutar($data);
            return redirect()->route('modificar.reserva.cancelada', app()->getLocale());
        } catch (\Exception $e) {
            $mensajes = json_decode($e->getResponse()->getBody())->mensaje;
            $array = ['code' => $e->getCode(), 'mensaje' => $mensajes];
            throw new \ErrorException(json_encode($array), 422);
        }

    }

    /**
     *
     * Menu devuelve en la vista.
     *
     * @return Factory|View
     *
     * @throws \Exception
     */
    public function reservaCancelada()
    {

        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $detalleReserva = GetReserva::ejecutar(AppModificarReserva::recuperarSesion()->id, app()->getLocale());
        AppCorreos::enviarCorreoReservaCancelada($marca, $propiedad, $detalleReserva);
        $configuracion = AppPropiedad::recuperarConfiguracion();
        if (count($configuracion->correos) > 0):
            AppCorreos::enviarCorreoReservaCanceladaCopia($marca, $propiedad, $detalleReserva, $configuracion->correos);
        endif;
        AppModificarReserva::terminarSesion();

        return view(
            AppSeleccionarTema::getURL() . '/modificar/reserva-cancelada',
            [
                'propiedad' => $propiedad,
                'marca' => $marca,
                'idiomas' => $idiomas,
                'monedas' => $monedas
            ]
        );
    }

    /**
     * Lista todas las habitaciones - tarifas de la busqueda previa.
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
     * @throws \Exception
     */
    public function disponibilidad(Request $request)
    {
        \Log::debug('********************** ModificarController -> disponibilidad');
        $detalleReserva = GetReserva::ejecutar(AppModificarReserva::recuperarSesion()->id, app()->getLocale());
        $permitirModificar = $this->permitirModificar($detalleReserva);
        if (!$permitirModificar) {
            return redirect()->route('modificar.menu', app()->getLocale());
        }
        $checkIn = $request->input('checkin', $detalleReserva->fecha_entrada);
        $checkOut = $request->input('checkout', $detalleReserva->fecha_salida);
        $nights = (int)$request->input('nights', $detalleReserva->noches);
        $adults = (int)$request->input('adults', $detalleReserva->detalle_actual->adultos);
        $children1 = (int)$request->input('children1', $detalleReserva->detalle_actual->ninos1);
        $children2 = (int)$request->input('children2', $detalleReserva->detalle_actual->ninos2);
        $children3 = (int)$request->input('children3', $detalleReserva->detalle_actual->ninos3);
        $promoCode = (string)$request->input('promocode', $detalleReserva->codigo_promocional);

        if (empty($checkIn) || empty($checkOut) || $nights < 1 || $adults < 1) {
            return redirect()->route('modificar.menu', app()->getLocale());
        }
        if (AppBusqueda::cambioBusqueda(
            $checkIn,
            $checkOut,
            $nights,
            $adults,
            $children1,
            $children2,
            $children3,
            $promoCode
        )) {
            AppCarrito::limpiar();
        } else {
            if (!AppPasos::enPaso1()) AppCarrito::limpiarComplementos();
        }
        AppPasos::marcarPaso1();
        AppBusqueda::actualizarBusqueda(
            $checkIn,
            $checkOut,
            $nights,
            $adults,
            $children1,
            $children2,
            $children3,
            $promoCode
        );
        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $propiedad = AppPropiedad::recuperar();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $carrito = AppCarrito::recuperar();
        $tieneElemento = false;
        if ($carrito->tieneElementos()) {
            $tieneElemento = true;
        }
        return view(
            AppSeleccionarTema::getURL() . '/modificar/disponibilidad/index',
            [
                'marca' => $marca,
                'idiomas' => $idiomas,
                'monedas' => $monedas,
                'propiedad' => $propiedad,
                'propiedadMotor' => $configuracion,
                'tieneElementos' => $tieneElemento,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
     * @throws \Exception
     */
    public function complementos(Request $request)
    {
        \Log::debug('********************** ModificarController -> complementos');
        AppPasos::marcarPaso2();
        $carrito = AppCarrito::recuperar();
        if (!$carrito->tieneElementos()) {
            return redirect()->route('modificar.menu', app()->getLocale());
        }
        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $propiedad = AppPropiedad::recuperar();
        $complementos = AppComplementos::listar();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $complementosLista = [];
        foreach ($complementos as $complemento) {
            $enCarrito = false;
            foreach ($carrito->elementos() as $elemento) {
                if ($elemento->getCotizacion()->tieneComplemento($complemento->id)) {
                    $enCarrito = true;
                }
            }
            if (!$enCarrito) {
                $complementosLista[] = $complemento->id;
            }
        }
        $tieneComplento = !empty($complementosLista);
//        $tieneComplento = count($complementos) > 0;
        if ($tieneComplento) {
            $reserva = AppModificarReserva::recuperarSesion();
            foreach ($reserva->complementos as $key => $complemento) {
                if (!$complemento->incluido) {
                    $indice = 1;
                    $complementoId = (int)$complemento->complemento_id;
                    $adultos = $reserva->detalle_actual->adultos;
                    $ninos1 = $reserva->detalle_actual->ninos1;
                    $ninos2 = $reserva->detalle_actual->ninos2;
                    $ninos3 = $reserva->detalle_actual->ninos3;
                    $unidades = $complemento->cantidad;
                    $cotizacion = AppComplementos::cotizar(
                        $complementoId,
                        $adultos,
                        $ninos1,
                        $ninos2,
                        $ninos3,
                        $unidades
                    );
                    AppCarrito::agregarAdicional(
                        $indice,
                        $complementoId,
                        $cotizacion
                    );
                }
            }

            return view(
                AppSeleccionarTema::getURL() . '/modificar/complemento/index',
                [
                    'marca' => $marca,
                    'idiomas' => $idiomas,
                    'monedas' => $monedas,
                    'propiedad' => $propiedad,
                    'propiedadMotor' => $configuracion,
                ]
            );
        }
        return redirect()->route('modificar.informacion', app()->getLocale());
    }

    /**
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
     * @throws \Exception
     */
    public function informacion()
    {
        \Log::debug('********************** ModificarController -> informacion');
        AppPasos::marcarPaso3();
        $carrito = AppCarrito::recuperar();
        if (!$carrito->tieneElementos()) {
            return redirect()->route('modificar.menu', app()->getLocale());
        }
        $marca = AppMarca::recuperar();
        $monedas = AppMonedas::listar();
        $idiomas = AppIdiomas::listar();
        $propiedad = AppPropiedad::recuperar();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $paises = AppPaises::listar();
        $titulos = AppTitulos::listar();
        $reserva = GetReserva::ejecutar(AppModificarReserva::recuperarSesion()->id, app()->getLocale());
        $titular = $reserva->huesped;
        $comentarios = $reserva->comentarios;
//        dd($titular);
        $total = AppCarrito::recuperar()->getTotal();

        // TODO: Actualizar las validaciones de acuerdo a la estructura que devuelva el sistema
        return view(
            AppSeleccionarTema::getURL() . '/modificar/informacion/index',
            [
                'marca' => $marca,
                'monedas' => $monedas,
                'idiomas' => $idiomas,
                'propiedadMotor' => $configuracion,
                'propiedad' => $propiedad,
                'paises' => $paises,
                'titulos' => $titulos,
                'titular' => $titular,
                'comentarios' => $comentarios,
                'total' => $total,
//                'total_anticipo' => $totalAnticipo,
//                'total_saldo' => $totalSaldo,
//                'resumen_anticipo' => $resumenAnticipo
            ]
        );
    }

    /**
     *
     * Menu devuelve en la vista.
     *
     * @return Factory|View
     *
     * @throws \Exception
     */
    public function reservaGuardada()
    {
        AppCarrito::limpiar();
        AppModificarReserva::terminarSesion();
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $idiomas = AppIdiomas::listar();
        $monedas = AppMonedas::listar();
        $reservas = AppReservas::recuperarSesion();
        $detalleReserva = GetReserva::ejecutar($reservas->id, app()->getLocale());
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $redireccion = app(PasarelasController::class)->getUrlRedireccion($configuracion, $propiedad);
        if (AppReservas::correoNoEnviado()) {
            AppCorreos::enviarCorreoReservaModificada($marca, $propiedad, $detalleReserva);
            if (count($configuracion->correos) > 0):
                AppCorreos::enviarCorreoReservaModificadaCopia($marca, $propiedad, $detalleReserva, $configuracion->correos);
            endif;
            AppReservas::marcarCorreoEnviado();
        }
        return view(
            AppSeleccionarTema::getURL() . '/modificar/reserva-modificada',
            [
                'propiedad' => $propiedad,
                'marca' => $marca,
                'idiomas' => $idiomas,
                'monedas' => $monedas,
                'detalleReserva' => $detalleReserva,
                'redireccion' => $redireccion
            ]
        );
    }

    /**
     * @param $reserva
     * @return bool
     */
    private function permitirModificar($reserva)
    {
        if ($reserva->regla_modificacion &&
            $reserva->regla_modificacion->modificaciones_restantes > 0) {
            if ($reserva->regla_modificacion->modo === 'libre' ||
                $reserva->regla_modificacion->modo === 'limitado') {
                if (strtotime($reserva->regla_modificacion->fecha_limite) >= strtotime("now")) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $reserva
     * @return bool
     */
    private function permitirCancelar($reserva)
    {
        if ($reserva->regla_cancelacion &&
            $reserva->regla_cancelacion->es_reembolsable &&
            count($reserva->regla_cancelacion->restricciones) > 0) {
            foreach ($reserva->regla_cancelacion->restricciones as $key => $restriccion) {
                if (strtotime($restriccion->fecha_limite) >= strtotime("now")) {
                    return true;
                }
            }
        }
        return false;
    }

}
