<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\PembayaranSpp;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa  = auth('siswa')->user();
        $tahun  = now()->year;
        $bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $statusBulan = [];
        for ($m = 1; $m <= 12; $m++) {
            $bayar = PembayaranSpp::where('siswa_id', $siswa->id)
                ->where('bulan', $m)->where('tahun', $tahun)->first();
            $statusBulan[] = [
                'bulan'      => $m,
                'nama'       => $bulanNames[$m],
                'status'     => $bayar ? 'lunas' : 'belum',
                'pembayaran' => $bayar,
            ];
        }

        $lunasCount = collect($statusBulan)->where('status', 'lunas')->count();
        $totalTagihan = 12 * $siswa->nominal_spp;
        $totalBayar   = PembayaranSpp::where('siswa_id', $siswa->id)->where('tahun', $tahun)->sum('total_bayar');
        $statusBulanIni = PembayaranSpp::where('siswa_id', $siswa->id)
            ->where('bulan', now()->month)->where('tahun', $tahun)->exists() ? 'lunas' : 'belum';

        $recentHistory = PembayaranSpp::where('siswa_id', $siswa->id)->latest()->limit(3)->get();
        $unreadNotif   = Notifikasi::unreadCount('siswa', $siswa->id);

        return view('siswa.dashboard', compact(
            'siswa', 'statusBulan', 'tahun', 'lunasCount',
            'totalTagihan', 'totalBayar', 'statusBulanIni', 'recentHistory', 'unreadNotif'
        ));
    }
}
