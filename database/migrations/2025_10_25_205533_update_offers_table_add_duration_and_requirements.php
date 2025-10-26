<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('offers', function (Blueprint $table) {
            $table->text('requirements')->nullable()->after('description');
            $table->string('duration_unit', 20)->nullable()->after('requirements');
            $table->integer('duration_quantity')->nullable()->after('duration_unit');
        });
    }

    public function down(): void {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['requirements', 'duration_unit', 'duration_quantity']);
        });
    }
};
