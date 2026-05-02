<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\PembayaranSpp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TunggakanExport implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(private int $bulan, private int $tahun) {}

    public function collection()
    {
        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $sudahBayar = PembayaranSpp::where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->pluck('siswa_id');

        return Siswa::with('kelas')
            ->whereNotIn('id', $sudahBayar)
            ->get()
            ->map(fn($s) => [
                'NIS'     => $s->nis,
                'Nama'    => $s->nama,
                'Kelas'   => $s->kelas->nama_kelas ?? '-',
                'Bulan'   => $namaBulan[$this->bulan],
                'Tahun'   => $this->tahun,
                'Status'  => 'Belum Bayar',
            ]);
    }

    public function headings(): array
    {
        return ['NIS', 'Nama', 'Kelas', 'Bulan', 'Tahun', 'Status'];
    }

    public function title(): string
    {
        return 'Tunggakan SPP';
    }
}
