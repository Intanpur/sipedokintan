<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('folder_dokumentasi')->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->enum('tipe_file', ['video', 'foto']);
            $table->string('nama_file');
            $table->string('path_file');
            $table->bigInteger('ukuran_file');
            $table->enum('status_progres', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->text('catatan_progres')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi');
    }
};