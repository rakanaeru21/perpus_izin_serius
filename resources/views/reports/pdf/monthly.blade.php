<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan - {{ $period }}</title>
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
            font-size: 32px;
            font-weight: bold;
            color: #ffc107;
            display: block;
        }
        .stats-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .section-title {
            background-color: #ffc107;
            color: #333;
            padding: 8px 12px;
            margin: 20px 0 10px 0;
            font-weight: bold;
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            font-size: 11px;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .chart-placeholder {
            height: 150px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            color: #666;
        }
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            text-align: center;
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
        <h2>Laporan Bulanan - {{ $period }}</h2>
        <p style="margin: 5px 0 0 0; font-size: 11px;">Digenerate pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-box">
        <strong>Periode Laporan:</strong> {{ $data['period'] }}<br>
        <strong>Total Aktivitas:</strong> {{ $data['total_borrowings'] + $data['total_returns'] }} transaksi dalam sebulan<br>
        <strong>Rata-rata per hari:</strong> {{ number_format(($data['total_borrowings'] + $data['total_returns']) / 30, 1) }} transaksi
    </div>

    <div class="stats-grid">
        <div class="stats-item">
            <span class="stats-number">{{ $data['total_borrowings'] }}</span>
            <div class="stats-label">TOTAL PEMINJAMAN BULAN INI</div>
        </div>
        <div class="stats-item">
            <span class="stats-number">{{ $data['total_returns'] }}</span>
            <div class="stats-label">TOTAL PENGEMBALIAN BULAN INI</div>
        </div>
    </div>

    <div class="summary-grid">
        <div class="summary-item">
            <strong style="color: #007bff; font-size: 18px;">
                @if($data['total_borrowings'] > 0)
                    {{ number_format(($data['total_returns'] / $data['total_borrowings']) * 100, 1) }}%
                @else
                    0%
                @endif
            </strong>
            <div style="font-size: 11px; margin-top: 5px;">Tingkat Pengembalian</div>
        </div>
        <div class="summary-item">
            <strong style="color: #28a745; font-size: 18px;">{{ count($data['popular_books']) }}</strong>
            <div style="font-size: 11px; margin-top: 5px;">Buku Populer</div>
        </div>
        <div class="summary-item">
            <strong style="color: #dc3545; font-size: 18px;">{{ number_format($data['total_borrowings'] / 30, 1) }}</strong>
            <div style="font-size: 11px; margin-top: 5px;">Rata-rata/Hari</div>
        </div>
    </div>

    @if(count($data['popular_books']) > 0)
        <div class="section-title">BUKU PALING POPULER BULAN INI</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Judul Buku</th>
                    <th>Total Dipinjam</th>
                    <th>Persentase</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['popular_books'] as $index => $book)
                <tr>
                    <td>
                        @if($index == 0) 🥇
                        @elseif($index == 1) 🥈
                        @elseif($index == 2) 🥉
                        @else {{ $index + 1 }}
                        @endif
                    </td>
                    <td>{{ $book['judul_buku'] ?? $book->judul_buku }}</td>
                    <td>{{ $book['total_borrowed'] ?? $book->total_borrowed }}</td>
                    <td>
                        @if($data['total_borrowings'] > 0)
                            {{ number_format((($book['total_borrowed'] ?? $book->total_borrowed) / $data['total_borrowings']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <td>
                        @if(($book['total_borrowed'] ?? $book->total_borrowed) > 15)
                            🔥 Sangat Populer
                        @elseif(($book['total_borrowed'] ?? $book->total_borrowed) > 10)
                            📈 Populer
                        @else
                            📚 Normal
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">BUKU PALING POPULER BULAN INI</div>
        <div style="text-align: center; color: #666; font-style: italic; padding: 20px;">
            Data buku populer tidak tersedia untuk periode ini
        </div>
    @endif

    <div class="section-title">ANALISIS PERFORMA BULANAN</div>

    <div class="info-box">
        <h4 style="margin-top: 0; color: #333;">📊 Ringkasan Performa</h4>

        @php
            $returnRate = $data['total_borrowings'] > 0 ? ($data['total_returns'] / $data['total_borrowings']) * 100 : 0;
            $dailyAverage = ($data['total_borrowings'] + $data['total_returns']) / 30;
        @endphp

        <p><strong>Tingkat Aktivitas:</strong>
            @if($dailyAverage > 10)
                🔥 Sangat Tinggi ({{ number_format($dailyAverage, 1) }} transaksi/hari)
            @elseif($dailyAverage > 5)
                📈 Tinggi ({{ number_format($dailyAverage, 1) }} transaksi/hari)
            @elseif($dailyAverage > 2)
                📊 Sedang ({{ number_format($dailyAverage, 1) }} transaksi/hari)
            @else
                📉 Rendah ({{ number_format($dailyAverage, 1) }} transaksi/hari)
            @endif
        </p>

        <p><strong>Efisiensi Pengembalian:</strong>
            @if($returnRate >= 90)
                ✅ Sangat Baik ({{ number_format($returnRate, 1) }}%)
            @elseif($returnRate >= 75)
                👍 Baik ({{ number_format($returnRate, 1) }}%)
            @elseif($returnRate >= 60)
                ⚠️ Cukup ({{ number_format($returnRate, 1) }}%)
            @else
                ❌ Perlu Perhatian ({{ number_format($returnRate, 1) }}%)
            @endif
        </p>

        <h4 style="color: #333;">💡 Rekomendasi untuk Bulan Depan</h4>
        <ul style="margin: 0; padding-left: 20px;">
            @if($returnRate < 75)
                <li><strong>Tingkatkan sistem reminder</strong> untuk pengembalian buku</li>
            @endif
            @if($dailyAverage < 5)
                <li><strong>Lakukan promosi khusus</strong> untuk meningkatkan minat baca</li>
            @endif
            <li><strong>Tambah stok buku populer</strong> berdasarkan data di atas</li>
            <li><strong>Evaluasi jam operasional</strong> untuk mengoptimalkan layanan</li>
            @if(count($data['popular_books']) > 0)
                <li><strong>Buat display khusus</strong> untuk buku-buku populer</li>
            @endif
        </ul>
    </div>

    <div class="section-title">TARGET BULAN DEPAN</div>

    <div class="summary-grid">
        <div class="summary-item">
            <strong style="color: #007bff; font-size: 16px;">{{ $data['total_borrowings'] + 20 }}</strong>
            <div style="font-size: 11px; margin-top: 5px;">Target Peminjaman</div>
        </div>
        <div class="summary-item">
            <strong style="color: #28a745; font-size: 16px;">95%</strong>
            <div style="font-size: 11px; margin-top: 5px;">Target Pengembalian</div>
        </div>
        <div class="summary-item">
            <strong style="color: #ffc107; font-size: 16px;">{{ count($data['popular_books']) + 2 }}</strong>
            <div style="font-size: 11px; margin-top: 5px;">Buku Baru</div>
        </div>
    </div>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem Perpustakaan</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>
