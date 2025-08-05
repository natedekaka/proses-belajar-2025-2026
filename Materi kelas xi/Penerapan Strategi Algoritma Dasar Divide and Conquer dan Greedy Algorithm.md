### Penerapan Strategi Algoritma Dasar: Divide and Conquer dan Greedy Algorithm



Peserta didik diharapkan dapat menerapkan salah satu strategi algoritma dasar (misalnya, divide and conquer atau greedy algorithm) untuk menyelesaikan masalah sederhana yang diberikan secara mandiri.



#### I. Strategi Divide and Conquer (Bagi dan Kuasai)



Konsep Dasar:

Strategi Divide and Conquer (Bagi dan Kuasai) adalah pendekatan desain algoritma yang memecah masalah besar menjadi sub-masalah yang lebih kecil dan independen yang serupa dengan masalah aslinya. Sub-masalah ini kemudian diselesaikan secara rekursif, dan solusi dari sub-masalah digabungkan untuk mendapatkan solusi akhir dari masalah asli.

Prinsip Kerja:

Strategi ini melibatkan tiga langkah utama:

1. **Divide (Bagi):** Memecah masalah menjadi dua atau lebih sub-masalah yang lebih kecil (biasanya berukuran sama) dari jenis yang sama.
2. **Conquer (Kuasai):** Menyelesaikan setiap sub-masalah secara rekursif. Jika sub-masalah cukup kecil, ia diselesaikan secara langsung (basis kasus).
3. **Combine (Gabungkan):** Menggabungkan solusi dari sub-masalah untuk mendapatkan solusi dari masalah asli.

**Kapan Menggunakan Divide and Conquer?**

- Ketika masalah dapat dipecah menjadi sub-masalah yang lebih kecil yang serupa dengan masalah asli.
- Ketika sub-masalah saling independen.
- Contoh masalah yang sering diselesaikan dengan strategi ini: pengurutan (Merge Sort, Quick Sort), pencarian (Binary Search), transformasi Fourier cepat (FFT), perkalian matriks Strassen.

**Contoh Sederhana: Pencarian Biner (Binary Search)**

**Masalah:** Mencari posisi (indeks) suatu elemen dalam array (larik) yang sudah terurut.

Algoritma dengan Divide and Conquer (Binary Search):

Misalkan kita memiliki array terurut [2, 5, 8, 12, 16, 23, 38, 56, 72, 91] dan ingin mencari angka 23.

1. **Divide:**
   - Tentukan titik tengah array. Bandingkan elemen yang dicari (`23`) dengan elemen di titik tengah.
   - Jika elemen tengah lebih besar dari yang dicari, cari di bagian kiri array.
   - Jika elemen tengah lebih kecil dari yang dicari, cari di bagian kanan array.
   - Jika elemen tengah sama dengan yang dicari, ditemukan!
2. **Conquer:**
   - Terus ulangi proses "divide" pada sub-array yang relevan sampai elemen ditemukan atau sub-array menjadi kosong.
3. **Combine:**
   - Tidak ada langkah "combine" eksplisit dalam Binary Search karena solusi ditemukan langsung di fase "conquer".

**Langkah-langkah Pencarian Angka 23 pada `[2, 5, 8, 12, 16, 23, 38, 56, 72, 91]`:**

- **Iterasi 1:**
  - Array: `[2, 5, 8, 12, 16, 23, 38, 56, 72, 91]`
  - Tengah: `16` (indeks 4).
  - `23 > 16`, jadi cari di sisi kanan.
- **Iterasi 2:**
  - Sub-array: `[23, 38, 56, 72, 91]`
  - Tengah: `56` (indeks 7 dari array asli, indeks 2 dari sub-array ini).
  - `23 < 56`, jadi cari di sisi kiri.
- **Iterasi 3:**
  - Sub-array: `[23]`
  - Tengah: `23` (indeks 5 dari array asli).
  - `23 == 23`, ditemukan! Angka 23 berada pada indeks 5.

**Flowchart Sederhana (Konseptual) untuk Binary Search:**

Cuplikan kode

```
graph TD
    A[Start] --> B(Inisialisasi: low=0, high=N-1, target);
    B --> C{low <= high?};
    C -- Yes --> D[mid = (low + high) / 2];
    D --> E{Array[mid] == target?};
    E -- Yes --> F[Return mid (target found)];
    E -- No --> G{Array[mid] < target?};
    G -- Yes --> H[low = mid + 1];
    H --> C;
    G -- No --> I[high = mid - 1];
    I --> C;
    C -- No --> J[Return -1 (target not found)];
    F --> K[End];
    J --> K;
```



