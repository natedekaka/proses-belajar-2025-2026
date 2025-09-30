# Perulangan (Loop) dalam Python untuk SMA

**Tujuan Pembelajaran:**
Setelah mempelajari materi ini, siswa diharapkan mampu:

1. Memahami konsep perulangan dalam pemrograman Python
2. Menerapkan berbagai jenis perulangan (for dan while) dalam penyelesaian masalah
3. Menggunakan break, continue, dan else dalam perulangan
4. Membuat perulangan bersarang (nested loop) untuk kasus yang lebih kompleks
5. Menghemat penulisan kode dengan perulangan

## Apa itu Perulangan (Loop)?

Perulangan atau **loop** adalah cara untuk menjalankan kode yang sama berulang-ulang. Dengan menggunakan fitur perulangan, kita bisa menghemat waktu dan membuat kode lebih efisien daripada menulis kode yang sama berkali-kali.

Bayangkan jika Anda diminta untuk menampilkan kata "Hello Python" sebanyak 100 kali! Tentu akan sangat melelahkan jika harus menulis `print("Hello Python")` sebanyak 100 kali. Dengan perulangan, kita bisa melakukannya hanya dengan beberapa baris kode saja.

Dalam Python, ada beberapa jenis perulangan yang akan kita pelajari:
1. For Loop
2. While Loop
3. Break dan Continue
4. Loop dengan Else
5. Nested Loop (Perulangan Bersarang)

Mari kita bahas satu per satu!

## 1. For Loop

For loop digunakan untuk mengulang kode sejumlah tertentu atau mengiterasi melalui sekumpulan data. For loop biasanya menggunakan fungsi `range()` untuk membuat urutan angka untuk perulangannya.

### For Loop dengan Range

Fungsi `range()` digunakan untuk membuat urutan angka. Sintaksnya:
```python
for variabel in range(jumlah_perulangan):
    # Kode yang akan diulang
```

**Penting:** Dalam Python, `range()` dimulai dari 0, bukan 1. Jadi `range(5)` akan menghasilkan angka 0, 1, 2, 3, 4.

**Contoh:**
```python
for i in range(5):
    print(i)
```
Output:
```
0
1
2
3
4
```

Kita juga bisa menentukan awal dan akhir dari range:
```python
for i in range(2, 6):
    print(i)
```
Output:
```
2
3
4
5
```

Untuk membuat perulangan mundur (dari besar ke kecil), kita bisa menambahkan parameter ketiga:
```python
for i in range(10, 0, -1):
    print(i)
```
Output:
```
10
9
8
7
6
5
4
3
2
1
```

**Contoh Praktis: Menampilkan "Hello Python" 100 kali**
```python
for i in range(100):
    print("Hello Python")
```

### For Loop dengan String

For loop juga bisa digunakan untuk mengiterasi setiap karakter yang ada di dalam string.

**Contoh:**
```python
nama = "Python"
for huruf in nama:
    print(huruf)
```
Output:
```
P
y
t
h
o
n
```

**Contoh dengan Input:**
```python
kata = input("Masukkan kata: ")
for huruf in kata:
    print(huruf, end="-")
```
Jika inputnya "Informatika", outputnya:
```
I-n-f-o-r-m-a-t-i-k-a-
```

## 2. While Loop

While loop mengulangi kode selama kondisinya bernilai benar (True). Jika kondisinya menjadi salah (False), perulangan akan berhenti.

Sintaksnya:
```python
while kondisi:
    # Kode yang akan diulang selama kondisi True
```

**Penting:** Hati-hati saat menggunakan while loop! Pastikan ada cara untuk menghentikan perulangan, jika tidak program akan berjalan terus-menerus (infinite loop).

**Contoh:**
```python
angka = 1
while angka <= 5:
    print(angka)
    angka += 1  # Sama dengan angka = angka + 1
```
Output:
```
1
2
3
4
5
```

**Contoh Praktis: Validasi Password**
```python
password = ""
while password != "12345":
    password = input("Masukkan password: ")
    if password != "12345":
        print("Password salah!")
print("Password benar!")
```

## 3. Break dan Continue

### Break

`break` digunakan untuk keluar dari perulangan secara paksa, meskipun kondisi perulangan masih bernilai True.

