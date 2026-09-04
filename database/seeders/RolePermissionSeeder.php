<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'lihat-dashboard',
            'kelola-kegiatan',
            'unggah-dokumentasi',
            'lihat-arsip',
            'monitoring-progres',
            'data-statistik',
            'kelola-pengguna',
            'kelola-hak-akses',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin    = Role::firstOrCreate(['name' => 'admin']);
        $pemimpin = Role::firstOrCreate(['name' => 'pemimpin']);
        $petugas  = Role::firstOrCreate(['name' => 'petugas']);

        $admin->givePermissionTo(Permission::all());

        $pemimpin->givePermissionTo([
            'lihat-dashboard',
            'lihat-arsip',
            'monitoring-progres',
            'data-statistik',
        ]);

        $petugas->givePermissionTo([
            'lihat-dashboard',
            'kelola-kegiatan',
            'unggah-dokumentasi',
            'lihat-arsip',
        ]);
    }
}