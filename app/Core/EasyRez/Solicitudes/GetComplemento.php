<?php
namespace App\Core\EasyRez\Solicitudes;

use App\Core\EasyRez\EasyRez;

/**
 * Class GetComplemento
 * @package App\Core\EasyRez\Solicitudes
 */
class GetComplemento extends EasyRez
{
	/**
	 * @param int    $complementoId
	 * @param string $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function ejecutar($complementoId, $idiomaId = 'es')
	{
		$temp = new self();
		$data = [
			'complemento_id' => (int)$complementoId
		];
		return $temp->get('complemento', $idiomaId, $data);
	}
	
	/**
	 * @param int      $complementoId
	 * @param string   $fechaEntrada
	 * @param int      $noches
	 * @param int|null $adultos
	 * @param int|null $ninos1
	 * @param int|null $ninos2
	 * @param int|null $ninos3
	 * @param int|null $unidades
	 * @param string   $idiomaId
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public static function cotizar($complementoId, $fechaEntrada, $noches, $adultos = null, $ninos1 = null, $ninos2 = null, $ninos3 = null, $unidades = null, $idiomaId = 'es')
	{
		$temp = new self();
		$data = [
			'complemento_id' => $complementoId,
			'fecha_entrada'  => $fechaEntrada,
			'noches'         => $noches
		];
		if ($adultos !== null): $data['adultos'] = (int) $adultos; endif;
		if ($ninos1 !== null): $data['ninos1'] = (int) $ninos1; endif;
		if ($ninos2 !== null): $data['ninos2'] = (int) $ninos2; endif;
		if ($ninos3 !== null): $data['ninos3'] = (int) $ninos3; endif;
		if ($unidades !== null): $data['unidades'] = (int) $unidades; endif;
		return $temp->get('complemento-cotizar', $idiomaId, $data);
	}
}