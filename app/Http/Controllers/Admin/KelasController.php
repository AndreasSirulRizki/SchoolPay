<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::withCount('siswa');
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kelas', 'like', "%{$request->search}%")
                  ->orWhere('jurusan', 'like', "%{$request->search}%");
            });
        }
        $kelas = $query->paginate(10)->withQueryString();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat'    => 'required|in:X,XI,XII',
            'jurusan'    => 'required|string|max:100',
            'wali_kelas' => 'nullable|string|max:100',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'tingkat.required'    => 'Tingkat wajib dipilih.',
            'jurusan.required'    => 'Jurusan wajib diisi.',
        ]);

        Kelas::create($request->only(['nama_kelas', 'tingkat', 'jurusan', 'wali_kelas']));
        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat'    => 'required|in:X,XI,XII',
            'jurusan'    => 'required|string|max:100',
            'wali_kelas' => 'nullable|string|max:100',
        ]);

        $kelas->update($request->only(['nama_kelas', 'tingkat', 'jurusan', 'wali_kelas']));
        return back()->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        if ($kelas->siswa()->count() > 0) {
            return back()->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }
        $kelas->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}
