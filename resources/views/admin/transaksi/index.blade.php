@extends('layouts.app')
@section('title', 'Entry Transaksi')
@section('page-title', 'Entry Transaksi')
@section('show-search', true)
@section('sidebar-nav')@include('admin.partials.sidebar')@endsection
@section('content')
<div class="pg-header">
  <div class="pg-titles">
    <h1>Entry Transaksi</h1>
    <p>Catat pembayaran SPP siswa</p>
  </div>
</div>

<!-- SEARCH BAR -->
<div class="table-card" style="margin-bottom:20px">
  <div style="padding:20px">
    <label style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#475569;display:block;margin-bottom:8px">Cari Siswa</label>
    <div style="position:relative">
      <input type="text" id="searchSiswa" class="form-control" placeholder="Ketik NISN, NIS, atau nama siswa..." autocomplete="off" style="padding-left:36px">
      <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8">🔍</span>
    </div>
    <div id="searchDropdown" style="display:none;border:1px solid #e2e8f0;border-radius:10px;margin-top:6px;background:#fff;box-shadow:0 8px 24px rgba(0,0,0,.1);max-height:200px;overflow-y:auto"></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:340px 1fr;gap:20px" id="mainContent" style="display:none">
  <!-- LEFT: Student Identity -->
  <div>
    <div class="table-card" id="studentCard" style="display:none">
      <div style="padding:20px">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px">
          <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#059669;background:#dcfce7;padding:3px 10px;border-radius:20px">ACTIVE RECORD</span>
        </div>
        <div style="text-align:center;margin-bottom:16px">
          <div id="studentAvatar" style="width:64px;height:64px;border-radius:50%;background:#2563eb;display:inline-flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:#fff;margin-bottom:10px"></div>
          <div id="studentName" style="font-size:16px;font-weight:700"></div>
          <div id="studentNis" style="font-size:12px;color:#94a3b8;margin-top:2px"></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px">
          <div style="background:#f0f4f8;border-radius:8px;padding:10px;text-align:center">
            <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px">Kelas</div>
            <div id="studentKelas" style="font-size:13px;font-weight:700;margin-top:2px"></div>
          </div>
          <div style="background:#f0f4f8;border-radius:8px;padding:10px;text-align:center">
            <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px">Angkatan</div>
            <div id="studentAngkatan" style="font-size:13px;font-weight:700;margin-top:2px"></div>
          </div>
        </div>
        <div style="background:#0d1b3e;border-radius:10px;padding:14px;margin-bottom:10px">
          <div style="font-size:10px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">TAGIHAN TERSISA</div>
          <div id="tagihanTersisa" style="font-size:20px;font-weight:800;color:#fff"></div>
          <div style="font-size:10px;color:rgba(255,255,255,.4);margin-top:2px">Termasuk denda keterlambatan</div>
        </div>
        <div style="background:#fef3c7;border-radius:10px;padding:14px">
          <div style="font-size:10px;color:#92400e;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px">BULAN TUNGGAKAN</div>
          <div id="bulanTunggakan" style="display:flex;flex-wrap:wrap;gap:4px"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT: Payment Form -->
  <div class="table-card" id="paymentForm" style="display:none">
    <div class="tc-header"><div class="tc-title">Formulir Pembayaran</div></div>
    <div style="padding:24px">
      <form id="formTransaksi">
        @csrf
        <input type="hidden" id="siswaId" name="siswa_id">
        <div class="form-row" style="margin-bottom:16px">
          <div class="form-group" style="margin-bottom:0">
            <label>Bulan Pembayaran</label>
            <select name="bulan" id="bulanPembayaran" class="form-control">
              @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
              <option value="{{ $i+1 }}" {{ ($i+1) == now()->month ? 'selected' : '' }}>{{ $b }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group" style="margin-bottom:0">
            <label>Tahun Dibayar</label>
            <input type="number" name="tahun" class="form-control" value="{{ now()->year }}" min="2020">
          </div>
        </div>
        <div class="form-group">
          <label>Jumlah Bayar</label>
          <input type="number" name="jumlah_bayar" id="jumlahBayar" class="form-control" placeholder="150000">
          <div id="saranNominal" style="font-size:11px;color:#94a3b8;margin-top:4px"></div>
        </div>
        <div style="background:#f8fafc;border-radius:10px;padding:14px;margin-bottom:16px">
          <div style="display:flex;justify-content:space-between;font-size:12px;color:#64748b;margin-bottom:6px">
            <span>Biaya Admin</span><span>Rp 2.500</span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:12px;color:#64748b;margin-bottom:6px">
            <span>Metode</span><span>Tunai / Kasir</span>
          </div>
          <div style="border-top:1px solid #e2e8f0;padding-top:8px;display:flex;justify-content:space-between;font-size:15px;font-weight:800;color:#0d1b3e">
            <span>TOTAL BAYAR</span><span id="totalBayar">Rp 0</span>
          </div>
        </div>
        <input type="hidden" name="metode_bayar" value="tunai">
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:14px;font-size:14px">▷ Konfirmasi Pembayaran</button>
        <div style="display:flex;align-items:center;gap:10px;margin-top:14px;padding:12px;background:#f0f4f8;border-radius:10px">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;font-weight:600;text-transform:none;letter-spacing:0;color:#0d1b3e">
            <input type="checkbox" id="printToggle" checked style="width:16px;height:16px"> Print Receipt Auto-Enabled
          </label>
        </div>
        <div style="font-size:11px;color:#94a3b8;margin-top:6px;text-align:center">Kwitansi akan dicetak otomatis setelah konfirmasi.</div>
      </form>
    </div>
  </div>
</div>

<!-- SUCCESS MODAL -->
<div class="modal-overlay" id="successModal">
  <div class="modal" style="max-width:400px;text-align:center">
    <div style="padding:32px 24px">
      <div style="font-size:56px;margin-bottom:16px">✅</div>
      <div style="font-size:20px;font-weight:800;margin-bottom:8px">Transaksi Berhasil!</div>
      <div style="font-size:13px;color:#64748b;margin-bottom:20px">Data pembayaran telah berhasil disimpan ke dalam sistem dan riwayat telah diperbarui.</div>
      <div style="background:#f8fafc;border-radius:10px;padding:14px;margin-bottom:20px;text-align:left">
        <div style="font-size:12px;color:#64748b;margin-bottom:4px">Nama Siswa</div>
        <div id="modalNama" style="font-weight:700;margin-bottom:10px"></div>
        <div style="font-size:12px;color:#64748b;margin-bottom:4px">Total Pembayaran</div>
        <div id="modalTotal" style="font-weight:800;font-size:18px;color:#059669;margin-bottom:10px"></div>
        <div style="font-size:12px;color:#64748b;margin-bottom:4px">Periode</div>
        <div id="modalPeriode" style="font-weight:700"></div>
      </div>
      <button onclick="closeSuccess()" class="btn-primary" style="width:100%;justify-content:center;background:#059669;padding:12px">Selesai</button>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
let selectedSiswa = null;
const searchInput = document.getElementById('searchSiswa');
const dropdown = document.getElementById('searchDropdown');
let timer;

searchInput.addEventListener('input', function() {
  clearTimeout(timer);
  const q = this.value.trim();
  if (q.length < 2) { dropdown.style.display = 'none'; return; }
  timer = setTimeout(() => {
    fetch(`{{ route('admin.transaksi.cari-siswa') }}?q=${encodeURIComponent(q)}`, { headers: {'X-Requested-With':'XMLHttpRequest'} })
      .then(r => r.json()).then(data => {
        if (!data.length) { dropdown.innerHTML = '<div style="padding:12px 16px;color:#94a3b8;font-size:13px">Tidak ditemukan</div>'; dropdown.style.display = 'block'; return; }
        dropdown.innerHTML = data.map(s => `<div class="sr-item" onclick="selectSiswa(${JSON.stringify(s).replace(/"/g,'&quot;')})" style="padding:10px 16px;cursor:pointer;border-bottom:1px solid #f1f5f9">
          <div style="font-weight:600;font-size:13px">${s.nama}</div>
          <div style="font-size:11px;color:#94a3b8">${s.nis} · ${s.kelas}</div>
        </div>`).join('');
        dropdown.style.display = 'block';
      });
  }, 300);
});

function selectSiswa(s) {
  selectedSiswa = s;
  dropdown.style.display = 'none';
  searchInput.value = s.nama;
  document.getElementById('siswaId').value = s.id;
  document.getElementById('studentAvatar').textContent = s.nama.charAt(0).toUpperCase();
  document.getElementById('studentName').textContent = s.nama;
  document.getElementById('studentNis').textContent = 'NIS: ' + s.nis;
  document.getElementById('studentKelas').textContent = s.kelas;
  document.getElementById('studentAngkatan').textContent = s.tahun_angkatan || s.nis.substring(0,4);
  document.getElementById('tagihanTersisa').textContent = 'Rp ' + (s.tagihan_tersisa||0).toLocaleString('id-ID');
  const bt = document.getElementById('bulanTunggakan');
  bt.innerHTML = (s.bulan_belum||[]).map(b => `<span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:12px;font-size:10px;font-weight:700">${b}</span>`).join('');
  document.getElementById('jumlahBayar').value = s.nominal_spp || 150000;
  document.getElementById('saranNominal').textContent = '*Saran jumlah: Rp ' + (s.nominal_spp||150000).toLocaleString('id-ID') + ' / bulan';
  updateTotal();
  document.getElementById('studentCard').style.display = 'block';
  document.getElementById('paymentForm').style.display = 'block';
  document.getElementById('mainContent').style.display = 'grid';
}

document.getElementById('jumlahBayar').addEventListener('input', updateTotal);
function updateTotal() {
  const j = parseInt(document.getElementById('jumlahBayar').value) || 0;
  document.getElementById('totalBayar').textContent = 'Rp ' + (j + 2500).toLocaleString('id-ID');
}

document.getElementById('formTransaksi').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('{{ route("admin.transaksi.store") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
    body: fd
  }).then(r => r.json()).then(data => {
    if (data.success) {
      document.getElementById('modalNama').textContent = data.nama_siswa;
      document.getElementById('modalTotal').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
      document.getElementById('modalPeriode').textContent = data.bulan + ' ' + data.tahun;
      document.getElementById('successModal').classList.add('show');
      if (document.getElementById('printToggle').checked) {
        window.open(`{{ url('admin/transaksi') }}/${data.id}/kwitansi`, '_blank');
      }
    } else {
      alert(data.error || 'Terjadi kesalahan.');
    }
  }).catch(() => alert('Terjadi kesalahan jaringan.'));
});

function closeSuccess() {
  document.getElementById('successModal').classList.remove('show');
  location.reload();
}
</script>
@endsection
