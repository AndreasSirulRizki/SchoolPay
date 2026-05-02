@extends('layouts.student')
@section('title', 'History Pembayaran')
@section('content')
<div class="pg-header">
  <div class="pg-titles"><h1>History Pembayaran</h1><p>Riwayat lengkap pembayaran SPP Anda</p></div>
  <a href="{{ route('siswa.history') }}?print=1" class="btn-outline">🖨️ Cetak Riwayat</a>
</div>

<!-- TUNGGAKAN CARD -->
@if(count($bulanTunggakan) > 0)
<div class="table-card" style="margin-bottom:20px">
  <div style="padding:20px;display:flex;align-items:center;gap:16px">
    <div style="font-size:32px">📋</div>
    <div style="flex:1">
      <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:4px">Bulan Tunggakan</div>
      <div style="font-size:12px;color:#475569;margin-bottom:8px">Total bulan yang belum dibayar</div>
      <div style="display:flex;flex-wrap:wrap;gap:6px">
        @foreach($bulanTunggakan as $b)
        <span style="background:#fef3c7;color:#92400e;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:700">{{ $b }}</span>
        @endforeach
      </div>
    </div>
    <div style="text-align:center">
      <div style="font-size:40px;font-weight:800;color:#d97706">{{ count($bulanTunggakan) }}</div>
      <div style="font-size:11px;color:#94a3b8">Bulan</div>
    </div>
  </div>
</div>
@endif

<!-- HISTORY TABLE -->
<div class="table-card">
  <div class="tc-header">
    <div class="tc-title">Detail Transaksi</div>
  </div>
  @if($history->isEmpty())
  <!-- EMPTY STATE -->
  <div style="padding:48px 24px;text-align:center">
    <div style="font-size:56px;margin-bottom:16px">🔍</div>
    <div style="font-size:20px;font-weight:800;margin-bottom:8px">Belum ada riwayat pembayaran.</div>
    <div style="font-size:13px;color:#475569;max-width:400px;margin:0 auto 20px">Hubungi admin sekolah jika Anda sudah melakukan pembayaran namun tidak muncul di sini.</div>
    <div style="display:flex;gap:10px;justify-content:center;margin-bottom:20px">
      <a href="{{ route('siswa.bantuan') }}" class="btn-primary">Hubungi Admin</a>
      <button onclick="location.reload()" class="btn-outline">Cek Kembali</button>
    </div>
    <div style="background:#f0f4f8;border-radius:10px;padding:14px;max-width:400px;margin:0 auto;text-align:left">
      <div style="font-size:12px;font-weight:700;margin-bottom:6px">ℹ️ Informasi Verifikasi</div>
      <div style="font-size:12px;color:#475569;line-height:1.6">Pembayaran via transfer bank memerlukan waktu verifikasi manual sekitar 1×24 jam kerja. Harap simpan bukti bayar Anda.</div>
      <div style="font-size:12px;color:#475569;margin-top:6px">Jam layanan admin: Senin - Jumat, 08:00 - 15:00 WIB</div>
    </div>
  </div>
  @else
  <table class="dt">
    <thead><tr><th>Tanggal Bayar</th><th>Bulan</th><th>Tahun</th><th>Nominal</th><th>Status</th><th>Kwitansi</th></tr></thead>
    <tbody>
      @foreach($history as $h)
      <tr>
        <td style="font-size:12px">{{ \Carbon\Carbon::parse($h->tanggal_bayar)->format('d/m/Y') }}</td>
        <td>{{ $h->nama_bulan }}</td>
        <td>{{ $h->tahun }}</td>
        <td style="font-weight:700;color:#2563eb">Rp {{ number_format($h->total_bayar,0,',','.') }}</td>
        <td><span class="badge badge-{{ $h->status }}">✓ {{ strtoupper($h->status) }}</span></td>
        <td><a href="{{ route('siswa.kwitansi', $h) }}" style="font-size:12px;color:#2563eb;text-decoration:none">📄 PDF</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="pagination-info">
    {{ $history->links() }}
    @if($history->hasMorePages())
    <a href="{{ $history->nextPageUrl() }}" style="font-size:12px;color:#2563eb;text-decoration:none;margin-left:8px">Tampilkan Lebih Banyak</a>
    @endif
  </div>
  @endif
</div>

<!-- MOTIVATIONAL QUOTE -->
<div style="text-align:center;padding:20px;color:#94a3b8;font-size:13px;font-style:italic">
  "Investasi dalam pengetahuan selalu memberikan bunga yang terbaik."
</div>
@endsection
