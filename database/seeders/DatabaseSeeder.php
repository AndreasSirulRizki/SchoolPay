<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Petugas;
use App\Models\PembayaranSpp;
use App\Models\Siswa;
use App\Models\TarifSpp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'email'    => 'admin@smkn7baleendah.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        $petugasUser = User::create([
            'name'     => 'Petugas SPP',
            'username' => 'petugas',
            'email'    => 'petugas@smkn7baleendah.sch.id',
            'password' => Hash::make('petugas123'),
            'role'     => 'petugas',
        ]);

        Petugas::create([
            'user_id' => $petugasUser->id,
            'nip'     => '198501012010011001',
            'jabatan' => 'Bendahara SPP',
            'no_hp'   => '081234567890',
        ]);

        $kelas = [
            ['nama_kelas' => 'X RPL 1',   'tingkat' => 'X',   'jurusan' => 'Rekayasa Perangkat Lunak',  'wali_kelas' => 'Budi Santoso, S.Kom'],
            ['nama_kelas' => 'X RPL 2',   'tingkat' => 'X',   'jurusan' => 'Rekayasa Perangkat Lunak',  'wali_kelas' => 'Siti Rahayu, S.Pd'],
            ['nama_kelas' => 'XI RPL 1',  'tingkat' => 'XI',  'jurusan' => 'Rekayasa Perangkat Lunak',  'wali_kelas' => 'Ahmad Fauzi, S.T'],
            ['nama_kelas' => 'XI TKJ 1',  'tingkat' => 'XI',  'jurusan' => 'Teknik Komputer Jaringan',  'wali_kelas' => 'Dewi Lestari, S.Kom'],
            ['nama_kelas' => 'XII RPL 1', 'tingkat' => 'XII', 'jurusan' => 'Rekayasa Perangkat Lunak',  'wali_kelas' => 'Hendra Wijaya, S.T'],
            ['nama_kelas' => 'XII TKJ 1', 'tingkat' => 'XII', 'jurusan' => 'Teknik Komputer Jaringan',  'wali_kelas' => 'Rina Susanti, S.Pd'],
        ];
        foreach ($kelas as $k) Kelas::create($k);

        $siswaSample = [
            ['nis' => '2024001', 'nisn' => '0012345001', 'nama' => 'Andi Pratama',    'kelas_id' => 1, 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Merdeka No. 1',    'no_hp' => '081111111111'],
            ['nis' => '2024002', 'nisn' => '0012345002', 'nama' => 'Budi Setiawan',   'kelas_id' => 1, 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Pahlawan No. 5',   'no_hp' => '082222222222'],
            ['nis' => '2024003', 'nisn' => '0012345003', 'nama' => 'Citra Dewi',      'kelas_id' => 2, 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Sudirman No. 10',  'no_hp' => '083333333333'],
            ['nis' => '2024004', 'nisn' => '0012345004', 'nama' => 'Dian Permata',    'kelas_id' => 2, 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Diponegoro No. 3', 'no_hp' => '084444444444'],
            ['nis' => '2024005', 'nisn' => '0012345005', 'nama' => 'Eko Saputra',     'kelas_id' => 3, 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Ahmad Yani No. 7', 'no_hp' => '085555555555'],
            ['nis' => '2024006', 'nisn' => '0012345006', 'nama' => 'Fitri Handayani', 'kelas_id' => 3, 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Gatot Subroto',    'no_hp' => '086666666666'],
            ['nis' => '2024007', 'nisn' => '0012345007', 'nama' => 'Gilang Ramadhan', 'kelas_id' => 4, 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Veteran No. 8',    'no_hp' => '087777777777'],
            ['nis' => '2024008', 'nisn' => '0012345008', 'nama' => 'Hani Safitri',    'kelas_id' => 4, 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Kartini No. 4',    'no_hp' => '088888888888'],
            ['nis' => '2024009', 'nisn' => '0012345009', 'nama' => 'Irfan Maulana',   'kelas_id' => 5, 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Imam Bonjol No. 6','no_hp' => '089999999999'],
            ['nis' => '2024010', 'nisn' => '0012345010', 'nama' => 'Juwita Sari',     'kelas_id' => 6, 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Hasanuddin No. 9', 'no_hp' => '081000000000'],
        ];

        $siswaModels = [];
        foreach ($siswaSample as $s) {
            $siswaModels[] = Siswa::create(array_merge($s, [
                'password' => Hash::make($s['nis']),
                'status'   => 'active',
            ]));
        }

        // Tarif per siswa (150.000 default)
        foreach ($siswaModels as $s) {
            TarifSpp::create([
                'siswa_id'     => $s->id,
                'nominal'      => 150000,
                'tahun_ajaran' => '2024/2025',
                'is_aktif'     => true,
            ]);
        }

        // Pembayaran sample
        $tarif1 = TarifSpp::where('siswa_id', $siswaModels[0]->id)->first();
        foreach ([1, 2, 3, 4, 5] as $bulan) {
            PembayaranSpp::create([
                'no_transaksi' => 'SPP-2025' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-0001',
                'siswa_id'     => $siswaModels[0]->id,
                'tarif_id'     => $tarif1->id,
                'bulan'        => $bulan,
                'tahun'        => 2025,
                'tanggal_bayar'=> "2025-{$bulan}-10",
                'jumlah_bayar' => 150000,
                'biaya_admin'  => 2500,
                'total_bayar'  => 152500,
                'metode_bayar' => 'tunai',
                'petugas_id'   => $petugasUser->id,
                'status'       => 'lunas',
            ]);
        }

        foreach ([1, 2, 3] as $idx) {
            $s = $siswaModels[$idx];
            $tarif = TarifSpp::where('siswa_id', $s->id)->first();
            foreach ([1, 2, 3] as $bulan) {
                PembayaranSpp::create([
                    'no_transaksi' => 'SPP-2025' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . str_pad(($idx + 1) * 10, 4, '0', STR_PAD_LEFT),
                    'siswa_id'     => $s->id,
                    'tarif_id'     => $tarif->id,
                    'bulan'        => $bulan,
                    'tahun'        => 2025,
                    'tanggal_bayar'=> "2025-{$bulan}-15",
                    'jumlah_bayar' => 150000,
                    'biaya_admin'  => 2500,
                    'total_bayar'  => 152500,
                    'metode_bayar' => 'tunai',
                    'petugas_id'   => $petugasUser->id,
                    'status'       => 'lunas',
                ]);
            }
        }
    }
}
