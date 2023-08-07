<?php

namespace App\Core\Modelos\Disponibilidad;

use App\Core\Modelos\Cotizacion\Cotizacion;
use App\Core\Modelos\Tarifa\Tarifa;
use App\Core\Modelos\TipoHabitacion\TipoHabitacion;

/**
 * Class Disponibilidad
 * @package App\Core\Modelos\Disponibilidad
 */
class Disponibilidad
{
	/**
	 * @param int   $tarifaId
	 * @param mixed $tarifasIndexadas
	 *
	 * @return Tarifa
	 */
	public function getTarifa($tarifaId, $tarifasIndexadas)
	{
		if (isset($tarifasIndexadas[$tarifaId])){
			$tarifaAux = $tarifasIndexadas[$tarifaId];
			return new Tarifa($tarifaAux);
		}
		return null;
	}
	
	/**
	 * @param int   $tipoHabitacionId
	 * @param mixed $tiposHabitacionesIndexadas
	 *
	 * @return TipoHabitacion
	 */
	public function getTipoHabitacion($tipoHabitacionId, $tiposHabitacionesIndexadas)
	{
		if (isset($tiposHabitacionesIndexadas[$tipoHabitacionId])){
			$tipoHabitacion = $tiposHabitacionesIndexadas[$tipoHabitacionId];
			return new TipoHabitacion($tipoHabitacion);
		}
		return null;
	}
	
	/**
	 * @param int $noches
	 *
	 * @return float
	 */
	public function getPromedioComplementos($cotizacion)
	{
		$noches = count($cotizacion->getDetalles());
		return $cotizacion->getTotalComplementos() / $noches;
	}
	
	/**
	 * @param Cotizacion $cotizacion
	 * @param mixed      $impuestosCatalogo
	 * @param mixed      $propinasCatalogo
	 *
	 * @return mixed
	 */
	public function getImpuestosPropinas($cotizacion, $impuestosCatalogo, $propinasCatalogo)
	{
		$impuestosCatalogoAux = [];
		foreach ($impuestosCatalogo as $impuesto){
			$impuestosCatalogoAux[$impuesto->id] = $impuesto;
		}
		$propinasCatalogoAux = [];
		foreach ($propinasCatalogo as $propina){
			$propinasCatalogoAux[$propina->id] = $propina;
		}
		$impuestosAux = [];
		$propinasAux = [];
		foreach ($cotizacion->getDetalles() as $detalle){
			foreach ($detalle->getImpuestos() as $impuesto){
				if (isset($impuestosAux[$impuesto->getImpuestoId()])){
					$impuestosAux[$impuesto->getImpuestoId()]['importe'] += $impuesto->getImporte();
				}else{
					$impuestosAux[$impuesto->getImpuestoId()] = [
						'nombre'  => '',
						'importe' => $impuesto->getImporte()
					];
				}
			}
			foreach ($detalle->getPropinas() as $propina){
				if (isset($propinasAux[$propina->getPropinaId()])){
					$propinasAux[$propina->getPropinaId()]['importe'] += $propina->getImporte();
				}else{
					$propinasAux[$propina->getPropinaId()] = [
						'nombre'  => '',
						'importe' => $propina->getImporte()
					];
				}
			}
		}
		foreach ($cotizacion->getComplementos() as $complemento){
			foreach ($complemento->getImpuestos() as $impuesto){
				if (isset($impuestosAux[$impuesto->getImpuestoId()])){
					$impuestosAux[$impuesto->getImpuestoId()]['importe'] += $impuesto->getImporte();
				}else{
					$impuestosAux[$impuesto->getImpuestoId()] = [
						'nombre'  => '',
						'importe' => $impuesto->getImporte()
					];
				}
			}
			foreach ($complemento->getPropinas() as $propina){
				if (isset($propinasAux[$propina->getPropinaId()])){
					$propinasAux[$propina->getPropinaId()]['importe'] += $propina->getImporte();
				}else{
					$propinasAux[$propina->getPropinaId()] = [
						'nombre'  => '',
						'importe' => $propina->getImporte()
					];
				}
			}
		}
		foreach ($impuestosAux as $impuestoId => &$impuesto){
			if (isset($impuestosCatalogoAux[$impuestoId])){
				$impuesto['nombre'] = $impuestosCatalogoAux[$impuestoId]->nombre;
			}
		}
		foreach ($propinasAux as $propinaId => &$propina){
			if (isset($propinasCatalogoAux[$propinaId])){
				$propina['nombre'] = $propinasCatalogoAux[$propinaId]->nombre;
			}
		}
		$impuestosAux = array_values($impuestosAux);
		$propinasAux = array_values($propinasAux);
		return array_merge($impuestosAux, $propinasAux);
	}
	
	/**
	 * @param Cotizacion $cotizacion
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
		if (!$conDescuentos) $total += $cotizacion->getTotalDescuentos();
		if ($conComplementos) $total += $cotizacion->getTotalComplementos();
		if ($conImpuestos) $total += $cotizacion->getTotalImpuestos();
		if ($conPropinas) $total += $cotizacion->getTotalPropinas();
		return $total;
	}
	
	/**
	 * @param string     $monedaId
	 * @param int        $disponibles
	 * @param string     $formulaTarifa
	 * @param Cotizacion $cotizacion
	 *
	 * @return array
	 */
	public function getResumen($monedaId, $disponibles, $formulaTarifa, $cotizacion)
	{
		$noches = count($cotizacion->getDetalles());
		$adultos = $cotizacion->getAdultos();
		$ninos = $cotizacion->getNinos();
		$subtotal = 0;
		$total = 0;
		
		$conDescuento = $cotizacion->getTotalDescuentos() > 0;
		
		switch ($formulaTarifa) {
			case 'prom-imp':
				$subtotal = ($cotizacion->getTotalHospedaje() + $cotizacion->getTotalAlimentos() + $cotizacion->getTotalComplementos() + $cotizacion->getTotalDescuentos()) / $noches;
				$total = ($cotizacion->getTotalHospedaje() + $cotizacion->getTotalAlimentos() + $cotizacion->getTotalComplementos()) / $noches;
				break;
			case 'prom+imp':
				$subtotal = ($cotizacion->getTotal() + $cotizacion->getTotalDescuentos()) / $noches;
				$total = $cotizacion->getTotal() / $noches;
				break;
			case 'total-imp':
				$subtotal = $cotizacion->getTotalHospedaje() + $cotizacion->getTotalAlimentos() + $cotizacion->getTotalComplementos() + $cotizacion->getTotalDescuentos();
				$total = $cotizacion->getTotalHospedaje() + $cotizacion->getTotalAlimentos() + $cotizacion->getTotalComplementos();
				break;
			case 'total+imp':
				$subtotal = $cotizacion->getTotal() + $cotizacion->getTotalDescuentos();
				$total = $cotizacion->getTotal();
				break;
		}
		
		return [
			'formula'             => $formulaTarifa,
			'moneda_id'           => $monedaId,
			'disponibles'         => $disponibles,
			'adultos'             => $adultos,
			'ninos'               => $ninos,
			'noches'              => $noches,
			'con_descuento'       => $conDescuento,
			'total_sin_des' => $subtotal,
			'total_con_des' => $total
		];
	}
}
