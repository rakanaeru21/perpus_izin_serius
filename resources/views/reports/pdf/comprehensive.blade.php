<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Komprehensif Perpustakaan - {{ $period }}</title>
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
            width: 14.28%;
            padding: 12px 8px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .stats-number {
            font-size: 18px;
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

        .section-subtitle {
            background-color: #e9ecef;
            color: #495057;
            padding: 6px 12px;
            margin: 15px 0 8px 0;
            font-weight: 600;
            font-size: 11px;
            border-left: 4px solid #007bff;
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

        .rating-stars {
            color: #ffc107;
            font-weight: bold;
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

        .page-break {
            page-break-before: always;
        }

        .highlight-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 15px 0;
            border-radius: 0 4px 4px 0;
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
        <h2>Laporan Komprehensif Perpustakaan</h2>
        <p>{{ $data['period'] }} | Digenerate pada: {{ $data['generated_at'] }}</p>
    </div>

    <!-- Statistik Overview -->
    <div class="summary-box">
        <h4>📊 Ringkasan Statistik Perpustakaan</h4>
        <p><strong>Total Anggota Aktif:</strong> {{ number_format($data['statistics']['total_members']) }} orang</p>
        <p><strong>Total Koleksi Buku:</strong> {{ number_format($data['statistics']['total_books']) }} judul</p>
        <p><strong>Total Riwayat Peminjaman:</strong> {{ number_format($data['statistics']['total_borrowings']) }} transaksi</p>
    </div>

    <div class="stats-overview">
        <div class="stats-row">
            <div class="stats-item">
                <span class="stats-number">{{ $data['statistics']['total_members'] }}</span>
                <div class="stats-label">Total Anggota</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $data['statistics']['total_books'] }}</span>
                <div class="stats-label">Total Buku</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $data['statistics']['active_borrowings'] }}</span>
                <div class="stats-label">Sedang Dipinjam</div>
            </div>
            <div class="stats-item">
                <span class="stats-number text-warning">{{ $data['statistics']['overdue_borrowings'] }}</span>
                <div class="stats-label">Terlambat</div>
            </div>
            <div class="stats-item">
                <span class="stats-number text-success">{{ $data['statistics']['recent_borrowings'] }}</span>
                <div class="stats-label">Pinjam 7 Hari</div>
            </div>
            <div class="stats-item">
                <span class="stats-number text-primary">{{ $data['statistics']['recent_returns'] }}</span>
                <div class="stats-label">Kembali 7 Hari</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $data['statistics']['total_borrowings'] }}</span>
                <div class="stats-label">Total Transaksi</div>
            </div>
        </div>
    </div>

    <!-- Peminjam Terbaru -->
    <div class="section-title">👥 PEMINJAM TERBARU (7 HARI TERAKHIR)</div>
    @if($data['recent_borrowers']->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">ID Pinjam</th>
                    <th width="25%">Nama Peminjam</th>
                    <th width="15%">Username</th>
                    <th width="25%">Judul Buku</th>
                    <th width="15%">Tanggal Pinjam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['recent_borrowers'] as $index => $borrower)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>PJM{{ str_pad($borrower->id_peminjaman, 6, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>{{ $borrower->nama_peminjam }}</strong></td>
                    <td>{{ $borrower->username }}</td>
                    <td>{{ $borrower->judul_buku }} <br><small class="text-muted">{{ $borrower->penulis }}</small></td>
                    <td>{{ date('d/m/Y', strtotime($borrower->tanggal_pinjam)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Tidak ada peminjaman dalam 7 hari terakhir</div>
    @endif

    <!-- Buku yang Dikembalikan -->
    <div class="section-title">📚 BUKU YANG DIKEMBALIKAN (7 HARI TERAKHIR)</div>
    @if($data['recent_returns']->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">ID Pinjam</th>
                    <th width="25%">Nama Peminjam</th>
                    <th width="30%">Judul Buku</th>
                    <th width="15%">Tanggal Kembali</th>
                    <th width="10%">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['recent_returns'] as $index => $return)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>PJM{{ str_pad($return->id_peminjaman, 6, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>{{ $return->nama_peminjam }}</strong></td>
                    <td>{{ $return->judul_buku }} <br><small class="text-muted">{{ $return->penulis }}</small></td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Tidak ada pengembalian dalam 7 hari terakhir</div>
    @endif

    <div class="page-break"></div>

    <!-- Buku dengan Rating Bagus -->
    <div class="section-title">⭐ BUKU DENGAN RATING TINGGI (≥ 4.0)</div>
    @if($data['high_rated_books']->count() > 0)
        <div class="highlight-box">
            <strong>📈 Insight:</strong> Buku-buku berikut mendapat rating tinggi dari pembaca dan dapat dijadikan rekomendasi utama.
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Judul Buku</th>
                    <th width="25%">Penulis</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Rating</th>
                    <th width="10%">Jumlah Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['high_rated_books'] as $index => $book)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $book->judul_buku }}</strong></td>
                    <td>{{ $book->penulis }}</td>
                    <td><span class="badge badge-primary">{{ $book->kategori }}</span></td>
                    <td class="text-center">
                        <span class="rating-stars">★{{ $book->avg_rating }}</span>
                    </td>
                    <td class="text-center">{{ $book->total_ratings }} review</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Belum ada buku dengan rating tinggi (minimal 4.0)</div>
    @endif

    <!-- Buku yang Sering Dipinjam -->
    <div class="section-title">🔥 BUKU YANG SERING DIPINJAM</div>
    @if($data['popular_books']->count() > 0)
        <div class="highlight-box">
            <strong>📊 Insight:</strong> Buku-buku populer berikut sering dipinjam dan mungkin perlu penambahan stok.
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">Rank</th>
                    <th width="40%">Judul Buku</th>
                    <th width="25%">Penulis</th>
                    <th width="15%">Kategori</th>
                    <th width="15%">Total Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['popular_books'] as $index => $book)
                <tr>
                    <td class="text-center">
                        @if($index < 3)
                            <span class="badge badge-warning">#{{ $index + 1 }}</span>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </td>
                    <td><strong>{{ $book->judul_buku }}</strong></td>
                    <td>{{ $book->penulis }}</td>
                    <td><span class="badge badge-primary">{{ $book->kategori }}</span></td>
                    <td class="text-center">
                        <strong class="text-primary">{{ $book->total_borrowed }}x</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Belum ada data peminjaman buku</div>
    @endif

    <!-- Buku yang Jarang Dipinjam -->
    <div class="section-title">📉 BUKU YANG JARANG DIPINJAM</div>
    @if($data['unpopular_books']->count() > 0)
        <div class="highlight-box">
            <strong>⚠️ Perhatian:</strong> Buku-buku berikut jarang atau tidak pernah dipinjam. Pertimbangkan strategi promosi atau evaluasi koleksi.
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Judul Buku</th>
                    <th width="25%">Penulis</th>
                    <th width="15%">Kategori</th>
                    <th width="10%">Tahun</th>
                    <th width="5%">Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['unpopular_books'] as $index => $book)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $book->judul_buku }}</strong></td>
                    <td>{{ $book->penulis }}</td>
                    <td><span class="badge badge-primary">{{ $book->kategori }}</span></td>
                    <td class="text-center">{{ $book->tahun_terbit }}</td>
                    <td class="text-center">
                        @if($book->total_borrowed == 0)
                            <span class="text-danger">0x</span>
                        @else
                            <span class="text-warning">{{ $book->total_borrowed }}x</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">Semua buku telah dipinjam minimal sekali</div>
    @endif

    <!-- Kesimpulan dan Rekomendasi -->
    <div class="page-break"></div>
    <div class="section-title">💡 KESIMPULAN DAN REKOMENDASI</div>

    <div class="summary-box">
        <h4>📋 Ringkasan Laporan</h4>
        <p><strong>Total Aktivitas 7 Hari Terakhir:</strong> {{ $data['statistics']['recent_borrowings'] }} peminjaman, {{ $data['statistics']['recent_returns'] }} pengembalian</p>
        <p><strong>Buku Rating Tinggi:</strong> {{ $data['high_rated_books']->count() }} buku dengan rating ≥ 4.0</p>
        <p><strong>Buku Populer:</strong> {{ $data['popular_books']->count() }} buku teratas berdasarkan frekuensi peminjaman</p>
        <p><strong>Buku Kurang Populer:</strong> {{ $data['unpopular_books']->count() }} buku dengan peminjaman terendah</p>
    </div>

    @if($data['statistics']['overdue_borrowings'] > 0)
    <div class="highlight-box">
        <strong>⚠️ Perhatian Khusus:</strong> Terdapat {{ $data['statistics']['overdue_borrowings'] }} peminjaman yang terlambat.
        Silakan lakukan tindak lanjut untuk menghubungi peminjam yang bersangkutan.
    </div>
    @endif

    <div class="section-subtitle">🎯 Rekomendasi Tindak Lanjut:</div>
    <table class="table">
        <thead>
            <tr>
                <th width="30%">Area</th>
                <th width="70%">Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Koleksi Populer</strong></td>
                <td>Pertimbangkan menambah stok untuk {{ $data['popular_books']->take(3)->pluck('judul_buku')->implode(', ') }}</td>
            </tr>
            <tr>
                <td><strong>Promosi Buku</strong></td>
                <td>Lakukan promosi khusus untuk buku-buku yang jarang dipinjam melalui display, rekomendasi petugas, atau program khusus</td>
            </tr>
            <tr>
                <td><strong>Koleksi Berkualitas</strong></td>
                <td>Buku dengan rating tinggi dapat dijadikan koleksi unggulan dan direkomendasi kepada anggota baru</td>
            </tr>
            <tr>
                <td><strong>Aktivitas Peminjaman</strong></td>
                <td>Pantau tren peminjaman dan siapkan strategi untuk meningkatkan sirkulasi buku</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Laporan Komprehensif Perpustakaan</strong> | Digenerate secara otomatis oleh Sistem Perpustakaan</p>
        <p>Halaman ini berisi analisis menyeluruh aktivitas perpustakaan untuk pengambilan keputusan strategis</p>
    </div>
</body>
</html>
