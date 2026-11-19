<?php

namespace App\Warehouse;

/**
 * Configuracion de los tipos de movimiento habilitados en el formulario de Serebo2.
 * IDs = mat_materials_summary_types.id_mqt. Reemplaza los arrays que en Serebo estaban repetidos en el
 * controlador ([4,10,11,14,15,17,18], [2,3,8]), en WarehouseHandler.ts y en las vistas.
 *
 * Etapa 1: registrar movimiento (3, 4, 8, 17, 18) y solicitar (14, 15).
 * Pendientes para etapas siguientes: 2 y 16 (adicionales), 9 y 19. El 13 no tiene logica definida.
 */
final class MovementType
{
	public const PICKED_UP_FROM_CRE = 3;
	public const DELIVERED_TO_BUILDER = 4;
	public const DELIVERED_TO_CRE = 8;
	public const REQUEST_MATERIALS = 14;
	public const REQUEST_LOAN = 15;
	public const DELIVERED_TO_BUILDER_LOAN = 17;
	public const BUILDER_RETURNS = 18;

	public const ENABLED = [
		self::PICKED_UP_FROM_CRE,
		self::DELIVERED_TO_BUILDER,
		self::DELIVERED_TO_CRE,
		self::REQUEST_MATERIALS,
		self::REQUEST_LOAN,
		self::DELIVERED_TO_BUILDER_LOAN,
		self::BUILDER_RETURNS,
	];

	/** Tipos que piden fiscal y constructor. */
	private const WITH_BUILDER_AND_FISCAL = [
		self::DELIVERED_TO_BUILDER,
		self::REQUEST_MATERIALS,
		self::REQUEST_LOAN,
		self::DELIVERED_TO_BUILDER_LOAN,
		self::BUILDER_RETURNS,
	];

	/** Tipos que piden numero de reserva (en Serebo: el selector solo se muestra para 3 y 8). */
	private const WITH_RESERVATION = [
		self::PICKED_UP_FROM_CRE,
		self::DELIVERED_TO_CRE,
	];

	/** Entrega que se crea a partir de cada solicitud (parent_summary_id). */
	private const DELIVERY_OF_REQUEST = [
		self::REQUEST_MATERIALS => self::DELIVERED_TO_BUILDER,
		self::REQUEST_LOAN => self::DELIVERED_TO_BUILDER_LOAN,
	];

	/** Estados de proyecto (wfl_project_status.keyword_pst) en los que se puede registrar el movimiento. */
	private const PROJECT_STATUSES_ALL = [
		'approved', 'assign_to', 'in_progress', 'stopped', 'paused', 'completed', 'as_built',
		'conciliation_reception', 'conciliation_shipment', 'cre_return_order', 'project_return_materials', 'project_energized',
	];

	/** Las solicitudes (14, 15) solo se hacen mientras el proyecto esta en obra o recien aprobado. */
	private const PROJECT_STATUSES_REQUESTS = [
		'approved', 'assign_to', 'in_progress', 'stopped', 'paused', 'completed',
	];

	/** @return string[] */
	public static function projectStatusKeywords(int $typeId): array
	{
		return in_array($typeId, [self::REQUEST_MATERIALS, self::REQUEST_LOAN], true)
			? self::PROJECT_STATUSES_REQUESTS
			: self::PROJECT_STATUSES_ALL;
	}

	public static function isEnabled(int $typeId): bool
	{
		return in_array($typeId, self::ENABLED, true);
	}

	public static function requiresBuilderAndFiscal(int $typeId): bool
	{
		return in_array($typeId, self::WITH_BUILDER_AND_FISCAL, true);
	}

	public static function requiresReservation(int $typeId): bool
	{
		return in_array($typeId, self::WITH_RESERVATION, true);
	}

	/** Tipo de solicitud que respalda a una entrega (4 <- 14, 17 <- 15), o null si no admite solicitud. */
	public static function requestTypeFor(int $deliveryTypeId): ?int
	{
		$map = array_flip(self::DELIVERY_OF_REQUEST);
		return $map[$deliveryTypeId] ?? null;
	}
}