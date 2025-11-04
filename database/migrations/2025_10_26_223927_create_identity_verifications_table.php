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

            // Datos personales capturados desde información de usuario
            $table->string('first_name');
            $table->string('second_name')->nullable();
            $table->string('last_name');
            $table->string('second_last_name')->nullable();
            $table->string('dpi', 13)->unique();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('department')->nullable();
            $table->string('municipality')->nullable();

            // Archivos de verificación
            $table->string('dpi_front')->nullable();       // Imagen DPI frontal
            $table->string('dpi_back')->nullable();        // Imagen DPI trasera
            $table->string('selfie')->nullable(); // Foto selfie
            $table->string('voucher')->nullable();// Comprobante (agua/luz/etc.)

            // Estado
            $table->enum('status', ['pending', 'approved', 'rejected','expired'])->default('pending');
            $table->text('rejection_reason')->nullable();

            // Control
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('identity_verifications');
    }
};
