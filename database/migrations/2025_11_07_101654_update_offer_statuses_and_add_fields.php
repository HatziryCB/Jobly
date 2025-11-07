<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            // 🔹 Actualizamos el enum de estados con lo esencial para contratación
            $table->enum('status', [
                'draft',       // creada, sin publicar
                'open',        // publicada, recibiendo postulaciones
                'hired',       // empleador seleccionó candidato
                'accepted',    // ambas partes confirmaron
                'completed',   // trabajo terminado
                'closed'       // cerrada definitiva o cancelada
            ])->default('open')->change();

            // 🔹 Campos adicionales mínimos para control
            if (!Schema::hasColumn('offers', 'hired_employee_id')) {
                $table->foreignId('hired_employee_id')->nullable()->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('offers', 'employer_confirmed')) {
                $table->boolean('employer_confirmed')->default(false);
            }

            if (!Schema::hasColumn('offers', 'employee_confirmed')) {
                $table->boolean('employee_confirmed')->default(false);
            }

            if (!Schema::hasColumn('offers', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            // 🔹 Revertir los nuevos campos y el enum al estado anterior
            $table->dropColumn(['hired_employee_id', 'employer_confirmed', 'employee_confirmed', 'completed_at']);
            $table->enum('status', ['draft', 'open', 'hired', 'closed'])->default('open')->change();
        });
    }
};
