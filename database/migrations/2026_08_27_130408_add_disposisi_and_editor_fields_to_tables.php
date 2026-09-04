<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel pivot untuk pengiriman notifikasi ke banyak pimpinan sekaligus (Multi-Pimpinan)
        if (!Schema::hasTable('disposisi_pimpinan')) {
            Schema::create('disposisi_pimpinan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('folder_id')->constrained('folder_dokumentasi')->onDelete('cascade');
                $table->foreignId('pimpinan_id')->constrained('users')->onDelete('cascade');
                $table->string('token')->unique(); // Token unik untuk Magic Link WhatsApp
                $table->enum('status_review', ['pending', 'selesai'])->default('pending');
                $table->text('catatan_pimpinan')->nullable();
                $table->timestamps();
            });
        }

        // 2. Menambahkan kolom simpan hasil file final editan editor & catatan pimpinan di tabel mentahan
        Schema::table('dokumentasi', function (Blueprint $table) {
            if (!Schema::hasColumn('dokumentasi', 'file_final_path')) {
                $table->string('file_final_path')->nullable()->after('path_file');
            }

            if (!Schema::hasColumn('dokumentasi', 'instruksi_edit')) {
                // Mengecek ketersediaan kolom catatan_progres sebagai patokan urutan 'after'
                if (Schema::hasColumn('dokumentasi', 'catatan_progres')) {
                    $table->text('instruksi_edit')->nullable()->after('catatan_progres');
                } else {
                    $table->text('instruksi_edit')->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        // Hapus tabel disposisi_pimpinan jika ada
        Schema::dropIfExists('disposisi_pimpinan');

        // Hapus kolom tambahan pada tabel dokumentasi jika ada
        Schema::table('dokumentasi', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('dokumentasi', 'file_final_path')) {
                $columnsToDrop[] = 'file_final_path';
            }
            if (Schema::hasColumn('dokumentasi', 'instruksi_edit')) {
                $columnsToDrop[] = 'instruksi_edit';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};