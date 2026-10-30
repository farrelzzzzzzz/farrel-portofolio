# 🚀 Panduan Hosting Gratis 100% di Vercel (Tanpa Kartu Kredit)

Karena Vercel mendukung *PHP Runtime* untuk Laravel, website portfolio 3D Anda bisa di-deploy secara utuh (termasuk fitur-fiturnya) ke Vercel secara **gratis sepanjang masa tanpa kartu kredit**.

---

### Langkah-Langkah Upload ke Vercel:

1. **Pastikan Project Ter-push ke GitHub:**
   Pastikan kode terbaru sudah masuk ke repository GitHub Anda.
   ```bash
   git add .
   git commit -m "Add Vercel configuration"
   git push origin main
   ```

2. **Daftar & Hubungkan ke Vercel:**
   * Buka [Vercel.com](https://vercel.com/)
   * Klik **Sign Up** dan login menggunakan akun **GitHub** Anda (100% gratis, **tidak ada** permintaan kartu kredit).

3. **Import Project:**
   * Di dashboard Vercel, klik **Add New...** -> **Project**.
   * Pilih repository GitHub portfolio Anda, lalu klik **Import**.

4. **Konfigurasi Environment Variables (Opsional jika pakai Database):**
   * Di bagian **Environment Variables**, Anda bisa memasukkan konfigurasi database jika menghubungkannya ke database eksternal (seperti Supabase atau Neon). Jika belum, biarkan default dulu.
   * Klik **Deploy**.

5. **Selesai!**
   Vercel akan membangun aplikasi Anda dalam hitungan detik, dan Anda akan langsung mendapatkan URL gratis (contoh: `portofolio-farrel.vercel.app`) yang aktif selamanya!
