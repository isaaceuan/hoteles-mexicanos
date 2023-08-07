<?php

namespace App\Http\Controllers\Api;

use App\Core\Modelos\Cotizacion\Cotizacion;
use App\Core\Modelos\Formato\FormatoBusqueda;
use App\Core\Modelos\Formato\FormatoCarrito;
use App\Core\Modelos\Formato\FormatoComplementos;
use App\Core\Modelos\Formato\FormatoPromociones;
use App\Core\Modelos\Formato\FormatoReglaCancelacion;
use App\Core\Modelos\Formato\FormatoReglaModificacion;
use App\Core\Modelos\Formato\FormatoResumen;
use App\Core\Modelos\Formato\FormatoTarifa;
use App\Core\Modelos\Formato\FormatoTipoHabitacion;
use AppBusqueda;
use AppDisponibilidad;
use AppCarrito;
use AppComplementos;

use App\Http\Controllers\Controller;
use AppImpuestos;
use AppPropiedad;
use AppPropinas;
use AppTarifas;
use AppTiposHabitaciones;
use Illuminate\Http\Request;

/**
 * Class CarritoController
 * @package App\Http\Controllers\Api
 */
class CarritoController extends Controller
{
	/**
	 * @param Cotizacion $cotizacion
	 *
	 * @param bool       $conDescuentos
	 * @param bool       $conComplementos
	 * @param bool       $conImpuestos
	 * @param bool       $conPropinas
	 *
	 * @return float
	 */
	public function getTotalPersonalizado($cotizacion, $conDescuentos = false, $conComplementos = false, $conImpuestos = false, $conPropinas = false)
	{
		$total = $cotizacion->getTotalHospedaje() + $cotizacion->getTotalAlimentos();
		if (!$conDescuentos) {
			$total += $cotizacion->getTotalDescuentos();
		}
		if ($conComplementos) {
			$total += $cotizacion->getTotalComplementos();
		}
		if ($conImpuestos) {
			$total += $cotizacion->getTotalImpuestos();
		}
		if ($conPropinas) {
			$total += $cotizacion->getTotalPropinas();
		}
		return $total;
	}
	
