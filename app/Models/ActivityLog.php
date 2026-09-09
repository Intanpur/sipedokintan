<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'dokumentasi_id',
        'activity',
        'description',
        'ip',
        'device',
    ];

    /**
     * Formatting otomatis atribut.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User (Pemilik Aksi).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'User Terhapus',
            'role' => '-',
        ]);
    }

    /**
     * Relasi ke Dokumentasi (File Terkait).
     */
    public function dokumentasi(): BelongsTo
    {
        return $this->belongsTo(Dokumentasi::class)->withDefault([
            'nama_file' => 'File Terhapus/Tidak Ada',
        ]);
    }
}