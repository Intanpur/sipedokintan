<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringProgres extends Model
{
    use HasFactory;

    protected $table = 'monitoring_progres';

    protected $fillable = [
        'kegiatan_id',
        'updated_by',
        'status_baru',
        'catatan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}