### **Materi Fungsi `def` di Python untuk SMA Kelas 11**  
#### **Apa Itu Fungsi dalam Python?**  
Fungsi adalah **blok kode reusable** (dapat digunakan berulang kali) yang menjalankan tugas tertentu. Bayangkan fungsi seperti "resep" dalam memasak: Anda tulis sekali, lalu gunakan kapan saja tanpa menulis ulang.  

**Mengapa Fungsi Penting?**  
- Menghindari penulisan kode berulang (efisien!).  
- Memudahkan pemeliharaan program.  
- Membuat kode lebih terstruktur dan mudah dibaca.  

#### **Cara Membuat Fungsi: `def`**  
Python menggunakan kata kunci `def` untuk mendefinisikan fungsi. Struktur dasarnya:  
```python
def nama_fungsi(parameter):
    # Blok kode fungsi
    return hasil  # Opsional
```

**Penjelasan Komponen:**  
1. **`def`**: Kata kunci untuk memulai fungsi.  
2. **`nama_fungsi`**: Nama unik untuk memanggil fungsi (aturan penamaan seperti variabel).  
3. **`parameter`**: Input yang diterima fungsi (bisa nol atau lebih).  
4. **`:`**: Tanda akhir dari header fungsi.  
5. **`return`**: Mengembalikan nilai hasil (jika tidak ada, fungsi menghasilkan `None`).  

#### **Contoh 1: Fungsi Sederhana Tanpa Parameter**  
Fungsi ini mencetak ucapan selamat datang:  
```python
def sapa():
    print("Halo, selamat datang di kelas Python!")

# Memanggil fungsi
sapa()  # Output: Halo, selamat datang di kelas Python!
```

#### **Contoh 2: Fungsi dengan Parameter**  
Parameter adalah **input** yang diberikan ke fungsi. Misalnya, fungsi untuk menyapa nama tertentu:  
```python
def sapa_nama(nama):
    print(f"Halo, {nama}! Selamat belajar Python.")

# Memanggil fungsi dengan argumen "Andi"
sapa_nama("Andi")  # Output: Halo, Andi! Selamat belajar Python.
```

**Perbedaan Parameter dan Argumen:**  
- **Parameter**: Variabel dalam definisi fungsi (contoh: `nama`).  
- **Argumen**: Nilai yang diberikan saat memanggil fungsi (contoh: `"Andi"`).  

#### **Contoh 3: Fungsi dengan `return`**  
`return` digunakan untuk **mengembalikan nilai** hasil perhitungan. Contoh fungsi hitung luas persegi:  
```python
def luas_persegi(sisi):
    luas = sisi * sisi
    return luas

# Memanggil fungsi dan menyimpan hasil
hasil = luas_persegi(5)
print(f"Luas persegi: {hasil}")  # Output: Luas persegi: 25
```

**Catatan Penting:**  
- Jika tidak ada `return`, fungsi otomatis menghasilkan `None`.  
- `return` menghentikan eksekusi fungsi.  

#### **Contoh 4: Fungsi dengan Banyak Parameter**  
Fungsi dapat memiliki lebih dari satu parameter. Contoh fungsi hitung luas segitiga:  
```python
def luas_segitiga(alas, tinggi):
    return 0.5 * alas * tinggi

# Memanggil fungsi
print(f"Luas segitiga: {luas_segitiga(10, 5)}")  # Output: Luas segitiga: 25.0
```

#### **Contoh 5: Fungsi dengan Parameter Default**  
Parameter default memberikan nilai otomatis jika argumen tidak diberikan:  
```python
def sapa_waktu(nama, waktu="pagi"):
    print(f"Selamat {waktu}, {nama}!")

# Memanggil dengan 1 argumen (waktu default="pagi")
sapa_waktu("Budi")  # Output: Selamat pagi, Budi!

# Memanggil dengan 2 argumen
sapa_waktu("Siti", "sore")  # Output: Selamat sore, Siti!
```

---

#### **Latihan Praktik!**  
Coba kerjakan soal berikut untuk memahami lebih dalam:  

1. **Buat fungsi `hitung_lingkaran(jari_jari)`** yang mengembalikan luas lingkaran (rumus: `π * r²`).  
   ```python
   # π bisa gunakan 3.14
   ```

2. **Buat fungsi `konversi_suhu(celcius)`** yang mengubah suhu dari Celcius ke Fahrenheit (rumus: `(C × 9/5) + 32`).  

