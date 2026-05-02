<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranSpp;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->q);
        if (strlen($q) < 2) {
            return response()->json(['siswa' => [], 'transaksi' => []]);
        }

        $siswa = Siswa::with('kelas')
            ->where(function ($query) use ($q) {
                $query->where('nama', 'like', "%{$q}%")
                      ->orWhere('nis', 'like', "%{$q}%")
                      ->orWhere('nisn', 'like', "%{$q}%");
            })
            ->limit(5)->get()
            ->map(fn($s) => [
                'id'    => $s->id,
                'nama'  => $s->nama,
                'nis'   => $s->nis,
                'kelas' => $s->kelas->nama_kelas ?? '-',
                'url'   => route('admin.transaksi.index') . '?siswa_id=' . $s->id,
            ]);

        $transaksi = PembayaranSpp::with('siswa')
            ->where(function ($query) use ($q) {
                $query->where('no_transaksi', 'like', "%{$q}%")
                      ->orWhereHas('siswa', fn($sq) => $sq->where('nama', 'like', "%{$q}%"));
            })
            ->latest()->limit(5)->get()
            ->map(fn($t) => [
                'id'           => $t->id,
                'no_transaksi' => $t->no_transaksi,
                'nama_siswa'   => $t->siswa->nama ?? '-',
                'total'        => 'Rp ' . number_format($t->total_bayar, 0, ',', '.'),
                'url'          => route('admin.history.index') . '?search=' . $t->no_transaksi,
            ]);

        return response()->json(compact('siswa', 'transaksi'));
    }
}
