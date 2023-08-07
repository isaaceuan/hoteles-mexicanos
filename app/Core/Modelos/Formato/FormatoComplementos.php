<?php

namespace App\Core\Modelos\Formato;

use App\Core\Carrito\Elemento\ElementoAdicional;
use App\Core\Modelos\Cotizacion\Cotizacion;

/**
 * Class FormatoComplementos
 * @package App\Core\Modelos\Formato
 */
class FormatoComplementos
{
	/**
	 * FormatoComplementos constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param Cotizacion $cotizacion
	 * @param mixed      $complementosIndexados
	 *
	 * @return mixed
	 */
	public function getFormatoSinImportes($cotizacion, $complementosIndexados)
	{
		$complementos = [];
		foreach ($cotizacion->getComplementos() as $complemento):
			if (!isset($complementos[$complemento->getComplementoId()])):
				$complementos[$complemento->getComplementoId()] = [
					'id'     => $complemento->getComplementoId(),
					'nombre' => ''
				];
			endif;
		endforeach;
		foreach ($complementos as $complementoId => &$complemento):
			if (isset($complementosIndexados[$complementoId])):
				$complemento['nombre'] = $complementosIndexados[$complementoId]->nombre;
			endif;
		endforeach;
		$complementos = array_values($complementos);
		return $complementos;
	}
	
	/**
	 * @param Cotizacion $cotizacion
	 * @param mixed      $complementosIndexados
	 *
	 * @return mixed
	 */
	public function getFormatoConImportes($cotizacion, $complementosIndexados)
	{
		$complementos = [];
		foreach ($cotizacion->getComplementos() as $complemento):
			if (isset($complementos[$complemento->getComplementoId()])):
				$complementos[$complemento->getComplementoId()]['total_sin_imp'] += $complemento->getImporte();
			else:
				$complementos[$complemento->getComplementoId()] = [
					'nombre'        => '',
					'total_sin_imp' => $complemento->getImporte()
				];
			endif;
		endforeach;
		foreach ($complementos as $complementoId => &$complemento):
			if (isset($complementosIndexados[$complementoId])):
				$complemento['nombre'] = $complementosIndexados[$complementoId]->nombre;
			endif;
		endforeach;
		$complementos = array_values($complementos);
		return $complementos;
	}
	
	/**
	 * @param ElementoAdicional[] $adicionales
	 * @param mixed               $complementosIndexados
	 *
	 * @return mixed
	 */
	public function getFormatoAdicionales($adicionales, $complementosIndexados)
	{
		$complementos = [];
		foreach ($adicionales as $complemento):
			if (isset($complementos[$complemento->getComplementoId()])):
				$complementos[$complemento->getComplementoId()]['total_sin_imp'] += $complemento->getImporte();
				$complementos[$complemento->getComplementoId()]['total_imp_pro'] += $complemento->getTotalImpuestos() + $complemento->getTotalPropinas();
				$complementos[$complemento->getComplementoId()]['total'] += $complemento->getTotal();
			else:
				$complementos[$complemento->getComplementoId()] = [
					'complemento_id' => $complemento->getComplementoId(),
					'nombre'         => '',
					'descripcion'    => '',
					'modo_cobro'     => '',
					'imagen_url'     => null,
					'imagen_crop'    => null,
					'total_sin_imp'  => $complemento->getImporte(),
					'total_imp_pro'  => $complemento->getTotalImpuestos() + $complemento->getTotalPropinas(),
					'total'          => $complemento->getTotal(),
					'encabezado'     => [],
					'desgloce'       => []
				];
			endif;
			if (isset($complementos[$complemento->getComplementoId()]['desgloce'][$complemento->getFecha()])):
				$complementos[$complemento->getComplementoId()]['desgloce'][$complemento->getFecha()]['total_sin_imp'] += $complemento->getImporte();
			else:
				$complementos[$complemento->getComplementoId()]['desgloce'][$complemento->getFecha()] = [
					'fecha'         => $complemento->getFecha(),
					'total_sin_imp' => $complemento->getImporte(),
					'detalle'       => []
				];
			
			endif;
			$complementos[$complemento->getComplementoId()]['encabezado'][$complemento->getTipo()] = $complemento->getTipo();
			$complementos[$complemento->getComplementoId()]['desgloce'][$complemento->getFecha()]['detalle'][$complemento->getTipo()] = [
				'tipo'          => $complemento->getTipo(),
				'cantidad'      => $complemento->getCantidad(),
				'precio'        => $complemento->getPrecio()
			];
		endforeach;
		foreach ($complementos as $complementoId => &$complemento):
			if (isset($complementosIndexados[$complementoId])):
				$complementoAux = $complementosIndexados[$complementoId];
				$complemento['nombre'] = $complementoAux->nombre;
				$complemento['descripcion'] = $complementoAux->descripcion;
				$complemento['modo_cobro'] = $complementoAux->modo_cobro;
				$complemento['imagen_url'] = $complementoAux->imagen_url;
				$complemento['imagen_crop'] = $complementoAux->imagen_crop;
				$complemento['desgloce'] = array_values($complemento['desgloce']);
				$complemento['encabezado'] = array_values($complemento['encabezado']);
				foreach ($complemento['desgloce'] as &$noche):
					$noche['detalle'] = array_values($noche['detalle']);
				endforeach;
			endif;
		endforeach;
		$complementos = array_values($complementos);
		return $complementos;
	}
}
