<?php

namespace App\Handlers;

use Exception;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $exception) {
            $pilaLlamadas = get_excepcion_pila($exception);
    	    error($exception->getMessage(), $pilaLlamadas);
        });
    }

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     *
     * @return void
     *
     * @throws Exception
     */
    /*public function report(Exception $exception)
    {
    	$pilaLlamadas = get_excepcion_pila($exception);
    	Log::error($exception->getMessage(), $pilaLlamadas);
    }*/

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Exception $exception
     *
     * @return Response
     *
	 * @throws Exception
     */
    /*public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }*/
}
