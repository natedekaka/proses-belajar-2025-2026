## Soal Essay Informatika (Variabel dan Tipe Data Python)



1. Jelaskan konsep **Variabel** dalam pemrograman Python, termasuk analogi yang digunakan untuk mempermudah pemahaman. Sebutkan dua sifat utama variabel di Python.
2. Python memiliki aturan ketat dalam penamaan variabel. Sebutkan dan jelaskan tiga aturan utama dalam penamaan variabel yang harus diikuti, serta berikan satu contoh nama variabel yang **salah** dan satu contoh yang **benar** untuk setiap aturan.
3. Dalam Python, jelaskan perbedaan mendasar antara tipe data **Integer (`int`)** dan **Float**. Berikan contoh nilai yang sesuai untuk masing-masing tipe data tersebut.
4. Jelaskan apa yang dimaksud dengan **Multiple Assignment (Penugasan Ganda)** dalam Python dan berikan dua bentuk sintaksis (cara) untuk melakukannya beserta contohnya.
5. Fungsi `input()` dalam Python selalu menghasilkan tipe data `string`. Jelaskan mengapa konversi tipe data diperlukan setelah menggunakan `input()` untuk mendapatkan nilai numerik (misalnya, umur atau tinggi), dan sebutkan fungsi konversi yang tepat untuk mengubah input tersebut menjadi bilangan bulat (**Integer**).

------



## Jawaban Essay



1. 

   ### Konsep Variabel dan Sifat Variabel

   

   - **Variabel** adalah wadah penyimpanan data di memori komputer yang diberi label/nama.
   - **Analogi:** Variabel diibaratkan sebagai **kotak berlabel**, di mana label adalah nama variabel (`nama`) dan isi kotak adalah nilai/data yang disimpan (`"Budi"`).
   - **Dua Sifat Utama Variabel di Python:**
     1. **Dinamis:** Tipe data dari variabel bisa berubah saat program berjalan (misalnya, dari `int` menjadi `str`).
     2. **Case-sensitive:** Nama variabel membedakan huruf besar dan huruf kecil (`nama` berbeda dengan `Nama`).

2. 

   ### Aturan Penamaan Variabel

   

   Aturan utama penamaan variabel di Python adalah:

   - **Aturan 1: Tidak boleh diawali angka.**
     - **Contoh Salah:** `1nama = "Eko"`
     - **Contoh Benar:** `nama1 = "Eko"`
   - **Aturan 2: Tidak boleh pakai tanda minus (-).**
     - **Contoh Salah:** `nama-depan = "Alice"`
     - **Contoh Benar:** `nama_depan = "Alice"` (menggunakan *underscore*)
   - **Aturan 3: Tidak boleh pakai spasi.**
     - **Contoh Salah:** `nama depan = "Bob"`
     - **Contoh Benar:** `nama_depan = "Bob"`

3. 

   ### Perbedaan Integer (int) dan Float

   

   - **Integer (`int`):** Adalah tipe data untuk **bilangan bulat** (positif, negatif, atau nol) tanpa komponen desimal.
     - **Contoh Nilai:** `25`, `1998`, `-10`.
   - **Float:** Adalah tipe data untuk **bilangan desimal** atau bilangan pecahan, yang penulisannya menggunakan **titik (.)** sebagai pemisah desimal.
     - **Contoh Nilai:** `170.5`, `3.14`, `65.7`.

4. 

   ### Multiple Assignment (Penugasan Ganda)

   

   - **Multiple Assignment** adalah cara untuk membuat beberapa variabel dan memberikan nilai padanya dalam satu baris kode, sehingga mempermudah penulisan.
   - **Dua Bentuk Sintaksis:**
     1. **Untuk variabel bernilai sama:**
        - **Sintaksis:** `x = y = z = nilai`
        - **Contoh:** `a = b = c = 0`
     2. **Untuk variabel dengan nilai berbeda (Unpacking):**
        - **Sintaksis:** `var1, var2, var3 = nilai1, nilai2, nilai3`
        - **Contoh:** `nama, umur = "Bob", 25`

5. 

   ### Fungsi `input()` dan Konversi Tipe Data

   

   - Fungsi `input()` selalu menghasilkan tipe data **String** (`str`) karena ia dirancang untuk menerima input teks dari pengguna.
   - **Konversi Tipe Data Diperlukan** karena data bertipe `string` tidak dapat digunakan dalam operasi matematika (seperti perhitungan usia, rata-rata, dsb.). Untuk melakukan perhitungan, data numerik tersebut harus diubah ke tipe data numerik.
   - **Fungsi Konversi yang Tepat** untuk mengubah input string menjadi bilangan bulat (**Integer**) adalah: `int()`.
     - **Contoh Penerapan:** `umur = int(input("Masukkan umur: "))`