#### II. Strategi Greedy Algorithm (Algoritma Rakus)



Konsep Dasar:

Greedy Algorithm adalah strategi algoritma yang membangun solusi langkah demi langkah. Pada setiap langkah, algoritma membuat pilihan yang "terbaik" atau "paling optimal" pada saat itu (secara lokal) tanpa mempertimbangkan konsekuensi di masa depan. Algoritma ini berasumsi bahwa pilihan optimal lokal akan menghasilkan solusi optimal global.

**Prinsip Kerja:**

- Pada setiap tahap, pilih opsi yang tampak paling menguntungkan (rakus).
- Jangan pernah mempertimbangkan untuk kembali ke pilihan sebelumnya.
- Berharap bahwa serangkaian pilihan optimal lokal akan mengarah pada solusi optimal global.

**Kapan Menggunakan Greedy Algorithm?**

- Ketika masalah memiliki "struktur optimal" (solusi optimal global dapat dibangun dari solusi optimal sub-masalah).
- Ketika ada "properti pilihan rakus" (pilihan optimal lokal tidak akan menghalangi pencapaian solusi optimal global).
- Contoh masalah yang sering diselesaikan dengan strategi ini: masalah pertukaran uang koin, masalah knapsack fraksional, algoritma Dijkstra (untuk jalur terpendek), algoritma Prim dan Kruskal (untuk pohon rentang minimum).

**Contoh Sederhana: Masalah Pertukaran Uang Koin**

**Masalah:** Mengembalikan sejumlah uang menggunakan jumlah koin seminimal mungkin, dengan denominasi koin tertentu.

**Denominasi Koin yang Tersedia di Indonesia:**

- Rp1.000, Rp500, Rp200, Rp100 (dan koin-koin lain seperti Rp50, Rp25, Rp10 yang kurang umum untuk kembalian besar). Untuk contoh ini, kita pakai Rp1.000, Rp500, Rp200, Rp100.

**Algoritma Greedy (Pertukaran Koin):**

1. Mulai dengan jumlah uang yang harus dikembalikan.
2. Pilih koin dengan denominasi terbesar yang masih kurang atau sama dengan sisa uang yang harus dikembalikan.
3. Gunakan koin tersebut, dan kurangi sisa uang.
4. Ulangi langkah 2 dan 3 sampai sisa uang menjadi nol.

**Contoh: Kembalian Rp2.750**

1. Uang kembalian = Rp2.750.
2. **Koin Rp1.000:**
   - Apakah Rp1.000 <= Rp2.750? Ya.
   - Ambil 1 koin Rp1.000. Sisa uang = Rp1.750. (Jumlah koin: 1 x Rp1.000)
   - Apakah Rp1.000 <= Rp1.750? Ya.
   - Ambil 1 koin Rp1.000. Sisa uang = Rp750. (Jumlah koin: 2 x Rp1.000)
3. **Koin Rp500:**
   - Apakah Rp500 <= Rp750? Ya.
   - Ambil 1 koin Rp500. Sisa uang = Rp250. (Jumlah koin: 2 x Rp1.000, 1 x Rp500)
4. **Koin Rp200:**
   - Apakah Rp200 <= Rp250? Ya.
   - Ambil 1 koin Rp200. Sisa uang = Rp50. (Jumlah koin: 2 x Rp1.000, 1 x Rp500, 1 x Rp200)
5. **Koin Rp100:**
   - Apakah Rp100 <= Rp50? Tidak.
6. **Koin Rp50:**
   - Apakah Rp50 <= Rp50? Ya.
   - Ambil 1 koin Rp50. Sisa uang = Rp0. (Jumlah koin: 2 x Rp1.000, 1 x Rp500, 1 x Rp200, 1 x Rp50)

**Hasil:** Untuk kembalian Rp2.750, dibutuhkan 2 koin Rp1.000, 1 koin Rp500, 1 koin Rp200, dan 1 koin Rp50. Ini adalah jumlah koin minimal.

**Penting:** Algoritma Greedy tidak selalu menghasilkan solusi optimal global untuk semua masalah. Untuk masalah pertukaran koin, Greedy bekerja optimal jika denominasi koin tertentu memiliki properti khusus (misalnya, sistem koin standar). Namun, untuk beberapa set denominasi koin, Greedy bisa gagal (misal, jika ada koin Rp1, Rp3, Rp4, dan perlu kembalian Rp6, Greedy akan pakai Rp4+Rp1+Rp1=3 koin, padahal optimalnya Rp3+Rp3=2 koin).

