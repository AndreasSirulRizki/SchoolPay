@extends('layouts.app')
@section('title', 'Data Petugas')
@section('page-title', 'Data Petugas')
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles">
    <h1>Petugas & Administrator</h1>
    <p>Staff Management Overview</p>
  </div>
  <button onclick="openModal('addModal')" class="btn-primary">+ Tambah Petugas</button>
</div>

<div class="stats-grid-3">
  <div class="stat-card"><div class="sc-icon sc-i-blue">👤</div><div class="sc-val">{{ $totalPetugas }}</div><div class="sc-label">Total Petugas</div></div>
  <div class="stat-card"><div class="sc-icon sc-i-amber">🛡️</div><div class="sc-val">{{ $totalAdmin }}</div><div class="sc-label">Admin Accounts</div></div>
  <div class="stat-card"><div class="sc-icon sc-i-green">🟢</div><div class="sc-val">{{ $activeToday }}</div><div class="sc-label">Active Today</div></div>
</div>

<div class="table-card">
  <div class="tc-header">
    <div class="tc-title">Daftar Staff</div>
    <form method="GET" style="display:flex;gap:8px">
      <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama/username..." style="width:200px;padding:7px 12px">
      <button type="submit" class="btn-outline" style="padding:7px 12px">Cari</button>
    </form>
  </div>
  <table class="dt">
    <thead><tr><th>ID Petugas</th><th>Username</th><th>Nama Petugas</th><th>Jabatan</th><th>Login Terakhir</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($petugas as $p)
      <tr>
        <td style="font-family:monospace;font-size:12px">#PTG-{{ str_pad($p->id,3,'0',STR_PAD_LEFT) }}</td>
        <td style="font-size:12px">{{ $p->username }}</td>
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <div style="width:32px;height:32px;border-radius:50%;background:#d97706;display:grid;place-items:center;font-size:12px;font-weight:700;color:#fff;overflow:hidden;">
              @if($p->foto)
                <img src="{{ asset('storage/'.$p->foto) }}" style="width:100%;height:100%;object-fit:cover;">
              @else
                {{ strtoupper(substr($p->name,0,1)) }}
              @endif
            </div>
            <div style="font-weight:600;font-size:13px">{{ $p->name }}</div>
          </div>
        </td>
        <td><span class="badge badge-petugas">PETUGAS</span></td>
        <td style="font-size:12px;color:#94a3b8">{{ $p->last_login_at ? \Carbon\Carbon::parse($p->last_login_at)->diffForHumans() : 'Belum pernah' }}</td>
        <td>
          <div style="display:flex;gap:6px">
            <button onclick="openEdit({{ $p->id }},'{{ addslashes($p->name) }}','{{ $p->username }}','{{ $p->email }}','{{ $p->petugasProfile->jabatan ?? '' }}','{{ $p->petugasProfile->no_hp ?? '' }}')" class="btn-outline" style="padding:5px 10px;font-size:11px">Edit</button>
            <button onclick="openDelete({{ $p->id }},'{{ addslashes($p->name) }}')" class="btn-danger" style="padding:5px 10px;font-size:11px">Hapus</button>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6">@include('partials.empty-state', ['msg'=>'Belum ada data petugas.'])</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="pagination-info">SHOWING {{ $petugas->firstItem() ?? 0 }} OF {{ $petugas->total() }} RECORDS &nbsp; {{ $petugas->links() }}</div>
</div>

<!-- INFO SECTION -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
  <div class="table-card">
    <div class="tc-header"><div class="tc-title">Role Responsibilities</div></div>
    <div style="padding:16px;font-size:13px;color:#475569;line-height:1.7">
      <strong>Administrator:</strong> Akses penuh ke semua modul termasuk manajemen data, laporan, dan konfigurasi sistem.<br>
      <strong>Petugas:</strong> Akses terbatas ke entry transaksi dan history pembayaran yang diproses sendiri.
    </div>
  </div>
  <div class="table-card">
    <div class="tc-header"><div class="tc-title">Security Audit</div></div>
    <div style="padding:16px;font-size:13px;color:#475569;line-height:1.7">
      Audit keamanan terakhir: <strong>{{ now()->format('d M Y') }}</strong><br>
      Semua akses tercatat dalam log sistem. Password dienkripsi menggunakan bcrypt.
    </div>
  </div>
</div>
@endsection
@section('modals')
<div class="modal-overlay" id="addModal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Tambah Petugas</div><button onclick="closeModal('addModal')" class="modal-close">✕</button></div>
    <form method="POST" action="{{ route('admin.petugas.store') }}">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" class="form-control" required></div>
        <div class="form-row">
          <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" required></div>
          <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
        </div>
        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
        <div class="form-row">
          <div class="form-group"><label>NIP</label><input type="text" name="nip" class="form-control"></div>
          <div class="form-group"><label>Jabatan</label><input type="text" name="jabatan" class="form-control"></div>
        </div>
        <div class="form-group"><label>No. HP</label><input type="text" name="no_hp" class="form-control"></div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('addModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan</button></div>
    </form>
  </div>
</div>
<div class="modal-overlay" id="editModal">
  <div class="modal">
    <div class="modal-header dark"><div class="modal-title" style="color:#fff">Edit Petugas</div><button onclick="closeModal('editModal')" class="modal-close">✕</button></div>
    <form method="POST" id="editForm">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" id="editNama" class="form-control" required></div>
        <div class="form-row">
          <div class="form-group"><label>Username</label><input type="text" name="username" id="editUsername" class="form-control" required></div>
          <div class="form-group"><label>Password Baru (kosongkan jika tidak diubah)</label><input type="password" name="password" class="form-control"></div>
        </div>
        <div class="form-group"><label>Email</label><input type="email" name="email" id="editEmail" class="form-control"></div>
        <div class="form-row">
          <div class="form-group"><label>Jabatan</label><input type="text" name="jabatan" id="editJabatan" class="form-control"></div>
          <div class="form-group"><label>No. HP</label><input type="text" name="no_hp" id="editNoHp" class="form-control"></div>
        </div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('editModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan Perubahan</button></div>
    </form>
  </div>
</div>
<div class="modal-overlay" id="deleteModal">
  <div class="modal" style="max-width:380px">
    <div class="modal-body" style="text-align:center;padding:28px">
      <div style="font-size:40px;margin-bottom:12px">⚠️</div>
      <div style="font-size:16px;font-weight:800;margin-bottom:8px">Hapus Petugas?</div>
      <div id="deleteInfo" style="font-size:13px;color:#dc2626;font-weight:600;margin-bottom:16px"></div>
      <form method="POST" id="deleteForm">
        @csrf @method('DELETE')
        <div style="display:flex;gap:10px;justify-content:center">
          <button type="button" onclick="closeModal('deleteModal')" class="btn-outline">Batal</button>
          <button type="submit" class="btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function openEdit(id, nama, username, email, jabatan, noHp) {
  document.getElementById('editNama').value = nama;
  document.getElementById('editUsername').value = username;
  document.getElementById('editEmail').value = email;
  document.getElementById('editJabatan').value = jabatan;
  document.getElementById('editNoHp').value = noHp;
  document.getElementById('editForm').action = `/admin/petugas/${id}`;
  openModal('editModal');
}
function openDelete(id, nama) {
  document.getElementById('deleteInfo').textContent = `Menghapus: ${nama}`;
  document.getElementById('deleteForm').action = `/admin/petugas/${id}`;
  openModal('deleteModal');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if (e.target === o) o.classList.remove('show'); }));
</script>
@endsection
