# Contoh Penggunaan Form Peminjaman Buku

## 📋 Cara Menggunakan Form Peminjaman

### 1. **Mengisi ID User**
```
Langkah:
1. Masukkan ID User (contoh: 1, 2, 3, dst)
2. Klik di luar field atau tekan Tab
3. Nama user akan muncul otomatis

Contoh:
- Input: 1 → Output: "John Doe"
- Input: 2 → Output: "Jane Smith" 
- Input: 999 → Error: "User dengan ID tersebut tidak ditemukan"
```

### 2. **Mengisi ID Buku**
```
Langkah:
1. Masukkan ID Buku (contoh: 1, 2, 3, dst)
2. Klik di luar field atau tekan Tab
3. Judul buku akan muncul otomatis

Contoh:
- Input: 1 → Output: "Pemrograman PHP untuk Pemula"
- Input: 2 → Output: "Database MySQL Advanced"
- Input: 999 → Error: "Buku dengan ID tersebut tidak ditemukan"
```

### 3. **Field Otomatis Terisi**
- **Tanggal Pinjam**: Otomatis hari ini (2025-10-07)
- **Status**: Otomatis "Dipinjam"
- **Denda**: Otomatis 0.00

### 4. **Mengatur Batas Kembali**
```
- Minimal: Besok (2025-10-08)
- Default: 7 hari dari sekarang (2025-10-14)
- Bisa diubah sesuai kebutuhan
```

## 💡 Contoh Skenario Lengkap

### **Skenario 1: Peminjaman Berhasil**
```
1. ID User: 1
   → Muncul: "Ahmad Rizki" ✅

2. ID Buku: 5  
   → Muncul: "Belajar Laravel 10" ✅

3. Batas Kembali: 2025-10-20 ✅

4. Keterangan: "Untuk tugas kuliah"

5. Klik "Proses Peminjaman"
   → Berhasil! Data tersimpan ✅
```

### **Skenario 2: User Tidak Ditemukan**
```
1. ID User: 999
   → Error: "User dengan ID tersebut tidak ditemukan atau tidak aktif" ❌

2. Solusi: Gunakan ID user yang valid (1, 2, 3, dst)
```

### **Skenario 3: Buku Tidak Tersedia**
```
1. ID User: 1 ✅
2. ID Buku: 10
   → Error: "Buku tidak tersedia untuk dipinjam" ❌

3. Solusi: Pilih buku lain yang tersedia
```

### **Skenario 4: User Sudah Pinjam 3 Buku**
```
1. ID User: 2 ✅
2. ID Buku: 3 ✅
3. Submit → Error: "Anggota telah mencapai batas maksimal peminjaman (3 buku)" ❌

4. Solusi: User harus mengembalikan buku dulu
```

## 🔍 Validasi Form

### **Validasi Client-Side (JavaScript)**
1. ID User harus diisi
2. ID Buku harus diisi  
3. Batas kembali harus diisi
4. Tanggal kembali tidak boleh kemarin/hari ini

### **Validasi Server-Side (PHP)**
1. User harus ada di database
2. User harus role 'anggota' dan status 'aktif'
3. Buku harus ada di database
4. Buku harus tersedia (jumlah_tersedia > 0)
5. User belum mencapai batas maksimal (3 buku)
6. User tidak punya buku yang terlambat

## 📊 Response Format

### **Sukses**
```json
{
    "success": true,
    "message": "Peminjaman berhasil diproses",
    "data": {
        "id_peminjaman": 1,
        "borrowing_id": "PJM000001",
        "user_name": "Ahmad Rizki",
        "book_title": "Belajar Laravel 10",
        "tanggal_pinjam": "07/10/2025",
        "batas_kembali": "20/10/2025",
        "status": "Dipinjam"
    }
}
```

### **Error**
```json
{
    "success": false,
    "message": "User dengan ID tersebut tidak ditemukan atau tidak aktif"
}
```

## 🎯 Tips Penggunaan

1. **Untuk Testing**: Gunakan ID 1-10 untuk user dan buku
2. **Reset Form**: Klik tombol "Reset" untuk mengosongkan form
3. **Auto Refresh**: Tabel peminjaman hari ini update otomatis setiap 30 detik
4. **Keyboard**: Gunakan Tab untuk navigasi antar field
5. **Mobile Friendly**: Form responsive untuk berbagai ukuran layar

## 🛠️ Troubleshooting

### **Problem: Nama user tidak muncul**
- **Cause**: ID user tidak valid atau user tidak aktif
- **Solution**: Cek ID user di database, pastikan role='anggota' dan status='aktif'

### **Problem: Judul buku tidak muncul**  
- **Cause**: ID buku tidak valid atau buku tidak tersedia
- **Solution**: Cek ID buku di database, pastikan jumlah_tersedia > 0

### **Problem: Submit gagal**
- **Cause**: Validasi server-side gagal
- **Solution**: Cek console browser untuk error detail

### **Problem: Form tidak responsive**
- **Cause**: JavaScript error atau koneksi internet
- **Solution**: Refresh halaman atau cek console browser
