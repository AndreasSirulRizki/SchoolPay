<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan SPP — {{ $judulPeriode ?? $namaBulan[$bulan].' '.$tahun }}</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:DejaVu Sans,Arial,sans-serif;font-size:10px;color:#1e293b;background:#fff}

/* HEADER */
.page-header{position:relative;background:#0f172a;color:#fff;padding:22px 28px 18px;margin-bottom:0;overflow:hidden}
.page-header::after{content:'';position:absolute;top:0;right:0;width:220px;height:100%;background:linear-gradient(135deg,transparent 40%,rgba(37,99,235,.25))}
.ph-top{display:flex;justify-content:space-between;align-items:flex-start;position:relative;z-index:1}
.ph-brand{display:flex;align-items:center;gap:12px}
.ph-logo{width:40px;height:40px;background:#2563eb;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.ph-school{font-size:13px;font-weight:700;letter-spacing:-.2px;line-height:1.3}
.ph-school-sub{font-size:9px;color:rgba(255,255,255,.45);margin-top:2px;letter-spacing:.3px}
.ph-doc{text-align:right}
.ph-doc-type{font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.4);margin-bottom:4px}
.ph-doc-title{font-size:16px;font-weight:700;letter-spacing:-.3px}
.ph-divider{height:1px;background:rgba(255,255,255,.1);margin:14px 0;position:relative;z-index:1}
.ph-meta{display:flex;gap:28px;position:relative;z-index:1}
.ph-meta-item label{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.35);display:block;margin-bottom:3px}
.ph-meta-item p{font-size:11px;font-weight:600;color:#fff}

/* STATS BAR */
.stats-bar{display:flex;background:#f8fafc;border-bottom:1px solid #e2e8f0}
.stat-item{flex:1;padding:14px 20px;border-right:1px solid #e2e8f0;text-align:center}
.stat-item:last-child{border-right:none}
.stat-val{font-size:16px;font-weight:800;color:#0f172a;letter-spacing:-.5px}
.stat-val.blue{color:#2563eb}
.stat-val.green{color:#059669}
.stat-label{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;margin-top:3px}

/* TABLE */
.table-wrap{padding:0}
table{width:100%;border-collapse:collapse}
thead tr{background:#0f172a}
th{padding:9px 12px;font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:rgba(255,255,255,.7);text-align:left}
th:first-child{width:28px;text-align:center}
tbody tr:nth-child(even){background:#f8fafc}
tbody tr:hover{background:#eff6ff}
td{padding:9px 12px;font-size:9.5px;color:#334155;border-bottom:1px solid #f1f5f9;vertical-align:middle}
td:first-child{text-align:center;color:#94a3b8;font-size:9px}
.mono{font-family:DejaVu Sans Mono,monospace;font-size:8.5px;color:#64748b}
.amount{font-weight:700;color:#0f172a}
.badge-lunas{background:#dcfce7;color:#166534;padding:2px 8px;border-radius:20px;font-size:8px;font-weight:700}
.badge-pending{background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:20px;font-size:8px;font-weight:700}

/* TOTAL ROW */
.total-row td{background:#0f172a;color:#fff;font-weight:700;font-size:10px;padding:10px 12px;border-bottom:none}
.total-row td.amount{color:#60a5fa;font-size:12px}

/* FOOTER */
.page-footer{display:flex;justify-content:space-between;align-items:center;padding:12px 20px;background:#f8fafc;border-top:2px solid #e2e8f0;margin-top:0}
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
      <div class="ph-doc-title">Laporan Pembayaran SPP</div>
    </div>
  </div>
  <div class="ph-divider"></div>
  <div class="ph-meta">
    <div class="ph-meta-item">
      <label>Periode</label>
      <p>{{ $judulPeriode ?? $namaBulan[$bulan].' '.$tahun }}</p>
    </div>
    <div class="ph-meta-item">
      <label>Total Transaksi</label>
      <p>{{ $pembayaran->count() }} Transaksi</p>
    </div>
    <div class="ph-meta-item">
      <label>Total Pendapatan</label>
      <p>Rp {{ number_format($pembayaran->sum('total_bayar'),0,',','.') }}</p>
    </div>
    <div class="ph-meta-item">
      <label>Dicetak</label>
      <p>{{ now()->format('d M Y, H:i') }} WIB</p>
    </div>
  </div>
</div>

<div class="stats-bar">
  <div class="stat-item">
    <div class="stat-val">{{ $pembayaran->count() }}</div>
    <div class="stat-label">Total Transaksi</div>
  </div>
  <div class="stat-item">
    <div class="stat-val green">{{ $pembayaran->where('status','lunas')->count() }}</div>
    <div class="stat-label">Lunas</div>
  </div>
  <div class="stat-item">
    <div class="stat-val" style="color:#d97706">{{ $pembayaran->where('status','pending')->count() }}</div>
    <div class="stat-label">Pending</div>
  </div>
  <div class="stat-item">
    <div class="stat-val blue">Rp {{ number_format($pembayaran->sum('total_bayar'),0,',','.') }}</div>
    <div class="stat-label">Total Pendapatan</div>
  </div>
</div>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>No. Transaksi</th>
        <th>Nama Siswa</th>
        <th>NIS</th>
        <th>Kelas</th>
        <th>Bulan</th>
        <th>Total Bayar</th>
        <th>Metode</th>
        <th>Tgl Bayar</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pembayaran as $i => $p)
      <tr>
        <td>{{ $i+1 }}</td>
        <td class="mono">{{ $p->no_transaksi }}</td>
        <td style="font-weight:600;color:#0f172a">{{ $p->siswa->nama ?? '-' }}</td>
        <td class="mono">{{ $p->siswa->nis ?? '-' }}</td>
        <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
        <td>{{ $p->nama_bulan }}</td>
        <td class="amount">Rp {{ number_format($p->total_bayar,0,',','.') }}</td>
        <td>{{ ucfirst($p->metode_bayar) }}</td>
        <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
        <td><span class="badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
      </tr>
      @endforeach
      <tr class="total-row">
        <td colspan="6" style="text-align:right;letter-spacing:.5px">TOTAL KESELURUHAN</td>
        <td class="amount">Rp {{ number_format($pembayaran->sum('total_bayar'),0,',','.') }}</td>
        <td colspan="3"></td>
      </tr>
    </tbody>
  </table>
</div>

<div class="page-footer">
  <div class="pf-left">
    <strong>SchoolPay — SMKN 7 Baleendah</strong>
    Dokumen ini dicetak secara otomatis oleh sistem dan sah tanpa tanda tangan. | Made by TEAM PAYFLOW
  </div>
  <div class="pf-right">
    Dicetak: {{ now()->format('d M Y H:i:s') }} WIB<br>
    Periode: {{ $judulPeriode ?? $namaBulan[$bulan].' '.$tahun }}
  </div>
</div>

</body>
</html>
