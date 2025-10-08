<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('offers', function (Blueprint $t) {
            $t->id();
            $t->foreignId('employer_id')->constrained('users')->cascadeOnDelete(); // dueño (empleador)
            $t->string('title',120);
            $t->text('description');
            $t->string('location_text',120)->nullable();
            $t->unsignedInteger('pay_min')->nullable();
            $t->unsignedInteger('pay_max')->nullable();
            $t->enum('status',['draft','open','hired','closed'])->default('open');
            $t->decimal('lat',9,6)->nullable();
            $t->decimal('lng',9,6)->nullable();
            $t->timestamps();

            $t->index(['employer_id','status']);
            $t->index('created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('offers'); }

};
