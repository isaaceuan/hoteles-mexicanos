<?php

namespace App\Http\Middleware;

use AppSesion;
use Closure;

class SesionRutas
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		AppSesion::renovar();
		return $next($request);
	}
}
