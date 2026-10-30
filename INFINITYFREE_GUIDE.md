# 🚀 Panduan Upload Laravel ke InfinityFree (cPanel Gratis)

InfinityFree adalah salah satu hosting PHP/MySQL gratis sepanjang masa yang sudah lama beroperasi dan **tidak pernah meminta kartu kredit**. 

Karena Laravel secara default mengarah ke folder `public/`, struktur project Anda sudah saya sesuaikan agar langsung kompatibel dengan InfinityFree!

---

### Langkah 1: Siapkan Akun di InfinityFree
1. Buka [InfinityFree.com](https://infinityfree.com/) dan buat akun gratis.
2. Buat akun hosting baru (*Create Hosting Account*), pilih domain gratis yang mereka sediakan (contoh: `farrelportofolio.epizy.com` atau `rf.gd`).
3. Masuk ke **Control Panel (cPanel)** hosting Anda.

### Langkah 2: Buat Database MySQL di InfinityFree
1. Di cPanel, cari menu **MySQL Databases**.
2. Buat database baru (catat nama database, username, password, dan MySQL Hostname yang diberikan oleh InfinityFree).
3. Buka **phpMyAdmin** di cPanel, lalu import database SQL portfolio Anda (jika ada) atau biarkan kosong agar migrasi via script / seeder.

### Langkah 3: Upload File Project Anda
1. Di cPanel, buka **Online File Manager** (atau gunakan aplikasi FTP seperti FileZilla menggunakan detail FTP dari cPanel).
2. Masuk ke dalam folder **`htdocs`** (biasanya path-nya `htdocs/domainanda.com/`).
3. **PENTING:** Hapus file bawaan `index.php` atau `index.html` bawaan dari InfinityFree di dalam folder `htdocs`.
4. Upload **seluruh isi folder project Laravel Anda (`F:\portofolio`)** ke dalam folder `htdocs` tersebut.
   * *Catatan:* Anda bisa men-zip (`.zip`) folder project di komputer lalu meng-upload-nya ke `htdocs` dan klik **Extract**, jauh lebih cepat daripada upload satu-satu.

### Langkah 4: Sesuaikan File `.env` di Hosting
1. Di File Manager cPanel, cari atau buat file `.env` (salin dari `.env.example`).
2. Sesuaikan konfigurasi database dengan data dari InfinityFree:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=http://domainanda.epizy.com

   DB_CONNECTION=mysql
   DB_HOST=sqlXXXX.infinityfree.com (sesuaikan dari cPanel)
   DB_DATABASE=if0_3xxxxxxx_portofoliodb (sesuaikan dari cPanel)
   DB_USERNAME=if0_3xxxxxxx (sesuaikan dari cPanel)
   DB_PASSWORD=password_database_anda (sesuaikan dari cPanel)
   ```
3. Simpan (`Save`).

### Selesai!
Buka domain gratis Anda di browser. Website portfolio Laravel Anda akan langsung aktif, lengkap dengan database dan fitur dinamisnya secara gratis selamanya tanpa kartu kredit!
