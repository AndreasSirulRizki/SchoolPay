@extends('layouts.app')
@section('title', 'Dashboard Petugas')
@section('page-title', now()->translatedFormat('l, d F Y'))
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
  <div class="pg-titles">
    <h1>Selamat Datang, {{ auth()->user()->name }}.</h1>
    <p>Ikhtisar sistem untuk transaksi hari ini. Semua modul berjalan optimal.</p>
  </div>
</div>

<!-- METRIC CARDS -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
  <div class="stat-card dark">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px">
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:rgba(255,255,255,.4)">PRIMARY METRIC</div>
      <span class="badge-green-sm">+12%</span>
    </div>
    <div style="font-size:13px;color:rgba(255,255,255,.5);margin-bottom:4px">Total Transaksi Hari Ini</div>
    <div style="font-size:40px;font-weight:800;color:#fff;letter-spacing:-2px">{{ $jumlahHariIni }}</div>
    <div style="font-size:12px;color:rgba(255,255,255,.4);margin-top:4px">Rp {{ number_format($totalHariIni,0,',','.') }}</div>
    <a href="{{ route('petugas.history') }}" style="display:inline-block;margin-top:12px;padding:7px 14px;background:rgba(255,255,255,.1);border-radius:8px;font-size:12px;color:#fff;text-decoration:none">View Detailed Report</a>
  </div>
  <div class="stat-card">
    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;margin-bottom:12px">IMPACT OVERVIEW</div>
    <div style="font-size:13px;color:#475569;margin-bottom:4px">Jumlah Siswa Terlayani</div>
    <div style="font-size:40px;font-weight:800;color:#0d1b3e;letter-spacing:-2px">{{ $hariIni->count() }}</div>
    <div style="font-size:12px;color:#94a3b8;margin-top:4px">Out of {{ $totalSiswa }} students registered</div>
  </div>
</div>

<!-- RECENT ACTIVITY FEED -->
<div class="table-card" style="margin-bottom:16px">
  <div class="tc-header">
    <div>
      <div class="tc-title">Recent Activity Feed</div>
      <div class="tc-sub">Last 5 transactions handled by you.</div>
    </div>
    <a href="{{ route('petugas.history') }}" style="font-size:12px;color:#2563eb;text-decoration:none">History Pembayaran →</a>
  </div>
  <div style="padding:16px;display:flex;flex-direction:column;gap:10px">
    @forelse($recentActivity as $t)
    <div style="display:flex;align-items:center;gap:12px;padding:10px;background:#f8fafc;border-radius:10px">
      <div style="width:36px;height:36px;border-radius:50%;background:#2563eb;display:grid;place-items:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0">{{ strtoupper(substr($t->siswa->nama??'?',0,1)) }}</div>
      <div style="flex:1">
        <div style="font-weight:600;font-size:13px">{{ $t->siswa->nama ?? '-' }}</div>
        <div style="font-size:11px;color:#94a3b8">{{ $t->siswa->kelas->nama_kelas ?? '-' }} · {{ $t->nama_bulan }} {{ $t->tahun }}</div>
      </div>
      <div style="text-align:right">
        <div style="font-weight:700;font-size:13px;color:#2563eb">Rp {{ number_format($t->total_bayar,0,',','.') }}</div>
        <span class="badge badge-{{ $t->status }}" style="font-size:9px">{{ strtoupper($t->status) }}</span>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:20px;color:#94a3b8;font-size:13px">Belum ada aktivitas hari ini.</div>
    @endforelse
  </div>
</div>

<!-- CTA BANNER -->
<div class="stat-card dark">
  <div style="display:flex;align-items:center;justify-content:space-between">
    <div>
      <div style="font-size:24px;margin-bottom:8px">💳</div>
      <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:4px">Need to process a new payment?</div>
      <div style="font-size:12px;color:rgba(255,255,255,.5)">Access the transaction entry module quickly.</div>
    </div>
    <a href="{{ route('petugas.transaksi') }}" class="btn-outline" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;white-space:nowrap">Go to Entry Transaksi →</a>
  </div>
</div>
@endsection
