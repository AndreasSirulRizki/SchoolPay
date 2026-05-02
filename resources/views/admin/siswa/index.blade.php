@extends('layouts.app')
@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')
@section('show-search', true)
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles"><h1>Data Siswa</h1><p>Kelola data siswa SMKN 7 Baleendah</p></div>
  <button onclick="openModal('addModal')" class="btn-primary">+ Tambah Siswa</button>
</div>

<!-- HEADER STATS -->
<div class="stats-grid-3">
  <div class="stat-card"><div class="sc-icon sc-i-blue">🎓</div><div class="sc-val">{{ $totalSiswa }}</div><div class="sc-label">Total Students</div></div>
  <div class="stat-card"><div class="sc-icon sc-i-green">✅</div><div class="sc-val">{{ $activeCount }}</div><div class="sc-label">Active Enrollment</div></div>
  <div class="stat-card"><div class="sc-icon sc-i-amber">⚠️</div><div class="sc-val">{{ $pendingCount }}</div><div class="sc-label">Pending Verification</div></div>
</div>

<!-- TABLE -->
<div class="table-card">
  <div class="tc-header">
    <div>
      <div class="tc-title">Daftar Siswa</div>
    </div>
    <div style="display:flex;gap:8px;align-items:center">
      <form method="GET" style="display:flex;gap:8px">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama/NIS..." style="width:180px;padding:7px 12px">
        <select name="kelas_id" class="form-control" style="width:130px;padding:7px 12px">
          <option value="">ALL CLASSES</option>
          @foreach($kelas as $k)
          <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn-outline" style="padding:7px 12px">≡ Filter</button>
      </form>
      <a href="{{ route('admin.laporan.excel-siswa') }}" class="btn-outline" style="padding:7px 12px">↓ Export</a>
    </div>
  </div>
  <table class="dt">
    <thead><tr>
      <th>NISN</th><th>Nama Lengkap</th><th>Kelas</th><th>No. HP</th><th>Status</th><th>Aksi</th>
    </tr></thead>
    <tbody>
      @forelse($siswa as $s)
      <tr>
        <td style="font-size:12px;font-family:monospace">{{ $s->nisn ?? '-' }}</td>
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <div style="width:32px;height:32px;border-radius:50%;background:#2563eb;display:grid;place-items:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden;">
              @if($s->foto)
                <img src="{{ asset('storage/'.$s->foto) }}" style="width:100%;height:100%;object-fit:cover;">
              @else
                {{ strtoupper(substr($s->nama,0,1)) }}
              @endif
            </div>
            <div>
              <div style="font-weight:600;font-size:13px">{{ $s->nama }}</div>
              <div style="font-size:11px;color:#94a3b8">Reg. {{ $s->tahun_angkatan }}/{{ $s->tahun_angkatan + 1 }}</div>
            </div>
          </div>
        </td>
        <td style="font-size:12px">{{ $s->kelas->nama_kelas ?? '-' }}</td>
        <td style="font-size:12px">{{ $s->no_hp ?? '-' }}</td>
        <td><span class="badge badge-{{ $s->status }}">{{ strtoupper($s->status) }}</span></td>
        <td>
          <div style="display:flex;gap:6px">
            <button onclick="openEdit({{ $s->id }}, '{{ addslashes($s->nama) }}', '{{ $s->nis }}', '{{ $s->nisn }}', {{ $s->kelas_id }}, '{{ $s->no_hp }}', '{{ $s->status }}')" class="btn-outline" style="padding:5px 10px;font-size:11px">Edit</button>
            <button onclick="openDelete({{ $s->id }}, '{{ addslashes($s->nama) }}', '{{ $s->nisn ?? $s->nis }}')" class="btn-danger" style="padding:5px 10px;font-size:11px">Hapus</button>
            <a href="{{ route('admin.siswa.id-card', $s) }}" class="btn-outline" style="padding:5px 10px;font-size:11px">ID Card</a>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6">@include('partials.empty-state', ['msg'=>'Belum ada data siswa.'])</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="pagination-info">SHOWING {{ $siswa->firstItem() ?? 0 }} OF {{ $siswa->total() }} RECORDS &nbsp; {{ $siswa->links() }}</div>
</div>

<!-- IMPORT SECTION -->
<div class="stat-card dark" style="margin-bottom:16px">
  <div style="display:flex;justify-content:space-between;align-items:center">
    <div>
      <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:4px">Advanced Import</div>
      <div style="font-size:12px;color:rgba(255,255,255,.5)">Bulk upload data siswa via Excel atau CSV dengan auto-validasi.</div>
    </div>
    <button onclick="openModal('importModal')" class="btn-outline" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff">Upload File</button>
  </div>
</div>

<!-- STUDENT ID GENERATOR -->
<div class="table-card">
  <div class="tc-header">
    <div>
      <div class="tc-title">Student ID Generator</div>
      <div class="tc-sub">Generate dan cetak kartu identitas digital dengan QR code.</div>
    </div>
  </div>
  <div style="padding:16px;display:flex;gap:10px;flex-wrap:wrap">
    @foreach($siswa->take(5) as $s)
    <a href="{{ route('admin.siswa.id-card', $s) }}" class="btn-outline" style="font-size:12px;padding:7px 12px">🪪 {{ $s->nama }}</a>
    @endforeach
  </div>
</div>
@endsection

