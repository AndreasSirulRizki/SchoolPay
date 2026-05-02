<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\PembayaranSpp;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $petugasId = auth()->id();

        $hariIni = PembayaranSpp::whereDate('tanggal_bayar', today())
            ->where('petugas_id', $petugasId)->with(['siswa.kelas'])->latest()->get();

        $totalHariIni  = $hariIni->sum('total_bayar');
        $jumlahHariIni = $hariIni->count();
        $totalSiswa    = Siswa::count();

        $recentActivity = PembayaranSpp::where('petugas_id', $petugasId)
            ->with(['siswa.kelas'])->latest()->limit(5)->get();

        $unreadNotif = Notifikasi::unreadCount('staff', $petugasId);

        return view('petugas.dashboard', compact(
            'hariIni', 'totalHariIni', 'jumlahHariIni',
            'totalSiswa', 'recentActivity', 'unreadNotif'
        ));
    }
}
