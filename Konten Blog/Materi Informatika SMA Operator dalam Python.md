

# **Materi Informatika SMA: Operator dalam Python**

## **Pengantar**

Dalam pemrograman Python, **operator** adalah simbol khusus yang digunakan untuk melakukan operasi terhadap variabel dan nilai. Operator memungkinkan kita memanipulasi data, membandingkan nilai, menggabungkan teks, dan membuat keputusan logis dalam program. Python menyediakan berbagai jenis operator yang akan kita pelajari secara bertahap.

## **1. Operator Aritmatika**

Operator aritmatika digunakan untuk melakukan perhitungan matematika dasar.

| Operator | Nama                | Contoh    | Hasil      |
| -------- | ------------------- | --------- | ---------- |
| `+`      | Penjumlahan         | `10 + 3`  | `13`       |
| `-`      | Pengurangan         | `10 - 3`  | `7`        |
| `*`      | Perkalian           | `10 * 3`  | `30`       |
| `/`      | Pembagian (desimal) | `10 / 3`  | `3.333...` |
| `//`     | Pembagian Bulat     | `10 // 3` | `3`        |
| `%`      | Modulo (sisa bagi)  | `10 % 3`  | `1`        |
| `**`     | Pangkat             | `2 ** 3`  | `8`        |

> **Catatan:**  
>
> - Pembagian bulat (`//`) menghasilkan bilangan bulat tanpa desimal.  
> - Modulo (`%`) menghasilkan sisa dari operasi pembagian.

**Contoh program:**
```python
a = 10
b = 3
print(a + b)   # 13
print(a // b)  # 3
print(a % b)   # 1
print(2 ** 3)  # 8
```

## **2. Operator Assignment (Penugasan)**

Operator ini digunakan untuk memberikan nilai ke variabel.

- Operator dasar: `=`
  ```python
  x = 10
  ```

- **Compound assignment** menggabungkan operasi aritmatika dengan penugasan:

| Operator | Contoh   | Arti        |
| -------- | -------- | ----------- |
| `+=`     | `x += 5` | `x = x + 5` |
| `-=`     | `x -= 3` | `x = x - 3` |
| `*=`     | `x *= 2` | `x = x * 2` |
| `/=`     | `x /= 4` | `x = x / 4` |

**Contoh program:**
```python
x = 10
print(x)      # 10
x += 5
print(x)      # 15
x -= 3
print(x)      # 12
```

## **3. Operator Perbandingan**

Operator perbandingan membandingkan dua nilai dan menghasilkan nilai **boolean** (`True` atau `False`).

| Operator | Arti                  | Contoh   | Hasil   |
| -------- | --------------------- | -------- | ------- |
| `==`     | Sama dengan           | `5 == 5` | `True`  |
| `!=`     | Tidak sama dengan     | `5 != 3` | `True`  |
| `>`      | Lebih besar dari      | `5 > 3`  | `True`  |
| `<`      | Lebih kecil dari      | `5 < 3`  | `False` |
| `>=`     | Lebih besar atau sama | `5 >= 5` | `True`  |
| `<=`     | Lebih kecil atau sama | `4 <= 3` | `False` |

> **Untuk tipe data string**, hanya operator `==` dan `!=` yang relevan, karena teks tidak bisa dibandingkan secara numerik (misalnya “lebih besar dari”).

**Contoh program:**
```python
nama1 = "Eko"
nama2 = "Joko"
print(nama1 == nama2)  # False
print(nama1 != nama2)  # True
```

## **4. Operator Logika**

Digunakan untuk menggabungkan atau membalik nilai boolean.

| Operator | Nama  | Aturan                                                     |
| -------- | ----- | ---------------------------------------------------------- |
| `and`    | Dan   | Hasil `True` hanya jika **kedua** kondisi bernilai `True`  |
| `or`     | Atau  | Hasil `True` jika **salah satu** kondisi bernilai `True`   |
| `not`    | Bukan | Membalik nilai: `not True` → `False`, `not False` → `True` |

**Contoh program:**
```python
umur = 25
print(umur > 18 and umur < 30)  # True

hari = "Sabtu"
print(hari == "Sabtu" or hari == "Minggu")  # True

aktif = True
print(not aktif)  # False
```

## **5. Operator String**

Operator khusus yang bekerja pada data teks (string).

| Operator | Fungsi                   | Contoh              | Hasil          |
| -------- | ------------------------ | ------------------- | -------------- |
| `+`      | Menggabungkan string     | `"Halo" + " Dunia"` | `"Halo Dunia"` |
| `*`      | Mengulang string         | `"A" * 3`           | `"AAA"`        |
| `in`     | Mengecek keberadaan teks | `"Py" in "Python"`  | `True`         |

**Contoh program:**
```python
depan = "Rina"
belakang = "Wijaya"
lengkap = depan + " " + belakang
print(lengkap)  # Rina Wijaya

print("o" in "Python")  # True
print("-" * 10)        # ----------
```

## **6. Prioritas Operator (Operator Precedence)**

Saat sebuah ekspresi mengandung beberapa operator, Python memiliki aturan urutan pengerjaan:

**Urutan prioritas (dari tertinggi ke terendah):**

1. `**` → pangkat  
2. `*`, `/`, `//`, `%` → perkalian & pembagian  
3. `+`, `-` → penjumlahan & pengurangan  
4. Operator perbandingan (`==`, `!=`, `>`, `<`, dll)  
5. `not`  
6. `and`  
7. `or`

**Contoh:**
```python
hasil = 5 + 3 * 2  # 3*2 dikerjakan dulu → 5 + 6 = 11
print(hasil)  # 11
```

> **Tips:** Gunakan tanda kurung `()` untuk mengatur urutan secara eksplisit jika diperlukan.

## **Refleksi & Latihan**

1. Buat program yang menghitung sisa bagi dari dua bilangan menggunakan operator modulo.  
2. Gunakan operator perbandingan dan logika untuk menentukan apakah seseorang boleh menonton film (usia ≥ 17).  
3. Gabungkan nama depan dan belakang, lalu ulangi hasilnya dua kali menggunakan operator string.

## **Penutup**

Memahami operator dalam Python adalah langkah penting dalam membangun logika pemrograman. Dengan menguasai operator aritmatika, assignment, perbandingan, logika, dan string — serta aturan prioritasnya — kalian telah memiliki fondasi yang kuat untuk membuat program yang lebih interaktif dan bermanfaat.

Terus berlatih, eksplorasi, dan jangan takut mencoba!


