<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DisposisiPimpinan; // <-- Import model yang benar di sini

class FolderDokumentasi extends Model
{
    use HasFactory;

    protected $table = 'folder_dokumentasi';

    protected $fillable = [
        'kegiatan_id',
        'created_by',
        'nama_folder',
        'total_foto',
        'total_video',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KEGIATAN
    |--------------------------------------------------------------------------
    */

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DOKUMENTASI
    |--------------------------------------------------------------------------
    */

    public function dokumentasi(): HasMany
    {
        return $this->hasMany(Dokumentasi::class, 'folder_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DISPOSISI PIMPINAN
    |--------------------------------------------------------------------------
    */

    public function disposisi(): HasMany
    {
        // Diarahkan ke DisposisiPimpinan
        return $this->hasMany(DisposisiPimpinan::class, 'folder_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI USER / CREATOR
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}