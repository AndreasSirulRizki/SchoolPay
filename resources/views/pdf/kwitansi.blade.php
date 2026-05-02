<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kwitansi {{ $pembayaran->no_transaksi }}</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:DejaVu Sans,Arial,sans-serif;font-size:11px;color:#1e293b;background:#fff;padding:24px}
.wrap{max-width:560px;margin:0 auto}

/* HEADER */
.kw-header{background:#0f172a;color:#fff;border-radius:12px 12px 0 0;padding:20px 24px;position:relative;overflow:hidden}
.kw-header::before{content:'';position:absolute;top:-30px;right:-30px;width:120px;height:120px;border-radius:50%;background:rgba(37,99,235,.2)}
.kw-header::after{content:'';position:absolute;bottom:-20px;left:40%;width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,.03)}
.kw-h-top{display:flex;justify-content:space-between;align-items:flex-start;position:relative;z-index:1}
.kw-brand{display:flex;align-items:center;gap:12px}
.kw-logo{width:42px;height:42px;background:#2563eb;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0}
.kw-school{font-size:12px;font-weight:700;line-height:1.4}
.kw-school-sub{font-size:9px;color:rgba(255,255,255,.45);margin-top:2px}
.kw-badge{background:rgba(37,99,235,.25);border:1px solid rgba(37,99,235,.4);color:#93c5fd;padding:4px 12px;border-radius:20px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:1px;white-space:nowrap}
.kw-divider{height:1px;background:rgba(255,255,255,.1);margin:14px 0;position:relative;z-index:1}
.kw-h-bottom{display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1}
.kw-title{font-size:15px;font-weight:700;letter-spacing:-.2px}
.kw-no{font-size:9px;color:rgba(255,255,255,.45);margin-top:3px;font-family:DejaVu Sans Mono,monospace}

/* STATUS STRIP */
.kw-strip{background:#2563eb;padding:7px 24px;display:flex;justify-content:space-between;align-items:center}
.kw-strip-no{font-size:10px;font-weight:700;color:#fff;letter-spacing:.5px;font-family:DejaVu Sans Mono,monospace}
.kw-strip-status{background:rgba(255,255,255,.2);color:#fff;padding:3px 12px;border-radius:20px;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px}

/* BODY */
.kw-body{border:1px solid #e2e8f0;border-top:none;border-radius:0 0 12px 12px;overflow:hidden}
.kw-section{padding:18px 24px;border-bottom:1px solid #f1f5f9}
.kw-section:last-child{border-bottom:none}
.kw-section-title{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#94a3b8;margin-bottom:12px}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.info-item label{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#94a3b8;display:block;margin-bottom:3px}
.info-item p{font-size:12px;font-weight:600;color:#0f172a}

/* RINCIAN */
.rincian-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f1f5f9;font-size:11px;color:#475569}
.rincian-row:last-child{border-bottom:none;padding-top:12px;margin-top:4px}
.rincian-total{font-size:14px;font-weight:800;color:#0f172a}
.rincian-total-val{font-size:16px;font-weight:800;color:#2563eb}

/* FOOTER */
.kw-footer{display:flex;justify-content:space-between;align-items:flex-end;padding:16px 24px;background:#f8fafc;border-top:1px solid #e2e8f0}
.kw-note{font-size:9px;color:#94a3b8;line-height:1.6;max-width:220px}
.kw-ttd{text-align:center}
.kw-ttd-label{font-size:9px;color:#94a3b8;margin-bottom:36px}
.kw-ttd-name{font-size:10px;font-weight:700;color:#0f172a;border-top:1.5px solid #0f172a;padding-top:5px;min-width:120px}
</style>
</head>
<body>
<div class="wrap">

  <div class="kw-header">
    <div class="kw-h-top">
      <div class="kw-brand">
        <div class="kw-logo"><img src="{{ public_path('logo.png') }}" style="width:26px;height:26px;object-fit:contain"></div>
        <div>
          <div class="kw-school">SMKN 7 BALEENDAH</div>
          <div class="kw-school-sub">Jl. Adipati Agung No. 114, Baleendah, Bandung</div>
          <div class="kw-school-sub">SchoolPay — Sistem Informasi Manajemen SPP</div>
        </div>
      </div>
      <div class="kw-badge">Kwitansi Resmi</div>
    </div>
    <div class="kw-divider"></div>
    <div class="kw-h-bottom">
      <div>
        <div class="kw-title">Bukti Pembayaran SPP</div>
        <div class="kw-no">{{ $pembayaran->no_transaksi }}</div>
      </div>
      <div style="text-align:right;font-size:9px;color:rgba(255,255,255,.5)">
        {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}
      </div>
    </div>
  </div>

  <div class="kw-strip">
    <span class="kw-strip-no">NO: {{ $pembayaran->no_transaksi }}</span>
    <span class="kw-strip-status">✓ {{ ucfirst($pembayaran->status) }}</span>
  </div>

  <div class="kw-body">
    <div class="kw-section">
      <div class="kw-section-title">Data Siswa</div>
      <div class="info-grid">
        <div class="info-item">
          <label>Nama Lengkap</label>
          <p>{{ $pembayaran->siswa->nama }}</p>
        </div>
        <div class="info-item">
          <label>NIS</label>
          <p style="font-family:DejaVu Sans Mono,monospace">{{ $pembayaran->siswa->nis }}</p>
        </div>
        <div class="info-item">
          <label>Kelas</label>
          <p>{{ $pembayaran->siswa->kelas->nama_kelas ?? '-' }}</p>
        </div>
        <div class="info-item">
          <label>Periode SPP</label>
          <p>{{ $pembayaran->nama_bulan }} {{ $pembayaran->tahun }}</p>
        </div>
      </div>
    </div>

    <div class="kw-section">
      <div class="kw-section-title">Rincian Pembayaran</div>
      <div class="rincian-row">
        <span>Nominal SPP ({{ $pembayaran->tarif->nama_tarif ?? 'SPP Reguler' }})</span>
        <span style="font-weight:600">Rp {{ number_format($pembayaran->jumlah_bayar ?? ($pembayaran->total_bayar - ($pembayaran->biaya_admin ?? 0)),0,',','.') }}</span>
      </div>
      <div class="rincian-row">
        <span>Biaya Administrasi</span>
        <span style="font-weight:600">Rp {{ number_format($pembayaran->biaya_admin ?? 0,0,',','.') }}</span>
      </div>
      <div class="rincian-row">
        <span class="rincian-total">Total Dibayar</span>
        <span class="rincian-total-val">Rp {{ number_format($pembayaran->total_bayar,0,',','.') }}</span>
      </div>
    </div>

    <div class="kw-section">
      <div class="info-grid">
        <div class="info-item">
          <label>Metode Pembayaran</label>
          <p>{{ ucfirst($pembayaran->metode_bayar) }}</p>
        </div>
        <div class="info-item">
          <label>Tanggal Bayar</label>
          <p>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y, H:i') }}</p>
        </div>
      </div>
    </div>

    <div class="kw-footer">
      <div class="kw-note">
        Kwitansi ini merupakan bukti pembayaran yang sah.<br>
        Simpan sebagai arsip pembayaran SPP Anda.<br>
        Dicetak: {{ now()->format('d M Y H:i') }} WIB<br>
        <span style="color:#cbd5e1">Made by TEAM PAYFLOW</span>
      </div>
      <div class="kw-ttd">
        <div class="kw-ttd-label">Petugas SPP</div>
        <div class="kw-ttd-name">{{ $pembayaran->petugas->name ?? 'Petugas' }}</div>
      </div>
    </div>
  </div>

</div>
</body>
</html>
