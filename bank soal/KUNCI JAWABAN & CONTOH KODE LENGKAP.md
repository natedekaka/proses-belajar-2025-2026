**KUNCI JAWABAN & CONTOH KODE LENGKAP**  
File harus disimpan dengan nama: **NIS_NamaLengkap.py**

```python
# SOAL 1
print("Selamat Datang di SMA Negeri 6 Cimahi")
print("Kelas XI Informatika – Semangat Belajar Python!")

# SOAL 2
nama = "Ahmad Zaky"          # ganti dengan nama sendiri
nis  = "23101"               # ganti dengan NIS sendiri
kelas = "XI MIPA 3"          # ganti dengan kelas sendiri
umur = 17                    # ganti dengan umur sendiri
print("Nama Lengkap :", nama)
print("NIS          :", nis)
print("Kelas        :", kelas)
print("Umur         :", umur, "tahun")

# SOAL 3
uang = 75000
boba = 27000
batagor = 15000
esteh = 5000
sisa = uang - boba - batagor - esteh
print("Sisa uang jajan hari ini = Rp" + str(sisa))

# SOAL 4
nilai = int(input("Masukkan nilai kamu (0-100): "))
if nilai >= 85:
    print("A – Remedi banget!")
elif nilai >= 75:
    print("B – Lumayan aman")
elif nilai >= 65:
    print("C – Harus lebih giat lagi ya")
else:
    print("D – Kita ngulang bareng ya nak")

# SOAL 5
nama = input("Masukkan nama kamu: ")
print("Halo " + nama + "! Selamat ulangan praktik ya!")

# SOAL 6
print("*" * 7)

# SOAL 7
jumlah = int(input("Mau di-spam berapa kali? (1-20): "))
for i in range(jumlah):
    print("Aku pasti bisa mengerjakan ulangan Python dengan baik!")

# SOAL 8
kill = int(input("Berapa kill? "))
death = int(input("Berapa death? "))
skor = kill * 15 - death * 8
print("Skor kamu =", skor, "| Mantap atau masih noob?")

# SOAL 9
nama = input("Masukkan nama asli kamu: ")
nick = "X" + nama[:len(nama)//2] + "Z" + nama[len(nama)//2:] + "69"
print("Nickname gaming keren kamu:", nick)

# SOAL 10
teman = input("Nama teman sebelahmu: ")
print("Terima kasih " + teman + " sudah jadi teman sekelas!")
print("Terima kasih " + teman + " sudah jadi teman sekelas!")
print("Terima kasih " + teman + " sudah jadi teman sekelas!")
```

Semua kode di atas **100 % jalan** dan sesuai dengan poin penilaian.  
Bisa langsung Anda copy ke Thonny/Colab untuk cek sendiri.

Rubrik penilaian cepat (bisa Anda catat di kertas):
- Soal 1 → 5 poin (teks persis)
- Soal 2 → 2 poin tiap variabel + print benar
- Soal 3 → 10 poin (harus 28000)
- Soal 4 → 10 poin (semua kondisi benar)
- Soal 5 → 12 poin (input + print)
- Soal 6 → 10 poin (7 bintang)
- Soal 7 → 10 poin (loop sesuai input)
- Soal 8 → 10 poin (rumus benar)
- Soal 9 → 15 poin (nickname sesuai pola)
- Soal 10 → 10 poin (3 kali print)

