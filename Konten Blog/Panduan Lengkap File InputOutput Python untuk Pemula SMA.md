# Panduan Lengkap File Input/Output Python untuk Pemula SMA

Halo teman-teman SMA! Pada kesempatan kali ini, kita akan membahas salah satu materi penting dalam pemrograman Python, yaitu File Input/Output. Materi ini sangat berguna untuk kalian yang sedang belajar Informatika, khususnya dalam menyimpan dan membaca data menggunakan Python.

## Tujuan Pembelajaran

Setelah mempelajari materi ini, kalian diharapkan mampu:
1. Memahami konsep File Input/Output dalam Python
2. Membuka dan menutup file dengan benar
3. Menulis data ke file
4. Membaca data dari file
5. Menggunakan berbagai mode file (read, write, append, create)
6. Menggunakan with statement untuk penanganan file yang lebih aman

## Apa itu File Input/Output?

File Input/Output (sering disingkat File I/O) adalah kemampuan program untuk membaca data atau menuliskan data ke file. 

Coba bayangkan ketika kalian menggunakan Microsoft Word atau Microsoft Excel. Saat kalian mengetik dan menyimpan dokumen, kalian sebenarnya sedang menyimpan data ke dalam file. Demikian juga, saat kalian membuka dokumen yang sudah tersimpan, kalian sedang membaca data dari file.

Dalam pemrograman, File I/O sangat penting karena:
- Menyimpan data secara permanen
- Membaca data yang sudah disimpan sebelumnya
- Membuat laporan dalam bentuk file
- Memproses data dari file eksternal
- Melakukan backup dan restore data

## Membuka dan Menutup File

Untuk membuka file dalam Python, kita menggunakan fungsi `open()` dengan dua parameter:
1. Nama file (lokasi file)
2. Mode (menentukan apakah file akan dibaca, ditulis, dll)

Setelah selesai menggunakan file, jangan lupa untuk menutupnya menggunakan fungsi `close()`. Mengapa? Karena jika file tidak ditutup, data akan tetap tersimpan di memori dan dapat menyebabkan "memory leak" (kebocoran memori) yang membuat aplikasi menjadi berat.

## Mode File

Saat membuka file, kita perlu menentukan mode penggunaannya. Berikut adalah mode-mode yang tersedia:

1. **'r' (Read)**: Membaca file yang sudah ada. File harus ada, jika tidak akan terjadi error.
2. **'w' (Write)**: Menulis ke file. Jika file sudah ada, isinya akan ditimpa. Jika file belum ada, akan dibuat baru.
3. **'a' (Append)**: Menambah data di akhir file. Jika file belum ada, akan dibuat baru.
4. **'x' (Create)**: Membuat file baru. Jika file sudah ada, akan terjadi error.

## Menulis ke File

Untuk menulis ke file, kita gunakan fungsi `write()`. Perlu diingat, file yang sudah ditutup tidak bisa ditulis lagi kecuali dibuka kembali.

Contoh program untuk menyimpan data nilai siswa:

```python
# Program simpan data nilai
print("Program Simpan Data Nilai")

# Membuka file dengan mode write
file = open("nilai_siswa.txt", "w")

while True:
    nama = input("Nama siswa: ")
    
    # Jika nama kosong, hentikan perulangan
    if nama == "":
        break
        
    nilai = input("Nilai siswa: ")
    
    # Menulis data ke file
    file.write(nama + "," + nilai + "\n")
    print(f"Data {nama} berhasil disimpan.")

# Menutup file
file.close()
print("Program selesai.")
```

## Membaca dari File

Untuk membaca dari file, kita bisa menggunakan:
1. Fungsi `read()` untuk membaca seluruh isi file sekaligus. Namun, ini berisiko jika file ukurannya besar.
2. Perulangan untuk membaca file baris per baris, yang lebih efisien untuk penggunaan memori.

Contoh program untuk menampilkan data nilai siswa:

