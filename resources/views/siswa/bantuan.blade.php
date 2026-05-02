@extends('layouts.student')
@section('title', 'Bantuan')
@section('content')
<!-- HERO -->
<div style="text-align:center;padding:32px 0 24px">
  <h1 style="font-size:28px;font-weight:800;color:#0d1b3e;margin-bottom:8px">Ada yang bisa kami bantu?</h1>
  <p style="font-size:14px;color:#475569;margin-bottom:20px">Temukan jawaban atas pertanyaan Anda di sini</p>
  <div style="max-width:480px;margin:0 auto;position:relative">
    <input type="text" class="form-control" placeholder="Ketik kata kunci (misal: kartu kredit, deadline, refund)..." style="padding-left:40px">
    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8">🔍</span>
  </div>
</div>

<!-- KATEGORI -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px">
  <div class="stat-card" style="text-align:center;cursor:pointer">
    <div style="font-size:32px;margin-bottom:10px">💳</div>
    <div style="font-size:14px;font-weight:700;margin-bottom:4px">Payments</div>
    <div style="font-size:12px;color:#475569">Informasi metode transfer, cicilan, dan konfirmasi pembayaran</div>
  </div>
  <div class="stat-card" style="text-align:center;cursor:pointer">
    <div style="font-size:32px;margin-bottom:10px">👤</div>
    <div style="font-size:14px;font-weight:700;margin-bottom:4px">Account</div>
    <div style="font-size:12px;color:#475569">Pengaturan profil, pemulihan kata sandi, sinkronisasi data</div>
  </div>
  <div class="stat-card" style="text-align:center;cursor:pointer;border-color:#059669;background:#f0fdf4">
    <div style="font-size:32px;margin-bottom:10px">📚</div>
    <div style="font-size:14px;font-weight:700;margin-bottom:4px;color:#059669">General</div>
    <div style="font-size:12px;color:#475569">Kebijakan, pengembalian dana, kalender akademik</div>
  </div>
</div>

<!-- FAQ -->
<div class="table-card" style="margin-bottom:20px">
  <div class="tc-header"><div class="tc-title">Pertanyaan Populer</div></div>
  <div style="padding:0">
    @php
    $faqs = [
      ['q' => 'Berapa lama proses verifikasi pembayaran manual?', 'a' => 'Proses verifikasi pembayaran manual memerlukan waktu 1×24 jam kerja. Pastikan Anda menyimpan bukti pembayaran dan menghubungi admin jika lebih dari 1 hari kerja belum terkonfirmasi.'],
      ['q' => 'Apakah saya bisa mengubah metode pembayaran yang sudah dipilih?', 'a' => 'Metode pembayaran tidak dapat diubah setelah transaksi dikonfirmasi. Hubungi admin untuk bantuan lebih lanjut.'],
      ['q' => 'Bagaimana cara mencetak bukti pembayaran resmi (Kwitansi)?', 'a' => 'Buka halaman History Pembayaran, lalu klik tombol "PDF" di samping transaksi yang ingin dicetak. File PDF akan otomatis terunduh.'],
      ['q' => 'Jadwal operasional kantor administrasi keuangan?', 'a' => 'Kantor administrasi keuangan buka Senin - Jumat pukul 08:00 - 15:00 WIB. Sabtu dan Minggu libur.'],
    ];
    @endphp
    @foreach($faqs as $i => $faq)
    <div style="border-bottom:1px solid #f1f5f9">
      <button onclick="toggleFaq({{ $i }})" style="width:100%;text-align:left;padding:16px 20px;background:none;border:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-family:'DM Sans',sans-serif">
        <span style="font-size:13px;font-weight:600;color:#0d1b3e">{{ $faq['q'] }}</span>
        <span id="faq-icon-{{ $i }}" style="font-size:16px;color:#94a3b8;flex-shrink:0;margin-left:12px">+</span>
      </button>
      <div id="faq-body-{{ $i }}" style="display:none;padding:0 20px 16px;font-size:13px;color:#475569;line-height:1.7">{{ $faq['a'] }}</div>
    </div>
    @endforeach
  </div>
</div>

<!-- CONTACT ADMIN -->
<div class="stat-card dark" style="margin-bottom:20px">
  <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:4px">Butuh bantuan lebih lanjut?</div>
  <div style="font-size:12px;color:rgba(255,255,255,.5);margin-bottom:16px">Senin - Jumat, 08:00 - 17:00 WIB</div>
  <div style="display:flex;gap:10px;flex-wrap:wrap">
    <a href="https://wa.me/6281234567890" target="_blank" class="btn-outline" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;font-size:12px">💬 WhatsApp Admin</a>
    <a href="mailto:admin@smkn7baleendah.sch.id" class="btn-outline" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;font-size:12px">✉️ Kirim Email</a>
  </div>
</div>

<!-- TIPS -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px">
  @foreach([['🔒','Keamanan Transaksi Online'],['⏰','Atur Pengingat Jatuh Tempo'],['📄','Simpan Bukti PDF'],['📱','Akses Mobile Responsif']] as $tip)
  <div class="stat-card" style="text-align:center;padding:16px">
    <div style="font-size:24px;margin-bottom:8px">{{ $tip[0] }}</div>
    <div style="font-size:12px;font-weight:600;color:#0d1b3e">{{ $tip[1] }}</div>
  </div>
  @endforeach
</div>
@endsection
@section('scripts')
<script>
function toggleFaq(i) {
  const body = document.getElementById('faq-body-' + i);
  const icon = document.getElementById('faq-icon-' + i);
  const open = body.style.display === 'none';
  body.style.display = open ? 'block' : 'none';
  icon.textContent = open ? '−' : '+';
}
</script>
@endsection
