<div style="text-align:center;padding:40px 24px;color:#94a3b8">
  <div style="font-size:40px;margin-bottom:12px">📭</div>
  <div style="font-size:15px;font-weight:700;color:#475569;margin-bottom:6px">{{ $msg ?? 'Tidak ada data.' }}</div>
  @if(isset($sub))
  <div style="font-size:12px">{{ $sub }}</div>
  @endif
</div>
