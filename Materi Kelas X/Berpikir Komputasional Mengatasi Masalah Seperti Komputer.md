## Berpikir Komputasional: Mengatasi Masalah Seperti Komputer 

Berpikir komputasional adalah cara berpikir untuk memecahkan masalah. Ini bukan hanya tentang coding, tapi tentang bagaimana kita merancang solusi yang bisa dijalankan oleh komputer. Ada empat pilar utama dalam berpikir komputasional:

1. **Dekomposisi:** Memecah masalah besar menjadi bagian-bagian kecil yang lebih mudah dipecahkan.
2. **Pengenalan Pola:** Mencari pola atau kesamaan dalam masalah yang sudah dipecah.
3. **Abstraksi:** Fokus pada informasi yang penting dan mengabaikan detail yang tidak relevan.
4. **Algoritma:** Membuat langkah-langkah sistematis untuk memecahkan masalah.

Di kelas 10 ini, kita akan fokus pada beberapa algoritma dasar yang penting untuk berpikir komputasional, yaitu pencarian (searching), pengurutan (sorting), dan struktur data sederhana (tumpukan dan antrean).

------



## 1. Pencarian (Searching) 



Bayangkan kamu mencari buku di perpustakaan. Ada dua cara yang bisa kamu lakukan:



### a) Pencarian Beruntun (Sequential Search)



Ini seperti mencari buku satu per satu dari rak paling kiri sampai kamu menemukannya.

- **Cara kerja:** Membandingkan elemen yang dicari dengan setiap elemen dalam daftar, dimulai dari awal.
- **Kapan dipakai:** Ketika daftar tidak diurutkan.
- **Contoh:** Cari angka 7 di daftar: `[2, 9, 4, 7, 5]`.
  - Apakah 2 sama dengan 7? Tidak.
  - Apakah 9 sama dengan 7? Tidak.
  - Apakah 4 sama dengan 7? Tidak.
  - Apakah 7 sama dengan 7? Ya! Ketemu!



### b) Pencarian Biner (Binary Search)



Ini seperti mencari kata di kamus. Kamu tidak akan mencari dari halaman pertama. Kamu akan membuka di tengah, lalu tentukan apakah kata yang kamu cari ada di bagian kiri atau kanan.

- **Syarat:** Daftarnya **harus sudah diurutkan**.
- **Cara kerja:**
  1. Tentukan elemen tengah.
  2. Bandingkan elemen yang dicari dengan elemen tengah.
  3. Jika sama, selesai.
  4. Jika lebih kecil, cari di bagian kiri.
  5. Jika lebih besar, cari di bagian kanan.
  6. Ulangi langkah 1-5 sampai ketemu.
- **Contoh:** Cari angka 7 di daftar terurut: `[2, 4, 5, 7, 9]`.
  - Tengahnya adalah 5. Apakah 7 sama dengan 5? Tidak. Apakah 7 > 5? Ya. Cari di kanan.
  - Bagian kanan: `[7, 9]`. Tengahnya adalah 7. Apakah 7 sama dengan 7? Ya! Ketemu!

------



## 2. Pengurutan (Sorting) 



Pengurutan adalah proses menyusun elemen dalam daftar sesuai urutan tertentu (misalnya, dari kecil ke besar). Ada banyak cara untuk mengurutkan, tapi kita akan bahas dua yang paling mudah dimengerti.



### a) Pengurutan Pilihan (Selection Sort)



Ini seperti menyusun kartu remi. Kamu mencari kartu terkecil, lalu menaruhnya di posisi pertama. Lalu mencari kartu terkecil berikutnya, dan seterusnya.

- **Cara kerja:**
  1. Cari elemen terkecil di seluruh daftar.
  2. Tukar elemen terkecil itu dengan elemen di posisi pertama.
  3. Ulangi langkah 1-2 untuk sisa daftar yang belum diurutkan.
