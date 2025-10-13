<?php

namespace App\Console\Commands;

use App\Models\ClassInformation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanExpiredClassInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'class-information:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove automaticamente avisos expirados das turmas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCount = ClassInformation::expired()->count();
        
        if ($expiredCount > 0) {
            $deleted = ClassInformation::expired()->delete();
            
            $this->info("{$deleted} avisos expirados foram removidos.");
            Log::info("Limpeza automática: {$deleted} avisos expirados removidos.");
        } else {
            $this->info('Nenhum aviso expirado encontrado.');
        }
    }
}