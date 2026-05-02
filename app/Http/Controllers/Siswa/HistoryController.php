<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PembayaranSpp;

class HistoryController extends Controller
{
    public function index()
    {
        $siswa   = auth('siswa')->user();
        $tahun   = now()->year;
        $history = PembayaranSpp::where('siswa_id', $siswa->id)->with(['petugas'])->latest()->paginate(10);

        $bulanNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $sudahBayar = PembayaranSpp::where('siswa_id', $siswa->id)->where('tahun', $tahun)->pluck('bulan')->toArray();
        $bulanTunggakan = [];
        for ($m = 1; $m <= now()->month; $m++) {
            if (!in_array($m, $sudahBayar)) {
                $bulanTunggakan[] = $bulanNames[$m];
            }
        }

        return view('siswa.history', compact('history', 'siswa', 'bulanTunggakan'));
    }

    public function kwitansiPdf(PembayaranSpp $pembayaran)
    {
        $siswa = auth('siswa')->user();
        if ($pembayaran->siswa_id !== $siswa->id) abort(403);
        $pembayaran->load(['siswa.kelas', 'petugas']);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.kwitansi', compact('pembayaran'));
        $pdf->setPaper([0, 0, 595, 420]);
        return $pdf->download("kwitansi-{$pembayaran->no_transaksi}.pdf");
    }
}
