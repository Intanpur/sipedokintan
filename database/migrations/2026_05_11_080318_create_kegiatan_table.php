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
      Schema::create('kegiatan', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kegiatan');
    $table->text('deskripsi')->nullable();
    $table->string('lokasi');
    $table->date('tanggal_kegiatan');
    $table->time('waktu_mulai');
    $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
    $table->foreignId('pimpinan_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
