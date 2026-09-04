<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan opsi 'tolak' serta opsi lainnya ke dalam ENUM
        DB::statement("ALTER TABLE dokumentasi MODIFY COLUMN status ENUM('mentah', 'dipilih', 'editing', 'selesai', 'ditolak', 'tolak', 'pending', 'proses') DEFAULT 'mentah'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE dokumentasi MODIFY COLUMN status ENUM('mentah', 'dipilih', 'selesai', 'ditolak') DEFAULT 'mentah'");
    }
};
