<?php

namespace App\Core\FormasPagos\Pasarelas;



final class CargoPagador
{
    private string $nombre;
    private string $apellido;
    private string $email;
    private string $telefono;

    public function __construct(string $nombre, string $apellido, string $email, string $telefono)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getApellido(): string
    {
        return $this->apellido;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }
}
