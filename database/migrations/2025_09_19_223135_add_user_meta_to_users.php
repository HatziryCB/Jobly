<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->string('phone',20)->nullable()->after('email');                   // Teléfono (opcional)
            $t->enum('role',['employee','employer','admin'])->default('employee')->after('phone'); // Rol
            $t->boolean('tos_accepted')->default(false)->after('role');           // Aceptó T&C
            $t->timestamp('tos_accepted_at')->nullable()->after('tos_accepted');  // Fecha aceptación
        });
    }
    public function down(): void {
        Schema::table('users', fn(Blueprint $t)=>$t->dropColumn(['phone','role','tos_accepted','tos_accepted_at']));
    }

};
