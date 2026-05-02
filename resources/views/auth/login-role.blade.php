<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pilih Role — SchoolPay SMKN 7 Baleendah</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:#0d1b3e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.wrap{width:100%;max-width:400px;text-align:center}
.logo-box{margin-bottom:36px}
.logo-icon{width:64px;height:64px;background:#2563eb;border-radius:18px;display:inline-flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:16px}
.logo-title{font-size:22px;font-weight:800;color:#fff;letter-spacing:-.5px}
.logo-sub{font-size:12px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:1.5px;margin-top:4px}
.role-stack{display:flex;flex-direction:column;gap:0;margin-bottom:28px}
.role-btn{display:block;width:100%;padding:16px 24px;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:700;text-decoration:none;transition:.2s;position:relative;text-align:left}
.role-btn .rb-label{font-size:14px;letter-spacing:.5px;text-transform:uppercase}
.role-btn .rb-desc{font-size:11px;opacity:.6;margin-top:2px;font-weight:400}
.role-btn .rb-arrow{position:absolute;right:20px;top:50%;transform:translateY(-50%);font-size:18px;opacity:.5}
.role-btn:hover .rb-arrow{opacity:1;right:16px}
.role-siswa{background:rgba(255,255,255,.06);color:rgba(255,255,255,.7);border-radius:12px 12px 0 0;border-bottom:1px solid rgba(255,255,255,.05)}
.role-siswa:hover{background:rgba(255,255,255,.1);color:#fff}
.role-petugas{background:rgba(37,99,235,.15);color:rgba(255,255,255,.85);border-bottom:1px solid rgba(37,99,235,.1)}
.role-petugas:hover{background:rgba(37,99,235,.25);color:#fff}
.role-admin{background:#2563eb;color:#fff;border-radius:0 0 12px 12px;padding:20px 24px}
.role-admin .rb-label{font-size:16px}
.role-admin:hover{background:#1d4ed8}
.footer-copy{font-size:11px;color:rgba(255,255,255,.2)}
</style>
</head>
<body>
<div class="wrap">
  <a href="{{ route('landing') }}" style="position:fixed;top:20px;left:20px;display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.45);text-decoration:none;font-size:12px;font-weight:600;padding:7px 14px;border-radius:8px;border:1px solid rgba(255,255,255,.1);transition:.2s;z-index:10" onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,.08)'" onmouseout="this.style.color='rgba(255,255,255,.45)';this.style.background=''">← Beranda</a>
  <div class="logo-box">
    <div class="logo-icon"><img src="{{ asset('logo.png') }}" alt="SchoolPay" style="width:36px;height:36px;object-fit:contain"></div>
    <div class="logo-title">SchoolPay</div>
    <div class="logo-sub">SMKN 7 Baleendah</div>
  </div>

  <div class="role-stack">
    <a href="{{ route('login.form', 'siswa') }}" class="role-btn role-siswa">
      <div class="rb-label">Siswa</div>
      <div class="rb-desc">Login menggunakan NIS</div>
      <span class="rb-arrow">→</span>
    </a>
    <a href="{{ route('login.form', 'petugas') }}" class="role-btn role-petugas">
      <div class="rb-label">Petugas</div>
      <div class="rb-desc">Staff administrasi keuangan</div>
      <span class="rb-arrow">→</span>
    </a>
    <a href="{{ route('login.form', 'admin') }}" class="role-btn role-admin">
      <div class="rb-label">Administrator</div>
      <div class="rb-desc">Akses penuh sistem</div>
      <span class="rb-arrow">→</span>
    </a>
  </div>

  <div class="footer-copy">© 2026 SchoolPay SMKN 7 Baleendah. All Rights Reserved.</div>
</div>
</body>
</html>
