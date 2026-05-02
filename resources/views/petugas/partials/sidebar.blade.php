<a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
  <span class="nav-icon">📊</span> Dashboard
</a>
<a href="{{ route('petugas.transaksi') }}" class="nav-item {{ request()->routeIs('petugas.transaksi') ? 'active' : '' }}">
  <span class="nav-icon">💳</span> Entry Transaksi
</a>
<a href="{{ route('petugas.history') }}" class="nav-item {{ request()->routeIs('petugas.history') ? 'active' : '' }}">
  <span class="nav-icon">📋</span> History Pembayaran
</a>
<a href="{{ route('petugas.profile') }}" class="nav-item {{ request()->routeIs('petugas.profile') ? 'active' : '' }}">
  <span class="nav-icon">⚙️</span> Profil
</a>