- **Contoh:** Urutkan daftar: `[6, 4, 8, 2]`.
  - Iterasi 1: Terkecil adalah 2. Tukar 2 dengan 6. Daftar jadi `[2, 4, 8, 6]`.
  - Iterasi 2: Di sisa daftar `[4, 8, 6]`, terkecil adalah 4. 4 sudah di posisi yang benar. Daftar jadi `[2, 4, 8, 6]`.
  - Iterasi 3: Di sisa daftar `[8, 6]`, terkecil adalah 6. Tukar 6 dengan 8. Daftar jadi `[2, 4, 6, 8]`.
  - Selesai!



### b) Pengurutan Gelembung (Bubble Sort)



Ini seperti gelembung udara yang naik ke permukaan. Angka-angka yang lebih besar "menggelembung" naik ke akhir daftar melalui pertukaran berulang.

- **Cara kerja:**
  1. Mulai dari awal daftar.
  2. Bandingkan dua elemen yang bersebelahan.
  3. Jika elemen pertama lebih besar dari yang kedua, tukar posisinya.
  4. Ulangi proses ini sampai akhir daftar. Satu iterasi ini akan menempatkan elemen terbesar di posisi terakhir.
  5. Ulangi seluruh proses untuk daftar yang tersisa, sampai tidak ada lagi pertukaran yang terjadi.
- **Contoh:** Urutkan daftar: `[6, 4, 8, 2]`.
  - Iterasi 1:
    - Bandingkan 6 dan 4. Tukar. `[4, 6, 8, 2]`.
    - Bandingkan 6 dan 8. Tidak tukar. `[4, 6, 8, 2]`.
    - Bandingkan 8 dan 2. Tukar. `[4, 6, 2, 8]`. Angka 8 sudah di posisi terakhir.
  - Iterasi 2:
    - Bandingkan 4 dan 6. Tidak tukar. `[4, 6, 2, 8]`.
    - Bandingkan 6 dan 2. Tukar. `[4, 2, 6, 8]`. Angka 6 sudah di posisi yang benar.
  - Iterasi 3:
    - Bandingkan 4 dan 2. Tukar. `[2, 4, 6, 8]`.
  - Selesai! Daftar sudah terurut.

------



## 3. Struktur Data: Tumpukan (Stack) dan Antrean (Queue) 



Struktur data adalah cara mengorganisir data agar lebih efisien. Kita akan belajar dua struktur data dasar yang sering dipakai.



### a) Tumpukan (Stack) 



Bayangkan tumpukan piring. Kamu hanya bisa mengambil piring paling atas dan menaruh piring baru juga di paling atas.

- **Prinsip:** **LIFO** (Last In, First Out) – yang terakhir masuk, yang pertama keluar.
- **Operasi utama:**
  - `Push`: Menambahkan elemen baru di atas tumpukan.
  - `Pop`: Menghapus elemen paling atas dari tumpukan.
- **Contoh:** Tumpukan buku. Kamu taruh buku A, lalu buku B, lalu buku C. Untuk mengambil, kamu harus ambil C dulu, lalu B, baru A.



### b) Antrean (Queue) 



Bayangkan antrean di kasir. Orang yang pertama datang, yang pertama dilayani.

- **Prinsip:** **FIFO** (First In, First Out) – yang pertama masuk, yang pertama keluar.
- **Operasi utama:**
  - `Enqueue`: Menambahkan elemen baru di belakang antrean.
  - `Dequeue`: Menghapus elemen paling depan dari antrean.
- **Contoh:** Antrean siswa. Siswa A datang, lalu B, lalu C. A dilayani lebih dulu, lalu B, baru C.

**Hubungan dengan kehidupan sehari-hari:**

- **Tumpukan:** tombol **`Undo`** di aplikasi (mengembalikan ke kondisi terakhir), history halaman web.
- **Antrean:** printer yang mencetak dokumen (dokumen yang dikirim duluan dicetak duluan), antrean di bank.