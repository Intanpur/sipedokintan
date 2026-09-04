<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\FolderDokumentasi;
use App\Models\Notification;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'lokasi',
        'tanggal_kegiatan',
        'waktu_mulai',
        'created_by',
        'pimpinan_id',
    ];

    /**
     * User yang membuat kegiatan (Relasi dipanggil oleh controller: createdBy)
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    /**
     * Alias jika kamu tetap ingin menggunakan method creator()
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Pimpinan yang menerima kegiatan
     */
    public function pimpinan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pimpinan_id');
    }

    /**
     * Folder dokumentasi kegiatan
     */
    public function folder(): HasOne
    {
        return $this->hasOne(FolderDokumentasi::class, 'kegiatan_id');
    }

    /**
     * Notifikasi kegiatan
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
    // Tambahkan jika model Catatan/Revisi dipisah
public function catatan()
{
    // Sesuaikan nama model target relasimu (misal Catatan ::class atau Revisi ::class)
    return $this->hasMany(\App\Models\Catatan::class, 'kegiatan_id');
}
}