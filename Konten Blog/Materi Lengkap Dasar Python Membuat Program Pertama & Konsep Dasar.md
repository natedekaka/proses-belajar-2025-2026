## **Materi Lengkap Dasar Python: Membuat Program Pertama & Konsep Dasar**  

Python adalah bahasa pemrograman yang ramah untuk pemula. Di materi ini, kita akan membuat program pertama *"Hello Python"*, memahami cara kerja Python, dan mempelajari konsep dasar seperti **komentar**. Simak langkah-langkahnya!  

### **1. Program Pertama: "Hello Python" dengan Python Interactive Shell**  
**Python Interactive Shell** adalah mode interaktif di terminal untuk mengeksekusi kode Python baris per baris. Cocok untuk eksperimen kecil!  

#### **Cara Menggunakan**:  
1. Buka **Terminal** (macOS/Linux) atau **Command Prompt** (Windows).  
2. Ketik perintah:  
   ```bash  
   python3  # atau "python" di beberapa sistem  
   ```
3. Akan muncul tanda `>>>`, artinya Anda sudah masuk mode interaktif.  

#### **Membuat Output Teks**:  
Gunakan fungsi `print()` untuk menampilkan teks. Teks harus diapit tanda petik (`"` atau `'`).  
```python  
>>> print("Hello Python")  
Hello Python  
>>> print("Hello Programmer Zaman Now")  
Hello Programmer Zaman Now  
```

#### **Keluar dari Mode Interaktif**:  
Ketik `exit()` atau tekan `Ctrl + D` (macOS/Linux) / `Ctrl + Z` lalu `Enter` (Windows).  

### **2. Pentingnya Case Sensitivity & Penulisan String**  
Python **case sensitive**: huruf besar dan kecil dianggap berbeda.  
- **Benar**: `print("Hello")`  
- **Salah**: `Print("Hello")` → Error: `NameError: name 'Print' is not defined`  

**Error Umum**:  
1. **Lupa tutup petik**:  
   ```python  
   >>> print("Hello Python)  
   # Error: SyntaxError: EOL while scanning string literal  
   ```
2. **Salah ketik fungsi**:  
   ```python  
   >>> Print("Hello")  
   # Error: NameError: name 'Print' is not defined  
   ```

### **3. Membuat File Python (.py)**  
Untuk program besar, kode disimpan dalam file berekstensi **.py**.  

#### **Aturan Penamaan File**:  
- Gunakan huruf kecil semua.  
- Pisahkan kata dengan underscore (`_`), bukan spasi.  
- Contoh benar: `hello.py`, `program_sederhana.py`  
- Contoh salah: `Hello Python.py` (pakai spasi)  

#### **Langkah Membuat File**:  
1. Buat folder proyek, misal:  
   ```bash  
   mkdir -p development/python/belajar_python_dasar  
   cd development/python/belajar_python_dasar  
   ```
2. Buat file `hello.py` (gunakan teks editor seperti VS Code/PyCharm).  
3. Tulis kode:  
   ```python  
   print("Hello Python")  
   print("Hello Programmer Zaman Now")  
   ```

### **4. Menjalankan File Python dari Terminal**  
1. Pastikan terminal berada di folder yang sama dengan file `.py`.  
2. Jalankan perintah:  
   ```bash  
   python3 hello.py  # atau "python hello.py"  
   ```
3. Hasilnya:  
   ```  
   Hello Python  
   Hello Programmer Zaman Now  
   ```

#### **Tips: Terminal Bawaan IDE**  
- **VS Code**: Tekan `Ctrl + ` ` (backtick) atau menu `Terminal > New Terminal`.  
- **PyCharm**: Klik ikon terminal di bagian bawah.  
  Terminal otomatis terbuka di folder proyek!  

### **5. Komentar dalam Python**  
**Komentar** adalah catatan untuk programmer, **tidak dieksekusi** oleh Python. Gunakan tanda `#`.  

#### **Cara Membuat Komentar**:  
```python  
# Ini adalah komentar  
print("Hello Python")  # Komentar setelah kode  
# print("Teks ini tidak akan muncul")  
```

#### **Contoh File dengan Komentar**:  
```python  
# Program: Hello Python  
# Fungsi: Menampilkan teks sambutan  
print("Hello Python")  
print("Hello Programmer Zaman Now")  # Output kedua  
```
Saat dijalankan, hanya teks di dalam `print()` yang muncul.  

### **6. Praktik: Membuat & Menjalankan File Python**  
#### **Langkah 1: Buat File**  
1. Buka VS Code/PyCharm.  
2. Buat file baru: `belajar_pertama.py`.  
3. Tulis kode:  
   ```python  
   # Program pertama saya  
   print("Saya belajar Python!")  
   print("Python itu mudah dan seru!")  
   ```

#### **Langkah 2: Jalankan File**  
1. Buka terminal di IDE.  
2. Ketik:  
   ```bash  
   python3 belajar_pertama.py  
   ```
3. Hasil:  
   ```  
   Saya belajar Python!  
   Python itu mudah dan seru!  
   ```

### **Kesimpulan**  
- **Python Interactive Shell**: Cocok untuk tes kode singkat.  
- **File .py**: Untuk program nyata dengan banyak baris.  
- **Print()**: Fungsi dasar untuk menampilkan output.  
- **Komentar (#)**: Penting untuk dokumentasi kode.  
- **IDE**: VS Code/PyCharm memudahkan pengelolaan proyek.  

**Selamat!** Anda sudah membuat program Python pertama. Lanjutkan ke materi berikutnya: **Variabel & Tipe Data**!  