3. **Buat fungsi `cek_genap(angka)`** yang mengembalikan `"Genap"` jika angka genap, dan `"Ganjil"` jika ganjil.  

**Contoh Jawaban Latihan 1:**  
```python
def hitung_lingkaran(jari_jari):
    return 3.14 * jari_jari ** 2

print(f"Luas lingkaran: {hitung_lingkaran(7)}")  # Output: Luas lingkaran: 153.86
```

#### **Kesimpulan**  
- **Fungsi `def`** adalah alat powerful untuk membuat kode modular dan efisien.  
- **Parameter** adalah input fungsi, sedangkan **argumen** adalah nilai yang diberikan saat pemanggilan.  
- Gunakan **`return`** untuk mengembalikan nilai hasil dari fungsi.  
- Selalu beri nama fungsi yang **deskriptif** agar mudah dipahami!  

> **Tips:**  
> - Latihan membuat fungsi setiap hari!  
> - Gunakan fungsi untuk tugas-tugas berulang (misal: perhitungan matematika, validasi input).  

### **Contoh Dasar Fungsi `def` di Python**  
*(Sangat Sederhana & Cocok untuk Pemula)*

#### **1. Fungsi Tanpa Parameter (Hanya Mencetak)**  
Fungsi ini hanya menampilkan teks tanpa menerima input.  
```python
def sapa():
    print("Halo! Selamat belajar Python.")

# Memanggil fungsi
sapa()
```
**Output:**  

```
Halo! Selamat belajar Python.
```

#### **2. Fungsi dengan Parameter (Tanpa Return)**  
Fungsi menerima input (`nama`) dan menampilkan pesan personal.  
```python
def sapa_nama(nama):
    print(f"Halo, {nama}! Semangat belajarnya!")

# Memanggil fungsi dengan argumen
sapa_nama("Andi")
sapa_nama("Siti")
```
**Output:**  
```
Halo, Andi! Semangat belajarnya!
Halo, Siti! Semangat belajarnya!
```

#### **3. Fungsi dengan Parameter dan Return**  
Fungsi menghitung luas persegi dan **mengembalikan hasil** dengan `return`.  
```python
def luas_persegi(sisi):
    hasil = sisi * sisi
    return hasil

# Memanggil fungsi dan menyimpan hasil
luas = luas_persegi(5)
print(f"Luas persegi: {luas}")
```
**Output:**  
```
Luas persegi: 25
```

#### **4. Fungsi dengan 2 Parameter**  
Fungsi menghitung luas segitiga dengan 2 input (`alas` dan `tinggi`).  
```python
def luas_segitiga(alas, tinggi):
    return 0.5 * alas * tinggi

# Memanggil fungsi
print(f"Luas segitiga: {luas_segitiga(10, 5)}")
```
**Output:**  
```
Luas segitiga: 25.0
```

#### **5. Fungsi dengan Parameter Default**  
Parameter `waktu` memiliki nilai default `"pagi"`.  
```python
def sapa_waktu(nama, waktu="pagi"):
    print(f"Selamat {waktu}, {nama}!")

# Memanggil dengan 1 argumen (menggunakan default)
sapa_waktu("Budi")

# Memanggil dengan 2 argumen (mengganti default)
sapa_waktu("Citra", "malam")
```
**Output:**  
```
Selamat pagi, Budi!
Selamat malam, Citra!
```

### **Latihan Dasar**  
Coba kerjakan soal berikut:  
1. Buat fungsi `keliling_persegi(sisi)` yang mengembalikan keliling persegi (rumus: `4 × sisi`).  
2. Buat fungsi `konversi_ke_derajat(fahrenheit)` yang mengubah suhu Fahrenheit ke Celcius (rumus: `(F - 32) × 5/9`).  

**Contoh Jawaban Latihan 1:**  
```python
def keliling_persegi(sisi):
    return 4 * sisi

print(f"Keliling persegi: {keliling_persegi(7)}")  # Output: Keliling persegi: 28
```

### **Kesimpulan**  
- **`def`** = kata kunci untuk membuat fungsi.  
- **Parameter** = input fungsi (dalam tanda kurung).  
- **`return`** = mengembalikan nilai hasil (bisa disimpan ke variabel).  
- **Parameter default** = nilai otomatis jika argumen tidak diberikan.  

> **Tips:**  
> - Beri nama fungsi yang jelas (misal: `hitung_luas` bukan `fungsi1`).  
> - Gunakan `print()` untuk menampilkan, `return` untuk mengirim hasil.  

