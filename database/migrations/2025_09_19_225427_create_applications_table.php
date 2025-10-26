<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void {
        Schema::create('applications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('offer_id')->constrained('offers')->cascadeOnDelete();
            $t->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $t->text('message')->nullable();
            $t->enum('status',['pending','accepted','rejected'])->default('pending');
            $t->timestamp('accepted_at')->nullable();
            $t->timestamps();
            $t->unique(['offer_id','employee_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('applications'); }

};
