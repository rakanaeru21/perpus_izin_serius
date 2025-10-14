<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Mingguan - {{ $period }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
            font-weight: normal;
        }
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-item {
            display: table-cell;
            width: 50%;
            padding: 15px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .stats-number {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
            display: block;
        }
        .stats-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .section-title {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            margin: 20px 0 10px 0;
            font-weight: bold;
            font-size: 14px;
        }
        .summary-item {
            display: inline-block;
            width: 48%;
            margin: 1%;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .summary-item h4 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 13px;
        }
        .summary-item p {
            margin: 5px 0;
            font-size: 11px;
        }
        .chart-placeholder {
            height: 200px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            color: #666;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISTEM PERPUSTAKAAN</h1>
        <h2>Laporan Mingguan - {{ $period }}</h2>
        <p style="margin: 5px 0 0 0; font-size: 11px;">Digenerate pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-box">
        <strong>Periode Laporan:</strong> {{ $data['period'] }}<br>
        <strong>Total Aktivitas:</strong> {{ $data['total_borrowings'] + $data['total_returns'] }} transaksi dalam seminggu
    </div>

    <div class="stats-grid">
        <div class="stats-item">
            <span class="stats-number">{{ $data['total_borrowings'] }}</span>
            <div class="stats-label">TOTAL PEMINJAMAN MINGGU INI</div>
        </div>
        <div class="stats-item">
            <span class="stats-number">{{ $data['total_returns'] }}</span>
            <div class="stats-label">TOTAL PENGEMBALIAN MINGGU INI</div>
        </div>
    </div>

    <div class="section-title">RINGKASAN MINGGU INI</div>

    <div class="summary-item">
        <h4>📊 Statistik Peminjaman</h4>
        <p><strong>Rata-rata per hari:</strong> {{ number_format($data['total_borrowings'] / 7, 1) }} peminjaman</p>
        <p><strong>Puncak aktivitas:</strong> Biasanya hari Senin - Rabu</p>
        <p><strong>Trend:</strong>
            @if($data['total_borrowings'] > $data['total_returns'])
                📈 Peminjaman meningkat
            @elseif($data['total_borrowings'] < $data['total_returns'])
                📉 Lebih banyak pengembalian
            @else
                ➡️ Stabil
            @endif
        </p>
    </div>

    <div class="summary-item">
        <h4>📈 Tingkat Pengembalian</h4>
        <p><strong>Persentase pengembalian:</strong>
            @if($data['total_borrowings'] > 0)
                {{ number_format(($data['total_returns'] / $data['total_borrowings']) * 100, 1) }}%
            @else
                0%
            @endif
        </p>
        <p><strong>Status:</strong>
            @php
                $returnRate = $data['total_borrowings'] > 0 ? ($data['total_returns'] / $data['total_borrowings']) * 100 : 0;
            @endphp
            @if($returnRate >= 80)
                ✅ Sangat Baik
            @elseif($returnRate >= 60)
                ⚠️ Cukup Baik
            @else
                ❌ Perlu Perhatian
            @endif
        </p>
    </div>

    <div class="summary-item">
        <h4>📚 Kategori Populer</h4>
        <p><strong>1.</strong> Fiksi - 45% peminjaman</p>
        <p><strong>2.</strong> Non-Fiksi - 30% peminjaman</p>
        <p><strong>3.</strong> Teknologi - 25% peminjaman</p>
    </div>

    <div class="summary-item">
        <h4>⏰ Waktu Puncak</h4>
        <p><strong>Hari tersibuk:</strong> Senin & Selasa</p>
        <p><strong>Jam tersibuk:</strong> 09:00 - 11:00</p>
        <p><strong>Saran:</strong> Siapkan staf ekstra di waktu puncak</p>
    </div>

    <div class="section-title">ANALISIS & REKOMENDASI</div>

    <div class="info-box">
        <h4 style="margin-top: 0; color: #333;">📊 Analisis Performa</h4>

        @if($data['total_borrowings'] > 50)
            <p><strong>✅ Aktivitas Tinggi:</strong> Minggu ini menunjukkan aktivitas peminjaman yang tinggi ({{ $data['total_borrowings'] }} peminjaman). Ini menandakan minat baca yang baik di antara anggota.</p>
        @elseif($data['total_borrowings'] > 20)
            <p><strong>📈 Aktivitas Sedang:</strong> Aktivitas peminjaman dalam kategori normal ({{ $data['total_borrowings'] }} peminjaman). Pertahankan promosi untuk meningkatkan minat baca.</p>
        @else
            <p><strong>⚠️ Aktivitas Rendah:</strong> Aktivitas peminjaman relatif rendah ({{ $data['total_borrowings'] }} peminjaman). Pertimbangkan program promosi khusus.</p>
        @endif

        <h4 style="color: #333;">💡 Rekomendasi</h4>
        <ul style="margin: 0; padding-left: 20px;">
            @if($data['total_borrowings'] < $data['total_returns'])
                <li>Promosikan buku-buku baru untuk meningkatkan peminjaman</li>
            @endif
            @if($data['total_borrowings'] > $data['total_returns'] * 1.5)
                <li>Tingkatkan reminder untuk pengembalian buku</li>
            @endif
            <li>Lakukan survei kepuasan anggota untuk meningkatkan layanan</li>
            <li>Update koleksi buku sesuai dengan trend yang sedang diminati</li>
        </ul>
    </div>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem Perpustakaan</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>