**Contoh: Game Tebak Angka**
```python
angka_rahasia = 7
while True:
    tebakan = int(input("Tebak angka (1-10): "))
    if tebakan == angka_rahasia:
        print("Selamat, Anda benar!")
        break
    else:
        print("Salah, coba lagi!")
```

### Continue

`continue` digunakan untuk melanjutkan ke iterasi berikutnya tanpa mengeksekusi sisa kode di dalam perulangan untuk iterasi saat ini.

**Contoh: Menampilkan Angka Ganjil**
```python
for i in range(20):
    if i % 2 == 0:  # Jika angka genap
        continue    # Lewati iterasi ini
    print(i)
```
Output:
```
1
3
5
7
9
11
13
15
17
19
```

## 4. Loop dengan Else

Python memiliki fitur unik di mana loop bisa memiliki bagian `else`. Bagian `else` akan dieksekusi jika loop selesai secara normal (tanpa `break`).

### For Loop dengan Else

**Contoh: Mencari Huruf dalam Kata**
```python
kata = input("Masukkan kata: ")
huruf_dicari = input("Masukkan huruf yang dicari: ")

for huruf in kata:
    if huruf == huruf_dicari:
        print(f"Huruf {huruf_dicari} ditemukan dalam kata!")
        break
else:
    print(f"Huruf {huruf_dicari} tidak ditemukan dalam kata!")
```

### While Loop dengan Else

**Contoh: Batas Percobaan Password**
```python
password_benar = "12345"
percobaan = 0
maks_percobaan = 3

while percobaan < maks_percobaan:
    password = input("Masukkan password: ")
    percobaan += 1
    
    if password == password_benar:
        print("Login berhasil!")
        break
    else:
        sisa = maks_percobaan - percobaan
        print(f"Password salah! Sisa percobaan: {sisa}")
else:
    print("Terlalu banyak percobaan! Akses ditolak.")
```

## 5. Nested Loop (Perulangan Bersarang)

Nested loop adalah perulangan di dalam perulangan. Ini berguna untuk kasus yang lebih kompleks seperti membuat tabel perkalian atau pola-pola tertentu.

**Contoh: Tabel Perkalian 1-5**
```python
print("Tabel Perkalian 1-5")
for i in range(1, 6):
    for j in range(1, 6):
        hasil = i * j
        print(f"{i} x {j} = {hasil}")
    print()  # Baris kosong untuk pemisah
```

Output:
```
Tabel Perkalian 1-5
1 x 1 = 1
1 x 2 = 2
1 x 3 = 3
1 x 4 = 4
1 x 5 = 5

2 x 1 = 2
2 x 2 = 4
2 x 3 = 6
2 x 4 = 8
2 x 5 = 10

3 x 1 = 3
3 x 2 = 6
3 x 3 = 9
3 x 4 = 12
3 x 5 = 15

4 x 1 = 4
4 x 2 = 8
4 x 3 = 12
4 x 4 = 16
4 x 5 = 20

5 x 1 = 5
5 x 2 = 10
5 x 3 = 15
5 x 4 = 20
5 x 5 = 25
```

## Kesimpulan

Perulangan adalah konsep fundamental dalam pemrograman yang memungkinkan kita untuk menjalankan kode yang sama berulang-ulang secara efisien. Dalam Python, kita memiliki:

1. **For Loop**: Untuk perulangan dengan jumlah yang sudah diketahui atau untuk mengiterasi melalui sekumpulan data.
2. **While Loop**: Untuk perulangan selama kondisi tertentu bernilai True.
3. **Break**: Untuk menghentikan perulangan secara paksa.
4. **Continue**: Untuk melanjutkan ke iterasi berikutnya.
5. **Loop dengan Else**: Untuk mengeksekusi kode setelah perulangan selesai secara normal.
6. **Nested Loop**: Perulangan di dalam perulangan untuk kasus yang lebih kompleks.

Dengan menguasai konsep perulangan, Anda bisa membuat program yang lebih efisien dan terstruktur. Teruslah berlatih dengan mencoba berbagai contoh dan eksperimen sendiri!

Semoga materi ini bermanfaat untuk pembelajaran Informatika Anda. Jika ada pertanyaan, jangan ragu untuk bertanya kepada guru Anda!