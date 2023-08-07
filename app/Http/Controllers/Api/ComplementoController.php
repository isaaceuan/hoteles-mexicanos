<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use AppCarrito;
use AppComplementos;
use AppPropiedad;
use AppTarifas;
use AppTiposHabitaciones;
use Illuminate\Http\Request;

/**
 * Class ComplementoController
 * @package App\Http\Controllers\Api
 */
class ComplementoController extends Controller
{
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function lista(Request $request)
	{
		$complementosDB = AppComplementos::listar();
		$carrito = AppCarrito::recuperar();
		$propiedad = AppPropiedad::recuperar();
		$tiposHabitacionesIndexadas = AppTiposHabitaciones::listarIndexado();
		$tarifasIndexadas = AppTarifas::listarIndexado();
		$complementos = [];
		foreach ($complementosDB as $complemento){
			$tiposHabitaciones = [];
			foreach ($carrito->elementos() as $elemento){
				if (!$elemento->getCotizacion()->tieneComplemento($complemento->id)){
					$adultos = '';
					$ninos1 = '';
					$ninos2 = '';
					$ninos3 = '';
					$unidades = '';
					if ($complemento->modo_cobro === 'persona' || $complemento->modo_cobro === 'persona_noche'){
						$adultos = $elemento->getCotizacion()->getAdultos();
						if ($complemento->aplica_ninos1){
							$ninos1 = $elemento->getCotizacion()->getNinos1();
						}
						if ($complemento->aplica_ninos2){
							$ninos2 = $elemento->getCotizacion()->getNinos2();
						}
						if ($complemento->aplica_ninos3){
							$ninos3 = $elemento->getCotizacion()->getNinos3();
						}
					}
					if ($complemento->modo_cobro === 'estancia'){
						$unidades = $elemento->tieneUnidadesAdicional($complemento->id);
					}
					$tarifaNombre = '';
					$tipoHabitacionNombre = '';
					if (isset($tarifasIndexadas[$elemento->getTarifaId()])){
						$tarifa = $tarifasIndexadas[$elemento->getTarifaId()];
						$tarifaNombre = $tarifa->nombre;
					}
					if (isset($tiposHabitacionesIndexadas[$elemento->getTipoHabitacionId()])){
						$tipoHabitacion = $tiposHabitacionesIndexadas[$elemento->getTipoHabitacionId()];
						$tipoHabitacionNombre = $tipoHabitacion->nombre;
					}
					$tiposHabitaciones[] = [
						'indice'             => $elemento->getIndice(),
						'tipo_habitacion'    => $tipoHabitacionNombre,
						'tarifa'             => $tarifaNombre,
						'adultos'            => $adultos,
						'ninos1'             => $ninos1,
						'ninos2'             => $ninos2,
						'ninos3'             => $ninos3,
						'unidades'           => $unidades,
						'seleccionado'       => $elemento->tieneAdicional($complemento->id)
					];
				}
			}
			if (!empty($tiposHabitaciones)){
				$complementos[] = [
					'id'                 => $complemento->id,
					'moneda_id'          => $complemento->moneda_id,
					'modo_cobro'         => $complemento->modo_cobro,
					'imagen_crop'        => $complemento->imagen_crop,
					'nombre'             => $complemento->nombre,
					'descripcion'        => $complemento->descripcion,
					'precio_adultos'     => $complemento->precio_adultos,
					'precio_ninos1'      => $complemento->precio_ninos1,
					'precio_ninos2'      => $complemento->precio_ninos2,
					'precio_ninos3'      => $complemento->precio_ninos3,
					'aplica_adultos'     => $complemento->aplica_adultos,
					'aplica_ninos1'      => $complemento->aplica_ninos1,
					'aplica_ninos2'      => $complemento->aplica_ninos2,
					'aplica_ninos3'      => $complemento->aplica_ninos3,
					'ninos_min_1'        => $propiedad->ninos_min_1,
					'ninos_max_1'        => $propiedad->ninos_max_1,
					'ninos_min_2'        => $propiedad->ninos_min_2,
					'ninos_max_2'        => $propiedad->ninos_max_2,
					'ninos_min_3'        => $propiedad->ninos_min_3,
					'ninos_max_3'        => $propiedad->ninos_max_3,
					'precio_unitario'    => $complemento->precio_unitario,
					'tipos_habitaciones' => $tiposHabitaciones,
				];
			}
		}
		return $complementos;
	}

	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function cotizar(Request $request)
	{
		$complemento = AppComplementos::cotizar(
			$request->input('complemento_id'),
			$request->input('adultos'),
			$request->input('ninos1'),
			$request->input('ninos2'),
			$request->input('ninos3'),
			$request->input('unidades')
		);
		return $complemento;
	}
}