```python
# Program menampilkan data nilai
print("Program Menampilkan Data Nilai")

# Membuka file dengan mode read
file = open("nilai_siswa.txt", "r")

# Membaca file baris per baris
for line in file:
    # Menghapus spasi di awal dan akhir, lalu memisahkan nama dan nilai
    data = line.strip().split(",")
    nama = data[0]
    nilai = data[1]
    print(f"Nama: {nama}, Nilai: {nilai}")

# Menutup file
file.close()
print("Program selesai.")
```

## With Statement

Dalam Python, ada cara yang lebih aman untuk menangani file, yaitu menggunakan `with statement`. Keuntungannya adalah file akan otomatis ditutup bahkan jika terjadi error, sehingga menghindari memory leak.

Contoh penggunaan `with statement`:

```python
# Program menulis data dengan with statement
print("Program Simpan Data Nilai dengan With Statement")

with open("nilai_siswa.txt", "w") as file:
    while True:
        nama = input("Nama siswa: ")
        
        if nama == "":
            break
            
        nilai = input("Nilai siswa: ")
        
        file.write(nama + "," + nilai + "\n")
        print(f"Data {nama} berhasil disimpan.")

print("Program selesai.")
```

```python
# Program membaca data dengan with statement
print("Program Menampilkan Data Nilai dengan With Statement")

with open("nilai_siswa.txt", "r") as file:
    for line in file:
        data = line.strip().split(",")
        nama = data[0]
        nilai = data[1]
        print(f"Nama: {nama}, Nilai: {nilai}")

print("Program selesai.")
```

## Contoh Latihan

### Latihan 1: Membuat Daftar Hadir
Buat program yang memungkinkan guru untuk memasukkan nama-nama siswa yang hadir hari ini dan menyimpannya dalam file bernama "daftar_hadir.txt".

```python
# Program untuk mencatat daftar hadir siswa
print("Program Pencatatan Daftar Hadir")

with open("daftar_hadir.txt", "w") as file:
    print("Masukkan nama siswa yang hadir (kosongkan jika selesai):")
    
    while True:
        nama = input("Nama siswa: ")
        
        if nama == "":
            break
            
        file.write(nama + "\n")
        print(f"Data {nama} berhasil disimpan.")

print("Pencatatan selesai. Data telah tersimpan di daftar_hadir.txt")
```

### Latihan 2: Menampilkan Daftar Hadir
Buat program yang membaca file "daftar_hadir.txt" dan menampilkan semua nama siswa yang hadir beserta nomor urutnya.

```python
# Program untuk menampilkan daftar hadir siswa
print("Daftar Hadir Siswa Hari Ini")
print("=" * 30)

try:
    with open("daftar_hadir.txt", "r") as file:
        nomor = 1
        for line in file:
            nama = line.strip()
            print(f"{nomor}. {nama}")
            nomor += 1
except FileNotFoundError:
    print("File daftar_hadir.txt tidak ditemukan!")

print("=" * 30)
print(f"Total siswa yang hadir: {nomor - 1}")
```

### Latihan 3: Menambah Data ke File
Buat program yang memungkinkan user untuk menambahkan nama siswa baru ke file "daftar_hadir.txt" tanpa menghapus data yang sudah ada.

```python
# Program untuk menambah data ke file daftar hadir
print("Program Penambahan Daftar Hadir")

with open("daftar_hadir.txt", "a") as file:
    print("Masukkan nama siswa tambahan yang hadir (kosongkan jika selesai):")
    
    while True:
        nama = input("Nama siswa: ")
        
        if nama == "":
            break
            
        file.write(nama + "\n")
        print(f"Data {nama} berhasil ditambahkan.")

print("Penambahan data selesai.")
```

## Penutup

Itulah panduan lengkap tentang File Input/Output dalam Python untuk pemula tingkat SMA. Materi ini sangat penting karena akan sering digunakan dalam pengembangan aplikasi yang lebih kompleks. Dengan memahami cara menyimpan dan membaca data dari file, kalian sudah selangkah lebih maju dalam dunia pemrograman!

Jangan lupa untuk terus berlatih dan mencoba berbagai eksperimen dengan kode-kode di atas. Semoga sukses!

Salam,
Tim Informatika SMA