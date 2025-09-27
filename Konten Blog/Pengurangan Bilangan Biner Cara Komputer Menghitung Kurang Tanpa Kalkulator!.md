# **Pengurangan Bilangan Biner: Cara Komputer Menghitung Kurang Tanpa Kalkulator!**

Halo, teman-teman SMA kelas 1! Setelah kita belajar penjumlahan bilangan biner, sekarang kita akan jelajahi operasi matematika lain yang sama pentingnya: **pengurangan bilangan biner**. Yuk, kita pahami cara komputer "menghitung kurang" hanya dengan dua angka sederhana: 0 dan 1!

## **Apa Itu Pengurangan Biner?**

Pengurangan bilangan biner adalah operasi matematika untuk mengurangi satu bilangan biner dari bilangan biner lainnya. Sama seperti penjumlahan, ini menjadi dasar dari semua perhitungan di komputer, mulai dari operasi sederhana hingga pemrosesan data kompleks!

## **4 Aturan Dasar Pengurangan Biner**

Ada 4 aturan fundamental yang harus kamu ingat:

1. **0 - 0 = 0**  
   *Contoh:* Tidak ada apel - tidak ada apel = tetap tidak ada apel!

2. **1 - 0 = 1**  
   *Contoh:* Satu apel - tidak ada apel = satu apel!

3. **1 - 1 = 0**  
   *Contoh:* Satu apel - satu apel = tidak ada apel!

4. **0 - 1 = 1 (dengan pinjaman)**  
   *Ini yang paling penting!*  
   *Contoh:* Tidak ada apel - satu apel = butuh pinjam dari tetangga!  
   **Ingat:** Karena tidak bisa kurang langsung, kita harus "pinjam" dari digit di sebelah kiri.

## **Konsep "Pinjaman" (Borrow) dalam Pengurangan Biner**

Sama seperti pengurangan desimal, ketika digit yang dikurangi lebih kecil dari pengurang, kita perlu **meminjam** dari digit di sebelah kiri.

Contoh dalam desimal:  
32 - 15 → Di satuan: 2 < 5, jadi pinjam 1 dari puluhan (menjadi 12 - 5 = 7).

Dalam biner:  
10 - 1 → Di satuan: 0 < 1, jadi pinjam 1 dari digit kiri (menjadi 10 - 1 = 1).

## **Metode Pengurangan Langsung (Dengan Pinjaman)**

### **Langkah-Langkah:**
1. Tulis kedua bilangan biner dengan rapi (sejajarkan digit dari kanan)
2. Mulai dari digit paling kanan
3. Kurangkan digit per digit sesuai aturan
4. Jika perlu pinjam, tandai di digit sebelah kiri
5. Lanjutkan hingga semua digit selesai

### **Contoh 1: 10 - 1**

```
  10  (desimal: 2)
-  1  (desimal: 1)
-----
```

Langkah per langkah:

1. **Digit paling kanan (satuan):**  
   0 < 1 → butuh pinjam dari digit kiri  
   Pinjam 1 dari digit kiri (1), jadi digit satuan menjadi 10 (biner)  
   10 - 1 = 1 → tulis **1**

2. **Digit kedua (duaan):**  
   Karena sudah dipinjam, digit ini menjadi 0  
   0 - 0 = 0 → tulis **0**

Hasil: **01** atau cukup **1** (desimal: 1)

```
   0¹  ← pinjaman
   10
-   1
-----
    1
```

### **Contoh 2: 100 - 11**

```
  100  (desimal: 4)
-  11  (desimal: 3)
-----
```

Langkah per langkah:

1. **Digit paling kanan (satuan):**  
   0 < 1 → butuh pinjam  
   Pinjam dari digit kiri, tapi digit kiri juga 0 → perlu pinjam lagi  
   Pinjam dari digit paling kiri (1), jadi digit tengah menjadi 10  
   Kemudian pinjam dari digit tengah (sekarang 10), jadi digit satuan menjadi 10  
   10 - 1 = 1 → tulis **1**

2. **Digit kedua (duaan):**  
   Setelah dipinjam, digit ini menjadi 1 (karena 10 - 1 = 1)  
   1 - 1 = 0 → tulis **0**

3. **Digit ketiga (puluhan biner):**  
   Setelah dipinjam, digit ini menjadi 0  
   0 - 0 = 0 → tulis **0**

Hasil: **001** atau cukup **1** (desimal: 1)

```
   0¹0  ← pinjaman
   100
-   11
-----
     1
```

### **Contoh 3: 1100 - 101**

```
  1100  (desimal: 12)
-  101  (desimal: 5)
-----
```

Langkah per langkah:

1. **Digit paling kanan (satuan):**  
   0 < 1 → butuh pinjam  
   Pinjam dari digit kiri (0) → tidak bisa, pinjam lagi  
   Pinjam dari digit berikutnya (1), jadi digit kedua menjadi 10  
   Kemudian pinjam dari digit kedua (sekarang 10), jadi digit satuan menjadi 10  
   10 - 1 = 1 → tulis **1**

2. **Digit kedua (duaan):**  
   Setelah dipinjam, digit ini menjadi 1 (karena 10 - 1 = 1)  
   1 - 0 = 1 → tulis **1**

3. **Digit ketiga (puluhan biner):**  
   Setelah dipinjam, digit ini menjadi 0  
   0 - 1 → butuh pinjam lagi  
   Pinjam dari digit paling kiri (1), jadi digit ini menjadi 10  
   10 - 1 = 1 → tulis **1**

4. **Digit keempat (ratusan biner):**  
   Setelah dipinjam, digit ini menjadi 0  
   0 - 0 = 0 → tulis **0**

