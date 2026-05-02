@extends('layouts.guest')
@section('title', 'Beranda')
@section('styles')
<style>
#landing{min-height:100vh;background:#060d1f;color:#fff}
.land-nav{display:flex;align-items:center;justify-content:space-between;padding:0 64px;height:68px;position:fixed;top:0;left:0;right:0;z-index:100;background:rgba(6,13,31,.88);backdrop-filter:blur(20px);border-bottom:1px solid rgba(255,255,255,.06)}
.land-logo{display:flex;align-items:center;gap:12px;text-decoration:none}
.land-logo-icon{width:36px;height:36px;background:linear-gradient(135deg,#2563eb,#3b82f6);border-radius:10px;display:grid;place-items:center;font-size:16px;box-shadow:0 4px 14px rgba(37,99,235,.4)}
.land-logo-text{font-size:16px;font-weight:800;letter-spacing:-.4px;color:#fff}
.land-logo-sub{font-size:9px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:1.5px;margin-top:1px}
.land-nav-links{display:flex;gap:32px;list-style:none}
.land-nav-links a{color:rgba(255,255,255,.5);text-decoration:none;font-size:13px;font-weight:500;transition:color .2s}
.land-nav-links a:hover{color:#fff}
.land-nav-right{display:flex;align-items:center;gap:10px}
.land-nav-ghost{color:rgba(255,255,255,.6);text-decoration:none;font-size:13px;font-weight:600;padding:8px 16px;border-radius:8px;transition:.2s}
.land-nav-ghost:hover{color:#fff;background:rgba(255,255,255,.06)}
.land-nav-cta{background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;border:none;padding:9px 20px;border-radius:8px;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:.2s;text-decoration:none;box-shadow:0 4px 14px rgba(37,99,235,.35)}
.land-nav-cta:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(37,99,235,.5)}
.hero{min-height:100vh;display:grid;place-items:center;padding:120px 64px 80px;position:relative;overflow:hidden;text-align:center}
.hero-bg{position:absolute;inset:0;background:radial-gradient(ellipse 80% 55% at 50% -10%,rgba(37,99,235,.22) 0%,transparent 65%)}
.hero-glow{position:absolute;top:30%;left:50%;transform:translate(-50%,-50%);width:600px;height:600px;background:radial-gradient(circle,rgba(37,99,235,.07) 0%,transparent 70%);pointer-events:none}
.hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);background-size:60px 60px}
.hero-inner{position:relative;z-index:1;max-width:760px;animation:fadeUp .8s ease}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(37,99,235,.1);border:1px solid rgba(37,99,235,.2);border-radius:100px;padding:6px 18px;margin-bottom:32px;font-size:11px;font-weight:700;color:rgba(255,255,255,.7);letter-spacing:1px;text-transform:uppercase}
.hero-badge-dot{width:6px;height:6px;border-radius:50%;background:#22d3ee;box-shadow:0 0 8px #22d3ee;animation:pulse 2s ease infinite}
.hero h1{font-family:'Instrument Serif',serif;font-size:clamp(44px,6.5vw,82px);font-weight:400;line-height:1.04;margin-bottom:26px;letter-spacing:-1.5px}
.hero h1 em{font-style:italic;background:linear-gradient(135deg,#93c5fd,#60a5fa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.hero p{font-size:17px;color:rgba(255,255,255,.5);margin-bottom:44px;line-height:1.85;max-width:500px;margin-left:auto;margin-right:auto}
.hero-btns{display:flex;gap:12px;align-items:center;justify-content:center;flex-wrap:wrap}
.btn-hero-primary{background:#fff;color:#060d1f;border:none;padding:15px 32px;border-radius:10px;font-family:inherit;font-size:14px;font-weight:800;cursor:pointer;transition:.25s;display:inline-flex;align-items:center;gap:8px;text-decoration:none}
.btn-hero-primary:hover{transform:translateY(-2px);box-shadow:0 14px 40px rgba(255,255,255,.18)}
.btn-hero-ghost{background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);border:1px solid rgba(255,255,255,.12);padding:15px 28px;border-radius:10px;font-family:inherit;font-size:14px;font-weight:600;cursor:pointer;transition:.25s;text-decoration:none}
.btn-hero-ghost:hover{background:rgba(255,255,255,.09);color:#fff;border-color:rgba(255,255,255,.2)}
.hero-stats{display:flex;gap:0;justify-content:center;margin-top:72px;border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden;background:rgba(255,255,255,.03);max-width:580px;margin-left:auto;margin-right:auto}
.hero-stat{flex:1;padding:22px 16px;text-align:center;border-right:1px solid rgba(255,255,255,.07)}
.hero-stat:last-child{border-right:none}
.hs-val{font-size:24px;font-weight:800;color:#fff;letter-spacing:-1px}
.hs-label{font-size:10px;color:rgba(255,255,255,.35);margin-top:4px;text-transform:uppercase;letter-spacing:.8px}
.marquee-band{padding:18px 0;background:rgba(37,99,235,.07);border-top:1px solid rgba(37,99,235,.12);border-bottom:1px solid rgba(37,99,235,.12);overflow:hidden;white-space:nowrap}
.marquee-inner{display:inline-flex;gap:48px;animation:marquee 22s linear infinite}
.marquee-item{font-size:11px;font-weight:700;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:2px;display:inline-flex;align-items:center;gap:12px}
.marquee-item::before{content:'✦';color:#3b82f6;font-size:8px}
@keyframes marquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}
.features-section{padding:110px 64px;background:#060d1f}
.section-label{display:inline-flex;align-items:center;gap:8px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:2.5px;color:#3b82f6;margin-bottom:14px}
.section-label::before{content:'';width:20px;height:1px;background:#3b82f6}
.section-title{font-family:'Instrument Serif',serif;font-size:clamp(30px,4vw,50px);color:#fff;line-height:1.12;margin-bottom:14px;letter-spacing:-.5px}
.section-sub{font-size:15px;color:rgba(255,255,255,.38);max-width:440px;line-height:1.75}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:rgba(255,255,255,.06);border-radius:20px;overflow:hidden;margin-top:64px;border:1px solid rgba(255,255,255,.06)}
.feat-card{background:#060d1f;padding:32px 28px;transition:.3s}
.feat-card:hover{background:rgba(37,99,235,.05)}
.feat-icon{width:46px;height:46px;border-radius:12px;display:grid;place-items:center;font-size:20px;margin-bottom:20px}
.fi-b{background:rgba(37,99,235,.12)}
.fi-g{background:rgba(5,150,105,.12)}
.fi-a{background:rgba(217,119,6,.12)}
.feat-card h3{font-size:15px;font-weight:700;color:#fff;margin-bottom:8px}
.feat-card p{font-size:13px;color:rgba(255,255,255,.38);line-height:1.75}
.how-section{padding:110px 64px;background:rgba(255,255,255,.015)}
.steps-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:32px;margin-top:64px;position:relative}
.steps-grid::before{content:'';position:absolute;top:28px;left:calc(16.66% + 16px);right:calc(16.66% + 16px);height:1px;background:linear-gradient(90deg,transparent,rgba(37,99,235,.3),rgba(37,99,235,.3),transparent)}
.step-card{text-align:center;padding:32px 24px}
.step-num{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#1e3a6e,#2563eb);border:1px solid rgba(37,99,235,.3);display:inline-flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;color:#fff;margin-bottom:20px;position:relative;z-index:1}
.step-card h3{font-size:16px;font-weight:700;color:#fff;margin-bottom:10px}
.step-card p{font-size:13px;color:rgba(255,255,255,.38);line-height:1.75}
.faq-section{padding:110px 64px;background:#060d1f}
.faq-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:64px;max-width:900px}
.faq-item{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:14px;overflow:hidden}
.faq-q{padding:18px 22px;font-size:14px;font-weight:600;color:#fff;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:12px;user-select:none}
.faq-q:hover{background:rgba(255,255,255,.03)}
.faq-icon{font-size:16px;color:rgba(255,255,255,.3);flex-shrink:0;transition:.2s}
.faq-a{padding:0 22px;max-height:0;overflow:hidden;transition:max-height .3s ease}
.faq-a p{font-size:13px;color:rgba(255,255,255,.4);line-height:1.75;padding-bottom:18px}
.faq-item.open .faq-a{max-height:200px}
.faq-item.open .faq-icon{transform:rotate(45deg);color:#3b82f6}
.contact-section{padding:110px 64px;background:rgba(255,255,255,.015)}
.contact-inner{display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;margin-top:64px}
.contact-info p{font-size:15px;color:rgba(255,255,255,.45);line-height:1.85;margin-bottom:28px}
.contact-detail{display:flex;flex-direction:column;gap:14px}
.cd-item{display:flex;align-items:center;gap:14px;padding:14px 18px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:12px}
.cd-icon{font-size:20px;flex-shrink:0}
.cd-text{font-size:13px;color:rgba(255,255,255,.5);line-height:1.5}
.cd-text strong{color:#fff;display:block;font-size:14px;margin-bottom:2px}
.wa-card{background:linear-gradient(135deg,#0a2a1c,#0f3a28);border:1px solid rgba(5,150,105,.25);border-radius:20px;padding:40px 36px;text-align:center}
.wa-icon{width:72px;height:72px;background:linear-gradient(135deg,#059669,#10b981);border-radius:20px;display:inline-flex;align-items:center;justify-content:center;font-size:32px;margin-bottom:20px;box-shadow:0 8px 24px rgba(5,150,105,.3)}
.wa-card h3{font-size:20px;font-weight:800;color:#fff;margin-bottom:10px}
.wa-card p{font-size:13px;color:rgba(255,255,255,.4);line-height:1.7;margin-bottom:28px}
.wa-btn{display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#059669,#10b981);color:#fff;text-decoration:none;padding:14px 28px;border-radius:12px;font-size:14px;font-weight:700;transition:.25s;box-shadow:0 4px 20px rgba(5,150,105,.35)}
.wa-btn:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(5,150,105,.5)}
.wa-note{font-size:11px;color:rgba(255,255,255,.2);margin-top:14px}
.land-footer{padding:40px 64px;border-top:1px solid rgba(255,255,255,.06);display:flex;justify-content:space-between;align-items:center;background:#060d1f}
.land-footer p{font-size:12px;color:rgba(255,255,255,.2)}
@media(max-width:768px){
  .land-nav{padding:0 20px}
  .land-nav-links,.land-nav-ghost{display:none}
  .hero{padding:100px 24px 60px}
  .hero-stats{flex-wrap:wrap}
  .hero-stat{min-width:50%;border-bottom:1px solid rgba(255,255,255,.07)}
  .features-section,.how-section,.faq-section,.contact-section{padding:64px 24px}
  .features-grid{grid-template-columns:1fr;border-radius:14px}
  .steps-grid{grid-template-columns:1fr}
  .steps-grid::before{display:none}
  .faq-grid{grid-template-columns:1fr}
  .contact-inner{grid-template-columns:1fr}
  .land-footer{padding:28px 24px;flex-direction:column;gap:12px;text-align:center}
}
</style>
@endsection
@section('content')
<div id="landing">
  <!-- NAV -->
  <nav class="land-nav">
    <a href="{{ route('landing') }}" class="land-logo">
      <img src="{{ asset('logo.png') }}" alt="SchoolPay" style="width:36px;height:36px;object-fit:contain;border-radius:10px">
      <div>
        <div class="land-logo-text">SchoolPay</div>
        <div class="land-logo-sub">SMKN 7 Baleendah</div>
      </div>
    </a>
    <ul class="land-nav-links">
      <li><a href="#fitur">Fitur</a></li>
      <li><a href="#cara-kerja">Cara Kerja</a></li>
      <li><a href="#bantuan">Bantuan</a></li>
      <li><a href="#kontak">Kontak</a></li>
    </ul>
    <div class="land-nav-right">
      <a href="{{ route('login.admin') }}" class="land-nav-ghost">Staff →</a>
      <a href="{{ route('login') }}" class="land-nav-cta">Masuk Siswa</a>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-glow"></div>
    <div class="hero-grid"></div>
    <div class="hero-inner">
      <div class="hero-badge">
        <span class="hero-badge-dot"></span>
        Sistem Aktif 2024/2025
      </div>
      <h1>Kelola SPP Sekolah<br>dengan <em>Mudah & Cepat</em></h1>
      <p>SchoolPay adalah sistem informasi manajemen pembayaran SPP untuk SMKN 7 Baleendah. Pantau pembayaran, kelola data siswa, dan cetak laporan dalam satu platform.</p>
      <div class="hero-btns">
        <a href="{{ route('login') }}" class="btn-hero-primary">🚀 Mulai Sekarang</a>
        <a href="#fitur" class="btn-hero-ghost">Pelajari Fitur</a>
      </div>
      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hs-val">10+</div>
          <div class="hs-label">Kelas Aktif</div>
        </div>
        <div class="hero-stat">
          <div class="hs-val">3</div>
          <div class="hs-label">Level Akses</div>
        </div>
        <div class="hero-stat">
          <div class="hs-val">100%</div>
          <div class="hs-label">Digital</div>
        </div>
        <div class="hero-stat">
          <div class="hs-val">PDF</div>
          <div class="hs-label">Laporan Instan</div>
        </div>
      </div>
    </div>
  </section>

  <!-- MARQUEE -->
  <div class="marquee-band">
    <div class="marquee-inner">
      <span class="marquee-item">Pencatatan Pembayaran</span>
      <span class="marquee-item">Laporan PDF & Excel</span>
      <span class="marquee-item">Manajemen Siswa</span>
      <span class="marquee-item">Cetak Kwitansi</span>
      <span class="marquee-item">Dashboard Real-time</span>
      <span class="marquee-item">3 Level Akses</span>
      <span class="marquee-item">Notifikasi Tunggakan</span>
      <span class="marquee-item">Pencatatan Pembayaran</span>
      <span class="marquee-item">Laporan PDF & Excel</span>
      <span class="marquee-item">Manajemen Siswa</span>
      <span class="marquee-item">Cetak Kwitansi</span>
      <span class="marquee-item">Dashboard Real-time</span>
      <span class="marquee-item">3 Level Akses</span>
      <span class="marquee-item">Notifikasi Tunggakan</span>
    </div>
  </div>

  <!-- FEATURES -->
  <section class="features-section" id="fitur">
    <div class="section-label">Fitur Unggulan</div>
    <div class="section-title">Semua yang Anda Butuhkan</div>
    <div class="section-sub">Dari pencatatan pembayaran hingga laporan lengkap, semua tersedia dalam satu sistem.</div>
    <div class="features-grid">
      <div class="feat-card">
        <div class="feat-icon fi-b">💳</div>
        <h3>Pencatatan Pembayaran</h3>
        <p>Catat pembayaran SPP dengan cepat, lengkap dengan nomor transaksi otomatis dan kwitansi digital.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon fi-g">📊</div>
        <h3>Laporan & Statistik</h3>
        <p>Pantau rekap pembayaran per bulan, kelas, dan tahun ajaran. Export ke PDF dan Excel.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon fi-a">👥</div>
        <h3>Manajemen Siswa</h3>
        <p>Kelola data siswa lengkap dengan foto, kelas, dan riwayat pembayaran SPP.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon fi-b">🔐</div>
        <h3>Akses Berbasis Peran</h3>
        <p>3 level akses: Admin, Petugas, dan Siswa. Setiap peran memiliki hak akses yang sesuai.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon fi-g">🖨️</div>
        <h3>Cetak Kwitansi</h3>
        <p>Cetak kwitansi pembayaran langsung dari sistem dengan format profesional.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon fi-a">⚡</div>
        <h3>Real-time Dashboard</h3>
        <p>Dashboard interaktif dengan statistik terkini, grafik transaksi, dan notifikasi tunggakan.</p>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="how-section" id="cara-kerja">
    <div class="section-label">Cara Kerja</div>
    <div class="section-title">Mulai dalam 3 Langkah</div>
    <div class="section-sub">Proses yang sederhana dan cepat untuk semua pengguna sistem.</div>
    <div class="steps-grid">
      <div class="step-card">
        <div class="step-num">1</div>
        <h3>Login ke Portal</h3>
        <p>Masuk menggunakan akun yang telah diberikan oleh admin sekolah. Siswa menggunakan NIS, staff menggunakan username.</p>
      </div>
      <div class="step-card">
        <div class="step-num">2</div>
        <h3>Kelola & Catat</h3>
        <p>Petugas mencatat pembayaran SPP siswa secara real-time. Sistem otomatis membuat nomor transaksi dan kwitansi digital.</p>
      </div>
      <div class="step-card">
        <div class="step-num">3</div>
        <h3>Laporan Instan</h3>
        <p>Admin dapat mencetak laporan PDF atau Excel kapan saja. Siswa dapat memantau status dan mengunduh kwitansi pembayaran.</p>
      </div>
    </div>
  </section>

  <!-- FAQ / BANTUAN -->
  <section class="faq-section" id="bantuan">
    <div class="section-label">Bantuan</div>
    <div class="section-title">Pertanyaan yang Sering Diajukan</div>
    <div class="section-sub">Temukan jawaban atas pertanyaan umum seputar SchoolPay.</div>
    <div class="faq-grid">
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">Bagaimana cara login sebagai siswa? <span class="faq-icon">+</span></div>
        <div class="faq-a"><p>Gunakan NIS (Nomor Induk Siswa) sebagai username dan password default adalah NIS Anda. Hubungi admin jika lupa password.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">Apakah kwitansi bisa dicetak ulang? <span class="faq-icon">+</span></div>
        <div class="faq-a"><p>Ya, kwitansi dapat dicetak ulang kapan saja melalui menu History Pembayaran di portal siswa maupun portal petugas.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">Metode pembayaran apa saja yang tersedia? <span class="faq-icon">+</span></div>
        <div class="faq-a"><p>Saat ini mendukung pembayaran tunai dan transfer bank. Petugas yang mencatat metode pembayaran saat transaksi dilakukan.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">Bagaimana jika ada kesalahan data pembayaran? <span class="faq-icon">+</span></div>
        <div class="faq-a"><p>Hubungi petugas SPP atau admin sekolah untuk koreksi data. Admin memiliki akses penuh untuk mengelola transaksi.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">Apakah data pembayaran aman? <span class="faq-icon">+</span></div>
        <div class="faq-a"><p>Ya, sistem menggunakan enkripsi password dan akses berbasis peran. Setiap pengguna hanya dapat melihat data sesuai haknya.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">Bagaimana cara mendapatkan akun? <span class="faq-icon">+</span></div>
        <div class="faq-a"><p>Akun siswa dibuat otomatis oleh admin saat data siswa diinput ke sistem. Untuk akun petugas, hubungi administrator sekolah.</p></div>
      </div>
    </div>
  </section>

  <!-- KONTAK -->
  <section class="contact-section" id="kontak">
    <div class="section-label">Kontak</div>
    <div class="section-title">Butuh Bantuan Lebih Lanjut?</div>
    <div class="section-sub">Tim kami siap membantu Anda melalui berbagai saluran komunikasi.</div>
    <div class="contact-inner">
      <div class="contact-info">
        <p>Jika Anda mengalami kendala teknis, lupa password, atau membutuhkan informasi lebih lanjut seputar pembayaran SPP, jangan ragu untuk menghubungi kami.</p>
        <div class="contact-detail">
          <div class="cd-item">
            <span class="cd-icon">🏫</span>
            <div class="cd-text"><strong>SMKN 7 Baleendah</strong>Jl. Adipati Agung No. 114, Baleendah, Bandung</div>
          </div>
          <div class="cd-item">
            <span class="cd-icon">🕐</span>
            <div class="cd-text"><strong>Jam Layanan</strong>Senin – Jumat, 07.30 – 15.00 WIB</div>
          </div>
          <div class="cd-item">
            <span class="cd-icon">💬</span>
            <div class="cd-text"><strong>WhatsApp Admin</strong>+62 851-9929-6848</div>
          </div>
        </div>
      </div>
      <div class="wa-card">
        <div class="wa-icon">💬</div>
        <h3>Chat via WhatsApp</h3>
        <p>Hubungi admin atau petugas SPP langsung melalui WhatsApp untuk respons yang lebih cepat.</p>
        <a href="https://wa.me/6285199296848" target="_blank" rel="noopener" class="wa-btn">
          <span>💬</span> Chat Sekarang
        </a>
        <div class="wa-note">Biasanya merespons dalam 1–2 jam di hari kerja</div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="land-footer">
    <p>© {{ date('Y') }} SchoolPay — SMKN 7 Baleendah. Sistem Informasi Manajemen SPP.</p>
    <div style="display:flex;gap:20px;align-items:center">
      <a href="#bantuan" style="font-size:12px;color:rgba(255,255,255,.3);text-decoration:none;transition:.2s" onmouseover="this.style.color='rgba(255,255,255,.7)'" onmouseout="this.style.color='rgba(255,255,255,.3)'">Bantuan</a>
      <a href="#kontak" style="font-size:12px;color:rgba(255,255,255,.3);text-decoration:none;transition:.2s" onmouseover="this.style.color='rgba(255,255,255,.7)'" onmouseout="this.style.color='rgba(255,255,255,.3)'">Kontak</a>
      <a href="https://wa.me/6285199296848" target="_blank" style="font-size:12px;color:rgba(255,255,255,.3);text-decoration:none;transition:.2s" onmouseover="this.style.color='rgba(255,255,255,.7)'" onmouseout="this.style.color='rgba(255,255,255,.3)'">WhatsApp</a>
      <p style="color:rgba(255,255,255,.15)">Made with ♥ by <strong style="color:rgba(255,255,255,.35)">TEAM PAYFLOW</strong></p>
    </div>
  </footer>
</div>
@endsection
@section('scripts')
<script>
function toggleFaq(el) {
  const item = el.parentElement;
  item.classList.toggle('open');
}
</script>
@endsection
