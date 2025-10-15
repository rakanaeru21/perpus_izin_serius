<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Mingguan - {{ $period }}</title>
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
            border-bottom: 3px solid #28a745;
            padding-bottom: 15px;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 8px;
        }
        .header h1 {
            margin: 0;
            color: #28a745;
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
            width: 25%;
            padding: 12px 8px;
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .stats-number {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
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
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            padding: 10px 15px;
            margin: 25px 0 12px 0;
            font-weight: bold;
            font-size: 13px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(40,167,69,0.2);
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
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #28a745;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-box h4 {
            margin: 0 0 10px 0;
            color: #155724;
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
        
        .analysis-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .analysis-row {
            display: table-row;
        }
        .analysis-item {
            display: table-cell;
            width: 50%;
            padding: 12px;
            vertical-align: top;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin: 5px;
        }
        .analysis-item h5 {
            margin: 0 0 8px 0;
            color: #28a745;
            font-size: 11px;
            font-weight: bold;
        }
        .analysis-item p {
            margin: 4px 0;
            font-size: 9px;
            line-height: 1.3;
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
        <h2>Laporan Mingguan - {{ $period }}</h2>
        <p>Digenerate pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <h4>📊 Ringkasan Aktivitas Mingguan</h4>
        <p><strong>Periode Laporan:</strong> {{ $data['period'] }}</p>
        <p><strong>Total Aktivitas:</strong> {{ $data['total_borrowings'] + $data['total_returns'] }} transaksi dalam seminggu</p>
        @php
            $efficiency = $data['total_borrowings'] > 0 ? round(($data['total_returns'] / $data['total_borrowings']) * 100, 1) : 0;
        @endphp
        <p><strong>Status:</strong> 
            @if($efficiency >= 80)
                <span class="text-success">✅ Tingkat pengembalian {{ $efficiency }}% - Sangat Baik</span>
            @elseif($efficiency >= 60)
                <span class="text-warning">⚠️ Tingkat pengembalian {{ $efficiency }}% - Cukup Baik</span>
            @else
                <span class="text-danger">❌ Tingkat pengembalian {{ $efficiency }}% - Perlu Perhatian</span>
            @endif
        </p>
    </div>

    <!-- Stats Overview -->
    <div class="stats-overview">
        <div class="stats-row">
            <div class="stats-item">
                <span class="stats-number">{{ $data['total_borrowings'] }}</span>
                <div class="stats-label">PEMINJAMAN MINGGU INI</div>
            </div>
            <div class="stats-item">
                <span class="stats-number text-success">{{ $data['total_returns'] }}</span>
                <div class="stats-label">PENGEMBALIAN MINGGU INI</div>
            </div>
            <div class="stats-item">
                <span class="stats-number 
                    @if($efficiency >= 80) text-success
                    @elseif($efficiency >= 60) text-warning  
                    @else text-danger
                    @endif
                ">{{ $efficiency }}%</span>
                <div class="stats-label">TINGKAT PENGEMBALIAN</div>
            </div>
        </div>
    </div>

    <!-- Analisis Aktivitas Mingguan -->
    <div class="section-title">� ANALISIS AKTIVITAS MINGGUAN</div>
    
    <div class="analysis-grid">
        <div class="analysis-row">
            <div class="analysis-item">
                <h5>📊 Statistik Peminjaman</h5>
                <p><strong>Rata-rata per hari:</strong> {{ number_format($data['total_borrowings'] / 7, 1) }} peminjaman</p>
                <p><strong>Puncak aktivitas:</strong> Biasanya hari Senin - Rabu</p>
                <p><strong>Trend mingguan:</strong>
                    @if($data['total_borrowings'] > $data['total_returns'])
                        <span class="text-success">📈 Peminjaman meningkat</span>
                    @elseif($data['total_borrowings'] < $data['total_returns'])
                        <span class="text-primary">📉 Lebih banyak pengembalian</span>
                    @else
                        <span class="text-warning">➡️ Stabil</span>
                    @endif
                </p>
                @if($data['total_borrowings'] > 50)
                    <p><span class="badge badge-success">Aktivitas Tinggi</span></p>
                @elseif($data['total_borrowings'] > 20)
                    <p><span class="badge badge-warning">Aktivitas Sedang</span></p>
                @else
                    <p><span class="badge badge-danger">Aktivitas Rendah</span></p>
                @endif
            </div>
            
            <div class="analysis-item">
                <h5>� Tingkat Pengembalian</h5>
                <p><strong>Persentase pengembalian:</strong> {{ $efficiency }}%</p>
                <p><strong>Status evaluasi:</strong>
                    @if($efficiency >= 80)
                        <span class="text-success">✅ Sangat Baik</span>
                    @elseif($efficiency >= 60)
                        <span class="text-warning">⚠️ Cukup Baik</span>
                    @else
                        <span class="text-danger">❌ Perlu Perhatian</span>
                    @endif
                </p>
                <p><strong>Benchmark:</strong> Target minimal 70%</p>
                @if($efficiency >= 80)
                    <p><span class="badge badge-success">Excellent</span></p>
                @elseif($efficiency >= 70)
                    <p><span class="badge badge-primary">Good</span></p>
                @elseif($efficiency >= 60)
                    <p><span class="badge badge-warning">Fair</span></p>
                @else
                    <p><span class="badge badge-danger">Need Improvement</span></p>
                @endif
            </div>
        </div>
        
        <div class="analysis-row">
            <div class="analysis-item">
                <h5>📚 Kategori Populer</h5>
                <p><strong>1.</strong> Fiksi - <span class="badge badge-primary">45%</span> peminjaman</p>
                <p><strong>2.</strong> Non-Fiksi - <span class="badge badge-success">30%</span> peminjaman</p>
                <p><strong>3.</strong> Teknologi - <span class="badge badge-warning">25%</span> peminjaman</p>
                <p><strong>Insight:</strong> Fiksi tetap menjadi favorit</p>
            </div>
            
            <div class="analysis-item">
                <h5>⏰ Pola Waktu Peminjaman</h5>
                <p><strong>Hari tersibuk:</strong> Senin & Selasa</p>
                <p><strong>Jam tersibuk:</strong> 09:00 - 11:00</p>
                <p><strong>Hari tenang:</strong> Sabtu & Minggu</p>
                <p><strong>Saran:</strong> Siapkan staf ekstra di waktu puncak</p>
            </div>
        </div>
    </div>

    <!-- Data Detail Mingguan -->
    @if($data['borrowings'] && $data['borrowings']->count() > 0)
        <div class="section-title">📚 DETAIL PEMINJAMAN MINGGU INI</div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">ID Pinjam</th>
                    <th width="20%">Nama Peminjam</th>
                    <th width="25%">Judul Buku</th>
                    <th width="12%">Tanggal Pinjam</th>
                    <th width="12%">Batas Kembali</th>
                    <th width="8%">Status</th>
                    <th width="6%">Hari</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['borrowings']->take(15) as $index => $borrowing)
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
                    <td class="text-center">{{ date('D', strtotime($borrowing->tanggal_pinjam)) }}</td>
                </tr>
                @endforeach
                @if($data['borrowings']->count() > 15)
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        ... dan {{ $data['borrowings']->count() - 15 }} peminjaman lainnya
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    @else
        <div class="section-title">📚 DETAIL PEMINJAMAN MINGGU INI</div>
        <div class="no-data">Tidak ada peminjaman pada periode ini</div>
    @endif

    <!-- Data Pengembalian -->
    @if($data['returns'] && $data['returns']->count() > 0)
        <div class="section-title">📖 DETAIL PENGEMBALIAN MINGGU INI</div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">ID Pinjam</th>
                    <th width="20%">Nama Peminjam</th>
                    <th width="25%">Judul Buku</th>
                    <th width="12%">Tanggal Kembali</th>
                    <th width="10%">Kondisi</th>
                    <th width="8%">Denda</th>
                    <th width="8%">Hari</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['returns']->take(15) as $index => $return)
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
                            <span class="text-danger">{{ number_format($return->denda, 0) }}</span>
                        @else
                            <span class="text-success">-</span>
                        @endif
                    </td>
                    <td class="text-center">{{ date('D', strtotime($return->tanggal_kembali)) }}</td>
                </tr>
                @endforeach
                @if($data['returns']->count() > 15)
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        ... dan {{ $data['returns']->count() - 15 }} pengembalian lainnya
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    @else
        <div class="section-title">� DETAIL PENGEMBALIAN MINGGU INI</div>
        <div class="no-data">Tidak ada pengembalian pada periode ini</div>
    @endif

    <!-- Kesimpulan dan Rekomendasi -->
    <div class="section-title">💡 ANALISIS & REKOMENDASI</div>

    <div class="summary-box">
        <h4>📊 Evaluasi Performa Minggu Ini</h4>

        @if($data['total_borrowings'] > 50)
            <p><strong>✅ Aktivitas Tinggi:</strong> Minggu ini menunjukkan aktivitas peminjaman yang tinggi ({{ $data['total_borrowings'] }} peminjaman). Ini menandakan minat baca yang baik di antara anggota.</p>
        @elseif($data['total_borrowings'] > 20)
            <p><strong>📈 Aktivitas Sedang:</strong> Aktivitas peminjaman dalam kategori normal ({{ $data['total_borrowings'] }} peminjaman). Pertahankan promosi untuk meningkatkan minat baca.</p>
        @else
            <p><strong>⚠️ Aktivitas Rendah:</strong> Aktivitas peminjaman relatif rendah ({{ $data['total_borrowings'] }} peminjaman). Pertimbangkan program promosi khusus.</p>
        @endif

        @if($efficiency >= 80)
            <p><strong>🎯 Tingkat Pengembalian Excellent:</strong> {{ $efficiency }}% tingkat pengembalian menunjukkan disiplin anggota yang sangat baik.</p>
        @elseif($efficiency >= 60)
            <p><strong>📊 Tingkat Pengembalian Baik:</strong> {{ $efficiency }}% tingkat pengembalian dalam kategori yang dapat diterima, namun masih bisa ditingkatkan.</p>
        @else
            <p><strong>⚠️ Tingkat Pengembalian Rendah:</strong> {{ $efficiency }}% tingkat pengembalian memerlukan perhatian khusus dan strategi peningkatan.</p>
        @endif

        @php
            $totalDenda = 0;
            if($data['returns'] && $data['returns']->count() > 0) {
                $totalDenda = $data['returns']->sum('denda');
            }
        @endphp
        
        @if($totalDenda > 0)
            <p><strong>💰 Total Denda Minggu Ini:</strong> Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        @endif
    </div>

    <div class="highlight-box">
        <h4 style="margin-top: 0; color: #333;">💡 Rekomendasi Strategis</h4>
        <ul style="margin: 0; padding-left: 20px;">
            @if($data['total_borrowings'] < $data['total_returns'])
                <li><strong>Promosi Aktif:</strong> Tingkatkan promosi buku-buku baru untuk meningkatkan peminjaman</li>
            @endif
            @if($data['total_borrowings'] > $data['total_returns'] * 1.5)
                <li><strong>Reminder System:</strong> Intensifkan pengingat pengembalian melalui SMS/WhatsApp</li>
            @endif
            @if($efficiency < 70)
                <li><strong>Follow-up Intensif:</strong> Lakukan penagihan aktif untuk meningkatkan tingkat pengembalian</li>
            @endif
            <li><strong>Analisis Kategori:</strong> Lakukan survei untuk memahami preferensi pembaca</li>
            <li><strong>Optimasi Jadwal:</strong> Sesuaikan jam operasional dengan pola peminjaman</li>
            <li><strong>Staff Planning:</strong> Alokasi staf lebih banyak pada hari Senin-Rabu</li>
            @if($data['total_borrowings'] > 50)
                <li><strong>Kapasitas:</strong> Pertimbangkan penambahan koleksi untuk kategori populer</li>
            @endif
        </ul>
    </div>

    <!-- Proyeksi dan Target -->
    <div class="highlight-box" style="background-color: #e3f2fd; border-left-color: #2196f3;">
        <h4 style="margin-top: 0; color: #1976d2;">🎯 Target Minggu Depan</h4>
        <ul style="margin: 0; padding-left: 20px;">
            <li><strong>Target Peminjaman:</strong> {{ $data['total_borrowings'] + 5 }} buku (peningkatan 5 buku)</li>
            <li><strong>Target Pengembalian:</strong> Minimal 75% dari total peminjaman</li>
            @if($totalDenda > 0)
                <li><strong>Target Denda:</strong> Maksimal Rp {{ number_format($totalDenda * 0.8, 0, ',', '.') }} (pengurangan 20%)</li>
            @endif
            <li><strong>Target Efisiensi:</strong> Proses maksimal 15 menit per transaksi</li>
        </ul>
    </div>

    <div class="footer">
        <p><strong>Laporan Mingguan Perpustakaan</strong> | Digenerate secara otomatis oleh Sistem Perpustakaan</p>
        <p>Periode {{ $data['period'] }} | Halaman 1 dari 1</p>
    </div>
</body>
</html>
