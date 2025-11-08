<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // 1) Eliminar el constraint CHECK existente si lo hubiera
        DB::statement("
        DO $$
        DECLARE
            constraint_name text;
        BEGIN
            SELECT conname
            INTO constraint_name
            FROM pg_constraint
            WHERE conrelid = 'offers'::regclass
              AND contype = 'c';

            IF constraint_name IS NOT NULL THEN
                EXECUTE format('ALTER TABLE offers DROP CONSTRAINT %I', constraint_name);
            END IF;
        END
        $$;
    ");

        // 2) Cambiar columna a varchar si aplica
        DB::statement("ALTER TABLE offers ALTER COLUMN status TYPE VARCHAR(20)");

        // 3) Establecer nuevo CHECK con estados permitidos
        DB::statement("
        ALTER TABLE offers
        ADD CONSTRAINT offers_status_check CHECK (status IN (
            'draft',
            'open',
            'hired',
            'accepted',
            'completed',
            'closed'
        ));
    ");

        // 4) Establecer valor por defecto
        DB::statement("ALTER TABLE offers ALTER COLUMN status SET DEFAULT 'open'");

        // 5) Asegurar NOT NULL
        DB::statement("UPDATE offers SET status = 'open' WHERE status IS NULL");
        DB::statement("ALTER TABLE offers ALTER COLUMN status SET NOT NULL");

        // 6) Nuevos campos si la migración incluía otros
        if (!Schema::hasColumn('offers', 'employer_confirmed')) {
            Schema::table('offers', function (Blueprint $table) {
                $table->boolean('employer_confirmed')->default(false);
                $table->boolean('employee_confirmed')->default(false);
                $table->timestamp('completed_at')->nullable();
            });
        }
    }


    public function down(): void
    {
        //
    }
};
