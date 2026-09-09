<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataPetugasController extends Controller
{
    /**
     * Menampilkan daftar seluruh petugas/user.
     */
    public function index()
    {
        $petugas = User::all();
        return view('admin.datapetugas.index', compact('petugas'));
    }

    /**
     * Menampilkan form tambah petugas.
     */
    public function create()
    {
        return view('admin.datapetugas.create');
    }

    /**
     * Menyimpan data petugas baru ke tabel users.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,petugas,pimpinan,editor',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        // Jika input username diketik tanpa @sipedok.com, otomatis ditambahkan
        $email = str_contains($request->username, '@') 
            ? $request->username 
            : strtolower($request->username) . '@sipedok.com';

        User::create([
            'name'      => $request->nama,
            'email'     => $email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'no_hp'     => $request->no_hp,
            'is_active' => 1,
        ]);

        return redirect()
            ->route('admin.datapetugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit petugas.
     */
    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        return view('admin.datapetugas.edit', compact('petugas'));
    }

    /**
     * Memperbarui data petugas di tabel users.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'  => 'required|string|max:255',
            'role'  => 'required|in:admin,petugas,pimpinan,editor',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $dataUpdate = [
            'name'  => $request->nama,
            'role'  => $request->role,
            'no_hp' => $request->no_hp,
        ];

        if ($request->filled('username')) {
            $email = str_contains($request->username, '@') 
                ? $request->username 
                : strtolower($request->username) . '@sipedok.com';
            $dataUpdate['email'] = $email;
        }

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataUpdate);

        return redirect()
            ->route('admin.datapetugas.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Mengaktifkan akun petugas.
     */
    public function aktifkan($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => 1]);

        return redirect()->back()->with('success', 'Akun ' . $user->name . ' berhasil diaktifkan.');
    }

    /**
     * Menonaktifkan akun petugas.
     */
    public function nonaktifkan($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => 0]);

        return redirect()->back()->with('success', 'Akun ' . $user->name . ' berhasil dinonaktifkan.');
    }

    /**
     * Menghapus data petugas dari database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('admin.datapetugas.index')
            ->with('success', 'Data petugas berhasil dihapus.');
    }
}