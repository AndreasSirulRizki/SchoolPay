<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranSpp;
use App\Models\Siswa;
use App\Models\TarifSpp;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function index()
    {
        $tarif = TarifSpp::with('siswa.kelas')->latest()->paginate(15);
        $siswa = Siswa::with('kelas')->orderBy('nama')->get();

        $totalKoleksi = PembayaranSpp::whereYear('tanggal_bayar', now()->year)->sum('total_bayar');
        $totalSiswa   = Siswa::count();
        $sudahBayar   = PembayaranSpp::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)->distinct('siswa_id')->count('siswa_id');
        $completionRate = $totalSiswa > 0 ? round(($sudahBayar / $totalSiswa) * 100, 1) : 0;
        $tahunAjaran  = date('Y') . '/' . (date('Y') + 1);

        return view('admin.spp.index', compact('tarif', 'siswa', 'totalKoleksi', 'completionRate', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'     => 'nullable|exists:siswa,id',
            'nominal'      => 'required|integer|min:1000',
            'tahun_ajaran' => 'required|string|max:20',
        ]);

        // Deactivate previous tarif for this siswa
        if ($request->siswa_id) {
            TarifSpp::where('siswa_id', $request->siswa_id)->update(['is_aktif' => false]);
        }

        TarifSpp::create([
            'siswa_id'     => $request->siswa_id,
            'nominal'      => $request->nominal,
            'tahun_ajaran' => $request->tahun_ajaran,
            'is_aktif'     => true,
        ]);

        return back()->with('success', 'Tarif SPP berhasil ditambahkan.');
    }

    public function update(Request $request, TarifSpp $spp)
    {
        $request->validate([
            'nominal'      => 'required|integer|min:1000',
            'tahun_ajaran' => 'required|string|max:20',
        ]);
        $spp->update([
            'nominal'      => $request->nominal,
            'tahun_ajaran' => $request->tahun_ajaran,
            'is_aktif'     => $request->boolean('is_aktif'),
        ]);
        return back()->with('success', 'Tarif SPP berhasil diperbarui.');
    }

    public function destroy(TarifSpp $spp)
    {
        if ($spp->pembayaran()->count() > 0) {
            return back()->with('error', 'Tarif tidak dapat dihapus karena sudah digunakan.');
        }
        $spp->delete();
        return back()->with('success', 'Tarif SPP berhasil dihapus.');
    }
}
