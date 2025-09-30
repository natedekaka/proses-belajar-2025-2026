# **Materi Dasar Python: Struktur Kontrol Alur Program (Percabangan)**  
*Untuk Siswa SMA – Mata Pelajaran Informatika*

Dalam pemrograman, program tidak selalu berjalan dari atas ke bawah secara lurus. Terkadang, kita ingin program **mengambil keputusan** berdasarkan kondisi tertentu — misalnya, jika nilai siswa di atas 60, maka “Lulus”, jika tidak, maka “Tidak Lulus”.

Inilah yang disebut **kontrol alur program** atau **struktur percabangan**. Di Python, ada beberapa cara untuk mengatur alur program berdasarkan kondisi. Mari kita pelajari satu per satu!

---

## **1. Pernyataan `if`**
Pernyataan `if` digunakan untuk **menjalankan blok kode hanya jika kondisi bernilai `True`**.

### 🔹 Sintaks:
```python
if kondisi:
    # kode yang dijalankan jika kondisi benar
```

### 🔹 Contoh:
```python
angka = int(input("Masukkan angka: "))

if angka > 0:
    print("Angka positif")
if angka < 0:
    print("Angka negatif")
if angka == 0:
    print("Angka adalah 0")
```

> 💡 **Catatan Penting**:  
> - Setelah `if`, harus diikuti **titik dua (`:`)**.  
> - Kode di dalam blok `if` **harus di-indentasi** (diberi spasi di awal baris). Biasanya menggunakan **4 spasi** atau **1 tab**.

---

## **2. Pernyataan `if-else`**
Jika kita ingin menentukan **dua kemungkinan**:  
- Jika kondisi **benar**, jalankan kode A.  
- Jika kondisi **salah**, jalankan kode B.

### 🔹 Sintaks:
```python
if kondisi:
    # kode jika kondisi benar
else:
    # kode jika kondisi salah
```

### 🔹 Contoh:
```python
nilai = int(input("Masukkan nilai: "))

if nilai >= 60:
    print("Anda lulus")
else:
    print("Anda tidak lulus")
```

---

## **3. Pernyataan `elif` (Else If)**
Digunakan ketika ada **lebih dari dua kondisi** yang perlu dicek **secara berurutan**. Python akan berhenti mengecek begitu menemukan kondisi yang **benar**.

### 🔹 Sintaks:
```python
if kondisi1:
    # kode 1
elif kondisi2:
    # kode 2
elif kondisi3:
    # kode 3
else:
    # kode jika semua kondisi salah
```

### 🔹 Contoh:
```python
nilai = int(input("Masukkan nilai: "))

if nilai >= 90:
    print("Nilai A")
elif nilai >= 80:
    print("Nilai B")
elif nilai >= 70:
    print("Nilai C")
elif nilai >= 60:
    print("Nilai D")
else:
    print("Nilai E")
```

> ⚠️ **Perbedaan `if` vs `elif`**:  
> Jika menggunakan `if` berulang, **semua kondisi akan dicek**, meskipun salah satu sudah benar.  
> Dengan `elif`, **hanya satu blok** yang dijalankan — yang pertama kali bernilai `True`.

---

## **4. Operator Logika dalam Kondisi**
Kita bisa menggabungkan beberapa kondisi menggunakan **operator logika**:

| Operator | Arti  | Contoh Penggunaan                     |
| -------- | ----- | ------------------------------------- |
| `and`    | dan   | `umur >= 17 and punya_sim == "ya"`    |
| `or`     | atau  | `hari == "Sabtu" or hari == "Minggu"` |
| `not`    | bukan | `not (nilai < 0)`                     |

### 🔹 Contoh:
```python
umur = int(input("Masukkan umur: "))
punya_sim = input("Punya SIM? (ya/tidak): ")

if umur >= 17 and punya_sim == "ya":
    print("Boleh mengendarai motor")
else:
    print("Tidak boleh mengendarai motor")
```

---

## **5. Nested `if` (If Bersarang)**
Kita bisa menempatkan pernyataan `if` **di dalam** pernyataan `if` lainnya.

### 🔹 Contoh:
```python
username = input("Username: ")
password = input("Password: ")

if username == "admin":
    if password == "12345":
        print("Login berhasil")
        print("Selamat datang, admin!")
    else:
        print("Password salah")
else:
    print("Username tidak ditemukan")
```

> 💡 Indentasi sangat penting! Setiap `if` di dalam harus **lebih menjorok ke kanan**.

---

## **6. `match-case` (Alternatif Modern untuk Banyak Kondisi)**
Mulai Python 3.10, kita bisa menggunakan `match-case` sebagai pengganti `if-elif` yang panjang. Lebih rapi dan mudah dibaca!

### 🔹 Sintaks:
```python
match variabel:
    case nilai1 | nilai2:
        # kode
    case nilai3:
        # kode
    case _:
        # default (seperti else)
```

### 🔹 Contoh:
```python
hari = input("Masukkan nama hari: ").lower()

match hari:
    case "senin" | "selasa" | "rabu" | "kamis" | "jumat":
        print("Hari kerja")
    case "sabtu" | "minggu":
        print("Hari libur")
    case _:
        print("Nama hari tidak valid")
```

> ✅ Lebih ringkas daripada menulis banyak `or` di `if`!

---

## **7. Conditional Expression (Ternary Operator)**
Untuk kondisi **sederhana**, kita bisa menulis `if-else` dalam **satu baris**!

### 🔹 Sintaks:
```python
variabel = nilai_jika_benar if kondisi else nilai_jika_salah
```

### 🔹 Contoh:
```python
angka = int(input("Masukkan angka: "))
hasil = "positif" if angka > 0 else "negatif atau nol"
print("Hasil:", hasil)
```

> 💡 Sangat berguna untuk menghemat baris kode saat hanya menetapkan nilai berdasarkan kondisi.

---

## **Kesimpulan**
Struktur kontrol alur program memungkinkan program kita **berpikir dan mengambil keputusan**, seperti manusia! Dengan memahami:

- `if`, `if-else`, `elif`
- Operator logika (`and`, `or`, `not`)
- `nested if`
- `match-case`
- Ternary operator

Kamu sudah siap membuat program Python yang **interaktif dan cerdas**!

---

## **Latihan untuk Siswa**
1. Buat program yang menentukan apakah seseorang boleh menonton film berdasarkan usia (misal: usia ≥ 13).
2. Buat kalkulator sederhana yang memilih operasi berdasarkan input pengguna (`+`, `-`, `*`, `/`) menggunakan `match-case`.
3. Gunakan ternary operator untuk menentukan apakah bilangan genap atau ganjil.

---

> 📌 **Tips**: Selalu perhatikan **indentasi** dan **titik dua (`:`)**. Kesalahan kecil di sini bisa membuat program error!

---

