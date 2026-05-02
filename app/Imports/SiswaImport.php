<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class SiswaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row): ?Siswa
    {
        if (empty($row['nis'])) return null;

        $kelas = Kelas::where('nama_kelas', $row['kelas'] ?? '')->first();

        return new Siswa([
            'nis'           => (string) $row['nis'],
            'nisn'          => isset($row['nisn']) ? (string) $row['nisn'] : null,
            'nama'          => $row['nama'] ?? '',
            'kelas_id'      => $kelas?->id ?? 1,
            'jenis_kelamin' => strtoupper($row['jenis_kelamin'] ?? 'L'),
            'no_hp'         => $row['no_hp'] ?? null,
            'alamat'        => $row['alamat'] ?? null,
            'password'      => Hash::make((string) $row['nis']),
            'status'        => 'active',
        ]);
    }
}
