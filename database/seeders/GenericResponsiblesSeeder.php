<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GenericResponsiblesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Catálogo de usuarios genéricos solicitados
        // Se definen palabras clave ('status_keywords') de wfl_project_status a las que suelen pertenecer
        $generics = [
            [
                'first_name' => 'Diseñador',
                'last_name'  => 'Genérico',
                'email'      => 'diseniador.generico@aguilasa.com',
                'keywords'   => ['design', 'diseno', 'schedule', 'programacion', 'rectify_design'],
            ],
            [
                'first_name' => 'Estaqueador',
                'last_name'  => 'Genérico',
                'email'      => 'estaqueador.generico@aguilasa.com',
                'keywords'   => ['stake', 'estaca', 'estacado'],
            ],
            [
                'first_name' => 'Digitalizador',
                'last_name'  => 'Genérico',
                'email'      => 'digitalizador.generico@aguilasa.com',
                'keywords'   => ['digitization', 'digitalizacion', 'drawing'],
            ],
            [
                'first_name' => 'Constructor',
                'last_name'  => 'Genérico',
                'email'      => 'constructor.generico@aguilasa.com',
                'keywords'   => ['construction', 'construccion', 'in_progress', 'builder'],
            ],
            [
                'first_name' => 'Fiscal',
                'last_name'  => 'Genérico',
                'email'      => 'fiscal.generico@aguilasa.com',
                'keywords'   => ['fiscal', 'fiscalizacion', 'supervision'],
            ],
            [
                'first_name' => 'Fiscal CRE',
                'last_name'  => 'Genérico',
                'email'      => 'fiscal.cre.generico@aguilasa.com',
                'keywords'   => ['cre', 'cre_fiscal', 'fiscal_cre', 'approval_cre'],
            ],
            [
                'first_name' => 'Encargado de Proyecto',
                'last_name'  => 'Genérico',
                'email'      => 'encargado.generico@aguilasa.com',
                'keywords'   => ['manager', 'project_manager', 'assign_to', 'completed'],
            ],
        ];

        $now = now();
        $defaultPassword = Hash::make('Aguila2026!');

        foreach ($generics as $gen) {
            // A. Insertar o recuperar de sec_users
            $user = DB::table('sec_users')->where('email', $gen['email'])->first();

            if (!$user) {
                $userId = DB::table('sec_users')->insertGetId([
                    'firstname_usr' => $gen['first_name'],
                    'lastname_usr'  => $gen['last_name'],
                    'email_usr'     => $gen['email'],
                    'first_name'    => $gen['first_name'],
                    'last_name'     => $gen['last_name'],
                    'email'         => $gen['email'],
                    'password'      => $defaultPassword,
                    'status_usr'    => 1,
                    'deleted_usr'   => 0,
                    'createdon_usr' => $now,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            } else {
                $userId = $user->id_usr;
            }

            // B. Asociar a wfl_status_responsibles buscando estados por keyword o nombre
            $query = DB::table('wfl_project_status')->where('deleted_pst', 0);

            $query->where(function ($q) use ($gen) {
                foreach ($gen['keywords'] as $kw) {
                    $q->orWhere('keyword_pst', 'LIKE', "%{$kw}%")
                      ->orWhere('status_name_pst', 'LIKE', "%{$kw}%");
                }
            });

            $matchingStatuses = $query->get(['id_pst']);

            foreach ($matchingStatuses as $status) {
                $exists = DB::table('wfl_status_responsibles')
                    ->where('user_id_sre', $userId)
                    ->where('status_id_sre', $status->id_pst)
                    ->exists();

                if (!$exists) {
                    DB::table('wfl_status_responsibles')->insert([
                        'user_id_sre'   => $userId,
                        'status_id_sre' => $status->id_pst,
                        'active_sre'    => 1,
                        'deleted_sre'   => 0,
                        'createdon_sre' => $now,
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ]);
                }
            }
        }

        // C. Garantizar que ningún estado de wfl_project_status quede sin responsable asignado
        // Si algún estado no coincidió con ninguna palabra clave, se asigna al "Encargado de Proyecto Genérico"
        $fallbackUser = DB::table('sec_users')->where('email', 'encargado.generico@aguilasa.com')->first();
        
        if ($fallbackUser) {
            $unassignedStatuses = DB::table('wfl_project_status as s')
                ->leftJoin('wfl_status_responsibles as r', function ($join) {
                    $join->on('s.id_pst', '=', 'r.status_id_sre')
                         ->where('r.deleted_sre', '=', 0);
                })
                ->whereNull('r.id_sre')
                ->where('s.deleted_pst', 0)
                ->pluck('s.id_pst');

            foreach ($unassignedStatuses as $statusId) {
                DB::table('wfl_status_responsibles')->insert([
                    'user_id_sre'   => $fallbackUser->id_usr,
                    'status_id_sre' => $statusId,
                    'active_sre'    => 1,
                    'deleted_sre'   => 0,
                    'createdon_sre' => $now,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            }
        }
    }
}