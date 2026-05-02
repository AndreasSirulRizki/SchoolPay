<?php

namespace App\Exports;

use App\Models\PembayaranSpp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(
        private int $bulan,
        private int $tahun,
        private ?int $kelasId = null
    ) {}

    public function collection()
    {
        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $query = PembayaranSpp::with(['siswa.kelas', 'petugas'])
            ->where('bulan', $this->bulan)
            ->where('tahun', $this->tahun);

        if ($this->kelasId) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $this->kelasId));
        }

        return $query->get()->map(fn($p) => [
            'No. Transaksi' => $p->no_transaksi,
            'Nama Siswa'    => $p->siswa->nama,
            'NIS'           => $p->siswa->nis,
            'Kelas'         => $p->siswa->kelas->nama_kelas ?? '-',
            'Bulan'         => $namaBulan[$p->bulan],
            'Tahun'         => $p->tahun,
            'Jumlah Bayar'  => $p->jumlah_bayar,
            'Biaya Admin'   => $p->biaya_admin,
            'Total Bayar'   => $p->total_bayar,
            'Metode'        => ucfirst($p->metode_bayar),
            'Tgl Bayar'     => $p->tanggal_bayar,
            'Petugas'       => $p->petugas->name ?? '-',
            'Status'        => ucfirst($p->status),
        ]);
    }

    public function headings(): array
    {
        return ['No. Transaksi', 'Nama Siswa', 'NIS', 'Kelas', 'Bulan', 'Tahun',
                'Jumlah Bayar', 'Biaya Admin', 'Total Bayar', 'Metode', 'Tgl Bayar', 'Petugas', 'Status'];
    }

    public function title(): string
    {
        return 'Laporan SPP';
    }
}
