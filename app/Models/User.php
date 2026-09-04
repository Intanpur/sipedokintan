<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $google_id
 * @property string $role
 * @property string|null $jabatan
 * @property string|null $no_hp
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $last_login
 * @property string|null $last_login_ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'role',
        'jabatan',
        'no_hp',
        'is_active',
        'last_login',
        'last_login_ip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'last_login'        => 'datetime',
        ];
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'created_by');
    }

    public function uploadedDokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'uploaded_by');
    }

    public function selectedDokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'selected_by');
    }

    public function editedDokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'editor_id');
    }

    public function approvedDokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'approved_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}