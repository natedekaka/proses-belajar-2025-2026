Berikut adalah **materi lengkap** tentang **Python Dasar: Operasi Aritmatika dan Pernyataan Kondisional (if, elif, else)** yang **dirancang khusus untuk siswa SMA kelas 11**, dilengkapi dengan **penjelasan konsep, contoh kode, latihan, dan proyek akhir**.

---

# 📘 **MATERI PEMBELAJARAN PYTHON DASAR**  
### 🎯 Kelas: XI SMA  
### 🧠 Topik: Operasi Aritmatika dan Pernyataan Kondisional (`if`, `elif`, `else`)  
### 🕒 Durasi: 2–3 Pertemuan (90 menit per pertemuan)

---

## 🌟 TUJUAN PEMBELAJARAN
Setelah mempelajari materi ini, siswa mampu:
1. Melakukan operasi aritmatika dasar menggunakan Python.
2. Memahami operator perbandingan dan logika.
3. Menggunakan pernyataan `if`, `elif`, dan `else` untuk membuat keputusan dalam program.
4. Menerapkan konsep logika pemrograman dalam proyek sederhana.

---

## 🔤 1. OPERASI ARITMATIKA DASAR DI PYTHON

Python dapat digunakan sebagai kalkulator. Berikut adalah operator aritmatika dasar:

| Operator | Arti            | Contoh        |
| -------- | --------------- | ------------- |
| `+`      | Penjumlahan     | `5 + 3` → 8   |
| `-`      | Pengurangan     | `5 - 3` → 2   |
| `*`      | Perkalian       | `5 * 3` → 15  |
| `/`      | Pembagian       | `6 / 3` → 2.0 |
| `//`     | Pembagian bulat | `7 // 2` → 3  |
| `%`      | Modulus (sisa)  | `7 % 3` → 1   |
| `**`     | Perpangkatan    | `2 ** 3` → 8  |

### ✅ Contoh Kode:
```python
a = 10
b = 3

print("Penjumlahan:", a + b)
print("Pengurangan:", a - b)
print("Perkalian:", a * b)
print("Pembagian:", a / b)
print("Pembagian bulat:", a // b)
print("Modulus:", a % b)
print("Perpangkatan:", a ** b)
```

> 💡 Catatan: Hasil pembagian (`/`) selalu bertipe `float`, sedangkan `//` menghasilkan bilangan bulat.

---

## 🔍 2. OPERATOR PERBANDINGAN

Operator perbandingan digunakan untuk membandingkan dua nilai. Hasilnya adalah `True` atau `False`.

| Operator | Arti                  | Contoh          |
| -------- | --------------------- | --------------- |
| `==`     | Sama dengan           | `5 == 5` → True |
| `!=`     | Tidak sama dengan     | `5 != 3` → True |
| `>`      | Lebih besar dari      | `5 > 3` → True  |
| `<`      | Lebih kecil dari      | `5 < 3` → False |
| `>=`     | Lebih besar atau sama | `5 >= 5` → True |
| `<=`     | Lebih kecil atau sama | `5 <= 6` → True |

### ✅ Contoh Kode:
```python
nilai = 80
lulus = nilai >= 75
print("Apakah lulus?", lulus)  # Output: True
```

---

## 🔁 3. PERNYATAAN KONDISIONAL: `if`, `elif`, `else`

Pernyataan kondisional digunakan untuk membuat keputusan dalam program.

### Struktur Dasar:
```python
if kondisi:
    pernyataan
elif kondisi_lain:
    pernyataan
else:
    pernyataan
```

> 🔹 `if`: diperiksa terlebih dahulu.  
> 🔹 `elif` (singkatan dari *else if*): opsional, bisa lebih dari satu.  
> 🔹 `else`: dieksekusi jika semua kondisi sebelumnya salah.

### ✅ Contoh 1: Pengecekan Nilai
```python
nilai = 85

if nilai >= 75:
    print("Selamat! Anda Lulus.")
else:
    print("Maaf, Anda Tidak Lulus.")
```

### ✅ Contoh 2: Predikat Nilai (Menggunakan `elif`)
```python
nilai = 90

if nilai >= 90:
    print("Predikat: A")
elif nilai >= 80:
    print("Predikat: B")
elif nilai >= 70:
    print("Predikat: C")
else:
    print("Predikat: D")
```

> 💡 Indentasi (spasi/tab) sangat penting di Python!

---

## 🧩 4. LATIHAN PRAKTIK

### 🔹 Latihan 1: Operasi Aritmatika
Buat program yang menghitung:
- Luas persegi panjang (panjang × lebar)
- Keliling lingkaran (2 × π × r)

> Gunakan `input()` untuk meminta data dari pengguna.

**Contoh Output:**
```
Masukkan panjang: 10
Masukkan lebar: 5
Luas persegi panjang: 50
```

---

### 🔹 Latihan 2: Pengecekan Bilangan
Buat program yang memeriksa apakah sebuah bilangan:
- Genap atau ganjil
- Positif, negatif, atau nol

**Contoh Output:**
```
Masukkan angka: 7
Bilangan ganjil dan positif.
```

