@extends('layouts.app')
@section('title', 'Data SPP')
@section('page-title', 'Data SPP')
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles"><h1>Data SPP</h1><p>Kelola tarif SPP per siswa</p></div>
  <button onclick="openModal('addModal')" class="btn-primary">+ Tambah Tarif</button>
</div>

<!-- ACTIVE TUITION CYCLE CARD -->
<div class="stat-card dark" style="margin-bottom:20px">
  <div style="display:flex;justify-content:space-between;align-items:center">
    <div>
      <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:6px">ACTIVE TUITION CYCLE</div>
      <div style="font-size:18px;font-weight:800;color:#fff">Academic Year {{ $tahunAjaran }}</div>
      <div style="font-size:13px;color:rgba(255,255,255,.5);margin-top:4px">
        Total Collections: IDR {{ number_format($totalKoleksi/1000000000, 1) }}B &nbsp;·&nbsp;
        Completion Rate: {{ $completionRate }}%
      </div>
    </div>
    <div style="text-align:right">
      <div style="background:rgba(255,255,255,.1);border-radius:10px;padding:12px 16px">
        <div style="font-size:10px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px">Standard Nominal</div>
        <div style="font-size:18px;font-weight:800;color:#fff">IDR 500.000</div>
        <span class="badge-green-sm" style="font-size:9px">CURRENT BASE</span>
      </div>
    </div>
  </div>
</div>

<div class="table-card">
  <div class="tc-header"><div class="tc-title">Daftar Tarif SPP per Siswa</div></div>
  <table class="dt">
    <thead><tr><th>Siswa</th><th>Kelas</th><th>Nominal</th><th>Tahun Ajaran</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($tarif as $t)
      <tr>
        <td>
          @if($t->siswa)
          <div style="font-weight:600;font-size:13px">{{ $t->siswa->nama }}</div>
          <div style="font-size:11px;color:#94a3b8">{{ $t->siswa->nis }}</div>
          @else
          <span style="color:#94a3b8;font-size:12px">— Default —</span>
          @endif
        </td>
        <td style="font-size:12px">{{ $t->siswa->kelas->nama_kelas ?? '-' }}</td>
        <td style="font-weight:700;color:#2563eb">Rp {{ number_format($t->nominal,0,',','.') }}</td>
        <td style="font-size:12px">{{ $t->tahun_ajaran }}</td>
        <td><span class="badge {{ $t->is_aktif ? 'badge-active' : 'badge-inactive' }}">{{ $t->is_aktif ? 'AKTIF' : 'NONAKTIF' }}</span></td>
        <td>
          <div style="display:flex;gap:6px">
            <button onclick="openEdit({{ $t->id }},{{ $t->nominal }},'{{ $t->tahun_ajaran }}',{{ $t->is_aktif ? 'true' : 'false' }})" class="btn-outline" style="padding:5px 10px;font-size:11px">Edit</button>
            <button onclick="openDelete({{ $t->id }})" class="btn-danger" style="padding:5px 10px;font-size:11px">Hapus</button>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="6">@include('partials.empty-state', ['msg'=>'Belum ada data tarif SPP.'])</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="pagination-info">{{ $tarif->links() }}</div>
</div>

<!-- SYSTEM NOTICE -->
<div style="background:#fef3c7;border:1px solid #fde68a;border-radius:12px;padding:16px;margin-top:4px">
  <div style="font-size:13px;font-weight:700;color:#92400e;margin-bottom:4px">⚠️ System Notice</div>
  <div style="font-size:12px;color:#92400e">Perubahan nominal standar hanya akan berpengaruh pada pendaftaran baru untuk tahun ajaran yang bersangkutan. Data historis tetap terkunci untuk keperluan audit.</div>
</div>
@endsection
@section('modals')
<div class="modal-overlay" id="addModal">
  <div class="modal">
    <div class="modal-header"><div class="modal-title">Tambah Tarif SPP</div><button onclick="closeModal('addModal')" class="modal-close">✕</button></div>
    <form method="POST" action="{{ route('admin.spp.store') }}">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Siswa (kosongkan untuk default)</label>
          <select name="siswa_id" class="form-control">
            <option value="">— Default (semua siswa) —</option>
            @foreach($siswa as $s)<option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->nis }})</option>@endforeach
          </select>
        </div>
        <div class="form-group"><label>Nominal (Rp)</label><input type="number" name="nominal" class="form-control" value="150000" required></div>
        <div class="form-group"><label>Tahun Ajaran</label><input type="text" name="tahun_ajaran" class="form-control" value="{{ date('Y') }}/{{ date('Y')+1 }}" required></div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('addModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan</button></div>
    </form>
  </div>
</div>
<div class="modal-overlay" id="editModal">
  <div class="modal">
    <div class="modal-header dark"><div class="modal-title" style="color:#fff">Edit Tarif SPP</div><button onclick="closeModal('editModal')" class="modal-close">✕</button></div>
    <form method="POST" id="editForm">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group"><label>Nominal (Rp)</label><input type="number" name="nominal" id="editNominal" class="form-control" required></div>
        <div class="form-group"><label>Tahun Ajaran</label><input type="text" name="tahun_ajaran" id="editTahun" class="form-control" required></div>
        <div class="form-group"><label style="display:flex;align-items:center;gap:8px;cursor:pointer"><input type="checkbox" name="is_aktif" id="editAktif" value="1"> Aktif</label></div>
      </div>
      <div class="modal-footer"><button type="button" onclick="closeModal('editModal')" class="btn-outline">Batal</button><button type="submit" class="btn-primary">Simpan</button></div>
    </form>
  </div>
</div>
<div class="modal-overlay" id="deleteModal">
  <div class="modal" style="max-width:360px">
    <div class="modal-body" style="text-align:center;padding:28px">
      <div style="font-size:40px;margin-bottom:12px">⚠️</div>
      <div style="font-size:16px;font-weight:800;margin-bottom:16px">Hapus Tarif SPP?</div>
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
function openEdit(id, nominal, tahun, aktif) {
  document.getElementById('editNominal').value = nominal;
  document.getElementById('editTahun').value = tahun;
  document.getElementById('editAktif').checked = aktif;
  document.getElementById('editForm').action = `/admin/spp/${id}`;
  openModal('editModal');
}
function openDelete(id) {
  document.getElementById('deleteForm').action = `/admin/spp/${id}`;
  openModal('deleteModal');
}
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if (e.target === o) o.classList.remove('show'); }));
</script>
@endsection
