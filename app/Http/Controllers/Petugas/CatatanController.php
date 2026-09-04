<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\Catatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanController extends Controller
{
    public function store(Request $request)
    {
        Catatan::create([
            'kegiatan_id' => $request->kegiatan_id,
            'user_id' => Auth::id(),
            'isi_catatan' => $request->isi_catatan,
        ]);

        return back();
    }
}