# Struktur Data Python untuk Pemula: Panduan Lengkap SMA Informatika

**Tujuan Pembelajaran:**
Setelah mempelajari materi ini, siswa diharapkan mampu:
1. Memahami konsep struktur data dalam Python
2. Membedakan berbagai jenis struktur data (list, tuple, dictionary, set)
3. Membuat dan mengoperasikan setiap struktur data
4. Memilih struktur data yang tepat sesuai kebutuhan
5. Menerapkan struktur data dalam penyelesaian masalah pemrograman

## Apa itu Struktur Data?

Struktur data adalah cara untuk menyimpan dan mengorganisir data dalam program. Sejauh ini, kita sudah belajar menyimpan satu nilai dalam variabel. Sekarang, kita akan belajar cara menyimpan banyak data sekaligus dalam satu variabel menggunakan struktur data.

Bayangkan Anda memiliki banyak buku dan perlu menyusunnya di rak. Anda bisa menyusunnya berdasarkan warna, ukuran, atau abjad. Struktur data dalam pemrograman bekerja serupa - mereka membantu kita menyimpan dan mengatur data dengan cara tertentu.

Dalam Python, ada beberapa struktur data utama yang akan kita pelajari:
1. List (Daftar)
2. Tuple (Pasangan)
3. Dictionary (Kamus)
4. Set (Himpunan)

Mari kita bahas satu per satu!

## 1. List (Daftar)

### Apa itu List?
List adalah kumpulan data yang bisa menyimpan banyak nilai dalam satu variabel. List bersifat **ubah** (mutable), artinya kita bisa mengubah, menambah, atau menghapus elemen di dalamnya setelah list dibuat.

List ditulis menggunakan kurung siku `[]` dan elemen-elemennya dipisahkan dengan tanda koma.

### Membuat List
```python
# List kosong
daftar_kosong = []

# List dengan angka
angka = [1, 2, 3, 4, 5, 6]

# List dengan string
nama = ["Eko", "Budi", "Joko"]

# List dengan tipe data campuran
campuran = ["Eko", 25, "Budi", 30]
```

### Mengakses Elemen List
Setiap elemen dalam list memiliki indeks yang dimulai dari 0. Kita bisa mengakses elemen menggunakan indeks tersebut.

```python
buah = ["apel", "jeruk", "pisang", "mangga"]

# Mengakses elemen pertama
print(buah[0])  # Output: apel

# Mengakses elemen ketiga
print(buah[2])  # Output: pisang
```

### Mengubah Elemen List
Kita bisa mengubah nilai elemen list dengan menggunakan indeks.

```python
warna = ["merah", "biru", "hijau"]
print(warna)  # Output: ['merah', 'biru', 'hijau']

# Mengubah elemen kedua
warna[1] = "kuning"
print(warna)  # Output: ['merah', 'kuning', 'hijau']
```

### Menambah Elemen ke List
Ada beberapa cara untuk menambah elemen ke list:

1. **append()**: Menambah elemen di akhir list
```python
buah = ["apel", "jeruk"]
buah.append("durian")
print(buah)  # Output: ['apel', 'jeruk', 'durian']
```

2. **insert()**: Menyisipkan elemen di posisi tertentu
```python
buah = ["apel", "jeruk", "durian"]
buah.insert(1, "buah naga")
print(buah)  # Output: ['apel', 'buah naga', 'jeruk', 'durian']
```

### Menghapus Elemen dari List
Ada beberapa cara untuk menghapus elemen dari list:

1. **remove()**: Menghapus elemen berdasarkan nilai
```python
buah = ["apel", "buah naga", "jeruk", "durian"]
buah.remove("jeruk")
print(buah)  # Output: ['apel', 'buah naga', 'durian']
```

2. **pop()**: Menghapus elemen terakhir
```python
buah = ["apel", "buah naga", "durian"]
buah.pop()
print(buah)  # Output: ['apel', 'buah naga']
```

3. **del**: Menghapus elemen berdasarkan indeks
```python
buah = ["apel", "buah naga"]
del buah[0]
print(buah)  # Output: ['buah naga']
```

### Menggabungkan List
Kita bisa menggabungkan dua list dengan operator `+`.

```python
list1 = [1, 2, 3, 4, 5]
list2 = [6, 7, 8, 9, 10]
gabungan = list1 + list2
print(gabungan)  # Output: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
```

### Menghitung Panjang List
Kita bisa menggunakan fungsi `len()` untuk menghitung jumlah elemen dalam list.

```python
buah = ["apel", "jeruk", "mangga"]
print(len(buah))  # Output: 3
```

### Iterasi pada List
Kita bisa menggunakan perulangan `for` untuk mengakses setiap elemen dalam list.

