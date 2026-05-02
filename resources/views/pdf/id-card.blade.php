<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; }
body { font-family: DejaVu Sans, sans-serif; background:#fff; }
</style>
</head>
<body>
<table width="320" cellpadding="0" cellspacing="0" style="background:#0f172a;border-collapse:collapse;">
  {{-- Stripe --}}
  <tr>
    <td colspan="2" height="5" style="background:#2563eb;font-size:1px;line-height:1px;">&nbsp;</td>
  </tr>
  {{-- Header --}}
  <tr>
    <td colspan="2" style="padding:8px 10px 6px;border-bottom:1px solid #1e293b;">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td style="vertical-align:middle;">
            <img src="{{ public_path('logo.png') }}" width="16" height="16" style="vertical-align:middle;">
            <span style="font-size:7px;font-weight:bold;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;vertical-align:middle;">&nbsp;SMKN 7 Baleendah &mdash; SchoolPay</span>
          </td>
          <td align="right" style="vertical-align:middle;">
            <span style="background:#1e3a6e;border:1px solid #2563eb;color:#93c5fd;font-size:6px;font-weight:bold;text-transform:uppercase;padding:2px 7px;">Kartu Pelajar</span>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  {{-- Body --}}
  <tr>
    <td width="72" style="padding:10px 0 10px 10px;vertical-align:top;">
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td width="52" height="64" style="background:#1e3a6e;border:2px solid #334155;text-align:center;vertical-align:middle;font-size:22px;font-weight:bold;color:#ffffff;padding-top:18px;">
            @if($siswa->foto)
              <img src="{{ public_path('storage/'.$siswa->foto) }}" width="52" height="64" style="display:block;object-fit:cover;">
            @else
              {{ strtoupper(substr($siswa->nama, 0, 1)) }}
            @endif
          </td>
        </tr>
      </table>
    </td>
    <td style="padding:10px 10px 10px 8px;vertical-align:top;">
      <p style="font-size:11px;font-weight:bold;color:#f1f5f9;margin-bottom:6px;">{{ $siswa->nama }}</p>
      <table cellpadding="0" cellspacing="2">
        <tr>
          <td width="30" style="font-size:7px;color:#475569;text-transform:uppercase;">NIS</td>
          <td style="font-size:8px;font-weight:bold;color:#94a3b8;">{{ $siswa->nis }}</td>
        </tr>
        <tr>
          <td style="font-size:7px;color:#475569;text-transform:uppercase;">NISN</td>
          <td style="font-size:8px;font-weight:bold;color:#94a3b8;">{{ $siswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
          <td style="font-size:7px;color:#475569;text-transform:uppercase;">Kelas</td>
          <td style="font-size:8px;font-weight:bold;color:#94a3b8;">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
          <td style="font-size:7px;color:#475569;text-transform:uppercase;">T.A.</td>
          <td style="font-size:8px;font-weight:bold;color:#94a3b8;">{{ date('Y') }}/{{ date('Y')+1 }}</td>
        </tr>
      </table>
    </td>
  </tr>
  {{-- Footer --}}
  <tr>
    <td colspan="2" style="padding:5px 10px 7px;border-top:1px solid #1e293b;background:#0a1020;">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td style="vertical-align:middle;">
            <span style="background:#052e16;border:1px solid #16a34a;color:#4ade80;font-size:7px;font-weight:bold;text-transform:uppercase;padding:2px 8px;">&#10003; Siswa Aktif</span>
          </td>
          <td align="right" style="vertical-align:middle;">
            <span style="font-size:6px;color:#475569;text-transform:uppercase;display:block;">Berlaku s/d</span>
            <span style="font-size:8px;font-weight:bold;color:#64748b;">Juni {{ date('Y')+1 }}</span>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
