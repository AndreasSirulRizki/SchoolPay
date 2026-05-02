<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Notifikasi;
use App\Models\Siswa;
use App\Models\TarifSpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%")
                  ->orWhere('nisn', 'like', "%{$request->search}%");
            });
        }
        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $siswa  = $query->paginate(10)->withQueryString();
        $kelas  = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $tarifs = TarifSpp::whereNull('siswa_id')->where('is_aktif', true)->get();

        $totalSiswa   = Siswa::count();
        $activeCount  = Siswa::where('status', 'active')->count();
        $pendingCount = Siswa::where('status', 'suspended')->count();

        return view('admin.siswa.index', compact('siswa', 'kelas', 'tarifs', 'totalSiswa', 'activeCount', 'pendingCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|string|unique:siswa,nis|max:20',
            'nisn'          => 'nullable|string|unique:siswa,nisn|max:20',
            'nama'          => 'required|string|max:100',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
        ]);

        $data = $request->only(['nis', 'nisn', 'nama', 'kelas_id', 'jenis_kelamin', 'alamat', 'no_hp']);
        $data['password'] = Hash::make($request->filled('password') ? $request->password : $request->nis);
        $data['status']   = 'active';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create($data);

        // Assign tarif if provided
        if ($request->nominal_spp) {
            TarifSpp::create([
                'siswa_id'     => $siswa->id,
                'nominal'      => $request->nominal_spp,
                'tahun_ajaran' => $request->tahun_ajaran ?? date('Y') . '/' . (date('Y') + 1),
                'is_aktif'     => true,
            ]);
        }

        // Notifikasi ke admin
        Notifikasi::kirim('staff', auth()->id(), "Siswa baru {$siswa->nama} (NIS: {$siswa->nis}) berhasil didaftarkan.", 'success');

        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'           => 'required|string|unique:siswa,nis,' . $siswa->id . '|max:20',
            'nisn'          => 'nullable|string|unique:siswa,nisn,' . $siswa->id . '|max:20',
            'nama'          => 'required|string|max:100',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $data = $request->only(['nis', 'nisn', 'nama', 'kelas_id', 'jenis_kelamin', 'alamat', 'no_hp', 'status']);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $siswa->update($data);
        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xlsx,csv,xls']);
        try {
            Excel::import(new \App\Imports\SiswaImport, $request->file('file'));
            return back()->with('success', 'Import siswa berhasil.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    public function idCard(Siswa $siswa)
    {
        $siswa->load('kelas');
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.id-card', compact('siswa'));
        $pdf->setPaper([0, 0, 320, 175], 'portrait');
        return $pdf->download("id-card-" . str_replace(' ', '-', strtolower($siswa->nama)) . ".pdf");
    }
}