> Petunjuk: Gunakan `% 2 == 0` untuk cek genap.

---

### 🔹 Latihan 3: Diskon Toko
Sebuah toko memberikan diskon:
- Jika total belanja ≥ 100000, diskon 10%
- Jika ≥ 50000, diskon 5%
- Selain itu, tidak ada diskon

Hitung total yang harus dibayar.

**Contoh Output:**
```
Total belanja: 120000
Total bayar setelah diskon: 108000
```

---

## 🧪 PROYEK 1: KALKULATOR SEDERHANA

### 🎯 Tujuan:
Membuat kalkulator yang bisa melakukan operasi +, -, *, / berdasarkan pilihan pengguna.

### 🛠 Langkah:
1. Minta dua angka dari pengguna.
2. Minta pilihan operasi (+, -, *, /).
3. Gunakan `if`, `elif`, `else` untuk menentukan operasi.
4. Tampilkan hasilnya.
5. Tambahkan pengecekan pembagian dengan nol!

### ✅ Contoh Kode:
```python
print("=== KALKULATOR SEDERHANA ===")
angka1 = float(input("Masukkan angka pertama: "))
angka2 = float(input("Masukkan angka kedua: "))
operator = input("Pilih operator (+, -, *, /): ")

if operator == "+":
    hasil = angka1 + angka2
    print("Hasil:", hasil)
elif operator == "-":
    hasil = angka1 - angka2
    print("Hasil:", hasil)
elif operator == "*":
    hasil = angka1 * angka2
    print("Hasil:", hasil)
elif operator == "/":
    if angka2 != 0:
        hasil = angka1 / angka2
        print("Hasil:", hasil)
    else:
        print("Error: Pembagian dengan nol tidak diperbolehkan!")
else:
    print("Operator tidak valid!")
```

---

## 🧪 PROYEK 2: PENGECEK NILAI SISWA

### 🎯 Tujuan:
Membuat program yang mengecek kelulusan dan memberikan predikat nilai.

### 🛠 Langkah:
1. Minta input nilai (0–100).
2. Cek apakah nilai valid (antara 0 dan 100).
3. Tampilkan status kelulusan dan predikat.

### ✅ Contoh Kode:
```python
print("=== PENGECEKAN NILAI SISWA ===")
nilai = float(input("Masukkan nilai Anda (0-100): "))

if nilai < 0 or nilai > 100:
    print("Nilai tidak valid! Harus antara 0 dan 100.")
else:
    if nilai >= 75:
        status = "Lulus"
    else:
        status = "Tidak Lulus"
    
    if nilai >= 90:
        predikat = "A"
    elif nilai >= 80:
        predikat = "B"
    elif nilai >= 70:
        predikat = "C"
    else:
        predikat = "D"
    
    print(f"Status: {status}")
    print(f"Predikat: {predikat}")
```

---

## 📚 RANGKUMAN KONSEP

| Konsep                     | Penjelasan                                               |
| -------------------------- | -------------------------------------------------------- |
| **Operasi Aritmatika**     | `+`, `-`, `*`, `/`, `//`, `%`, `**`                      |
| **Operator Perbandingan**  | `==`, `!=`, `>`, `<`, `>=`, `<=` → hasil `True`/`False`  |
| **Pernyataan Kondisional** | `if`, `elif`, `else` untuk kontrol alur program          |
| **Indentasi**              | Blok kode harus di-indent (4 spasi atau 1 tab)           |
| **Input Pengguna**         | Gunakan `input()` dan konversi ke `int()` atau `float()` |

---

## 🧠 TIPS BELAJAR
- Coba setiap kode di editor Python (seperti IDLE, Thonny, atau VS Code).
- Ubah nilai dan lihat bagaimana output berubah.
- Eksperimen: Tambahkan fitur seperti "ulangi program" atau "konversi suhu".

---

## 📝 PENILAIAN (Untuk Guru)

| Kriteria                        | Skor Maksimal |
| ------------------------------- | ------------- |
| Pemahaman operator aritmatika   | 20            |
| Penggunaan `if`, `elif`, `else` | 30            |
| Logika program dan alur         | 30            |
| Fungsi input dan output         | 20            |
| **Total**                       | **100**       |

---

## 📌 KESIMPULAN

Materi ini membentuk **fondasi logika pemrograman** yang sangat penting. Dengan menguasai operasi aritmatika dan pernyataan kondisional, siswa siap melangkah ke topik lebih lanjut seperti **perulangan (`for`, `while`)**, **fungsi**, dan **struktur data**.

> 💬 *"Programming is not about what you know; it’s about what you can do."*

---

## 📎 Lampiran: Template Tugas Siswa

```python
# Nama: [Isi Nama]
# Kelas: XI IPA/IPS
# Tanggal: ...

# Proyek 1: Kalkulator Sederhana
# Tulis kode di sini
```

---

Jika Anda ingin, saya bisa bantu membuat **PowerPoint**, **Lembar Kerja Siswa (LKS)**, atau **kuis online** berbasis materi ini. Beri tahu saja! 😊