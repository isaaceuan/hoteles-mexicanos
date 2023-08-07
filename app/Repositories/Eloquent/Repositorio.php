<?php namespace App\Repositories\Eloquent;

use App\Models\Modelo;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Container\Container;

/**
 * Representa un repositorio para manipular objetos en modelos
 * con llave primaria <i>id</i>.
 *
 * @package App\Repositories\Eloquent
 */
abstract class Repositorio implements IRepositorio
{
	/**
	 * @var Modelo
	 */
	private $_modelo;
	
	/**
	 * @var Container
	 */
	private $_app;
	
	/**
	 * @var int
	 */
	private $_registros = 200;
	
	/**
	 * @param Container $app
	 *
	 * @throws \Exception
	 */
	public function __construct(Container $app)
	{
		$this->_app = $app;
		$this->onInicializar();
	}
	
	/**
	 * Ocurre cuando se inicializa el repositorio.
	 *
	 * @throws \Exception
	 */
	protected function onInicializar()
	{
		$this->_modelo = $this->generarModelo($this->getModeloClase());
	}
	
	/**
	 * Devuelve la instancia de la aplicación actual.
	 *
	 * @return Container
	 */
	protected final function getApp()
	{
		return $this->_app;
	}
	
	/**
	 * Establece la cantidad máxima de registros permitidos
	 * para recuperar/procesar.
	 *
	 * @param int $maximo
	 */
	protected final function setRegistros($maximo)
	{
		$this->_registros = $maximo;
	}
	
	/**
	 * Devuelve la cantidad máxima de registros permitidos
	 * para recuperar/procesar.
	 *
	 * @return int
	 */
	protected final function getRegistros()
	{
		return $this->_registros;
	}
	
	/**
	 * Objeto con el modelo del repositorio.
	 *
	 * @return Modelo
	 */
	protected final function getModelo()
	{
		return $this->_modelo;
	}
	
	/**
	 * @inheritdoc
	 */
	protected abstract function getModeloClase();
	
	/**
	 * @inheritdoc
	 */
	public function listar(array $columnas = ['*'], array $ordenarPor = [])
	{
		if (empty($columnas)) $columnas = ['*'];
		return $this
			->crearConsulta([], $ordenarPor)
			->get($columnas);
	}
	
	/**
	 * @inheritdoc
	 */
	public function listarPor(array $criterios, array $columnas = [], array $ordenarPor = [])
	{
		if (empty($columnas)) $columnas = ['*'];
		return $this
			->crearConsulta($criterios, $ordenarPor)
			->get($columnas);
	}
	
	/**
	 * @inheritdoc
	 */
	public function buscar($id, array $columnas = [])
	{
		$objeto = null;
		
		# Si el ID es un arreglo entonces...
		if (is_array($id))
		{
			# Recuperar la lista de llaves primarias.
			$criterios = [];
			$pks = $this->getLlavesPrimarias();
			
			# Para cada columna de la llave primaria...
			foreach ($pks as $indice => $pk)
			{
				# Si no se le encuentra un valor, arrojar error.
				if (!isset($id[$indice])) throw new RepositoryException("No se especificó un valor para la llave primaria {$pk}.");
				
				# Anexar la columna como criterio de búsqueda junto con su valor.
				$criterios[$pk] = $id[$indice];
			}
			
			# Recuperar el primer objeto encontrado.
			$objeto = $this->buscarPor($criterios, $columnas);
		}
		else
		{
			# En caso contrario, hacer una búsqueda directa por find.
			if (empty($columnas)) $columnas = ['*'];
			$objeto = $this
				->crearConsulta()
				->findOrFail($id, $columnas);
		}
		
		return $objeto;
	}
	
	/**
	 * @inheritdoc
	 *
	 * @return Modelo
	 */
	public function buscarPor(array $criterios, array $columnas = [])
	{
		if (empty($columnas)) $columnas = ['*'];
		
		return $this
			->crearConsulta($criterios)
			->firstOrFail($columnas);
	}
	
	/**
	 * @inheritdoc
	 *
	 * @return Modelo
	 */
	public function crear(array $datos)
	{
		return $this
			->_modelo
			->newQuery()
			->create($datos);
	}
	
	/**
	 * @inheritdoc
	 */
	public function actualizar(array $datos, $id)
	{
		$objeto = $this->buscar($id);
		$objeto->update($datos);
		return $objeto;
	}
	
	/**
	 * @inheritdoc
	 */
	public function actualizarPor(array $datos, array $criterios)
	{
		$objeto = $this->buscarPor($criterios);
		$objeto->update($datos);
		return $objeto;
	}
	
	/**
	 * @inheritdoc
	 */
	public function eliminar($id)
	{
		$objeto = $this->buscar($id, $this->getLlavesPrimarias());
		$objeto->delete();
		return $objeto;
	}
	
	/**
	 * @inheritdoc
	 */
	public function eliminarPor(array $criterios)
	{
		$objeto = $this->buscarPor($criterios, $this->getLlavesPrimarias());
		$objeto->delete();
		return $objeto;
	}
	
