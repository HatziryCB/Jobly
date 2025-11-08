<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1
                    FROM pg_constraint
                    WHERE conname = 'identity_verifications_dpi_unique'
                ) THEN
                    ALTER TABLE identity_verifications
                    DROP CONSTRAINT identity_verifications_dpi_unique;
                END IF;
            END
            $$;
        ");
    }

    public function down()
    {
        //
    }
};
