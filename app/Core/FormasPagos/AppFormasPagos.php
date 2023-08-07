<?php

namespace App\Core\FormasPagos;

use App\Core\EasyRez\Solicitudes\ActualizarReserva;
use App\Core\EasyRez\Solicitudes\CreateReservas;
use App\Core\EasyRez\Solicitudes\GetFormasPago;
use App\Core\FormasPagos\Pasarelas\Cargo;
use App\Core\FormasPagos\Pasarelas\CargoArticulo;
use App\Core\FormasPagos\Pasarelas\CargoPagador;
use App\Core\FormasPagos\Pasarelas\Conekta\CargoPorSolicitud;
use App\Core\FormasPagos\Pasarelas\Conekta\OxxoPay;
use App\Core\FormasPagos\Pasarelas\Conekta\TransferenciaSpei;
use App\Core\FormasPagos\Pasarelas\Openpay\PagoEnBanco;
use App\Core\FormasPagos\Pasarelas\Openpay\PagoEnTienda;
use App\Core\FormasPagos\Pasarelas\Openpay\Secure3d;
use App\Core\FormasPagos\Pasarelas\Openpay\Tokenizado as TokenizadoOpenPay;
use App\Core\FormasPagos\Pasarelas\Stripe\Tokenizado as TokenizadoStripe;
use App\Core\FormasPagos\Pasarelas\PayPal\PayPalPlus;
use App\Core\FormasPagos\Pasarelas\PayPal\PayPalCheckout;
use App\Core\FormasPagos\Pasarelas\InstrumentoPago;
use App\Core\FormasPagos\WebHook\CompraWebHook;
use App\Core\Modelos\Formato\FormatoReserva;
use App\Http\Controllers\Api\CarritoController;
use AppCarrito;
use AppTarifas;
use AppTiposHabitaciones;
use AppReservas;
use AppTransaccion;
use AppVisita;
use AppModificarReserva;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Session;
use AppSeleccionarTema;
use Illuminate\Support\Facades\URL; 
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Class AppFormasPagos
 * @package App\Core\FormasPagos
 */
class AppFormasPagos
{

    /**
     * @var string
     */
    public $_sdk;

    /**
     * @var Agent
     */
    public $_agent;


    public function __construct()
    {
        $this->_sdk = 'basic';
        $this->_agent = new Agent();
    }

    static private array $pasarelas = [
        'paypal' => [
            'paypal-checkout' => PayPalCheckout::class,
            'paypal-plus' => PayPalPlus::class
        ],
        'conekta' => [
            'oxxo' => OxxoPay::class,
            'spei' => TransferenciaSpei::class,
            'token' => CargoPorSolicitud::class,
        ],
        'openpay' => [
            '3dsecure' => Secure3d::class,
            'banco' => PagoEnBanco::class,
            'tienda' => PagoEnTienda::class,
            'token' => TokenizadoOpenPay::class,
        ],
        'stripe' => [
            'token' => TokenizadoStripe::class
        ]
    ];

    static public function cargarFormaPagoVista(int $indiceFormaPago, object $formaPago)
    {
        $noHayAnticipos = AppCarrito::recuperar()->getTotalAnticipo() == 0;
        if (empty($formaPago->pasarela_pago) || $noHayAnticipos) {
            return self::cargarTarjetaVista();
        }

        $instrumento = self::getPasarelaPagoInstrumento($formaPago);
        return $instrumento->cargarVista($indiceFormaPago);

    }

    static public function cargarScriptVista(int $indiceFormaPago, object $formaPago)
    {
        $noHayAnticipos = AppCarrito::recuperar()->getTotalAnticipo() == 0;
        if (empty($formaPago->pasarela_pago) || $noHayAnticipos) {
            return;
        }
        $instrumento = self::getPasarelaPagoInstrumento($formaPago);
        $instrumento->imprimirEtiquetaJs($indiceFormaPago);

    }

    static public function cargarTarjetaVista()
    {
        $view = AppSeleccionarTema::getURL('.') . '.' . 'formas_pagos' . '.garantia.index';
        return view($view);
    }

