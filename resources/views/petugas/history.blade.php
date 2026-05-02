@extends('layouts.app')
@section('title', 'History Pembayaran')
@section('page-title', 'History Pembayaran')
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
  <div class="pg-titles"><h1>History Pembayaran</h1><p>Transaksi yang Anda proses</p></div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
  <div class="stat-card dark">
    <div class="sc-icon sc-i-dark">💵</div>
    <div class="sc-val" style="font-size:20px">Rp {{ number_format($totalBulanIni,0,',','.') }}</div>
    <div class="sc-label">Total Bulan Ini</div>
  </div>
  <div class="stat-card">
    <div class="sc-icon sc-i-blue">📅</div>
    <div class="sc-val" style="font-size:20px">Rp {{ number_format($totalHariIni,0,',','.') }}</div>
    <div class="sc-label">Total Hari Ini</div>
  </div>
</div>

<div class="table-card">
  <div class="tc-header">
    <div class="tc-title">Riwayat Transaksi Saya</div>
    <form method="GET" style="display:flex;gap:8px">
      <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari siswa..." style="width:180px;padding:7px 12px">
      <select name="kelas_id" class="form-control" style="width:130px;padding:7px 12px">
        <option value="">Semua Kelas</option>
        @foreach($kelas as $k)<option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>@endforeach
      </select>
      <button type="submit" class="btn-outline" style="padding:7px 12px">Filter</button>
    </form>
  </div>
  <table class="dt">
    <thead><tr><th>Tanggal</th><th>Nama Siswa</th><th>Bulan/Tahun</th><th>Jumlah</th><th>Status</th><th>Kwitansi</th></tr></thead>
    <tbody>
      @forelse($history as $h)
      <tr>
        <td style="font-size:12px">{{ \Carbon\Carbon::parse($h->tanggal_bayar)->format('d/m/Y') }}</td>
        <td>
          <div style="font-weight:600;font-size:13px">{{ $h->siswa->nama ?? '-' }}</div>
          <div style="font-size:11px;color:#94a3b8">{{ $h->siswa->kelas->nama_kelas ?? '-' }}</div>
        </td>
        <td style="font-size:12px">{{ $h->nama_bulan }} {{ $h->tahun }}</td>
        <td style="font-weight:700;color:#2563eb">Rp {{ number_format($h->total_bayar,0,',','.') }}</td>
        <td><span class="badge badge-{{ $h->status }}">{{ strtoupper($h->status) }}</span></td>
        <td><a href="{{ route('petugas.kwitansi', $h) }}" style="font-size:12px;color:#2563eb;text-decoration:none">📄 PDF</a></td>
      </tr>
      @empty
      <tr><td colspan="6">@include('partials.empty-state', ['msg'=>'Belum ada riwayat transaksi.'])</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="pagination-info">{{ $history->links() }}</div>
</div>
@endsection
