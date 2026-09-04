<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('folder_dokumentasi', function (Blueprint $table) {

            $table->id();

            $table->foreignId('kegiatan_id')
                ->constrained('kegiatan')
                ->cascadeOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_folder');

            $table->text('deskripsi')->nullable();

            $table->integer('total_video')->default(0);

            $table->integer('total_foto')->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folder_dokumentasi');
    }
};