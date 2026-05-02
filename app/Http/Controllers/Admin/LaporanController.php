<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PembayaranSpp;
use App\Models\Siswa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan    = $request->bulan;   // null = semua bulan
        $tahun    = $request->tahun ?? now()->year;
        $kelas_id = $request->kelas_id;
        $periode  = $request->periode ?? 'bulan'; // hari_ini | bulan | semua

        $query = PembayaranSpp::with(['siswa.kelas', 'tarif', 'petugas']);

        if ($periode === 'hari_ini') {
            $query->whereDate('tanggal_bayar', today());
        } elseif ($periode === 'semua') {
            // no date filter
        } else {
            // default: filter bulan & tahun
            $bulan = $bulan ?? now()->month;
            $query->where('bulan', $bulan)->where('tahun', $tahun);
        }

        if ($kelas_id) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelas_id));
        }

        // clone before paginate to get accurate totals
        $statsQuery      = clone $query;
        $totalPendapatan = $statsQuery->sum('total_bayar');
        $totalTransaksi  = $statsQuery->count();

        $pembayaran = $query->latest()->paginate(15)->withQueryString();
        $kelas      = Kelas::orderBy('tingkat')->get();
        $bulan      = $bulan ?? now()->month;

        return view('admin.laporan.index', compact(
            'pembayaran', 'kelas', 'bulan', 'tahun', 'kelas_id',
            'totalPendapatan', 'totalTransaksi', 'periode'
        ));
    }

    public function pdf(Request $request)
    {
        $bulan    = $request->bulan;
        $tahun    = $request->tahun ?? now()->year;
        $kelas_id = $request->kelas_id;
        $periode  = $request->periode ?? 'bulan';

        $query = PembayaranSpp::with(['siswa.kelas', 'tarif', 'petugas']);

        if ($periode === 'hari_ini') {
            $query->whereDate('tanggal_bayar', today());
        } elseif ($periode === 'semua') {
            // no date filter
        } else {
            $bulan = $bulan ?? now()->month;
            $query->where('bulan', $bulan)->where('tahun', $tahun);
        }

        if ($kelas_id) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelas_id));
        }

        $pembayaran = $query->get();
        $bulan      = $bulan ?? now()->month;
        $namaBulan  = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $judulPeriode = match($periode) {
            'hari_ini' => 'Hari Ini — ' . now()->format('d M Y'),
            'semua'    => 'Semua Data',
            default    => $namaBulan[$bulan] . ' ' . $tahun,
        };

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.laporan', compact('pembayaran', 'bulan', 'tahun', 'namaBulan', 'judulPeriode'));
        $pdf->setPaper('a4', 'landscape');

        $filename = 'laporan-spp-' . str_replace(' ', '-', strtolower($judulPeriode)) . '.pdf';
        return $pdf->download($filename);
    }

    public function excel(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanExport($bulan, $tahun, $request->kelas_id),
            "laporan-spp-{$namaBulan[$bulan]}-{$tahun}.xlsx"
        );
    }

    public function pdfSiswa(Request $request)
    {
        $periode = $request->periode ?? 'bulan'; // hari_ini | bulan | tahun
        $bulan   = $request->bulan ?? now()->month;
        $tahun   = $request->tahun ?? now()->year;

        $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni',
                      'Juli','Agustus','September','Oktober','November','Desember'];

        // Build pembayaran subquery for the chosen period
        $bayarQuery = PembayaranSpp::query();
        if ($periode === 'hari_ini') {
            $bayarQuery->whereDate('tanggal_bayar', today());
            $judulPeriode = 'Hari Ini — ' . now()->format('d M Y');
        } elseif ($periode === 'tahun') {
            $bayarQuery->where('tahun', $tahun);
            $judulPeriode = 'Tahun ' . $tahun;
        } else {
            $bayarQuery->where('bulan', $bulan)->where('tahun', $tahun);
            $judulPeriode = $namaBulan[$bulan] . ' ' . $tahun;
        }

        $paidIds = (clone $bayarQuery)->pluck('siswa_id');

        // Load all payments for the period in ONE query, then group — eliminates N+1
        $allPembayaran = (clone $bayarQuery)->get()->groupBy('siswa_id');

        $siswa = Siswa::with('kelas')
            ->orderBy('kelas_id')
            ->orderBy('nama')
            ->get()
            ->map(function ($s) use ($allPembayaran) {
                $payments = $allPembayaran->get($s->id, collect());
                $s->total_bayar   = $payments->sum('total_bayar');
                $s->jml_transaksi = $payments->count();
                $s->sudah_bayar   = $payments->isNotEmpty();
                return $s;
            });

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.laporan-siswa', compact('siswa', 'judulPeriode', 'namaBulan', 'bulan', 'tahun', 'periode'));
        $pdf->setPaper('a4', 'landscape');

        $filename = 'laporan-siswa-' . str_replace([' ','—'], ['-',''], strtolower($judulPeriode)) . '.pdf';
        return $pdf->download($filename);
    }

    public function excelSiswa()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SiswaExport(),
            'data-siswa.xlsx'
        );
    }

    public function excelTunggakan(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\TunggakanExport($bulan, $tahun),
            "tunggakan-spp-{$bulan}-{$tahun}.xlsx"
        );
    }
}