    static private function getPasarelaPagoInstrumento(object $formaPago): InstrumentoPago
    {
        $pasarelaCodigo = $formaPago->pasarela_pago->codigo;
        $instrumentoCodigo = $formaPago->instrumento_pago->codigo;
        $clase = @self::$pasarelas[$pasarelaCodigo][$instrumentoCodigo];
        if (empty($clase)) throw new \Exception("{$pasarelaCodigo} con {$instrumentoCodigo} no estan registrados en el ayudante de compras.");
        return new $clase($formaPago);
    }

    public function jshex(object $objeto): string
    {
        $resultado = '';
        $cadena = base64_encode(json_encode($objeto));
        for ($i = 0; $i < strlen($cadena); $i++) {
            $resultado .= '\\x' . bin2hex($cadena[$i]);
        }
        return $resultado;
    }

    static public function getFormasPago(): array
    {
        return GetFormasPago::ejecutar();
    }

    static public function getFormaPago(int $indiceFormaPago): object
    {

        $formasPago = self::getFormasPago();
        if (!isset($formasPago[$indiceFormaPago])) throw new \Exception('No existe la forma de pago especificada.');
        return $formasPago[$indiceFormaPago];
    }

    static public function prepararPago(int $indiceFormaPago, array $parametros, array $huesped): object
    {

        $formaPago = self::getFormaPago($indiceFormaPago);

        $pagador = new CargoPagador(
            $huesped['nombres'],
            $huesped['apellidos'],
            $huesped['correo'],
            $huesped['telefono']
        );
        $carrito = AppCarrito::recuperar();
        $tarifasIndexadas = AppTarifas::listarIndexado();
        $tiposHabitacionesIndexadas = AppTiposHabitaciones::listarIndexado();
        $resumenAnticipo = $carrito->getResumenAnticipo($tiposHabitacionesIndexadas, $tarifasIndexadas);
        $carrito = app(CarritoController::class)->resumenCompleto();

        foreach ($resumenAnticipo as $articulo) {
            $articulos[] = new CargoArticulo(
                $articulo['tipo_habitacion'] . ' - ' . $articulo['tarifa'],
                $articulo['total_anticipo'],
                1
            );
        }

        $cargo = new Cargo(
            $carrito['moneda'],
            $parametros,
            $pagador,
            $articulos,
            [
                'url' => URL::to('') . '/webhook/compras',
                'usuario' => env('WEBHOOK_USUARIO'),
                'contrasena' => env('WEBHOOK_CONTRASENA')
            ]
        );

        $resultado = self::getPasarelaPagoInstrumento($formaPago)->prepararCargo($cargo);
        return $resultado->getMetadatos();
    }

    static public function guardarReservaciones(array $huesped, ?int $formaPagoIndice = null, array $parametros = [], array $tarjeta = []): string
    {

        $carrito = AppCarrito::recuperar();
        $carritoResumen = app(CarritoController::class)->resumenCompleto();

        $huespedData = [
            "nombre" => $huesped['nombres'],
            "apellido" => $huesped['apellidos'],
            "contacto" => [
                "correo" => $huesped['correo'],
                "telefono_1" => $huesped['telefono'],
                "telefono_2" => @$huesped['telefono_otro']
            ],
            "domicilio" => [
                "direccion" => @$huesped['direccion'],
                "codigo_postal" => @$huesped['codigo_postal'],
                "ciudad" => @$huesped['ciudad'],
                "estado" => @$huesped['estado'],
                "pais_id" => @$huesped['pais']
            ],
            "preferencias" => [
                "titulo" => @$huesped['titulo'],
            ]
        ];

        $solicitud = [
            'visita_id' => AppVisita::crearVisita(),
            'huesped' => $huespedData,
            'tarjeta' => null,
            'forma_pago' => null,
            'reservaciones' => []
        ];


//          VALIDAR SI FALLO Y OBTENER DE LA SESION DE TRANSACCION PARA VOLVER A ENVIAR
        if (AppReservas::existeSesion()) {
            $solicitud['reservaciones'] = AppReservas::recuperarSesion();
        } else {
            foreach ($carrito->elementos() as $indice => $articulo) {
                $formatoReserva = new FormatoReserva();
                $reserva = $formatoReserva->getReserva($articulo);
                $reserva['comentarios'] = $huesped['comentarios'];
                $reserva['fecha_entrada'] = $carritoResumen['llegada'];
                $reserva['noches'] = $carritoResumen['noches'];
                $reserva['tarifa_id'] = $articulo->getTarifaId();
                $solicitud['reservaciones'][] = $reserva;
            }
        } 
 

        $noHayAnticipos = AppCarrito::recuperar()->getTotalAnticipo() == 0;
        if ($noHayAnticipos) {
            return self::reservarConTarjetaGarantia($solicitud, $tarjeta);
        } else {
            $formaPago = self::getFormaPago($formaPagoIndice);

            $solicitud['forma_pago'] = [
                'codigo' => $formaPago->codigo,
                'parametros' => null,
                'notificacion' => null
            ];
            if ($formaPago->codigo == 'tarjeta' && empty($formaPago->pasarela_pago)) {
                return self::reservarConTarjetaGarantia($solicitud, $tarjeta);
            } else {
                return self::reservarConPasarelaPago($solicitud, $formaPago, $parametros);
            }
        }
    }

