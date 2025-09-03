Tentu, berikut adalah materi lengkap dan latihan yang dirancang khusus untuk siswa SMA kelas 11 tentang percabangan dasar di Python.



# Percabangan (Conditional Statements)



Percabangan adalah salah satu konsep terpenting dalam pemrograman. Ini memungkinkan program untuk membuat keputusan dan menjalankan kode yang berbeda tergantung pada kondisi tertentu. Bayangkan seperti membuat keputusan dalam kehidupan sehari-hari: "Jika hujan, saya akan memakai payung." Pernyataan `if`, `elif`, dan `else` dalam Python bekerja dengan cara yang sama.



## Konsep Dasar



Dalam Python, kita menggunakan tiga kata kunci utama untuk percabangan:

- **`if`**: Digunakan untuk menguji satu kondisi. Jika kondisi tersebut `True` (benar), kode di dalamnya akan dieksekusi.
- **`elif`** (singkatan dari "else if"): Digunakan untuk menguji kondisi kedua, ketiga, dan seterusnya, jika kondisi `if` sebelumnya `False` (salah). Anda bisa menggunakan `elif` sebanyak yang Anda butuhkan.
- **`else`**: Digunakan untuk menangkap semua kondisi yang tidak terpenuhi oleh `if` atau `elif` sebelumnya. Kode di dalam `else` akan dieksekusi jika semua kondisi di atasnya `False`.



### Operator Perbandingan



Untuk membuat keputusan, kita menggunakan operator perbandingan. Operator ini membandingkan dua nilai dan menghasilkan nilai `True` atau `False`.

| Operator | Deskripsi                    | Contoh                       |
| -------- | ---------------------------- | ---------------------------- |
| `==`     | Sama dengan                  | `5 == 5`  (hasilnya `True`)  |
| `!=`     | Tidak sama dengan            | `5 != 10` (hasilnya `True`)  |
| `>`      | Lebih dari                   | `10 > 5` (hasilnya `True`)   |
| `<`      | Kurang dari                  | `5 < 10` (hasilnya `True`)   |
| `>=`     | Lebih dari atau sama dengan  | `10 >= 10` (hasilnya `True`) |
| `<=`     | Kurang dari atau sama dengan | `5 <= 10` (hasilnya `True`)  |

------



## Latihan Praktik untuk Siswa





### Latihan 1: Pengecek Kelulusan Sederhana



**Tujuan:** Memahami penggunaan `if` dan `else` serta operator perbandingan.

Instruksi:

Buatlah program yang meminta pengguna memasukkan nilai ujian. Program kemudian akan mencetak "Lulus" jika nilai lebih dari atau sama dengan 75, dan "Tidak Lulus" jika sebaliknya.

**Contoh kode:**

Python

```
nilai = int(input("Masukkan nilai ujian Anda: "))

if nilai >= 75:
  print("Selamat, Anda lulus!")
else:
  print("Maaf, Anda tidak lulus. Coba lagi!")
```



### Latihan 2: Kalkulator Sederhana



**Tujuan:** Menggabungkan percabangan dengan operasi aritmatika dan input pengguna.

Instruksi:

Kembangkan program kalkulator yang telah Anda buat sebelumnya. Tambahkan pilihan operasi (+, -, *, /) dan gunakan percabangan untuk menjalankan operasi yang sesuai dengan pilihan pengguna.

**Contoh kode:**

Python

```
# Minta input dua angka
angka1 = float(input("Masukkan angka pertama: "))
angka2 = float(input("Masukkan angka kedua: "))

# Minta input operator
operator = input("Pilih operasi (+, -, *, /): ")

if operator == '+':
  hasil = angka1 + angka2
  print(f"Hasilnya: {hasil}")
elif operator == '-':
  hasil = angka1 - angka2
  print(f"Hasilnya: {hasil}")
elif operator == '*':
  hasil = angka1 * angka2
  print(f"Hasilnya: {hasil}")
elif operator == '/':
  # Tambahkan pengecekan agar tidak terjadi pembagian dengan nol
  if angka2 != 0:
    hasil = angka1 / angka2
    print(f"Hasilnya: {hasil}")
  else:
    print("Tidak bisa melakukan pembagian dengan nol.")
else:
  print("Operator yang Anda masukkan tidak valid.")
```



### Latihan 3: Penentu Kategori Usia



**Tujuan:** Memahami penggunaan `if`, `elif`, dan `else` secara berurutan.

Instruksi:

Buat program yang meminta pengguna memasukkan usia. Program akan menentukan kategori usia berdasarkan aturan berikut:

- Jika usia kurang dari 13: "Anak-anak"
- Jika usia 13 sampai 19: "Remaja"
- Jika usia lebih dari 19: "Dewasa"

**Contoh kode:**

Python

```
usia = int(input("Masukkan usia Anda: "))

if usia < 13:
  print("Anda termasuk kategori anak-anak.")
elif usia >= 13 and usia <= 19:
  print("Anda termasuk kategori remaja.")
else:
  print("Anda termasuk kategori dewasa.")
```

------

Setelah menyelesaikan latihan ini, siswa akan memiliki pemahaman yang kuat tentang bagaimana percabangan bekerja dan dapat mulai berpikir secara logis untuk memecahkan masalah yang lebih kompleks. Materi selanjutnya yang akan sangat relevan adalah **perulangan (loops)**, yang memungkinkan mereka untuk mengulang suatu proses secara otomatis.