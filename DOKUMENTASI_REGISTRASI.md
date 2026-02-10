# 📋 DOKUMENTASI - Sistem Registrasi & Geofencing JajanYuk

## 🎯 Ringkasan Implementasi

Sistem registrasi JajanYuk telah diimplementasikan dengan fitur lengkap untuk **Pembeli** (gratis) dan **Pedagang** (dengan verifikasi admin dan geofencing).

---

## 📊 Alur Singkat

### 1️⃣ **Alur Pendaftaran Pembeli**
```
User → Klik "Daftar Pembeli" 
     → Isi form (Nama, Email, Password)
     → Otomatis teraktifkan
     → Bisa langsung akses Dashboard
```

### 2️⃣ **Alur Pendaftaran Pedagang**
```
User → Klik "Daftar Pedagang"
     → Step 1: Isi akun (Nama, Email, Password) → Login otomatis
     → Step 2: Isi profil (Nama Toko, Lokasi via Map, Upload Foto Gerobak & Bukti Bayar)
     → Validation: Geofencing (20 KM dari pusat Tasikmalaya)
     → Status: Payment_status = pending, Admin_status = pending, is_active = false
     → Halaman "Menunggu Verifikasi"
```

### 3️⃣ **Alur Verifikasi Admin**
```
Admin → Akses /admin/verifikasi-pedagang
      → Lihat daftar "Menunggu Verifikasi"
      → Cek: Foto Gerobak, Bukti Pembayaran, Lokasi
      → Setujui (Approve) → Payment_status = paid, Admin_status = approved, is_active = true
      → Atau Tolak (Reject) → Admin_status = rejected
      → Pedagang otomatis muncul di peta setelah approved
```

---

## 🗂️ File & Struktur yang Dibuat/Diubah

### **Controllers**
| File | Fungsi |
|------|--------|
| `app/Http/Controllers/Auth/RegisteredUserController.php` | Update: Registrasi pembeli hanya |
| `app/Http/Controllers/Auth/RegisterPedagangController.php` | **Baru**: Registrasi pedagang 2 step |
| `app/Http/Controllers/AdminVerifikasiPedagangController.php` | **Baru**: Verifikasi pedagang oleh admin |

### **Views**
| File | Fungsi |
|------|--------|
| `resources/views/auth/choose-role.blade.php` | **Baru**: Halaman pilih daftar pembeli atau pedagang |
| `resources/views/auth/register.blade.php` | Update: Form registrasi pembeli saja |
| `resources/views/auth/register-pedagang.blade.php` | **Baru**: Form registrasi pedagang step 1 |
| `resources/views/auth/register-pedagang-profile.blade.php` | **Baru**: Form profil + geofencing map (step 2) |
| `resources/views/auth/register-pedagang-waiting.blade.php` | **Baru**: Halaman menunggu verifikasi |
| `resources/views/admin/verifikasi-pedagang.blade.php` | **Baru**: Dashboard admin verifikasi |
| `resources/views/admin/verifikasi-detail.blade.php` | **Baru**: Detail pedagang untuk verifikasi |

### **Services**
| File | Fungsi |
|------|--------|
| `app/Services/GeofencingService.php` | **Baru**: Service untuk validasi radius geofencing |

### **Models**
| File | Perubahan |
|------|-----------|
| `app/Models/User.php` | Update: Tambah relasi `pedagang()` |
| `app/Models/Pedagang.php` | Update: Tambah fillable untuk kolom baru |

### **Routes**
| File | Perubahan |
|------|-----------|
| `routes/auth.php` | Update: Tambah routes untuk registrasi pedagang & pembeli |
| `routes/web.php` | Update: Tambah routes admin verifikasi |

### **Database**
| File | Perubahan |
|------|-----------|
| `database/migrations/2026_02_04_175343_create_pedagangs_table.php` | Update: Tambah kolom `payment_status`, `admin_status`, `bukti_pembayaran` |
| `database/migrations/2026_02_10_130509_update_jajanyuk_tables.php` | Update: Hapus duplikasi kolom (sudah di migration pedagang) |

---

## 🔧 Fitur Teknologi

### **1. Geofencing dengan Leaflet Map**
- **Lokasi Pusat**: Tasikmalaya (-7.3581, 108.2186)
- **Radius**: 20 KM
- **Formula**: Haversine (menghitung jarak akurat antar koordinat)
- **Fitur**:
  - Peta interaktif dengan drag-drop marker
  - Validation real-time saat user mengklik/drag
  - Circle radius visualization
  - Koordinat real-time update

### **2. Upload File dengan Validasi**
- File Type: JPEG, PNG, JPG
- Max Size: 2 MB
- Storage Path: `/storage/pedagang/gerobak/` dan `/storage/pedagang/bukti/`
- Preview image sebelum submit

### **3. Status Management**
| Status | Deskripsi |
|--------|-----------|
| `payment_status` | `pending` → belum dibayar, `paid` → sudah dibayar |
| `admin_status` | `pending` → menunggu, `approved` → disetujui, `rejected` → ditolak |
| `is_active` | `false` → tidak muncul di map, `true` → muncul di map |

### **4. Middleware & Authorization**
- Registrasi pedagang: Hanya yang sudah login bisa akses step 2
- Admin verifikasi: Check role = 'admin' di middleware
- Pendaftaran pembeli: Free, langsung diterima

---

## 📱 User Flow Mobile/Web

### **Pembeli**
```
[Halaman Pilih] → [Daftar Pembeli] → [Form Biodata] → [Dashboard] → [Lihat Pedagang di Map]
```

