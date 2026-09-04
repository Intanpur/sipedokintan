<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class);
    }

}