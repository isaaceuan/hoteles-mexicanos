<?php

namespace App\Core\FormasPagos\Pasarelas;

final class CargoArticulo
{
    private string $nombre;
    private float $precio;
    private int $cantidad;

    public function __construct(string $nombre, float $precio, int $cantidad)
    {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return float
     */
    public function getPrecio(): float
    {
        return round($this->precio, 2);
    }

    /**
     * @return int
     */
    public function getCantidad(): int
    {
        return $this->cantidad;
    }


}
