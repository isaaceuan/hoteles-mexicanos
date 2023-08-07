<?php

namespace App\Core\Modelos\Formato;

use App\Core\Busqueda\Busqueda;
use App\Core\Carrito\Elemento\Elemento;

/**
 * Class FormatoCarrito
 * @package App\Core\Modelos\Formato
 */
class FormatoCarrito
{
	/**
	 * FormatoCarrito constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param Elemento[] $elementos
	 * @param mixed      $impuestosIndexados
	 * @param mixed      $propinasIndexadas
	 *
	 * @return mixed
	 */
	public function getImpuestosPropinas($elementos, $impuestosIndexados, $propinasIndexadas)
	{
		$impuestosAux = [];
		$propinasAux = [];
		foreach ($elementos as $elemento) {
			foreach ($elemento->getCotizacion()->getDetalles() as $detalle) {
				foreach ($detalle->getImpuestos() as $impuesto) {
					if (isset($impuestosAux[$impuesto->getImpuestoId()])) {
						$impuestosAux[$impuesto->getImpuestoId()]['importe'] += $impuesto->getImporte();
					}
					else {
						$impuestosAux[$impuesto->getImpuestoId()] = [
							'nombre'  => '',
							'importe' => $impuesto->getImporte()
						];
					}
				}
				foreach ($detalle->getPropinas() as $propina) {
					if (isset($propinasAux[$propina->getPropinaId()])) {
						$propinasAux[$propina->getPropinaId()]['importe'] += $propina->getImporte();
					}
					else {
						$propinasAux[$propina->getPropinaId()] = [
							'nombre'  => '',
							'importe' => $propina->getImporte()
						];
					}
				}
			}
			foreach ($elemento->getCotizacion()->getComplementos() as $complemento) {
				foreach ($complemento->getImpuestos() as $impuesto) {
					if (isset($impuestosAux[$impuesto->getImpuestoId()])) {
						$impuestosAux[$impuesto->getImpuestoId()]['importe'] += $impuesto->getImporte();
					}
					else {
						$impuestosAux[$impuesto->getImpuestoId()] = [
							'nombre'  => '',
							'importe' => $impuesto->getImporte()
						];
					}
				}
				foreach ($complemento->getPropinas() as $propina) {
					if (isset($propinasAux[$propina->getPropinaId()])) {
						$propinasAux[$propina->getPropinaId()]['importe'] += $propina->getImporte();
					}
					else {
						$propinasAux[$propina->getPropinaId()] = [
							'nombre'  => '',
							'importe' => $propina->getImporte()
						];
					}
				}
			}
			foreach ($elemento->getAdicionales() as $complemento) {
				foreach ($complemento->getImpuestos() as $impuesto) {
					if (isset($impuestosAux[$impuesto->getImpuestoId()])) {
						$impuestosAux[$impuesto->getImpuestoId()]['importe'] += $impuesto->getImporte();
					}
					else {
						$impuestosAux[$impuesto->getImpuestoId()] = [
							'nombre'  => '',
							'importe' => $impuesto->getImporte()
						];
					}
				}
				foreach ($complemento->getPropinas() as $propina) {
					if (isset($propinasAux[$propina->getPropinaId()])) {
						$propinasAux[$propina->getPropinaId()]['importe'] += $propina->getImporte();
					}
					else {
						$propinasAux[$propina->getPropinaId()] = [
							'nombre'  => '',
							'importe' => $propina->getImporte()
						];
					}
				}
			}
		}
		foreach ($impuestosAux as $impuestoId => &$impuesto) {
			if (isset($impuestosIndexados[$impuestoId])) {
				$impuesto['nombre'] = $impuestosIndexados[$impuestoId]->nombre;
			}
		}
		foreach ($propinasAux as $propinaId => &$propina) {
			if (isset($propinasIndexadas[$propinaId])) {
				$propina['nombre'] = $propinasIndexadas[$propinaId]->nombre;
			}
		}
		$impuestosAux = array_values($impuestosAux);
		$propinasAux = array_values($propinasAux);
		return array_merge($impuestosAux, $propinasAux);
	}
	
	/**
	 * @param Elemento[] $elementos
	 *
	 * @return float
	 */
	public function getTotalImpuestosPropinas($elementos)
	{
		$importe = 0;
		foreach ($elementos as $elemento) {
			$importe += ($elemento->getCotizacion()->getTotalImpuestos() + $elemento->getCotizacion()->getTotalPropinas());
			foreach ($elemento->getAdicionales() as $adicional) {
				$importe += $adicional->getTotalImpuestos() + $adicional->getTotalPropinas();
			}
		}
		return $importe;
	}
	
	/**
	 * @param Elemento[] $elementos
	 *
	 * @param bool       $conDescuentos
	 * @param bool       $conComplementos
	 * @param bool       $conImpuestos
	 * @param bool       $conPropinas
	 *
	 * @return float
	 */
	public function getTotalPersonalizado($elementos, $conDescuentos = false, $conComplementos = false, $conImpuestos = false, $conPropinas = false)
	{
		$total = 0;
		foreach ($elementos as $elemento) {
			$total += $elemento->getCotizacion()->getTotalHospedaje() + $elemento->getCotizacion()->getTotalAlimentos();
			if (!$conDescuentos) {
				$total += $elemento->getCotizacion()->getTotalDescuentos();
			}
			if ($conComplementos) {
				$total += $elemento->getCotizacion()->getTotalComplementos();
			}
			if ($conImpuestos) {
				$total += $elemento->getCotizacion()->getTotalImpuestos();
			}
			if ($conPropinas) {
				$total += $elemento->getCotizacion()->getTotalPropinas();
			}
			foreach ($elemento->getAdicionales() as $adicional) {
				$total += $adicional->getImporte();
			}
		}
		return $total;
	}
	
