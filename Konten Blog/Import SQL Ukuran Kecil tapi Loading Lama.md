Wah, selamat! Senang sekali mendengarnya. Memang benar, ketika data sudah mencapai puluhan ribu baris, menggunakan Terminal (CLI) terasa seperti pindah dari mobil macet ke pesawat terbang.

Berikut adalah draf postingan blog yang disusun secara sistematis, menarik, dan ramah SEO agar bisa menjadi dokumentasi pribadi sekaligus bermanfaat bagi orang lain.

------

### **Konfigurasi SEO**

- **Judul Postingan:** Import SQL Ukuran Kecil tapi Loading Lama? Ini Cara Kilat Import Puluhan Ribu Baris Data di MySQL/MariaDB!
- **Permalink:** `cara-cepat-import-sql-besar-mysql-terminal`
- **Deskripsi Penelusuran (Meta Description):** Import SQL di phpMyAdmin lambat atau timeout? Pelajari cara mengatasi limit php.ini dan cara import kilat via Terminal/Podman hanya dalam hitungan detik.

------

### **Isi Postingan Blog**

#### **Pernah Alami Import SQL Cuma 2MB tapi Loading-nya Seharian?**

Mungkin kamu pernah mengalami: file SQL ukurannya kecil (misal hanya 2.4 MB), tapi pas di-import lewat phpMyAdmin, prosesnya "gantung", *loading* lama, atau bahkan kena *timeout*.

**Kenapa bisa begitu?**

Ternyata, beban database bukan cuma dilihat dari ukuran filenya, tapi **jumlah baris datanya**. Contohnya, file 2.4 MB bisa berisi lebih dari 65.000 baris data (seperti data absensi siswa). Jika di-import lewat browser (phpMyAdmin), setiap baris harus melewati antrean PHP dan Apache yang punya batas waktu (timeout).

#### **Solusi 1: "Pertolongan Pertama" dengan Mengubah Limit PHP**

Jika kamu menggunakan Docker atau Podman, kamu bisa menaikkan batas limit di `php.ini` dengan membuat file konfigurasi tambahan (misal: `uploads.ini`):

Ini, TOML

```
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 256M
max_execution_time = 600  # 10 Menit
```

Lalu *mount* file tersebut ke dalam container phpMyAdmin di `docker-compose.yml`:

YAML

```
volumes:
  - ./uploads.ini:/usr/local/etc/php/conf.d/uploads.ini:ro
```

#### **Solusi 2: Jalur Tol via Terminal (CLI) — Paling Ampuh!**

Lupakan browser jika datamu sudah puluhan ribu baris. Gunakan Terminal untuk menyuntikkan data langsung ke mesin database. Cara ini **10x lebih cepat** dan anti-gagal.

Jika kamu menggunakan **Podman/Docker**, gunakan perintah "sakti" ini:

Bash

```
podman exec -i nama_container_db mysql -u root -p'password_kamu' nama_database < file_database.sql
```

**Kenapa Cara CLI Lebih Baik?**

1. **Tanpa Timeout:** Tidak ada batasan waktu dari browser atau PHP.
2. **Hemat RAM:** Database langsung memproses file tanpa perlu "dibungkus" oleh interface web.
3. **Aman:** Mengurangi risiko data terpotong di tengah jalan karena koneksi internet tidak stabil.

#### **Tips Tambahan: Mengatasi Error "Table Already Exists"**

Kalau kamu mencoba import ulang dan muncul error `Table already exists`, kamu bisa membersihkan database dulu sebelum import ulang:

Bash

```
# Hapus dan buat ulang database agar bersih
podman exec -it nama_container_db mysql -u root -p'password' -e "DROP DATABASE IF EXISTS nama_db; CREATE DATABASE nama_db;"
```

#### **Kesimpulan**

Ukuran file SQL yang kecil tidak menjamin proses import akan cepat jika jumlah barisnya sangat banyak. Menguasai perintah dasar CLI (Command Line Interface) akan sangat menyelamatkan waktu kamu saat bekerja dengan database berskala besar.

------

**Semoga bermanfaat! Jangan lupa share ke teman-teman developer lainnya ya!** 

\#MySQL #Database #DeveloperTips #Docker #Podman #WebDevelopment