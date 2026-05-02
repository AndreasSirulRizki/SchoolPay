<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\PembayaranSpp;
use App\Models\Siswa;
use App\Models\TarifSpp;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $recentTransaksi = PembayaranSpp::where('petugas_id', auth()->id())
            ->with(['siswa.kelas'])->latest()->limit(3)->get();
        return view('petugas.transaksi', compact('recentTransaksi'));
    }

    public function cariSiswa(Request $request)
    {
        $keyword = trim($request->q ?? '');
        if (strlen($keyword) < 2) {
            return response()->json([]);
        }
        $siswa = Siswa::with('kelas')
            ->where(function ($q) use ($keyword) {
                $q->where('nis', 'like', "%{$keyword}%")
                  ->orWhere('nama', 'like', "%{$keyword}%");
            })
            ->limit(10)->get()
            ->map(function ($s) {
                $tahun = now()->year;
                $sudahBayar = PembayaranSpp::where('siswa_id', $s->id)->where('tahun', $tahun)->pluck('bulan')->toArray();
                $tunggakan = [];
                for ($m = 1; $m <= now()->month; $m++) {
                    if (!in_array($m, $sudahBayar)) $tunggakan[] = $m;
                }
                return [
                    'id'             => $s->id,
                    'nis'            => $s->nis,
                    'nama'           => $s->nama,
                    'kelas'          => $s->kelas->nama_kelas ?? '-',
                    'nominal_spp'    => $s->nominal_spp,
                    'tagihan_tersisa'=> count($tunggakan) * $s->nominal_spp,
                ];
            });
        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'     => 'required|exists:siswa,id',
            'bulan'        => 'required|integer|between:1,12',
            'tahun'        => 'required|integer|min:2020',
            'jumlah_bayar' => 'required|integer|min:1000',
        ]);

        $exists = PembayaranSpp::where('siswa_id', $request->siswa_id)
            ->where('bulan', $request->bulan)->where('tahun', $request->tahun)->exists();
        if ($exists) {
            return back()->with('error', 'Pembayaran bulan ini sudah tercatat.');
        }

        $siswa = Siswa::findOrFail($request->siswa_id);
        $tarif = TarifSpp::where('siswa_id', $siswa->id)->where('is_aktif', true)->first();
        $biayaAdmin = 2500;
        $total = $request->jumlah_bayar + $biayaAdmin;

        $pembayaran = PembayaranSpp::create([
            'no_transaksi' => PembayaranSpp::generateNoTransaksi(),
            'siswa_id'     => $request->siswa_id,
            'tarif_id'     => $tarif?->id,
            'bulan'        => $request->bulan,
            'tahun'        => $request->tahun,
            'tanggal_bayar'=> today(),
            'jumlah_bayar' => $request->jumlah_bayar,
            'biaya_admin'  => $biayaAdmin,
            'total_bayar'  => $total,
            'metode_bayar' => $request->metode_bayar ?? 'tunai',
            'petugas_id'   => auth()->id(),
            'keterangan'   => $request->keterangan,
            'status'       => 'lunas',
        ]);

        Notifikasi::kirim('siswa', $siswa->id,
            "Pembayaran SPP bulan {$pembayaran->nama_bulan} {$request->tahun} sebesar Rp " . number_format($total, 0, ',', '.') . " telah berhasil dicatat.",
            'success');

        return back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function kwitansi(PembayaranSpp $pembayaran)
    {
        $pembayaran->load(['siswa.kelas', 'tarif', 'petugas']);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.kwitansi', compact('pembayaran'));
        $pdf->setPaper([0, 0, 595, 420]);
        return $pdf->download("kwitansi-{$pembayaran->no_transaksi}.pdf");
    }
}
