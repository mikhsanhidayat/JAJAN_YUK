# 🚀 IMPLEMENTASI REGISTRASI & GEOFENCING - QUICK START

## ✅ Apa yang Sudah Dibuat

### **1. Pembeli (Gratis)**
- ✅ Halaman pilih role `/register`
- ✅ Form registrasi pembeli `/register/pembeli`
- ✅ Format: Nama, Email, Password
- ✅ Langsung aktif setelah submit
- ✅ Role: `pembeli`

### **2. Pedagang (Verifikasi)**
- ✅ Step 1: Form akun `/register-pedagang` → login otomatis
- ✅ Step 2: Form profil + geofencing map `/register-pedagang/profile`
- ✅ Geofencing: 20 KM radius Tasikmalaya dengan Haversine formula
- ✅ Upload: Foto gerobak + bukti pembayaran
- ✅ Status: `payment_status = pending`, `admin_status = pending`, `is_active = false`
- ✅ Halaman tunggu: `/register-pedagang/waiting`
- ✅ Role: `pedagang`

### **3. Admin Verifikasi**
- ✅ Dashboard admin: `/admin/verifikasi-pedagang`
- ✅ List pedagang pending dengan foto preview
- ✅ Tombol: Approve / Reject
- ✅ Approve → `payment_status = paid`, `admin_status = approved`, `is_active = true`
- ✅ Reject dengan alasan
- ✅ Pedagang otomatis aktif & muncul di map setelah approve
- ✅ Authorization: Hanya role `admin`

---

## 🗂️ Files yang Dibuat/Diubah

### **Controllers (3 files)**
```
✅ app/Http/Controllers/Auth/RegisteredUserController.php (UPDATE)
✅ app/Http/Controllers/Auth/RegisterPedagangController.php (BARU)
✅ app/Http/Controllers/AdminVerifikasiPedagangController.php (BARU)
```

### **Views (7 files)**
```
✅ resources/views/auth/choose-role.blade.php (BARU)
✅ resources/views/auth/register.blade.php (UPDATE)
✅ resources/views/auth/register-pedagang.blade.php (BARU)
✅ resources/views/auth/register-pedagang-profile.blade.php (BARU - dengan Leaflet map)
✅ resources/views/auth/register-pedagang-waiting.blade.php (BARU)
✅ resources/views/admin/verifikasi-pedagang.blade.php (BARU)
✅ resources/views/admin/verifikasi-detail.blade.php (BARU)
```

### **Services (1 file)**
```
✅ app/Services/GeofencingService.php (BARU)
   - calculateDistance() - Haversine formula
   - validateLocation() - Check radius
```

### **Models (2 files)**
```
✅ app/Models/User.php (UPDATE - tambah relasi pedagang)
✅ app/Models/Pedagang.php (UPDATE - tambah fillable)
```

### **Routes (2 files)**
```
✅ routes/auth.php (UPDATE)
   - GET /register → choose role
   - GET/POST /register/pembeli → pembeli registration
   - GET/POST /register-pedagang → pedagang registration
   - GET/POST /register-pedagang/profile → pedagang profile
   - GET /register-pedagang/waiting → waiting page

✅ routes/web.php (UPDATE)
   - GET/POST /admin/verifikasi-pedagang/* → admin verification
```

### **Database (2 files)**
```
✅ database/migrations/2026_02_04_175343_create_pedagangs_table.php (UPDATE)
   Kolom baru:
   - payment_status ENUM('pending', 'paid')
   - admin_status ENUM('pending', 'approved', 'rejected')
   - bukti_pembayaran VARCHAR
   
✅ database/migrations/2026_02_10_130509_update_jajanyuk_tables.php (UPDATE)
   - Hapus duplikasi kolom
```

---

## 🔗 Routes Reference

### **Public Routes (Guest)**
```
GET  /register                           → Halaman pilih role
GET  /register/pembeli                   → Form pembeli
POST /register/pembeli                   → Submit pembeli
GET  /register-pedagang                  → Form pedagang step 1
POST /register-pedagang                  → Submit pedagang step 1 + LOGIN
```

### **Protected Routes (Auth + Pedagang)**
```
GET  /register-pedagang/profile          → Form pedagang step 2
POST /register-pedagang/profile          → Submit profil + geofencing
GET  /register-pedagang/waiting          → Status menunggu verifikasi
```

### **Admin Routes (Auth + Admin)**
```
GET    /admin/verifikasi-pedagang        → List pending pedagang
GET    /admin/verifikasi-pedagang/{id}   → Detail pedagang
POST   /admin/verifikasi-pedagang/{id}/approve     → Setujui
POST   /admin/verifikasi-pedagang/{id}/reject      → Tolak
POST   /admin/verifikasi-pedagang/{id}/deactivate → Nonaktifkan
POST   /admin/verifikasi-pedagang/{id}/reactivate → Aktifkan
```

