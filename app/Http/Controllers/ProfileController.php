<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        // Mengarahkan ke file resources/views/profile/show.blade.php
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        // Tarik data sebagai instance Model User Eloquent
        $user = User::findOrFail($authUser->id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'   => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'no_hp'   => $request->no_hp,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}