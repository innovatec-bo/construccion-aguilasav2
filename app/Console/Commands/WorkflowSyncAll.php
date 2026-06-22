<?php

namespace App\Console\Commands;

use App\CustomLibraries\WorkflowPaginationHandler;
use App\Models\Workflow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WorkflowSyncAll extends Command
{
    protected $signature   = 'workflow:sync-all
                                {--ids=      : Lista de IDs separados por coma (opcional, para sincronizar proyectos específicos)}';

    protected $description = 'Sincroniza la tabla workflows recalculando todos los proyectos desde wfl_projects.';

    public function handle() : int
    {
        $idsRaw = $this->option('ids');

        $this->newLine();
        $this->info('╔══════════════════════════════════════════╗');
        $this->info('║        WORKFLOW SYNC — Serebo2           ║');
        $this->info('╚══════════════════════════════════════════╝');
        $this->newLine();

        // ── 1. Contar total de proyectos ──────────────────────────────────
        $this->line('⏳ Contando proyectos...');

        $handler = new WorkflowPaginationHandler(1, 0);

        if ($idsRaw)
        {
            $ids = implode("\n", array_map('trim', explode(',', $idsRaw)));
            $handler->setAdditionalParameters(['id-list' => $ids]);
            $this->line("   Modo: IDs específicos → <comment>{$idsRaw}</comment>");
        }
        else
        {
            $this->line('   Modo: <comment>todos los proyectos</comment>');
        }

        $total = $handler->countAll();

        if ($total === 0)
        {
            $this->warn('⚠️  No se encontraron proyectos. Verificá los filtros.');
            return self::FAILURE;
        }

        $this->info("   Total de proyectos encontrados: <comment>{$total}</comment>");
        $this->newLine();

        // ── 2. Confirmar si es sync total ─────────────────────────────────
        if (!$idsRaw)
        {
            if (!$this->confirm("¿Confirmas la sincronización de {$total} proyectos? Esto sobreescribirá los datos existentes.", true))
            {
                $this->warn('Operación cancelada.');
                return self::FAILURE;
            }
            $this->newLine();
        }

        // ── 3. Una sola query para traer todos los proyectos ─────────────
        $processed = 0;
        $errors    = 0;
        $startTime = now();

        $this->line("🔍 Ejecutando query principal...");
        $this->newLine();

        try
        {
            $fetchHandler = new WorkflowPaginationHandler($total, 0);
            if ($idsRaw)
            {
                $fetchHandler->setAdditionalParameters(['id-list' => $ids]);
            }
            $allProjects = $fetchHandler->getAll();
        }
        catch (\Throwable $e)
        {
            $this->error("❌ Error al ejecutar la query principal: " . $e->getMessage());
            return self::FAILURE;
        }

        $fetched = count($allProjects);

        $this->info("   Proyectos obtenidos: <comment>{$fetched}</comment>");
        $this->line("📦 Guardando registro por registro...");
        $this->newLine();

        // ── 4. updateOrCreate registro por registro ───────────────────────
        $bar = $this->output->createProgressBar($fetched);
        $bar->setFormat(" %current%/%max% [%bar%] %percent:3s%%\n");
        $bar->start();

        foreach ($allProjects as $project)
        {
            try
            {
                $data = (array) $project;

                // Calcular chunk seguro según límite de placeholders de MySQL
                // (solo aplica si en algún momento se vuelve a usar upsert)
                Workflow::updateOrCreate(
                    ['id_pro' => $data['id_pro']],
                    $data
                );
                $processed++;
            }
            catch (\Throwable $e)
            {
                $errors++;
                $this->newLine();
                $this->error("   ❌ Error en proyecto id_pro={$project->id_pro}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // ── 5. Resumen final ──────────────────────────────────────────────
        $elapsed = $startTime->diffForHumans(now(), true);
        $missing = $total - $fetched;

        $this->info('╔══════════════════════════════════════════╗');
        $this->info('║              RESUMEN FINAL               ║');
        $this->info('╚══════════════════════════════════════════╝');
        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total encontrados',   $total],
                ['Proyectos obtenidos', $fetched],
                ['Procesados',          $processed],
                ['No obtenidos',        $missing],
                ['Errores',             $errors],
                ['Tiempo transcurrido', $elapsed],
            ]
        );

        // ── 6. Detectar proyectos no procesados ───────────────────────────
        if ($missing > 0)
        {
            $this->newLine();
            $this->warn("⚠️  {$missing} proyecto(s) no fueron obtenidos por el handler.");
            $this->line('🔍 Identificando proyectos faltantes...');

            // IDs que sí llegaron al handler
            $fetchedIds = array_map(fn($p) => $p->id_pro, $allProjects);

            // IDs en wfl_projects que no llegaron al resultado del handler
            $missingProjects = DB::table('wfl_projects')
                ->select('id_pro', 'code_pro', 'detail_pro', 'status_pro')
                ->where('deleted_pro', '!=', 1)
                ->whereNotIn('id_pro', $fetchedIds)
                ->get();

            if ($missingProjects->isEmpty())
            {
                $this->info('   ℹ️  No se encontraron proyectos faltantes en wfl_projects (puede ser diferencia de timing).');
            }
            else
            {
                $this->newLine();
                $this->warn("   Proyectos en wfl_projects NO procesados ({$missingProjects->count()}):");
                $this->table(
                    ['id_pro', 'code_pro', 'status_pro', 'detail_pro'],
                    $missingProjects->map(fn($p) => [
                        $p->id_pro,
                        $p->code_pro,
                        $p->status_pro,
                        mb_substr($p->detail_pro ?? '', 0, 50),
                    ])->toArray()
                );

                // Guardar IDs en archivo para referencia y reintento fácil
                $missingIds = $missingProjects->pluck('id_pro')->implode(',');
                $logPath    = storage_path('logs/workflow_missing_' . now()->format('Ymd_His') . '.txt');
                file_put_contents($logPath, $missingIds);

                $this->newLine();
                $this->line("   💾 IDs guardados en: <comment>{$logPath}</comment>");
                $this->line("   🔄 Para reintentarlos:");
                $this->line("      <comment>php artisan workflow:sync-all --ids={$missingIds}</comment>");
            }
        }

        if ($errors > 0)
        {
            $this->newLine();
            $this->warn("⚠️  Completado con {$errors} error(es). Revisá los logs para más detalle.");
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('✅  Sincronización completada exitosamente.');
        $this->newLine();

        return self::SUCCESS;
    }
}