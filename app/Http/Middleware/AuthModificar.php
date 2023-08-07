<?php

namespace App\Http\Middleware;

use AppModificarReserva;
use Closure;

/**
 * Class AuthModificar
 * @package App\Http\Middleware\AuthModificar
 */
class AuthModificar
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (AppModificarReserva::existeSesion()):
            return $next($request);
        endif;

        return redirect()->route('modificar.login', app()->getLocale());
    }
}
