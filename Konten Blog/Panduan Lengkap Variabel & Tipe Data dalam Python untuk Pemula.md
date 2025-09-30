## **Panduan Lengkap Variabel & Tipe Data dalam Python untuk Pemula**  

Variabel dan tipe data adalah fondasi pemrograman Python. Tanpa memahami keduanya, Anda akan kesulitan mengelola data dalam program. Yuk, pelajari konsep dasar ini dengan penjelasan sederhana dan contoh praktis!  

---

### **Apa Itu Variabel?**  
Variabel adalah **wadah penyimpanan data** di memori komputer. Analoginya seperti kotak berlabel:  
- **Label** = nama variabel  
- **Isi kotak** = nilai/data yang disimpan  

**Contoh**:  
```python  
nama = "Budi"  # Variabel 'nama' berisi teks "Budi"  
umur = 25      # Variabel 'umur' berisi angka 25  
```

#### **Sifat Variabel di Python**:  
- **Dinamis**: Tipe data bisa berubah saat program berjalan.  
- **Case-sensitive**: `nama` berbeda dengan `Nama`.  

### **Aturan Penamaan Variabel**  
Nama variabel tidak bisa sembarangan! Ikuti aturan ini:  
1. **Tidak boleh diawali angka**:  
   ```python  
   # Salah  
   1nama = "Eko"  # Error!  
   # Benar  
   nama1 = "Eko"  
   ```
2. **Tidak boleh pakai tanda minus (-)**:  
   ```python  
   # Salah  
   nama-depan = "Alice"  # Error!  
   # Benar  
   nama_depan = "Alice"  
   ```
3. **Tidak boleh pakai spasi**:  
   ```python  
   # Salah  
   nama depan = "Bob"  # Error!  
   # Benar  
   nama_depan = "Bob"  
   ```
4. **Tidak boleh pakai keyword Python** (seperti `if`, `for`, `while`):  
   ```python  
   # Salah  
   if = True  # Error! 'if' adalah keyword  
   ```

### **4 Tipe Data Dasar di Python**  
Python punya 4 tipe data fundamental:  

#### **1. Integer (int)**  
Bilangan bulat (positif/negatif/nol).  
```python  
umur = 25  
tahun_lahir = 1998  
saldo = -50000  
populasi_dunia = 8000000000  # Python handle angka besar!  

# Cek tipe data  
print(type(umur))  # Output: <class 'int'>  
```

#### **2. Float**  
Bilangan desimal (pakai titik, bukan koma).  
```python  
tinggi = 170.5    # 170,5 dalam format Indonesia  
berat = 65.7  
suhu = -10.5  
pi = 3.14  

# Notasi ilmiah  
angka_besar = 3e8  # 3 x 10^8 = 300,000,000  
angka_kecil = 1e-6 # 0.000001  

# Cek tipe data  
print(type(tinggi))  # Output: <class 'float'>  
```

#### **3. String (str)**  
Teks/huruf, dibuat dengan petik satu (`'`), dua (`"`), atau tiga (`'''`).  
```python  
# Petik satu/kedu  
nama = 'Budi Santoso'  
kota = "Jakarta"  

# Petik tiga untuk teks multi-baris  
puisi = '''Ini adalah puisi  
yang terdiri dari  
beberapa baris'''  

# String kosong  
kosong = ""  

# Cek tipe data  
print(type(nama))  # Output: <class 'str'>  
```

#### **4. Boolean (bool)**  
Hanya punya 2 nilai: `True` (benar) atau `False` (salah). **Case-sensitive!**  
```python  
is_student = True    # T untuk kapital  
is_married = False   # F untuk kapital  
has_license = True  

# Cek tipe data  
print(type(is_student))  # Output: <class 'bool'>  
```

### **Cara Membuat & Menggunakan Variabel**  
#### **1. Membuat Variabel Baru**  
Gunakan tanda `=` untuk mengisi nilai:  
```python  
nama = "Alice"  
umur = 25  
tinggi = 170.5  
```

#### **2. Multiple Assignment**  
Buat beberapa variabel sekaligus:  
```python  
# Semua variabel bernilai sama  
x = y = z = 0  # x=0, y=0, z=0  

# Variabel dengan nilai berbeda  
a, b, c = 1, 2, 3  # a=1, b=2, c=3  

# Unpacking dari list  
nama, umur = "Bob", 25  
```

#### **3. Update Variabel**  
Ubah nilai variabel dengan `=`:  
```python  
skor = 80  
print(skor)  # Output: 80  

skor = 95   # Update nilai  
print(skor)  # Output: 95  
```

### **Menampilkan Variabel dengan `print()`**  
#### **1. Satu Variabel**  
```python  
nama = "Eko"  
print(nama)  # Output: Eko  
```

#### **2. Beberapa Variabel Sekaligus**  
Pisahkan dengan koma:  
```python  
nama_depan = "John"  
nama_belakang = "Doe"  
umur = 30  

print("Nama lengkap:", nama_depan, nama_belakang)  
print("Umur:", umur)  

# Output:  
# Nama lengkap: John Doe  
# Umur: 30  
```

---

### **Input dari Pengguna: `input()`  
Ambil data dari user dengan fungsi `input()`. **Hasilnya selalu string!**  
```python  
# Input string  
nama = input("Masukkan nama Anda: ")  
print("Hello,", nama)  

# Input angka (hasilnya string)  
umur_teks = input("Masukkan umur: ")  
print(type(umur_teks))  # Output: <class 'str'>  
```

#### **Konversi Tipe Data Input**  
Ubah input string ke tipe lain:  
```python  
# Konversi string ke integer  
umur_teks = input("Masukkan umur: ")  
umur = int(umur_teks)  # Konversi ke integer  
print(type(umur))      # Output: <class 'int'>  

# Konversi string ke float  
tinggi_teks = input("Masukkan tinggi: ")  
tinggi = float(tinggi_teks)  

# Konversi ke boolean  
is_active = bool(input("Aktif? (True/False): "))  
```

**Fungsi Konversi**:  
- `int()` → Ubah ke integer  
- `float()` → Ubah ke float  
- `str()` → Ubah ke string  
- `bool()` → Ubah ke boolean  

---

### **Contoh Program Lengkap**  
```python  
# Input data user  
nama = input("Nama: ")  
umur = int(input("Umur: "))  
tinggi = float(input("Tinggi (cm): "))  
is_student = bool(input("Pelajar? (True/False): "))  

# Tampilkan hasil  
print("\nData Anda:")  
print("Nama:", nama)  
print("Umur:", umur, "tahun")  
print("Tinggi:", tinggi, "cm")  
print("Status pelajar:", is_student)  
```

**Output**:  
```  
Nama: Eko  
Umur: 30  
Tinggi: 170.5 cm  
Status pelajar: True  
```

---

### **Kesimpulan**  
- **Variabel** = Wadah penyimpanan data dengan aturan penamaan ketat.  
- **4 Tipe Data Dasar**: Integer, Float, String, Boolean.  
- **Input User**: Gunakan `input()` dan konversi tipe data jika perlu.  
- **Print Variabel**: Bisa satu atau beberapa variabel sekaligus.  

Dengan memahami variabel dan tipe data, Anda siap membuat program Python yang lebih kompleks! Lanjutkan ke materi berikutnya: **Operator & Operasi Matematika**.  

