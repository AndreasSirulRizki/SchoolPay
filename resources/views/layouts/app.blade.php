<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — SchoolPay SMKN 7 Baleendah</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:#f0f4f8;color:#0d1b3e;line-height:1.5}
:root{
  --navy:#0d1b3e;--navy-2:#162554;--navy-3:#1e3a6e;
  --blue:#2563eb;--blue-light:#3b82f6;
  --green:#059669;--amber:#d97706;--red:#dc2626;
  --surface:#fff;--bg:#f0f4f8;--border:#e2e8f0;
  --text-1:#0d1b3e;--text-2:#475569;--text-3:#94a3b8;
  --sidebar-w:220px;--header-h:60px;
}
.app-shell{display:flex;min-height:100vh}
/* SIDEBAR */
.sidebar{width:var(--sidebar-w);background:var(--navy);position:fixed;top:0;left:0;bottom:0;display:flex;flex-direction:column;z-index:50}
.sb-brand{padding:18px 16px;border-bottom:1px solid rgba(255,255,255,.07)}
.sb-brand-icon{width:32px;height:32px;background:var(--blue);border-radius:8px;display:grid;place-items:center;font-size:14px;margin-bottom:8px}
.sb-brand-name{font-size:11px;font-weight:700;color:#fff;line-height:1.3}
.sb-brand-role{font-size:9px;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:1px;margin-top:2px}
.sb-nav{flex:1;padding:12px 8px;overflow-y:auto}
.nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;cursor:pointer;color:rgba(255,255,255,.5);font-size:13px;font-weight:500;margin-bottom:2px;transition:.15s;text-decoration:none;position:relative}
.nav-item:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.8)}
.nav-item.active{background:rgba(37,99,235,.18);color:#fff}
.nav-item.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:18px;background:var(--blue);border-radius:0 2px 2px 0}
.nav-icon{font-size:14px;width:18px;text-align:center;flex-shrink:0}
.sb-bottom{padding:12px 8px;border-top:1px solid rgba(255,255,255,.07)}
.sb-user{display:flex;align-items:center;gap:10px;padding:8px;border-radius:8px;margin-bottom:6px}
.sb-avatar{width:30px;height:30px;border-radius:50%;background:var(--blue);display:grid;place-items:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
.sb-user-name{font-size:12px;font-weight:600;color:#fff;line-height:1.2}
.sb-user-role{font-size:9px;color:rgba(255,255,255,.3);text-transform:uppercase;letter-spacing:.5px}
.sb-logout{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:8px;cursor:pointer;color:rgba(255,255,255,.35);font-size:12px;font-weight:500;transition:.15s;border:none;background:transparent;width:100%;font-family:inherit}
.sb-logout:hover{background:rgba(239,68,68,.1);color:#f87171}
/* MAIN */
.main-content{margin-left:var(--sidebar-w);flex:1;min-height:100vh;display:flex;flex-direction:column}
.topbar{height:var(--header-h);background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 24px;position:sticky;top:0;z-index:30;gap:16px}
.topbar-left{font-size:16px;font-weight:700;color:var(--text-1);white-space:nowrap}
.topbar-center{flex:1;max-width:400px;position:relative}
.topbar-search{width:100%;padding:8px 14px 8px 36px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;transition:.15s}
.topbar-search:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.search-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-3);font-size:14px}
.search-results{position:absolute;top:calc(100% + 6px);left:0;right:0;background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:100;display:none;max-height:360px;overflow-y:auto}
.search-results.show{display:block}
.sr-section{padding:8px 0}
.sr-label{padding:6px 14px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-3)}
.sr-item{display:flex;align-items:center;gap:10px;padding:8px 14px;cursor:pointer;transition:.1s;text-decoration:none;color:var(--text-1)}
.sr-item:hover{background:var(--bg)}
.sr-item-name{font-size:13px;font-weight:600}
.sr-item-sub{font-size:11px;color:var(--text-3)}
.topbar-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;width:36px;height:36px;border-radius:10px;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:grid;place-items:center;font-size:16px}
.notif-badge{position:absolute;top:-4px;right:-4px;background:var(--red);color:#fff;font-size:9px;font-weight:700;min-width:16px;height:16px;border-radius:8px;display:flex;align-items:center;justify-content:center;padding:0 3px}
.notif-dropdown{position:absolute;top:calc(100% + 8px);right:0;width:300px;background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:100;display:none}
.notif-dropdown.show{display:block}
.notif-header{padding:12px 16px;border-bottom:1px solid var(--border);font-size:13px;font-weight:700}
.notif-item{padding:10px 16px;border-bottom:1px solid var(--border);font-size:12px;cursor:pointer}
.notif-item:hover{background:var(--bg)}
.notif-item.unread{background:#eff6ff}
.notif-empty{padding:20px;text-align:center;color:var(--text-3);font-size:12px}
.tb-user{display:flex;align-items:center;gap:10px}
.tb-user-info{text-align:right}
.tb-user-name{font-size:13px;font-weight:700;color:var(--text-1)}
.tb-user-role{font-size:10px;color:var(--text-3);text-transform:uppercase;letter-spacing:.5px}
.tb-avatar{width:34px;height:34px;border-radius:50%;background:var(--navy);display:grid;place-items:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0}
.content-area{padding:24px;flex:1}
/* COMPONENTS */
.pg-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:22px}
.pg-titles h1{font-size:24px;font-weight:800;color:var(--text-1);letter-spacing:-.5px;margin-bottom:3px}
.pg-titles p{font-size:13px;color:var(--text-2)}
.stats-grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px}
.stats-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px}
.stat-card{background:#fff;border-radius:14px;padding:20px;border:1px solid var(--border);transition:.2s;position:relative;overflow:hidden}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 24px rgba(0,0,0,.07)}
.stat-card.dark{background:var(--navy);border-color:transparent;color:#fff}
.sc-icon{width:40px;height:40px;border-radius:10px;display:grid;place-items:center;font-size:17px;margin-bottom:12px}
.sc-i-blue{background:#eff6ff;color:var(--blue)}
.sc-i-green{background:#ecfdf5;color:var(--green)}
.sc-i-amber{background:#fffbeb;color:var(--amber)}
.sc-i-dark{background:rgba(255,255,255,.12);color:#fff}
.sc-val{font-size:26px;font-weight:800;letter-spacing:-1px;color:var(--text-1);margin-bottom:3px}
.stat-card.dark .sc-val{color:#fff}
.sc-label{font-size:12px;color:var(--text-2)}
.stat-card.dark .sc-label{color:rgba(255,255,255,.5)}
.badge-green-sm{background:#dcfce7;color:#166534;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px}
.table-card{background:#fff;border-radius:14px;border:1px solid var(--border);overflow:hidden;margin-bottom:18px}
.tc-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
.tc-title{font-size:14px;font-weight:700;color:var(--text-1)}
.tc-sub{font-size:11px;color:var(--text-3);margin-top:2px}
table.dt{width:100%;border-collapse:collapse}
table.dt th{padding:10px 16px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-3);background:var(--bg);text-align:left;border-bottom:1px solid var(--border)}
table.dt td{padding:13px 16px;font-size:13px;color:var(--text-1);border-bottom:1px solid var(--border)}
table.dt tr:last-child td{border-bottom:none}
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
.badge-lunas{background:#dcfce7;color:#166534}
.badge-pending{background:#fef3c7;color:#92400e}
.badge-active{background:#dcfce7;color:#166534}
.badge-inactive{background:#f1f5f9;color:#64748b}
.badge-suspended{background:#fef3c7;color:#92400e}
.badge-admin{background:#dbeafe;color:#1e40af}
.badge-petugas{background:#fef3c7;color:#92400e}
.btn-primary{background:var(--navy);color:#fff;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;border:none;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;transition:.15s}
.btn-primary:hover{background:var(--navy-2)}
.btn-outline{background:#fff;color:var(--text-1);padding:8px 16px;border-radius:9px;font-size:13px;font-weight:600;border:1.5px solid var(--border);cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;transition:.15s}
.btn-outline:hover{border-color:var(--navy);color:var(--navy)}
.btn-danger{background:var(--red);color:#fff;padding:9px 18px;border-radius:9px;font-size:13px;font-weight:600;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;transition:.15s}
.btn-danger:hover{background:#b91c1c}
.pill-btn{padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600;border:1.5px solid var(--border);background:#fff;cursor:pointer;font-family:'DM Sans',sans-serif;transition:.15s}
.pill-btn.active{background:var(--navy);color:#fff;border-color:var(--navy)}
.quick-action-btn{display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:10px;background:var(--bg);color:var(--text-1);text-decoration:none;font-size:13px;font-weight:600;transition:.15s}
.quick-action-btn:hover{background:#e2e8f0}
.fab{position:fixed;bottom:28px;right:28px;width:52px;height:52px;border-radius:50%;background:var(--navy);color:#fff;border:none;font-size:24px;cursor:pointer;box-shadow:0 4px 20px rgba(0,0,0,.25);z-index:40;transition:.2s}
.fab:hover{background:var(--navy-2);transform:scale(1.05)}
.empty-cell{text-align:center;padding:40px;color:var(--text-3)}
.alert{padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
.alert-success{background:#dcfce7;color:#166534;border:1px solid #bbf7d0}
.alert-error{background:#fef2f2;color:#dc2626;border:1px solid #fecaca}
/* MODAL */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;display:none;align-items:center;justify-content:center;padding:20px}
.modal-overlay.show{display:flex}
.modal{background:#fff;border-radius:16px;width:100%;max-width:520px;max-height:90vh;overflow-y:auto;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.modal-header{padding:20px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.modal-header.dark{background:var(--navy);color:#fff;border-radius:16px 16px 0 0}
.modal-title{font-size:16px;font-weight:700}
.modal-close{width:28px;height:28px;border-radius:6px;border:none;background:rgba(0,0,0,.08);cursor:pointer;font-size:14px;display:grid;place-items:center}
.modal-header.dark .modal-close{background:rgba(255,255,255,.1);color:#fff}
.modal-body{padding:24px}
.modal-footer{padding:16px 24px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:10px}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-2);margin-bottom:6px}
.form-control{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:9px;font-size:13px;font-family:'DM Sans',sans-serif;color:var(--text-1);outline:none;transition:.15s}
.form-control:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.pagination-info{padding:12px 20px;font-size:12px;color:var(--text-3);border-top:1px solid var(--border)}
</style>
</head>
<body>
<div class="app-shell">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('petugas.dashboard') }}" class="sb-brand" style="text-decoration:none;display:block;transition:.2s" onmouseover="this.style.background='rgba(255,255,255,.05)'" onmouseout="this.style.background=''">
      <img src="{{ asset('logo.png') }}" alt="SchoolPay" style="width:32px;height:32px;object-fit:contain;border-radius:6px">
      <div class="sb-brand-name">PEMBAYARAN SPP</div>
      <div class="sb-brand-role">@yield('sidebar-role', 'ADMIN WORKSPACE')</div>
    </a>
    <nav class="sb-nav">
      @yield('sidebar-nav')
    </nav>
    <div class="sb-bottom">
      <div class="sb-user">
        <div class="sb-avatar" style="{{ auth()->user()?->foto ? 'padding:0;overflow:hidden;' : '' }}">
          @if(auth()->user()?->foto)
            <img src="{{ asset('storage/'.auth()->user()->foto) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
          @else
            {{ strtoupper(substr(auth()->user()->name ?? auth('siswa')->user()->nama ?? '?', 0, 1)) }}
          @endif
        </div>
        <div>
          <div class="sb-user-name">{{ auth()->user()->name ?? auth('siswa')->user()->nama ?? '' }}</div>
          <div class="sb-user-role">{{ strtoupper(auth()->user()->role ?? 'siswa') }}</div>
        </div>
      </div>
      <form method="POST" action="{{ auth()->check() ? route('logout') : route('siswa.logout') }}">
        @csrf
        <button type="submit" class="sb-logout">🚪 Logout</button>
      </form>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main-content">
    <header class="topbar">
      <div class="topbar-left">@yield('page-title', 'Dashboard')</div>

      @hasSection('show-search')
      <div class="topbar-center">
        <span class="search-icon">🔍</span>
        <input type="text" class="topbar-search" id="globalSearch" placeholder="Cari siswa atau transaksi..." autocomplete="off">
        <div class="search-results" id="searchResults"></div>
      </div>
      @endif

      <div class="topbar-right">
        <!-- NOTIFICATIONS -->
        <div style="position:relative">
          <button class="notif-btn" id="notifBtn" onclick="toggleNotif()">
            🔔
            @php
              $notifCount = isset($unreadNotif) ? $unreadNotif : 0;
            @endphp
            @if($notifCount > 0)
            <span class="notif-badge">{{ $notifCount }}</span>
            @endif
          </button>
          <div class="notif-dropdown" id="notifDropdown">
            <div class="notif-header">Notifikasi</div>
            <div id="notifList"><div class="notif-empty">Memuat...</div></div>
          </div>
        </div>

        <div class="tb-user">
          <div class="tb-user-info">
            <div class="tb-user-name">{{ auth()->user()->name ?? auth('siswa')->user()->nama ?? '' }}</div>
            <div class="tb-user-role">{{ strtoupper(auth()->user()->role ?? 'SISWA') }}</div>
          </div>
          <div class="tb-avatar" style="{{ auth()->user()?->foto ? 'padding:0;overflow:hidden;' : '' }}">
            @if(auth()->user()?->foto)
              <img src="{{ asset('storage/'.auth()->user()->foto) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            @else
              {{ strtoupper(substr(auth()->user()->name ?? auth('siswa')->user()->nama ?? '?', 0, 1)) }}
            @endif
          </div>
        </div>
      </div>
    </header>

    <main class="content-area">
      @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
      @endif
      @if(session('error'))
      <div class="alert alert-error">⚠️ {{ session('error') }}</div>
      @endif
      @yield('content')
    </main>
  </div>
</div>

@yield('modals')

<script>
// Notifications
function toggleNotif() {
  const dd = document.getElementById('notifDropdown');
  dd.classList.toggle('show');
  if (dd.classList.contains('show')) loadNotifs();
}
function loadNotifs() {
  const url = @json(auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.notifications') : route('petugas.notifications')) : (auth('siswa')->check() ? route('siswa.notifications') : '#'));
  if (url === '#') return;
  fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.json()).then(data => {
      const list = document.getElementById('notifList');
      if (!data.length) { list.innerHTML = '<div class="notif-empty">Tidak ada notifikasi</div>'; return; }
      list.innerHTML = data.map(n => `<div class="notif-item ${n.is_read ? '' : 'unread'}">${n.message}<div style="font-size:10px;color:#94a3b8;margin-top:3px">${n.created_at}</div></div>`).join('');
    }).catch(() => {});
}
document.addEventListener('click', e => {
  if (!e.target.closest('#notifBtn') && !e.target.closest('#notifDropdown')) {
    document.getElementById('notifDropdown')?.classList.remove('show');
  }
});

// Global search
const searchInput = document.getElementById('globalSearch');
const searchResults = document.getElementById('searchResults');
if (searchInput) {
  let timer;
  searchInput.addEventListener('input', function() {
    clearTimeout(timer);
    const q = this.value.trim();
    if (q.length < 2) { searchResults.classList.remove('show'); return; }
    timer = setTimeout(() => {
      fetch(`{{ route('admin.search') }}?q=${encodeURIComponent(q)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json()).then(data => {
          let html = '';
          if (data.siswa?.length) {
            html += '<div class="sr-section"><div class="sr-label">Siswa</div>';
            data.siswa.forEach(s => {
              html += `<a href="${s.url}" class="sr-item"><div><div class="sr-item-name">${s.nama}</div><div class="sr-item-sub">${s.nis} · ${s.kelas}</div></div></a>`;
            });
            html += '</div>';
          }
          if (data.transaksi?.length) {
            html += '<div class="sr-section"><div class="sr-label">Transaksi</div>';
            data.transaksi.forEach(t => {
              html += `<a href="${t.url}" class="sr-item"><div><div class="sr-item-name">${t.no_transaksi}</div><div class="sr-item-sub">${t.nama_siswa} · ${t.total}</div></div></a>`;
            });
            html += '</div>';
          }
          if (!html) html = '<div class="notif-empty">Tidak ada hasil</div>';
          searchResults.innerHTML = html;
          searchResults.classList.add('show');
        }).catch(() => {});
    }, 300);
  });
  document.addEventListener('click', e => {
    if (!e.target.closest('.topbar-center')) searchResults?.classList.remove('show');
  });
}
</script>
@yield('scripts')
<div style="margin-left:var(--sidebar-w);padding:10px 24px;background:#f8fafc;border-top:1px solid var(--border);font-size:11px;color:#94a3b8;display:flex;justify-content:space-between">
  <span>© {{ date('Y') }} SchoolPay — SMKN 7 Baleendah</span>
  <span>Made with ♥ by <strong style="color:#475569">TEAM PAYFLOW</strong></span>
</div>
</body>
</html>
