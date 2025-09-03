------

LATIHAN 1 – Cetak Nama 10× 



Buatlah program yang menampilkan namamu 10 kali ke layar. 

*Petunjuk*: pakai range(10).

\# Jawaban

nama = "Budi"

for i in range(10):

  print(nama)



------



LATIHAN 2 – Tabel Perkalian 1-9 

Tampilkan tabel perkalian 5 (5×1 sampai 5×9) dalam bentuk: 

5 x 1 = 5 dst.

\# Jawaban

for i in range(1, 10):

  print(f"5 x {i} = {5 * i}")



------



LATIHAN 3 – Jumlahkan Bilangan Ganjil 1-15 

Hitung total semua bilangan ganjil dari 1 sampai 15.

\# Jawaban

total = 0

for angka in range(1, 16, 2):

  total += angka

print("Total ganjil 1-15 =", total)  # 64



------



LATIHAN 4 – Cari Nilai Maksimum 

Diberikan list nilai = [76, 89, 54, 92, 67]. 

Gunakan for untuk menemukan nilai tertingginya tanpa fungsi max().

\# Jawaban

nilai = [76, 89, 54, 92, 67]

maks = nilai[0]

for n in nilai:

  if n > maks:

​    maks = n

print("Nilai tertinggi:", maks)  # 92



------



LATIHAN 5 – Segitiga Bintang 

Mintalah user memasukkan sebuah angka n, lalu cetak segitiga siku-siku bintang setinggi n baris.

Contoh input 4:

*

**

***

****

\# Jawaban

n = int(input("Tinggi segitiga: "))

for baris in range(1, n + 1):

  print("*" * baris)



------



Selamat mencoba!