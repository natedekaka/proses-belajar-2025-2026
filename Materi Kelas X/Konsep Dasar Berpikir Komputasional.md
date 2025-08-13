### **Konsep Dasar Berpikir Komputasional**

**Berpikir Komputasional** adalah cara berpikir untuk menyelesaikan masalah dengan menggunakan pendekatan yang mirip dengan cara komputer bekerja. Ini bukan berarti kita harus bisa coding, tapi lebih ke arah bagaimana kita memecah masalah besar menjadi bagian-bagian kecil, mengenali pola, dan membuat langkah-langkah yang logis untuk menyelesaikannya.

Ada empat pilar utama dalam berpikir komputasional, yaitu:

1. **Dekomposisi**: Memecah masalah besar jadi bagian-bagian yang lebih kecil dan mudah dikelola.
2. **Pengenalan Pola**: Mencari kesamaan atau pola pada masalah-masalah yang ada.
3. **Abstraksi**: Fokus pada informasi penting dan mengabaikan detail yang tidak relevan.
4. **Algoritma**: Membuat langkah-langkah atau instruksi yang terstruktur untuk menyelesaikan masalah.



------



### **A. Pencarian (Searching)**

Bayangkan Kita sedang mencari buku di rak perpustakaan. Ada banyak cara untuk mencarinya, bukan? Itu adalah ide dasar dari **pencarian**.

Pencarian adalah proses menemukan item tertentu di dalam sekumpulan data. Kita akan fokus pada dua jenis pencarian yang paling umum:

#### **1. Pencarian Sekuensial (Linear Search)**

- **Ide Dasar**: Mencari satu per satu, dari awal sampai akhir.
- **Analogi**: Kita mencari kunci yang hilang di dalam tumpukan pakaian. Kita mengambil satu per satu baju, memeriksanya, lalu pindah ke baju berikutnya sampai kunci itu ditemukan.
- **Cara Kerja**:

- Mulai dari item pertama.
- Bandingkan item tersebut dengan yang kita cari.
- Jika cocok, pencarian selesai.
- Jika tidak, pindah ke item berikutnya dan ulangi langkah di atas.

- **Kapan digunakan?**: Cocok untuk data yang tidak terurut dan jumlahnya tidak terlalu banyak.

#### **2. Pencarian Biner (Binary Search)**

- **Ide Dasar**: Membagi data menjadi dua bagian, lalu fokus pada salah satu bagian. Ini jauh lebih cepat, tapi datanya harus sudah **terurut**.

- **Analogi**: Mencari kata di kamus. Kita tidak akan membaca dari halaman pertama. Kita akan membuka kamus di bagian tengah. Jika kata yang dicari ada di bagian awal, Kita akan menutup bagian akhir dan fokus pada bagian awal. Begitu seterusnya.
- **Cara Kerja**:

- Data harus **sudah terurut**.
- Tentukan nilai tengah dari data.
- Bandingkan nilai yang kita cari dengan nilai tengah.
- Jika sama, pencarian selesai.
- Jika lebih kecil, fokus pada bagian kiri (sebelum nilai tengah).
- Jika lebih besar, fokus pada bagian kanan (setelah nilai tengah).
- Ulangi langkah ini sampai item ditemukan atau tidak ada lagi data yang bisa dibagi.

- **Kapan digunakan?**: Wajib untuk data yang sudah terurut dan jumlahnya banyak.



------



### **B. Pengurutan (Sorting)**

Pengurutan adalah proses menyusun data (angka, huruf, dll.) ke dalam urutan tertentu, bisa dari yang terkecil ke terbesar (ascending) atau sebaliknya (descending).

Ada banyak algoritma pengurutan, tapi kita akan bahas dua yang paling sederhana dan mudah dipahami.

#### **1. Pengurutan Pilihan (Selection Sort)**

- **Ide Dasar**: Mencari item terkecil dari seluruh data, lalu menukarnya ke posisi paling depan. Ulangi proses ini sampai semua data terurut.
- **Analogi**: Kita sedang mengurutkan kartu remi. Kita mencari kartu terkecil (As) di seluruh tumpukan, lalu menaruhnya di paling kiri. Lalu, dari sisa kartu yang ada, Kita mencari kartu terkecil berikutnya (angka 2), dan menaruhnya di sebelah As. Begitu seterusnya.
- **Cara Kerja**:

- Cari nilai terkecil dari seluruh data.
- Tukar nilai terkecil tersebut dengan nilai yang ada di posisi pertama.
- Lalu, cari nilai terkecil dari sisa data yang belum terurut.
- Tukar nilai terkecil tersebut dengan nilai di posisi kedua.
- Ulangi terus sampai semua data terurut.

#### **2. Pengurutan Gelembung (Bubble Sort)**

- **Ide Dasar**: Membandingkan dua item yang bersebelahan dan menukarnya jika urutannya salah. Proses ini diulang berkali-kali hingga tidak ada lagi item yang perlu ditukar. Item yang paling besar akan "menggelembung" ke posisi paling akhir.
- **Analogi**: Membandingkan berat dua orang yang bersebelahan. Jika yang lebih berat ada di kiri, mereka bertukar posisi. Lalu kita pindah ke dua orang berikutnya. Proses ini diulang-ulang sampai semua orang terurut dari yang paling ringan ke paling berat.
- **Cara Kerja**:

- Mulai dari awal data.
- Bandingkan item pertama dengan item kedua. Jika urutannya salah, tukar posisinya.
- Lalu, bandingkan item kedua dengan item ketiga. Lakukan hal yang sama.
- Ulangi sampai akhir data. Setelah satu putaran, item terbesar akan berada di posisi paling akhir.
- Ulangi lagi proses ini dari awal, tapi kali ini data di posisi terakhir tidak perlu diperiksa lagi karena sudah pasti benar.



------



### **C. Tumpukan (Stack) dan Antrean (Queue)**

Ini adalah dua cara berbeda untuk menyimpan dan mengambil data. Keduanya memiliki aturan yang sangat spesifik.

#### **1. Tumpukan (Stack)**

- **Prinsip**: **LIFO** (Last-In, First-Out). Artinya, data yang terakhir masuk adalah data yang pertama kali keluar.
- **Analogi**: Tumpukan piring. Piring yang terakhir kita letakkan di atas tumpukan adalah piring yang pertama kali kita ambil saat akan makan.
- **Operasi Dasar**:

- **Push**: Memasukkan data ke tumpukan.
- **Pop**: Mengambil data teratas dari tumpukan.

- **Contoh Penerapan**: Tombol "Undo" (kembali) pada aplikasi. Aksi terakhir yang kita lakukan akan dibatalkan terlebih dahulu.

#### **2. Antrean (Queue)**

- **Prinsip**: **FIFO** (First-In, First-Out). Artinya, data yang pertama kali masuk adalah data yang pertama kali keluar.
- **Analogi**: Antrean di loket tiket. Orang yang pertama kali datang dan mengantre adalah orang yang pertama kali dilayani.
- **Operasi Dasar**:

- **Enqueue**: Memasukkan data ke dalam antrean (di posisi belakang).
- **Dequeue**: Mengambil data dari antrean (dari posisi depan).

- **Contoh Penerapan**: Mencetak dokumen. Dokumen yang pertama kali dikirim ke printer akan dicetak terlebih dahulu.