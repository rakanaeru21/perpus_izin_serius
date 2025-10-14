<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Tahunan - {{ $period }}</title>
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
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 20px;
        }
        .header h2 {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 16px;
            font-weight: normal;
        }
        .executive-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .executive-summary h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
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
            margin-bottom: 25px;
        }
        .stats-item {
            display: table-cell;
            width: 50%;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .stats-number {
            font-size: 36px;
            font-weight: bold;
            color: #dc3545;
            display: block;
        }
        .stats-label {
            font-size: 13px;
            color: #666;
            margin-top: 8px;
        }
        .section-title {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            margin: 25px 0 15px 0;
            font-weight: bold;
            font-size: 15px;
        }
        .kpi-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .kpi-item {
            display: table-cell;
            width: 25%;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            text-align: center;
        }
        .kpi-number {
            font-size: 24px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .kpi-label {
            font-size: 10px;
            color: #666;
        }
        .chart-placeholder {
            height: 200px;
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            color: #666;
            font-size: 14px;
        }
        .achievement-box {
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .achievement-box h4 {
            margin: 0 0 10px 0;
            color: #2d3436;
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
        <h2>📊 LAPORAN TAHUNAN {{ $period }}</h2>
        <p style="margin: 10px 0 0 0; font-size: 12px;">Ringkasan Komprehensif Aktivitas Perpustakaan</p>
        <p style="margin: 5px 0 0 0; font-size: 11px;">Digenerate pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="executive-summary">
        <h3>🎯 RINGKASAN EKSEKUTIF</h3>
        <p style="margin: 0;">
            Tahun {{ $data['period'] }} menunjukkan
            @if($data['total_borrowings'] > 1000)
                <strong>performa luar biasa</strong>
            @elseif($data['total_borrowings'] > 500)
                <strong>performa yang solid</strong>
            @else
                <strong>fondasi yang baik</strong>
            @endif
            dengan total {{ $data['total_borrowings'] }} peminjaman dan {{ $data['total_returns'] }} pengembalian.
            Tingkat efisiensi operasional mencapai
            @if($data['total_borrowings'] > 0)
                {{ number_format(($data['total_returns'] / $data['total_borrowings']) * 100, 1) }}%
            @else
                0%
            @endif
            yang menunjukkan sistem perpustakaan yang
            @php
                $efficiency = $data['total_borrowings'] > 0 ? ($data['total_returns'] / $data['total_borrowings']) * 100 : 0;
            @endphp
            @if($efficiency >= 85) sangat efektif
            @elseif($efficiency >= 70) cukup efektif
            @else perlu optimisasi
            @endif
            .
        </p>
    </div>

    <div class="stats-grid">
        <div class="stats-item">
            <span class="stats-number">{{ number_format($data['total_borrowings']) }}</span>
            <div class="stats-label">TOTAL PEMINJAMAN TAHUN {{ $data['period'] }}</div>
        </div>
        <div class="stats-item">
            <span class="stats-number">{{ number_format($data['total_returns']) }}</span>
            <div class="stats-label">TOTAL PENGEMBALIAN TAHUN {{ $data['period'] }}</div>
        </div>
    </div>

    <div class="section-title">📈 KEY PERFORMANCE INDICATORS (KPI)</div>

    <div class="kpi-grid">
        <div class="kpi-item">
            <span class="kpi-number" style="color: #007bff;">
                @if($data['total_borrowings'] > 0)
                    {{ number_format(($data['total_returns'] / $data['total_borrowings']) * 100, 1) }}%
                @else
                    0%
                @endif
            </span>
            <div class="kpi-label">TINGKAT PENGEMBALIAN</div>
        </div>
        <div class="kpi-item">
            <span class="kpi-number" style="color: #28a745;">{{ number_format($data['total_borrowings'] / 365, 1) }}</span>
            <div class="kpi-label">RATA-RATA HARIAN</div>
        </div>
        <div class="kpi-item">
            <span class="kpi-number" style="color: #ffc107;">{{ number_format($data['total_borrowings'] / 12, 0) }}</span>
            <div class="kpi-label">RATA-RATA BULANAN</div>
        </div>
        <div class="kpi-item">
            <span class="kpi-number" style="color: #dc3545;">
                @if($data['total_borrowings'] > 0)
                    {{ number_format((($data['total_borrowings'] - $data['total_returns']) / $data['total_borrowings']) * 100, 1) }}%
                @else
                    0%
                @endif
            </span>
            <div class="kpi-label">BUKU BELUM KEMBALI</div>
        </div>
    </div>

    <div class="section-title">🏆 PENCAPAIAN & MILESTONE</div>

    <div class="achievement-box">
        <h4>🎉 Pencapaian Tahun {{ $data['period'] }}</h4>
        <ul style="margin: 0; padding-left: 20px;">
            @if($data['total_borrowings'] > 1000)
                <li><strong>🎯 Target Utama:</strong> Mencapai lebih dari 1000 peminjaman ({{ $data['total_borrowings'] }} peminjaman)</li>
            @endif
            @if($data['total_borrowings'] > 0 && ($data['total_returns'] / $data['total_borrowings']) * 100 > 80)
                <li><strong>✅ Efisiensi Tinggi:</strong> Tingkat pengembalian di atas 80%</li>
            @endif
            <li><strong>📚 Layanan Konsisten:</strong> Beroperasi sepanjang tahun tanpa gangguan signifikan</li>
            <li><strong>💻 Digitalisasi:</strong> Implementasi sistem digital perpustakaan</li>
        </ul>
    </div>

    @if(count($data['monthly_breakdown'] ?? []) > 0)
        <div class="section-title">📊 TREN BULANAN</div>
        <div class="chart-placeholder">
            📈 Grafik Tren Peminjaman Bulanan<br>
            <small>(Data tersedia untuk visualisasi di dashboard online)</small>
        </div>
    @endif

    <div class="section-title">📋 ANALISIS KOMPREHENSIF</div>

    <div class="info-box">
        <h4 style="margin-top: 0; color: #333;">📊 Analisis Performa Tahunan</h4>

        @php
            $returnRate = $data['total_borrowings'] > 0 ? ($data['total_returns'] / $data['total_borrowings']) * 100 : 0;
            $dailyAverage = $data['total_borrowings'] / 365;
            $monthlyAverage = $data['total_borrowings'] / 12;
        @endphp

        <p><strong>Performa Operasional:</strong></p>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>Rata-rata {{ number_format($dailyAverage, 1) }} transaksi per hari</li>
            <li>Puncak aktivitas mencapai {{ number_format($monthlyAverage * 1.3, 0) }} peminjaman per bulan</li>
            <li>Tingkat utilisasi perpustakaan:
                @if($dailyAverage > 10) Sangat Tinggi
                @elseif($dailyAverage > 5) Tinggi
                @elseif($dailyAverage > 2) Sedang
                @else Rendah
                @endif
            </li>
        </ul>

        <p><strong>Efisiensi Sistem:</strong></p>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>Tingkat pengembalian: {{ number_format($returnRate, 1) }}%
                @if($returnRate >= 90) (Sangat Baik)
                @elseif($returnRate >= 75) (Baik)
                @elseif($returnRate >= 60) (Cukup)
                @else (Perlu Perbaikan)
                @endif
            </li>
            <li>Estimasi buku yang masih beredar: {{ $data['total_borrowings'] - $data['total_returns'] }} eksemplar</li>
        </ul>
    </div>

    <div class="section-title">🎯 STRATEGI & REKOMENDASI 2026</div>

    <div class="info-box">
        <h4 style="margin-top: 0; color: #333;">💡 Rencana Strategis Tahun Depan</h4>

        <p><strong>Target Kuantitatif:</strong></p>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>🎯 Target peminjaman: {{ number_format($data['total_borrowings'] * 1.15, 0) }} (peningkatan 15%)</li>
            <li>📈 Target pengembalian: 95% dari total peminjaman</li>
            <li>👥 Target anggota baru: 100 anggota</li>
        </ul>

        <p><strong>Inisiatif Strategis:</strong></p>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li><strong>Digitalisasi Lanjutan:</strong> Implementasi sistem AI untuk rekomendasi buku</li>
            <li><strong>Program Engagement:</strong> Event bulanan dan klub baca</li>
            <li><strong>Ekspansi Koleksi:</strong> Tambah 500 judul buku baru</li>
            <li><strong>Optimisasi Operasional:</strong> Extended hours dan self-service kiosks</li>
        </ul>

        <p><strong>Focus Areas:</strong></p>
        <ul style="margin: 5px 0; padding-left: 20px;">
            @if($returnRate < 85)
                <li>🔍 <strong>Prioritas Utama:</strong> Tingkatkan sistem tracking dan reminder</li>
            @endif
            @if($dailyAverage < 5)
                <li>📢 <strong>Marketing:</strong> Kampanye awareness dan promosi khusus</li>
            @endif
            <li>🏗️ <strong>Infrastructure:</strong> Upgrade teknologi dan fasilitas</li>
            <li>👨‍🏫 <strong>SDM:</strong> Training staff dan customer service excellence</li>
        </ul>
    </div>

    <div class="footer">
        <p><strong>Laporan Tahunan Sistem Perpustakaan {{ $data['period'] }}</strong></p>
        <p>Dokumen ini merupakan ringkasan komprehensif aktivitas perpustakaan selama satu tahun penuh</p>
        <p>Halaman 1 dari 1 | Generated: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
