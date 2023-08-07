<?php namespace App\Core\FormasPagos\WebHook;

final class CompraWebHook
{
    public const USUARIO = 'compras.webhook';
    public const CONTRASENA = 'compras?2020*';

    protected function autenticar(string $usuario, string $contrasena): bool
    {
        return $usuario === self::USUARIO && $contrasena === self::CONTRASENA;
    }

    protected function procesar(array $solicitud): void
    {
//        $this->log('[' . $_SERVER['REMOTE_ADDR'] . '] ' . json_encode($solicitud, JSON_UNESCAPED_SLASHES));
    }
}
