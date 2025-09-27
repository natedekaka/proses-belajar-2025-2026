### Materi Pengurangan Bilangan Biner



Pengurangan bilangan biner adalah konsep penting dalam informatika yang seringkali membingungkan siswa. Kuncinya adalah memahami tiga metode utama: **Pengurangan Langsung (konsep pinjam)**, **Komplemen 1**, dan **Komplemen 2**. Kita akan fokus pada dua metode yang paling sering digunakan dan mudah dipahami, yaitu pengurangan langsung dan komplemen 2.



### 1. Pengurangan Langsung (Konsep Meminjam)



Metode ini mirip dengan pengurangan bilangan desimal yang sudah familiar bagi siswa. Kita mengurangi setiap digit dari kanan ke kiri, dan jika digit di atas lebih kecil dari digit di bawahnya, kita **meminjam** dari kolom sebelah kiri.

**Aturan Dasar Pengurangan Langsung:**

- 0−0=0
- 1−1=0
- 1−0=1
- 0−1=1 (dengan meminjam 1 dari kolom kiri)

**Contoh Soal:** Kurangkan 1101_2 dengan 101_2.

**Langkah-langkah:**

1. **Susun secara vertikal:**

   ```
     1101
     0101   (agar jumlah digit sama)
     ---- (-)
   ```

2. **Kurangkan dari kolom paling kanan (LSB - \*Least Significant Bit\*):**

   - 1−1=0. Tulis 0.

   ```
     1101
     0101
     ----
        0
   ```

3. **Lanjut ke kolom kedua dari kanan:**

   - 0−0=0. Tulis 0.

   ```
     1101
     0101
     ----
       00
   ```

4. **Lanjut ke kolom ketiga:**

   - 1−1=0. Tulis 0.

   ```
     1101
     0101
     ----
      000
   ```

5. **Lanjut ke kolom paling kiri:**

   - 1−0=1. Tulis 1.

   ```
     1101
     0101
     ----
     1000
   ```

Jadi, 1101_2−101_2=1000_2.

**Contoh Soal (dengan meminjam):** Kurangkan 1010_2 dengan 101_2.

1. **Susun secara vertikal:**

   ```
     1010
     0101
     ---- (-)
   ```

2. **Kolom paling kanan:** 0−1. Tidak bisa, jadi kita **pinjam** dari kolom kiri.

   - Pinjam 1 dari kolom kedua. Digit 1 di kolom kedua menjadi 0.
   - Digit 0 di kolom pertama menjadi 10_2 (yang sama dengan 2 desimal).
   - Sekarang, hitung 10_2−1_2=1_2 (atau 2−1=1). Tulis 1.

   ```
     1010  (Setelah meminjam: 010)
     0101
     ----
        1
   ```

3. **Kolom kedua:** Sisa digit di sini adalah 0. Sekarang kita hitung 0−0=0.

   ```
     1010
     0101
     ----
       01
   ```

4. **Kolom ketiga:** 0−1. Tidak bisa, **pinjam** dari kolom kiri.

   - Pinjam 1 dari kolom paling kiri. Digit 1 di kolom paling kiri menjadi 0.
   - Digit 0 di kolom ketiga menjadi 10_2.
   - Sekarang, hitung 10_2−1_2=1_2. Tulis 1.

   ```
     1010  (Setelah meminjam: 01)
     0101
     ----
      101
   ```

5. **Kolom paling kiri:** Sisa digit di sini adalah 0. Sekarang hitung 0−0=0.

   ```
     1010
     0101
     ----
     0101
   ```

Jadi, 1010_2−101_2=101_2.

------



### 2. Metode Komplemen 2



Metode ini adalah cara yang paling sering digunakan oleh komputer untuk melakukan operasi pengurangan, karena lebih efisien dan dapat disederhanakan menjadi operasi penjumlahan.

**Konsep Dasar:** Pengurangan A−B dapat diubah menjadi **penjumlahan** A+(Komplemen 2 dari B).

**Langkah-langkah:**

1. **Sama ratakan jumlah bit:** Pastikan kedua bilangan memiliki jumlah digit yang sama. Tambahkan 0 di depan jika perlu.
2. **Cari Komplemen 2 dari bilangan pengurang (B):**
   - **Langkah A: Cari Komplemen 1.** Ubah setiap 0 menjadi 1, dan setiap 1 menjadi 0.
   - **Langkah B: Tambahkan 1.** Tambahkan 1 pada hasil Komplemen 1.
3. **Jumlahkan bilangan yang dikurangi (A) dengan hasil Komplemen 2 (B):** Lakukan penjumlahan biner seperti biasa.
4. **Abaikan bit \*overflow\*:** Jika hasil penjumlahan melebihi jumlah bit awal (ada kelebihan digit di paling kiri), abaikan bit tersebut. Sisa digitnya adalah hasilnya.

**Contoh Soal:** Kurangkan 1101_2 dengan 101_2.

1. **Sama ratakan bit:**

   - A=1101
   - B=0101

2. **Cari Komplemen 2 dari B (0101):**

   - Komplemen 1 dari 0101 adalah 1010.
   - Tambahkan 1: 1010+1=1011.

3. **Jumlahkan A dengan hasil Komplemen 2:**

   ```
     1101  (Bilangan pertama)
     1011  (Komplemen 2 dari bilangan kedua)
     ---- (+)
    11000
   ```

4. **Abaikan bit \*overflow\*:** Hasilnya adalah 5 bit (11000), sedangkan bilangan awal hanya 4 bit. Abaikan bit kelebihan (bit paling kiri, yaitu 1).

   - Hasilnya adalah 1000_2.

**Contoh Soal (hasil negatif):** Kurangkan 101_2 dengan 1101_2.

1. **Sama ratakan bit:**

   - A=0101
   - B=1101

2. **Cari Komplemen 2 dari B (1101):**

   - Komplemen 1 dari 1101 adalah 0010.
   - Tambahkan 1: 0010+1=0011.

3. **Jumlahkan A dengan hasil Komplemen 2:**

   ```
     0101  (Bilangan pertama)
     0011  (Komplemen 2 dari bilangan kedua)
     ---- (+)
     1000
   ```

4. **Tidak ada bit \*overflow\*.** Ini menunjukkan bahwa hasilnya adalah bilangan negatif. Untuk mengetahui nilainya, kita cari **Komplemen 2 dari hasil tersebut** dan berikan tanda negatif di depannya.

   - Komplemen 1 dari 1000 adalah 0111.
   - Tambahkan 1: 0111+1=1000.
   - Jadi, hasilnya adalah −1000_2.



### Kesimpulan



Dengan menguasai kedua metode ini, siswa akan memiliki pemahaman yang kuat tentang bagaimana komputer melakukan pengurangan, baik secara fundamental maupun secara praktis. Metode langsung lebih intuitif karena mirip dengan pengurangan desimal, sementara metode komplemen 2 adalah cara yang digunakan secara internal oleh perangkat digital.