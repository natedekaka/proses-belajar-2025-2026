### Konsep Dasar Algoritma dan Flowchart



Peserta didik diharapkan dapat memahami konsep dasar algoritma dan flowchart sebagai pondasi penting dalam berpikir logis dan sistematis, terutama dalam konteks pemrograman.



#### I. Algoritma



Pengertian Algoritma:

Algoritma adalah urutan langkah-langkah yang disusun secara logis dan sistematis untuk menyelesaikan suatu masalah. Algoritma bersifat prosedural, artinya serangkaian instruksi yang harus diikuti secara berurutan untuk mencapai hasil yang diinginkan.

- **Logis dan Sistematis:** Setiap langkah harus masuk akal dan terorganisir dengan baik.
- **Tidak Bergantung pada Bahasa Pemrograman:** Algoritma adalah konsep universal yang dapat diterapkan pada bahasa pemrograman apa pun.
- **Penyelesaian Masalah:** Tujuan utama algoritma adalah untuk memecahkan masalah.

**Ciri-ciri Algoritma yang Baik:**

- **Terbatas (Finiteness):** Algoritma harus berakhir setelah sejumlah langkah yang terbatas, mencapai tujuan akhir.
- **Jelas (Definiteness):** Setiap langkah harus didefinisikan dengan tepat dan tidak ambigu, sehingga tidak ada keraguan dalam pelaksanaannya.
- **Masukan (Input):** Algoritma memiliki nol atau lebih masukan yang diberikan untuk diproses.
- **Keluaran (Output):** Algoritma menghasilkan satu atau lebih keluaran yang merupakan solusi dari masalah.
- **Efektivitas (Effectiveness):** Setiap langkah harus sederhana dan dapat dijalankan dalam waktu yang wajar.

Struktur Dasar Algoritma:

Algoritma umumnya tersusun dari tiga struktur dasar:

1. **Runtutan (Sequence):** Perintah dikerjakan satu per satu secara berurutan dari awal hingga akhir.
   - *Contoh:* Algoritma membuat kopi instan (Tuang kopi, tuang air panas, aduk).
2. **Pemilihan (Selection/Percabangan):** Mengambil keputusan berdasarkan kondisi tertentu. Jika kondisi terpenuhi, satu tindakan dilakukan; jika tidak, tindakan lain dilakukan.
   - *Contoh:* Jika nilai ujian lebih dari 75, maka "Lulus", jika tidak "Tidak Lulus".
3. **Pengulangan (Repetition/Looping):** Menjalankan urutan perintah berulang kali sampai kondisi tertentu terpenuhi.
   - *Contoh:* Menampilkan bilangan kelipatan 5 dari 0 hingga 100.

**Manfaat Mempelajari Algoritma:**

- Membantu memahami alur program sebelum menulis kode.
- Mengurangi kesalahan saat membuat program (error logika).
- Meningkatkan kemampuan berpikir secara logis dan sistematis.
- Memudahkan modifikasi program di kemudian hari.

**Contoh Algoritma Sederhana:**

- **Algoritma Menghitung Luas Segitiga:**
  1. Mulai.
  2. Masukkan nilai alas (a).
  3. Masukkan nilai tinggi (t).
  4. Hitung Luas = 0.5timesatimest.
  5. Tampilkan Luas.
  6. Selesai.
- **Algoritma Menentukan Bilangan Ganjil atau Genap:**
  1. Mulai.
  2. Masukkan sebuah bilangan bulat.
  3. Bagi bilangan tersebut dengan 2.
  4. Jika sisa pembagian adalah 0, maka bilangan tersebut adalah genap.
  5. Jika sisa pembagian bukan 0, maka bilangan tersebut adalah ganjil.
  6. Tampilkan hasil.
  7. Selesai.



#### II. Flowchart



Pengertian Flowchart:

Flowchart atau bagan alir adalah representasi grafis dari suatu algoritma atau proses. Flowchart menggunakan simbol-simbol standar untuk menggambarkan langkah-langkah, keputusan, dan alur data dalam suatu sistem atau program.

**Fungsi Flowchart:**

- **Memvisualisasikan Alur Program:** Membuat alur program lebih mudah dipahami secara visual.
- **Merencanakan Proses:** Membantu dalam merencanakan langkah-langkah yang diperlukan untuk menyelesaikan tugas.
- **Menganalisis Algoritma:** Memudahkan identifikasi dan perbaikan kesalahan (bug) dalam algoritma.
- **Memudahkan Komunikasi:** Menjadi alat komunikasi yang efektif antara pengembang dan pengguna.

Simbol-simbol Dasar Flowchart:

Setiap simbol memiliki makna khusus:

- **Oval/Terminator (Start/End):** Menandakan awal dan akhir dari suatu proses atau algoritma.
- **Persegi Panjang (Process):** Menunjukkan langkah-langkah atau tindakan yang harus dilakukan.
- **Jajar Genjang (Input/Output):** Digunakan untuk menunjukkan masukan atau keluaran data.
- **Belah Ketupat (Decision):** Menunjukkan titik keputusan dalam alur kerja yang memerlukan pilihan "Ya" atau "Tidak".
- **Panah (Flowline):** Menunjukkan arah alur proses.
- **Lingkaran Kecil (Connector):** Menghubungkan bagian-bagian flowchart yang terpisah pada halaman yang sama.

**Aturan Membuat Flowchart:**

