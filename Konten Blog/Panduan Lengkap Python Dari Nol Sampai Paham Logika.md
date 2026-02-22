# Panduan Lengkap Python: Dari Nol Sampai Paham Logika

Selamat datang di dunia pemrograman Python! Bayangkan Python sebagai bahasa yang digunakan untuk "mengobrol" dengan komputer. Jika kita ingin komputer melakukan sesuatu, kita harus memberinya perintah dengan tata bahasa yang benar.

Mari kita bedah satu per satu.

---

## BAB 1: Variabel & Tipe Data (Kotak Penyimpanan)

### Konsep Dasar
Bayangkan **Variabel** itu seperti sebuah **kardus atau kotak**.
*   Kita memberi label pada kardus itu (Nama Variabel).
*   Kita memasukkan sesuatu ke dalamnya (Nilai/Value).
*   Kita bisa mengambil isinya kapan saja.

Di Python, kita tidak perlu mendeklarasikan jenis kotaknya di awal. Python cukup pintar untuk menebak isi kotak tersebut. Ini disebut **Tipe Data**.

### 4 Tipe Data Utama

1.  **String (`str`)**: Teks atau kalimat. Harus diapit tanda kutip (`'...'` atau `"..."`).
2.  **Integer (`int`)**: Angka bulat (tanpa koma).
3.  **Float (`float`)**: Angka desimal (pakai koma/titik).
4.  **Boolean (`bool`)**: Hanya punya dua nilai: `True` (Benar) atau `False` (Salah). Seperti saklar lampu.

### Contoh Kode

```python
# Membuat Variabel (Mengisi Kardus)
nama_siswa = "Budi"        # String
umur = 17                  # Integer
tinggi_badan = 165.5       # Float
lulus_ujian = True         # Boolean

# Menampilkan Isi Variabel
print("Nama:", nama_siswa)
print("Umur:", umur)
print("Tinggi:", tinggi_badan)
print("Status Lulus:", lulus_ujian)

# Cek Tipe Data (Untuk memastikan isi kardus)
print(type(nama_siswa))    # Output: <class 'str'>
print(type(umur))          # Output: <class 'int'>
```

> **💡 Catatan Penting:**
> *   Nama variabel tidak boleh pakai spasi (gunakan `_` sebagai ganti spasi, contoh: `nama_siswa`).
> *   Python membedakan huruf besar dan kecil (`Nama` beda dengan `nama`).

---

## BAB 2: Struktur Kontrol (Logika Percabangan)

### Konsep Dasar
Dalam hidup, kita sering mengambil keputusan berdasarkan kondisi.
*   **JIKA** hujan turun, **MAKA** bawa payung.
*   **JIKA TIDAK** (cerah), **MAKA** pakai topi.

Di Python, ini disebut `if-else`. Komputer akan mengecek sebuah kondisi. Jika benar, dia jalankan kode A. Jika salah, dia jalankan kode B.

### Aturan Emas: Indentasi (Spasi)
Python sangat peduli pada kerapian. Kode yang berada di dalam `if` atau `else` **harus menjorok ke dalam** (biasanya 4 spasi atau 1 tab). Ini menandakan bahwa kode tersebut adalah "anak" dari perintah `if`.

### Contoh Kode

```python
nilai = 75

# Logika Percabangan
if nilai >= 70:
    print("Selamat! Anda Lulus.")  # Kode ini menjorok ke dalam (Indentasi)
    print("Pertahankan prestasimu!")
else:
    print("Maaf, Anda belum lulus.")
    print("Belajar lebih giat lagi ya.")

print("Terima kasih sudah ikut ujian.") # Kode ini sejajar dengan 'if', jadi selalu dijalankan
```

**Penjelasan:**
1.  Komputer cek: Apakah `nilai` (75) lebih besar atau sama dengan 70?
2.  Karena **Ya (True)**, maka komputer menjalankan kode di bawah `if`.
3.  Kode di bawah `else` dilewati (di-skip).
4.  Kode terakhir (`Terima kasih...`) dijalankan karena posisinya sudah keluar dari blok `if-else`.

---

## BAB 3: Perulangan (Looping)

### Konsep Dasar
Komputer itu hebat dalam mengerjakan hal yang sama berulang-ulang tanpa merasa bosan. Untuk menyuruh komputer melakukan itu, kita menggunakan **Looping**.

Ada dua jenis utama: `for` dan `while`.

### 🅰️ Perulangan `for` (Analogi: Lari di Lapangan)