### **Pedagang**
```
        ┌─ [Form Akun]
[Pilih] │  └─↓ Login
        │  [Form Profil + Map] → [Geofencing Validation]
        │  ↓ (Valid) → [Upload Foto & Bukti]
        │  ↓ → [Menunggu Verifikasi] 
        │
Admin   → [Dashboard Verifikasi]
         → [Cek Foto & Bukti]
         → Approve → is_active = true → [Muncul di Map]
            atau
         → Reject → Kembali kirim dokumen
```

---

## 🛠️ Cara Menggunakan

### **1. Test Registrasi Pembeli**
```
http://localhost:8000/register
→ Klik "Daftar Pembeli" 
→ Isi form
→ Submit
→ Langsung masuk ke dashboard
```

### **2. Test Registrasi Pedagang**
```
http://localhost:8000/register
→ Klik "Daftar Pedagang"
→ Step 1: Isi form akun → Submit & Login
→ Redirect ke Step 2: Isi profil
→ Klik peta untuk tentukan lokasi
→ Check: Lokasi harus dalam radius 20 KM
→ Upload foto gerobak & bukti pembayaran
→ Submit
→ Halaman "Menunggu Verifikasi"
```

### **3. Test Admin Verifikasi**
```
http://localhost:8000/admin/verifikasi-pedagang
→ Tab "Menunggu Verifikasi" (lihat daftar pedagang)
→ Klik "Lihat Detail" untuk review
→ Cek foto + bukti pembayaran
→ Klik "Setujui Pendaftaran" → Status berubah jadi approved
→ Pedagang bisa mulai berjualan
```

---

## 🔐 Security & Validasi

### **Backend Validation**
- ✅ Email unique check
- ✅ Password minimum 8 char
- ✅ Geofencing distance calculation (Haversine)
- ✅ File size & type validation
- ✅ Admin role check dengan middleware

### **Frontend Validation**
- ✅ Real-time geofencing feedback
- ✅ Image preview sebelum upload
- ✅ Form validation dengan Blade components
- ✅ Confirmation dialog untuk action penting

---

## 📍 Konstanta Geofencing

Edit di: `app/Services/GeofencingService.php`

```php
const TASIKMALAYA_LAT = -7.3581;      // Latitude pusat
const TASIKMALAYA_LNG = 108.2186;     // Longitude pusat
const RADIUS_KM = 20;                 // Radius dalam KM
```

---

## 🗄️ Database Schema (Pedagang)

```sql
CREATE TABLE pedagangs (
  id BIGINT PRIMARY KEY,
  user_id BIGINT FOREIGN KEY,
  nama_toko VARCHAR(255),
  jenis_jajanan VARCHAR(255) NULLABLE,
  latitude DECIMAL(10,8) NULLABLE,
  longitude DECIMAL(11,8) NULLABLE,
  foto_gerobak VARCHAR(255) NULLABLE,
  
  -- Kolom Baru
  payment_status ENUM('pending', 'paid') DEFAULT 'pending',
  admin_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  bukti_pembayaran VARCHAR(255) NULLABLE,
  
  -- Aktifasi
  is_active BOOLEAN DEFAULT FALSE,
  last_heartbeat TIMESTAMP NULLABLE,
  
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

---

## 🐛 Troubleshooting

### **Error: "Lokasi Tidak Valid"**
- ✓ Pastikan klik di dalam circle hijau (radius 20 KM)
- ✓ Cek koneksi internet untuk load map
- ✓ Refresh halaman jika map tidak load

### **Error: "File terlalu besar"**
- ✓ Max 2 MB, compress foto dulu
- ✓ Gunakan format JPEG/PNG

### **Admin tidak bisa akses verifikasi**
- ✓ User harus memiliki `role = 'admin'` di DB
- ✓ Edit users tabel: `UPDATE users SET role = 'admin' WHERE id = 1;`

### **Map tidak muncul**
- ✓ Check CDN Leaflet: `https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/`
- ✓ Check browser console untuk error

---

## 📈 Maintenance & Monitoring

### **Check Pedagang yang Pending**
```sql
SELECT id, nama_toko, payment_status, admin_status, is_active 
FROM pedagangs 
WHERE admin_status = 'pending' 
ORDER BY created_at DESC;
```

### **Check Pedagang yang Aktif**
```sql
SELECT id, nama_toko, is_active 
FROM pedagangs 
WHERE is_active = true;
```

### **Reindex Status untuk Pedagang Tertentu**
```php
// Di tinker atau controller
$pedagang = Pedagang::find(1);
$pedagang->update([
    'payment_status' => 'paid',
    'admin_status' => 'approved',
    'is_active' => true
]);
```

---

## 🔄 Next Steps (Opsional)

1. **Email Notification**: Kirim email saat pedagogditerima/ditolak
2. **SMS Notification**: Integrase Twilio untuk notif SMS
3. **Payment Gateway**: Integrate Midtrans/Stripe untuk pembayaran online
4. **Location History**: Track pedagang realtime dengan `last_heartbeat`
5. **Geofencing Filter**: Dashboard pembeli auto-filter based on GPS location

---

## 📞 Support

Jika ada pertanyaan atau bug, cek:
- ✅ Laravel logs: `storage/logs/laravel.log`
- ✅ Browser console untuk error JS (F12)
- ✅ Database untuk data validation

---

**Created**: 10 Feb 2026  
**Version**: 1.0  
**Status**: ✅ Fully Implemented
