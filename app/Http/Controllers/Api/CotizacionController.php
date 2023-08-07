<?php

namespace App\Http\Controllers\Api;

use App\Core\Modelos\Disponibilidad\DisponibilidadTarifa;
use App\Core\Modelos\Disponibilidad\DisponibilidadTipoHabitacion;
use App\Core\Modelos\Formato\FormatoBusqueda;
use App\Core\Modelos\Formato\FormatoComplementos;
use App\Core\Modelos\Formato\FormatoPromociones;
use App\Core\Modelos\Formato\FormatoReglaCancelacion;
use App\Core\Modelos\Formato\FormatoReglaModificacion;
use App\Core\Modelos\Formato\FormatoResumen;
use App\Core\Modelos\Formato\FormatoTarifa;
use App\Core\Modelos\Formato\FormatoTipoHabitacion;
use AppBusqueda;
use AppCarrito;
use AppComplementos;
use AppDisponibilidad;

use App\Http\Controllers\Controller;
use AppImpuestos;
use AppPropiedad;
use AppPropinas;
use AppTarifas;
use AppTiposHabitaciones;
use Illuminate\Http\Request;

/**
 * Class CotizacionController
 * @package App\Http\Controllers\Api
 */
class CotizacionController extends Controller
{
	/**
	 * @param DisponibilidadTarifa[] $disponibilidad
	 */
	private function formatoConsultaSimplePorTarifa($disponibilidad)
	{
		$configuracion = AppPropiedad::recuperarConfiguracion();
		$formatoResumen = new FormatoResumen();
		$resumen = null;
		foreach ($disponibilidad as $tarifa) {
			foreach ($tarifa->getTiposHabitaciones() as $tipoHabitacion) {
				$resumen = $formatoResumen->getFormatoFormula(
					AppCarrito::existeTarifaTipoHabitacion($tarifa->getId(), $tipoHabitacion->getId()),
					$tarifa->getMonedaId(),
					$tipoHabitacion->getOcupacion() - AppCarrito::existencias($tipoHabitacion->getId()),
					$configuracion->formula_tarifa,
					$tipoHabitacion->getCotizacion()
				);
				break;
			}
			break;
		}
		return $resumen;
	}
	