	/**
	 * Genera una instancia de un modelo de acuerdo al nombre de su clase.
	 *
	 * @param string $clase Nombre del modelo.
	 *
	 * @return Modelo
	 *
	 * @throws RepositoryException
	 */
	protected final function generarModelo($clase)
	{
		# Crear el modelo de la clase hija.
		$modelo = $this->_app->make($clase);
		
		# Si el modelo no es del tipo base, arrojar un error.
		if (!$modelo instanceof Modelo) throw new RepositoryException("Clase {$clase} debe ser una intancia de " . Modelo::class);
		
		# Devolverlo.
		return $modelo;
	}
	
	/**
	 * Devuelve la lista de columnas que son llave primaria
	 * en el modelo actual.
	 *
	 * @return string[]
	 */
	protected final function getLlavesPrimarias()
	{
		# Recuperar los nombres de las columnas que son llaves primarias.
		$pks = $this->_modelo->getKeyName();
		
		# Si no es arreglo, convertirlo.
		if (!is_array($pks)) $pks = [$pks];
		
		# Devolver el resultado.
		return $pks;
	}
	
	/**
	 * Devuelve una consulta de lectura lista para ejecutar con el modelo actual,
	 * con los criterios de búsqueda y ordenamiento que se necesiten.
	 *
	 * @param array $criterios (Opcional) Lista de criterios clave/valor para filtrar
	 *                         los resultados.
	 * @param string[] $ordenarPor (Opcional) Arreglo de columnas para ordenar ascendentemente.
	 *
	 * @return Builder
	 */
	protected function crearConsulta(array $criterios = [], array $ordenarPor = [])
	{
		# Crear la consulta delimitada a la cantidad máxima de registros.
		$consulta = $this
			->_modelo
			->newQuery()
			->take($this->_registros);
		
		# Anexar los criterios adicionales.
		foreach ($criterios as $criterio => $valor)
		{
			$consulta->where($criterio, '=', $valor);
		}
		
		# Si está vacío la lista entonces, poner las llaves primarias.
		if (empty($ordenarPor)) $ordenarPor = $this->getLlavesPrimarias();
		
		# Ordenar por las columnas solicitadas.
		foreach ($ordenarPor as $indice => $valor)
		{
			# Ordenar por columna (el indice) en orden descendente.
			if (is_string($indice) && strtolower($valor) == 'desc')
			{
				$consulta->orderByDesc($indice);
			}
			# Ordenar por columna (el indice) en orden ascendente.
			else if (is_string($indice) && strtolower($valor) == 'asc')
			{
				$consulta->orderBy($indice);
			}
			# Ordenar por columna (el valor) en orden ascendente.
			else
			{
				$consulta->orderBy($valor);
			}
		}
		
		# Devolver la consulta.
		return $consulta;
	}
	
	/**
	 * Convierte una lista de valores en una cadena de texto
	 * única.
	 *
	 * @param array $valores Lista de valores a procesar.
	 *
	 * @return string Cadena generada.
	 */
	protected final function getHash(array $valores)
	{
		$resultadoHexa = '';
		
		# Para cada valor de la lista...
		foreach ($valores as $valor)
		{
			# Si es un número entonces...
			if (is_numeric($valor))
			{
				# Convertir el valor numérico en hexadecimal.
				$valorHexa = base_convert($valor, 10, 16);
			}
			# Si es una fecha/hora entonces...
			else if (preg_match('/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}( [0-2][0-9]:[0-5][0-9]:[0-5][0-9](\.[0-9]+)?)?$/', $valor) > 0)
			{
				# Convertirlo desde su marca de tiempo UNIX.
				$valorHexa = base_convert(strtotime($valor), 10, 16);
			}
			# Si es una cadena HASH entonces...
			else if (preg_match('/^[a-zA-Z0-9\!\$]+$/', $valor) > 0)
			{
				# Revertirla a su valor original en hexadecimal.
				$valor = str_replace(['!', '$'], ['+', '/'], $valor);
				$valorLongitud = strlen($valor);
				$valorMod = $valorLongitud % 4;
				if ($valorMod > 0) $valor = str_pad($valor, $valorLongitud - $valorMod + 4, '=', STR_PAD_RIGHT);
				$valorHexa = bin2hex(base64_decode($valor));
			}
			# En caso contrario...
			else
			{
				# Convertirlo a hexadecimal directo.
				$valorHexa = bin2hex($valor);
			}
			
			# Si la longitud no es par, agregarle un cero al principio.
			if (strlen($valorHexa) % 2 > 0) $valorHexa = '0' . $valorHexa;
			
			# Añadir el valor hexadecimal a resultado final.
			$resultadoHexa .= $valorHexa;
		}
		
		# Calcular el hash, convirtiendo el hexadecimal a binario y luego a base64.
		$hash = base64_encode(hex2bin($resultadoHexa));
		
		# Devolver el hash final, reemplazando caractéres finales y de relleno.
		return str_replace(['+', '/', '='], ['!', '$', ''], $hash);
	}
}