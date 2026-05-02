<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PembayaranSpp;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PembayaranSpp::with(['siswa.kelas', 'petugas'])->latest('tanggal_bayar');

        if ($request->tab === 'hari_ini') {
            $query->whereDate('tanggal_bayar', today());
        } elseif ($request->tab === 'bulan_ini') {
            $query->whereMonth('tanggal_bayar', now()->month)->whereYear('tanggal_bayar', now()->year);
        }
        if ($request->search) {
            $query->whereHas('siswa', fn($q) => $q->where('nama', 'like', "%{$request->search}%")
                ->orWhere('nis', 'like', "%{$request->search}%"));
        }
        if ($request->kelas_id) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->petugas_id) {
            $query->where('petugas_id', $request->petugas_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $history = $query->paginate(15)->withQueryString();
        $kelas = Kelas::orderBy('tingkat')->get();
        $petugasList = User::where('role', 'petugas')->get();

        $totalBulanIni = PembayaranSpp::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)->sum('total_bayar');
        $bulanLalu = now()->subMonthNoOverflow();
        $totalBulanLalu = PembayaranSpp::whereMonth('tanggal_bayar', $bulanLalu->month)
            ->whereYear('tanggal_bayar', $bulanLalu->year)->sum('total_bayar');
        $pctChange = $totalBulanLalu > 0 ? round((($totalBulanIni - $totalBulanLalu) / $totalBulanLalu) * 100) : 0;

        $sudahBayarBulanIni = PembayaranSpp::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)->where('status', 'lunas')
            ->distinct('siswa_id')->count('siswa_id');
        $totalSiswa = Siswa::count();
        $pending = PembayaranSpp::where('status', 'pending')->count();

        return view('admin.history.index', compact(
            'history', 'kelas', 'petugasList',
            'totalBulanIni', 'totalBulanLalu', 'pctChange', 'sudahBayarBulanIni', 'totalSiswa', 'pending'
        ));
    }

    public function preview(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $query = PembayaranSpp::with(['siswa.kelas', 'petugas'])
            ->where('bulan', $bulan)->where('tahun', $tahun);
        if ($request->kelas_id) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }
        $pembayaran = $query->get();
        $total = $pembayaran->sum('total_bayar');
        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return response()->json([
            'html'  => view('admin.history.preview-partial', compact('pembayaran', 'total', 'bulan', 'tahun', 'namaBulan'))->render(),
            'total' => $total,
        ]);
    }

    public function pdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $pembayaran = PembayaranSpp::with(['siswa.kelas', 'petugas'])
            ->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.laporan', compact('pembayaran', 'bulan', 'tahun', 'namaBulan'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download("laporan-spp-{$namaBulan[$bulan]}-{$tahun}.pdf");
    }
}
