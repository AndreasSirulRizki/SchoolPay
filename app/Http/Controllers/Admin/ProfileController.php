<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048',
        ]);
        $data = ['name' => $request->name];
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('staff', 'public');
        }
        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
