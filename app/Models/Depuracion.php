<?php namespace App\Models;

class Depuracion extends Modelo
{
	/**
	 * Tabla asociada con el modelo.
	 *
	 * @var string
	 */
	protected $table = 'auditoria.depuracion';
	
	/**
	 * Nombre de la columna de llave primaria.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';
	
	/**
	 * Indica si la llave primaria del modelo es auto-incremental
	 * o nó.
	 *
	 * @var bool
	 */
	public $incrementing = false;
	
	/**
	 * Indica si se usarán los atributos de
	 * fecha y hora de creación, modificación y eliminación.
	 *
	 * @var bool
	 */
	public $timestamps = false;
	
	/**
	 * Atributos rellenables en creación masiva.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'tipo',
		'origen',
		'codigo',
		'mensaje',
		'archivo',
		'linea',
		'pila'
	];
	
	/**
	 * Atributos no permitidos en creación masiva
	 *
	 * @var array
	 */
	protected $guarded = [
		'id'
	];
	
	/**
	 * Atributos ocultos en las respuestas.
	 *
	 * @var array
	 */
	protected $hidden = [
	];
	
	/**
	 * Atributos a convertir a otro tipo.
	 *
	 * @var array
	 */
	protected $casts = [
	];
	
	/**
	 * Atributos adicionales para el modelo.
	 * Es necesario definir la función del nuevo atributo
	 *
	 * @var array
	 */
	protected $appends = [
	];
}