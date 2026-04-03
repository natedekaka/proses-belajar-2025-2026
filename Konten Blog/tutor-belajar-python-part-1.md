---
title: "Belajar Python Tanpa Pusing: Panduan Praktis Minggu 1-3 untuk Pemula & Guru (Part 1)"
permalink: "panduan-belajar-python-part1-dasar-logika"
description: "Panduan lengkap belajar Python: Variabel, Tipe Data, List, IF/ELSE, Indentasi, dan Looping dengan analogi mudah untuk pemula."
date: 2026-04-03
tags: [Python, Tutorial Coding, Belajar Python, Informatika, Guru]
---

# Belajar Python Tanpa Pusing: Panduan Praktis Minggu 1-3 (Part 1)

Belajar coding bukan tentang menghafal, tapi tentang memahami alur. Mari kita bedah fondasi Python dalam 3 minggu pertama dengan cara yang paling manusiawi.

---

## Minggu 1: Mengenal Bahan (Variabel, Tipe Data, & List)

### 1. Apa itu Variabel?
Bayangkan variabel sebagai sebuah **Kotak Label**. Anda punya data (barang), dan Anda menyimpannya di dalam kotak agar bisa dipanggil lagi nanti.
*   `nama = "Budi"` (Artinya: Simpan teks "Budi" ke dalam kotak bernama `nama`).

### 2. Tipe Data (Jenis Barang)
Di Python, barang yang kita simpan punya jenis yang berbeda-beda:
*   **String (str):** Teks atau tulisan. Harus diapit tanda kutip. Contoh: `"Informatika"`, `"46 Tahun"`.
*   **Integer (int):** Angka bulat. Contoh: `10`, `-5`, `100`.
*   **Float:** Angka desimal (pakai titik, bukan koma). Contoh: `75.5`, `3.14`.
*   **Boolean (bool):** Nilai kebenaran. Hanya ada dua: `True` (Benar) atau `False` (Salah).

### 3. List (Lemari Rak)
Jika variabel biasa hanya bisa menyimpan satu barang, **List** bisa menyimpan banyak barang sekaligus dalam satu urutan.
*   `siswa = ["Ani", "Budi", "Caca"]`
*   **Indeks:** Cara memanggilnya pakai nomor urut yang dimulai dari **0**. Jadi, `siswa[0]` adalah "Ani".

---

## Minggu 2: Mengambil Keputusan (IF, ELIF, ELSE)

### 1. Logika Percabangan
Komputer bekerja berdasarkan kondisi. Kita memberikan instruksi: *"Jika ini terjadi, lakukan itu."*
*   **IF:** Kondisi utama.
*   **ELIF (Else If):** Kondisi alternatif jika kondisi pertama salah.
*   **ELSE:** Pilihan terakhir jika semua kondisi di atas salah.

### 2. Aturan Penulisan & Indentasi (Menjorok)
Ini bagian paling penting di Python! Python tidak menggunakan `{ }` seperti PHP atau C++. Python menggunakan **Spasi Menjorok (Indentasi)**.
*   Setelah tanda titik dua (`:`), baris berikutnya **WAJIB** menjorok ke dalam (biasanya 4 spasi atau 1 Tab).
*   Baris yang menjorok dianggap sebagai "anak buah" dari kondisi di atasnya.

**Contoh:**
```python
nilai = 85

if nilai >= 90:
    print("Sangat Baik") # Menjorok, anak buah IF
elif nilai >= 75:
    print("Cukup Baik")  # Menjorok, anak buah ELIF
else:
    print("Kurang")      # Menjorok, anak buah ELSE
```

---

## Minggu 3: Melakukan Tugas Berulang (Looping)

### 1. For Loop (Si Pengabsen)
Gunakan `for` jika Anda **tahu pasti** berapa kali harus mengulang atau ingin memeriksa **isi List**.
*   **Kapan dipakai?** Saat ingin mencetak semua nama siswa, menghitung total belanja, atau memeriksa daftar nilai.
```python
for s in ["Ani", "Budi"]:
    print(f"Halo {s}")
```

