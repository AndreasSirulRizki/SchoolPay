<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $siswa = auth('siswa')->user()->load('kelas');
        return view('siswa.profil', compact('siswa'));
    }

    public function update(Request $request)
    {
        $siswa = auth('siswa')->user();
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['kelas_id', 'no_hp', 'alamat']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        $siswa->update($data);
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