Hasil: **0111** atau **111** (desimal: 7)

```
   0¹0¹0  ← pinjaman
   1100
-   101
-----
    111
```

## **Metode Alternatif: Komplemen 2**

Untuk mempermudah pengurangan (terutama di komputer), sering digunakan metode **komplemen 2**. Komputer lebih suka metode ini karena hanya menggunakan penjumlahan!

### **Langkah-Langkah Komplemen 2:**
1. Cari komplemen 1 dari bilangan pengurang (balik semua bit: 0→1, 1→0)
2. Tambahkan 1 ke hasil komplemen 1 → dapat komplemen 2
3. Jumlahkan bilangan pengurang dengan komplemen 2
4. Abaikan carry terakhir (jika ada)

### **Contoh: 1010 - 110 (10 - 6)**

1. **Komplemen 1 dari 110:**  
   110 → 001 (balik semua bit)

2. **Komplemen 2:**  
   001 + 1 = 010

3. **Jumlahkan:**  
   ```
     1010
   +  010
   ------
     1100
   ```

4. **Hasil:** 1100 (desimal: 12) → tapi ini salah?  
   **Perbaikan:** Kita lupa abaikan carry!  
   Seharusnya:  
   ```
     1010
   + 0110  ← komplemen 2 sebenarnya dari 110 adalah 010? Tunggu...
   ```

   **Koreksi:**  
   Komplemen 2 dari 110:  
   - Komplemen 1: 001  
   - Tambah 1: 001 + 1 = 010  
   Tapi 010 adalah komplemen 2 dari 110?  
   Seharusnya: 110 (6) dalam 4 bit: 0110  
   Komplemen 1: 1001  
   Komplemen 2: 1001 + 1 = 1010  

   Jadi:  
   ```
     1010
   + 1010  ← komplemen 2 dari 0110
   ------
    10100  → abaikan carry terakhir (1), hasilnya 0100 (4)
   ```

   **Hasil:** 0100 (desimal: 4) → benar! (10 - 6 = 4)

**Catatan:** Metode komplemen 2 lebih efisien untuk komputer, tapi untuk pemahaman awal, metode pinjaman lebih直观. Kita fokus dulu ke metode pinjaman!

## **Latihan Pengurangan Biner**

Sekarang, giliran kamu mencoba! Kerjakan soal-soal berikut:

### **Soal Mudah:**
1. 11 - 1 = ?
2. 10 - 1 = ?
3. 100 - 10 = ?

### **Soal Sedang:**
4. 110 - 11 = ?
5. 1000 - 100 = ?
6. 1010 - 111 = ?

### **Soal Menantang:**
7. 1100 - 101 = ?
8. 10000 - 111 = ?
9. 10101 - 1100 = ?

## **Tips Super Praktis**

- **Gunakan kertas:** Tulis bilangan secara vertikal dan beri tanda pinjaman di atas
- **Periksa ulang:** Konversi ke desimal untuk memastikan hasilnya benar
- **Ingat pola pinjaman:** 0 - 1 selalu butuh pinjam dari kiri
- **Mulai dari kanan:** Selalu mulai dari digit paling kanan
- **Latih komplemen 2:** Untuk persiapan materi lebih lanjut

## **Mengapa Ini Penting?**

Pengurangan biner adalah dasar dari:
- **Operasi aritmatika lengkap** di CPU
- **Pemrosesan grafis** (perhitungan koordinat)
- **Sistem operasi** (manajemen memori)
- **Kriptografi** (algoritma enkripsi)
- **AI dan machine learning** (perhitungan bobot neural network)

Setiap kali kamu melihat animasi di game, edit foto, atau pakai navigasi GPS, jutaan operasi pengurangan biner terjadi di balik layar!

## **Kesimpulan**

Pengurangan bilangan biner mungkin terlihat rumit di awal, terutama dengan konsep pinjaman. Tapi dengan latihan, kamu akan terbiasa dan bahkan bisa "berpikir seperti komputer"! Ini adalah keterampilan fundamental yang akan membuka pemahaman lebih dalam tentang cara kerja teknologi digital.

Jangan frustrasi jika salah di awal. Bahkan programmer profesional pun masih sering mengecek ulang perhitungan biner mereka. Yang penting adalah memahami konsep dan terus berlatih!

---

### **Kunci Jawaban Latihan:**

**Soal Mudah:**
1. 11 - 1 = 10  
   *(3 - 1 = 2)*
2. 10 - 1 = 1  
   *(2 - 1 = 1)*
3. 100 - 10 = 10  
   *(4 - 2 = 2)*

**Soal Sedang:**
4. 110 - 11 = 11  
   *(6 - 3 = 3)*
5. 1000 - 100 = 100  
   *(8 - 4 = 4)*
6. 1010 - 111 = 11  
   *(10 - 7 = 3)*

**Soal Menantang:**
7. 1100 - 101 = 111  
   *(12 - 5 = 7)*
8. 10000 - 111 = 1001  
   *(16 - 7 = 9)*
9. 10101 - 1100 = 1001  
   *(21 - 12 = 9)*

---

**Pesan Penutup:**  
Kamu sudah menguasai dua operasi matematika paling dasar di dunia komputer: penjumlahan dan pengurangan biner! Ini seperti belajar alfabet sebelum menulis novel. Dengan fondasi ini, kamu siap menjelajahi topik lebih lanjut seperti perkalian, pembagian, dan logika digital. Teruslah berlatih, dan ingat: di balik setiap teknologi canggih, ada jutaan operasi sederhana 0 dan 1 yang bekerja tanpa henti! 💻🧮

*Ada pertanyaan atau kesulitan? Tulis di kolom komentar, kita bahas bersama!*