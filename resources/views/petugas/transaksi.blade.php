@extends('layouts.app')
@section('title', 'Entry Transaksi')
@section('page-title', 'Entry Transaksi')
@section('sidebar-role', 'STAFF PORTAL')
@section('sidebar-nav')
@php $cur = request()->route()?->getName() ?? ''; @endphp
<a href="{{ route('petugas.dashboard') }}" class="nav-item {{ $cur === 'petugas.dashboard' ? 'active' : '' }}"><span class="nav-icon">📊</span> Dashboard</a>
<a href="{{ route('petugas.transaksi') }}" class="nav-item {{ $cur === 'petugas.transaksi' ? 'active' : '' }}"><span class="nav-icon">📝</span> Entry Transaksi</a>
<a href="{{ route('petugas.history') }}" class="nav-item {{ $cur === 'petugas.history' ? 'active' : '' }}"><span class="nav-icon">📋</span> History Pembayaran</a>
<a href="{{ route('petugas.profile') }}" class="nav-item {{ $cur === 'petugas.profile' ? 'active' : '' }}"><span class="nav-icon">⚙️</span> Profil Saya</a>
@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles"><h1>Entry Transaksi</h1><p>Proses pembayaran SPP siswa</p></div>
</div>

<!-- SEARCH BAR -->
<div class="table-card" style="margin-bottom:20px">
  <div style="padding:20px">
    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#475569;display:block;margin-bottom:8px">Cari Siswa</label>
    <div style="position:relative">
      <input type="text" id="searchSiswa" class="form-control" placeholder="Search by NISN (e.g. 0054321098)" autocomplete="off" style="padding-left:36px">
      <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8">🔍</span>
    </div>
    <div id="searchDropdown" style="display:none;border:1px solid #e2e8f0;border-radius:10px;margin-top:6px;background:#fff;box-shadow:0 8px 24px rgba(0,0,0,.1)"></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:320px 1fr;gap:20px" id="mainContent" style="display:none">
  <div>
    <!-- STUDENT CARD -->
    <div class="table-card" id="studentCard" style="display:none;margin-bottom:16px">
      <div style="padding:18px">
        <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#059669;background:#dcfce7;padding:3px 10px;border-radius:20px">ACTIVE STUDENT</span>
        <div style="margin-top:14px">
          <div id="sNama" style="font-size:16px;font-weight:700"></div>
          <div id="sKelas" style="font-size:12px;color:#94a3b8;margin-top:2px"></div>
          <div id="sNis" style="font-size:12px;color:#94a3b8"></div>
          <div style="margin-top:12px;padding:10px;background:#f0f4f8;border-radius:8px">
            <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px">TAGIHAN TERSISA</div>
            <div id="sTagihan" style="font-size:18px;font-weight:800;color:#0d1b3e;margin-top:2px"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- PANDUAN -->
    <div class="stat-card dark">
      <div style="font-size:12px;font-weight:700;color:#fff;margin-bottom:6px">Panduan Pembayaran</div>
      <div style="font-size:11px;color:rgba(255,255,255,.5);line-height:1.6">Pastikan jumlah bayar sesuai dengan nominal tagihan per bulan untuk menghindari selisih data pada laporan bulanan.</div>
    </div>
  </div>

  <!-- FORM -->
  <div class="table-card" id="paymentForm" style="display:none">
    <div class="tc-header"><div class="tc-title">Formulir Pembayaran</div></div>
    <div style="padding:24px">
      <form method="POST" action="{{ route('petugas.transaksi.store') }}" id="formPetugas">
        @csrf
        <input type="hidden" id="siswaId" name="siswa_id">
        <div class="form-row" style="margin-bottom:16px">
          <div class="form-group" style="margin-bottom:0">
            <label>Bulan Dibayar</label>
            <select name="bulan" class="form-control">
              @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
              <option value="{{ $i+1 }}" {{ ($i+1) == now()->month ? 'selected' : '' }}>{{ $b }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label>Tahun Dibayar</label>
            <input type="number" name="tahun" class="form-control" value="{{ now()->year }}">
          </div>
        </div>
        <div class="form-group">
          <label>Jumlah Bayar (Rp)</label>
          <input type="number" name="jumlah_bayar" id="jumlahBayar" class="form-control" placeholder="150000">
          <div style="font-size:11px;color:#94a3b8;margin-top:4px">*Pastikan nominal sudah termasuk kode unik jika ada.</div>
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:13px;font-size:14px">✓ Proses Pembayaran</button>
        <div style="margin-top:12px;padding:12px;background:#f0f4f8;border-radius:10px;font-size:12px;color:#475569">
          <strong>Verifikasi Real-time</strong> — Data transaksi akan langsung diperbarui di dashboard siswa segera setelah tombol proses ditekan.
        </div>
      </form>
    </div>
  </div>
</div>

<!-- RECENT ACTIVITY -->
@if($recentTransaksi->count())
<div style="margin-top:20px">
  <div style="font-size:14px;font-weight:700;margin-bottom:12px">Aktivitas Terakhir</div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
    @foreach($recentTransaksi as $t)
    <div class="stat-card">
      <div style="font-size:11px;color:#94a3b8;margin-bottom:6px">{{ \Carbon\Carbon::parse($t->created_at)->format('H:i · d/m/Y') }}</div>
      <div style="font-weight:700;font-size:13px">{{ $t->siswa->nama ?? '-' }}</div>
      <div style="font-size:12px;color:#2563eb;font-weight:700;margin-top:4px">Rp {{ number_format($t->total_bayar,0,',','.') }}</div>
      <span class="badge badge-{{ $t->status }}" style="margin-top:6px;font-size:9px">{{ strtoupper($t->status) }}</span>
    </div>
    @endforeach
  </div>
</div>
@endif
@endsection
@section('scripts')
<script>
let timer;
document.getElementById('searchSiswa').addEventListener('input', function() {
  clearTimeout(timer);
  const q = this.value.trim();
  const dd = document.getElementById('searchDropdown');
  if (q.length < 2) { dd.style.display = 'none'; return; }
  timer = setTimeout(() => {
    fetch(`{{ route('petugas.cari-siswa') }}?q=${encodeURIComponent(q)}`, { headers: {'X-Requested-With':'XMLHttpRequest'} })
      .then(r => r.json()).then(data => {
        if (!data.length) { dd.innerHTML = '<div style="padding:12px 16px;color:#94a3b8;font-size:13px">Tidak ditemukan</div>'; dd.style.display = 'block'; return; }
        dd.innerHTML = data.map(s => `<div onclick="selectSiswa(${JSON.stringify(s).replace(/"/g,'&quot;')})" style="padding:10px 16px;cursor:pointer;border-bottom:1px solid #f1f5f9">
          <div style="font-weight:600;font-size:13px">${s.nama}</div>
          <div style="font-size:11px;color:#94a3b8">${s.nis} · ${s.kelas}</div>
        </div>`).join('');
        dd.style.display = 'block';
      });
  }, 300);
});
function selectSiswa(s) {
  document.getElementById('searchDropdown').style.display = 'none';
  document.getElementById('searchSiswa').value = s.nama;
  document.getElementById('siswaId').value = s.id;
  document.getElementById('sNama').textContent = s.nama;
  document.getElementById('sKelas').textContent = s.kelas;
  document.getElementById('sNis').textContent = 'NIS: ' + s.nis;
  document.getElementById('sTagihan').textContent = 'Rp ' + (s.tagihan_tersisa||0).toLocaleString('id-ID');
  document.getElementById('jumlahBayar').value = s.nominal_spp || 150000;
  document.getElementById('studentCard').style.display = 'block';
  document.getElementById('paymentForm').style.display = 'block';
  document.getElementById('mainContent').style.display = 'grid';
}
</script>
@endsection
