<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\EasyRez\Solicitudes\ActualizarReserva;
use App\Core\EasyRez\Solicitudes\GetReserva;
use AppPasos;
use AppPropiedad;
use AppMarca;
use AppFormasPagos;
use AppReservas;
use AppModificarReserva;
use AppCorreos;
use Validator;
use AppTitular;

use Illuminate\Http\Request;

/**
 * Class ReservaController
 * @package App\Http\Controllers\Api
 */
class ReservaController extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function crear(Request $request)
    {
        \Log::debug('********************** ReservaController -> crear');
        $validation_rules = [
            'aceptar_terminos' => 'filled|required',
            'forma_pago_tipo' => 'required'
        ];
        $validator = Validator::make($request->all(), $validation_rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()
                ],
                422
            );
        }
        $titular = AppTitular::_recuperarSesion();
        $formaPago = $request->get('forma_pago_tipo');
        $parametros = $request->get('parametros', []);
        $tarjeta = $request->get('tarjeta', []);
        $redireccion = AppFormasPagos::guardarReservaciones($titular, $formaPago, $parametros, $tarjeta);
        AppReservas::iniciarCorreoEnviado();

        return response()->json($redireccion, 200);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function modificar(Request $request)
    {
        \Log::debug('********************** ReservaController -> modificar');
        $validation_rules = [
            'titular.nombres' => 'required',
            'titular.apellidos' => 'required',
            'titular.correo' => 'required|email',
            'titular.telefono' => 'required|min:10',
            'aceptar_terminos' => 'filled|required',
        ];
        $configuracion = AppPropiedad::recuperarConfiguracion();
        if ($configuracion->campo_titulo == 'requerido') $validation_rules['titular.titulo'] = 'required';
        if ($configuracion->campo_telefono_otro == 'requerido') $validation_rules['titular.telefono_otro'] = 'required|min:10';
        if ($configuracion->campo_direccion == 'requerido') $validation_rules['titular.direccion'] = 'required';
        if ($configuracion->campo_ciudad == 'requerido') $validation_rules['titular.ciudad'] = 'required';
        if ($configuracion->campo_estado == 'requerido') $validation_rules['titular.estado'] = 'required';
        if ($configuracion->campo_pais == 'requerido') $validation_rules['titular.pais'] = 'required';
        if ($configuracion->campo_cp == 'requerido') $validation_rules['titular.codigo_postal'] = 'required';
        $validator = Validator::make($request->all(), $validation_rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()
                ],
                422
            );
        }
        $titular = $request->get('titular');
        $redireccion = AppFormasPagos::modificarReservacion($titular);
        AppReservas::iniciarCorreoEnviado();
        return response()->json($redireccion, 200);
    }

    /**
     * @param Request $request
     * @param string $lang
     * @param int $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function detalle(Request $request, $lang, $id)
    {
        $detalleReserva = GetReserva::ejecutar($id, $lang);
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $complementosIncluidos = [];
        $complementosAdicionales = [];
        $promociones = [];
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
        foreach ($detalleReserva->complementos as $complemento) {
            if ($complemento->incluido) {
                $complementosIncluidos[$complemento->complemento_id] = $complemento;
                $totalComplementosIncluidos += $complemento->importe;
            } else {
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
            }
        }
        if ($detalleReserva->total_descuentos > 0) {
            foreach ($detalleReserva->detalles as $detalle) {
                if ($detalle->promocion_id > 0) {
                    $promociones[$detalle->promocion_id] = $detalle->promocion; 
                }
            }
        }
        $habitacion['total_sin_imp'] += $totalComplementosIncluidos;
        $habitacion['subtotal'] = $habitacion['total_sin_imp'] + $totalComplementosAdicionales; 
        return view(
            'plantilla/reserva_nueva',
            [
                'propiedad' => $propiedad,
                'marca' => $marca,
                'reserva' => $detalleReserva,
                'complementosIncluidos' => $complementosIncluidos,
                'complementosAdicionales' => $complementosAdicionales,
                'detalle' => $habitacion,
                'promociones' => $promociones,
                'tarifa' => $tarifa,
                'dominio' => url('/') . '/' . app()->getLocale(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param string $lang
     * @param int $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function detalleModificada(Request $request, $lang, $id)
    {
        $detalleReserva = GetReserva::ejecutar($id, $lang);
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $complementosIncluidos = [];
        $complementosAdicionales = [];
        $promociones = [];
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
        foreach ($detalleReserva->complementos as $complemento) {
            if ($complemento->incluido) {
                $complementosIncluidos[$complemento->complemento_id] = $complemento;
                $totalComplementosIncluidos += $complemento->importe;
            } else {
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
            }
        }
        if ($detalleReserva->total_descuentos > 0) {
            foreach ($detalleReserva->detalles as $detalle) {
                if ($detalle->promocion_id > 0) {
                    $promociones[$detalle->promocion_id] = $detalle->promocion;
                }
            }
        }
        $habitacion['total_sin_imp'] += $totalComplementosIncluidos;
        $habitacion['subtotal'] = $habitacion['total_sin_imp'] + $totalComplementosAdicionales;

        return view(
            'plantilla/reserva_modificada',
            [
                'propiedad' => $propiedad,
                'marca' => $marca,
                'reserva' => $detalleReserva,
                'complementosIncluidos' => $complementosIncluidos,
                'complementosAdicionales' => $complementosAdicionales,
                'detalle' => $habitacion,
                'promociones' => $promociones,
                'tarifa' => $tarifa,
                'dominio' => url('/') . '/' . app()->getLocale(),
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function reenviarReserva(Request $request)
    {
        $validation_rules = [
            'email' => 'required|email'
        ];
        $validator = Validator::make($request->all(), $validation_rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()
                ],
                422
            );
        }
        $reservacion = AppModificarReserva::recuperarSesion(); 
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $detalleReserva = GetReserva::ejecutar($reservacion->id, app()->getLocale());
        $detalleReserva->huesped->contacto->correo = $request->input('email');
        AppCorreos::enviarCorreoReservaNueva($marca, $propiedad, $detalleReserva);
        return response()->json(true, 200);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function actualizarDatosPersonales(Request $request)
    {
        $validation_rules = [
            'huesped.nombre' => 'required',
            'huesped.apellido' => 'required',
            'huesped.contacto.correo' => 'required|email',
            'huesped.contacto.telefono_1' => 'required|max:10|regex:/[0-9]{10}/',
            'huesped.contacto.telefono_2' => 'nullable|max:10|regex:/[0-9]{10}/'
        ];
        $validation_rules_message = [
            'huesped.contacto.telefono_1.regex' => 'Teléfono móvil invalido',
            'huesped.contacto.telefono_2.regex' => 'Otro teléfono móvil invalido'
        ];
        $configuracion = AppPropiedad::recuperarConfiguracion();
        if ($configuracion->campo_titulo == 'requerido') $validation_rules['huesped.titulo'] = 'required';
        if ($configuracion->campo_telefono_otro == 'requerido') $validation_rules['huesped.contacto.telefono_2'] = 'required|min:10|max:10|regex:/[0-9]{10}/';
        if ($configuracion->campo_direccion == 'requerido') $validation_rules['huesped.domicilio.direccion'] = 'required';
        if ($configuracion->campo_ciudad == 'requerido') $validation_rules['huesped.domicilio.ciudad'] = 'required';
        if ($configuracion->campo_estado == 'requerido') $validation_rules['huesped.domicilio.estado'] = 'required';
        if ($configuracion->campo_pais == 'requerido') $validation_rules['huesped.domicilio.pais_id'] = 'required';
        if ($configuracion->campo_cp == 'requerido') $validation_rules['huesped.domicilio.codigo_postal'] = 'required';
        $validator = Validator::make($request->all(), $validation_rules, $validation_rules_message);
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()
                ],
                422
            );
        }
        $detalleReserva = GetReserva::ejecutar(AppModificarReserva::recuperarSesion()->id, app()->getLocale());
        $data = null;

        $data['huesped'] = $request->get('huesped');
        if($request->get('comentarios')) $data['comentarios'] = $request->get('comentarios');
        $data['id'] = $detalleReserva->id;
        try {
            ActualizarReserva::ejecutar($data);
        } catch (\Exception $e) {
            $mensajes = json_decode($e->getResponse()->getBody())->mensaje;
            $array = ['code' => $e->getCode(), 'mensaje' => $mensajes];
            throw new \ErrorException(json_encode($array), 422);
        }
        $propiedad = AppPropiedad::recuperar();
        $marca = AppMarca::recuperar();
        $configuracion = AppPropiedad::recuperarConfiguracion();
        $dataAnteriores = null;
        $dataAnteriores['titular'] = $detalleReserva->huesped;
        $dataAnteriores['comentarios'] = $detalleReserva->comentarios;  

        
       
        
        AppCorreos::enviarCorreoReservaDatosModificados($marca, $propiedad, $detalleReserva, $data, $dataAnteriores);
        if (count($configuracion->correos) > 0) {
            AppCorreos::enviarCorreoReservaDatosModificadosCopias($marca, $propiedad, $detalleReserva, $data, $dataAnteriores, $configuracion->correos);
        }
        return response(1, 200);
    }
}
