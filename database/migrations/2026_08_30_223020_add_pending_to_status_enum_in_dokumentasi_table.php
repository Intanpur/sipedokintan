<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Matikan strict mode dan check constraint sementara
        DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        DB::statement("SET SESSION sql_mode = '';");

        // Jalankan alter table ENUM
        DB::statement("ALTER TABLE dokumentasi MODIFY COLUMN status ENUM('proses', 'pending', 'dipilih', 'ditolak', 'revisi', 'selesai') NOT NULL DEFAULT 'proses'");

        // Kembalikan ke mode normal
        DB::statement("SET FOREIGN_KEY_CHECKS=1;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        DB::statement("SET SESSION sql_mode = '';");

        DB::statement("ALTER TABLE dokumentasi MODIFY COLUMN status ENUM('proses', 'dipilih', 'ditolak', 'revisi', 'selesai') NOT NULL DEFAULT 'proses'");

        DB::statement("SET FOREIGN_KEY_CHECKS=1;");
    }
};