<?php

namespace App\Core\EasyRez;

use Exception;

/**
 * Class EasyRezApp
 *
 * @package App\Core\EasyRez
 */
class EasyRezApp
{
	/**
	 */
	protected $id;
	
	/**
	 */
	protected $key;

	/**
	 */
	protected $refer;
	
	/**
	 * @param string $id
	 * @param string $key
	 *
	 * @throws Exception
	 */
	public function __construct($id, $key, $refer)
	{
		if (!is_string($id) && !is_int($id)):
			throw new Exception('El "app_id" no tiene el formato correcto');
		endif;
		$this->id = (string) $id;
		$this->key = $key;
		$this->refer = (string) $refer;
	}
	
	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @return string
	 */
	public function getRefer()
	{
		return $this->refer;
	}
}