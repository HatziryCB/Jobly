<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Nombres y apellidos separados
            $table->string('first_name');
            $table->string('last_name');

            // Autenticación
            $table->string('email')->unique();
            $table->string('password');

            // Teléfono y rol
            $table->string('phone', 8)->nullable()->after('email');
            $table->enum('role', ['employee', 'employer', 'admin'])->default('employee');

            // Verificación de email (opcional si usas Breeze con verificación)
            $table->timestamp('email_verified_at')->nullable();

            // Términos y condiciones
            $table->boolean('tos_accepted')->default(false);
            $table->timestamp('tos_accepted_at')->nullable();

            // Laravel default
            $table->rememberToken();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
