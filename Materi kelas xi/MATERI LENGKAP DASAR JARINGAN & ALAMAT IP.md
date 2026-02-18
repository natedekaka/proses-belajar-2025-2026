# MATERI LENGKAP: DASAR JARINGAN & ALAMAT IP

## 1. Arsitektur Jaringan: Client-Server

**Definisi Ilmiah:** Model struktur aplikasi terdistribusi yang membagi tugas antara penyedia sumber daya (Server) dan peminta layanan (Client).

- **Client:** Perangkat (HP/Laptop) yang mengirimkan *request*.
- **Server:** Komputer spesifikasi tinggi yang melayani *request* dan mengirimkan data.
- **Analogi:** Seperti **Pelanggan** dan **Pelayan** di restoran. Pelanggan memesan (request), pelayan menyajikan makanan (data).

------

## 2. Identitas Perangkat: IP Address

**Definisi Ilmiah:** Alamat unik 32-bit (untuk IPv4) yang direpresentasikan dalam format *dotted decimal* (4 oktet) untuk mengidentifikasi host di jaringan.

- **Struktur:** Terdiri dari bagian **Network ID** (Identitas kelompok) dan **Host ID** (Identitas individu).
- **Analogi:** Seperti **Alamat Rumah Lengkap**. Tanpa alamat, paket data tidak tahu harus dikirim ke mana.

------

## 3. Netmask & Subnetting: Menentukan Batas

**Definisi Ilmiah:** Angka biner yang digunakan untuk menutupi (*masking*) bagian IP Address sehingga komputer bisa membedakan mana bit untuk Network dan mana bit untuk Host.

- **Analogi:** Seperti **Pagar Kompleks**. Netmask menentukan seberapa luas "RT" atau "RW" kamu. Perangkat dengan Netmask yang sama bisa berkomunikasi langsung tanpa bantuan Router.

### 🔴 Cara Perhitungan Netmask (Konversi CIDR ke Desimal)

Siswa sering melihat format `/24`. Ini disebut **CIDR (Prefix)**. Angka 24 berarti ada 24 bit angka `1` di awal.

**Contoh: Menghitung Netmask dari `/24`**

1. Tuliskan angka `1` sebanyak 24 kali, bagi menjadi 4 kelompok (oktet):

   `11111111 . 11111111 . 11111111 . 00000000`

2. Konversikan setiap oktet biner ke desimal:

   - `11111111` = **255**
   - `00000000` = **0**

3. **Hasil:** Netmasknya adalah **255.255.255.0**.

------

## 4. Perhitungan Network, Host, dan Broadcast

Misalkan kita punya IP **192.168.1.10/24**. Bagaimana cara mencari identitas lainnya?

### A. Mencari Network ID (Alamat Jalan)

- **Rumus Ilmiah:** Operasi logika **AND** antara IP dan Netmask.
- **Cara Cepat:** Jika `/24`, maka 3 angka pertama dikunci, angka terakhir diubah jadi `0`.
- **Hasil:** `192.168.1.0`

### B. Mencari Broadcast Address (Alamat Toa)

- **Rumus Ilmiah:** Mengubah semua bit Host menjadi `1`.
- **Cara Cepat:** Jika `/24`, angka terakhir diubah menjadi angka maksimal (`255`).
- **Hasil:** `192.168.1.255`

### C. Mencari Range Host (Rumah yang Tersedia)

- **Rumus:** Angka setelah Network ID sampai sebelum Broadcast.
- **Hasil:** `192.168.1.1` sampai `192.168.1.254`.

------

## 5. DNS (Domain Name System)

**Definisi Ilmiah:** Sistem basis data terdistribusi yang menerjemahkan nama domain (human-readable) menjadi IP Address (machine-readable).

- **Analogi:** Seperti **Buku Telepon** atau **Kontak di HP**. Kamu mencari nama "Andi", tapi sistem memanggil nomor teleponnya. Komputer mencari "https://www.google.com/search?q=google.com", DNS memberikan IP `142.250.190.46`.

------

## 6. Tabel Rangkuman Saku

| **Istilah**    | **Fungsi Teknis**        | **Analogi Sederhana**    |
| -------------- | ------------------------ | ------------------------ |
| **IP Address** | Identitas Node           | Nomor Rumah              |
| **Netmask**    | Pemisah Network & Host   | Batas Pagar RT           |
| **Broadcast**  | Pengiriman ke semua Host | Toa Pengumuman           |
| **DNS**        | Penerjemah Nama ke IP    | Kontak/Buku Telepon      |
| **Traceroute** | Melacak jalur paket data | Riwayat perjalanan kurir |

------

### Aktivitas Simulasi untuk Siswa:

1. **Cek Identitas:** Buka Termux/iTerminal, ketik `ifconfig` atau `ip addr`.
2. **Uji Tetangga:** Coba `ping` ke IP teman sebangku (Network ID harus sama).
3. **Uji DNS:** Ketik `nslookup facebook.com`, catat IP-nya, lalu buka IP tersebut di browser HP.

**Langkah selanjutnya:**

Apakah Anda ingin saya buatkan satu set **Soal Pilihan Ganda** atau **Studi Kasus** untuk menguji pemahaman mereka tentang perhitungan Netmask ini?