	/**
	 * @param DisponibilidadTarifa[] $disponibilidad
	 */
	private function formatoConsultaMultiplePorTarifa($disponibilidad)
	{
		$busqueda = AppBusqueda::recuperar();
		$propiedad = AppPropiedad::recuperar();
		$configuracion = AppPropiedad::recuperarConfiguracion();
		$tiposHabitacionesIndexadas = AppTiposHabitaciones::listarIndexado();
		$tarifasIndexadas = AppTarifas::listarIndexado();
		$impuestosIndexados = AppImpuestos::listarIndexado();
		$propinasIndexadas = AppPropinas::listarIndexado();
		$complementosIndexados = AppComplementos::listarIndexado();
		$disponibilidadLista = [];
		$formatoTarifa = new FormatoTarifa();
		$formatoTipoHabitacion = new FormatoTipoHabitacion();
		$formatoReglaModificacion = new FormatoReglaModificacion();
		$formatoReglaCancelacion = new FormatoReglaCancelacion();
		$formatoResumen = new FormatoResumen();
		$formatoBusqueda = new FormatoBusqueda();
		$formatoPromociones = new FormatoPromociones();
		$formatoComplementos = new FormatoComplementos();
		foreach ($disponibilidad as $tarifa) {
			$tiposHabitaciones = [];
			foreach ($tarifa->getTiposHabitaciones() as $tipoHabitacion) {
				$tiposHabitaciones[] = [
					'tipo_habitacion'    => $formatoTipoHabitacion->getFormato($tipoHabitacion->getId(), $tiposHabitacionesIndexadas),
					'edades'             => [
						'ninos_min_1' => $propiedad->ninos_min_1,
						'ninos_max_1' => $propiedad->ninos_max_1,
						'ninos_min_2' => $propiedad->ninos_min_2,
						'ninos_max_2' => $propiedad->ninos_max_2,
						'ninos_min_3' => $propiedad->ninos_min_3,
						'ninos_max_3' => $propiedad->ninos_max_3,
					],
					'tiene_promocion'    => $formatoPromociones->tienePromociones($tipoHabitacion->getPromociones()),
					'promociones'        => $formatoPromociones->getFormato($tipoHabitacion->getPromociones()),
					'regla_cancelacion'  => $formatoReglaCancelacion->getFormato($tipoHabitacion->getCotizacion(), true),
					'regla_modificacion' => $formatoReglaModificacion->getFormato($tipoHabitacion->getCotizacion(), true),
					'complementos'       => $formatoComplementos->getFormatoSinImportes($tipoHabitacion->getCotizacion(), $complementosIndexados),
					'resumen'            => $formatoResumen->getFormato($tipoHabitacion->getCotizacion(), $impuestosIndexados, $propinasIndexadas),
					'formula'            => $formatoResumen->getFormatoFormula(
						AppCarrito::existeTarifaTipoHabitacion($tarifa->getId(), $tipoHabitacion->getId()),
						$tarifa->getMonedaId(),
						$tipoHabitacion->getDisponibles() - AppCarrito::existencias($tipoHabitacion->getId()),
						$configuracion->formula_tarifa,
						$tipoHabitacion->getCotizacion()
					)
				];
			}
			$tipoHabitacion = $tarifa->getTipoHabitacion();
			$tipoHabitacionEconomica = [
				'tipo_habitacion'    => $formatoTipoHabitacion->getFormato($tipoHabitacion->getId(), $tiposHabitacionesIndexadas),
				'edades'             => [
					'ninos_min_1' => $propiedad->ninos_min_1,
					'ninos_max_1' => $propiedad->ninos_max_1,
					'ninos_min_2' => $propiedad->ninos_min_2,
					'ninos_max_2' => $propiedad->ninos_max_2,
					'ninos_min_3' => $propiedad->ninos_min_3,
					'ninos_max_3' => $propiedad->ninos_max_3,
				],
				'tiene_promocion'    => $formatoPromociones->tienePromociones($tipoHabitacion->getPromociones()),
				'promociones'        => $formatoPromociones->getFormato($tipoHabitacion->getPromociones()),
				'regla_cancelacion'  => $formatoReglaCancelacion->getFormato($tipoHabitacion->getCotizacion(), true),
				'regla_modificacion' => $formatoReglaModificacion->getFormato($tipoHabitacion->getCotizacion(), true),
				'complementos'       => $formatoComplementos->getFormatoSinImportes($tipoHabitacion->getCotizacion(), $complementosIndexados),
				'resumen'            => $formatoResumen->getFormato($tipoHabitacion->getCotizacion(), $impuestosIndexados, $propinasIndexadas),
				'formula'            => $formatoResumen->getFormatoFormula(
					AppCarrito::existeTarifaTipoHabitacion($tarifa->getId(), $tipoHabitacion->getId()),
					$tarifa->getMonedaId(),
					$tipoHabitacion->getDisponibles() - AppCarrito::existencias($tipoHabitacion->getId()),
					$configuracion->formula_tarifa,
					$tipoHabitacion->getCotizacion()
				)
			];
			$disponibilidadLista[] = [
				'tarifa'                    => $formatoTarifa->getFormato($tarifa->getId(), $tarifasIndexadas),
				'tipos_habitaciones_conteo' => $tarifa->getCantidadTiposHabitaciones(),
				'tipos_habitaciones'        => $tiposHabitaciones,
				'tipo_habitacion_economica' => $tipoHabitacionEconomica,
				'busqueda'                  => $formatoBusqueda->getFormato($busqueda)
			];
		}
		return $disponibilidadLista;
	}
	
