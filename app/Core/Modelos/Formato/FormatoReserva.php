<?php

namespace App\Core\Modelos\Formato;

use App\Core\Carrito\Elemento\Elemento;
use App\Core\Modelos\Cotizacion\Cotizacion;
use App\Core\Modelos\Cotizacion\Detalle\Detalle;

/**
 * Class FormatoReserva
 * @package App\Core\Modelos\Formato
 */
class FormatoReserva
{
	/**
	 * FormatoReserva constructor.
	 */
	public function __construct()
	{
	}
	
	/**
	 * @param Elemento $elemento
	 *
	 * @return mixed
	 */
	public function getReserva($elemento)
	{
		$reserva = [];
		$anticipo = $elemento->getTotalAnticipo();
		$reserva['total_hospedaje'] = $elemento->getCotizacion()->getTotalHospedaje();
		$reserva['total_alimentos'] = $elemento->getCotizacion()->getTotalAlimentos();
		$reserva['total_descuentos'] = $elemento->getCotizacion()->getTotalDescuentos();
		$reserva['total_complementos'] = $elemento->getCotizacion()->getTotalComplementos();
		$reserva['total_impuestos'] = $elemento->getCotizacion()->getTotalImpuestos();
		$reserva['total_propinas'] = $elemento->getCotizacion()->getTotalPropinas();
		$reserva['total'] = $elemento->getCotizacion()->getTotal();
		$reserva['total_anticipo'] = $anticipo;
		$reserva['tipo_cambio_compra'] = $elemento->getCotizacion()->getTipoCambioCompra();
		$reserva['complementos'] = [];
		$reserva['regla_cancelacion'] = $this->getReglaCancelacion($elemento->getCotizacion());
		$reserva['regla_modificacion'] = $this->getReglaModificacion($elemento->getCotizacion());
		$reserva['regla_pago'] = $this->getReglaPago($elemento->getCotizacion(), $anticipo);
		foreach ($elemento->getCotizacion()->getDetalles() as $detalle):
			$reserva['detalles'][] = $this->getDetalle($detalle);
		endforeach;
		$reserva['complementos'] = $this->getComplementos($elemento->getCotizacion()->getComplementos(), $elemento->getAdicionales());
		return $reserva;
	}
	
	/**
	 * @param Detalle $detalleC
	 *
	 * @return mixed
	 */
	private function getDetalle($detalleC)
	{
		$detalle = [];
		$detalle['fecha'] = $detalleC->getFecha();
		$detalle['tipo_habitacion_id'] = $detalleC->getTipoHabitacionId();
		$detalle['habitacion_id'] = $detalleC->getHabitacionId();
		$detalle['promocion_id'] = $detalleC->getPromocionId();
		$detalle['adultos'] = $detalleC->getAdultos();
		$detalle['adultos_hospedaje'] = $detalleC->getAdultosHospedaje();
		$detalle['adultos_hospedaje_descuento'] = $detalleC->getAdultosHospedajeDescuento();
		$detalle['adultos_alimentos'] = $detalleC->getAdultosAlimentos();
		$detalle['adultos_alimentos_descuento'] = $detalleC->getAdultosAlimentosDescuento();
		$detalle['ninos1'] = $detalleC->getNinos1();
		$detalle['ninos2'] = $detalleC->getNinos2();
		$detalle['ninos3'] = $detalleC->getNinos3();
		$detalle['ninos_hospedaje'] = $detalleC->getNinosHospedaje();
		$detalle['ninos_hospedaje_descuento'] = $detalleC->getNinosHospedajeDescuento();
		$detalle['ninos_alimentos'] = $detalleC->getNinosAlimentos();
		$detalle['ninos_alimentos_descuento'] = $detalleC->getNinosAlimentosDescuento();
		$impuestos = [];
		$propinas = [];
		foreach ($detalleC->getImpuestos() as $impuesto):
			$objImpuesto = [];
			$objImpuesto['impuesto_id'] = $impuesto->getImpuestoId();
			$objImpuesto['tipo'] = $impuesto->getTipo();
			$objImpuesto['importe_adultos'] = $impuesto->getImporteAdultos();
			$objImpuesto['importe_ninos'] = $impuesto->getImporteNinos();
			$impuestos[] = $objImpuesto;
		endforeach;
		foreach ($detalleC->getPropinas() as $propina):
			$objPropina = [];
			$objPropina['propina_id'] = $propina->getPropinaId();
			$objPropina['tipo'] = $propina->getTipo();
			$objPropina['importe_adultos'] = $propina->getImporteAdultos();
			$objPropina['importe_ninos'] = $propina->getImporteNinos();
			$propinas[] = $objPropina;
		endforeach;
		$detalle['impuestos'] = $impuestos;
		$detalle['propinas'] = $propinas;
		
		return $detalle;
	}
	
	/**
	 * @param array $incluidos
	 * @param array $adicionales
	 *
	 * @return mixed
	 */
	private function getComplementos($incluidos, $adicionales)
	{
		$complementos = array_merge($incluidos, $adicionales);
		$complementosFormato = [];
		foreach ($complementos as $complemento):
			$detalle = [];
			$detalle['fecha'] = $complemento->getFecha();
			$detalle['complemento_id'] = $complemento->getComplementoId();
			$detalle['producto_id'] = $complemento->getProductoId();
			$detalle['tipo'] = $complemento->getTipo();
			$detalle['precio'] = $complemento->getPrecio();
			$detalle['cantidad'] = $complemento->getCantidad();
			$detalle['importe'] = $complemento->getImporte();
			$detalle['incluido'] = $complemento->getIncluido();
			$impuestos = [];
			$propinas = [];
			foreach ($complemento->getImpuestos() as $impuesto):
				$objImpuesto = [];
				$objImpuesto['impuesto_id'] = $impuesto->getImpuestoId();
				$objImpuesto['importe'] = $impuesto->getImporte();
				$impuestos[] = $objImpuesto;
			endforeach;
			foreach ($complemento->getPropinas() as $propina):
				$objPropina = [];
				$objPropina['propina_id'] = $propina->getPropinaId();
				$objPropina['importe'] = $propina->getImporte();
				$propinas[] = $objPropina;
			endforeach;
			$detalle['impuestos'] = $impuestos;
			$detalle['propinas'] = $propinas;
			$complementosFormato[] = $detalle;
		endforeach;
		return $complementosFormato;
	}
	
	/**
	 * @param Cotizacion $elemento
	 *
	 * @return mixed
	 */
	private function getReglaCancelacion($elemento)
	{
		$formatoReglaCancelacion = new FormatoReglaCancelacion();
		return $formatoReglaCancelacion->getFormato($elemento);
	}
	
	/**
	 * @param Cotizacion $elemento
	 *
	 * @return mixed
	 */
	private function getReglaModificacion($elemento)
	{
		$formatoReglaModificacion = new FormatoReglaModificacion();
		return $formatoReglaModificacion->getFormato($elemento);
	}
	
	/**
	 * @param Cotizacion $elemento
	 * @param float      $nuevoAnticipo
	 *
	 * @return mixed
	 */
	private function getReglaPago($elemento, $nuevoAnticipo = null)
	{
		$formatoReglaPago = new FormatoReglaPago();
		return $formatoReglaPago->getFormato($elemento, $nuevoAnticipo);
	}
}
