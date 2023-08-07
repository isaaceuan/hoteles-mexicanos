<?php

namespace App\Http\Controllers;

use App\Core\EasyRez\Solicitudes\GetTarjetasCredito;
use App\Core\EasyRez\Solicitudes\GetFormasPago;
use AppVisita;
use AppBusqueda;
use AppCarrito;
use AppComplementos;
use AppPasos;
use AppIdiomas;
use AppMarca;
use AppMonedas;
use AppPaises;
use AppPropiedad;
use AppReservas;
use AppTransaccion;
use AppTarifas;
use AppTiposHabitaciones;
use AppTitulos;
use AppSeleccionarTema;
use Validator;
use AppTitular;
use AppModificarReserva;

use Illuminate\Http\Request;

/**
 * Class BasicoController
 * @package App\Http\Controllers
 */
class BasicoController extends Controller
{
	/**
	 *
	 * Metodo para la pagina principal del motor, para llenar el buscador
	 * Verifica si en la sesion de la propiedad existe la información, de lo contrario
	 * realiza la petición, lo guarda y lo devuelve en la vista.
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function inicio()
	{
		\Log::debug('********************** BasicoController -> inicio');
		AppReservas::terminarSesion();
		AppTransaccion::terminarSesion();
		AppPasos::marcarPaso0();
		AppCarrito::limpiar();
		AppBusqueda::recuperar();
		AppVisita::crearVisita();
		$marca = AppMarca::recuperar();
		$idiomas = AppIdiomas::listar();
		$monedas = AppMonedas::listar();
		$propiedad = AppPropiedad::recuperar();
		$configuracion = AppPropiedad::recuperarConfiguracion();
		return view(
			AppSeleccionarTema::getURL() . '/inicio/index',
			[
				'marca'          => $marca,
				'idiomas'        => $idiomas,
				'monedas'        => $monedas,
				'propiedad'      => $propiedad,
				'propiedadMotor' => $configuracion,
			]
		);
	}

	/**
	 * Lista todas las habitaciones - tarifas de la busqueda previa.
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function disponibilidad(Request $request)
	{
		\Log::debug('********************** BasicoController -> disponibilidad');
		$checkIn = $request->input('checkin');
		$checkOut = $request->input('checkout');
		$nights = (int) $request->input('nights', 0);
		$adults = (int) $request->input('adults', 0);
		$children1 = (int) $request->input('children1', 0);
		$children2 = (int) $request->input('children2', 0);
		$children3 = (int) $request->input('children3', 0);
		$promoCode = (string) $request->input('promocode', '');
		if (empty($checkIn) || empty($checkOut) || $nights < 1 || $adults < 1) {
			return redirect()->route('app.inicio');
		}
		AppVisita::vistandoDisponibilidad();
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
		}
		else {
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
		AppModificarReserva::terminarSesion();
		AppTitular::_terminarSesion();
		return view(
			AppSeleccionarTema::getURL() . '/disponibilidad/index',
			[
				'marca'          => $marca,
				'idiomas'        => $idiomas,
				'monedas'        => $monedas,
				'propiedad'      => $propiedad,
				'propiedadMotor' => $configuracion,
			]
		);
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function complementos(Request $request)
	{
		\Log::debug('********************** BasicoController -> complementos');
		AppPasos::marcarPaso2();
		$carrito = AppCarrito::recuperar();
		if (!$carrito->tieneElementos()) {
			return redirect()->route('app.inicio');
		}
		AppVisita::vistandoComplementos();
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
		if ($tieneComplento) {
			return view(
				AppSeleccionarTema::getURL() . '/complemento/index',
				[
					'marca'          => $marca,
					'idiomas'        => $idiomas,
					'monedas'        => $monedas,
					'propiedad'      => $propiedad,
					'propiedadMotor' => $configuracion,
				]
			);
		}
		return redirect()->route('app.informacion', app()->getLocale());
	}

	/**
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function informacion()
	{
		\Log::debug('********************** BasicoController -> informacion');
		AppPasos::marcarPaso3();
		$carrito = AppCarrito::recuperar();
		if (!$carrito->tieneElementos()) {
			return redirect()->route('app.inicio');
		}
		AppVisita::vistandoInformacion();
		$marca = AppMarca::recuperar();
		$monedas = AppMonedas::listar();
		$idiomas = AppIdiomas::listar();
		$propiedad = AppPropiedad::recuperar();
		$configuracion = AppPropiedad::recuperarConfiguracion();
		$paises = AppPaises::listar();
		$titulos = AppTitulos::listar();
		$titular = [
			"titulo"        => null,
			"nombres"       => null,
			"apellidos"     => null,
			"correo"        => null,
			"telefono"      => null,
			"telefono_otro" => null,
			"direccion"     => null,
			"ciudad"        => null,
			"estado"        => null,
			"pais"          => 'MX',
			"codigo_postal" => null,
			"comentarios"   => null,
		];
		if (AppTitular::_existeSesion()) {
			$titular = AppTitular::_recuperarSesion();
		}

		// TODO: Actualizar las validaciones de acuerdo a la estructura que devuelva el sistema
		return view(
			AppSeleccionarTema::getURL() . '/informacion/index',
			[
				'marca'          => $marca,
				'monedas'        => $monedas,
				'idiomas'        => $idiomas,
				'propiedadMotor' => $configuracion,
				'propiedad'      => $propiedad,
				'paises'         => $paises,
				'titulos'        => $titulos,
				'titular'        => $titular,
			]
		);
	}

	/**
	 * Lista todas las habitaciones - tarifas de la busqueda previa.
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function informacionGuardar(Request $request)
	{
		$validation_rules = [
			'titular.nombres'       => 'required',
			'titular.apellidos'     => 'required',
			'titular.correo'        => 'required|email',
			'titular.telefono'      => 'required|max:10|regex:/[0-9]{10}/',
			'titular.telefono_otro' => 'nullable|max:10|regex:/[0-9]{10}/',
		];
		$validation_rules_message = [
			'titular.telefono.regex'      => 'Teléfono móvil invalido',
			'titular.telefono_otro.regex' => 'Otro teléfono móvil invalido'
		];
		$configuracion = AppPropiedad::recuperarConfiguracion();
		if ($configuracion->campo_titulo == 'requerido') $validation_rules['titular.titulo'] = 'required';
		if ($configuracion->campo_telefono_otro == 'requerido') $validation_rules['titular.telefono_otro'] = 'required|max:10|regex:/[0-9]{10}/';
		if ($configuracion->campo_direccion == 'requerido') $validation_rules['titular.direccion'] = 'required';
		if ($configuracion->campo_ciudad == 'requerido') $validation_rules['titular.ciudad'] = 'required';
		if ($configuracion->campo_estado == 'requerido') $validation_rules['titular.estado'] = 'required';
		if ($configuracion->campo_pais == 'requerido') $validation_rules['titular.pais'] = 'required';
		if ($configuracion->campo_cp == 'requerido') $validation_rules['titular.codigo_postal'] = 'required';

		$validator = Validator::make($request->all(), $validation_rules, $validation_rules_message);
		if ($validator->fails()):
			return response()->json(
				[
					'success' => false,
					'message' => $validator->errors()
				],
				422
			);
		endif;

		try {
			AppVisita::capturandoCliente(
				$request->input('titular.nombres'),
				$request->input('titular.apellidos'),
				$request->input('titular.correo'),
				$request->input('titular.titulo'),
				$request->input('titular.telefono'),
				$request->input('titular.telefono_otro'),
				$request->input('titular.direccion'),
				$request->input('titular.codigo_postal'),
				$request->input('titular.ciudad'),
				$request->input('titular.estado'),
				$request->input('titular.pais')
			);

			AppTitular::_guardarSesion($request->input('titular'));
		}
		catch (\Exception $e) {
			$mensajes = json_decode($e->getResponse()->getBody())->mensaje;
			$array = ['code' => $e->getCode(), 'mensaje' => $mensajes];
			throw new \ErrorException(json_encode($array), 422);
		}
		$redireccion = AppSeleccionarTema::getURLRoute() . '/summary';
		return response()->json($redireccion, 200);
	}

	/**
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function resumen()
	{
		\Log::debug('********************** BasicoController -> resumen');
		AppPasos::marcarPaso3();
		$carrito = AppCarrito::recuperar();
		if (!$carrito->tieneElementos() || !AppTitular::_existeSesion()) {
			return redirect()->route('app.inicio');
		}
		AppVisita::vistandoInformacion();
		$marca = AppMarca::recuperar();
		$monedas = AppMonedas::listar();
		$idiomas = AppIdiomas::listar();
		$propiedad = AppPropiedad::recuperar();
		$configuracion = AppPropiedad::recuperarConfiguracion();
		$formasPago = GetFormasPago::ejecutar(app()->getLocale());
		$tarjetasPropiedad = GetTarjetasCredito::ejecutar();
		$paises = AppPaises::listar();
		$titulos = AppTitulos::listar();
		$totalAnticipo = $carrito->getTotalAnticipo();
		$totalSaldo = $carrito->getTotalSaldo();
		$tarifasIndexadas = AppTarifas::listarIndexado();
		$tiposHabitacionesIndexadas = AppTiposHabitaciones::listarIndexado();
		$resumenAnticipo = $carrito->getResumenAnticipo($tiposHabitacionesIndexadas, $tarifasIndexadas);

		// TODO: Actualizar las validaciones de acuerdo a la estructura que devuelva el sistema
		return view(
			AppSeleccionarTema::getURL() . '/resumen/index',
			[
				'marca'              => $marca,
				'monedas'            => $monedas,
				'idiomas'            => $idiomas,
				'propiedadMotor'     => $configuracion,
				'formas_pago'        => $formasPago,
				'propiedad'          => $propiedad,
				'paises'             => $paises,
				'titulos'            => $titulos,
				'tarjetas_propiedad' => $tarjetasPropiedad,
				'total_anticipo'     => $totalAnticipo,
				'total_saldo'        => $totalSaldo,
				'resumen_anticipo'   => $resumenAnticipo
			]
		);
	}

	/**
	 * Verifica la marca de la propiedad y crea la paleta de colores y el css.
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function estilos()
	{
		\Log::debug('********************** BasicoController -> estilos');
		$marca = AppMarca::getEstilosMarca();
		$contents = view(
			AppSeleccionarTema::getURL() . '/inicio/estilos',
			[
				'marca' => $marca
			]
		);
		return response($contents)->header('Content-Type', 'text/css; charset: UTF-8');
	}
}
