<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Settings\StatusManagementSettings;
use App\Settings\SystemSettings;
use Illuminate\Http\JsonResponse;

class SettingsApiController extends Controller
{
    /**
     * Obtener todas las configuraciones consolidadas del sistema.
     */
    public function index(
        SystemSettings $systemSettings,
        StatusManagementSettings $statusSettings
    ): JsonResponse {
        return response()->json([
            'response' => true,
            'message'  => 'Configuraciones recuperadas exitosamente.',
            'data'     => [
                'system'            => $this->formatSystemSettings($systemSettings),
                'status_management' => $this->formatStatusSettings($statusSettings),
            ],
        ], 200);
    }

    /**
     * Obtener únicamente las configuraciones visuales e identidad del sistema.
     */
    public function system(SystemSettings $systemSettings): JsonResponse
    {
        return response()->json([
            'response' => true,
            'message'  => 'Configuración de identidad visual del sistema recuperada.',
            'data'     => $this->formatSystemSettings($systemSettings),
        ], 200);
    }

    /**
     * Obtener únicamente las reglas de administración de estados.
     */
    public function statusManagement(StatusManagementSettings $statusSettings): JsonResponse
    {
        return response()->json([
            'response' => true,
            'message'  => 'Configuración de administración de estados recuperada.',
            'data'     => $this->formatStatusSettings($statusSettings),
        ], 200);
    }

    /**
     * Formateador auxiliar para las propiedades de SystemSettings.
     */
    private function formatSystemSettings(SystemSettings $settings): array
    {
        return [
            'app_logo_url'            => $settings->getAppLogoUrl(),
            'document_logo_url'       => $settings->getDocumentLogoUrl(),
            'document_logo_real_path' => $settings->getDocumentLogoRealPath(),
            'pin_marker_url'          => $settings->getPinMarkerUrl(),
            'favicon_url'             => $settings->getFaviconUrl(),
        ];
    }

    /**
     * Formateador auxiliar para las propiedades de StatusManagementSettings.
     */
    private function formatStatusSettings(StatusManagementSettings $settings): array
    {
        return [
            'enable_manual_approvement_for_conciliations' => (bool) $settings->enable_manual_approvement_for_conciliations,
            'no_pending_materials_in_cre_for_as_built'   => (bool) $settings->no_pending_materials_in_cre_for_as_built,
        ];
    }
}