<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identity_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Documentos e identificadores
            $table->string('dpi', 13)->unique();
            $table->string('dpi_front'); // Fotografía de DPI frontal
            $table->string('selfie'); // Selfie con DPI
            $table->string('voucher')->nullable(); // Comprobante (luz/agua/teléfono)

            // Estado del proceso de verificación
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            $table->text('rejection_reason')->nullable();

            // Control de expiración
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('identity_verifications');
    }
};
