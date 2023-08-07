<?php

namespace App\Core\FormasPagos\Pasarelas;

use App\Core\EasyRez\Solicitudes\EnviarCargo;
use AppSeleccionarTema;

/**
 * Class AppInstrumentoPago
 * @package App\Facades\FormasPagos\Pasarelas
 */
abstract class InstrumentoPago
{
    private object $formaPago;

    final public function __construct(object $formaPago)
    {
        $this->formaPago = $formaPago;
    }

    final protected function getFormaPago(): object
    {
        return $this->formaPago;
    }

    final protected function enviarCargo(array $solicitud): object
    {
        $formaPago = $this->getFormaPago();
        $pasarela = $formaPago->pasarela_pago->codigo;
        $instrumento = $formaPago->instrumento_pago->codigo;
        return EnviarCargo::ejecutar($pasarela, $instrumento, $solicitud);

    }

    final protected function getUrlDestino(string $pagina): string
    {
        $formaPago = $this->getFormaPago();
//        $pasarela = $formaPago->pasarela_pago->codigo;
//        $instrumento = $formaPago->instrumento_pago->codigo;
//        $url = AppSeleccionarTema::getURLRoute() . '/finish/' . $pasarela . '/' . $instrumento . '/'.$pagina;
        $url = AppSeleccionarTema::getURLRoute() . '/'.$pagina;
        return $url;
    }

    final public function cargarVista(int $indiceFormaPago)
    {
        $formaPago = $this->getFormaPago();
        $pasarela = $formaPago->pasarela_pago->codigo;
        $instrumento = $formaPago->instrumento_pago->codigo;
        $view = AppSeleccionarTema::getURL('.') . '.' . 'formas_pagos' . '.' . $pasarela . '.' . $instrumento . '.' . 'index';
        return view($view, ['forma_pago' => $formaPago]);
    }

    final public function imprimirEtiquetaJs(int $indiceFormaPago): void
    {
        $formaPago = $this->getFormaPago();
        $pasarela = $formaPago->pasarela_pago->codigo;
        $instrumento = $formaPago->instrumento_pago->codigo;
        $timestamp = time();
        $url = '/formas_pagos' . '/' . $pasarela . '/' . $instrumento . '/' . 'javascript.js?ts=' . $timestamp;
        echo "<script type=\"text/javascript\" src=\"{$url}\" data-forma-pago-indice=\"{$indiceFormaPago}\"></script>";
    }

    public function prepararCargo(Cargo $cargo): CargoResultado
    {
        throw new \Exception('Metodo no implementado.');
    }

    public function completarParametros(array &$parametros): void
    {
    }

    abstract public function getRedireccion(object $transaccion): string;
}
