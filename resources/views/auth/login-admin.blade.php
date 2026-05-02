<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Staff — SchoolPay SMKN 7 Baleendah</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;background:#f0f4f8}
.left{flex:1;background:linear-gradient(135deg,#0d1b3e 0%,#162554 50%,#1e3a6e 100%);display:flex;flex-direction:column;justify-content:center;align-items:center;padding:48px;position:relative;overflow:hidden}
.left::before{content:'';position:absolute;top:-80px;right:-80px;width:320px;height:320px;border-radius:50%;background:rgba(255,255,255,.03)}
.left::after{content:'';position:absolute;bottom:-60px;left:-60px;width:240px;height:240px;border-radius:50%;background:rgba(37,99,235,.1)}
.brand{text-align:center;position:relative;z-index:1}
.brand-icon{width:72px;height:72px;background:rgba(255,255,255,.1);border-radius:20px;display:inline-flex;align-items:center;justify-content:center;font-size:32px;margin-bottom:20px;border:1px solid rgba(255,255,255,.12)}
.brand-name{font-size:28px;font-weight:800;color:#fff;letter-spacing:-.5px;margin-bottom:6px}
.brand-sub{font-size:13px;color:rgba(255,255,255,.45);letter-spacing:.3px}
.role-cards{margin-top:48px;display:flex;flex-direction:column;gap:12px;width:100%;max-width:300px;position:relative;z-index:1}
.role-card{padding:14px 16px;background:rgba(255,255,255,.05);border-radius:12px;border:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:12px}
.role-card-icon{font-size:22px;flex-shrink:0}
.role-card-text strong{display:block;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px}
.role-card-text span{font-size:12px;color:rgba(255,255,255,.5)}
.right{width:480px;display:flex;flex-direction:column;justify-content:center;padding:48px;background:#fff}
.form-header{margin-bottom:32px}
.form-badge{display:inline-flex;align-items:center;gap:6px;background:#eff6ff;color:#2563eb;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;padding:4px 12px;border-radius:20px;margin-bottom:16px}
.form-title{font-size:28px;font-weight:800;color:#0d1b3e;letter-spacing:-.5px;margin-bottom:6px}
.form-sub{font-size:14px;color:#64748b}
.error-box{background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;color:#dc2626;font-size:13px;display:flex;align-items:flex-start;gap:8px}
.role-tabs{display:flex;gap:8px;margin-bottom:24px;background:#f8fafc;border-radius:10px;padding:4px}
.role-tab{flex:1;padding:9px;border-radius:8px;border:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;color:#64748b;cursor:pointer;transition:.15s;display:flex;align-items:center;justify-content:center;gap:6px}
.role-tab.active{background:#fff;color:#0d1b3e;box-shadow:0 1px 4px rgba(0,0,0,.1)}
.form-group{margin-bottom:20px}
.form-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.form-label label{font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px}
.form-label a{font-size:11px;color:#2563eb;text-decoration:none}
.input-wrap{position:relative}
.input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:16px;color:#94a3b8}
input[type=text],input[type=password]{width:100%;padding:13px 14px 13px 42px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:'DM Sans',sans-serif;color:#0d1b3e;transition:.15s;outline:none;background:#fafafa}
input:focus{border-color:#2563eb;background:#fff;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.submit-btn{width:100%;padding:14px;background:#0d1b3e;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;transition:.2s;letter-spacing:.3px;display:flex;align-items:center;justify-content:center;gap:8px}
.submit-btn:hover{background:#162554;transform:translateY(-1px);box-shadow:0 4px 16px rgba(13,27,62,.3)}
.form-footer{margin-top:20px;text-align:center;font-size:12px;color:#94a3b8}
.form-footer a{color:#2563eb;text-decoration:none;font-weight:600}
.security-note{display:flex;align-items:center;gap:8px;margin-top:20px;padding:12px 14px;background:#f8fafc;border-radius:10px;font-size:12px;color:#64748b;border:1px solid #e2e8f0}
@media(max-width:768px){.left{display:none}.right{width:100%;padding:32px 24px}}
</style>
</head>
<body>
<div class="left">
  <a href="{{ route('landing') }}" style="position:absolute;top:20px;left:20px;display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,.45);text-decoration:none;font-size:12px;font-weight:600;padding:7px 14px;border-radius:8px;border:1px solid rgba(255,255,255,.1);transition:.2s;z-index:10" onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,.08)'" onmouseout="this.style.color='rgba(255,255,255,.45)';this.style.background=''">← Beranda</a>
  <div class="brand">
    <div class="brand-icon"><img src="{{ asset('logo.png') }}" alt="SchoolPay" style="width:36px;height:36px;object-fit:contain"></div>
    <div class="brand-name">SchoolPay</div>
    <div class="brand-sub">Portal Administrasi — SMKN 7 Baleendah</div>
  </div>
  <div class="role-cards">
    <div class="role-card">
      <span class="role-card-icon">👑</span>
      <div class="role-card-text">
        <strong>Administrator</strong>
        <span>Akses penuh ke seluruh sistem</span>
      </div>
    </div>
    <div class="role-card">
      <span class="role-card-icon">👤</span>
      <div class="role-card-text">
        <strong>Petugas SPP</strong>
        <span>Entry transaksi & laporan</span>
      </div>
    </div>
  </div>
</div>
<div class="right">
  <div class="form-header">
    <div class="form-badge">🛡️ Portal Staff</div>
    <div class="form-title">Login Administrasi</div>
    <div class="form-sub">Masuk dengan akun staff yang telah terdaftar</div>
  </div>

  @if(isset($errors) && $errors->any())
  <div class="error-box">
    <span>⚠️</span>
    <span>{{ $errors->first() }}</span>
  </div>
  @endif

  <form method="POST" action="{{ route('login.admin.post') }}" id="loginForm">
    @csrf

    <!-- Role Tabs -->
    <div class="role-tabs">
      <button type="button" class="role-tab {{ old('role','petugas') === 'petugas' ? 'active' : '' }}" onclick="setRole('petugas')">
        👤 Petugas
      </button>
      <button type="button" class="role-tab {{ old('role') === 'admin' ? 'active' : '' }}" onclick="setRole('admin')">
        👑 Administrator
      </button>
    </div>
    <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'petugas') }}">

    <div class="form-group">
      <div class="form-label">
        <label>Username</label>
      </div>
      <div class="input-wrap">
        <span class="input-icon">👤</span>
        <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" autocomplete="username" required>
      </div>
      @error('username')<div style="font-size:11px;color:#dc2626;margin-top:4px">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <div class="form-label">
        <label>Password</label>
        <a href="https://wa.me/6285199296848?text=Halo%2C+saya+lupa+password+akun+staff+SchoolPay" target="_blank">Lupa Password?</a>
      </div>
      <div class="input-wrap">
        <span class="input-icon">🔒</span>
        <input type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
      </div>
    </div>

    <button type="submit" class="submit-btn">Masuk ke Sistem →</button>
  </form>

  <div class="security-note">
    🔐 Koneksi aman. Sesi akan berakhir otomatis setelah tidak aktif.
  </div>

  <div class="form-footer">
    Anda siswa? <a href="{{ route('login') }}">Login sebagai Siswa →</a>
  </div>
</div>
<script>
function setRole(role) {
  document.getElementById('roleInput').value = role;
  document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
  event.currentTarget.classList.add('active');
}
</script>
</body>
</html>