**Flowchart Sederhana (Konseptual) untuk Pertukaran Koin Greedy:**

Cuplikan kode

```
graph TD
    A[Start] --> B(Input: Jumlah Uang, Denominasi Koin [besar ke kecil]);
    B --> C[Array Koin Hasil = Kosong];
    C --> D{Jumlah Uang > 0?};
    D -- Yes --> E[Pilih Koin Terbesar yang <= Jumlah Uang];
    E --> F[Tambahkan Koin ke Koin Hasil];
    F --> G[Kurangi Jumlah Uang dengan Nilai Koin];
    G --> D;
    D -- No --> H[Tampilkan Koin Hasil];
    H --> I[End];
```

Materi ini memberikan pemahaman dasar tentang bagaimana strategi Divide and Conquer dan Greedy Algorithm bekerja, serta contoh sederhana untuk membantu peserta didik menerapkan konsep-konsep ini secara mandiri dalam menyelesaikan masalah.

**Sumber Informasi:**

- [Divide and Conquer (Algoritma & Pemrograman)](https://www.google.com/search?q=https://www.youtube.com/watch%3Fv%3DyYJ-u-9R7tQ)
- [Bab 7 Algoritma dan Pemrograman - SMA Negeri 2 Lintau Buo](http://sman2-lintaubuo.sch.id/wp-content/uploads/2022/02/BAB-7-Algoritma-dan-Pemrograman-Siswa.pdf)
- [STRATEGI ALGORITMA (Divide and Conquer) - Slideshare](https://www.google.com/search?q=https://www.slideshare.net/slideshow/strategi-algoritma-divide-and-conquer/16149959)
- [Algoritma Greedy - Slideshare](https://www.google.com/search?q=https://www.slideshare.net/slideshow/algoritma-greedy/10706691)
- [Algoritma Greedy | PDF - Scribd](https://www.google.com/search?q=https://id.scribd.com/document/556942475/Algoritma-Greedy)
- [Algoritma Divide and Conquer - Jago Ngoding](https://www.google.com/search?q=https://jagongoding.com/algoritma-dan-struktur-data/algoritma-divide-and-conquer/)
- [Algoritma Greedy - Jago Ngoding](https://www.google.com/search?q=https://jagongoding.com/algoritma-dan-struktur-data/algoritma-greedy/)
- [Studi Kasus Algoritma Greedy | PDF - Scribd](https://www.google.com/search?q=https://id.scribd.com/document/582092122/Studi-Kasus-Algoritma-Greedy)
- [Algoritma Greedy - CODEPOLITAN](https://www.google.com/search?q=https://www.codepolitan.com/course/intro/algoritma-greedy/)
- [Bab 14 Divide and Conquer - Universitas Budi Luhur](https://www.google.com/search?q=https://fti.budiluhur.ac.id/wp-content/uploads/2020/07/Bab-14-Divide-and-Conquer.pdf)
- [Algoritma Greedy - Teknik Informatika UNTAN](https://www.google.com/search?q=http://informatika.untan.ac.id/wp-content/uploads/2014/12/Algoritma-Greedy.pdf)
- [Strategi Algoritma - Universitas Komputer Indonesia](https://www.google.com/search?q=http://repository.unikom.ac.id/48450/1/STRATEGI%20ALGORITMA.pdf)
- [Algoritma Divide and Conquer - Ilmu Komputer](https://www.google.com/search?q=https://ilmukomputer.org/wp-content/uploads/2008/04/divide-and-conquer.pdf)
- [Pengertian Algoritma Divide and Conquer – Materi Dosen](https://www.google.com/search?q=https://materi.dosen.unas.ac.id/pengertian-algoritma-divide-and-conquer/)
- [ALGORITMA GREEDY - Materi Kuliah TI](https://www.google.com/search?q=https://www.materikuliah.id/wp-content/uploads/2021/08/Materi-Kuliah-Algoritma-Greedy.pdf)
- [ALGORITMA DIVIDE AND CONQUER - Materi Kuliah TI](https://www.google.com/search?q=https://www.materikuliah.id/wp-content/uploads/2021/08/Materi-Kuliah-ALGORITMA-DIVIDE-AND-CONQUER.pdf)
- [ALGORITMA GREEDY - Universitas Bina Sarana Informatika](https://www.google.com/search?q=https://repository.bsi.ac.id/index.php/unduh/item/296715/Algoritma-Greedy.pdf)
- [Algoritma Greedy - Universitas PGRI Semarang](https://www.google.com/search?q=https://repository.upgris.ac.id/2968/1/Algoritma%20Greedy%202.pdf)