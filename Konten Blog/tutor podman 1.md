Terima kasih atas informasinya! Karena kamu menggunakan **Fedora** dengan **Podman** (bukan Docker), ada beberapa penyesuaian kecil yang perlu dilakukan — terutama dalam **perintah CLI** dan **penanganan user/container**. Tapi kabar baiknya: **Dockerfile-nya tetap sama!** 🎉

Berikut versi **posting Blogger** yang disesuaikan khusus untuk pengguna **Fedora + Podman**:

---

**Judul Posting:**  
🧋 Jalankan PHP 8.4 di Fedora Tanpa Docker! (Pakai Podman, Lebih Aman & Ringan)

**Deskripsi Meta (≤150 karakter):**  
Setup PHP 8.4 + Apache di Fedora dengan Podman — tanpa Docker, tanpa root, 100% native Linux!

**Permalink (URL SEO):**  
`https://namablogmu.com/php-84-podman-fedora`

---

### 🧋 Jalankan PHP 8.4 di Fedora dengan Podman (Tanpa Docker!)

Hai developer Fedora! 👋  
Tahukah kamu? Sejak Fedora 31, **Docker tidak lagi direkomendasikan** — digantikan oleh **Podman**, tools container open-source yang:
- **Tidak butuh daemon**
- **Bisa jalan tanpa root** (lebih aman!)
- **Kompatibel 100% dengan Docker CLI**

Artinya: **Dockerfile yang kamu tulis tetap bisa dipakai!** Cuma perintahnya sedikit berbeda.

Mari kita buat proyek PHP 8.4 + Apache di Fedora **menggunakan Podman** — dari nol sampai jalan!

---

## ✅ Langkah 1: Pastikan Podman Terinstall

Biasanya sudah terinstall di Fedora, tapi cek dulu:

```bash
podman --version
```

Jika belum:
```bash
sudo dnf install -y podman
```

> ⚠️ Tidak perlu `docker` atau `docker-compose` sama sekali!

---

## ✅ Langkah 2: Buat Struktur Proyek

Sama seperti biasa:

```bash
mkdir my-php-app && cd my-php-app
mkdir src
```

Buat file `src/index.php`:

```php
<?php
echo "<h1>✅ PHP 8.4 di Podman (Fedora) Berhasil!</h1>";
phpinfo();
```

---

## ✅ Langkah 3: Buat `Dockerfile` (Ya, namanya tetap Dockerfile!)

```dockerfile
FROM php:8.4-apache

RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY src/ /var/www/html/

RUN chown -R www-www-data /var/www/html
```

> 🔥 Fakta: Podman **bisa baca Dockerfile** tanpa modifikasi! Keren, kan?

---

## ✅ Langkah 4: Build Image dengan Podman

Ganti `docker` → jadi `podman`:

```bash
podman build -t my-php-app .
```

Tunggu sampai selesai. Podman akan unduh image `php:8.4-apache` dari Docker Hub (ya, tetap kompatibel!).

---

## ✅ Langkah 5: Jalankan Container

```bash
podman run -d -p 8080:80 --name myapp my-php-app
```

> 🎯 Tidak perlu `sudo`! Podman jalan **rootless by default** di Fedora.

---

## ✅ Langkah 6: Akses Aplikasi

Buka browser, kunjungi:  
👉 [http://localhost:8080](http://localhost:8080)

Jika muncul halaman PHP — **selamat!** Kamu baru saja menjalankan PHP 8.4 **tanpa Docker, tanpa root, dan 100% native di Fedora!**

---

## 🔍 Tips Khusus Fedora + Podman

### 1. Lihat container yang berjalan:
```bash
podman ps
```

### 2. Hentikan & hapus:
```bash
podman stop myapp
podman rm myapp
```

### 3. Build ulang setelah ubah kode:
```bash
podman build -t my-php-app . && podman run -d -p 8080:80 --name myapp my-php-app
```

> 💡 Untuk development lebih lancar, nanti kita bisa pakai **volume mount**:
> ```bash
> podman run -d -p 8080:80 -v $(pwd)/src:/var/www/html:Z my-php-app
> ```
> Tanda `:Z` penting di SELinux (aktif di Fedora) agar izin file aman.

---

## ❓ Kenapa Pakai Podman?

| Fitur                 | Docker      | Podman (Fedora)    |
| --------------------- | ----------- | ------------------ |
| Butuh root?           | Ya (daemon) | ❌ Tidak (rootless) |
| SELinux support       | Terbatas    | ✅ Native           |
| Kompatibel Dockerfile | ✅ Ya        | ✅ Ya               |
| Ringan?               | Sedang      | ✅ Lebih ringan     |

---

### Penutup

Dengan **Podman di Fedora**, kamu dapat semua keuntungan container **tanpa kompromi keamanan**.  
Dan yang terbaik: **tidak perlu belajar ulang** — Dockerfile tetap berlaku!

Jadi, mulai sekarang, kamu bisa bilang:  
> “Saya pakai container… tapi bukan Docker 😎”

---

**Mau lanjut?**  
Berikutnya:  
➡️ **Podman Compose + MySQL**  
➡️ **Auto-reload saat development dengan volume**  
➡️ **Deploy ke systemd service**

Komentar di bawah: mau tutorial yang mana dulu?

Jangan lupa **bagikan** ke sesama pengguna Fedora! 🐧

---

*#Podman #Fedora #PHP84 #WebDevelopment #LinuxDeveloper #ContainerTanpaDocker #OpenSource*

---

> **Catatan:** PHP 8.4 masih dalam tahap rilis akhir 2025. Jika tidak tersedia, ganti `php:8.4-apache` dengan `php:8.3-apache` atau versi stabil terbaru.

---

Silakan ganti `namablogmu.com` dengan domain blogmu, lalu publish!  
Semoga membantu — happy coding di Fedora! 💻✨