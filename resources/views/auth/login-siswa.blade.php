<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Siswa — SchoolPay SMKN 7 Baleendah</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;background:#f0f4f8}
.left{flex:1;background:linear-gradient(135deg,#0d1b3e 0%,#1e3a6e 60%,#2563eb 100%);display:flex;flex-direction:column;justify-content:center;align-items:center;padding:48px;position:relative;overflow:hidden}
.left::before{content:'';position:absolute;top:-80px;right:-80px;width:320px;height:320px;border-radius:50%;background:rgba(255,255,255,.04)}
.left::after{content:'';position:absolute;bottom:-60px;left:-60px;width:240px;height:240px;border-radius:50%;background:rgba(37,99,235,.15)}
.brand{text-align:center;position:relative;z-index:1}
.brand-icon{width:72px;height:72px;background:rgba(255,255,255,.12);border-radius:20px;display:inline-flex;align-items:center;justify-content:center;font-size:32px;margin-bottom:20px;border:1px solid rgba(255,255,255,.15)}
.brand-name{font-size:28px;font-weight:800;color:#fff;letter-spacing:-.5px;margin-bottom:6px}
.brand-sub{font-size:13px;color:rgba(255,255,255,.5);letter-spacing:.3px}
.features{margin-top:48px;display:flex;flex-direction:column;gap:16px;width:100%;max-width:320px;position:relative;z-index:1}
.feat{display:flex;align-items:center;gap:14px;padding:14px 16px;background:rgba(255,255,255,.06);border-radius:12px;border:1px solid rgba(255,255,255,.08)}
.feat-icon{font-size:20px;flex-shrink:0}
.feat-text{font-size:13px;color:rgba(255,255,255,.7);line-height:1.4}
.feat-text strong{color:#fff;display:block;font-size:12px;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px}
.right{width:480px;display:flex;flex-direction:column;justify-content:center;padding:48px;background:#fff}
.form-header{margin-bottom:36px}
.form-badge{display:inline-flex;align-items:center;gap:6px;background:#ecfdf5;color:#059669;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;padding:4px 12px;border-radius:20px;margin-bottom:16px}
.form-title{font-size:28px;font-weight:800;color:#0d1b3e;letter-spacing:-.5px;margin-bottom:6px}
.form-sub{font-size:14px;color:#64748b}
.error-box{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;color:#dc2626;font-size:13px;display:flex;align-items:flex-start;gap:8px}
.form-group{margin-bottom:20px}
.form-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.form-label label{font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px}
.form-label a{font-size:11px;color:#2563eb;text-decoration:none}
.form-label a:hover{text-decoration:underline}
.input-wrap{position:relative}
.input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:16px;color:#94a3b8}
input[type=text],input[type=password]{width:100%;padding:13px 14px 13px 42px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:'DM Sans',sans-serif;color:#0d1b3e;transition:.15s;outline:none;background:#fafafa}
input:focus{border-color:#2563eb;background:#fff;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
input.error{border-color:#dc2626}
.field-error{font-size:11px;color:#dc2626;margin-top:4px}
.submit-btn{width:100%;padding:14px;background:#0d1b3e;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;transition:.2s;letter-spacing:.3px;display:flex;align-items:center;justify-content:center;gap:8px}
.submit-btn:hover{background:#162554;transform:translateY(-1px);box-shadow:0 4px 16px rgba(13,27,62,.3)}
.form-footer{margin-top:24px;text-align:center;font-size:12px;color:#94a3b8}
.form-footer a{color:#2563eb;text-decoration:none;font-weight:600}
.form-footer a:hover{text-decoration:underline}
.divider{display:flex;align-items:center;gap:12px;margin:20px 0;color:#cbd5e1;font-size:12px}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:#e5e7eb}
.info-box{background:#f8fafc;border-radius:10px;padding:14px 16px;margin-top:20px;font-size:12px;color:#64748b;line-height:1.6;border:1px solid #e2e8f0}
.info-box strong{color:#0d1b3e}
@media(max-width:768px){.left{display:none}.right{width:100%;padding:32px 24px}}
</style>
</head>
<body>
<div class="left">
  <a href="{{ route('landing') }}" style="position:absolute;top:20px;left:20px;display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.45);text-decoration:none;font-size:12px;font-weight:600;padding:7px 14px;border-radius:8px;border:1px solid rgba(255,255,255,.1);transition:.2s;z-index:10" onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,.08)'" onmouseout="this.style.color='rgba(255,255,255,.45)';this.style.background=''">← Beranda</a>
  <div class="brand">
    <div class="brand-icon"><img src="{{ asset('logo.png') }}" alt="SchoolPay" style="width:36px;height:36px;object-fit:contain"></div>
    <div class="brand-name">SchoolPay</div>
    <div class="brand-sub">SMKN 7 Baleendah — Sistem Informasi SPP</div>
  </div>
  <div class="features">
    <div class="feat">
      <span class="feat-icon">📊</span>
      <div class="feat-text"><strong>Pantau Status SPP</strong>Lihat status pembayaran SPP Anda secara real-time</div>
    </div>
    <div class="feat">
      <span class="feat-icon">🧾</span>
      <div class="feat-text"><strong>Riwayat Lengkap</strong>Akses seluruh riwayat pembayaran dan unduh kwitansi</div>
    </div>
    <div class="feat">
      <span class="feat-icon">🔔</span>
      <div class="feat-text"><strong>Notifikasi Otomatis</strong>Terima notifikasi saat pembayaran berhasil dicatat</div>
    </div>
  </div>
</div>
<div class="right">
  <div class="form-header">
    <div class="form-badge">🎓 Portal Siswa</div>
    <div class="form-title">Masuk ke Akun Anda</div>
    <div class="form-sub">Gunakan NIS dan password untuk mengakses portal siswa</div>
  </div>

  @if(isset($errors) && $errors->any())
  <div class="error-box">
    <span>⚠️</span>
    <span>{{ $errors->first() }}</span>
  </div>
  @endif

  <form method="POST" action="{{ route('login.post') }}">
    @csrf
    <div class="form-group">
      <div class="form-label">
        <label>NIS (Nomor Induk Siswa)</label>
      </div>
      <div class="input-wrap">
        <span class="input-icon">🎓</span>
        <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Contoh: 2024001" autocomplete="username" required class="{{ $errors->has('nis') ? 'error' : '' }}">
      </div>
      @error('nis')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <div class="form-label">
        <label>Password</label>
        <a href="https://wa.me/6285199296848?text=Halo%2C+saya+lupa+password+SchoolPay+NIS+saya" target="_blank" class="forgot-link">Lupa Password?</a>
      </div>
      <div class="input-wrap">
        <span class="input-icon">🔒</span>
        <input type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
      </div>
    </div>

    <button type="submit" class="submit-btn">Masuk ke Portal Siswa →</button>
  </form>

  <div class="info-box">
    <strong>💡 Informasi Login:</strong><br>
    Password default adalah NIS Anda. Hubungi admin jika mengalami kesulitan login.<br>
    Jam layanan: <strong>Senin–Jumat, 08:00–15:00 WIB</strong>
  </div>

  <div class="form-footer" style="margin-top:20px">
    Anda staf sekolah? <a href="{{ route('login.admin') }}">Login sebagai Petugas/Admin →</a>
  </div>
</div>
</body>
</html>