---

## 🎯 Testing Checklist

### **Test Pembeli**
- [ ] Buka `/register` → klik "Daftar Pembeli"
- [ ] Isi form, submit
- [ ] Redirect ke dashboard
- [ ] Lihat di DB: role = 'pembeli'

### **Test Pedagang**
- [ ] Buka `/register` → klik "Daftar Pedagang"
- [ ] Step 1: Isi form, submit → auto login
- [ ] Redirect ke `/register-pedagang/profile`
- [ ] Isi nama toko, buka map
- [ ] Klik peta di area Tasikmalaya → status = "Lokasi Valid"
- [ ] Upload foto gerobak dan bukti bayar
- [ ] Submit → redirect ke halaman "Menunggu Verifikasi"
- [ ] Lihat di DB: `is_active = false`, `admin_status = pending`, `payment_status = pending`

### **Test Admin (Verify)**
- [ ] Akses `/admin/verifikasi-pedagang`
- [ ] Lihat list pedagang pending
- [ ] Klik "Lihat Detail" → lihat foto + bukti
- [ ] Klik "Setujui Pendaftaran"
- [ ] Cek DB: `is_active = true`, `admin_status = approved`, `payment_status = paid`
- [ ] Pedagang harus muncul di map

### **Test Geofencing**
- [ ] Di step 2, klik peta jauh dari Tasikmalaya
- [ ] Harus ada error: "Lokasi di luar jangkauan"
- [ ] Drag marker ke dalam area radius → valid
- [ ] Submit button aktif hanya saat lokasi valid

---

## 🔑 Key Features Implemented

### **Geofencing**
- ✅ Leaflet Map dengan radius circle
- ✅ Haversine formula untuk akurat
- ✅ Real-time validation saat klik/drag
- ✅ Koordinat auto-filled

### **File Upload**
- ✅ Image preview sebelum submit
- ✅ Validation: type, size (max 2MB)
- ✅ Storage: `/storage/pedagang/gerobak/` dan `/bukti/`

### **Status Management**
- ✅ Payment status: pending/paid
- ✅ Admin status: pending/approved/rejected
- ✅ is_active: otomatis true saat approved

### **Authorization**
- ✅ Admin middleware check
- ✅ Auth check untuk step 2 profil
- ✅ Guest check untuk register

---

## 📊 Database Schema

```sql
-- Kolom baru di tabel pedagangs:
ALTER TABLE pedagangs ADD (
    payment_status ENUM('pending', 'paid') DEFAULT 'pending',
    admin_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    bukti_pembayaran VARCHAR(255) NULLABLE
);
```

---

## 🐛 Common Issues & Fix

| Issue | Solusi |
|-------|--------|
| Map tidak muncul | Cek CDN Leaflet aktif, refresh halaman |
| Geofencing selalu error | Pastikan klik di dalam circle hijau, jangan di luar |
| File upload error | Max 2MB, gunakan format JPEG/PNG |
| Admin tidak bisa akses | Set role = 'admin' di table users |
| Pengangkat/Pedagang tidak muncul di map | Ensure `is_active = true` dan `admin_status = approved` |

---

## 📝 Geofencing Config

Edit di `app/Services/GeofencingService.php`:

```php
const TASIKMALAYA_LAT = -7.3581;      // Latitude
const TASIKMALAYA_LNG = 108.2186;     // Longitude
const RADIUS_KM = 20;                 // Bisa ubah sesuai kebutuhan
```

---

## 🎓 Alur Singkat (Dalam Bahasa)

### **Pembeli: "Saya mau cari jajanan"**
```
Daftar (Nama, Email, Password)
→ Login otomatis
→ Lihat pedagang di map
→ Pesan jajanan
```

### **Pedagang: "Saya mau jualan"**
```
Daftar Akun (Nama, Email, Password)
→ Login otomatis
→ Isi Profil (Nama Toko, Lokasi via Map, Upload Foto)
→ Cek Lokasi (harus Tasikmalaya)
→ Upload Bukti Bayar
→ Tunggu Admin Verifikasi
→ Kalau approved, Teknologi ke map otomatis
→ Mulai menerima order dari pembeli
```

### **Admin: "Saya verifikasi pedagang"**
```
Buka Dashboard Verifikasi
→ Lihat pedagang baru yang daftar
→ Cek foto gerobak & bukti bayar
→ Kalau ok, klik "Setujui"
→ Pedagang otomatis aktif di map
```

---

## 🔗 Dokumentasi Lengkap

Lihat: **DOKUMENTASI_REGISTRASI.md**

---

**Status**: ✅ READY TO USE  
**Last Updated**: 10 Feb 2026  
**Version**: 1.0
