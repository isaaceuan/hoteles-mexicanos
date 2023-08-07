<?php

namespace App\Core\FormasPagos\Pasarelas;



final class Cargo
{
    private string $moneda;
    private array $parametros;
    private CargoPagador $pagador;
    private array $articulos;
    private array $notificacion;

    public function __construct(string $moneda, array $parametros, CargoPagador $pagador, array $articulos, array $notificacion = [])
    {
        $this->moneda = $moneda;
        $this->parametros = $parametros;
        $this->pagador = $pagador;
        $this->articulos = $articulos;
        $this->notificacion = $notificacion;
    }

    /**
     * @return CargoPagador
     */
    public function getPagador(): CargoPagador
    {
        return $this->pagador;
    }

    /**
     * @return string
     */
    public function getMoneda(): string
    {
        return $this->moneda;
    }

    /**
     * @return CargoArticulo[]
     */
    public function getArticulos(): array
    {
        return $this->articulos;
    }

    /**
     * @param string $nombre
     *
     * @return string
     */
    public function getParametro(string $nombre): ?string
    {
        return @$this->parametros[$nombre];
    }

    /**
     * @param array $parametros
     *
     * @return array
     */
    public function getSolicitud(array $parametros = []): array
    {
        $articulos = [];
        foreach ($this->getArticulos() as $articulo) {
            $articulos[] = [
                'nombre' => $articulo->getNombre(),
                'precio' => $articulo->getPrecio(),
                'cantidad' => $articulo->getCantidad()
            ];
        }

        return [
            'moneda' => 'MXN',
            'parametros' => array_merge($this->parametros, $parametros),
            'pagador' => [
                'nombre' => $this->getPagador()->getNombre(),
                'apellido' => $this->getPagador()->getApellido(),
                'email' => $this->getPagador()->getEmail(),
                'telefono' => $this->getPagador()->getTelefono()
            ],
            'articulos' => $articulos,
            'notificacion' => $this->notificacion
        ];
    }
}
