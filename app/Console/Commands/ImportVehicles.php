<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImportService;

class ImportVehicles extends Command
{
    protected $signature = 'vehicles:import';
    protected $description = 'Import vehicles from external sources';

    protected $importService;

    public function __construct(ImportService $importService)
    {
        parent::__construct();
        $this->importService = $importService;
    }

    public function handle()
    {
        $this->info('Starting import...');
        $this->importService->importWebMotors();
        $this->importService->importRevendaMais();
        $this->info('Import completed successfully.');
    }
}