	/**
	 * @param Elemento[] $elementos
	 *
	 * @return float
	 */
	public function getTotal($elementos)
	{
		$importe = 0;
		foreach ($elementos as $elemento) {
			$importe += $elemento->getCotizacion()->getTotal();
			foreach ($elemento->getAdicionales() as $adicional) {
				$importe += $adicional->getTotal();
			}
		}
		return $importe;
	}
	
	/**
	 * @param Elemento[] $elementos
	 * @param Busqueda   $busqueda
	 *
	 * @return mixed
	 */
	public function getGuardado($elementos, $busqueda, $titular, $comentarios)
	{
		$reservaciones = [];
		foreach ($elementos as $elemento) {
			$detalles = [];
			foreach ($elemento->getCotizacion()->getDetalles() as $detalle) {
				$detalles[] = [
					'fecha'                       => $detalle->getFecha(),
					'tipo_habitacion_id'          => $detalle->getTipoHabitacionId(),
					'habitacion_id'               => null,
					'promocion_id'                => $detalle->getPromocionId(),
					'adultos'                     => $detalle->getAdultos(),
					'adultos_hospedaje'           => $detalle->getAdultosHospedaje(),
					'adultos_hospedaje_descuento' => $detalle->getAdultosHospedajeDescuento(),
					'adultos_alimentos'           => $detalle->getAdultosAlimentos(),
					'adultos_alimentos_descuento' => $detalle->getAdultosAlimentosDescuento(),
					'ninos1'                      => $detalle->getNinos1(),
					'ninos2'                      => $detalle->getNinos2(),
					'ninos3'                      => $detalle->getNinos3(),
					'ninos_hospedaje'             => $detalle->getNinosHospedaje(),
					'ninos_hospedaje_descuento'   => $detalle->getNinosHospedajeDescuento(),
					'ninos_alimentos'             => $detalle->getNinosAlimentos(),
					'ninos_alimentos_descuento'   => $detalle->getNinosAlimentosDescuento(),
					'impuestos'                   => $detalle->getImpuestosGuardado(),
					'propinas'                    => $detalle->getPropinasGuardado()
				];
			}
			$reglaCancelacion = null;
			if ($elemento->getCotizacion()->tieneReglaCancelacion()) {
				$restricciones = [];
				if ($elemento->getCotizacion()->getReglaCancelacion()->tieneRestricciones()) {
					foreach ($elemento->getCotizacion()->getReglaCancelacion()->getRestricciones() as $restriccion) {
						$restricciones[] = [
							'dias_entrada' => $restriccion->getDiasEntrada(),
							'tasa'         => $restriccion->getTasa(),
							'fecha_limite' => $restriccion->getFechaLimite(),
							'reembolso'    => $restriccion->getReembolso()
						];
					}
				}
				$reglaCancelacion = [
					'regla_cancelacion_id' => $elemento->getCotizacion()->getReglaCancelacion()->getReglaCancelacionId(),
					'es_reembolsable'      => $elemento->getCotizacion()->getReglaCancelacion()->esReembolsable(),
					'restricciones'        => $restricciones
				];
			}
			$reglaModificacion = null;
			if ($elemento->getCotizacion()->tieneReglaModificacion()) {
				$reglaModificacion = [
					'regla_modificacion_id' => $elemento->getCotizacion()->getReglaModificacion()->getReglaModificacionId(),
					'modo'                  => $elemento->getCotizacion()->getReglaModificacion()->getModo(),
					'dias_anticipacion'     => $elemento->getCotizacion()->getReglaModificacion()->getDiasAnticipacion(),
					'modificaciones'        => $elemento->getCotizacion()->getReglaModificacion()->getModificaciones(),
					'fecha_limite'          => $elemento->getCotizacion()->getReglaModificacion()->getFechaLimite()
				];
			}
			
			$reglaPago = null;
			if ($elemento->getCotizacion()->tieneReglaPago()) {
				$reglaPago = [
					'regla_pago_id' => $elemento->getCotizacion()->getReglaPago()->getReglaPagoId(),
					'modo'          => $elemento->getCotizacion()->getReglaPago()->getModo(),
					'valor'         => $elemento->getCotizacion()->getReglaPago()->getValor(),
					'anticipo'      => $elemento->getCotizacion()->getReglaPago()->getAnticipo(),
				];
			}
			$complementos = [];
			foreach ($elemento->getCotizacion()->getComplementos() as $complemento) {
				$complementos[] = $complemento->getGuardado();
			}
			foreach ($elemento->getAdicionales() as $complemento) {
				$complementos[] = $complemento->getGuardado();
			}
			$reservaciones[] = [
				'fecha_entrada'      => $busqueda->getLlegada(),
				'noches'             => $busqueda->getNoches(),
				'tarifa_id'          => $elemento->getTarifaId(),
				'titular'            => $titular,
				'comentarios'        => $comentarios,
				'detalles'           => $detalles,
				'regla_cancelacion'  => $reglaCancelacion,
				'regla_modificacion' => $reglaModificacion,
				'regla_pago'         => $reglaPago,
				'complementos'       => $complementos
			];
		}
		return $reservaciones;
	}
}
