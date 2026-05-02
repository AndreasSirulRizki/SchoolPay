@extends('layouts.app')
@section('title', 'Laporan SPP')
@section('page-title', 'Laporan SPP')
@section('show-search', true)
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
@php
$namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
@endphp
<div class="pg-header">
  <div class="pg-titles">
    <h1>Laporan Pembayaran SPP</h1>
    <p>Rekap pembayaran SPP per bulan, kelas, dan tahun ajaran.</p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="btn-primary" style="font-size:12px;padding:8px 14px">📥 PDF Transaksi</a>
    <div style="position:relative" id="pdfSiswaWrap">
      <button type="button" onclick="document.getElementById('pdfSiswaMenu').classList.toggle('show')" class="btn-outline" style="font-size:12px;padding:8px 14px">🎓 PDF Siswa ▾</button>
      <div id="pdfSiswaMenu" style="display:none;position:absolute;top:calc(100% + 6px);right:0;background:#fff;border:1px solid #e2e8f0;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:50;min-width:180px;overflow:hidden">
        <a href="{{ route('admin.laporan.pdf-siswa', ['periode'=>'hari_ini']) }}" style="display:block;padding:10px 16px;font-size:13px;color:#0d1b3e;text-decoration:none;transition:.1s" onmouseover="this.style.background='#f0f4f8'" onmouseout="this.style.background=''">📅 Hari Ini</a>
        <a href="{{ route('admin.laporan.pdf-siswa', ['periode'=>'bulan','bulan'=>request('bulan',now()->month),'tahun'=>request('tahun',now()->year)]) }}" style="display:block;padding:10px 16px;font-size:13px;color:#0d1b3e;text-decoration:none;transition:.1s" onmouseover="this.style.background='#f0f4f8'" onmouseout="this.style.background=''">📆 Bulan Ini ({{ now()->translatedFormat('F Y') }})</a>
        <a href="{{ route('admin.laporan.pdf-siswa', ['periode'=>'tahun','tahun'=>request('tahun',now()->year)]) }}" style="display:block;padding:10px 16px;font-size:13px;color:#0d1b3e;text-decoration:none;transition:.1s" onmouseover="this.style.background='#f0f4f8'" onmouseout="this.style.background=''">🗓️ Tahun Ini ({{ now()->year }})</a>
      </div>
    </div>
    <a href="{{ route('admin.laporan.excel', request()->query()) }}" class="btn-outline" style="font-size:12px;padding:8px 14px">📊 Excel</a>
    <a href="{{ route('admin.laporan.excel-siswa') }}" class="btn-outline" style="font-size:12px;padding:8px 14px">🎓 Excel Siswa</a>
  </div>
</div>

<div class="table-card" style="margin-bottom:20px">
  <div style="padding:16px">
    <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
      <select name="periode" class="form-control" style="width:140px;padding:8px 12px" onchange="togglePeriode(this.value)">
        <option value="bulan" {{ ($periode??'bulan')==='bulan'?'selected':'' }}>Per Bulan</option>
        <option value="hari_ini" {{ ($periode??'')==='hari_ini'?'selected':'' }}>Hari Ini</option>
        <option value="semua" {{ ($periode??'')==='semua'?'selected':'' }}>Semua Data</option>
      </select>
      <span id="wrap-bulan-tahun" style="{{ in_array($periode??'bulan',['hari_ini','semua'])?'display:none':'display:flex' }};gap:10px">
        <select name="bulan" class="form-control" style="width:140px;padding:8px 12px">
          @for($m=1;$m<=12;$m++)
          <option value="{{ $m }}" {{ $bulan==$m?'selected':'' }}>{{ $namaBulan[$m] }}</option>
          @endfor
        </select>
        <select name="tahun" class="form-control" style="width:100px;padding:8px 12px">
          @for($y=date('Y');$y>=date('Y')-3;$y--)
          <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>
          @endfor
        </select>
      </span>
      <select name="kelas_id" class="form-control" style="width:150px;padding:8px 12px">
        <option value="">Semua Kelas</option>
        @foreach($kelas as $k)
        <option value="{{ $k->id }}" {{ $kelas_id==$k->id?'selected':'' }}>{{ $k->nama_kelas }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-primary" style="padding:8px 16px">Filter</button>
    </form>
  </div>
</div>

<div class="stats-grid-3">
  <div class="stat-card dark">
    <div class="sc-icon sc-i-dark">💵</div>
    <div class="sc-val" style="font-size:20px">Rp {{ number_format($totalPendapatan,0,',','.') }}</div>
    <div class="sc-label">Total Pendapatan</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-blue">📋</div>
    <div class="sc-val">{{ $totalTransaksi }}</div>
    <div class="sc-label">Jumlah Transaksi</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-green">📅</div>
    <div class="sc-val" style="font-size:18px">
      @if(($periode??'bulan')==='hari_ini') Hari Ini
      @elseif(($periode??'bulan')==='semua') Semua Data
      @else {{ $namaBulan[$bulan] }} {{ $tahun }}
      @endif
    </div>
    <div class="sc-label">Periode</div>
  </div>
</div>

<div class="table-card">
  <div class="tc-header">
    <div class="tc-title">Rekap Pembayaran —
      @if(($periode??'bulan')==='hari_ini') Hari Ini
      @elseif(($periode??'bulan')==='semua') Semua Data
      @else {{ $namaBulan[$bulan] }} {{ $tahun }}
      @endif
    </div>
    <div class="tc-sub">{{ $pembayaran->total() }} transaksi ditemukan</div>
  </div>
  <table class="dt">
    <thead><tr>
      <th>No. Transaksi</th><th>Siswa</th><th>Kelas</th><th>Bulan</th>
      <th>Jumlah</th><th>Metode</th><th>Petugas</th><th>Tgl Bayar</th><th>Status</th>
    </tr></thead>
    <tbody>
      @forelse($pembayaran as $p)
      <tr>
        <td style="font-size:11px;font-family:monospace">{{ $p->no_transaksi }}</td>
        <td>{{ $p->siswa->nama ?? '-' }}</td>
        <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
        <td>{{ $p->nama_bulan }} {{ $p->tahun }}</td>
        <td style="font-weight:700;color:#2563eb">Rp {{ number_format($p->total_bayar,0,',','.') }}</td>
        <td>{{ ucfirst($p->metode_bayar) }}</td>
        <td>{{ $p->petugas->name ?? '-' }}</td>
        <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
        <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
      </tr>
      @empty
      <tr><td colspan="9">@include('partials.empty-state', ['msg'=>'Tidak ada data pembayaran untuk periode ini.'])</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="pagination-info">{{ $pembayaran->links() }}</div>
</div>
@endsection
@section('scripts')
<script>
function togglePeriode(val) {
  document.getElementById('wrap-bulan-tahun').style.display = (val === 'bulan') ? 'flex' : 'none';
}
document.addEventListener('click', function(e) {
  if (!e.target.closest('#pdfSiswaWrap')) {
    document.getElementById('pdfSiswaMenu').classList.remove('show');
    document.getElementById('pdfSiswaMenu').style.display = 'none';
  }
});
document.getElementById('pdfSiswaMenu').addEventListener('transitionend', function() {});
// override classList.toggle to also set display
(function(){
  const menu = document.getElementById('pdfSiswaMenu');
  if (!menu) return;
  const orig = menu.classList.toggle.bind(menu.classList);
  menu.classList.toggle = function(cls) {
    orig(cls);
    menu.style.display = menu.classList.contains('show') ? 'block' : 'none';
  };
})();
</script>
@endsection
