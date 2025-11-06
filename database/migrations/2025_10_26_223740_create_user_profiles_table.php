<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('profile_picture')->nullable();
            $table->enum('verification_status', ['none', 'pending', 'verified', 'rejected'])->default('none');
            $table->float('average_rating', 3, 2)->default(0.0);
            $table->json('work_categories')->nullable();
            $table->text('bio')->nullable();
            $table->text('experience')->nullable();

            $table->string('department',30)->nullable();
            $table->string('municipality',30)->nullable();
            $table->string('zone',10)->nullable();
            $table->string('neighborhood',100)->nullable(); //Aldea, barrio, colonia


            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->default('female');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
