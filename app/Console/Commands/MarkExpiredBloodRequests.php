<?php

namespace App\Console\Commands;

use App\Models\BloodRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkExpiredBloodRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blood-requests:mark-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca automáticamente las solicitudes de sangre como expiradas cuando han pasado su fecha límite';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Buscando solicitudes expiradas...');

        $expiredCount = BloodRequest::markExpiredRequests();

        if ($expiredCount > 0) {
            $this->info("✅ Se marcaron {$expiredCount} solicitudes como expiradas.");

            Log::info("Comando mark-expired ejecutado: {$expiredCount} solicitudes marcadas como expiradas", [
                'command' => 'blood-requests:mark-expired',
                'expired_count' => $expiredCount,
                'executed_at' => now()
            ]);
        } else {
            $this->info('ℹ️  No se encontraron solicitudes para marcar como expiradas.');
        }

        // Mostrar estadísticas actuales
        $stats = [
            'active' => BloodRequest::active()->count(),
            'completed' => BloodRequest::completed()->count(),
            'cancelled' => BloodRequest::cancelled()->count(),
            'expired' => BloodRequest::expired()->count(),
        ];

        $this->info('📊 Estadísticas actuales:');
        $this->table(
            ['Estado', 'Cantidad'],
            [
                ['Activas', $stats['active']],
                ['Completadas', $stats['completed']],
                ['Canceladas', $stats['cancelled']],
                ['Expiradas', $stats['expired']],
            ]
        );

        return Command::SUCCESS;
    }
}