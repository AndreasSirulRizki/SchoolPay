<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'SchoolPay') — SMKN 7 Baleendah</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:#f0f4f8;color:#0d1b3e;line-height:1.5;overflow-x:hidden}
:root{
  --navy:#0d1b3e;--navy-2:#162554;--navy-3:#1e3a6e;
  --blue:#2563eb;--blue-light:#3b82f6;
  --green:#059669;--green-light:#10b981;
  --amber:#d97706;--red:#dc2626;--red-2:#b91c1c;
  --surface:#ffffff;--bg:#f0f4f8;--bg-2:#e8eef8;
  --border:#e2e8f0;--border-2:#cbd5e1;
  --text-1:#0d1b3e;--text-2:#475569;--text-3:#94a3b8;
  --serif:'Instrument Serif',serif;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.6}}
</style>
@yield('styles')
</head>
<body>
@yield('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@yield('scripts')
</body>
</html>
