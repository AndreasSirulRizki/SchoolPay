<div style="font-family:Arial,sans-serif">
  <div style="text-align:center;margin-bottom:20px;border-bottom:2px solid #0d1b3e;padding-bottom:16px">
    <div style="font-size:16px;font-weight:bold">SMKN 7 BALEENDAH</div>
    <div style="font-size:12px;color:#64748b">Jl. Raya Baleendah, Kab. Bandung · Telp. (022) 5940-XXX</div>
    <div style="font-size:14px;font-weight:bold;margin-top:10px">LAPORAN PEMBAYARAN SUMBANGAN PEMBINAAN PENDIDIKAN</div>
    <div style="font-size:12px">Periode: {{ $namaBulan[$bulan] }} {{ $tahun }}</div>
  </div>
  <table style="width:100%;border-collapse:collapse;font-size:12px">
    <thead>
      <tr style="background:#0d1b3e;color:#fff">
        <th style="padding:8px;text-align:left">No</th>
        <th style="padding:8px;text-align:left">Tanggal</th>
        <th style="padding:8px;text-align:left">NISN</th>
        <th style="padding:8px;text-align:left">Nama Siswa</th>
        <th style="padding:8px;text-align:left">Kelas</th>
        <th style="padding:8px;text-align:left">Bulan/Tahun</th>
        <th style="padding:8px;text-align:right">Jumlah</th>
        <th style="padding:8px;text-align:left">Petugas</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pembayaran as $i => $p)
      <tr style="border-bottom:1px solid #e2e8f0">
        <td style="padding:8px">{{ $i+1 }}</td>
        <td style="padding:8px">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
        <td style="padding:8px">{{ $p->siswa->nisn ?? '-' }}</td>
        <td style="padding:8px">{{ $p->siswa->nama ?? '-' }}</td>
        <td style="padding:8px">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
        <td style="padding:8px">{{ $p->nama_bulan }} {{ $p->tahun }}</td>
        <td style="padding:8px;text-align:right">Rp {{ number_format($p->total_bayar,0,',','.') }}</td>
        <td style="padding:8px">{{ $p->petugas->name ?? '-' }}</td>
      </tr>
      @empty
      <tr><td colspan="8" style="padding:20px;text-align:center;color:#94a3b8">Tidak ada data</td></tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr style="background:#f0f4f8;font-weight:bold">
        <td colspan="6" style="padding:10px;text-align:right">TOTAL PENDAPATAN</td>
        <td style="padding:10px;text-align:right;color:#0d1b3e">Rp {{ number_format($total,0,',','.') }}</td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</div>
