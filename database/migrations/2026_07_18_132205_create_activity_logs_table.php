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
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            // User yang melakukan aktivitas
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // File dokumentasi yang terkena aktivitas
            $table->foreignId('dokumentasi_id')
                ->constrained('dokumentasi')
                ->onDelete('cascade');

            // Jenis aktivitas
            $table->enum('activity', [
                'upload',
                'view',
                'download',
                'selected',
                'assign_editor',
                'edit_upload',
                'approve',
                'reject',
                'archive'
            ]);

            // Keterangan tambahan
            $table->text('description')->nullable();

            // Alamat IP pengguna
            $table->ipAddress('ip')->nullable();

            // Browser / Device
            $table->string('device')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};