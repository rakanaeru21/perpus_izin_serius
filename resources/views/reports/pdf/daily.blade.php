<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Harian - {{ $period }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 8px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 22px;
            font-weight: bold;
        }
        .header h2 {
            margin: 8px 0 0 0;
            color: #495057;
            font-size: 16px;
            font-weight: normal;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #6c757d;
        }

        .stats-overview {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-item {
            display: table-cell;
            width: 33.33%;
            padding: 12px 8px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            display: block;
            margin-bottom: 4px;
        }
        .stats-label {
            font-size: 9px;
            color: #495057;
            text-transform: uppercase;
            font-weight: 600;
        }

        .section-title {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 10px 15px;
            margin: 25px 0 12px 0;
            font-weight: bold;
            font-size: 13px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,123,255,0.2);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .table th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            color: #495057;
        }
        .table td {
            border: 1px solid #dee2e6;
            padding: 7px 6px;
            font-size: 10px;
            vertical-align: top;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .table tr:hover {
            background-color: #e3f2fd;
        }

        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .summary-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-box h4 {
            margin: 0 0 10px 0;
            color: #1976d2;
            font-size: 12px;
        }
        .summary-box p {
            margin: 5px 0;
            font-size: 10px;
            color: #424242;
        }

        .highlight-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 15px 0;
            border-radius: 0 4px 4px 0;
        }

        .footer {
            position: fixed;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
            background-color: white;
        }

        .text-center { text-align: center; }
        .text-success { color: #28a745; }
        .text-warning { color: #ffc107; }
        .text-danger { color: #dc3545; }
        .text-primary { color: #007bff; }
        .text-muted { color: #6c757d; }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            color: white;
            background-color: #6c757d;
            border-radius: 3px;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-danger { background-color: #dc3545; }
        .badge-primary { background-color: #007bff; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISTEM PERPUSTAKAAN</h1>
        <h2>Laporan Harian - {{ $period }}</h2>
        <p>Digenerate pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <h4>📊 Ringkasan Aktivitas Harian</h4>
        <p><strong>Periode Laporan:</strong> {{ date('d F Y', strtotime($data['date'])) }}</p>
        <p><strong>Total Aktivitas:</strong> {{ $data['total_borrowings'] + $data['total_returns'] }} transaksi</p>
        <p><strong>Status:</strong>
            @if($data['total_overdue'] > 0)
                <span class="text-warning">⚠️ {{ $data['total_overdue'] }} peminjaman terlambat</span>
            @else
                <span class="text-success">✅ Tidak ada keterlambatan</span>
            @endif
        </p>
    </div>

    <!-- Stats Overview -->
    <div class="stats-overview">
        <div class="stats-row">
            <div class="stats-item">
                <span class="stats-number">{{ $data['total_borrowings'] }}</span>
                <div class="stats-label">PEMINJAMAN BARU</div>
            </div>
            <div class="stats-item">
                <span class="stats-number text-success">{{ $data['total_returns'] }}</span>
                <div class="stats-label">PENGEMBALIAN</div>
            </div>
            <div class="stats-item">
                <span class="stats-number text-warning">{{ $data['total_overdue'] }}</span>
                <div class="stats-label">KETERLAMBATAN</div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Hari Ini -->
    @if($data['borrowings']->count() > 0)
        <div class="section-title">📚 PEMINJAMAN HARI INI</div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">ID Peminjaman</th>
                    <th width="25%">Nama Peminjam</th>
                    <th width="25%">Judul Buku</th>
                    <th width="12%">Tanggal Pinjam</th>
                    <th width="12%">Batas Kembali</th>
                    <th width="6%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['borrowings'] as $index => $borrowing)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>PJM{{ str_pad($borrowing->id_peminjaman, 6, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>{{ $borrowing->nama_peminjam ?? 'N/A' }}</strong></td>
                    <td>{{ $borrowing->judul_buku ?? 'N/A' }}</td>
                    <td>{{ date('d/m/Y', strtotime($borrowing->tanggal_pinjam)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($borrowing->batas_kembali)) }}</td>
                    <td>
                        @php
                            $statusClass = match($borrowing->status) {
                                'dipinjam' => 'badge-primary',
                                'dikembalikan' => 'badge-success',
                                'terlambat' => 'badge-warning',
                                'hilang' => 'badge-danger',
                                default => 'badge-primary'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($borrowing->status) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">📚 PEMINJAMAN HARI INI</div>
        <div class="no-data">Tidak ada peminjaman pada tanggal ini</div>
    @endif

    <!-- Pengembalian Hari Ini -->
    @if($data['returns']->count() > 0)
        <div class="section-title">📖 PENGEMBALIAN HARI INI</div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">ID Peminjaman</th>
                    <th width="25%">Nama Peminjam</th>
                    <th width="25%">Judul Buku</th>
                    <th width="12%">Tanggal Kembali</th>
                    <th width="10%">Kondisi Buku</th>
                    <th width="8%">Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['returns'] as $index => $return)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>PJM{{ str_pad($return->id_peminjaman, 6, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>{{ $return->nama_peminjam ?? 'N/A' }}</strong></td>
                    <td>{{ $return->judul_buku ?? 'N/A' }}</td>
                    <td>{{ date('d/m/Y', strtotime($return->tanggal_kembali)) }}</td>
                    <td>
                        @php
                            $kondisi = $return->kondisi_buku ?? 'baik';
                            $badgeClass = match($kondisi) {
                                'baik' => 'badge-success',
                                'rusak_ringan' => 'badge-warning',
                                'rusak_berat' => 'badge-danger',
                                'hilang' => 'badge-danger',
                                default => 'badge-success'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($kondisi) }}</span>
                    </td>
                    <td class="text-center">
                        @if(($return->denda ?? 0) > 0)
                            <span class="text-danger">Rp {{ number_format($return->denda, 0, ',', '.') }}</span>
                        @else
                            <span class="text-success">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">📖 PENGEMBALIAN HARI INI</div>
        <div class="no-data">Tidak ada pengembalian pada tanggal ini</div>
    @endif

    <!-- Alert Keterlambatan -->
    @if($data['total_overdue'] > 0)
        <div class="section-title">⚠️ PERINGATAN KETERLAMBATAN</div>
        <div class="highlight-box">
            <strong>⚠️ Perhatian Khusus:</strong> Terdapat {{ $data['total_overdue'] }} peminjaman yang sudah melewati batas waktu pengembalian.
            Silakan lakukan tindak lanjut untuk menghubungi peminjam yang terlambat dan melakukan penagihan denda jika diperlukan.
        </div>
    @endif

    <!-- Ringkasan dan Analisis -->
    <div class="section-title">📊 RINGKASAN HARI INI</div>
    <div class="summary-box">
        <h4>📈 Analisis Aktivitas Harian</h4>
        <p><strong>Efisiensi Layanan:</strong>
            @if($data['total_borrowings'] + $data['total_returns'] > 0)
                {{ $data['total_borrowings'] + $data['total_returns'] }} transaksi berhasil diproses
            @else
                Tidak ada aktivitas pada hari ini
            @endif
        </p>

        @if($data['total_borrowings'] > 0)
            <p><strong>Peminjaman:</strong> {{ $data['total_borrowings'] }} buku dipinjam hari ini</p>
        @endif

        @if($data['total_returns'] > 0)
            <p><strong>Pengembalian:</strong> {{ $data['total_returns'] }} buku dikembalikan hari ini</p>
        @endif

        @if($data['total_overdue'] > 0)
            <p><strong>⚠️ Keterlambatan:</strong> {{ $data['total_overdue'] }} peminjaman memerlukan tindak lanjut</p>
        @else
            <p><strong>✅ Status:</strong> Tidak ada keterlambatan yang perlu ditindaklanjuti</p>
        @endif

        @php
            $totalDenda = 0;
            if($data['returns'] && $data['returns']->count() > 0) {
                $totalDenda = $data['returns']->sum('denda');
            }
        @endphp

        @if($totalDenda > 0)
            <p><strong>💰 Total Denda:</strong> Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        @endif
    </div>

    <!-- Rekomendasi -->
    @if($data['total_borrowings'] + $data['total_returns'] > 0)
        <div class="highlight-box">
            <strong>💡 Rekomendasi untuk Esok Hari:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                @if($data['total_overdue'] > 0)
                    <li>Prioritaskan penanganan {{ $data['total_overdue'] }} peminjaman yang terlambat</li>
                @endif
                @if($data['total_borrowings'] > 5)
                    <li>Hari ini cukup sibuk dengan {{ $data['total_borrowings'] }} peminjaman - siapkan staf yang cukup</li>
                @endif
                @if($data['total_returns'] > 0)
                    <li>{{ $data['total_returns'] }} buku telah dikembalikan - lakukan pengecekan kondisi dan pengembalian ke rak</li>
                @endif
                @if($totalDenda > 0)
                    <li>Catat pemasukan denda sebesar Rp {{ number_format($totalDenda, 0, ',', '.') }} ke dalam laporan keuangan</li>
                @endif
            </ul>
        </div>
    @endif

    <div class="footer">
        <p><strong>Laporan Harian Perpustakaan</strong> | Digenerate secara otomatis oleh Sistem Perpustakaan</p>
        <p>Laporan untuk tanggal {{ date('d F Y', strtotime($data['date'])) }} | Halaman 1 dari 1</p>
    </div>
</body>
</html>
