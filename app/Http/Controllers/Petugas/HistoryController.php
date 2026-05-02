<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PembayaranSpp;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PembayaranSpp::with(['siswa.kelas', 'petugas'])
            ->where('petugas_id', auth()->id())->latest('tanggal_bayar');

        if ($request->search) {
            $query->whereHas('siswa', fn($q) => $q->where('nama', 'like', "%{$request->search}%")
                ->orWhere('nis', 'like', "%{$request->search}%"));
        }
        if ($request->kelas_id) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->tanggal) {
            $query->whereDate('tanggal_bayar', $request->tanggal);
        }

        $history = $query->paginate(15)->withQueryString();
        $kelas   = Kelas::orderBy('tingkat')->get();

        $totalBulanIni = PembayaranSpp::where('petugas_id', auth()->id())
            ->whereMonth('tanggal_bayar', now()->month)->whereYear('tanggal_bayar', now()->year)->sum('total_bayar');
        $totalHariIni  = PembayaranSpp::where('petugas_id', auth()->id())
            ->whereDate('tanggal_bayar', today())->sum('total_bayar');

        return view('petugas.history', compact('history', 'kelas', 'totalBulanIni', 'totalHariIni'));
    }

    public function kwitansiPdf(PembayaranSpp $pembayaran)
    {
        if ($pembayaran->petugas_id !== auth()->id()) abort(403);
        $pembayaran->load(['siswa.kelas', 'tarif', 'petugas']);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.kwitansi', compact('pembayaran'));
        $pdf->setPaper([0, 0, 595, 420]);
        return $pdf->download("kwitansi-{$pembayaran->no_transaksi}.pdf");
    }
}
