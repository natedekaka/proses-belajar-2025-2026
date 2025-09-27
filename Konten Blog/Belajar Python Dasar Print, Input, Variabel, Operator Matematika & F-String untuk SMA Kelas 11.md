### **Belajar Python Dasar: Print, Input, Variabel, Operator Matematika & F-String untuk SMA Kelas 11**  
*(Cocok untuk Pemula! Siap Posting Blog)*  

---

#### **Pendahuluan**  
**Daniarsyah** - teman-teman SMA! Python itu seperti bahasa rahasia yang bikin komputer ngerti apa yang kita mau. Di kelas 11, kita bakal kenalan sama **dasar-dasar Python** yang super penting: `print()`, `input()`, **variabel**, **operator matematika**, dan **f-string** (teknik formatting kece!). Jangan khawatir, materinya dibuat seru dan gampang dipahami. Yuk, mulai petualangan coding kita!  

---

### **1. Fungsi `print()` – Komputer Bicara!**  
`print()` adalah cara buat komputer "ngomong" ke kita. Fungsinya? **Menampilkan teks atau hasil** di layar.  

#### **Contoh:**  
```python
print("Halo, aku belajar Python!")
print("Siswa SMA kelas 11 keren!")
```
**Output:**  
```
Halo, aku belajar Python!
Siswa SMA kelas 11 keren!
```

#### **Tips:**  
- Teks harus diapit **tanda kutip** (`"` atau `'`).  
- Bisa juga nampilin angka:  
  ```python
  print(2024)  # Output: 2024
  ```

---

### **2. Fungsi `input()` – Komputer Dengar!**  
`input()` buat komputer **dengerin** apa yang kita ketik. Fungsinya? **Minta data dari user**.  

#### **Contoh:**  
```python
nama = input("Siapa namamu? ")
print("Halo, " + nama + "! Senang bertemu denganmu.")
```
**Output:**  
```
Siapa namamu? Budi  
Halo, Budi! Senang bertemu denganmu.
```

#### **Penjelasan:**  
- `input("Teks pertanyaan")` → Nampilin pertanyaan dan nunggu jawaban.  
- Hasil input **selalu berupa teks (string)**, meskipun kita ketik angka!  

---

### **3. Variabel – Kotak Penyimpanan Ajaib**  
Variabel itu seperti **kotak penyimpanan** buat nyimpen data. Kita kasih nama, lalu isi dengan nilai.  

#### **Aturan Penamaan Variabel:**  
- Nama harus unik (tidak boleh spasi atau simbol khusus kecuali `_`).  
- Case-sensitive: `nama` ≠ `Nama`.  
- Contoh nama valid: `umur`, `nilai_ujian`, `namaSiswa`.  

#### **Contoh Penggunaan:**  
```python
# Simpen data ke variabel
nama = "Rina"
umur = 17
nilai = 89.5

# Tampilkan hasil
print("Nama:", nama)
print("Umur:", umur, "tahun")
print("Nilai:", nilai)
```
**Output:**  
```
Nama: Rina
Umur: 17 tahun
Nilai: 89.5
```

#### **Tips:**  
- Gunakan `=` buat ngasih nilai ke variabel.  
- Bisa simpen teks (string), angka bulat (integer), atau desimal (float).  

---

### **4. F-String – Cara Keren Menampilkan Teks dan Variabel**  
F-String (formatted string literal) adalah cara **modern dan mudah** untuk menampilkan teks bersama variabel. Kita pakai tanda `f` sebelum tanda kutip dan masukkan variabel di dalam kurung kurawal `{}`.  

#### **Contoh:**  
```python
nama = "Andi"
umur = 16
print(f"Halo, nama saya {nama} dan umur saya {umur} tahun.")
```
**Output:**  
```
Halo, nama saya Andi dan umur saya 16 tahun.
```

#### **Kelebihan F-String:**  
- **Lebih singkat** dan mudah dibaca.  
- Bisa langsung pakai ekspresi matematika di dalam `{}`:  
  ```python
  a = 5
  b = 3
  print(f"Hasil penjumlahan: {a + b}")  # Output: Hasil penjumlahan: 8
  ```
- Bisa format angka (misal: desimal, persen):  
  ```python
  nilai = 89.5
  print(f"Nilai: {nilai:.1f}")  # Output: Nilai: 89.5 (1 angka di belakang koma)
  ```

