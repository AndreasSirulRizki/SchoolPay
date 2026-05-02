@extends('layouts.student')
@section('title', 'Dashboard Siswa')
@section('content')
<div class="pg-header">
  <div class="pg-titles">
    <h1>Selamat Datang, {{ $siswa->nama }}.</h1>
    <p>Update terakhir: {{ now()->translatedFormat('d F Y') }}</p>
  </div>
  <a href="{{ route('siswa.history') }}" class="btn-outline">🖨️ Print History</a>
</div>

<!-- STAT CARDS -->
<div class="stats-grid-3">
  <div class="stat-card">
    <div class="sc-icon sc-i-blue">💰</div>
    <div class="sc-val" style="font-size:18px">Rp {{ number_format($totalTagihan,0,',','.') }}</div>
    <div class="sc-label">Total Tagihan Tahun Ini</div>
    <div style="margin-top:10px;background:#e2e8f0;border-radius:4px;height:6px;overflow:hidden">
      <div style="height:100%;background:#2563eb;width:{{ $totalTagihan > 0 ? round(($totalBayar/$totalTagihan)*100) : 0 }}%;border-radius:4px"></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-green">✅</div>
    <div class="sc-val" style="font-size:18px">Rp {{ number_format($totalBayar,0,',','.') }}</div>
    <div class="sc-label">Total Sudah Dibayar</div>
    <div style="font-size:11px;color:#059669;margin-top:6px">{{ $totalTagihan > 0 ? round(($totalBayar/$totalTagihan)*100) : 0 }}% pencapaian</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon {{ $statusBulanIni === 'lunas' ? 'sc-i-green' : 'sc-i-amber' }}">{{ $statusBulanIni === 'lunas' ? '✅' : '⚠️' }}</div>
    <div style="margin-top:8px">
      <span class="badge {{ $statusBulanIni === 'lunas' ? 'badge-lunas' : 'badge-pending' }}" style="font-size:14px;padding:6px 16px">
        {{ $statusBulanIni === 'lunas' ? 'LUNAS' : 'BELUM BAYAR' }}
      </span>
    </div>
    <div class="sc-label" style="margin-top:8px">Status Bulan Ini</div>
  </div>
</div>

<!-- RECENT HISTORY -->
<div class="table-card">
  <div class="tc-header">
    <div>
      <div class="tc-title">Riwayat Pembayaran</div>
      <div class="tc-sub">Menampilkan 3 transaksi terakhir secara real-time</div>
    </div>
    <a href="{{ route('siswa.history') }}" style="font-size:12px;color:#2563eb;text-decoration:none">Lihat Semua →</a>
  </div>
  <table class="dt">
    <thead><tr><th>Tanggal Bayar</th><th>Bulan</th><th>Nominal</th><th>Status</th></tr></thead>
    <tbody>
      @forelse($recentHistory as $h)
      <tr>
        <td>
          <div style="font-weight:600;font-size:13px">{{ \Carbon\Carbon::parse($h->tanggal_bayar)->format('d/m/Y') }}</div>
          <div style="font-size:11px;color:#94a3b8">{{ $h->no_transaksi }}</div>
        </td>
        <td>{{ $h->nama_bulan }} {{ $h->tahun }}</td>
        <td style="font-weight:700;color:#2563eb">Rp {{ number_format($h->total_bayar,0,',','.') }}</td>
        <td><span class="badge badge-{{ $h->status }}">{{ strtoupper($h->status) }}</span></td>
      </tr>
      @empty
      <tr><td colspan="4" style="text-align:center;padding:32px;color:#94a3b8">
        <div style="font-size:32px;margin-bottom:8px">📄</div>
        <div style="font-weight:700;margin-bottom:4px">Belum ada riwayat pembayaran.</div>
        <div style="font-size:12px">Hubungi admin sekolah jika Anda sudah melakukan pembayaran.</div>
      </td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- FAB: Pay Tuition -->
<button class="fab" onclick="openModal('payModal')" title="Pay Tuition">🖨️</button>

<!-- PAY MODAL -->
<div class="modal-overlay" id="payModal">
  <div class="modal" style="max-width:400px">
    <div style="padding:28px;text-align:center">
      <div style="font-size:40px;margin-bottom:12px">💳</div>
      <div style="font-size:18px;font-weight:800;margin-bottom:8px">Cara Pembayaran SPP</div>
      <div style="font-size:13px;color:#475569;line-height:1.7;margin-bottom:20px">
        Pembayaran SPP dilakukan melalui petugas administrasi keuangan sekolah.<br>
        Datang ke kantor administrasi dengan membawa kartu pelajar Anda.
      </div>
      <div style="background:#f0f4f8;border-radius:10px;padding:14px;text-align:left;margin-bottom:20px">
        <div style="font-size:12px;font-weight:700;margin-bottom:6px">Jam Layanan:</div>
        <div style="font-size:12px;color:#475569">Senin - Jumat: 08:00 - 15:00 WIB</div>
      </div>
      <button onclick="document.getElementById('payModal').classList.remove('show')" class="btn-primary" style="width:100%;justify-content:center">Mengerti</button>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); }
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if (e.target === o) o.classList.remove('show'); }));
</script>
@endsection
