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

            // Nombres y apellidos
            $table->string('first_name');
            $table->string('second_name')->nullable(); // Nuevo
            $table->string('last_name');
            $table->string('second_last_name')->nullable(); // Nuevo

            $table->string('email')->unique();
            $table->string('password');

            $table->string('phone', 8)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('tos_accepted')->default(false);
            $table->timestamp('tos_accepted_at')->nullable();

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