- Dimulai dari atas ke bawah dan dari kiri ke kanan.
- Aktivitas yang digambarkan harus jelas dan mudah dimengerti.
- Tentukan dengan jelas kapan aktivitas dimulai dan berakhir.
- Gunakan simbol-simbol flowchart yang standar.

**Contoh Flowchart Sederhana (Menghitung Luas Segitiga):**

```
     [ START ]
        |
        V
[ INPUT ALAS (a) ]
        |
        V
[ INPUT TINGGI (t) ]
        |
        V
[ LUAS = 0.5 * a * t ]
        |
        V
[ TAMPILKAN LUAS ]
        |
        V
      [ END ]
```

**Contoh Flowchart (Menentukan Bilangan Ganjil/Genap):**

```
     [ START ]
        |
        V
[ INPUT BILANGAN ]
        |
        V
  [BILANGAN MOD 2 == 0?] --- (Tidak) ---> [ BILANGAN GANJIL ]
        |                              ^
      (Ya)                             |
        V                              |
[ BILANGAN GENAP ] --------------------
        |
        V
      [ END ]
```

Dengan memahami konsep-konsep ini, peserta didik akan memiliki dasar yang kuat untuk melanjutkan pembelajaran di bidang informatika dan pemrograman.

**Sumber Informasi:**

- [21 Contoh Algoritma Dan Flowchart - Badoy Studio](https://badoystudio.com/contoh-algoritma-dan-flowchart/)
- [Materi Algoritma Dan Flowchart | PDF - Scribd](https://id.scribd.com/document/575401587/MATERI-ALGORITMA-DAN-FLOWCHART)
- [Flowchat pemreograman dasar kelas XI.pptx - SlideShare](https://www.slideshare.net/slideshow/flowchat-pemreograman-dasar-kelas-xipptx/266669862)
- [ALGORITMA DAN PEMROGRAMAN - Poltekkes Kemenkes Yogyakarta](https://eprints.poltekkesjogja.ac.id/11279/1/Modul Algoritma dan Pemograman.pdf)
- [Pengantar Algoritma dan Pemrograman | Komputer - MODUL 1 - Universitas Terbuka](https://pustaka.ut.ac.id/lib/wp-content/uploads/pdfmk/MSIM4203-M1.pdf)
- [Algoritma Dan Pemrograman - Up | PDF | Komputer - Scribd](https://id.scribd.com/document/669566842/Algoritma-Dan-Pemrograman-up)
- [Bab 7 Algoritma dan Pemrograman - SMA Negeri 2 Lintau Buo](http://sman2-lintaubuo.sch.id/wp-content/uploads/2022/02/BAB-7-Algoritma-dan-Pemrograman-Siswa.pdf)
- [Mengenal Dasar Algoritma - FTI - ARS University](https://fti.ars.ac.id/blog/content/mengenal-dasar-algoritma)
- [Algoritma: Pengertian, Sejarah, Jenis, Fungsi, dan Contohnya - Gramedia](https://www.gramedia.com/literasi/pengertian-algoritma/)
- [Pemrograman Dasar SMK Kelas X Sem 1](https://www.smkm08paciran.sch.id/upload/file/38660806PemrogDasarSMK-X-Smt1.pdf)
- [Materi Algoritma Kelas 10: Pengertian, Fungsi, Ciri, & Unsurnya - Tirto.id](https://tirto.id/materi-algoritma-kelas-10-pengertian-fungsi-ciri-dan-unsurnya-gCTw)
- [Algoritma dan Pemrograman Dasar - CODEPOLITAN](https://www.codepolitan.com/course/intro/algoritma-pemrograman-dasar/)
- [Algoritma Pemrograman: Pengertian, Cara Kerja, dan Fungsinya - BINUS UNIVERSITY](https://binus.ac.id/malang/2024/02/algoritma-pemrograman-pengertian-cara-kerja-dan-fungsinya/)
- [Mengenal Flowchart - Selamat Datang di SMPN 1 Panguragan](https://www.smpn1panguragan.sch.id/berita/detail/mengenal-flowchart)
- [Apa Itu Flowchart: Pengertian Menurut Ahli, Fungsi, dan Jenisnya – Gramedia Literasi](https://www.gramedia.com/literasi/flowchart/)
- [Inovasi Berkelanjutan dalam Bisnis: Manfaatkan Flowchart untuk Mengoptimalkan Nilai Limbah Perusahaan Sustainable Innovation in - Jurnal](https://e-journal.nalanda.ac.id/index.php/jipm/article/download/552/529/1852)
- [Flowchart Adalah: Fungsi, Jenis, Simbol, dan Contohnya - Dicoding Blog](https://www.dicoding.com/blog/flowchart-adalah/)
- [BAB I PENDAHULUAN A. Latar Belakang Flowchart atau bagan alir adalah bagan (chart) yang menunjukan alir (flow) di dalam program](https://eprints.ums.ac.id/93073/13/BAB I.pdf)
- [5 Contoh Algoritma Pemrograman Dilengkapi dengan Flowchart - BINUS UNIVERSITY](https://binus.ac.id/malang/2024/02/5-contoh-algoritma-pemrograman-dilengkapi-dengan-flowchart/)
- [ALGORITMA DAN FLOWCHART](https://teknik.univpancasila.ac.id/labkom/praktikum/Modul Praktikum/Raptor/Pertemuan-1 Algoritma dan Flowchart.pdf)