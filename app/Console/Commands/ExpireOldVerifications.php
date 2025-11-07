<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\IdentityVerification;

class ExpireOldVerifications extends Command
{
    protected $signature = 'verifications:expire';


    protected $description = 'Marca como expiradas las solicitudes de verificación con más de 5 días en estado pendiente.';


    public function handle()
    {
        $expired = IdentityVerification::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);

        if ($expired > 0) {
            $this->info("✅ Se marcaron {$expired} solicitudes como expiradas.");
        } else {
            $this->info("No hay solicitudes pendientes vencidas.");
        }

        return Command::SUCCESS;
    }
}
