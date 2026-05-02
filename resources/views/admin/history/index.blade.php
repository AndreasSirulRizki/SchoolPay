@extends('layouts.app')
@section('title', 'History Pembayaran')
@section('page-title', 'History Pembayaran')
@section('show-search', true)
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles">
    <h1>History Pembayaran</h1>
    <p>Riwayat seluruh transaksi pembayaran SPP</p>
  </div>
  <a href="{{ route('admin.transaksi.index') }}" class="btn-primary">+ Input Baru</a>
</div>

<!-- STAT CARDS -->
<div class="stats-grid-3">
  <div class="stat-card dark">
    <div style="display:flex;justify-content:space-between;align-items:flex-start">
      <div class="sc-icon sc-i-dark">💵</div>
      <span class="badge-green-sm">{{ $pctChange >= 0 ? '+' : '' }}{{ $pctChange }}%</span>
    </div>
    <div class="sc-val" style="font-size:20px">Rp {{ number_format($totalBulanIni/1000000,1) }}M</div>
    <div class="sc-label">Total Koleksi Bulan Ini</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-green">✅</div>
    <div class="sc-val">{{ $sudahBayarBulanIni }} / {{ $totalSiswa }}</div>
    <div class="sc-label">Siswa Sudah Bayar</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-amber">⏳</div>
    <div class="sc-val">{{ $pending }}</div>
    <div class="sc-label">Transaksi Tertunda</div>
  </div>
</div>

<!-- FILTER TABS -->
<div class="table-card">
  <div class="tc-header" style="flex-wrap:wrap;gap:12px">
    <div style="display:flex;gap:6px">
      <a href="?tab=semua" class="pill-btn {{ request('tab','semua') === 'semua' ? 'active' : '' }}">Semua</a>
      <a href="?tab=hari_ini" class="pill-btn {{ request('tab') === 'hari_ini' ? 'active' : '' }}">Hari Ini</a>
      <a href="?tab=bulan_ini" class="pill-btn {{ request('tab') === 'bulan_ini' ? 'active' : '' }}">Bulan Ini</a>
    </div>
    <div style="display:flex;gap:8px;align-items:center">
      <form method="GET" style="display:flex;gap:8px;align-items:center">
        <input type="hidden" name="tab" value="{{ request('tab','semua') }}">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari siswa..." style="width:180px;padding:7px 12px">
        <select name="kelas_id" class="form-control" style="width:130px;padding:7px 12px">
          <option value="">Semua Kelas</option>
          @foreach($kelas as $k)
          <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
          @endforeach
        </select>
        <select name="status" class="form-control" style="width:120px;padding:7px 12px">
          <option value="">Semua Status</option>
          <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
        <button type="submit" class="btn-primary" style="padding:8px 14px">Filter</button>
      </form>
      <select id="filterBulan" class="form-control" style="width:130px;padding:7px 12px">
        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $nb)
        <option value="{{ $i+1 }}" {{ now()->month == $i+1 ? 'selected' : '' }}>{{ $nb }}</option>
        @endforeach
      </select>
      <select id="filterTahun" class="form-control" style="width:90px;padding:7px 12px">
        @for($y = now()->year; $y >= now()->year - 4; $y--)
        <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
      </select>
      <button onclick="generatePreview()" class="btn-primary" style="padding:8px 14px;background:#0d1b3e">Generate Preview</button>
    </div>
  </div>

  <table class="dt">
    <thead><tr>
      <th>Tanggal Bayar</th><th>NISN</th><th>Nama Siswa</th>
      <th>Bulan/Tahun</th><th>Jumlah</th><th>Petugas</th><th>Status</th><th>Aksi</th>
    </tr></thead>
    <tbody>
      @forelse($history as $h)
      <tr>
        <td>
          <div style="font-weight:600;font-size:13px">{{ \Carbon\Carbon::parse($h->tanggal_bayar)->format('d/m/Y') }}</div>
          <div style="font-size:11px;color:#94a3b8">{{ \Carbon\Carbon::parse($h->created_at)->format('H:i') }}</div>
        </td>
        <td style="font-size:12px">{{ $h->siswa->nisn ?? '-' }}</td>
        <td>
          <div style="font-weight:600;font-size:13px">{{ $h->siswa->nama ?? '-' }}</div>
          <div style="font-size:11px;color:#94a3b8">{{ $h->siswa->kelas->nama_kelas ?? '-' }}</div>
        </td>
        <td style="font-size:12px">{{ $h->nama_bulan }} {{ $h->tahun }}</td>
        <td style="font-weight:700;color:#2563eb">Rp {{ number_format($h->total_bayar,0,',','.') }}</td>
        <td>
          <div style="display:flex;align-items:center;gap:6px">
            <div style="width:24px;height:24px;border-radius:50%;background:#0d1b3e;display:grid;place-items:center;font-size:9px;font-weight:700;color:#fff">{{ strtoupper(substr($h->petugas->name??'?',0,1)) }}</div>
            <span style="font-size:12px">{{ $h->petugas->name ?? '-' }}</span>
          </div>
        </td>
        <td><span class="badge badge-{{ $h->status }}">{{ strtoupper($h->status) }}</span></td>
        <td>
          <a href="{{ route('admin.history.pdf', ['bulan'=>$h->bulan,'tahun'=>$h->tahun]) }}" style="color:#2563eb;font-size:12px;text-decoration:none">⋮</a>
        </td>
      </tr>
      @empty
      <tr><td colspan="8">
        @include('partials.empty-state', ['msg' => 'Belum ada data transaksi.'])
      </td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="pagination-info">
    SHOWING {{ $history->firstItem() ?? 0 }} OF {{ $history->total() }} RECORDS
    &nbsp;{{ $history->links() }}
  </div>
</div>

<!-- PREVIEW LAPORAN -->
<div id="previewSection" style="display:none">
  <div class="table-card">
    <div class="tc-header">
      <div class="tc-title">Preview Laporan</div>
      <a id="exportPdfBtn" href="#" class="btn-primary" style="padding:8px 14px">Export PDF</a>
    </div>
    <div id="previewContent" style="padding:24px"></div>
  </div>
</div>
@endsection
@section('scripts')
<script>
function generatePreview() {
  const bulan = document.getElementById('filterBulan').value;
  const tahun = document.getElementById('filterTahun').value;
  fetch(`{{ route('admin.history.preview') }}?bulan=${bulan}&tahun=${tahun}`, { headers: {'X-Requested-With':'XMLHttpRequest'} })
    .then(r => r.json()).then(data => {
      document.getElementById('previewContent').innerHTML = data.html || '<p style="color:#94a3b8;text-align:center;padding:20px">Tidak ada data</p>';
      document.getElementById('exportPdfBtn').href = `{{ route('admin.history.pdf') }}?bulan=${bulan}&tahun=${tahun}`;
      document.getElementById('previewSection').style.display = 'block';
      document.getElementById('previewSection').scrollIntoView({ behavior: 'smooth' });
    });
}
</script>
@endsection
