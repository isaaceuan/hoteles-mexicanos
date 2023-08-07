<?php

namespace App\Http\Middleware;

use App;
use AppIdiomas;
use AppMonedas;
use AppPropiedad;
use Closure;

class SetLocale
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

		\Log::debug('********************** SetLocale -> handle');

		$idiomaIdUrl = $request->segment(1);
		$idiomasIds = [];

		$idiomas = AppIdiomas::listar();
		foreach ($idiomas as $idioma):
			$idiomasIds[] = $idioma->id;
		endforeach;
		if (empty($idiomaIdUrl)):
			$propiedad = AppPropiedad::recuperar();
			$idiomaId = $propiedad->idioma_id;
			return redirect()->route('app.inicio', ['locale' => $idiomaId]);
		endif;
		if (!in_array($idiomaIdUrl, $idiomasIds)):
			abort(404);
		endif;
		App::setLocale($idiomaIdUrl);
		AppMonedas::establecerMonedaDefault();
		return $next($request);
	}
}