@section('modals')
<!-- ADD MODAL -->
<div class="modal-overlay" id="addModal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Tambah Siswa</div><button onclick="closeModal('addModal')" class="modal-close">✕</button></div>
    <form method="POST" action="{{ route('admin.siswa.store') }}">
      @csrf
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group"><label>NISN</label><input type="text" name="nisn" class="form-control" placeholder="0012345678"></div>
          <div class="form-group"><label>NIS</label><input type="text" name="nis" class="form-control" placeholder="2024001" required></div>
        </div>
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" class="form-control" required></div>
        <div class="form-row">
          <div class="form-group"><label>Kelas</label>
            <select name="kelas_id" class="form-control" required>
              @foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>@endforeach
            </select>
          </div>
          <div class="form-group"><label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
          </div>
        </div>
        <div class="form-group"><label>No. Telp/WhatsApp</label><input type="text" name="no_hp" class="form-control"></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" placeholder="Kosongkan = default NIS"></div>
        <div class="form-row">
          <div class="form-group"><label>Nominal SPP (Rp)</label><input type="number" name="nominal_spp" class="form-control" value="150000"></div>
          <div class="form-group"><label>Tahun Ajaran</label><input type="text" name="tahun_ajaran" class="form-control" value="{{ date('Y') }}/{{ date('Y')+1 }}"></div>
        </div>
        <div class="form-group"><label>Alamat Domisili</label><textarea name="alamat" class="form-control" rows="2"></textarea></div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('addModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan Data</button></div>
    </form>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal-overlay" id="editModal">
  <div class="modal">
    <div class="modal-header dark"><div class="modal-title" style="color:#fff">Edit Data Siswa</div><button onclick="closeModal('editModal')" class="modal-close">✕</button></div>
    <form method="POST" id="editForm">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group"><label>NISN</label><input type="text" name="nisn" id="editNisn" class="form-control"></div>
          <div class="form-group"><label>NIS</label><input type="text" name="nis" id="editNis" class="form-control" required></div>
        </div>
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" id="editNama" class="form-control" required></div>
        <div class="form-row">
          <div class="form-group"><label>Kelas</label>
            <select name="kelas_id" id="editKelas" class="form-control">
              @foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>@endforeach
            </select>
          </div>
          <div class="form-group"><label>Status</label>
            <select name="status" id="editStatus" class="form-control">
              <option value="active">Active</option><option value="inactive">Inactive</option><option value="suspended">Suspended</option>
            </select>
          </div>
        </div>
        <div class="form-group"><label>No. HP/WhatsApp</label><input type="text" name="no_hp" id="editNoHp" class="form-control"></div>
        <input type="hidden" name="jenis_kelamin" value="L">
        <div style="border-top:1px solid #e2e8f0;margin:16px 0;padding-top:16px">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:10px">🔑 Reset Password</div>
          <div class="form-group" style="margin-bottom:0">
            <label>Password Baru <span style="font-weight:400;color:#94a3b8">(kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" name="password" id="editPassword" class="form-control" placeholder="Masukkan password baru...">
          </div>
        </div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('editModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan Perubahan</button></div>
    </form>
  </div>
</div>

<!-- DELETE MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal" style="max-width:420px">
    <div class="modal-body" style="text-align:center;padding:32px 24px">
      <div style="font-size:48px;margin-bottom:12px">⚠️</div>
      <div style="font-size:18px;font-weight:800;margin-bottom:8px">Hapus Data Siswa?</div>
      <div style="font-size:13px;color:#64748b;margin-bottom:16px">Apakah Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan dan semua riwayat pembayaran terkait siswa ini akan ikut terhapus.</div>
      <div id="deleteInfo" style="background:#fef2f2;border-radius:8px;padding:10px;font-size:13px;font-weight:600;color:#dc2626;margin-bottom:20px"></div>
      <form method="POST" id="deleteForm">
        @csrf @method('DELETE')
        <div style="display:flex;gap:10px;justify-content:center">
          <button type="button" onclick="closeModal('deleteModal')" class="btn-outline">Batal</button>
          <button type="submit" class="btn-danger">Ya, Hapus Permanen</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- IMPORT MODAL -->
<div class="modal-overlay" id="importModal">
  <div class="modal" style="max-width:420px">
    <div class="modal-header"><div class="modal-title">Import Data Siswa</div><button onclick="closeModal('importModal')" class="modal-close">✕</button></div>
    <form method="POST" action="{{ route('admin.siswa.import') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>File Excel/CSV</label><input type="file" name="file" class="form-control" accept=".xlsx,.csv,.xls" required></div>
        <div style="font-size:12px;color:#64748b">Kolom yang diperlukan: nis, nisn, nama, kelas, jenis_kelamin, no_hp, alamat</div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('importModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Upload & Import</button></div>
    </form>
  </div>
</div>
@endsection
@section('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function openEdit(id, nama, nis, nisn, kelasId, noHp, status) {
  document.getElementById('editNama').value = nama;
  document.getElementById('editNis').value = nis;
  document.getElementById('editNisn').value = nisn || '';
  document.getElementById('editKelas').value = kelasId;
  document.getElementById('editNoHp').value = noHp || '';
  document.getElementById('editStatus').value = status;
  document.getElementById('editForm').action = `/admin/siswa/${id}`;
  openModal('editModal');
}
function openDelete(id, nama, nisn) {
  document.getElementById('deleteInfo').textContent = `Menghapus: ${nama} - ${nisn}`;
  document.getElementById('deleteForm').action = `/admin/siswa/${id}`;
  openModal('deleteModal');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if (e.target === o) o.classList.remove('show'); }));
</script>
@endsection
