<?php namespace App\Repositories;

use App\Models\Depuracion;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repositorio para controlar y registrar las excepciones
 * del sistema.
 *
 * @package App\Repositories
 */
class DepuracionRepository
{
	/**
	 * @var Depuracion
	 */
	private $_modelo;
	
	public function __construct(Container $app)
	{
		$this->_modelo = $app->make(Depuracion::class);
	}
	
	/**
	 * Lista los últimos registros de depuración con datos básicos
	 * como su ID, tipo, mensaje y fecha de creación.
	 *
	 * @param int $limite (Opcional) Cantidad máxima de registros.
	 *
	 * @return Collection
	 */
	public function listarUltimos($limite = 50)
	{
		return $this
			->_modelo
			->newQuery()
			->take($limite)
			->orderByDesc('creado_en')
			->get(['id', 'tipo', 'mensaje', 'creado_en']);
	}
	
	/**
	 * Lista una serie de registros de depuración con datos básicos
	 * como su ID, tipo, mensaje y fecha de creación, filtrando por fecha.
	 *
	 * @param string $fecha
	 * @param int $limite (Opcional) Cantidad máxima de registros.
	 *
	 * @return Collection
	 */
	public function listarPorFecha($fecha, $limite = 50)
	{
		return $this
			->_modelo
			->newQuery()
			->take($limite)
			->whereBetween('creado_en', ["{$fecha} 00:00:00.000", "{$fecha} 23:59:59.999"])
			->orderByDesc('creado_en')
			->get(['id', 'tipo', 'mensaje', 'creado_en']);
	}
	
	/**
	 * Crea un nuevo registro de depuración del sistema y devuelve
	 * el ID del objeto generado.
	 *
	 * @param array $datos
	 *
	 * @return string
	 */
	public function crear(array $datos)
	{
		$datos['id'] = md5(microtime());
		if (!isset($datos['tipo'])) $datos['tipo'] = 'inf';
		if (!isset($datos['archivo'])) $datos['archivo'] = '';
		
		if (!isset($datos['pila']))
		{
			$llamadas = debug_backtrace();
			$raiz = dirname(realpath(__DIR__ . '/../'));
			$pila = [];
			
			foreach ($llamadas as $id => $llamada)
			{
				$llamada['file'] = str_replace([$raiz, DIRECTORY_SEPARATOR], ['', '/'], $llamada['file']);
				$llamadaCadena = "#{$id} {$llamada['file']}({$llamada['line']}): {$llamada['class']}{$llamada['type']}{$llamada['function']}(";
				
				if (!empty($llamada['args']))
				{
					$args = [];
					foreach ($llamada['args'] as $arg) $args[] = is_object($arg) ? get_class($arg) : gettype($arg);
					$llamadaCadena .= implode(', ', $args);
				}
				
				$llamadaCadena .= ')';
				$pila[] = $llamadaCadena;
			}
			
			$datos['pila'] = implode("\n", $pila);
		}
		
		$objeto = $this->_modelo->newQuery()->create($datos);
		return $objeto['id'];
	}
	
	/**
	 * Recupera un registro de depuración por su ID.
	 *
	 * @param string $id
	 *
	 * @return Depuracion
	 */
	public function recuperar($id)
	{
		return $this
			->_modelo
			->newQuery()
			->find($id);
	}
	
	/**
	 * Crea un nuevo registro de depuración del sistema, pasando
	 * el tipo de registro, el origen y el mensaje solamente;
	 * devolviendo el ID del objeto generado.
	 *
	 * @param string $tipo inf, adv o err
	 * @param string $origen
	 * @param string $mensaje
	 *
	 * @return string
	 */
	public function crearPor($tipo, $origen, $mensaje)
	{
		return $this->crear([
			'tipo' => $tipo,
			'origen' => $origen,
			'mensaje' => $mensaje
		]);
	}
}