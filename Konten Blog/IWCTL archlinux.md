Konfigurasi SEO Blogger

- **Judul SEO:** Cara Menggunakan iWctl untuk Koneksi WiFi di Linux via Terminal (iwd)
- **Deskripsi Penelusuran (Max 150 Karakter):** Tutorial cara koneksi WiFi di Linux menggunakan perintah iwctl (iwd). Cepat, ringan, dan cocok untuk pengguna Arch Linux atau minimal distro.
- **Permalink:** `cara-koneksi-wifi-linux-iwctl`

------

Isi Postingan

Cara Praktis Koneksi WiFi di Linux Menggunakan iWctl (iwd)

Bagi pengguna distro Linux minimalis seperti Arch Linux atau Void Linux, mengelola jaringan melalui Command Line Interface (CLI) adalah hal biasa. Salah satu alat yang paling efisien dan modern saat ini adalah **iwd (Internet Wireless Daemon)** dengan utilitasnya `iwctl`.

Dalam artikel ini, kita akan membedah langkah-langkah mengoneksikan WiFi hanya melalui terminal, berdasarkan log aktivitas terbaru di tahun 2026.

Mengapa Memilih iwd/iwctl?

iwd dirancang oleh Intel untuk menggantikan *wpa_supplicant*. Keunggulannya adalah penggunaan resource yang sangat kecil, proses koneksi yang lebih cepat, dan perintah yang lebih intuitif.

Langkah-langkah Koneksi WiFi via iwctl

1. Masuk ke Konsol iwctl

Buka terminal Anda dan ketikkan perintah berikut untuk masuk ke mode interaktif:

bash

```
iwctl
```

2. Cek List Device (Interface)

Pastikan perangkat WiFi Anda terbaca dan dalam kondisi aktif (Powered: on).

bash

```
[iwd]# device list
```

*Contoh output: Nama interface biasanya adalah **wlan0**.*

3. Pindai dan Lihat Jaringan yang Tersedia

Gunakan perintah berikut untuk mencari sinyal WiFi di sekitar Anda:

bash

```
[iwd]# station wlan0 get-networks
```

Anda akan melihat daftar SSID (nama WiFi), tipe keamanan (seperti PSK), dan kekuatan sinyalnya.

4. Melakukan Koneksi

Setelah menemukan target WiFi (misalnya: **Ramadhan00**), hubungkan dengan perintah:

bash

```
[iwd]# station wlan0 connect "Nama_SSID"
```

*Catatan: Jika WiFi menggunakan password, sistem akan meminta Anda memasukkannya setelah perintah ini dijalankan.*

5. Verifikasi Koneksi

Setelah berhasil, keluar dari mode iwctl dengan mengetik `exit`. Kemudian, pastikan koneksi internet sudah aktif dengan melakukan ping ke server Google:

bash

```
ping google.com
```



Jika muncul balasan (reply) dengan *0% packet loss*, selamat! Anda sudah berhasil terhubung ke internet.

Kesimpulan

Menggunakan `iwctl` adalah cara yang sangat efisien bagi pengguna Linux yang mengutamakan kecepatan tanpa harus bergantung pada antarmuka grafis (GUI). Pastikan service `iwd` sudah berjalan di sistem Anda sebelum memulai langkah-langkah di atas.

------