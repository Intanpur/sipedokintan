<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            // Penerima notifikasi
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Dokumentasi yang berkaitan
            $table->foreignId('dokumentasi_id')
                ->nullable()
                ->constrained('dokumentasi')
                ->nullOnDelete();

            // Kegiatan yang berkaitan
            $table->foreignId('kegiatan_id')
                ->nullable()
                ->constrained('kegiatan')
                ->nullOnDelete();

            // Judul
            $table->string('title');

            // Isi notifikasi
            $table->text('message');

            // Jenis notifikasi
            $table->enum('type', [
                'upload',
                'selected',
                'editing',
                'revision',
                'approved',
                'archive',
                'system'
            ]);

            // Status dibaca
            $table->boolean('is_read')->default(false);

            // Link tujuan
            $table->string('url')->nullable();

            // Waktu dibaca
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};