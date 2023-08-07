<?php

namespace App\Core\FormasPagos\Pasarelas;


final class CargoResultado
{
    private object $metadatos;
    private string $redireccion;

    public function __construct(object $metadatos, string $redireccion)
    {
        $this->metadatos = $metadatos;
        $this->redireccion = $redireccion;
    }

    /**
     * @return object
     */
    public function getMetadatos(): object
    {
        return $this->metadatos;
    }

    /**
     * @return string
     */
    public function getRedireccion(): string
    {
        return $this->redireccion;
    }
}
