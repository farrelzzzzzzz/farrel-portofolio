# Panduan Deployment & Penggunaan Website UMKM Kampung (100% Gratis)

Sistem website profil UMKM dan panel admin ini sudah terintegrasi penuh di dalam project Laravel Anda. Anda bisa langsung mencobanya di komputer lokal maupun mendeploynya ke server cloud gratis selamanya.

---

## 🚀 1. Cara Menjalankan di Localhost (Komputer Anda)

1. Pastikan server Laravel sedang berjalan:
   ```bash
   php artisan serve
   ```
2. Buka browser dan akses halaman berikut:
   - **Website Utama (Katalog & Pemesanan WA):** [`http://127.0.0.1:8000/umkm`](http://127.0.0.1:8000/umkm)
   - **Panel Admin (Dashboard & CRUD):** [`http://127.0.0.1:8000/umkm/admin`](http://127.0.0.1:8000/umkm/admin)

---

## 🌐 2. Cara Hosting 100% Gratis (Database & Hosting)

Untuk membuat sistem ini online selamanya tanpa biaya bulanan bagi UMKM kampung, gunakan kombinasi layanan gratis berikut:

### Langkah A: Buat Database Cloud Gratis (Supabase / Neon.tech)
1. Buat akun gratis di [Supabase.com](https://supabase.com) atau [Neon.tech](https://neon.tech).
2. Buat Project baru (misal: `umkm-kampung`).
3. Dapatkan **Database Connection URL** (PostgreSQL/MySQL URL).

### Langkah B: Upload Project ke GitHub
1. Buat repository baru di GitHub Anda (misal: `umkm-kampung`).
2. Push source code project ini ke GitHub Anda.

### Langkah C: Deploy Gratis di Render.com / Railway
1. Buat akun gratis di [Render.com](https://render.com).
2. Klik **New +** -> **Web Service**, lalu hubungkan repository GitHub project Anda.
3. Atur konfigurasi build:
   - **Build Command:** `composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache && php artisan view:cache`
   - **Start Command:** `php artisan serve --host=0.0.0.0 --port=$PORT`
4. Di bagian **Environment Variables**, masukkan konfigurasi `.env` Anda (termasuk URL database gratis dari Supabase/Neon).
5. Klik **Deploy Web Service**. Website UMKM Anda langsung online dengan domain publik gratis (`namaproject.onrender.com`)!

---

## 🛠️ Fitur yang Tersedia:
- **Katalog Produk Interaktif:** Pencarian produk, filter kategori, dan tombol langsung terhubung ke **WhatsApp Penjual** dengan format pesanan otomatis.
- **Panel Admin Lengkap:**
  - **Dashboard:** Ringkasan total produk, pesanan, dan omset.
  - **CRUD Produk:** Tambah, hapus, atur harga, stok, dan produk unggulan.
  - **Manajemen Kategori:** Kelola kategori produk dengan mudah.
  - **Daftar Pesanan:** Pantau pesanan masuk dan ubah status (Pending, Diproses, Selesai, Dibatalkan).
  - **Pengaturan Toko:** Ubah nama UMKM, slogan, alamat, dan nomor WhatsApp resmi langsung dari panel admin tanpa ngoding.
