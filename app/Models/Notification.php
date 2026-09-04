<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [

        'user_id',

        'dokumentasi_id',

        'kegiatan_id',

        'title',

        'message',

        'type',

        'url',

        'is_read',

        'read_at'

    ];

    protected $casts = [

        'is_read'=>'boolean',

        'read_at'=>'datetime',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

}