### 2. While Loop (Si Penjaga Pintu)
Gunakan `while` jika Anda **tidak tahu** kapan berhentinya, yang penting **selama syarat masih benar**, lakukan terus.
*   **Kapan dipakai?** Menunggu input password yang benar, menjalankan mesin selama tombol 'ON' ditekan, atau permainan yang terus berjalan sampai nyawa habis.
```python
nyawa = 3
while nyawa > 0:
    print("Sedang Bermain...")
    nyawa = nyawa - 1
```

---

## Waktunya Praktik! (Hands-on Lab)

Silakan buka **Visual Studio Code**, buat folder baru, dan coba ketik ulang (jangan copy-paste) skrip latihan berikut satu per satu.

### Latihan 1: Dasar Looping (File: `latihan_loop.py`)
Skrip ini melatih cara mengambil data dari List dan menampilkannya.
```python
buah_buahan = ["Apel", "Jeruk", "Mangga", "Pisang"]

print("--- Daftar Buah Kesukaan ---")
for buah in buah_buahan:
    print(f"Saya sangat suka makan buah {buah}")
```
**Penjelasan:** Program akan mengambil satu per satu nama buah dari list `buah_buahan` dan mencetaknya ke layar.

### Latihan 2: Laporan Nilai Siswa (File: `latihan_nilai.py`)
Skrip ini menggabungkan List, Loop, dan Logika IF/ELSE.
```python
daftar_nilai = [60, 85, 90, 45, 75, 80]

print("=== LAPORAN HASIL UJIAN ===")
for nilai in daftar_nilai:
    if nilai >= 75:
        status = "LULUS"
    else:
        status = "REMEDIAL"
    print(f"Nilai Siswa: {nilai} -> Status: {status}")
```
**Penjelasan:** Setiap nilai diperiksa. Jika mencapai angka 75 ke atas, komputer otomatis memberi label "LULUS".

### Latihan 3: Kalkulator Kantin (File: `kantin_sekolah.py`)
Skrip ini melatih teknik **Akumulasi** (menjumlahkan nilai secara bertahap).
```python
harga_jajanan = [2000, 5000, 1500, 3000, 10000]
total_bayar = 0

for harga in harga_jajanan:
    total_bayar = total_bayar + harga
    print(f"Item harga: Rp {harga} -> Total sementara: Rp {total_bayar}")

print(f"TOTAL YANG HARUS DIBAYAR: Rp {total_bayar}")
```
**Penjelasan:** Kita menyiapkan "keranjang kosong" (`total_bayar = 0`), lalu setiap harga jajanan dimasukkan ke dalam keranjang tersebut satu per satu.

### Latihan 4: Rekap Absensi (File: `rekap_absen.py`)
Skrip ini melatih teknik **Counting** (menghitung jumlah kejadian).
```python
# H = Hadir, S = Sakit, A = Alpa
daftar_hadir = ["H", "H", "S", "H", "A", "H", "S"]

jumlah_hadir = 0
jumlah_sakit = 0
jumlah_alpa = 0

for status in daftar_hadir:
    if status == "H":
        jumlah_hadir = jumlah_hadir + 1
    elif status == "S":
        jumlah_sakit = jumlah_sakit + 1
    else:
        jumlah_alpa = jumlah_alpa + 1

print("=== REKAP ABSENSI HARI INI ===")
print(f"Siswa Hadir : {jumlah_hadir}")
print(f"Siswa Sakit : {jumlah_sakit}")
print(f"Siswa Alpa  : {jumlah_alpa}")
```
**Penjelasan:** Komputer menghitung berapa kali huruf "H", "S", dan "A" muncul dalam daftar. Ini sangat membantu untuk membuat laporan otomatis.

---

## Kesimpulan
Belajar coding di usia berapapun adalah tentang **ketekunan**. Dengan mencoba skrip di atas, Anda sudah melatih logika dasar yang digunakan oleh programmer profesional di seluruh dunia.

*Sampai jumpa di Part 2: Menguasai Fungsi (def) untuk membungkus logika Anda!*
