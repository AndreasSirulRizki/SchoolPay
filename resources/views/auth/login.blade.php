<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login {{ ucfirst($role) }} — SchoolPay</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:#0d1b3e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.card{background:#fff;border-radius:20px;width:100%;max-width:420px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.4)}
.card-header{background:#0d1b3e;padding:28px 32px 24px;position:relative}
.back-btn{position:absolute;top:20px;left:20px;width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.08);border:none;cursor:pointer;color:rgba(255,255,255,.6);font-size:16px;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:.15s}
.back-btn:hover{background:rgba(255,255,255,.15);color:#fff}
.role-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px}
.badge-admin{background:rgba(37,99,235,.3);color:#93c5fd}
.badge-petugas{background:rgba(217,119,6,.3);color:#fcd34d}
.badge-siswa{background:rgba(5,150,105,.3);color:#6ee7b7}
.card-title{font-size:22px;font-weight:800;color:#fff;letter-spacing:-.5px}
.card-sub{font-size:12px;color:rgba(255,255,255,.35);margin-top:4px}
.card-body{padding:28px 32px}
.error-banner{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;color:#dc2626;font-size:13px;display:flex;align-items:center;gap:8px}
.form-group{margin-bottom:18px}
.form-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}
label{font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px}
.forgot-link{font-size:11px;color:#2563eb;text-decoration:none}
.forgot-link:hover{text-decoration:underline}
input[type=text],input[type=password]{width:100%;padding:12px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:'DM Sans',sans-serif;color:#0d1b3e;transition:.15s;outline:none}
input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.submit-btn{width:100%;padding:14px;background:#0d1b3e;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;transition:.2s;letter-spacing:.3px;margin-top:4px}
.submit-btn:hover{background:#162554}
.card-footer{padding:16px 32px;border-top:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center}
.footer-version{font-size:11px;color:#9ca3af;font-weight:600}
.footer-links{display:flex;gap:12px}
.footer-links a{font-size:11px;color:#9ca3af;text-decoration:none}
.footer-links a:hover{color:#2563eb}
.page-footer{text-align:center;margin-top:20px;font-size:11px;color:rgba(255,255,255,.2)}
</style>
</head>
<body>
<div>
<div class="card">
  <div class="card-header">
    <a href="{{ route('login') }}" class="back-btn">←</a>
    <div class="role-badge badge-{{ $role }}">{{ strtoupper($role) }}</div>
    <div class="card-title">Selamat Datang</div>
    <div class="card-sub">Masuk ke portal {{ $role === 'siswa' ? 'akademik' : 'administrasi' }} SchoolPay</div>
  </div>
  <div class="card-body">
    @if(isset($errors) && $errors->any())
    <div class="error-banner">
      <span>⚠</span>
      <span>Kredensial tidak valid. Harap verifikasi username dan password Anda.</span>
    </div>
    @endif

    @if($role === 'siswa')
    <form method="POST" action="{{ route('siswa.login.post') }}">
    @else
    <form method="POST" action="{{ route('login.post') }}">
    <input type="hidden" name="role" value="{{ $role }}">
    @endif
    @csrf

    <div class="form-group">
      <label>{{ $role === 'siswa' ? 'NIS' : 'Username' }}</label>
      <input type="text" name="{{ $role === 'siswa' ? 'nis' : 'username' }}"
             value="{{ old($role === 'siswa' ? 'nis' : 'username') }}"
             placeholder="{{ $role === 'siswa' ? 'Masukkan NIS Anda' : 'Masukkan username' }}"
             autocomplete="username" required>
    </div>

    <div class="form-group">
      <div class="form-row">
        <label>Password</label>
        <a href="https://wa.me/6285199296848?text=Halo%2C+saya+lupa+password+SchoolPay" target="_blank" class="forgot-link">FORGOT PASSWORD?</a>
      </div>
      <input type="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
    </div>

    <button type="submit" class="submit-btn">AUTHENTICATE →</button>
    </form>
  </div>
  <div class="card-footer">
    <span class="footer-version">V2.4.0 STABLE</span>
    <div class="footer-links">
      <a href="#">HELP CENTER</a>
      <a href="#">SECURITY</a>
    </div>
  </div>
</div>
<div class="page-footer">© 2026 SchoolPay SMKN 7 Baleendah. All Rights Reserved.</div>
</div>
</body>
</html>
