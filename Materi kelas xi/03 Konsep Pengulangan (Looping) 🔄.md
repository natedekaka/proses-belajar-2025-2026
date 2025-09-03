## 1. Pengantar Konsep Perulangan (Looping) 🔄



Dalam pemrograman, **perulangan (loop)** adalah sebuah instruksi yang memungkinkan kita untuk menjalankan satu blok kode yang sama **berulang kali**. Konsep ini sangat fundamental dan penting untuk menghindari penulisan kode yang berulang-ulang, yang dikenal sebagai prinsip **DRY (Don't Repeat Yourself)**.

Bayangkan jika kita ingin mencetak nama 50 siswa. Tanpa perulangan, kita harus menulis `print()` sebanyak 50 kali. Dengan loop, kita cukup menulis satu kali `print()` di dalam blok perulangan, dan Python akan melakukannya untuk kita secara otomatis.

Di Python, ada dua jenis perulangan utama yang sering digunakan:

- **`for` loop**: Digunakan ketika kita tahu **berapa kali** perulangan akan terjadi atau ketika kita ingin mengiterasi (mengunjungi satu per satu) setiap item dalam sebuah urutan.
- **`while` loop**: Digunakan ketika kita tidak tahu pasti berapa kali perulangan akan terjadi, tetapi kita tahu **kondisi apa** yang harus terpenuhi agar perulangan berhenti.

------



## 2. Mengenal Lebih Jauh `for` Loop





### Konsep Dasar



`for` loop adalah "tukang urut" yang andal. Ia akan mengurutkan dan menjalankan kode untuk setiap item dalam sebuah **urutan (sequence)**. Urutan ini bisa berupa daftar (`list`), string, atau rentang angka yang dibuat dengan fungsi `range()`.



### Sintaks Dasar



Sintaksnya sangat sederhana dan mudah dibaca:

Python

```
for <variabel_iterasi> in <urutan>:
    # blok kode yang akan diulang
```

- `<variabel_iterasi>`: Sebuah variabel sementara yang akan menampung setiap item dari urutan pada setiap putaran loop.
- `<urutan>`: Koleksi data (seperti `range()`, `string`, atau `list`) yang akan diiterasi.



### Penerapan dengan `range()`



Fungsi **`range()`** adalah cara paling umum untuk membuat perulangan `for` dalam jumlah tertentu. Fungsi ini akan menghasilkan urutan angka.

- **`range(stop)`**: Menghasilkan angka dari `0` sampai `stop-1`.

  Python

  ```
  print("Mencetak angka 0 hingga 4:")
  for i in range(5):
      print(i)
  ```

- **`range(start, stop)`**: Menghasilkan angka dari `start` hingga `stop-1`.

  Python

  ```
  print("\nMencetak angka 10 hingga 15:")
  for angka in range(10, 16):
      print(angka)
  ```

- **`range(start, stop, step)`**: Menghasilkan angka dari `start` hingga `stop-1` dengan langkah (`step`) tertentu.

  Python

  ```
  print("\nMencetak angka genap dari 2 hingga 10:")
  for genap in range(2, 12, 2):
      print(genap)
  ```



### Penerapan dengan Tipe Data Lain



Kelebihan `for` loop di Python adalah kemampuannya untuk langsung mengiterasi setiap item di dalam string atau list.

- **Mengiterasi String**:

  Python

  ```
  kata = "Informatika"
  print("\nMengeja kata 'Informatika':")
  for huruf in kata:
      print(huruf)
  ```

- **Mengiterasi List**:

  Python

  ```
  daftar_nama = ["Budi", "Santi", "Andi", "Putri"]
  print("\nDaftar nama siswa:")
  for nama in daftar_nama:
      print("Nama: " + nama)
  ```

------



## 3. Mengenal Lebih Jauh `while` Loop





### Konsep Dasar



`while` loop adalah **"penjaga gerbang"** yang sangat teliti. Ia akan terus mengulang instruksi **selama sebuah kondisi bernilai `True`**. Begitu kondisinya menjadi `False`, loop akan berhenti. Karena itu, `while` sangat cocok untuk situasi di mana jumlah perulangan tidak diketahui sejak awal.



### Sintaks Dasar



Sintaksnya juga sangat mudah:

Python

```
while <kondisi>:
    # blok kode yang akan diulang
```



### Tiga Elemen Penting `while` Loop



Agar `while` loop bekerja dengan benar dan tidak terjebak dalam **perulangan tak terbatas (infinite loop)**, ia harus memiliki tiga elemen berikut:

1. **Inisialisasi (Initialization)**: Variabel yang akan digunakan dalam kondisi harus diberi nilai awal sebelum loop dimulai.
2. **Kondisi (Condition)**: Pernyataan yang diuji di setiap putaran loop. Selama hasilnya `True`, loop berlanjut.
3. **Perubahan (Mutation)**: Ada baris kode di dalam loop yang mengubah nilai variabel inisialisasi. Perubahan inilah yang pada akhirnya akan membuat kondisi menjadi `False` dan menghentikan loop.



### Contoh Penerapan



Mari kita gunakan tiga elemen di atas untuk membuat program penghitung sederhana.

Python

```
# 1. Inisialisasi: Memberi nilai awal
counter = 1

# 2. Kondisi: Selama 'counter' kurang dari atau sama dengan 5
while counter <= 5:
    print("Hitungan ke-" + str(counter))

    # 3. Perubahan: Menambah nilai 'counter'
    counter = counter + 1

print("\nLoop selesai.")
```

**Perhatikan**: Jika baris `counter = counter + 1` dihapus, `counter` akan selalu bernilai 1, kondisi `counter <= 5` akan selalu `True`, dan program tidak akan pernah berhenti.



### Contoh Praktis: Meminta Input sampai Benar



Ini adalah skenario di mana `while` loop sangat berguna.

Python

```
kata_sandi_benar = "rahasia"
input_kata_sandi = ""

while input_kata_sandi != kata_sandi_benar:
    input_kata_sandi = input("Masukkan kata sandi: ")
    if input_kata_sandi != kata_sandi_benar:
        print("Kata sandi salah, coba lagi.")

print("Login berhasil! Selamat datang.")
```

------



## 4. Ringkasan dan Perbandingan `for` vs `while`



| Kriteria             | `for` Loop                                                   | `while` Loop                                                 |
| -------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| **Tujuan Utama**     | Mengiterasi setiap item dalam urutan.                        | Mengulang kode selama sebuah kondisi terpenuhi.              |
| **Kapan Digunakan?** | Ketika kita tahu **berapa kali** perulangan akan terjadi.    | Ketika kita tidak tahu pasti berapa kali perulangan akan terjadi. |
| **Elemen Kunci**     | Urutan (misal: `range()`, `list`).                           | Inisialisasi, Kondisi, dan Perubahan.                        |
| **Contoh Kasus**     | Mencetak angka 1-100, memproses semua item dalam keranjang belanja. | Permainan tebak angka, validasi input, atau login.           |