	/**
	 * @param DisponibilidadTipoHabitacion[] $disponibilidad
	 */
	private function formatoConsultaMultiplePorTipoHabitacion($disponibilidad)
	{
		$busqueda = AppBusqueda::recuperar();
		$propiedad = AppPropiedad::recuperar();
		$configuracion = AppPropiedad::recuperarConfiguracion();
		$tiposHabitacionesIndexadas = AppTiposHabitaciones::listarIndexado();
		$tarifasIndexadas = AppTarifas::listarIndexado();
		$impuestosIndexados = AppImpuestos::listarIndexado();
		$propinasIndexadas = AppPropinas::listarIndexado();
		$complementosIndexados = AppComplementos::listarIndexado();
		$disponibilidadLista = [];
		$formatoTarifa = new FormatoTarifa();
		$formatoTipoHabitacion = new FormatoTipoHabitacion();
		$formatoReglaModificacion = new FormatoReglaModificacion();
		$formatoReglaCancelacion = new FormatoReglaCancelacion();
		$formatoResumen = new FormatoResumen();
		$formatoBusqueda = new FormatoBusqueda();
		$formatoPromociones = new FormatoPromociones();
		$formatoComplementos = new FormatoComplementos();
		foreach ($disponibilidad as $tipoHabitacion) {
			$tarifas = [];
			foreach ($tipoHabitacion->getTarifas() as $tarifa) {
				$tarifas[] = [
					'tarifa'             => $formatoTarifa->getFormato($tarifa->getId(), $tarifasIndexadas),
					'edades'             => [
						'ninos_min_1' => $propiedad->ninos_min_1,
						'ninos_max_1' => $propiedad->ninos_max_1,
						'ninos_min_2' => $propiedad->ninos_min_2,
						'ninos_max_2' => $propiedad->ninos_max_2,
						'ninos_min_3' => $propiedad->ninos_min_3,
						'ninos_max_3' => $propiedad->ninos_max_3,
					],
					'tiene_promocion'    => $formatoPromociones->tienePromociones($tarifa->getPromociones()),
					'promociones'        => $formatoPromociones->getFormato($tarifa->getPromociones()),
					'regla_cancelacion'  => $formatoReglaCancelacion->getFormato($tarifa->getCotizacion(), true),
					'regla_modificacion' => $formatoReglaModificacion->getFormato($tarifa->getCotizacion(), true),
					'complementos'       => $formatoComplementos->getFormatoSinImportes($tarifa->getCotizacion(), $complementosIndexados),
					'resumen'            => $formatoResumen->getFormato($tarifa->getCotizacion(), $impuestosIndexados, $propinasIndexadas),
					'formula'            => $formatoResumen->getFormatoFormula(
						AppCarrito::existeTarifaTipoHabitacion($tarifa->getId(), $tipoHabitacion->getId()),
						$tarifa->getMonedaId(),
						$tipoHabitacion->getDisponibles() - AppCarrito::existencias($tipoHabitacion->getId()),
						$configuracion->formula_tarifa,
						$tarifa->getCotizacion()
					)
				];
			}
			$tarifa = $tipoHabitacion->getTarifa();
			$tarifaEconomica = [
				'tarifa'             => $formatoTarifa->getFormato($tarifa->getId(), $tarifasIndexadas),
				'edades'             => [
					'ninos_min_1' => $propiedad->ninos_min_1,
					'ninos_max_1' => $propiedad->ninos_max_1,
					'ninos_min_2' => $propiedad->ninos_min_2,
					'ninos_max_2' => $propiedad->ninos_max_2,
					'ninos_min_3' => $propiedad->ninos_min_3,
					'ninos_max_3' => $propiedad->ninos_max_3,
				],
				'tiene_promocion'    => $formatoPromociones->tienePromociones($tarifa->getPromociones()),
				'promociones'        => $formatoPromociones->getFormato($tarifa->getPromociones()),
				'regla_cancelacion'  => $formatoReglaCancelacion->getFormato($tarifa->getCotizacion(), true),
				'regla_modificacion' => $formatoReglaModificacion->getFormato($tarifa->getCotizacion(), true),
				'complementos'       => $formatoComplementos->getFormatoSinImportes($tarifa->getCotizacion(), $complementosIndexados),
				'resumen'            => $formatoResumen->getFormato($tarifa->getCotizacion(), $impuestosIndexados, $propinasIndexadas),
				'formula'            => $formatoResumen->getFormatoFormula(
					AppCarrito::existeTarifaTipoHabitacion($tarifa->getId(), $tipoHabitacion->getId()),
					$tarifa->getMonedaId(),
					$tipoHabitacion->getDisponibles() - AppCarrito::existencias($tipoHabitacion->getId()),
					$configuracion->formula_tarifa,
					$tarifa->getCotizacion()
				)
			];
			$disponibilidadLista[] = [
				'tipo_habitacion'  => $formatoTipoHabitacion->getFormato($tipoHabitacion->getId(), $tiposHabitacionesIndexadas),
				'tarifas_conteo'   => $tipoHabitacion->getCantidadTarifas(),
				'tarifas'          => $tarifas,
				'tarifa_economica' => $tarifaEconomica,
				'busqueda'         => $formatoBusqueda->getFormato($busqueda)
			];
		}
		return $disponibilidadLista;
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function multiple(Request $request)
	{
		$porTarifa = $request->input('por_tarifa', false);
		if ($porTarifa) {
			$disponibilidad = AppDisponibilidad::consultaMultiplePorTarifa();
			return $this->formatoConsultaMultiplePorTarifa($disponibilidad);
		}
		else {
			$disponibilidad = AppDisponibilidad::consultaMultiplePorTipoHabitacion();
			return $this->formatoConsultaMultiplePorTipoHabitacion($disponibilidad);
		}
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function simple(Request $request)
	{
		$adultos = $request->input('adultos');
		$ninos1 = $request->input('ninos1');
		$ninos2 = $request->input('ninos2');
		$ninos3 = $request->input('ninos3');
		$tarifaId = $request->input('tarifa_id');
		$tipoHabitacionId = $request->input('tipo_habitacion_id');
		$promoCode = $request->input('promo_code', '');
		$disponibilidad = AppDisponibilidad::consultaSimplePorTarifa(
			$adultos,
			$ninos1,
			$ninos2,
			$ninos3,
			$promoCode,
			$tarifaId,
			$tipoHabitacionId
		);
		return $this->formatoConsultaSimplePorTarifa($disponibilidad);
	}
}