	/**
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function resumen()
	{
		$busqueda = AppBusqueda::recuperar();
		$carrito = AppCarrito::recuperar();
		$propiedad = AppPropiedad::recuperar();
		$tiposHabitacionesIndexadas = AppTiposHabitaciones::listarIndexado();
		$tarifasIndexadas = AppTarifas::listarIndexado();
		$impuestosIndexados = AppImpuestos::listarIndexado();
		$propinasIndexadas = AppPropinas::listarIndexado();
		$complementosIndexados = AppComplementos::listarIndexado();
		$formatoResumen = new FormatoResumen();
		$formatoTarifa = new FormatoTarifa();
		$formatoTipoHabitacion = new FormatoTipoHabitacion();
		$formatoReglaModificacion = new FormatoReglaModificacion();
		$formatoReglaCancelacion = new FormatoReglaCancelacion();
		$formatoBusqueda = new FormatoBusqueda();
		$formatoPromociones = new FormatoPromociones();
		$formatoComplementos = new FormatoComplementos();
		$formatoCarrito = new FormatoCarrito();
		$detalle = [];
		foreach ($carrito->elementos() as $elemento) {
			$detalle[] = [
				'indice'                        => $elemento->getIndice(),
				'busqueda'                      => $formatoBusqueda->getFormatoCotizacion($busqueda, $elemento->getCotizacion()),
				'total_con_des_con_com_sin_imp' => $this->getTotalPersonalizado($elemento->getCotizacion(), true, true),
				'tarifa'                        => $formatoTarifa->getFormato($elemento->getTarifaId(), $tarifasIndexadas),
				'tipo_habitacion'               => $formatoTipoHabitacion->getFormato($elemento->getTipoHabitacionId(), $tiposHabitacionesIndexadas),
				'edades'                        => [
					'ninos_min_1' => $propiedad->ninos_min_1,
					'ninos_max_1' => $propiedad->ninos_max_1,
					'ninos_min_2' => $propiedad->ninos_min_2,
					'ninos_max_2' => $propiedad->ninos_max_2,
					'ninos_min_3' => $propiedad->ninos_min_3,
					'ninos_max_3' => $propiedad->ninos_max_3,
				],
				'tiene_promocion'               => $formatoPromociones->tienePromociones($elemento->getPromociones()),
				'promociones'                   => $formatoPromociones->getFormato($elemento->getPromociones()),
				'regla_cancelacion'             => $formatoReglaCancelacion->getFormato($elemento->getCotizacion(), true),
				'regla_modificacion'            => $formatoReglaModificacion->getFormato($elemento->getCotizacion(), true),
				'complementos'                  => $formatoComplementos->getFormatoSinImportes($elemento->getCotizacion(), $complementosIndexados),
				'complementos_adicionales'      => $formatoComplementos->getFormatoAdicionales($elemento->getAdicionales(), $complementosIndexados),
				'resumen'                       => $formatoResumen->getFormato($elemento->getCotizacion(), $impuestosIndexados, $propinasIndexadas),
			];
		}
		return [
			'llegada'                       => $busqueda->getLlegada(),
			'salida'                        => $busqueda->getSalida(),
			'noches'                        => $busqueda->getNoches(),
			'moneda'                        => $propiedad->moneda_id,
			'detalle'                       => $detalle,
			'impuestos_propinas'            => $formatoCarrito->getImpuestosPropinas($carrito->elementos(), $impuestosIndexados, $propinasIndexadas),
			'total_imp_pro'                 => $formatoCarrito->getTotalImpuestosPropinas($carrito->elementos()),
			'total_con_des_con_com_sin_imp' => $formatoCarrito->getTotalPersonalizado($carrito->elementos(), true, true),
			'total'                         => $formatoCarrito->getTotal($carrito->elementos())
		];
	}
	
	/**
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function resumenCompleto()
	{
		$busqueda = AppBusqueda::recuperar();
		$carrito = AppCarrito::recuperar();
		$propiedad = AppPropiedad::recuperar();
		$tiposHabitacionesIndexadas = AppTiposHabitaciones::listarIndexado();
		$tarifasIndexadas = AppTarifas::listarIndexado();
		$impuestosIndexados = AppImpuestos::listarIndexado();
		$propinasIndexadas = AppPropinas::listarIndexado();
		$complementosIndexados = AppComplementos::listarIndexado();
		$formatoResumen = new FormatoResumen();
		$formatoTarifa = new FormatoTarifa();
		$formatoTipoHabitacion = new FormatoTipoHabitacion();
		$formatoReglaModificacion = new FormatoReglaModificacion();
		$formatoReglaCancelacion = new FormatoReglaCancelacion();
		$formatoBusqueda = new FormatoBusqueda();
		$formatoPromociones = new FormatoPromociones();
		$formatoComplementos = new FormatoComplementos();
		$formatoCarrito = new FormatoCarrito();
		$detalle = [];
		foreach ($carrito->elementos() as $elemento) {
			$detalle[] = [
				'indice'                        => $elemento->getIndice(),
				'busqueda'                      => $formatoBusqueda->getFormatoCotizacion($busqueda, $elemento->getCotizacion()),
				'total_con_des_con_com_sin_imp' => $this->getTotalPersonalizado($elemento->getCotizacion(), true, true),
				'tarifa'                        => $formatoTarifa->getFormato($elemento->getTarifaId(), $tarifasIndexadas),
				'tipo_habitacion'               => $formatoTipoHabitacion->getFormato($elemento->getTipoHabitacionId(), $tiposHabitacionesIndexadas),
				'edades'                        => [
					'ninos_min_1' => $propiedad->ninos_min_1,
					'ninos_max_1' => $propiedad->ninos_max_1,
					'ninos_min_2' => $propiedad->ninos_min_2,
					'ninos_max_2' => $propiedad->ninos_max_2,
					'ninos_min_3' => $propiedad->ninos_min_3,
					'ninos_max_3' => $propiedad->ninos_max_3,
				],
				'tiene_promocion'               => $formatoPromociones->tienePromociones($elemento->getPromociones()),
				'promociones'                   => $formatoPromociones->getFormato($elemento->getPromociones()),
				'regla_cancelacion'             => $formatoReglaCancelacion->getFormato($elemento->getCotizacion()),
				'regla_modificacion'            => $formatoReglaModificacion->getFormato($elemento->getCotizacion()),
				'complementos'                  => $formatoComplementos->getFormatoSinImportes($elemento->getCotizacion(), $complementosIndexados),
				'complementos_adicionales'      => $formatoComplementos->getFormatoAdicionales($elemento->getAdicionales(), $complementosIndexados),
				'resumen'                       => $formatoResumen->getFormato($elemento->getCotizacion(), $impuestosIndexados, $propinasIndexadas),
			];
		}
		return [
			'llegada'                       => $busqueda->getLlegada(),
			'salida'                        => $busqueda->getSalida(),
			'noches'                        => $busqueda->getNoches(),
			'moneda'                        => $propiedad->moneda_id,
			'detalle'                       => $detalle,
			'impuestos_propinas'            => $formatoCarrito->getImpuestosPropinas($carrito->elementos(), $impuestosIndexados, $propinasIndexadas),
			'total_imp_pro'                 => $formatoCarrito->getTotalImpuestosPropinas($carrito->elementos()),
			'total_con_des_con_com_sin_imp' => $formatoCarrito->getTotalPersonalizado($carrito->elementos(), true, true),
			'total'                         => $formatoCarrito->getTotal($carrito->elementos())
		];
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function lista(Request $request)
	{
		$carrito = AppCarrito::recuperar();
		$listaAux = [];
		foreach ($carrito->elementos() as $elemento) {
			$adicionales = [];
			foreach ($elemento->getAdicionales() as $adicional) {
				$adicionales[] = $adicional->getGuardado();
			}
			$listaAux[] = [
				'indice'             => $elemento->getIndice(),
				'tarifa_id'          => $elemento->getTarifaId(),
				'tipo_habitacion_id' => $elemento->getTipoHabitacionId(),
				'cotizacion'         => $elemento->getCotizacion()->getCotizacion(),
				'adicionales'        => $adicionales
			];
		}
		return $listaAux;
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function agregarElemento(Request $request)
	{
		$adultos = (int) $request->input('adultos');
		$ninos1 = $request->input('ninos1');
		$ninos2 = $request->input('ninos2');
		$ninos3 = $request->input('ninos3');
		$tarifaId = (int) $request->input('tarifa_id');
		$tipoHabitacionId = (int) $request->input('tipo_habitacion_id');
		$promoCode = $request->input('promocode');
		$cotizacion = null;
		$disponibilidad = AppDisponibilidad::consultaSimplePorTarifa(
			$adultos,
			$ninos1,
			$ninos2,
			$ninos3,
			$promoCode,
			$tarifaId,
			$tipoHabitacionId
		);
		$promociones = [];
		foreach ($disponibilidad as $tarifa) {
			foreach ($tarifa->getTiposHabitaciones() as $tipoHabitacion) {
				$cotizacion = $tipoHabitacion->getCotizacion();
				$promociones = $tipoHabitacion->getPromociones();
				break;
			}
			break;
		}
		if ($cotizacion === null) {
			throw new \Exception('Sin cotizacion');
		}
		$elemento = AppCarrito::agregarElemento(
			$tarifaId,
			$tipoHabitacionId,
			$promociones,
			$cotizacion
		);
		return [
			'agregado' => $elemento !== null,
			'elemento' => [
				'indice'             => $elemento->getIndice(),
				'tarifa_id'          => $elemento->getTarifaId(),
				'tipo_habitacion_id' => $elemento->getTipoHabitacionId()
			]
		];
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function removerElemento(Request $request)
	{
		$indice = (int) $request->input('indice');
		$elemento = AppCarrito::removerElemento($indice);
		return [
			'removido' => $elemento !== null,
			'elemento' => [
				'indice'             => $indice,
				'tarifa_id'          => $elemento->getTarifaId(),
				'tipo_habitacion_id' => $elemento->getTipoHabitacionId()
			]
		];
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function agregarComplemento(Request $request)
	{
		$indice = (int) $request->input('indice');
		$complementoId = (int) $request->input('complemento_id');
		$adultos = $request->input('adultos');
		$ninos1 = $request->input('ninos1');
		$ninos2 = $request->input('ninos2');
		$ninos3 = $request->input('ninos3');
		$unidades = $request->input('unidades');
		$cotizacion = AppComplementos::cotizar(
			$complementoId,
			$adultos,
			$ninos1,
			$ninos2,
			$ninos3,
			$unidades
		);
		$elementos = AppCarrito::agregarAdicional(
			$indice,
			$complementoId,
			$cotizacion
		);
		return [
			'agregado' => count($elementos) > 0,
			'elemento' => [
				'indice'         => $indice,
				'complemento_id' => $complementoId
			]
		];
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function removerComplemento(Request $request)
	{
		$indice = (int) $request->input('indice', 0);
		$complementoId = (int) $request->input('complemento_id', 0);
		if ($request->has('indice')) {
			$elementos = AppCarrito::removerAdicional($indice, $complementoId);
			return [
				'removido' => count($elementos) > 0,
				'elemento' => [
					'indice'         => $indice,
					'complemento_id' => $complementoId
				]
			];
		}
		else {
			$elementos = AppCarrito::removerAdicionales($complementoId);
			return [
				'removido' => count($elementos) > 0,
				'elemento' => [
					'indice'         => null,
					'complemento_id' => $complementoId
				]
			];
		}
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function limpiar(Request $request)
	{
		AppCarrito::limpiar();
		return [
			'completado' => true
		];
	}
}
