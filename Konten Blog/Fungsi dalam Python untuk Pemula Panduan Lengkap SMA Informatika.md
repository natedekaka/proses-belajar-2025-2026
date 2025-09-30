# Fungsi dalam Python untuk Pemula: Panduan Lengkap SMA Informatika

**Tujuan Pembelajaran:**
Setelah mempelajari materi ini, siswa diharapkan mampu:
1. Memahami konsep fungsi dalam pemrograman Python
2. Membuat fungsi sederhana dengan parameter dan return value
3. Membedakan local dan global variabel
4. Menggunakan default parameter dan keyword argument
5. Menerapkan parameter dinamis (*args dan **kwargs)
6. Menerapkan fungsi dalam penyelesaian masalah

## Apa itu Fungsi?

Fungsi (function) adalah blok kode yang dapat digunakan berulang-ulang. Fungsi membantu kita menulis kode yang lebih terorganisir, mudah dibaca, dan mudah dipelihara. Dengan menggunakan fungsi, kita tidak perlu menuliskan kode yang sama berulang-ulang.

**Analogi Sederhana:** Bayangkan fungsi seperti resep masakan. Anda bisa membuat resep "nasi goreng" sekali, lalu menggunakannya berkali-kali untuk membuat nasi goreng yang sama dengan bahan yang mungkin berbeda-beda.

Sebelumnya, Anda sudah menggunakan fungsi bawaan Python seperti `print()`, `len()`, dan metode-metode dari string atau list. Sekarang kita akan belajar membuat fungsi sendiri!

## Membuat Fungsi Sederhana

### Sintaks Dasar
```python
def nama_fungsi():
    # Kode fungsi di sini
    # Harus ada indentasi (spasi di awal)
```

**Penjelasan:**
- `def`: Kata kunci untuk mendefinisikan fungsi
- `nama_fungsi`: Nama fungsi (gunakan snake_case: huruf kecil dan underscore)
- `()`: Tempat parameter (kosong untuk fungsi tanpa parameter)
- `:`: Tanda titik dua menandakan awal blok kode fungsi
- Indentasi: Spasi di awal baris (biasanya 4 spasi) untuk menandakan kode milik fungsi

### Contoh Fungsi Sederhana
```python
def sapa():
    print("Halo dari fungsi!")
    print("Senang belajar Python")
```

### Memanggil Fungsi
Untuk menggunakan fungsi, kita panggil namanya diikuti tanda kurung:
```python
# Memanggil fungsi
sapa()  # Output: Halo dari fungsi! \n Senang belajar Python

# Memanggil berkali-kali
sapa()  # Output: Halo dari fungsi! \n Senang belajar Python
sapa()  # Output: Halo dari fungsi! \n Senang belajar Python
```

## Fungsi dengan Parameter

Parameter adalah data yang kita kirim ke fungsi untuk diolah. Parameter memungkinkan fungsi bekerja dengan data yang berbeda-beda.

### Sintaks dengan Parameter
```python
def nama_fungsi(parameter1, parameter2):
    # Kode fungsi yang menggunakan parameter
```

### Contoh Fungsi dengan Parameter
```python
def sapa_nama(nama):
    print(f"Halo {nama}!")
    print("Senang bertemu dengan Anda")

# Memanggil fungsi dengan argumen
sapa_nama("Ali")   # Output: Halo Ali! \n Senang bertemu dengan Anda
sapa_nama("Budi")  # Output: Halo Budi! \n Senang bertemu dengan Anda
```

### Fungsi dengan Beberapa Parameter
```python
def hitung_luas_persegi_panjang(panjang, lebar):
    luas = panjang * lebar
    print(f"Luas persegi panjang: {luas}")

# Memanggil fungsi dengan beberapa argumen
hitung_luas_persegi_panjang(10, 5)  # Output: Luas persegi panjang: 50
hitung_luas_persegi_panjang(8, 4)   # Output: Luas persegi panjang: 32
```

**Penting:** Urutan argumen harus sesuai dengan urutan parameter!

## Fungsi dengan Return Value

Kadang kita ingin fungsi mengembalikan nilai hasil perhitungan untuk digunakan di bagian lain program. Untuk ini, kita gunakan kata kunci `return`.

### Sintaks dengan Return
```python
def nama_fungsi(parameter):
    # Proses perhitungan
    return hasil  # Nilai yang dikembalikan
```

### Contoh Fungsi dengan Return
```python
def hitung_luas_lingkaran(radius):
    pi = 3.14159
    luas = pi * radius * radius
    return luas

# Menyimpan hasil return ke variabel
luas1 = hitung_luas_lingkaran(5)
print(f"Luas lingkaran radius 5: {luas1}")  # Output: Luas lingkaran radius 5: 78.53975

luas2 = hitung_luas_lingkaran(10)
print(f"Luas lingkaran radius 10: {luas2}")  # Output: Luas lingkaran radius 10: 314.159
```

