<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // If column exists, alter it to nullable using raw SQL (safer without doctrine/dbal)
        if (Schema::hasColumn('medicos', 'paciente_id')) {
            DB::statement("ALTER TABLE `medicos` MODIFY `paciente_id` bigint unsigned NULL;");

            // ensure foreign key exists and points to users(id)
            $rows = DB::select("SELECT CONSTRAINT_NAME as fk FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'medicos' AND COLUMN_NAME = 'paciente_id' AND REFERENCED_TABLE_NAME IS NOT NULL");
            if (!empty($rows)) {
                $fk = $rows[0]->fk;
                // drop existing foreign key if present, then re-add with expected name
                DB::statement("ALTER TABLE `medicos` DROP FOREIGN KEY `$fk`");
            }
            DB::statement("ALTER TABLE `medicos` ADD CONSTRAINT `medicos_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `users`(`id`) ON DELETE CASCADE");
        } else {
            Schema::table('medicos', function (Blueprint $table) {
                $table->foreignId('paciente_id')->nullable()->constrained('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // revert: make paciente_id NOT NULL
        if (Schema::hasColumn('medicos', 'paciente_id')) {
            // drop existing FK if any
            $rows = DB::select("SELECT CONSTRAINT_NAME as fk FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'medicos' AND COLUMN_NAME = 'paciente_id' AND REFERENCED_TABLE_NAME IS NOT NULL");
            if (!empty($rows)) {
                $fk = $rows[0]->fk;
                DB::statement("ALTER TABLE `medicos` DROP FOREIGN KEY `$fk`");
            }
            DB::statement("ALTER TABLE `medicos` MODIFY `paciente_id` bigint unsigned NOT NULL;");
            DB::statement("ALTER TABLE `medicos` ADD CONSTRAINT `medicos_paciente_id_foreign` FOREIGN KEY (`paciente_id`) REFERENCES `users`(`id`) ON DELETE CASCADE");
        }
    }
};
