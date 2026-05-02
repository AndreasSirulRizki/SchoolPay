@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('sidebar-role', 'STAFF PORTAL')
@section('sidebar-nav')
<a href="{{ route('petugas.dashboard') }}" class="nav-item"><span class="nav-icon">📊</span> Dashboard</a>
<a href="{{ route('petugas.transaksi') }}" class="nav-item"><span class="nav-icon">📝</span> Entry Transaksi</a>
<a href="{{ route('petugas.history') }}" class="nav-item"><span class="nav-icon">📋</span> History Pembayaran</a>
<a href="{{ route('petugas.profile') }}" class="nav-item active"><span class="nav-icon">⚙️</span> Profil Saya</a>
@endsection
@section('content')
<div style="max-width:560px">
  <div class="table-card" style="margin-bottom:16px">
    {{-- Photo Hero --}}
    <div style="padding:32px 24px 24px;text-align:center;border-bottom:1px solid #e2e8f0;background:linear-gradient(135deg,#78350f 0%,#d97706 100%);border-radius:14px 14px 0 0;">
      <div style="position:relative;display:inline-block;margin-bottom:14px;">
        <div id="avatarWrap" style="width:88px;height:88px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,.2);background:#92400e;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:800;color:#fff;cursor:pointer;" onclick="document.getElementById('fotoInput').click()">
          @if($user->foto)
            <img id="avatarImg" src="{{ asset('storage/'.$user->foto) }}" style="width:100%;height:100%;object-fit:cover;">
          @else
            <span>{{ strtoupper(substr($user->name,0,1)) }}</span>
          @endif
        </div>
        <div onclick="document.getElementById('fotoInput').click()" style="position:absolute;bottom:0;right:0;width:26px;height:26px;border-radius:50%;background:#d97706;border:2px solid #fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:12px;">✏️</div>
      </div>
      <div style="font-size:18px;font-weight:800;color:#fff;margin-bottom:4px">{{ $user->name }}</div>
      <span class="badge badge-petugas">PETUGAS</span>
      <div style="margin-top:10px;font-size:11px;color:rgba(255,255,255,.4)">Klik foto untuk mengganti</div>
    </div>

    <form method="POST" action="{{ route('petugas.profile.update') }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <input type="file" name="foto" id="fotoInput" accept="image/*" style="display:none" onchange="previewFoto(this)">
      <div style="padding:24px">
        <div class="form-group">
          <label>ID Petugas</label>
          <input type="text" class="form-control" value="{{ $user->id_petugas }}" readonly style="background:#f8fafc;color:#94a3b8">
        </div>
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" class="form-control" value="{{ $user->username }}" readonly style="background:#f8fafc;color:#94a3b8">
        </div>
        <div class="form-group">
          <label>Jabatan</label>
          <div><span class="badge badge-petugas">{{ $user->petugasProfile->jabatan ?? 'Petugas SPP' }}</span></div>
        </div>
        <div id="fotoInfo" style="display:none;margin-bottom:16px;padding:10px 14px;background:#fffbeb;border:1px solid #fde68a;border-radius:9px;font-size:12px;color:#92400e;">
          📷 Foto baru dipilih — klik Simpan untuk menerapkan
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Simpan Perubahan</button>
      </div>
    </form>
  </div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn-outline" style="width:100%;justify-content:center;color:#dc2626;border-color:#fecaca">🚪 Logout</button>
  </form>
</div>
@endsection
@section('scripts')
<script>
function previewFoto(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = function(e) {
    document.getElementById('avatarWrap').innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    document.getElementById('fotoInfo').style.display = 'block';
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