**Analogi untuk Siswa:**
Bayangkan seorang pelatih olahraga menyuruh kamu lari keliling lapangan.
Pelatih bilang: *"Lari sebanyak **5 putaran**!"*

Kamu tahu pasti kapan mulainya dan kapan berakhirnya (putaran 1 sampai 5). Kamu menghitung: 1, 2, 3, 4, 5. Selesai.

Ini adalah **`for` loop**. Kita menggunakannya ketika kita **tahu berapa kali** kita ingin mengulang sesuatu.

**Contoh Kode:**
```python
# range(1, 6) artinya mulai dari angka 1, tapi berhenti SEBELUM angka 6
# Jadi urutannya: 1, 2, 3, 4, 5

print("Mulai Lari!")

for putaran in range(1, 6):
    print(f"Sedang lari putaran ke-{putaran}")

print("Selesai Lari! Istirahat.")
```

**Output:**
```text
Mulai Lari!
Sedang lari putaran ke-1
Sedang lari putaran ke-2
Sedang lari putaran ke-3
Sedang lari putaran ke-4
Sedang lari putaran ke-5
Selesai Lari! Istirahat.
```

---

### 🅱️ Perulangan `while` (Analogi: Lari Sampai Lelah)

**Analogi untuk Siswa:**
Sekarang pelatih bilang: *"Larilah terus **selama** kamu belum lelah!"*

Di sini, kamu tidak tahu berapa putarannya. Bisa 3 putaran, bisa 10 putaran. Yang penting, **selama** kondisi "belum lelah" itu benar (`True`), kamu terus lari. Begitu kamu lelah (`False`), kamu berhenti.

Ini adalah **`while` loop**. Kita menggunakannya ketika kita **tidak tahu pasti berapa kali** mengulang, tapi tahu **kapan harus berhenti**.

**Contoh Kode:**
```python
energi = 5  # Kita punya 5 poin energi

print("Mulai Lari Bebas!")

while energi > 0:
    print(f"Lari! Sisa energi: {energi}")
    energi = energi - 1  # Setiap lari, energi berkurang 1

print("Energi habis! Berhenti lari.")
```

**Output:**
```text
Mulai Lari Bebas!
Lari! Sisa energi: 5
Lari! Sisa energi: 4
Lari! Sisa energi: 3
Lari! Sisa energi: 2
Lari! Sisa energi: 1
Energi habis! Berhenti lari.
```

> **⚠️ Bahaya `while`:**
> Hati-hati! Jika kondisi tidak pernah menjadi `False` (misalnya energi tidak dikurangi), komputer akan lari selamanya. Ini disebut *Infinite Loop* dan bisa membuat program kamu *hang/error*.

---

## Tantangan Kecil (Latihan)

Coba gabungkan semua ilmu di atas untuk membuat program sederhana ini:

**Kasus:**
Buatlah program untuk mengecek apakah seorang anak boleh menonton film horor.
1.  Buat variabel `umur`.
2.  Gunakan `if-else`: Jika umur di atas 17 tahun, cetak "Boleh Nonton". Jika tidak, cetak "Dilarang Nonton".
3.  Jika "Dilarang Nonton", gunakan loop `for` untuk mencetak kata "Nonton kartun saja" sebanyak 3 kali sebagai saran.

**Kunci Jawaban (Coba dulu sendiri sebelum intip!):**

<details>
<summary>👉 Klik untuk melihat jawaban</summary>

```python
umur = 15  # Coba ubah angka ini untuk mengetes

if umur >= 17:
    print("Boleh Nonton Film Horor.")
else:
    print("Dilarang Nonton Film Horor.")
    print("Saran untukmu:")
    
    # Looping untuk memberikan saran
    for i in range(1, 4):
        print(f"{i}. Nonton kartun saja")
```
</details>

---

## Ringkasan

1.  **Variabel**: Kotak untuk menyimpan data (String, Integer, Float, Boolean).
2.  **If-Else**: Membuat keputusan (Jika A maka B, jika tidak maka C). Perhatikan **indentasi**!
3.  **For Loop**: Perulangan yang sudah jelas jumlahnya (Seperti lari 5 putaran).
4.  **While Loop**: Perulangan berdasarkan kondisi (Seperti lari selama belum lelah).

Selamat! Anda sudah menguasai dasar logika pemrograman Python. Langkah selanjutnya adalah mempelajari **Fungsi** dan **List**, tapi pastikan pondasi di atas sudah benar-benar kuat dulu.

*Selamat Berkode! 