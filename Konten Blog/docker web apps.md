Berikut adalah materi lengkap untuk postingan Blogger kamu. Saya buat dengan gaya menarik, mudah dibaca, SEO-friendly (judul & permalink dioptimasi untuk pencarian seperti "cara multiple aplikasi web Docker localhost", "Docker PHP multiple project", dll), deskripsi meta <150 karakter, serta saran gambar dari hasil pencarian yang relevan.

### Judul Posting (SEO Optimized)
**Cara Setup Multiple Aplikasi Web PHP di Docker Lokal Tanpa Bentrok Port (2026 Guide)**

### Permalink (SEO-friendly, mudah dicari)
`/cara-setup-multiple-aplikasi-web-php-docker-localhost-tanpa-bentrok-port`

### Meta Description (<150 karakter)do (118 karakter)
### Isi Postingan Blogger (Copy-paste ready)

**Pendahuluan**  
Pernah kesulitan jalankan lebih dari satu aplikasi web PHP di localhost karena port 80 sudah dipakai? Saya juga dulu begitu!  

Akhirnya saya bikin struktur folder baru bernama `web-apps` yang rapi, pisah per project, pakai port berbeda (misal 8001, 8081), dan tetap bisa akses phpMyAdmin masing-masing.  

Tutorial ini hasil pengalaman real: dari folder lama `xampp-docker` (absensi) sampai project baru `presensirapat-gtk`. Cocok buat developer lokal yang pakai Docker di Linux (Arch/Manjaro dkk).

**Alat yang Dibutuhkan**  
- Docker & Docker Compose terinstall  
- Folder kerja di `/home/user/web-apps`  
- Akses terminal

**Langkah 1: Buat Struktur Folder Rapi**  
Buat folder utama supaya semua project terorganisir:

```bash
mkdir -p ~/web-apps
cd ~/web-apps
mkdir presensirapat-gtk
cd presensirapat-gtk
```

Ini hasilnya:  
- `~/web-apps/absensi` → project lama (rename dari xampp-docker nanti)  
- `~/web-apps/presensirapat-gtk` → project baru

**Langkah 2: Copy Template Docker dari Project Lama**  
Copy Dockerfile & docker-compose.yml dari project absensi:

```bash
cp ~/xampp-docker/Dockerfile .
cp ~/xampp-docker/docker-compose.yml .
```

**Langkah 3: Edit docker-compose.yml (Kunci Utama!)**  
Buka file dengan `nano docker-compose.yml`, ubah jadi seperti ini (port & nama unik):

```yaml
version: '3.8'
services:
  php:
    build: .
    container_name: php-apache-presensirapat
    ports:
      - "8001:80"  # Port app baru
    volumes:
      - ./htdocs:/var/www/html
    restart: unless-stopped

  mariadb:
    image: mariadb:11
    container_name: mariadb-presensirapat
    environment:
      MYSQL_ROOT_PASSWORD: root123
      MYSQL_DATABASE: presensirapat_db
    ports:
      - "3307:3306"
    volumes:
      - mariadb_presensirapat_data:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin:latest
    container_name: phpmyadmin-presensirapat
    environment:
      PMA_HOST: mariadb
      PMA_ARBITRARY: 1  # Penting agar bisa pilih host manual
    ports:
      - "8081:80"
    depends_on:
      - mariadb
```

**Langkah 4: Buat Folder htdocs & Jalankan**  

```bash
mkdir htdocs
docker compose up -d --build
```

**Langkah 5: Akses Hasilnya**  
- Aplikasi kamu → http://localhost:8001  
- phpMyAdmin → http://localhost:8081 (login root / root123, pilih host: mariadb kalau perlu)

**Tips Tambahan**  
- Kalau error port sudah dipakai → cek `sudo netstat -tulnp | grep 8001` lalu stop container lama.  
- Mau tanpa port? Nanti tambah Caddy/Traefik di folder proxy terpisah.  
- Backup rutin: `cp -r htdocs htdocs_backup_$(date +%Y%m%d)`

**Kesimpulan**  
Dengan cara ini, kamu bisa jalankan puluhan aplikasi web PHP di satu komputer tanpa bentrok! Struktur `web-apps` ini scalable, bersih, dan best practice 2026 untuk developer self-hosted.

Sudah coba? Share pengalaman di komentar ya! 🚀

### Saran Gambar untuk Postingan (Featured + Inline)

Gunakan gambar ini di postingan (upload ke Blogger atau link dari URL asli):

1. **Featured Image / Header** (pilih salah satu yang paling bagus):  
   - Laptop setup dengan code & browser localhost:




     (Atau alternatif: image:1 / image:2 untuk variasi MacBook/HP laptop)

2. **Inline Gambar Langkah Terminal** (untuk bagian copy command):




   (Ilustrasi terminal mkdir & cp – cocok untuk visualisasi command)

3. **Inline Gambar Docker Tutorial** (untuk bagian docker compose):




   (Infografis beginner Docker – tambahkan caption: "Proses build Docker seperti ini!")

Postingan ini siap dipublish langsung. Kalau perlu revisi judul, tambah kode, atau gambar lain, bilang saja ya! Semangat blogging-nya! 📝