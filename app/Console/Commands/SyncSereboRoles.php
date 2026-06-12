<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SyncSereboRoles extends Command
{
    /**
     * El nombre y firma del comando en la consola.
     */
    protected $signature = 'serebo:sync-roles';

    /**
     * La descripción del comando.
     */
    protected $description = 'Sincroniza masivamente los roles de los usuarios desde las tablas sec_ de Serebo (CI3)';

    /**
     * Diccionario de equivalencias selectivo que ya definimos.
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
        'Ecargado de proyecto' => 'Ecargado de proyecto', // Mantiene el tipeo de Serebo2
        'As built creator'     => 'As built creator',
        'Energizado y Poda'    => 'Energizado y Poda',
    ];

    public function handle()
    {
        $this->info('Iniciando la sincronización masiva de roles...');

        // 1. Consultar directamente las tablas sec_ usando el Query Builder de Laravel
        // Agrupamos por usuario utilizando la potencia de MySQL
        $sereboUsuarios = DB::table('sec_userroles as ur')
            ->join('sec_roles as r', 'r.id_rol', '=', 'ur.roleid_uro')
            ->select('ur.userid_uro as id_usr', DB::raw("GROUP_CONCAT(r.rolename_rol SEPARATOR '||') as roles_concatenados"))
            ->groupBy('ur.userid_uro')
            ->get();

        $total = $sereboUsuarios->count();
        
        if ($total === 0) {
            $this->warn('No se encontraron usuarios con roles asignados en las tablas de Serebo.');
            return Command::SUCCESS;
        }

        // Crear una barra de progreso visual en la consola
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $usuariosNoEncontrados = 0;

        foreach ($sereboUsuarios as $sUsuario) {
            // Buscar al usuario en Laravel 11 usando su ID original
            $user = User::find($sUsuario->id_usr);

            if (!$user) {
                $usuariosNoEncontrados++;
                $bar->advance();
                continue;
            }

            // Separar el string concatenado en un array de roles de CI3
            $rolesSerebo = $sUsuario->roles_concatenados ? explode('||', $sUsuario->roles_concatenados) : [];
            $rolesParaAsignar = [];

            // Filtrar y mapear según el diccionario selectivo
            foreach ($rolesSerebo as $rolSerebo) {
                if (array_key_exists($rolSerebo, $this->allowedRolesMap)) {
                    $rolesParaAsignar[] = $this->allowedRolesMap[$rolSerebo];
                }
            }

            // Conservar los roles exclusivos que el usuario tenga creados ÚNICAMENTE en Serebo2
            $rolesActualesEnSpatie = $user->getRoleNames()->toArray();
            $rolesExclusivosSerebo2 = array_diff($rolesActualesEnSpatie, array_values($this->allowedRolesMap));
            
            // Unificar e impactar mediante Spatie
            $rolesFinales = array_merge($rolesParaAsignar, $rolesExclusivosSerebo2);
            $user->syncRoles($rolesFinales);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Resumen final del proceso
        $this->table(
            ['Resultado', 'Cantidad'],
            [
                ['Usuarios procesados exitosamente', $total - $usuariosNoEncontrados],
                ['Usuarios omitidos (No existen en Serebo2)', $usuariosNoEncontrados],
                ['Total evaluado', $total]
            ]
        );

        $this->info('¡Proceso de sincronización finalizado con éxito!');
        return Command::SUCCESS;
    }
}