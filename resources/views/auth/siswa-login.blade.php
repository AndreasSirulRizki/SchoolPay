@extends('layouts.guest')
@section('title', 'Login Siswa')
@section('styles')
<style>
body{background:linear-gradient(145deg,#fffbeb 0%,#fef3c7 50%,#fde68a 100%);min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px}
:root{--navy:#0d1b3e;--navy-2:#162554;--amber:#d97706;--red:#dc2626;--red-2:#b91c1c;--bg:#f0f4f8;--border:#e2e8f0;--text-1:#0d1b3e;--text-2:#475569;--text-3:#94a3b8;--serif:'Instrument Serif',serif}
.login-back{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-2);font-weight:500;margin-bottom:28px;transition:color .2s;text-decoration:none;position:absolute;top:32px;left:40px}
.login-back:hover{color:var(--amber)}
.login-box{background:#fff;border-radius:20px;width:100%;max-width:440px;box-shadow:0 8px 48px rgba(13,27,62,.1),0 0 0 1px rgba(13,27,62,.06);overflow:hidden;animation:fadeUp .45s ease}
.login-top{padding:36px 36px 28px;text-align:center;border-bottom:1px solid var(--border)}
.login-icon-wrap{width:56px;height:56px;background:var(--amber);border-radius:14px;display:grid;place-items:center;font-size:24px;margin:0 auto 16px}
.login-title{font-family:var(--serif);font-size:22px;color:var(--navy);margin-bottom:4px}
.login-sub{font-size:13px;color:var(--text-3)}
.login-form{padding:28px 36px}
.login-error{background:#fef2f2;border:1px solid #fecaca;border-left:3px solid var(--red);border-radius:9px;padding:11px 14px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:13px;color:var(--red-2)}
.lf-group{margin-bottom:18px}
.lf-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--text-3);display:block;margin-bottom:7px}
.lf-input{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;color:var(--text-1);background:var(--bg);transition:.2s;outline:none}
.lf-input:focus{border-color:var(--amber);background:#fff;box-shadow:0 0 0 3px rgba(217,119,6,.08)}
.lf-input.error{border-color:var(--red)}
.lf-btn{width:100%;padding:13px;background:var(--amber);color:#fff;border:none;border-radius:10px;font-family:inherit;font-size:14px;font-weight:700;cursor:pointer;transition:.25s;letter-spacing:.5px;text-transform:uppercase;margin-top:4px}
.lf-btn:hover{background:#b45309;transform:translateY(-1px);box-shadow:0 8px 24px rgba(217,119,6,.3)}
.login-footer-row{padding:16px 36px;background:var(--bg);display:flex;justify-content:space-between;align-items:center}
.hint-box{background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:14px 16px;margin-bottom:18px;font-size:12px;color:#92400e}
.hint-box strong{display:block;margin-bottom:4px;font-weight:700}
</style>
@endsection
@section('content')
<a href="/" class="login-back">← Kembali ke Beranda</a>

<div class="login-box">
  <div class="login-top">
    <div class="login-icon-wrap">🎓</div>
    <div class="login-title">Portal Siswa</div>
    <div class="login-sub">SchoolPay — SMKN 7 Baleendah</div>
  </div>

  <div class="login-form">
    @if($errors->any())
      <div class="login-error">⚠️ {{ $errors->first() }}</div>
    @endif

    <div class="hint-box">
      <strong>Login menggunakan NIS Anda</strong>
      Password default: NIS Anda (contoh: 2024001)
    </div>

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="lf-group">
        <label class="lf-label" for="nis">NIS (Nomor Induk Siswa)</label>
        <input type="text" id="nis" name="nis" class="lf-input {{ $errors->has('nis') ? 'error' : '' }}"
               value="{{ old('nis') }}" placeholder="Masukkan NIS Anda" required autofocus>
      </div>
      <div class="lf-group">
        <label class="lf-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="lf-input {{ $errors->has('password') ? 'error' : '' }}"
               placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="lf-btn">Masuk →</button>
    </form>

    <div style="text-align:center;margin-top:16px;font-size:12px;color:var(--text-3)">
      Login sebagai staff? <a href="{{ route('login.admin') }}" style="color:var(--navy);font-weight:600">Klik di sini</a>
    </div>
  </div>

  <div class="login-footer-row">
    <span style="font-size:11px;color:var(--text-3);font-weight:600">Portal Siswa v1.0</span>
    <span style="font-size:11px;color:var(--text-3)">© {{ date('Y') }} SMKN 7 Baleendah</span>
  </div>
</div>
@endsection
