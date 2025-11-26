# Cara Termudah Ganti XAMPP dengan Docker di OMARCHY / Arch Linux (Tutorial Lengkap untuk Pemula)

**Permalink:**  
`https://namablogkamu.blogspot.com/2025/11/cara-install-lamp-docker-omarchy-arch-linux-tanpa-xampp.html`

**Meta Description (148 karakter):**  
Ganti XAMPP yang error 32-bit dengan Docker! Tutorial lengkap Apache + PHP 8.3 + MariaDB + phpMyAdmin di OMARCHY/Arch Linux cuma 5 menit.

---

## Cerita Nyata: Dari Frustasi XAMPP ke Cinta Docker

Pernah nggak sih install XAMPP di OMARCHY/Arch Linux terus muncul pesan:
> “XAMPP is currently only available as 32 bit application…”

Saya pernah. Berkali-kali. Install lib32, edit script, tetap saja error. Akhirnya saya nyerah dan pindah ke **Docker** — dan dalam 10 menit semua beres!

Hasil akhirnya:
- 100 % 64-bit murni
- PHP 8.3 terbaru
- Apache + MariaDB + phpMyAdmin
- Tanpa install lib32 apapun
- Cuma 1 perintah untuk start/stop
- Bisa langsung pakai proyek absensi siswa, website sekolah, Laravel, dll

## Apa Itu Docker? (Penjelasan Super Gampang untuk Pemula)

Bayangkan Docker seperti **flashdisk ajaib** yang isinya sudah ada:
- Web server (Apache)
- PHP
- Database (MariaDB)
- phpMyAdmin

Kamu tinggal “colok” (jalankan), langsung bisa pakai tanpa takut bentrok dengan sistem utama.

Istilah dasar:
- **Image** → file template (contoh: `php:8.3-apache`)
- **Container** → aplikasi yang sedang jalan dari image
- **docker compose** → cara paling gampang nyalain banyak container sekaligus

## Tutorial Lengkap: LAMP Stack Pakai Docker di OMARCHY Linux

### 1. Buat folder kerja
```bash
mkdir ~/xampp-docker && cd ~/xampp-docker
```

### 2. Buat file `docker-compose.yml`
```bash
cat > docker-compose.yml << 'EOF'
services:
  php:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: php-apache
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./htdocs:/var/www/html
    restart: unless-stopped

  mariadb:
    image: mariadb:11
    container_name: mariadb
    environment:
      MYSQL_ROOT_PASSWORD: root123
      MYSQL_DATABASE: testdb
      MYSQL_USER: user
      MYSQL_PASSWORD: pass
    volumes:
      - mariadb_data:/var/lib/mysql
    ports:
      - "3306:3306"
    restart: unless-stopped

  phpmyadmin:
    image: phpmyadmin
    container_name: phpmyadmin
    environment:
      PMA_HOST: mariadb
    ports:
      - "8080:80"
    depends_on:
      - mariadb
    restart: unless-stopped

volumes:
  mariadb_data:
EOF
```

### 3. Buat file `Dockerfile` (ini yang bikin mysqli, gd, mbstring jalan)
```bash
cat > Dockerfile << 'EOF'
FROM php:8.3-apache

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libwebp-dev \
    libzip-dev zlib1g-dev libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Install extension PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        mysqli pdo_mysql gd mbstring zip exif pcntl bcmath

# Aktifkan rewrite (buat .htaccess)
RUN a2enmod rewrite

# Naikkan limit upload & memory
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/custom.ini
RUN echo "upload_max_filesize = 100M" >> /usr/local/etc/php/conf.d/custom.ini
RUN echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/custom.ini
EOF
```

### 4. Buat folder htdocs + file tes
```bash
mkdir htdocs
echo "<?php phpinfo(); ?>" > htdocs/index.php
```

### 5. Jalankan pertama kali (tunggu 2–3 menit)
```bash
docker compose up -d --build
```

### Setiap hari cukup 1 perintah
```bash
cd ~/xampp-docker && docker compose up -d    # nyalakan
cd ~/xampp-docker && docker compose down     # matikan
```

### Bonus: Bikin alias supaya makin gampang
```bash
echo "alias xup='cd ~/xampp-docker && docker compose up -d'" >> ~/.bashrc
echo "alias xdown='cd ~/xampp-docker && docker compose down'" >> ~/.bashrc
source ~/.bashrc
```
Setelah ini cukup ketik `xup` dan `xdown` selamanya!

## Hasil Akhir
- http://localhost → website/proyek kamu
- http://localhost:8080 → phpMyAdmin (login: root / root123)

## Kesimpulan

Lupakan XAMPP yang selalu error 32-bit di Arch Linux/OMARCHY.  
Docker adalah solusi masa depan: cepat, bersih, selalu up-to-date, dan cuma 1 perintah!

Selamat! Kamu sekarang punya server lokal yang jauh lebih keren dari XAMPP, tanpa drama lagi.

Kalau artikel ini membantu, share ke teman guru atau developer lain yang masih berjuang dengan XAMPP ya.

Sukses terus belajar Docker-nya!  
Komentar di bawah kalau ada yang ingin ditanyakan, saya bantu sampai jalan 100 %.