```python
buah = ["apel", "jeruk", "mangga", "durian"]
for b in buah:
    print(b)
```

Output:
```
apel
jeruk
mangga
durian
```

### Mengecek Keanggotaan dalam List
Kita bisa menggunakan `in` untuk mengecek apakah suatu elemen ada dalam list.

```python
buah = ["apel", "jeruk", "mangga", "durian"]
if "apel" in buah:
    print("Ada apel dalam list buah")
else:
    print("Tidak ada apel dalam list buah")

if "salak" in buah:
    print("Ada salak dalam list buah")
else:
    print("Tidak ada salak dalam list buah")
```

Output:
```
Ada apel dalam list buah
Tidak ada salak dalam list buah
```

## 2. Tuple (Pasangan)

### Apa itu Tuple?
Tuple mirip dengan list, tetapi **tidak bisa diubah** (immutable) setelah dibuat. Artinya, kita tidak bisa menambah, mengubah, atau menghapus elemen tuple setelah tuple dibuat.

Tuple ditulis menggunakan kurung biasa `()` dan elemen-elemennya dipisahkan dengan tanda koma.

### Membuat Tuple
```python
# Tuple kosong
tuple_kosong = ()

# Tuple dengan angka
angka = (5, 10)

# Tuple dengan berbagai tipe data
tanggal_lahir = (10, 8, 1990)  # (tanggal, bulan, tahun)
```

### Mengakses Elemen Tuple
Sama seperti list, kita bisa mengakses elemen tuple menggunakan indeks yang dimulai dari 0.

```python
poin = (5, 10)
print(poin[0])  # Output: 5
print(poin[1])  # Output: 10

tanggal_lahir = (10, 8, 1990)
print(tanggal_lahir[0])  # Output: 10
print(tanggal_lahir[1])  # Output: 8
print(tanggal_lahir[2])  # Output: 1990
```

### Iterasi pada Tuple
Kita bisa menggunakan perulangan `for` untuk mengakses setiap elemen dalam tuple.

```python
tanggal_lahir = (10, 8, 1990)
for x in tanggal_lahir:
    print(x)
```

Output:
```
10
8
1990
```

### Menghitung Panjang Tuple
Kita bisa menggunakan fungsi `len()` untuk menghitung jumlah elemen dalam tuple.

```python
tanggal_lahir = (10, 8, 1990)
print(len(tanggal_lahir))  # Output: 3
```

## 3. Dictionary (Kamus)

### Apa itu Dictionary?
Dictionary digunakan untuk menyimpan data dalam pasangan **key** (kunci) dan **value** (nilai). Berbeda dengan list yang menggunakan indeks numerik (0, 1, 2, ...), dictionary menggunakan key yang bisa berupa berbagai tipe data (biasanya string).

Dictionary ditulis menggunakan kurung kurawal `{}` dengan format `key: value` dan setiap pasangan dipisahkan dengan tanda koma.

### Membuat Dictionary
```python
# Dictionary kosong
siswa = {}

# Dictionary dengan data
siswa = {
    "nama": "Eko",
    "umur": 17,
    "kelas": "15A"
}
```

### Mengakses Nilai dalam Dictionary
Kita bisa mengakses nilai dalam dictionary menggunakan key-nya.

```python
siswa = {
    "nama": "Eko",
    "umur": 17,
    "kelas": "15A"
}

print(siswa["nama"])   # Output: Eko
print(siswa["umur"])   # Output: 17
print(siswa["kelas"])  # Output: 15A
```

### Mengubah Nilai dalam Dictionary
Kita bisa mengubah nilai dalam dictionary dengan menggunakan key-nya.

```python
siswa = {
    "nama": "Eko",
    "umur": 17,
    "kelas": "15A"
}

print(siswa)  # Output: {'nama': 'Eko', 'umur': 17, 'kelas': '15A'}

# Mengubah nilai kelas
siswa["kelas"] = "15B"
print(siswa)  # Output: {'nama': 'Eko', 'umur': 17, 'kelas': '15B'}
```

### Menghapus Elemen dari Dictionary
Kita bisa menggunakan `del` untuk menghapus elemen dari dictionary.

```python
siswa = {
    "nama": "Eko",
    "umur": 17,
    "kelas": "15B"
}

print(siswa)  # Output: {'nama': 'Eko', 'umur': 17, 'kelas': '15B'}

# Menghapus elemen dengan key 'umur'
del siswa["umur"]
print(siswa)  # Output: {'nama': 'Eko', 'kelas': '15B'}
```

### Iterasi pada Dictionary
Ada beberapa cara untuk melakukan iterasi pada dictionary:

