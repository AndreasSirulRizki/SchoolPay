@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div style="max-width:560px">
  <div class="table-card" style="margin-bottom:16px">
    {{-- Photo Hero --}}
    <div style="padding:32px 24px 24px;text-align:center;border-bottom:1px solid #e2e8f0;background:linear-gradient(135deg,#0d1b3e 0%,#1e3a6e 100%);border-radius:14px 14px 0 0;">
      <div style="position:relative;display:inline-block;margin-bottom:14px;">
        <div id="avatarWrap" style="width:88px;height:88px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,.2);background:#1e3a6e;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:800;color:#fff;cursor:pointer;" onclick="document.getElementById('fotoInput').click()">
          @if($user->foto)
            <img id="avatarImg" src="{{ asset('storage/'.$user->foto) }}" style="width:100%;height:100%;object-fit:cover;">
          @else
            <span id="avatarInitial">{{ strtoupper(substr($user->name,0,1)) }}</span>
          @endif
        </div>
        <div onclick="document.getElementById('fotoInput').click()" style="position:absolute;bottom:0;right:0;width:26px;height:26px;border-radius:50%;background:#2563eb;border:2px solid #fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:12px;">✏️</div>
      </div>
      <div style="font-size:18px;font-weight:800;color:#fff;margin-bottom:4px">{{ $user->name }}</div>
      <span class="badge badge-admin">ADMINISTRATOR</span>
      <div style="margin-top:10px;font-size:11px;color:rgba(255,255,255,.4)">Klik foto untuk mengganti</div>
    </div>

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="profileForm">
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
        {{-- Foto preview info --}}
        <div id="fotoInfo" style="display:none;margin-bottom:16px;padding:10px 14px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:9px;font-size:12px;color:#1e40af;">
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
    const wrap = document.getElementById('avatarWrap');
    wrap.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    document.getElementById('fotoInfo').style.display = 'block';
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
