<?php namespace App\Repositories\Eloquent;

use App\Models\Modelo;
use Illuminate\Database\Eloquent\Collection;

/**
 * Métodos de un repositorio.
 *
 * @package App\Repositories\Eloquent
 */
interface IRepositorio
{
	/**
	 * Devuelve todos los objetos del tipo del modelo encontrados.
	 *
	 * @param string[] $columnas (Opcional) Lista de columnas a recuperar.
	 * @param string[] $ordenarPor (Opcional) Lista de columnas para ordenar los resultados ascendentemente.
	 *
	 * @return Collection
	 *
	 * @throws \Exception
	 */
	public function listar(array $columnas = [], array $ordenarPor = []);
	
	/**
	 * Devuelve los objetos del tipo del modelo, que cumplan
	 * con los criterios de búsqueda especificados.
	 *
	 * @param array $criterios Lista de columnas para filtrar resultados como diccionario clave/valor.
	 * @param string[] $columnas (Opcional) Lista de atributos a recuperar.
	 * @param string[] $ordenarPor (Opcional) Lista de atributos para ordenar los resultados ascendentemente.
	 *
	 * @return Collection
	 *
	 * @throws \Exception
	 */
	public function listarPor(array $criterios, array $columnas = [], array $ordenarPor = []);
	
	/**
	 * Devuelve un objeto del tipo del modelo buscandolo por su ID.
	 *
	 * @param int|string|array $id ID del objeto. Puede ser un arreglo de valores si la llave primaria es compuesta.
	 * @param string[] $columnas (Opcional) Lista de atributos a recuperar.
	 *
	 * @return Modelo
	 *
	 * @throws \Exception
	 */
	public function buscar($id, array $columnas = []);
	
	/**
	 * Devuelve un objeto del tipo del modelo buscándolo por una lista de criterios.
	 *
	 * @param array $criterios Lista de columnas para filtrar resultados como diccionario clave/valor.
	 * @param string[] $columnas (Opcional) Lista de columnas.
	 *
	 * @return Modelo
	 *
	 * @throws \Exception
	 */
	public function buscarPor(array $criterios, array $columnas = []);
	
	/**
	 * Crea un nuevo objeto del tipo del modelo.
	 *
	 * @param array $datos Conjunto de datos para el objeto.
	 *
	 * @return Modelo Objeto nuevo creado con el ID generado por la base de datos.
	 *
	 * @throws \Exception
	 */
	public function crear(array $datos);
	
	/**
	 * Actualiza los valores de un objeto del modelo, buscandolo por su ID.
	 *
	 * @param array $datos Conjuto de datos actualizados para el objeto.
	 * @param int|string|array $id ID del objeto a actualizar dentro de la propiedad, puede ser un arreglo de valores.
	 *
	 * @return Modelo
	 *
	 * @throws \Exception
	 */
	public function actualizar(array $datos, $id);
	
	/**
	 * Actualiza los valores de un objeto del modelo, buscandolo por una lista de criterios.
	 *
     * @param array $datos Conjuto de datos actualizados para el objeto.
	 * @param array $criterios Lista de columnas para filtrar resultados como diccionario clave/valor.
	 *
	 * @return Modelo
	 *
	 * @throws \Exception
	 */
	public function actualizarPor(array $datos, array $criterios);
	
	/**
	 * Elimina un objeto del tipo del modelo, buscandolo por su ID.
	 *
	 * @param int|string $id ID del objeto dentro de la propiedad actual.
	 *
	 * @return Modelo Objeto eliminado.
	 *
	 * @throws \Exception
	 */
	public function eliminar($id);
	
	/**
	 * Elimina un objeto del tipo del modelo, buscandolo por una lista de criterios.
	 *
	 * @param array $criterios Lista de columnas para filtrar resultados como diccionario clave/valor.
	 *
	 * @return Modelo Objeto eliminado.
	 *
	 * @throws \Exception
	 */
	public function eliminarPor(array $criterios);
}