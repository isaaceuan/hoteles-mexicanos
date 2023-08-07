<?php

namespace App\Core\Modelos\Formato;

use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class FormatoResumen
 * @package App\Core\Modelos\Formato
 */
class FormatoResumen
{
	/**
	 * FormatoResumen constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param Cotizacion $cotizacion
	 *
	 * @return float
	 */
	private function _getPromedioComplementos($cotizacion)
	{
		$noches = count($cotizacion->getDetalles());
		return $cotizacion->getTotalComplementos() / $noches;
	}
	
	/**
	 * @param Cotizacion $cotizacion
	 * @param mixed      $impuestosIndexados
	 * @param mixed      $propinasIndexadas
	 *
	 * @return mixed
	 */
	private function getImpuestosPropinas($cotizacion, $impuestosIndexados, $propinasIndexadas)
	{
		$impuestosAux = [];
		$propinasAux = [];
		foreach ($cotizacion->getDetalles() as $detalle):
			foreach ($detalle->getImpuestos() as $impuesto):
				if (isset($impuestosAux[$impuesto->getImpuestoId()])):
					$impuestosAux[$impuesto->getImpuestoId()]['importe'] += $impuesto->getImporte();
				else:
					$impuestosAux[$impuesto->getImpuestoId()] = [
						'nombre'  => '',
						'importe' => $impuesto->getImporte()
					];
				endif;
			endforeach;
			foreach ($detalle->getPropinas() as $propina):
				if (isset($propinasAux[$propina->getPropinaId()])):
					$propinasAux[$propina->getPropinaId()]['importe'] += $propina->getImporte();
				else:
					$propinasAux[$propina->getPropinaId()] = [
						'nombre'  => '',
						'importe' => $propina->getImporte()
					];
				endif;
			endforeach;
		endforeach;
		foreach ($cotizacion->getComplementos() as $complemento):
			foreach ($complemento->getImpuestos() as $impuesto):
				if (isset($impuestosAux[$impuesto->getImpuestoId()])):
					$impuestosAux[$impuesto->getImpuestoId()]['importe'] += $impuesto->getImporte();
				else:
					$impuestosAux[$impuesto->getImpuestoId()] = [
						'nombre'  => '',
						'importe' => $impuesto->getImporte()
					];
				endif;
			endforeach;
			foreach ($complemento->getPropinas() as $propina):
				if (isset($propinasAux[$propina->getPropinaId()])):
					$propinasAux[$propina->getPropinaId()]['importe'] += $propina->getImporte();
				else:
					$propinasAux[$propina->getPropinaId()] = [
						'nombre'  => '',
						'importe' => $propina->getImporte()
					];
				endif;
			endforeach;
		endforeach;
		foreach ($impuestosAux as $impuestoId => &$impuesto):
			if (isset($impuestosIndexados[$impuestoId])):
				$impuesto['nombre'] = $impuestosIndexados[$impuestoId]->nombre;
			endif;
		endforeach;
		foreach ($propinasAux as $propinaId => &$propina):
			if (isset($propinasIndexadas[$propinaId])):
				$propina['nombre'] = $propinasIndexadas[$propinaId]->nombre;
			endif;
		endforeach;
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
	private function _getTotalPersonalizado($cotizacion, $conDescuentos = false, $conComplementos = false, $conImpuestos = false, $conPropinas = false)
	{
		$total = $cotizacion->getTotalHospedaje() + $cotizacion->getTotalAlimentos();
		if (!$conDescuentos):
			$total += $cotizacion->getTotalDescuentos();
		endif;
		if ($conComplementos):
			$total += $cotizacion->getTotalComplementos();
		endif;
		if ($conImpuestos):
			$total += $cotizacion->getTotalImpuestos();
		endif;
		if ($conPropinas):
			$total += $cotizacion->getTotalPropinas();
		endif;
		return $total;
	}
	
	/**
	 * @param Cotizacion $cotizacion
	 * @param mixed      $impuestosIndexados
	 * @param mixed      $propinasIndexadas
	 *
	 * @return mixed
	 */
	public function getFormato($cotizacion, $impuestosIndexados, $propinasIndexadas)
	{
		$promedioComplementos = $this->_getPromedioComplementos($cotizacion);
		$noches = [];
		foreach ($cotizacion->getDetalles() as $noche):
			$noches[] = [
				'fecha'                 => $noche->getFecha(),
				'con_descuentos'        => $noche->conDescuentos(),
				'total_sin_des_sin_imp' => $noche->getTotalPersonalizado() + $promedioComplementos,
				'total_con_des_sin_imp' => $noche->getTotalPersonalizado(true) + $promedioComplementos,
			];
		endforeach;
		return [
			'noches'                        => $noches,
			'impuestos_propinas'            => $this->getImpuestosPropinas($cotizacion, $impuestosIndexados, $propinasIndexadas),
			'con_descuentos'                => $cotizacion->conDescuentos(),
			'total_imp_pro'                 => $cotizacion->getTotalImpuestos() + $cotizacion->getTotalPropinas(),
			'total_con_des_con_com_sin_imp' => $this->_getTotalPersonalizado($cotizacion, true, true),
			'total_des'                     => $cotizacion->getTotalDescuentos(),
			'total'                         => $cotizacion->getTotal(),
		];
	}
	
	/**
	 * @param string     $monedaId
	 * @param int        $disponibles
	 * @param string     $formulaTarifa
	 * @param Cotizacion $cotizacion
	 *
	 * @return mixed
	 */
	public function getFormatoFormula($enCarrito, $monedaId, $disponibles, $formulaTarifa, $cotizacion)
	{
		$noches = count($cotizacion->getDetalles());
		$adultos = $cotizacion->getAdultos();
		$ninos = $cotizacion->getNinos();
		$subtotal = 0;
		$total = 0;
		
		$conDescuento = $cotizacion->getTotalDescuentos() > 0;
		
		switch ($formulaTarifa):
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
		endswitch;
		
		return [
			'formula'       => $formulaTarifa,
			'moneda_id'     => $monedaId,
			'en_carrito'    => $enCarrito,
			'disponibles'   => $disponibles,
			'adultos'       => $adultos,
			'ninos'         => $ninos,
			'noches'        => $noches,
			'con_descuento' => $conDescuento,
			'total_sin_des' => $subtotal,
			'total_con_des' => $total
		];
	}
}
