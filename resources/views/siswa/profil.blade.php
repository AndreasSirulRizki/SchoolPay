@extends('layouts.student')
@section('title', 'Profil Saya')
@section('content')
<div class="pg-header">
  <div class="pg-titles"><h1>Profil Saya</h1><p>Kelola informasi akun Anda</p></div>
</div>

<div style="max-width:560px">
  <div class="table-card" style="margin-bottom:16px">
    {{-- Photo Hero --}}
    <div style="padding:32px 24px 24px;text-align:center;border-bottom:1px solid #e2e8f0;background:linear-gradient(135deg,#1e3a6e 0%,#2563eb 100%);border-radius:14px 14px 0 0;">
      <div style="position:relative;display:inline-block;margin-bottom:14px;">
        <div id="avatarWrap" style="width:88px;height:88px;border-radius:50%;overflow:hidden;border:3px solid rgba(255,255,255,.2);background:#1e40af;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:800;color:#fff;cursor:pointer;" onclick="document.getElementById('fotoInput').click()">
          @if($siswa->foto)
            <img src="{{ asset('storage/'.$siswa->foto) }}" style="width:100%;height:100%;object-fit:cover;">
          @else
            <span>{{ strtoupper(substr($siswa->nama,0,1)) }}</span>
          @endif
        </div>
        <div onclick="document.getElementById('fotoInput').click()" style="position:absolute;bottom:0;right:0;width:26px;height:26px;border-radius:50%;background:#2563eb;border:2px solid #fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:12px;">✏️</div>
      </div>
      <div style="font-size:18px;font-weight:800;color:#fff;margin-bottom:4px">{{ $siswa->nama }}</div>
      <span class="badge badge-active">Siswa</span>
      <div style="margin-top:10px;font-size:11px;color:rgba(255,255,255,.4)">Klik foto untuk mengganti</div>
    </div>

    <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <input type="file" name="foto" id="fotoInput" accept="image/*" style="display:none" onchange="previewFoto(this)">
      <div style="padding:24px">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
          <div class="form-group" style="margin-bottom:0">
            <label>NISN</label>
            <input type="text" class="form-control" value="{{ $siswa->nisn ?? '-' }}" readonly style="background:#f8fafc;color:#94a3b8">
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label>NIS</label>
            <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly style="background:#f8fafc;color:#94a3b8">
          </div>
        </div>
        <div class="form-group">
          <label>Kelas</label>
          <select name="kelas_id" class="form-control">
            @foreach(\App\Models\Kelas::orderBy('tingkat')->get() as $k)
            <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>No. Telepon</label>
          <input type="text" name="no_hp" class="form-control" value="{{ $siswa->no_hp }}">
        </div>
        <div class="form-group">
          <label>Alamat Domisili</label>
          <textarea name="alamat" class="form-control" rows="3">{{ $siswa->alamat }}</textarea>
        </div>
        <div id="fotoInfo" style="display:none;margin-bottom:16px;padding:10px 14px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:9px;font-size:12px;color:#1e40af;">
          📷 Foto baru dipilih — klik Simpan untuk menerapkan
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Simpan Perubahan</button>
      </div>
    </form>
  </div>

  <form method="POST" action="{{ route('siswa.logout') }}">
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
