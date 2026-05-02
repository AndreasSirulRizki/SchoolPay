@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('show-search', true)
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles">
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan sistem hari ini.</p>
  </div>
  <div style="display:flex;gap:10px">
    <a href="{{ route('admin.transaksi.index') }}" class="btn-primary">+ Transaksi Baru</a>
  </div>
</div>

<!-- STAT CARDS -->
<div class="stats-grid-4">
  <div class="stat-card">
    <div style="display:flex;justify-content:space-between;align-items:flex-start">
      <div class="sc-icon sc-i-blue">🎓</div>
      <span class="badge-green-sm">+12%</span>
    </div>
    <div class="sc-val">{{ $totalSiswa }}</div>
    <div class="sc-label">Total Students</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-green">👤</div>
    <div class="sc-val">{{ $activeStaff }}</div>
    <div class="sc-label">Active Staff</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-amber">🏫</div>
    <div class="sc-val">{{ $totalKelas }}</div>
    <div class="sc-label">Total Classes</div>
  </div>
  <div class="stat-card dark">
    <div class="sc-icon sc-i-dark">💵</div>
    <div class="sc-val" style="font-size:20px">Rp {{ number_format($monthlyRevenue/1000000, 1) }}M</div>
    <div class="sc-label">Monthly Revenue</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:20px">
  <div>
    <!-- REVENUE TRENDS CHART -->
    <div class="table-card" style="margin-bottom:20px">
      <div class="tc-header">
        <div>
          <div class="tc-title">Revenue Trends</div>
          <div class="tc-sub">Ikhtisar pengumpulan SPP tahun akademik ini</div>
        </div>
        <div style="display:flex;gap:6px">
          <button class="pill-btn" id="btn6m" onclick="switchChart('6m')">6 Months</button>
          <button class="pill-btn active" id="btnYearly" onclick="switchChart('yearly')">Yearly</button>
        </div>
      </div>
      <div style="padding:20px"><canvas id="chartRevenue" height="100"></canvas></div>
    </div>

    <!-- RECENT TRANSACTIONS -->
    <div class="table-card">
      <div class="tc-header">
        <div class="tc-title">Recent Transactions</div>
        <a href="{{ route('admin.history.index') }}" style="font-size:12px;color:#2563eb;text-decoration:none">View All Transactions →</a>
      </div>
      <table class="dt">
        <thead><tr>
          <th>Student Name</th><th>Class</th><th>Month Paid</th>
          <th>Amount</th><th>Date</th><th>Status</th>
        </tr></thead>
        <tbody>
          @forelse($transaksiTerbaru as $t)
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                <div style="width:32px;height:32px;border-radius:50%;background:#2563eb;display:grid;place-items:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0">{{ strtoupper(substr($t->siswa->nama??'?',0,1)) }}</div>
                <div>
                  <div style="font-weight:600;font-size:13px">{{ $t->siswa->nama ?? '-' }}</div>
                  <div style="font-size:11px;color:#94a3b8">{{ $t->siswa->nisn ?? $t->siswa->nis ?? '-' }}</div>
                </div>
              </div>
            </td>
            <td style="font-size:12px">{{ $t->siswa->kelas->nama_kelas ?? '-' }}</td>
            <td style="font-size:12px">{{ $t->nama_bulan }}</td>
            <td style="font-weight:700;color:#2563eb">Rp {{ number_format($t->total_bayar,0,',','.') }}</td>
            <td style="font-size:12px">{{ \Carbon\Carbon::parse($t->tanggal_bayar)->format('d/m/Y') }}</td>
            <td><span class="badge badge-{{ $t->status }}">{{ strtoupper($t->status) }}</span></td>
          </tr>
          @empty
          <tr><td colspan="6" class="empty-cell">@include('partials.empty-state', ['msg'=>'Belum ada transaksi'])</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div>
    <!-- QUICK ACTIONS -->
    <div class="table-card" style="margin-bottom:16px">
      <div class="tc-header"><div class="tc-title">Quick Actions</div></div>
      <div style="padding:16px;display:flex;flex-direction:column;gap:10px">
        <a href="{{ route('admin.transaksi.index') }}" class="quick-action-btn">
          <span>➕</span> New Transaction
        </a>
        <a href="{{ route('admin.siswa.index') }}?modal=add" class="quick-action-btn">
          <span>👤</span> Register Student
        </a>
        <a href="{{ route('admin.history.index') }}" class="quick-action-btn">
          <span>📄</span> Monthly Report
        </a>
      </div>
    </div>

    <!-- DATA STATUS -->
    <div class="stat-card dark">
      <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:8px">Data Status</div>
      <div style="font-size:13px;font-weight:600;color:#fff;margin-bottom:4px">Database integrity is healthy.</div>
      <div style="font-size:11px;color:rgba(255,255,255,.4)">Last backup: 2 hours ago</div>
    </div>
  </div>
</div>

<!-- FAB -->
<button class="fab" onclick="document.querySelector('.quick-action-btn').click()" title="New Transaction">+</button>
@endsection
@section('scripts')
<script>
const yearlyData = @json($yearlyData);
const sixMonthData = @json($sixMonthData);
let chart;
function buildChart(data) {
  const ctx = document.getElementById('chartRevenue').getContext('2d');
  if (chart) chart.destroy();
  chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: data.map(d => d.bulan),
      datasets: [{ label: 'Pendapatan', data: data.map(d => d.total),
        backgroundColor: '#2563eb', borderRadius: 6, borderSkipped: false }]
    },
    options: { responsive: true, plugins: { legend: { display: false } },
      scales: { y: { ticks: { callback: v => 'Rp ' + (v/1000000).toFixed(1) + 'M' } } } }
  });
}
function switchChart(mode) {
  document.getElementById('btn6m').classList.toggle('active', mode==='6m');
  document.getElementById('btnYearly').classList.toggle('active', mode==='yearly');
  buildChart(mode === '6m' ? sixMonthData : yearlyData);
}
buildChart(yearlyData);
</script>
@endsection
