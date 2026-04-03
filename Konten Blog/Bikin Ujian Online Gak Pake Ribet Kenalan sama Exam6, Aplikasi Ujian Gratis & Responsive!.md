Halo! Wah, keren banget ini aplikasinya. Sebagai sesama penggiat IT di sekolah, saya tahu banget rasanya butuh *tool* yang praktis, ringan, dan nggak bikin pusing tapi tetep kelihatan profesional.

Berikut adalah draf postingan blog untuk **Ruang Nate** yang didesain menarik, informatif, dan punya gaya bahasa santai supaya rekan-rekan guru atau admin sekolah lainnya tertarik buat coba.

------

## Bikin Ujian Online Gak Pake Ribet? Kenalan sama Exam6, Aplikasi Ujian Gratis & Responsive!

Zaman sekarang masih ribet koreksi hasil ujian satu-satu? Atau pusing cari platform ujian online yang beneran gratis tapi fiturnya lengkap? Tenang, ada kabar gembira buat rekan-rekan pengajar dan admin IT sekolah!

Hari ini saya mau berbagi sebuah *project* yang baru saja dirapikan: **Exam6**. Ini adalah sistem manajemen ujian berbasis web yang saya bangun supaya kita bisa kelola ujian dengan lebih santai, tapi hasilnya tetap maksimal.

### Kenapa Harus Exam6?

Banyak aplikasi ujian di luar sana, tapi **Exam6** punya "vibe" yang beda:

- **Beneran Gratis & Open Source**: Gak ada biaya langganan, tinggal *deploy* dan pakai.
- **Tampilan Modern & Responsive**: Mau dibuka di laptop, tablet, atau HP siswa pas lagi di kelas? Tetap rapi karena pakai Bootstrap 5.
- **Anti-Panik (Auto-Save)**: Kalau tiba-tiba koneksi putus atau browser ketutup, jawaban siswa aman karena tersimpan otomatis berkala.
- **Fitur Anti-Nyontek**: Ada fitur acak urutan soal dan acak opsi jawaban. Jadi, siswa sebelah-sebelahan gak bisa lirik-lirikan jawaban.
- **Input Soal Gak Pake Lama**: Malas ketik satu-satu? Tinggal *import* dari file DOCX pakai template yang sudah disediakan.

------

### Intip Fitur Unggulannya

| **Fitur**                | **Manfaat untuk Guru/Admin**                                 |
| ------------------------ | ------------------------------------------------------------ |
| **Bank Soal**            | Bisa pakai gambar di soal maupun di opsi jawaban.            |
| **Timer Real-time**      | Ada indikator warna (kuning/merah) kalau waktu mau habis.    |
| **Rekap Nilai Otomatis** | Langsung jadi tabel, lengkap dengan skor tertinggi, terendah, dan rata-rata. |
| **Ekspor Excel**         | Butuh buat laporan nilai? Tinggal sekali klik langsung jadi file Excel. |
| **Custom Tampilan**      | Bisa ganti logo sekolah dan warna tema sesuai identitas sekolah masing-masing. |

------

### Cara Pasangnya (Gampang Banget!)

Buat teman-teman yang sudah biasa pegang server (XAMPP/Hosting), tinggal ikuti langkah singkat ini:

1. **Persiapan**: Pastikan server kamu pakai PHP versi 7.4 ke atas.
2. **Database**: Buat database baru (misal: `ujian_online`) dan import file SQL yang ada di folder aplikasi.
3. **Config**: Atur koneksi database di file `config/database.php`.
4. **Login Admin**: Langsung meluncur ke `exam6/admin/login.php` dengan user: `admin` dan pass: `admin123`. (Jangan lupa langsung diganti ya!).

------

### Panduan untuk Siswa

Siswa cuma perlu akses link ujian, isi NIS, Nama, dan Kelas, langsung bisa tempur! Tampilannya intuitif dengan indikator progres di bagian bawah, jadi mereka tahu berapa soal lagi yang belum dikerjakan.

### Download Sekarang

Gak perlu lama-lama, silakan cek *source code*-nya langsung di GitHub saya. Feel free buat *clone*, modifikasi, atau kasih bintang (star) kalau bermanfaat!

> **[Download Exam6 di GitHub](https://github.com/natedekaka/my-php-app/tree/84ca498db041f54bd040aa46de6b96af34e9c22e/src/exam6)**

------

**Catatan Akhir:**

Aplikasi ini dibuat untuk memudahkan kita semua. Jangan lupa buat *backup* database secara berkala dan gunakan HTTPS kalau mau dipakai di skala luas biar lebih aman.

Selamat mencoba, semoga **Exam6** bisa membantu meringankan beban administrasi ujian di sekolah kalian! Ada pertanyaan? Tulis di kolom komentar ya!