    static private function reservarConTarjetaGarantia(array $solicitud, array $tarjeta): string
    {
        if (empty($tarjeta)) throw new \Exception('Se requieren los datos de la tarjeta para garantizar la compra.');

        $tarjeta['expiracion'] = $tarjeta['expiracion_anio'] . '-' . str_pad($tarjeta['expiracion_mes'], 2, 0, STR_PAD_LEFT) . '-01';
        unset($tarjeta['expiracion_anio'], $tarjeta['expiracion_mes']);
        $solicitud['tarjeta'] = $tarjeta;
        try {
            \Log::debug('********************** AppFormasPagos garantia -> Solicitud  creada' . json_encode($solicitud));
//            $path = public_path() . '\responses\conekta_token.json';
            $respuesta = CreateReservas::ejecutar($solicitud);
            //        $respuesta = json_decode(file_get_contents($path), false);
            \Log::debug('********************** AppFormasPagos garantia-> Reserva creada' . json_encode($respuesta));
            AppReservas::guardarSesion($respuesta->reservaciones);
            $url = AppSeleccionarTema::getURLRoute() . '/finish';
            return $url;
        } catch (\Exception $e) {
            $mensajes = json_decode($e->getResponse()->getBody())->mensaje;
            $array = ['code' => $e->getCode(), 'mensaje' => $mensajes];
            throw new \ErrorException(json_encode($array), 422);
        }

    }

    static private function reservarConPasarelaPago(array $solicitud, object $formaPago, array $parametros): string
    {
        $instrumentoPago = self::getPasarelaPagoInstrumento($formaPago);
        $instrumentoPago->completarParametros($parametros);
        $solicitud['forma_pago']['parametros'] = $parametros;
        $solicitud['forma_pago']['notificacion'] = [
            'url' => URL::to('') . '/webhook/compras',
            'usuario' => env('WEBHOOK_USUARIO'),
            'contrasena' => env('WEBHOOK_CONTRASENA')
        ];
        \Log::debug('********************** AppFormasPagos -> Solicitud creada' . json_encode($solicitud));
//        $path = public_path() . '\responses\conekta_token.json';
        try {
            $respuesta = CreateReservas::ejecutar($solicitud);
//            $respuesta = json_decode(file_get_contents($path), false);
            \Log::debug('********************** AppFormasPagos -> Reserva creada' . json_encode($respuesta));
            if ($respuesta->estado === false) {
                AppReservas::guardarSesion($respuesta->reservaciones);
                throw new \Exception($respuesta->error);
            }
            /*MANDAR OK DE GARANTIA*/
            if (empty($respuesta->transaccion)) {
                AppReservas::guardarSesion($respuesta->reservaciones);
                return AppSeleccionarTema::getURL('.') . '.' . 'formas_pagos' . '.garantia.confirmado';
            } else {
                AppTransaccion::guardarSesion($respuesta->transaccion);
                Log::debug('resevacion confirmada', $respuesta->reservaciones);
                AppReservas::guardarSesion($respuesta->reservaciones);
                return $instrumentoPago->getRedireccion($respuesta->transaccion);
            }

        } 
        catch (ClientException $e) { 
            self::validateResponse($e);
        }
        catch (ServerException $e) {
            self::validateResponse($e);
        }
        catch (BadResponseException $e) {
            self::validateResponse($e);
        }
        catch (\Exception $e) { 
            $array = ['code' => $e->getCode(), 'mensaje' => $e->getMessage()];
            throw new \ErrorException(json_encode($array), 500);
        }
    }

