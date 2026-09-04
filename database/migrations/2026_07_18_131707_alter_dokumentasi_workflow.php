<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumentasi', function (Blueprint $table) {
            // Hapus kolom lama
            if (Schema::hasColumn('dokumentasi', 'status_progres')) {
                $table->dropColumn('status_progres');
            }

            // Foreign Keys
            $table->foreignId('assigned_to')->nullable()->after('uploaded_by')->constrained('users')->nullOnDelete();
            $table->foreignId('selected_by')->nullable()->after('assigned_to')->constrained('users')->nullOnDelete();
            $table->foreignId('editor_id')->nullable()->after('selected_by')->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->after('editor_id')->constrained('users')->nullOnDelete();
            
            // Kolom Berkas & Instruksi Final (TAMBAHAN UTAMA)
            $table->string('file_final_path')->nullable()->after('path_file');
            $table->text('instruksi_edit')->nullable()->after('file_final_path');

            // Metadata Tambahan
            $table->string('thumbnail')->nullable();
            $table->string('durasi')->nullable();
            $table->enum('status', ['upload', 'dipilih', 'editing', 'revisi', 'selesai', 'arsip'])->default('upload');
            $table->timestamp('edited_at')->nullable();
            $table->timestamp('approved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('dokumentasi', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropForeign(['selected_by']);
            $table->dropForeign(['editor_id']);
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'assigned_to',
                'selected_by',
                'editor_id',
                'approved_by',
                'file_final_path',
                'instruksi_edit',
                'thumbnail',
                'durasi',
                'status',
                'edited_at',
                'approved_at'
            ]);

            $table->string('status_progres')->nullable();
        });
    }
};