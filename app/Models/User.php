<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Fortify\TwoFactorAuthenticatable; // Trait untuk 2FA

class User extends Authenticatable
{
    // Trait dipindahkan ke DALAM class
    use HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

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
        'last_login_ip',
        'two_factor_secret',         // Ditambahkan untuk 2FA
        'two_factor_recovery_codes', // Ditambahkan untuk 2FA
        'two_factor_confirmed_at',   // Ditambahkan untuk 2FA
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',         // Disembunyikan demi keamanan
        'two_factor_recovery_codes', // Disembunyikan demi keamanan
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'last_login'        => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
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