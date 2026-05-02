<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Notifikasi;
use App\Models\PembayaranSpp;
use App\Models\Siswa;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa   = Siswa::count();
        $activeStaff  = User::where('role', 'petugas')->count();
        $totalKelas   = Kelas::count();
        $bulanIni     = now()->month;
        $tahunIni     = now()->year;

        $monthlyRevenue = PembayaranSpp::whereMonth('tanggal_bayar', $bulanIni)
            ->whereYear('tanggal_bayar', $tahunIni)->where('status', 'lunas')->sum('total_bayar');

        // Revenue chart — yearly (12 months)
        $yearlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $yearlyData[] = [
                'bulan' => ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'][$m],
                'total' => PembayaranSpp::whereMonth('tanggal_bayar', $m)
                    ->whereYear('tanggal_bayar', $tahunIni)->sum('total_bayar'),
            ];
        }

        // 6 months chart
        $sixMonthData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $sixMonthData[] = [
                'bulan' => $date->format('M'),
                'total' => PembayaranSpp::whereMonth('tanggal_bayar', $date->month)
                    ->whereYear('tanggal_bayar', $date->year)->sum('total_bayar'),
            ];
        }

        $transaksiTerbaru = PembayaranSpp::with(['siswa.kelas', 'petugas'])
            ->latest()->limit(5)->get();

        $unreadNotif = Notifikasi::unreadCount('staff', auth()->id());

        return view('admin.dashboard.index', compact(
            'totalSiswa', 'activeStaff', 'totalKelas', 'monthlyRevenue',
            'yearlyData', 'sixMonthData', 'transaksiTerbaru', 'unreadNotif'
        ));
    }
}
