<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'petugas')->with('petugasProfile');
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%");
            });
        }
        $petugas = $query->paginate(10)->withQueryString();

        $totalPetugas  = User::where('role', 'petugas')->count();
        $totalAdmin    = User::where('role', 'admin')->count();
        $activeToday   = User::whereDate('last_login_at', today())->count();

        return view('admin.petugas.index', compact('petugas', 'totalPetugas', 'totalAdmin', 'activeToday'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|unique:users,username|max:50',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nip'      => 'nullable|string|max:30',
            'jabatan'  => 'nullable|string|max:100',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        Petugas::create([
            'user_id' => $user->id,
            'nip'     => $request->nip,
            'jabatan' => $request->jabatan,
            'no_hp'   => $request->no_hp,
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'username'=> 'required|string|unique:users,username,' . $user->id . '|max:50',
            'email'   => 'nullable|email|unique:users,email,' . $user->id,
            'jabatan' => 'nullable|string|max:100',
            'no_hp'   => 'nullable|string|max:20',
        ]);

        $user->update(['name' => $request->name, 'username' => $request->username, 'email' => $request->email]);
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        $user->petugasProfile()->updateOrCreate(
            ['user_id' => $user->id],
            ['nip' => $request->nip, 'jabatan' => $request->jabatan, 'no_hp' => $request->no_hp]
        );
        return back()->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Petugas berhasil dihapus.');
    }
}
