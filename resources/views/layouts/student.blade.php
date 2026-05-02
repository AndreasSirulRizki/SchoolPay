<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Portal Siswa') — SchoolPay</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:#f0f4f8;color:#0d1b3e;line-height:1.5}
:root{--navy:#0d1b3e;--blue:#2563eb;--green:#059669;--amber:#d97706;--red:#dc2626;--border:#e2e8f0;--text-2:#475569;--text-3:#94a3b8;--sidebar-w:220px}
.app-shell{display:flex;min-height:100vh}
.sidebar{width:var(--sidebar-w);background:var(--navy);position:fixed;top:0;left:0;bottom:0;display:flex;flex-direction:column;z-index:50}
.sb-profile{padding:20px 16px;border-bottom:1px solid rgba(255,255,255,.07);text-align:center}
.sb-photo{width:56px;height:56px;border-radius:50%;background:var(--blue);display:inline-flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#fff;margin-bottom:10px}
.sb-name{font-size:13px;font-weight:700;color:#fff;line-height:1.3}
.sb-id{font-size:10px;color:rgba(255,255,255,.3);margin-top:2px}
.sb-nav{flex:1;padding:12px 8px;overflow-y:auto}
.nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;cursor:pointer;color:rgba(255,255,255,.5);font-size:13px;font-weight:500;margin-bottom:2px;transition:.15s;text-decoration:none;position:relative}
.nav-item:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.8)}
.nav-item.active{background:rgba(37,99,235,.18);color:#fff}
.nav-item.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:18px;background:var(--blue);border-radius:0 2px 2px 0}
.nav-icon{font-size:14px;width:18px;text-align:center;flex-shrink:0}
.sb-bottom{padding:12px 8px;border-top:1px solid rgba(255,255,255,.07)}
.sb-logout{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:8px;cursor:pointer;color:rgba(255,255,255,.35);font-size:12px;font-weight:500;transition:.15s;border:none;background:transparent;width:100%;font-family:inherit}
.sb-logout:hover{background:rgba(239,68,68,.1);color:#f87171}
.main-content{margin-left:var(--sidebar-w);flex:1;min-height:100vh;display:flex;flex-direction:column}
.topbar{height:60px;background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 24px;position:sticky;top:0;z-index:30}
.topbar-title{font-size:15px;font-weight:700;color:#0d1b3e}
.topbar-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;width:36px;height:36px;border-radius:10px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:grid;place-items:center;font-size:16px}
.notif-badge{position:absolute;top:-4px;right:-4px;background:var(--red);color:#fff;font-size:9px;font-weight:700;min-width:16px;height:16px;border-radius:8px;display:flex;align-items:center;justify-content:center;padding:0 3px}
.content-area{padding:24px;flex:1}
.pg-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:22px}
.pg-titles h1{font-size:24px;font-weight:800;color:#0d1b3e;letter-spacing:-.5px;margin-bottom:3px}
.pg-titles p{font-size:13px;color:var(--text-2)}
.stats-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px}
.stat-card{background:#fff;border-radius:14px;padding:20px;border:1px solid var(--border);transition:.2s}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 24px rgba(0,0,0,.07)}
.stat-card.dark{background:var(--navy);border-color:transparent}
.sc-icon{width:40px;height:40px;border-radius:10px;display:grid;place-items:center;font-size:17px;margin-bottom:12px}
.sc-i-blue{background:#eff6ff;color:var(--blue)}
.sc-i-green{background:#ecfdf5;color:var(--green)}
.sc-i-amber{background:#fffbeb;color:var(--amber)}
.sc-val{font-size:26px;font-weight:800;letter-spacing:-1px;color:#0d1b3e;margin-bottom:3px}
.sc-label{font-size:12px;color:var(--text-2)}
.table-card{background:#fff;border-radius:14px;border:1px solid var(--border);overflow:hidden;margin-bottom:18px}
.tc-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.tc-title{font-size:14px;font-weight:700;color:#0d1b3e}
.tc-sub{font-size:11px;color:var(--text-3);margin-top:2px}
table.dt{width:100%;border-collapse:collapse}
table.dt th{padding:10px 16px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-3);background:#f8fafc;text-align:left;border-bottom:1px solid var(--border)}
table.dt td{padding:13px 16px;font-size:13px;color:#0d1b3e;border-bottom:1px solid var(--border)}
table.dt tr:last-child td{border-bottom:none}
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
.badge-lunas{background:#dcfce7;color:#166534}
.badge-pending{background:#fef3c7;color:#92400e}
.btn-primary{background:var(--navy);color:#fff;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;border:none;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;transition:.15s}
.btn-primary:hover{background:#162554}
.btn-outline{background:#fff;color:#0d1b3e;padding:8px 16px;border-radius:9px;font-size:13px;font-weight:600;border:1.5px solid var(--border);cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;transition:.15s}
.btn-outline:hover{border-color:var(--navy)}
.alert{padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px}
.alert-success{background:#dcfce7;color:#166534;border:1px solid #bbf7d0}
.alert-error{background:#fef2f2;color:#dc2626;border:1px solid #fecaca}
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;display:none;align-items:center;justify-content:center;padding:20px}
.modal-overlay.show{display:flex}
.modal{background:#fff;border-radius:16px;width:100%;max-width:480px;max-height:90vh;overflow-y:auto}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-2);margin-bottom:6px}
.form-control{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:9px;font-size:13px;font-family:'DM Sans',sans-serif;color:#0d1b3e;outline:none;transition:.15s}
.form-control:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.pagination-info{padding:12px 20px;font-size:12px;color:var(--text-3);border-top:1px solid var(--border)}
.fab{position:fixed;bottom:28px;left:calc(var(--sidebar-w) + 28px);width:52px;height:52px;border-radius:50%;background:var(--navy);color:#fff;border:none;font-size:20px;cursor:pointer;box-shadow:0 4px 20px rgba(0,0,0,.25);z-index:40;transition:.2s}
.fab:hover{background:#162554;transform:scale(1.05)}
</style>
</head>
<body>
@php $siswa = auth('siswa')->user(); @endphp
<div class="app-shell">
  <aside class="sidebar">
    <a href="{{ route('siswa.dashboard') }}" class="sb-profile" style="text-decoration:none;display:block;transition:.2s" onmouseover="this.style.background='rgba(255,255,255,.04)'" onmouseout="this.style.background=''">
      <div class="sb-photo" style="{{ $siswa->foto ? 'padding:0;overflow:hidden;' : '' }}">
        @if($siswa->foto)
          <img src="{{ asset('storage/'.$siswa->foto) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
        @else
          {{ strtoupper(substr($siswa->nama??'?',0,1)) }}
        @endif
      </div>
      <div class="sb-name">{{ $siswa->nama ?? '' }}</div>
      <div class="sb-id">NIS: {{ $siswa->nis ?? '' }}</div>
    </a>
    <nav class="sb-nav">
      @php $cur = request()->route()?->getName() ?? ''; @endphp
      <a href="{{ route('siswa.dashboard') }}" class="nav-item {{ $cur === 'siswa.dashboard' ? 'active' : '' }}"><span class="nav-icon">📊</span> Dashboard</a>
      <a href="{{ route('siswa.history') }}" class="nav-item {{ $cur === 'siswa.history' ? 'active' : '' }}"><span class="nav-icon">🕐</span> History Pembayaran</a>
      <a href="{{ route('siswa.bantuan') }}" class="nav-item {{ $cur === 'siswa.bantuan' ? 'active' : '' }}"><span class="nav-icon">❓</span> Bantuan</a>
      <a href="{{ route('siswa.profil') }}" class="nav-item {{ $cur === 'siswa.profil' ? 'active' : '' }}"><span class="nav-icon">👤</span> Profil Saya</a>
    </nav>
    <div class="sb-bottom">
      <form method="POST" action="{{ route('siswa.logout') }}">
        @csrf
        <button type="submit" class="sb-logout">🚪 Logout</button>
      </form>
    </div>
  </aside>
  <div class="main-content">
    <header class="topbar">
      <div class="topbar-title">Academic Portal — SchoolPay</div>
      <div class="topbar-right">
        <div style="position:relative">
          <button class="notif-btn" id="notifBtn" onclick="toggleNotif()">
            🔔
            @if(isset($unreadNotif) && $unreadNotif > 0)
            <span class="notif-badge">{{ $unreadNotif }}</span>
            @endif
          </button>
          <div id="notifDropdown" style="position:absolute;top:calc(100% + 8px);right:0;width:280px;background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:100;display:none">
            <div style="padding:12px 16px;border-bottom:1px solid var(--border);font-size:13px;font-weight:700">Notifikasi</div>
            <div id="notifList"><div style="padding:20px;text-align:center;color:var(--text-3);font-size:12px">Memuat...</div></div>
          </div>
        </div>
      </div>
    </header>
    <main class="content-area">
      @if(session('success'))<div class="alert alert-success">✅ {{ session('success') }}</div>@endif
      @if(session('error'))<div class="alert alert-error">⚠️ {{ session('error') }}</div>@endif
      @yield('content')
    </main>
  </div>
</div>
@yield('modals')
<script>
function toggleNotif() {
  const dd = document.getElementById('notifDropdown');
  const show = dd.style.display === 'none';
  dd.style.display = show ? 'block' : 'none';
  if (show) {
    fetch('{{ route("siswa.notifications") }}', { headers: {'X-Requested-With':'XMLHttpRequest'} })
      .then(r => r.json()).then(data => {
        const list = document.getElementById('notifList');
        if (!data.length) { list.innerHTML = '<div style="padding:20px;text-align:center;color:#94a3b8;font-size:12px">Tidak ada notifikasi</div>'; return; }
        list.innerHTML = data.map(n => `<div style="padding:10px 16px;border-bottom:1px solid #f1f5f9;font-size:12px;${n.is_read ? '' : 'background:#eff6ff'}">${n.message}</div>`).join('');
      }).catch(() => {});
  }
}
document.addEventListener('click', e => {
  if (!e.target.closest('#notifBtn') && !e.target.closest('#notifDropdown')) {
    const dd = document.getElementById('notifDropdown');
    if (dd) dd.style.display = 'none';
  }
});
</script>
@yield('scripts')
<div style="margin-left:var(--sidebar-w);padding:10px 24px;background:#f8fafc;border-top:1px solid var(--border);font-size:11px;color:#94a3b8;display:flex;justify-content:space-between">
  <span>© {{ date('Y') }} SchoolPay — SMKN 7 Baleendah</span>
  <span>Made with ♥ by <strong style="color:#475569">TEAM PAYFLOW</strong></span>
</div>
</body>
</html>
