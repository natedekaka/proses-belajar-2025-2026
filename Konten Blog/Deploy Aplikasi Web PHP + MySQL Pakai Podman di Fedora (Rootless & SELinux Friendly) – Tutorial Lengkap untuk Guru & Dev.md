# Deploy Aplikasi Web PHP + MySQL Pakai Podman di Fedora (Rootless & SELinux Friendly) – Tutorial Lengkap untuk Guru & Developer

Halo para guru Informatika dan teman-teman developer!

Saya baru saja berhasil menjalankan aplikasi absensi siswa berbasis PHP + MySQL menggunakan **Podman** di Fedora 43 secara *rootless* (tanpa sudo untuk container). Prosesnya memang agak berliku karena SELinux di Fedora cukup ketat, tapi setelah selesai, hasilnya sangat memuaskan: aman, ringan, dan mudah dikelola.

Postingan ini saya buat sebagai catatan pribadi sekaligus berbagi pengalaman agar kalian (dan saya sendiri nanti) bisa mengulangnya dengan cepat. Tutorial ini cocok untuk:

- Guru yang ingin demo containerisasi ke siswa kelas XI/XII
- Developer yang ingin jalankan banyak aplikasi web di satu mesin tanpa bentrok
- Siapa saja yang baru mulai dengan Podman di Fedora

## Apa yang Akan Kita Buat?

- Aplikasi absensi siswa PHP (login → dashboard → absen → rekap)
- Database MySQL
- phpMyAdmin untuk manage DB
- Semua dijalankan dengan Podman + podman-compose

## Prasyarat

- Fedora 43 (atau versi terbaru)
- Podman dan podman-compose sudah terinstall:

```
sudo dnf install podman podman-compose
```

## Struktur Folder Project

```
~/absensi-podman/
├── src/                  ← semua file aplikasi PHP (index.php, login.php, dashboard/, dll)
├── Dockerfile
├── compose.yaml
```

## 1. Dockerfile (Minimal & Terbukti Jalan)

```dockerfile
FROM php:8.4-apache

# Aktifkan mod_rewrite & install ekstensi MySQL
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy aplikasi ke web root
COPY src/ /var/www/html/

# Set permission agar Apache bisa baca
RUN chown -R www-data:www-data /var/www/html
```

## 2. compose.yaml (Versi Stabil untuk Fedora + SELinux)

```yaml
version: '3.8'
services:
  web:
    build: .
    container_name: absensi-web
    depends_on:
      - db
    volumes:
      - ./src:/var/www/html:z        # :z penting untuk SELinux Fedora!
    ports:
      - "8080:80"
    restart: unless-stopped
  db:
    image: mysql:8.0
    container_name: absensi-db
    environment:
      MYSQL_ROOT_PASSWORD: rootpass123
      MYSQL_DATABASE: absensi_db
      MYSQL_USER: absensi_user
      MYSQL_PASSWORD: userpass123
    volumes:
      - dbdata:/var/lib/mysql:z
    restart: unless-stopped
  phpmyadmin:
    image: docker.io/phpmyadmin/phpmyadmin:latest
    container_name: absensi-pma
    depends_on:
      - db
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      MYSQL_ROOT_PASSWORD: rootpass123
    ports:
      - "8081:80"
    restart: unless-stopped
volumes:
  dbdata:
```

**Catatan penting SELinux:** Gunakan `:z` (bukan `:Z`) pada volume agar Podman bisa relabel dengan benar di Fedora.

## 3. Jalankan Aplikasi

```
# Pertama kali (build image)
podman-compose up -d --build

# Selanjutnya cukup
podman-compose up -d

# Stop semua
podman-compose down

# Hapus data (hati-hati!)
podman-compose down -v
```

## 4. Akses Aplikasi

- **Aplikasi Absensi**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

## 5. Import Database (WAJIB!)

1. Buka phpMyAdmin → login root / rootpass123
2. Pilih database `absensi_db`
3. Tab Import → pilih file SQL backup (misal `absensi_db3 22-11-25.sql`)
4. Klik Go

## 6. Mengembangkan Banyak Aplikasi Tanpa Bentrok

Cara termudah: gunakan **port berbeda** untuk tiap project.

- Absensi → port 8080
- Project lain (misal perpustakaan) → buat folder baru, compose.yaml dengan port "8082:80"
- E-learning → port 8083, dst.

Nanti kalau sudah mahir, bisa pakai reverse proxy seperti Caddy/Traefik untuk akses via subpath atau subdomain lokal.

## Perintah Cheat Sheet Podman-Compose

```
podman-compose ps               # cek status container
podman-compose logs -f web      # lihat log real-time
podman-compose restart web      # restart hanya web
podman-compose exec db mysql ... # masuk ke MySQL
podman ps -a                    # semua container Podman
```

## Kesimpulan

Podman di Fedora memang butuh sedikit perhatian ekstra karena SELinux, tapi setelah setup benar, sangat powerful: aman (rootless), ringan, dan cocok untuk development + demo pendidikan.

Sekarang aplikasi absensi saya sudah live lokal, bisa dikembangkan lebih lanjut (QR code absen, notifikasi WA, dll), dan saya punya template siap pakai untuk project PHP lainnya.

Semoga tutorial ini membantu kalian juga. Kalau ada pertanyaan, silakan komentar di bawah!

Salam coding,  
Daniarsyah  
Guru Informatika SMA  

(Tanggal: 29 Desember 2025)