<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SiswaExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Siswa::with('kelas')->get()->map(fn($s) => [
            'NIS'           => $s->nis,
            'Nama'          => $s->nama,
            'Kelas'         => $s->kelas->nama_kelas ?? '-',
            'Jurusan'       => $s->kelas->jurusan ?? '-',
            'Jenis Kelamin' => $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            'No. HP'        => $s->no_hp ?? '-',
            'Alamat'        => $s->alamat ?? '-',
        ]);
    }

    public function headings(): array
    {
        return ['NIS', 'Nama', 'Kelas', 'Jurusan', 'Jenis Kelamin', 'No. HP', 'Alamat'];
    }

    public function title(): string
    {
        return 'Data Siswa';
    }
}
