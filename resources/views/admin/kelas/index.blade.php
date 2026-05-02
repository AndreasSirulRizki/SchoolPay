@extends('layouts.app')
@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles"><h1>Data Kelas</h1><p>Kelola data kelas SMKN 7 Baleendah</p></div>
  <button onclick="openModal('addModal')" class="btn-primary">+ Tambah Kelas</button>
</div>

<div style="display:grid;grid-template-columns:260px 1fr;gap:20px">
  <!-- LEFT SIDEBAR -->
  <div>
    <div class="stat-card dark" style="margin-bottom:16px">
      <div class="sc-icon sc-i-dark">🏫</div>
      <div class="sc-val">{{ $kelas->total() }}</div>
      <div class="sc-label">Total Kelas</div>
      <div style="margin-top:8px"><span class="badge-green-sm">+{{ $kelas->total() }} This Semester</span></div>
    </div>
    <div class="table-card">
      <div style="padding:16px">
        <div style="font-size:12px;font-weight:700;color:#0d1b3e;margin-bottom:4px">Sync Status</div>
        <div style="font-size:11px;color:#94a3b8">Last synchronized: 5 mins ago</div>
      </div>
    </div>
  </div>

  <!-- RIGHT: TABLE -->
  <div>
    <div class="table-card">
      <div class="tc-header">
        <div class="tc-title">Classroom Directory</div>
        <form method="GET" style="display:flex;gap:8px">
          <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari kelas..." style="width:180px;padding:7px 12px">
          <button type="submit" class="btn-outline" style="padding:7px 12px">Cari</button>
        </form>
      </div>
      <table class="dt">
        <thead><tr><th>ID Kelas</th><th>Nama Kelas</th><th>Kompetensi Keahlian</th><th>Siswa</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($kelas as $k)
          <tr>
            <td style="font-family:monospace;font-size:12px">#CLS-{{ str_pad($k->id,2,'0',STR_PAD_LEFT) }}-{{ strtoupper(substr($k->jurusan,0,3)) }}</td>
            <td style="font-weight:600">{{ $k->nama_kelas }}</td>
            <td><span class="badge badge-admin" style="font-size:10px">{{ $k->jurusan }}</span></td>
            <td>{{ $k->siswa_count ?? 0 }}</td>
            <td>
              <div style="display:flex;gap:6px">
                <button onclick="openEdit({{ $k->id }},'{{ addslashes($k->nama_kelas) }}','{{ $k->tingkat }}','{{ addslashes($k->jurusan) }}','{{ addslashes($k->wali_kelas) }}')" class="btn-outline" style="padding:5px 10px;font-size:11px">Edit</button>
                <button onclick="openDelete({{ $k->id }},'{{ addslashes($k->nama_kelas) }}')" class="btn-danger" style="padding:5px 10px;font-size:11px">Hapus</button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="5">@include('partials.empty-state', ['msg'=>'Belum ada data kelas.'])</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="pagination-info">Showing {{ $kelas->firstItem() ?? 0 }} of {{ $kelas->total() }} Classrooms &nbsp; {{ $kelas->links() }}</div>
    </div>

    <!-- DEPARTMENTAL DISTRIBUTION -->
    <div class="table-card">
      <div class="tc-header"><div class="tc-title">Departmental Distribution</div></div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;padding:16px">
        @php
          $jurusanList = [
            ['nama'=>'Rekayasa Perangkat Lunak','icon'=>'💻','short'=>'RPL'],
            ['nama'=>'Teknik Komputer Jaringan','icon'=>'🌐','short'=>'TKJ'],
            ['nama'=>'Multimedia','icon'=>'🎨','short'=>'MM'],
            ['nama'=>'Akuntansi','icon'=>'📊','short'=>'AK'],
          ];
        @endphp
        @foreach($jurusanList as $j)
        @php
          $jumlahKelas = $kelas->getCollection()->where('jurusan', $j['nama'])->count();
        @endphp
        <div style="background:#f8fafc;border-radius:10px;padding:14px;text-align:center">
          <div style="font-size:24px;margin-bottom:8px">{{ $j['icon'] }}</div>
          <div style="font-size:11px;font-weight:700;color:#0d1b3e">{{ $j['short'] }}</div>
          <div style="font-size:10px;color:#94a3b8;margin-top:2px">{{ $jumlahKelas }} Kelas</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
@section('modals')
<div class="modal-overlay" id="addModal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Tambah Kelas</div><button onclick="closeModal('addModal')" class="modal-close">✕</button></div>
    <form method="POST" action="{{ route('admin.kelas.store') }}">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Nama Kelas</label><input type="text" name="nama_kelas" class="form-control" required placeholder="X RPL 1"></div>
        <div class="form-row">
          <div class="form-group"><label>Tingkat</label>
            <select name="tingkat" class="form-control"><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select>
          </div>
          <div class="form-group"><label>Jurusan</label>
            <select name="jurusan" class="form-control">
              <option>Rekayasa Perangkat Lunak</option>
              <option>Teknik Komputer Jaringan</option>
              <option>Multimedia</option>
              <option>Akuntansi</option>
            </select>
          </div>
        </div>
        <div class="form-group"><label>Wali Kelas</label><input type="text" name="wali_kelas" class="form-control"></div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('addModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan</button></div>
    </form>
  </div>
</div>
<div class="modal-overlay" id="editModal">
  <div class="modal">
    <div class="modal-header dark"><div class="modal-title" style="color:#fff">Edit Kelas</div><button onclick="closeModal('editModal')" class="modal-close">✕</button></div>
    <form method="POST" id="editForm">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group"><label>Nama Kelas</label><input type="text" name="nama_kelas" id="editNama" class="form-control" required></div>
        <div class="form-row">
          <div class="form-group"><label>Tingkat</label>
            <select name="tingkat" id="editTingkat" class="form-control"><option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option></select>
          </div>
          <div class="form-group"><label>Jurusan</label>
            <select name="jurusan" id="editJurusan" class="form-control">
              <option>Rekayasa Perangkat Lunak</option><option>Teknik Komputer Jaringan</option><option>Multimedia</option><option>Akuntansi</option>
            </select>
          </div>
        </div>
        <div class="form-group"><label>Wali Kelas</label><input type="text" name="wali_kelas" id="editWali" class="form-control"></div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('editModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan Perubahan</button></div>
    </form>
  </div>
</div>
<div class="modal-overlay" id="deleteModal">
  <div class="modal" style="max-width:380px">
    <div class="modal-body" style="text-align:center;padding:28px">
      <div style="font-size:40px;margin-bottom:12px">⚠️</div>
      <div style="font-size:16px;font-weight:800;margin-bottom:8px">Hapus Kelas?</div>
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
function openEdit(id, nama, tingkat, jurusan, wali) {
  document.getElementById('editNama').value = nama;
  document.getElementById('editTingkat').value = tingkat;
  document.getElementById('editJurusan').value = jurusan;
  document.getElementById('editWali').value = wali;
  document.getElementById('editForm').action = `/admin/kelas/${id}`;
  openModal('editModal');
}
function openDelete(id, nama) {
  document.getElementById('deleteInfo').textContent = `Menghapus: ${nama}`;
  document.getElementById('deleteForm').action = `/admin/kelas/${id}`;
  openModal('deleteModal');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if (e.target === o) o.classList.remove('show'); }));
</script>
@endsection
