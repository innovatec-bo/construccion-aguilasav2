<?php

namespace App\Console\Commands;

use App\Services\ProjectImportService;
use Illuminate\Console\Command;
use Throwable;

class TestProjectImport extends Command
{
    /**
     * El nombre y firma del comando en consola.
     * Permite pasar un código opcional o la opción --all para procesar los 14 solicitados.
     */
    protected $signature = 'app:import-project 
                            {code? : Código de proyecto de Serebo (ej: RG.26.0108)}
                            {--all : Importar automáticamente la lista completa enviada por Gilberto}';

    protected $description = 'Importa uno o varios proyectos desde Serebo hacia Águila vía API';

    /**
     * Lista de los 14 proyectos solicitados formalmente por Gilberto Molina.
     */
    protected array $priorityProjects = [
        'RG.26.0108', 'RG.26.0121', 'RG.26.0148',
        'RO.25.0375', 'RO.25.0394', 'RO.25.0449', 'RO.26.0006',
        'RO.26.0035', 'RO.26.0049', 'RO.26.0114', 'RO.26.0164',
        'RV.26.0010', 'RV.26.0043', 'RV.26.0154',
    ];

    public function handle(ProjectImportService $service): int
    {
        $code = $this->argument('code');
        $importAll = $this->option('all');

        if (!$code && !$importAll) {
            $this->error('Debes proporcionar un código de proyecto (ej: RG.26.0108) o usar la bandera --all.');
            return 1;
        }

        $projectsToProcess = $importAll ? $this->priorityProjects : [$code];

        $this->info("Iniciando proceso de importación (" . count($projectsToProcess) . " proyecto/s)...");
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        foreach ($projectsToProcess as $projectCode) {
            $this->line("<comment>Procesando [{$projectCode}]...</comment>");

            try {
                $result = $service->importByCode($projectCode);

                $this->info("  ✔ Importado con éxito: {$result['code']} - {$result['name']} (ID: {$result['id_pro']})");
                $successCount++;
            } catch (Throwable $e) {
                $this->error("  ✖ Falló [{$projectCode}]: " . $e->getMessage());
                $failCount++;
            }

            $this->newLine();
        }

        $this->table(
            ['Total', 'Exitosos', 'Fallidos'],
            [[count($projectsToProcess), $successCount, $failCount]]
        );

        return $failCount === 0 ? 0 : 1;
    }
}