**Perbedaan `print` dan `return`:**
- `print`: Menampilkan nilai ke layar (tidak bisa disimpan)
- `return`: Mengembalikan nilai yang bisa disimpan di variabel

## Default Parameter

Default parameter adalah nilai awal untuk parameter yang membuat parameter tersebut opsional (tidak wajib diisi saat pemanggilan fungsi).

### Aturan Default Parameter:
1. Default parameter harus diletakkan setelah parameter biasa
2. Ditulis dengan format `parameter=nilai_awal`

### Contoh Default Parameter
```python
def sapa(nama, sapaan="Halo"):
    print(f"{sapaan} {nama}!")

# Memanggil tanpa mengisi default parameter
sapa("Ali")  # Output: Halo Ali!

# Memanggil dengan mengubah default parameter
sapa("Budi", "Selamat pagi")  # Output: Selamat pagi Budi!
sapa("Citra", "Hi")  # Output: Hi Citra!
```

## Keyword Argument

Keyword argument memungkinkan kita memanggil fungsi dengan menyebutkan nama parameter, sehingga urutan tidak harus sama.

### Contoh Keyword Argument
```python
def buat_profil(nama, umur, kota):
    print(f"Profil: {nama}, {umur} tahun, tinggal di {kota}")

# Pemanggilan biasa (urutan harus sesuai)
buat_profil("Doni", 17, "Jakarta")

# Pemanggilan dengan keyword argument (urutan bebas)
buat_profil(nama="Eka", kota="Bandung", umur=16)
buat_profil(umur=18, nama="Fajar", kota="Surabaya")
```

## Local vs Global Variabel

### Local Variabel
Variabel yang dideklarasikan di dalam fungsi. Hanya bisa diakses di dalam fungsi tersebut.

```python
def fungsi_test():
    x = 10  # Local variabel
    print(f"Nilai x di dalam fungsi: {x}")

fungsi_test()  # Output: Nilai x di dalam fungsi: 10

# Error: x tidak dikenal di luar fungsi
print(x)  # NameError: name 'x' is not defined
```

### Global Variabel
Variabel yang dideklarasikan di luar fungsi. Bisa diakses di dalam fungsi, tapi untuk mengubahnya harus menggunakan kata kunci `global`.

```python
nama_global = "Ali"  # Global variabel

def tampilkan_nama():
    print(f"Nama: {nama_global}")  # Bisa mengakses global variabel

tampilkan_nama()  # Output: Nama: Ali

def ubah_nama():
    global nama_global  # Wajib untuk mengubah global variabel
    nama_global = "Budi"

ubah_nama()
print(f"Nama setelah diubah: {nama_global}")  # Output: Nama setelah diubah: Budi
```

**Perbandingan Local dan Global Variabel:**

| Karakteristik | Local Variabel           | Global Variabel         |
| ------------- | ------------------------ | ----------------------- |
| Deklarasi     | Di dalam fungsi          | Di luar fungsi          |
| Akses         | Hanya di dalam fungsi    | Di mana saja            |
| Pengubahan    | Langsung di dalam fungsi | Harus pakai `global`    |
| Masa hidup    | Selama fungsi berjalan   | Selama program berjalan |

## Parameter Dinamis

Python mendukung parameter dinamis yang memungkinkan fungsi menerima jumlah argumen yang tidak tetap.

### *args (Argumen Posisisional Dinamis)
Mengumpulkan semua argumen posisional menjadi sebuah tuple.

```python
def cetak_list(*args):
    print("Data yang diterima:")
    for item in args:
        print(item, end=" ")
    print()  # Baris baru

# Bisa menerima berbagai jumlah argumen
cetak_list(1, 2, 3)  # Output: Data yang diterima: 1 2 3 
cetak_list("apel", "jeruk", "mangga", "pisang")  # Output: Data yang diterima: apel jeruk mangga pisang
```

### **kwargs (Argumen Keyword Dinamis)
Mengumpulkan semua argumen keyword menjadi sebuah dictionary.

```python
def cetak_dictionary(**kwargs):
    print("Data yang diterima:")
    for key, value in kwargs.items():
        print(f"{key}: {value}")

# Bisa menerima berbagai jumlah keyword argument
cetak_dictionary(nama="Ali", umur=17, kota="Jakarta")
# Output:
# Data yang diterima:
# nama: Ali
# umur: 17
# kota: Jakarta

cetak_dictionary(mata_pelajaran="Matematika", guru="Budi S.Pd", sks=4)
# Output:
# Data yang diterima:
# mata_pelajaran: Matematika
# guru: Budi S.Pd
# sks: 4
```

## Contoh Latihan dan Jawaban

### Latihan 1: Fungsi Sederhana
**Soal:**
Buat fungsi `hitung_keliling_segitiga()` yang menghitung keliling segitiga dengan parameter sisi1, sisi2, dan sisi3. Tampilkan hasilnya dengan print.