1. **Iterasi untuk mendapatkan key saja:**
```python
siswa = {
    "nama": "Eko",
    "kelas": "15B"
}

for key in siswa:
    print(key)
```

Output:
```
nama
kelas
```

2. **Iterasi untuk mendapatkan key dan value:**
```python
siswa = {
    "nama": "Eko",
    "kelas": "15B"
}

for key, value in siswa.items():
    print(key, ":", value)
```

Output:
```
nama : Eko
kelas : 15B
```

### Menghitung Panjang Dictionary
Kita bisa menggunakan fungsi `len()` untuk menghitung jumlah pasangan key-value dalam dictionary.

```python
siswa = {
    "nama": "Eko",
    "kelas": "15B"
}
print(len(siswa))  # Output: 2
```

## 4. Set (Himpunan)

### Apa itu Set?
Set adalah kumpulan data yang **tidak berurutan** dan **tidak memiliki elemen duplikat**. Artinya, setiap elemen dalam set harus unik.

Set ditulis menggunakan kurung kurawal `{}` atau dengan fungsi `set()`.

### Membuat Set
```python
# Set kosong
buah = set()  # Perhatikan: {} akan membuat dictionary kosong, bukan set

# Set dengan elemen
buah = {"apel", "jeruk", "pisang"}
```

### Menambah Elemen ke Set
Kita bisa menggunakan metode `add()` untuk menambah elemen ke set.

```python
buah = {"apel", "jeruk", "pisang"}
print(buah)  # Output bisa berupa: {'apel', 'pisang', 'jeruk'} (tidak berurutan)

buah.add("mangga")
print(buah)  # Output bisa berupa: {'apel', 'pisang', 'jeruk', 'mangga'}

# Menambah elemen yang sudah ada tidak akan mengubah set
buah.add("mangga")
print(buah)  # Output tetap sama karena 'mangga' sudah ada
```

### Menghapus Elemen dari Set
Kita bisa menggunakan metode `remove()` untuk menghapus elemen dari set.

```python
buah = {"apel", "pisang", "jeruk", "mangga"}
print(buah)  # Output bisa berupa: {'apel', 'pisang', 'jeruk', 'mangga'}

buah.remove("jeruk")
print(buah)  # Output bisa berupa: {'apel', 'pisang', 'mangga'}
```

### Iterasi pada Set
Kita bisa menggunakan perulangan `for` untuk mengakses setiap elemen dalam set.

```python
buah = {"apel", "pisang", "mangga"}
for b in buah:
    print(b)
```

Output (bisa berbeda karena tidak berurutan):
```
apel
pisang
mangga
```

### Menghitung Panjang Set
Kita bisa menggunakan fungsi `len()` untuk menghitung jumlah elemen dalam set.

```python
buah = {"apel", "pisang", "mangga"}
print(len(buah))  # Output: 3
```

## Perbandingan Struktur Data

| Struktur Data | Urutan | Dapat Diubah | Duplikat            | Penggunaan Umum                |
| ------------- | ------ | ------------ | ------------------- | ------------------------------ |
| List          | Ya     | Ya           | Ya                  | Koleksi item yang perlu diubah |
| Tuple         | Ya     | Tidak        | Ya                  | Data yang tidak boleh berubah  |
| Dictionary    | Tidak  | Ya           | Key tidak, Value ya | Pasangan key-value             |
| Set           | Tidak  | Ya           | Tidak               | Koleksi item unik              |

## Contoh Latihan dan Jawaban

### Latihan 1: List
**Soal:**
Buat program yang:
1. Membuat list kosong bernama `mata_pelajaran`
2. Menambahkan 3 mata pelajaran favorit Anda menggunakan `append()`
3. Menambahkan 1 mata pelajaran di posisi kedua menggunakan `insert()`
4. Menghapus mata pelajaran terakhir menggunakan `pop()`
5. Menghitung jumlah mata pelajaran dalam list
6. Menampilkan semua mata pelajaran menggunakan perulangan

**Jawaban:**
```python
# 1. Membuat list kosong
mata_pelajaran = []

# 2. Menambahkan 3 mata pelajaran favorit
mata_pelajaran.append("Matematika")
mata_pelajaran.append("Fisika")
mata_pelajaran.append("Kimia")
print("Setelah append:", mata_pelajaran)

# 3. Menambahkan 1 mata pelajaran di posisi kedua
mata_pelajaran.insert(1, "Biologi")
print("Setelah insert:", mata_pelajaran)

# 4. Menghapus mata pelajaran terakhir
mata_pelajaran.pop()
print("Setelah pop:", mata_pelajaran)

# 5. Menghitung jumlah mata pelajaran
jumlah = len(mata_pelajaran)
print("Jumlah mata pelajaran:", jumlah)

# 6. Menampilkan semua mata pelajaran
print("Daftar mata pelajaran:")
for mp in mata_pelajaran:
    print("-", mp)
```

