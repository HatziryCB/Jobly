<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->dropUnique('dpi');
        });
    }

    public function down()
    {
        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->unique('dpi');
        });
    }
};
