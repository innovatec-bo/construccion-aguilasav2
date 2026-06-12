<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleSyncApiController extends Controller
{
    /**
     * Diccionario de equivalencias selectivo.
     * Izquierda: Nombre del rol en CodeIgniter (sec_roles.rolename_rol)
     * Derecha: Nombre del rol en Spatie/Laravel (roles.name)
     */
    protected $allowedRolesMap = [
        'Super admin'          => 'Super admin',
        'Admin'                => 'Admin',
        'User'                 => 'User',
        'Proyectista'          => 'Proyectista',
        'Diseñador'            => 'Diseñador',
        'Responsable de Almac' => 'Responsable de Almac',
        'Fiscal'               => 'Fiscal',
        'Builder'              => 'Builder',
        'Responsable de const' => 'Responsable de const',
        'Admin contable'       => 'Admin contable',
        'Dibujante'            => 'Dibujante',
        'Estaqueador'          => 'Estaqueador',
        'Digitalizador'        => 'Digitalizador',
        'Fiscal de CRE'        => 'Fiscal de CRE',
        'Ecargado de proyecto' => 'Ecargado de proyecto', // Ojo: mantiene el tipeo de Serebo2
        'As built creator'     => 'As built creator',
        'Energizado y Poda'    => 'Energizado y Poda',
    ];

    public function syncUserRoles(Request $request)
    {
        // 1. Validar la estructura que viene de CodeIgniter
        $request->validate([
            'id_usr'     => 'required|integer',
            'serebo_roles' => 'array' // Array con los rolename_rol actuales del usuario en CI3
        ]);

        // 2. Buscar al usuario en Laravel usando su ID de la tabla original
        $user = User::find($request->id_usr);

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Usuario no encontrado en Serebo2.'
            ], 404);
        }

        // 3. Procesar los roles enviados desde CodeIgniter
        $sereboRolesEnviados = $request->input('serebo_roles', []);
        $rolesParaAsignar = [];

        foreach ($sereboRolesEnviados as $rolSerebo) {
            // Verificar si el rol de CI3 está aprobado para sincronizarse
            if (array_key_exists($rolSerebo, $this->allowedRolesMap)) {
                $rolesParaAsignar[] = $this->allowedRolesMap[$rolSerebo];
            }
        }

        // 4. Gestionar los roles que pertenecen EXCLUSIVAMENTE a Serebo2
        // Obtenemos los roles actuales que tiene el usuario en Spatie
        $rolesActualesEnSpatie = $user->getRoleNames()->toArray();
        
        // Identificar cuáles roles de Serebo2 NO forman parte del mapa de sincronización
        $rolesExclusivosSerebo2 = array_diff($rolesActualesEnSpatie, array_values($this->allowedRolesMap));

        // Fusionamos los roles que vienen aprobados de CI3 + los exclusivos que ya tenía en Laravel
        $rolesFinales = array_merge($rolesParaAsignar, $rolesExclusivosSerebo2);

        // 5. Sincronizar en la tabla de Spatie usando el método nativo
        // (Esto remueve los que ya no correspondan del entorno sincronizado y deja intactos los exclusivos)
        $user->syncRoles($rolesFinales);

        return response()->json([
            'status' => 'success',
            'message' => 'Roles sincronizados selectivamente de forma exitosa.',
            'roles_actuales_spatie' => $user->getRoleNames()
        ]);
    }
}