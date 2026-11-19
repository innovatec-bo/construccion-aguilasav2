<?php

namespace App\Warehouse;

use RuntimeException;

/**
 * El movimiento incumple alguna regla de negocio. No se guardo nada.
 */
final class MovementRejectedException extends RuntimeException
{
	/** @var array<int,array{field:string,message:string,lines:int[]}> */
	private array $errors;

	/**
	 * @param array<int,array{field:string,message:string,lines:int[]}> $errors
	 */
	public function __construct(array $errors)
	{
		parent::__construct($errors[0]['message'] ?? 'Movimiento rechazado.');
		$this->errors = $errors;
	}

	/**
	 * @return array<int,array{field:string,message:string,lines:int[]}>
	 */
	public function errors(): array
	{
		return $this->errors;
	}
}