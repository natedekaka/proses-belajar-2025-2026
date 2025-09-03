## **Memahami Algoritma dan Pemrograman**



Sebelum menulis kode, penting untuk memahami hubungan antara algoritma dan pemrograman.

- **Algoritma:** Ini adalah serangkaian langkah atau instruksi yang terstruktur untuk memecahkan sebuah masalah. Bayangkan resep masakan, itu adalah algoritma untuk membuat sebuah hidangan.
- **Pemrograman:** Ini adalah proses mengubah algoritma (resep) tersebut menjadi bahasa yang bisa dipahami oleh komputer, yaitu **kode program**.

Jadi, langkahnya adalah: **Masalah ➡️ Algoritma ➡️ Kode Program**

------



## **Mengenal Struktur Dasar Program Python**



Untuk memulai, kita perlu tahu beberapa elemen dasar dalam Python.



### **1. Mencetak Teks ke Layar**



Fungsi paling dasar adalah `print()`. Ini digunakan untuk menampilkan output atau hasil ke layar.

Python

```
print("Halo, dunia!")
```

Outputnya:

```
Halo, dunia!
```

**Tips:** Teks yang ingin dicetak harus diapit oleh tanda kutip tunggal (`'`) atau ganda (`"`).



### **2. Variabel**



Variabel adalah "wadah" untuk menyimpan data. Kita bisa menyimpan angka, teks, atau data lainnya.

Python

```
nama = "Budi"
umur = 17
print("Nama saya adalah", nama)
print("Umur saya", umur, "tahun")
```

Outputnya:

```
Nama saya adalah Budi
Umur saya 17 tahun
```

**Aturan Penamaan Variabel:**

- Tidak boleh diawali dengan angka.
- Tidak boleh mengandung spasi.
- Gunakan huruf, angka, dan garis bawah (`_`).



### **3. Input dari Pengguna**



Fungsi `input()` digunakan untuk meminta data dari pengguna. Data yang dimasukkan akan selalu dianggap sebagai teks (string).

Python

```
nama_lengkap = input("Masukkan nama lengkap Anda: ")
print("Halo,", nama_lengkap)
```

Outputnya:

```
Masukkan nama lengkap Anda: [pengguna mengetik namanya di sini]
Halo, [nama yang dimasukkan]
```

------



## **Latihan: Mengimplementasikan Algoritma Sederhana**



Mari kita terapkan konsep-konsep di atas untuk memecahkan masalah sederhana.



### **Soal: Menghitung Luas Persegi Panjang**



**Algoritma:**

1. Minta pengguna untuk memasukkan panjang.
2. Minta pengguna untuk memasukkan lebar.
3. Kalikan panjang dengan lebar untuk mendapatkan luas.
4. Tampilkan hasil luasnya.

**Implementasi Kode Program (Python):**

Python

```
# Langkah 1 dan 2: Meminta input dari pengguna
# Gunakan int() untuk mengubah teks input menjadi angka (integer)
panjang = int(input("Masukkan panjang persegi: "))
lebar = int(input("Masukkan lebar persegi: "))

# Langkah 3: Menghitung luas
luas = panjang * lebar

# Langkah 4: Menampilkan hasil
print("Luas persegi panjang adalah:", luas)
```

**Penjelasan Tambahan:**

- `int(input(...))` digunakan untuk mengubah input dari teks menjadi angka karena operasi matematika hanya bisa dilakukan pada tipe data angka.

------



## **Tugas Mandiri**



**Buatlah kode program Python untuk menghitung rata-rata dari tiga nilai (misalnya, nilai ulangan harian, UTS, dan UAS).**

**Panduan Algoritma:**

1. Minta pengguna untuk memasukkan tiga nilai.
2. Jumlahkan ketiga nilai tersebut.
3. Bagi jumlah tersebut dengan 3.
4. Tampilkan hasil rata-ratanya.