### Latihan 2: Tuple
**Soal:**
Buat program yang:
1. Membuat tuple untuk menyimpan data tanggal, bulan, dan tahun lahir Anda
2. Menampilkan tanggal lahir dalam format "tanggal/bulan/tahun"
3. Menghitung umur Anda (asumsikan tahun sekarang adalah 2023)

**Jawaban:**
```python
# 1. Membuat tuple tanggal lahir
tanggal_lahir = (15, 8, 2005)  # Contoh: 15 Agustus 2005

# 2. Menampilkan tanggal lahir dalam format "tanggal/bulan/tahun"
print(f"Tanggal lahir: {tanggal_lahir[0]}/{tanggal_lahir[1]}/{tanggal_lahir[2]}")

# 3. Menghitung umur
tahun_sekarang = 2023
umur = tahun_sekarang - tanggal_lahir[2]
print(f"Umur Anda: {umur} tahun")
```

### Latihan 3: Dictionary
**Soal:**
Buat program yang:
1. Membuat dictionary untuk menyimpan data diri (nama, umur, kelas, hobi)
2. Menambahkan key "alamat" dengan value sesuai dengan alamat Anda
3. Mengubah value dari key "kelas" menjadi kelas Anda sekarang
4. Menghapus key "hobi"
5. Menampilkan semua data diri Anda menggunakan perulangan

**Jawaban:**
```python
# 1. Membuat dictionary data diri
data_diri = {
    "nama": "Ahmad",
    "umur": 16,
    "kelas": "XI IPA 1",
    "hobi": "Bermain game"
}

# 2. Menambahkan key "alamat"
data_diri["alamat"] = "Jakarta"
print("Setelah menambah alamat:", data_diri)

# 3. Mengubah value dari key "kelas"
data_diri["kelas"] = "XII IPA 2"
print("Setelah mengubah kelas:", data_diri)

# 4. Menghapus key "hobi"
del data_diri["hobi"]
print("Setelah menghapus hobi:", data_diri)

# 5. Menampilkan semua data diri
print("\nData diri:")
for key, value in data_diri.items():
    print(f"{key}: {value}")
```

### Latihan 4: Set
**Soal:**
Buat program yang:
1. Membuat set berisi nama-nama buah yang Anda suka
2. Menambahkan 2 buah baru ke dalam set
3. Mencoba menambahkan buah yang sudah ada dalam set
4. Menghapus salah satu buah dari set
5. Menampilkan semua buah dalam set menggunakan perulangan

**Jawaban:**
```python
# 1. Membuat set nama buah
buah = {"apel", "jeruk", "mangga"}
print("Set awal:", buah)

# 2. Menambahkan 2 buah baru
buah.add("pisang")
buah.add("anggur")
print("Setelah menambah 2 buah:", buah)

# 3. Menambahkan buah yang sudah ada
buah.add("apel")  # Tidak akan menambah duplikat
print("Setelah mencoba menambah apel lagi:", buah)

# 4. Menghapus salah satu buah
buah.remove("jeruk")
print("Setelah menghapus jeruk:", buah)

# 5. Menampilkan semua buah
print("\nDaftar buah:")
for b in buah:
    print("-", b)
```

## Kesimpulan

Struktur data adalah konsep fundamental dalam pemrograman Python yang memungkinkan kita menyimpan dan mengorganisir data dengan efisien. Kita telah mempelajari empat struktur data utama dalam Python:

1. **List**: Koleksi item yang terurut dan dapat diubah. Sangat fleksibel dan sering digunakan untuk menyimpan sekumpulan item yang mungkin berubah.
2. **Tuple**: Koleksi item yang terurut tetapi tidak dapat diubah. Berguna untuk data yang tidak boleh berubah setelah dibuat.
3. **Dictionary**: Koleksi pasangan key-value yang tidak terurut. Sangat berguna untuk menyimpan data dengan label atau kunci.
4. **Set**: Koleksi item unik yang tidak terurutan. Berguna untuk operasi himpunan dan memastikan tidak ada duplikasi.

Memilih struktur data yang tepat sangat penting untuk efisiensi program. Dengan memahami karakteristik masing-masing struktur data, Anda bisa membuat program yang lebih efisien dan terorganisir.

Teruslah berlatih dengan mencoba berbagai contoh dan eksperimen sendiri. Semakin sering Anda menggunakan struktur data ini, semakin mudah Anda memahaminya!

Semoga materi ini bermanfaat untuk pembelajaran Informatika Anda. Jika ada pertanyaan, jangan ragu untuk bertanya kepada guru Anda!