**Jawaban:**
```python
def hitung_keliling_segitiga(sisi1, sisi2, sisi3):
    keliling = sisi1 + sisi2 + sisi3
    print(f"Keliling segitiga: {keliling}")

# Pemanggilan fungsi
hitung_keliling_segitiga(3, 4, 5)  # Output: Keliling segitiga: 12
hitung_keliling_segitiga(5, 12, 13)  # Output: Keliling segitiga: 30
```

### Latihan 2: Fungsi dengan Return
**Soal:**
Buat fungsi `konversi_celcius_ke_fahrenheit()` yang menerima parameter suhu dalam Celcius dan mengembalikan suhu dalam Fahrenheit. Rumus: F = (C × 9/5) + 32

**Jawaban:**
```python
def konversi_celcius_ke_fahrenheit(celcius):
    fahrenheit = (celcius * 9/5) + 32
    return fahrenheit

# Menggunakan hasil return
suhu_f = konversi_celcius_ke_fahrenheit(0)
print(f"0°C = {suhu_f}°F")  # Output: 0°C = 32.0°F

suhu_f = konversi_celcius_ke_fahrenheit(100)
print(f"100°C = {suhu_f}°F")  # Output: 100°C = 212.0°F
```

### Latihan 3: Default Parameter dan Keyword Argument
**Soal:**
Buat fungsi `daftar_barang()` dengan parameter:
- `nama` (wajib)
- `jumlah` (default: 1)
- `harga` (default: 0)
- `diskon` (default: 0)

Fungsi menghitung total harga = (jumlah × harga) × (100 - diskon) / 100 dan menampilkan hasilnya.

**Jawaban:**
```python
def daftar_barang(nama, jumlah=1, harga=0, diskon=0):
    total = (jumlah * harga) * (100 - diskon) / 100
    print(f"Barang: {nama}")
    print(f"Jumlah: {jumlah}")
    print(f"Harga per item: Rp{harga}")
    print(f"Diskon: {diskon}%")
    print(f"Total harga: Rp{total:.2f}")
    print("-" * 30)

# Pemanggilan dengan berbagai cara
daftar_barang("Pensil", 10, 2000, 10)
daftar_barang("Buku", harga=15000, jumlah=2)
daftar_barang("Tas", 1, 250000)
```

### Latihan 4: Local dan Global Variabel
**Soal:**
Buat program dengan:
1. Global variabel `counter` = 0
2. Fungsi `tambah_counter()` yang menambah nilai counter sebesar 1
3. Fungsi `tampilkan_counter()` yang menampilkan nilai counter
4. Fungsi `reset_counter()` yang mengubah nilai counter menjadi 0

**Jawaban:**
```python
counter = 0  # Global variabel

def tambah_counter():
    global counter
    counter += 1

def tampilkan_counter():
    print(f"Nilai counter: {counter}")

def reset_counter():
    global counter
    counter = 0

# Penggunaan
tampilkan_counter()  # Output: Nilai counter: 0
tambah_counter()
tambah_counter()
tampilkan_counter()  # Output: Nilai counter: 2
reset_counter()
tampilkan_counter()  # Output: Nilai counter: 0
```

### Latihan 5: Parameter Dinamis
**Soal:**
Buat fungsi `hitung_rata_rata()` yang bisa menerima berbagai jumlah angka dan mengembalikan nilai rata-ratanya.

**Jawaban:**
```python
def hitung_rata_rata(*angka):
    if len(angka) == 0:
        return 0
    
    total = 0
    for nilai in angka:
        total += nilai
    
    return total / len(angka)

# Pemanggilan dengan berbagai jumlah argumen
rata1 = hitung_rata_rata(10, 20, 30)
print(f"Rata-rata: {rata1}")  # Output: Rata-rata: 20.0

rata2 = hitung_rata_rata(5, 10, 15, 20, 25)
print(f"Rata-rata: {rata2}")  # Output: Rata-rata: 15.0

rata3 = hitung_rata_rata(100)
print(f"Rata-rata: {rata3}")  # Output: Rata-rata: 100.0
```

## Kesimpulan

Fungsi adalah konsep fundamental dalam pemrograman Python yang memungkinkan kita:
1. Mengorganisir kode menjadi blok-blok yang dapat digunakan kembali
2. Menghindari pengulangan kode yang sama
3. Membuat program lebih mudah dibaca dan dipelihara
4. Memecah masalah kompleks menjadi bagian-bagian kecil

Dengan menguasai fungsi, Anda bisa membuat program yang lebih efisien dan terstruktur. Teruslah berlatih dengan mencoba berbagai contoh dan eksperimen sendiri!

**Tips Praktis:**
- Beri nama fungsi yang deskriptif (menggambarkan apa yang dilakukan fungsi)
- Satu fungsi sebaiknya melakukan satu tugas spesifik
- Gunakan parameter untuk membuat fungsi lebih fleksibel
- Manfaatkan return value untuk membuat fungsi lebih reusable
- Pisahkan antara local dan global variabel dengan jelas

Semoga materi ini bermanfaat untuk pembelajaran Informatika Anda. Jika ada pertanyaan, jangan ragu untuk bertanya kepada guru Anda!