    static public function validateResponse($e){
        $code=$e->getResponse()->getStatusCode(); 
        $response=$e->getResponse()->getBody()->getContents(); 
        $msg= json_decode($response);
        $array = ['code' => $code, 'mensaje' => $msg->mensaje];
        throw new \ErrorException(json_encode($array),  $code);
    }

    static public function modificarReservacion(array $huesped): string
    {

        $carrito = AppCarrito::recuperar();
        $carritoResumen = app(CarritoController::class)->resumenCompleto();
        $huespedData = [
            "nombre" => $huesped['nombres'],
            "apellido" => $huesped['apellidos'],
            "contacto" => [
                "correo" => $huesped['correo'],
                "telefono_1" => $huesped['telefono'],
                "telefono_2" => @$huesped['telefono_otro']
            ],
            "domicilio" => [
                "direccion" => @$huesped['direccion'],
                "codigo_postal" => @$huesped['codigo_postal'],
                "ciudad" => @$huesped['ciudad'],
                "estado" => @$huesped['estado'],
                "pais_id" => @$huesped['pais']
            ],
            "preferencias" => [
                "titulo" => @$huesped['titulo'],
            ]
        ];

        $solicitud = [
            'id' => AppModificarReserva::recuperarSesion()->id,
            'fecha_entrada' => null,
            'noches' => null,
            'tarifa_id' => null,
            'comentarios' => $huesped['comentarios'],
            'huesped' => $huespedData,
            'detalles' => [],
            'complementos' => [],
            'regla_cancelacion' => null,
            'regla_modificacion' => null,
        ];

        foreach ($carrito->elementos() as $indice => $articulo) {

            $formatoReserva = new FormatoReserva();
            $reserva = $formatoReserva->getReserva($articulo);
            $solicitud['fecha_entrada'] = $carritoResumen['llegada'];
            $solicitud['noches'] = $carritoResumen['noches'];
            $solicitud['tarifa_id'] = $articulo->getTarifaId();
            $solicitud['detalles'] = $reserva['detalles'];
            $solicitud['complementos'] = $reserva['complementos'];
            $solicitud['regla_cancelacion'] = $reserva['regla_cancelacion'];
            $solicitud['regla_modificacion'] = $reserva['regla_modificacion'];
        }

        return self::reservarConModificacion($solicitud);
    }

    static private function reservarConModificacion(array $solicitud): string
    {
        try {
            \Log::debug('********************** AppFormasPagos modificar reserva -> Solicitud' . json_encode($solicitud));
//            $path = public_path() . '\responses\conekta_token.json';

            $respuesta = ActualizarReserva::ejecutar($solicitud);
            //        $respuesta = json_decode(file_get_contents($path), false);
            \Log::debug('********************** AppFormasPagos modificar reserva-> Respuesta' . json_encode($respuesta));

            $reserva = (object)array('id' => $solicitud['id']);
            AppReservas::guardarSesion($reserva);
            $url = AppSeleccionarTema::getURLRoute() . '/modify/finish';
            return $url;
        } catch (\Exception $e) {
            $mensajes = json_decode($e->getResponse()->getBody())->mensaje;
            $array = ['code' => $e->getCode(), 'mensaje' => $mensajes];
            throw new \ErrorException(json_encode($array), 422);
        }

    }
}
