@php $cur = request()->route()?->getName() ?? ''; @endphp
<a href="{{ route('admin.dashboard') }}" class="nav-item {{ str_starts_with($cur,'admin.dashboard') ? 'active' : '' }}">
  <span class="nav-icon">📊</span> Dashboard
</a>
<a href="{{ route('admin.petugas.index') }}" class="nav-item {{ str_starts_with($cur,'admin.petugas') ? 'active' : '' }}">
  <span class="nav-icon">👤</span> Data Petugas
</a>
<a href="{{ route('admin.siswa.index') }}" class="nav-item {{ str_starts_with($cur,'admin.siswa') ? 'active' : '' }}">
  <span class="nav-icon">🎓</span> Data Siswa
</a>
<a href="{{ route('admin.kelas.index') }}" class="nav-item {{ str_starts_with($cur,'admin.kelas') ? 'active' : '' }}">
  <span class="nav-icon">🏫</span> Data Kelas
</a>
<a href="{{ route('admin.spp.index') }}" class="nav-item {{ str_starts_with($cur,'admin.spp') ? 'active' : '' }}">
  <span class="nav-icon">💰</span> Data SPP
</a>
<a href="{{ route('admin.transaksi.index') }}" class="nav-item {{ str_starts_with($cur,'admin.transaksi') ? 'active' : '' }}">
  <span class="nav-icon">📝</span> Entry Transaksi
</a>
<a href="{{ route('admin.history.index') }}" class="nav-item {{ str_starts_with($cur,'admin.history') ? 'active' : '' }}">
  <span class="nav-icon">📋</span> History Pembayaran
</a>
<a href="{{ route('admin.profile') }}" class="nav-item {{ str_starts_with($cur,'admin.profile') ? 'active' : '' }}">
  <span class="nav-icon">⚙️</span> Profil Saya
</a>
