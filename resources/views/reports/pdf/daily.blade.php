<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Harian - {{ $period }}</title>
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
            width: 33.33%;
            padding: 10px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            display: block;
        }
        .stats-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        .section-title {
            background-color: #007bff;
            color: white;
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
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISTEM PERPUSTAKAAN</h1>
        <h2>Laporan Harian - {{ $period }}</h2>
        <p style="margin: 5px 0 0 0; font-size: 11px;">Digenerate pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-box">
        <strong>Periode Laporan:</strong> {{ $data['date'] }}<br>
        <strong>Total Aktivitas:</strong> {{ $data['total_borrowings'] + $data['total_returns'] }} transaksi
    </div>

    <div class="stats-grid">
        <div class="stats-item">
            <span class="stats-number">{{ $data['total_borrowings'] }}</span>
            <div class="stats-label">PEMINJAMAN BARU</div>
        </div>
        <div class="stats-item">
            <span class="stats-number">{{ $data['total_returns'] }}</span>
            <div class="stats-label">PENGEMBALIAN</div>
        </div>
        <div class="stats-item">
            <span class="stats-number">{{ $data['total_overdue'] }}</span>
            <div class="stats-label">KETERLAMBATAN</div>
        </div>
    </div>

    @if($data['borrowings']->count() > 0)
        <div class="section-title">PEMINJAMAN HARI INI</div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Peminjaman</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['borrowings'] as $index => $borrowing)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $borrowing->id_peminjaman }}</td>
                    <td>{{ $borrowing->nama_peminjam ?? 'N/A' }}</td>
                    <td>{{ $borrowing->judul_buku ?? 'N/A' }}</td>
                    <td>{{ date('d/m/Y', strtotime($borrowing->tanggal_pinjam)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($borrowing->batas_kembali)) }}</td>
                    <td>{{ ucfirst($borrowing->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">PEMINJAMAN HARI INI</div>
        <div class="no-data">Tidak ada peminjaman pada tanggal ini</div>
    @endif

    @if($data['returns']->count() > 0)
        <div class="section-title">PENGEMBALIAN HARI INI</div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Peminjaman</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Kembali</th>
                    <th>Kondisi Buku</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['returns'] as $index => $return)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $return->id_peminjaman }}</td>
                    <td>{{ $return->nama_peminjam ?? 'N/A' }}</td>
                    <td>{{ $return->judul_buku ?? 'N/A' }}</td>
                    <td>{{ date('d/m/Y', strtotime($return->tanggal_kembali)) }}</td>
                    <td>{{ $return->kondisi_buku ?? 'Baik' }}</td>
                    <td>Rp {{ number_format($return->denda ?? 0, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="section-title">PENGEMBALIAN HARI INI</div>
        <div class="no-data">Tidak ada pengembalian pada tanggal ini</div>
    @endif

    @if($data['total_overdue'] > 0)
        <div class="section-title">KETERLAMBATAN</div>
        <div class="info-box">
            <strong>Peringatan:</strong> Terdapat {{ $data['total_overdue'] }} peminjaman yang sudah melewati batas waktu pengembalian.
            Silakan lakukan tindak lanjut untuk menghubungi peminjam yang terlambat.
        </div>
    @endif

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem Perpustakaan</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>
