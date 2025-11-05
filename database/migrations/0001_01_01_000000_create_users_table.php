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
            $table->string('first_name', 50);
            $table->string('second_name',50)->nullable();
            $table->string('last_name',50);
            $table->string('second_last_name',50)->nullable();

            $table->string('email',100)->unique();
            $table->string('password');

            $table->string('phone', 8)->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('tos_accepted')->default(false)->index();
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
