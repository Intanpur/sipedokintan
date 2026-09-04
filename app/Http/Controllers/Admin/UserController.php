<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
{
    $users = User::latest()->get();

    return view('admin.datapetugas.index', compact('users'));
}

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.show', compact('user'));
    }

    public function aktifkan($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_active' => true
        ]);

        return back()->with('success', 'User berhasil diaktifkan');
    }

    public function nonaktifkan($id)
    {
        // Pengaman: Jangan biarkan Admin menonaktifkan dirinya sendiri
        if (Auth::id() == $id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user = User::findOrFail($id);

        $user->update([
            'is_active' => false
        ]);

        return back()->with('success', 'User berhasil dinonaktifkan');
    }

    public function destroy($id)
    {
        // Pengaman: Jangan biarkan Admin menghapus dirinya sendiri
        if (Auth::id() == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        User::findOrFail($id)->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}