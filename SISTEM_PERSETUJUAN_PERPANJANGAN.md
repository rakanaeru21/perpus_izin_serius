# Dokumentasi Implementasi Sistem Persetujuan Perpanjangan Buku

## Overview
Sistem perpanjangan buku telah diubah dari yang sebelumnya bisa diperpanjang langsung oleh anggota, menjadi sistem yang memerlukan persetujuan dari petugas perpustakaan.

## Perubahan yang Dilakukan

### 1. Database Migration
**File:** `database/migrations/2025_10_15_135504_add_extension_approval_to_peminjaman_table.php`

Menambahkan kolom-kolom baru pada tabel `peminjaman`:
- `extension_status`: enum('none', 'requested', 'approved', 'rejected') - Status permintaan perpanjangan
- `extension_requested_at`: date - Tanggal permintaan perpanjangan
- `approved_by`: foreign key ke tabel user - ID petugas yang menyetujui/menolak
- `extension_approved_at`: date - Tanggal persetujuan/penolakan
- `extension_reason`: text - Alasan permintaan perpanjangan dari anggota
- `rejection_reason`: text - Alasan penolakan dari petugas

### 2. Model Updates
**File:** `app/Models/Pinjaman.php`

Menambahkan:
- Relationship `approver()` untuk petugas yang menyetujui
- Method `requestExtension()` untuk membuat permintaan perpanjangan
- Method `approveExtension()` untuk menyetujui perpanjangan
- Method `rejectExtension()` untuk menolak perpanjangan
- Method `canRequestExtension()` untuk validasi kelayakan permintaan
- Accessor untuk formatting status dan warna UI
- Scope `pendingExtensions()` untuk query permintaan yang menunggu

### 3. Controller Updates

#### AnggotaController.php
**Method:** `extendLoan()`
- Diubah dari langsung memperpanjang ke membuat permintaan perpanjangan
- Menambahkan validasi parameter `reason` (opsional)
- Menggunakan method `requestExtension()` dari model

#### ExtensionController.php (Baru)
**File:** `app/Http/Controllers/Dashboard/Petugas/ExtensionController.php`

Method yang tersedia:
- `index()` - Menampilkan halaman kelola perpanjangan dengan statistics
- `approve($id)` - Menyetujui permintaan perpanjangan
- `reject($id)` - Menolak permintaan perpanjangan
- `show($id)` - Detail permintaan perpanjangan (untuk AJAX)

### 4. View Updates

#### loans.blade.php (Anggota)
**File:** `resources/views/dashboard/anggota/loans.blade.php`

Perubahan:
- Menambahkan badge status perpanjangan di kolom Status
- Mengubah logika tombol perpanjangan berdasarkan status:
  - Jika bisa request: tampilkan tombol "Perpanjang"
  - Jika sedang request: tampilkan "Menunggu persetujuan"
  - Jika disetujui: tampilkan "Diperpanjang"
  - Jika ditolak: tampilkan "Ditolak" + alasan
- Menambahkan modal untuk input alasan perpanjangan
- JavaScript untuk handle submit request perpanjangan

#### index.blade.php (Petugas)
**File:** `resources/views/dashboard/petugas/extensions/index.blade.php`

Fitur:
- Statistics cards (pending, approved today, rejected today, total approved)
- Tab interface untuk mengelola:
  - Permintaan pending
  - Permintaan yang sudah disetujui
  - Permintaan yang ditolak
- Modal untuk approve dengan pilihan jumlah hari perpanjangan
- Modal untuk reject dengan input alasan penolakan
- AJAX handling untuk proses approval/rejection

### 5. Routes
**File:** `routes/web.php`

Route baru untuk petugas:
```php
Route::get('/extensions', [ExtensionController::class, 'index'])->name('petugas.extensions');
Route::post('/extensions/{id}/approve', [ExtensionController::class, 'approve'])->name('petugas.extensions.approve');
Route::post('/extensions/{id}/reject', [ExtensionController::class, 'reject'])->name('petugas.extensions.reject');
Route::get('/extensions/{id}', [ExtensionController::class, 'show'])->name('petugas.extensions.show');
```

## Workflow Sistem Baru

### Untuk Anggota:
1. Anggota melihat daftar buku yang dipinjam di halaman "Pinjaman Saya"
2. Untuk buku yang masih bisa diperpanjang, anggota click tombol "Perpanjang"
3. Modal terbuka untuk input alasan perpanjangan (opsional)
4. Anggota submit permintaan
5. Status berubah menjadi "Menunggu persetujuan"
6. Anggota menunggu proses dari petugas

### Untuk Petugas:
1. Petugas masuk ke halaman "Kelola Perpanjangan"
2. Melihat daftar permintaan yang pending di tab "Menunggu Persetujuan"
3. Untuk menyetujui:
   - Click tombol "Setujui"
   - Pilih jumlah hari perpanjangan (3, 5, 7, 10, 14 hari)
   - Konfirmasi
4. Untuk menolak:
   - Click tombol "Tolak"
   - Input alasan penolakan (wajib)
   - Konfirmasi
5. Permintaan akan pindah ke tab "Disetujui" atau "Ditolak"

## Status Extension dalam Database

- `none`: Belum ada permintaan perpanjangan
- `requested`: Permintaan telah dikirim, menunggu petugas
- `approved`: Permintaan disetujui, buku sudah diperpanjang
- `rejected`: Permintaan ditolak

## Validasi Sistem

Anggota hanya bisa request perpanjangan jika:
- Status pinjaman = 'dipinjam'
- Status extension = 'none' 
- Buku belum terlambat

## UI/UX Improvements

- Anggota mendapat feedback visual yang jelas tentang status permintaan
- Petugas memiliki dashboard lengkap untuk mengelola semua permintaan
- Modal interface untuk interaksi yang smooth
- AJAX implementation untuk experience yang responsive
- Statistics untuk monitoring performa sistem

## Keamanan

- Semua route dilindungi middleware authentication dan role-based access
- CSRF protection pada semua form submission
- Validasi input pada server side
- Foreign key constraints untuk data integrity

Sistem ini memberikan kontrol penuh kepada petugas untuk mengelola perpanjangan buku, sambil tetap memberikan kemudahan bagi anggota untuk mengajukan permintaan perpanjangan.
