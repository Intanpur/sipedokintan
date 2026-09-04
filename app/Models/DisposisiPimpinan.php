<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposisiPimpinan extends Model
{
    use HasFactory;

    protected $table = 'disposisi_pimpinan';

    protected $fillable = [
        'folder_id',
        'pimpinan_id',
        'token',
        'status_review',
        'catatan_pimpinan',
    ];

    public function folder()
    {
        return $this->belongsTo(FolderDokumentasi::class, 'folder_id');
    }

    public function pimpinan()
    {
        return $this->belongsTo(User::class, 'pimpinan_id');
    }
}