<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Siswa — {{ $judulPeriode }}</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:DejaVu Sans,Arial,sans-serif;font-size:10px;color:#1e293b;background:#fff}
.page-header{position:relative;background:#0f172a;color:#fff;padding:22px 28px 18px;overflow:hidden}
.page-header::after{content:'';position:absolute;top:0;right:0;width:220px;height:100%;background:linear-gradient(135deg,transparent 40%,rgba(5,150,105,.2))}
.ph-top{display:flex;justify-content:space-between;align-items:flex-start;position:relative;z-index:1}
.ph-brand{display:flex;align-items:center;gap:12px}
.ph-logo{width:40px;height:40px;background:#059669;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.ph-school{font-size:13px;font-weight:700;letter-spacing:-.2px;line-height:1.3}
.ph-school-sub{font-size:9px;color:rgba(255,255,255,.45);margin-top:2px;letter-spacing:.3px}
.ph-doc{text-align:right}
.ph-doc-type{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.4);margin-bottom:4px}
.ph-doc-title{font-size:16px;font-weight:700;letter-spacing:-.3px}
.ph-divider{height:1px;background:rgba(255,255,255,.1);margin:14px 0;position:relative;z-index:1}
.ph-meta{display:flex;gap:28px;position:relative;z-index:1}
.ph-meta-item label{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.35);display:block;margin-bottom:3px}
.ph-meta-item p{font-size:11px;font-weight:600;color:#fff}
.stats-bar{display:flex;background:#f8fafc;border-bottom:1px solid #e2e8f0}
.stat-item{flex:1;padding:14px 20px;border-right:1px solid #e2e8f0;text-align:center}
.stat-item:last-child{border-right:none}
.stat-val{font-size:16px;font-weight:800;color:#0f172a;letter-spacing:-.5px}
.stat-label{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;margin-top:3px}
table{width:100%;border-collapse:collapse}
thead tr{background:#0f172a}
th{padding:9px 12px;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:rgba(255,255,255,.7);text-align:left}
th:first-child{width:28px;text-align:center}
tbody tr:nth-child(even){background:#f8fafc}
td{padding:9px 12px;font-size:9.5px;color:#334155;border-bottom:1px solid #f1f5f9;vertical-align:middle}
td:first-child{text-align:center;color:#94a3b8;font-size:9px}
.mono{font-family:DejaVu Sans Mono,monospace;font-size:8.5px;color:#64748b}
.amount{font-weight:700;color:#0f172a}
.lunas{background:#dcfce7;color:#166534;padding:2px 8px;border-radius:20px;font-size:8px;font-weight:700}
.belum{background:#fef2f2;color:#991b1b;padding:2px 8px;border-radius:20px;font-size:8px;font-weight:700}
.total-row td{background:#0f172a;color:#fff;font-weight:700;font-size:10px;padding:10px 12px;border-bottom:none}
.total-row td.amount{color:#60a5fa;font-size:12px}
.page-footer{display:flex;justify-content:space-between;align-items:center;padding:12px 20px;background:#f8fafc;border-top:2px solid #e2e8f0}
.pf-left{font-size:9px;color:#94a3b8}
.pf-left strong{color:#475569;display:block;margin-bottom:2px}
.pf-right{font-size:8px;color:#cbd5e1;text-align:right}
</style>
</head>
<body>

<div class="page-header">
  <div class="ph-top">
    <div class="ph-brand">
      <div class="ph-logo"><img src="{{ public_path('logo.png') }}" style="width:32px;height:32px;object-fit:contain"></div>
      <div>
        <div class="ph-school">SMKN 7 BALEENDAH</div>
        <div class="ph-school-sub">Jl. Adipati Agung No. 114, Baleendah, Bandung</div>
        <div class="ph-school-sub">SchoolPay — Sistem Informasi Manajemen SPP</div>
      </div>
    </div>
    <div class="ph-doc">
      <div class="ph-doc-type">Dokumen Resmi</div>
      <div class="ph-doc-title">Laporan Data Siswa</div>
    </div>
  </div>
  <div class="ph-divider"></div>
  <div class="ph-meta">
    <div class="ph-meta-item">
      <label>Periode</label>
      <p>{{ $judulPeriode }}</p>
    </div>
    <div class="ph-meta-item">
      <label>Total Siswa</label>
      <p>{{ $siswa->count() }} Siswa</p>
    </div>
    <div class="ph-meta-item">
      <label>Sudah Bayar</label>
      <p>{{ $siswa->where('sudah_bayar',true)->count() }} Siswa</p>
    </div>
    <div class="ph-meta-item">
      <label>Belum Bayar</label>
      <p>{{ $siswa->where('sudah_bayar',false)->count() }} Siswa</p>
    </div>
    <div class="ph-meta-item">
      <label>Dicetak</label>
      <p>{{ now()->format('d M Y, H:i') }} WIB</p>
    </div>
  </div>
</div>

<div class="stats-bar">
  <div class="stat-item">
    <div class="stat-val">{{ $siswa->count() }}</div>
    <div class="stat-label">Total Siswa</div>
  </div>
  <div class="stat-item">
    <div class="stat-val" style="color:#059669">{{ $siswa->where('sudah_bayar',true)->count() }}</div>
    <div class="stat-label">Sudah Bayar</div>
  </div>
  <div class="stat-item">
    <div class="stat-val" style="color:#dc2626">{{ $siswa->where('sudah_bayar',false)->count() }}</div>
    <div class="stat-label">Belum Bayar</div>
  </div>
  <div class="stat-item">
    <div class="stat-val" style="color:#2563eb">Rp {{ number_format($siswa->sum('total_bayar'),0,',','.') }}</div>
    <div class="stat-label">Total Terkumpul</div>
  </div>
</div>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>NIS</th>
      <th>Nama Siswa</th>
      <th>Kelas</th>
      <th>Jenis Kelamin</th>
      <th>Jml Transaksi</th>
      <th>Total Bayar</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($siswa as $i => $s)
    <tr>
      <td>{{ $i+1 }}</td>
      <td class="mono">{{ $s->nis }}</td>
      <td style="font-weight:600;color:#0f172a">{{ $s->nama }}</td>
      <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
      <td>{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
      <td style="text-align:center;font-weight:600">{{ $s->jml_transaksi }}</td>
      <td class="amount">{{ $s->total_bayar > 0 ? 'Rp '.number_format($s->total_bayar,0,',','.') : '—' }}</td>
      <td><span class="{{ $s->sudah_bayar ? 'lunas' : 'belum' }}">{{ $s->sudah_bayar ? 'Sudah Bayar' : 'Belum Bayar' }}</span></td>
    </tr>
    @endforeach
    <tr class="total-row">
      <td colspan="6" style="text-align:right;letter-spacing:.5px">TOTAL KESELURUHAN</td>
      <td class="amount">Rp {{ number_format($siswa->sum('total_bayar'),0,',','.') }}</td>
      <td></td>
    </tr>
  </tbody>
</table>

<div class="page-footer">
  <div class="pf-left">
    <strong>SchoolPay — SMKN 7 Baleendah</strong>
    Dokumen ini dicetak secara otomatis oleh sistem dan sah tanpa tanda tangan. | Made by TEAM PAYFLOW
  </div>
  <div class="pf-right">
    Dicetak: {{ now()->format('d M Y H:i:s') }} WIB<br>
    Periode: {{ $judulPeriode }}
  </div>
</div>

</body>
</html>
