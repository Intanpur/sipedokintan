<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi';

    protected $fillable = [
        'folder_id',
        'uploaded_by',
        'assigned_to',
        'selected_by',
        'editor_id',
        'approved_by',
        'tipe_file',
        'nama_file',
        'path_file',
        'file_final_path',
        'instruksi_edit',
        'ukuran_file',
        'status',
        'edited_at',
        'approved_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'edited_at'   => 'datetime',
        'approved_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Folder tempat file berada
    public function folder()
    {
        return $this->belongsTo(FolderDokumentasi::class, 'folder_id');
    }

    // User yang mengunggah file
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Pimpinan yang memilih file
    public function selectedBy()
    {
        return $this->belongsTo(User::class, 'selected_by');
    }

    // Editor yang mengedit file
    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    // Pimpinan yang menyetujui hasil final
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // Format ukuran file (contoh: 2.5 MB, 10 KB)
    public function getSizeFormattedAttribute()
    {
        $bytes = $this->ukuran_file;

        if ($bytes >= 1073741824) {
            return round($bytes / 1073741824, 2) . ' GB';
        }

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    // Icon berdasarkan tipe file
    public function getIconAttribute()
    {
        return strtolower($this->tipe_file) == 'video'
            ? 'bi-camera-video-fill'
            : 'bi-image-fill';
    }

    // Warna badge berdasarkan tipe file
    public function getBadgeColorAttribute()
    {
        return strtolower($this->tipe_file) == 'video'
            ? 'primary'
            : 'success';
    }
    
}