#### **Perbandingan dengan Cara Lama:**  
```python
# Cara lama (menggunakan .format())
nama = "Budi"
print("Halo, {}".format(nama))

# Cara lama (menggunakan %)
nama = "Budi"
print("Halo, %s" % nama)

# Cara baru (f-string) - direkomendasikan!
nama = "Budi"
print(f"Halo, {nama}")
```

F-String adalah **pilihan terbaik** untuk formatting string di Python modern. Yuk, pakai f-string biar kode kita makin kece!  

---

### **5. Operator Matematika – Kalkulator Super Cepat!**  
Python bisa jadi kalkulator! Operator matematika buat ngitung angka.  

#### **Jenis Operator:**  
| Operator | Fungsi          | Contoh    | Hasil |
| -------- | --------------- | --------- | ----- |
| `+`      | Penjumlahan     | `5 + 3`   | 8     |
| `-`      | Pengurangan     | `10 - 4`  | 6     |
| `*`      | Perkalian       | `6 * 7`   | 42    |
| `/`      | Pembagian       | `15 / 4`  | 3.75  |
| `//`     | Pembagian Bulat | `15 // 4` | 3     |
| `%`      | Sisa Bagi       | `10 % 3`  | 1     |
| `**`     | Pangkat         | `2 ** 3`  | 8     |

#### **Contoh Kode (dengan F-String):**  
```python
a = 10
b = 3

print(f"Penjumlahan: {a + b}")      # Output: 13
print(f"Pengurangan: {a - b}")      # Output: 7
print(f"Perkalian: {a * b}")        # Output: 30
print(f"Pembagian: {a / b}")        # Output: 3.333...
print(f"Pembagian bulat: {a // b}") # Output: 3
print(f"Sisa bagi: {a % b}")        # Output: 1
print(f"Pangkat: {a ** b}")         # Output: 1000
```

---

### **Latihan Seru!**  
Coba kerjain soal di bawah ini. Jawaban ada di akhir artikel ya!  

#### **Soal 1: Print & Input (dengan F-String)**  
Buat program yang minta **nama lengkap** dan **kelas** user, lalu tampilkan:  
```
Halo [nama lengkap], selamat datang di kelas [kelas]!
```

#### **Soal 2: Variabel & Operator**  
Diketahui:  
- `panjang = 12`  
- `lebar = 8`  
Hitung **luas** (`panjang × lebar`) dan **keliling** (`2 × (panjang + lebar)`) persegi panjang!  

#### **Soal 3: Gabungan Semua! (F-String + Operator)**  
Buat program kalkulator sederhana:  
1. Minta 2 angka dari user.  
2. Hitung **jumlah**, **selisih**, **kali**, dan **bagi**.  
3. Tampilkan semua hasil dengan f-string!  

---

### **Kunci Jawaban Latihan**  
#### **Jawaban Soal 1 (dengan F-String):**  
```python
nama = input("Masukkan nama lengkap: ")
kelas = input("Masukkan kelas: ")
print(f"Halo {nama}, selamat datang di kelas {kelas}!")
```

#### **Jawaban Soal 2:**  
```python
panjang = 12
lebar = 8
luas = panjang * lebar
keliling = 2 * (panjang + lebar)
print(f"Luas: {luas}")       # Output: Luas: 96
print(f"Keliling: {keliling}") # Output: Keliling: 40
```

#### **Jawaban Soal 3 (dengan F-String):**  
```python
angka1 = float(input("Masukkan angka pertama: "))
angka2 = float(input("Masukkan angka kedua: "))
print(f"Jumlah: {angka1 + angka2}")
print(f"Selisih: {angka1 - angka2}")
print(f"Kali: {angka1 * angka2}")
print(f"Bagi: {angka1 / angka2}")
```

---

### **Penutup**  
Selamat! Kamu sudah kuasai **dasar Python** yang penting banget. Ingat:  
- `print()` → Komputer ngomong.  
- `input()` → Komputer dengerin.  
- Variabel → Kotak penyimpanan data.  
- Operator → Kalkulator ajaib.  
- **F-String** → Cara keren nampilin teks + variabel!  

Terus latihan, jangan takut salah! Coding itu seperti naik sepeda: awalnya goyang, lama-lama jago. Sampai jumpa di materi berikutnya! 💻✨  

**"Python itu mudah kalau kita pelan-pelan dan banyak praktek!"**  

---
*Jangan lupa share ke teman-teman ya! Biar kita belajar bareng-bareng.* 😊