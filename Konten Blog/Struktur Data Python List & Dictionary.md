# Struktur Data Python: List & Dictionary

Selamat datang di materi lanjutan! 🎉

Di materi sebelumnya, kita sudah belajar menyimpan **satu data** dalam satu variabel (contoh: `nama = "Budi"`). Tapi bagaimana jika kita punya **100 siswa**? Apakah kita harus membuat `nama1`, `nama2`, ..., `nama100`? 😫

Tentu tidak! Itu akan sangat berantakan. Di sinilah kita butuh **Struktur Data**. Bayangkan ini sebagai **wadah khusus** untuk menyimpan banyak data sekaligus dengan rapi.

Fokus kita kali ini ada dua wadah ajaib: **List** dan **Dictionary**.

---

## 1️⃣ LIST (Daftar Berurutan)

### Konsep & Analogi
Bayangkan **List** itu seperti **Daftar Absen Siswa** di kelas.
*   Ada urutan yang jelas (Baris 1, Baris 2, Baris 3...).
*   Kita bisa memanggil siswa berdasarkan **nomor urutnya**.
*   Kita bisa menambah nama baru di paling bawah, atau menghapus nama yang keluar.

Di Python, List ditulis menggunakan **kurung siku `[]`** dan setiap data dipisahkan dengan **koma `,`**.

### Aturan Penting: Index Dimulai dari 0!
Ini yang sering bikin bingung pemula. Di dunia nyata, kita menghitung mulai dari 1. Di Python, **hitungan dimulai dari 0**.
*   Siswa pertama = Index `0`
*   Siswa kedua = Index `1`
*   Siswa ketiga = Index `2`

### Operasi Dasar List

```python
# 1. Membuat List (Daftar Absen)
daftar_siswa = ["Ali", "Budi", "Citra", "Dewi"]

# 2. Mengakses Data (Memanggil berdasarkan nomor urut/index)
print(daftar_siswa[0])  # Output: Ali (Karena index mulai dari 0)
print(daftar_siswa[2])  # Output: Citra

# 3. Menambah Data (Append) -> Seperti siswa pindahan masuk
daftar_siswa.append("Eko") 
print(daftar_siswa)     # Output: ['Ali', 'Budi', 'Citra', 'Dewi', 'Eko']

# 4. Mengubah Data -> Seperti memperbaiki nama yang salah tulis
daftar_siswa[1] = "Baru" # Mengganti "Budi" menjadi "Baru"
print(daftar_siswa)     # Output: ['Ali', 'Baru', 'Citra', 'Dewi', 'Eko']

# 5. Menghapus Data (Remove) -> Seperti siswa keluar
daftar_siswa.remove("Citra")
print(daftar_siswa)     # Output: ['Ali', 'Baru', 'Dewi', 'Eko']
```

> **💡 Tips:** Jika kamu memanggil index yang tidak ada (misalnya `daftar_siswa[10]` padahal hanya ada 5 data), Python akan error (`IndexError`). Hati-hati!

---

## 2️⃣ DICTIONARY (Kamus Data)

### Konsep & Analogi
Bayangkan **Dictionary** itu seperti **Buku Telepon** atau **Kamus Bahasa**.
*   Tidak ada urutan nomor baris yang penting.
*   Yang penting adalah **Kata Kunci (Key)** untuk menemukan **Isi (Value)**.
*   Contoh: Kamu cari nama **"Polisi"** (Key), maka kamu dapat nomor **"110"** (Value).

Di Python, Dictionary ditulis menggunakan **kurung kurawal `{}`** dan berbentuk pasangan **`Key: Value`**.

### Operasi Dasar Dictionary

```python
# 1. Membuat Dictionary (Buku Telepon)
# Format: "Key": "Value"
buku_telepon = {
    "Ayah": "08123456789",
    "Ibu": "08198765432",
    "Polisi": "110"
}

# 2. Mengakses Data (Memanggil berdasarkan Key, BUKAN index)
print(buku_telepon["Ayah"])   # Output: 08123456789
print(buku_telepon["Polisi"]) # Output: 110

# 3. Menambah Data -> Kontak baru
buku_telepon["Pemadam"] = "113"
print(buku_telepon)

# 4. Mengubah Data -> Ganti nomor telepon
buku_telepon["Ayah"] = "08111122233"
print(buku_telepon["Ayah"])   # Output: 08111122233

# 5. Menghapus Data (Pop) -> Hapus kontak
buku_telepon.pop("Polisi")
print(buku_telepon)           # Key "Polisi" hilang
```

> **💡 Tips:** 
> *   **Key** harus unik (tidak boleh ada nama "Ayah" dua kali).
> *   Jika kamu memanggil Key yang tidak ada (misalnya `buku_telepon["Tetangga"]`), Python akan error (`KeyError`).

---

## Perbandingan: Kapan Pakai List vs Dictionary?

Bingung memilih? Gunakan panduan sederhana ini:

| Fitur            | **List (Daftar)**                      | **Dictionary (Kamus)**                       |
| :--------------- | :------------------------------------- | :------------------------------------------- |
| **Simbol**       | `[ ]` (Siku)                           | `{ }` (Kurawal)                              |
| **Cara Akses**   | Pakai **Index** (Angka 0, 1, 2...)     | Pakai **Key** (Nama/Label)                   |
| **Urutan**       | **Penting** (Urutan data terjaga)      | **Tidak Penting** (Yang penting Key-nya)     |
| **Analogi**      | Antrean, Daftar Absen, Rel Kereta      | Buku Telepon, Kamus, Data Profil             |
| **Kapan Pakai?** | Saat punya banyak data sejenis & urut. | Saat butuh label spesifik untuk setiap data. |

---

## Tantangan Kecil (Latihan Gabungan)

Mari kita buat program **"Data Kelas Sederhana"**.
Kita akan menyimpan nama-nama siswa dalam **List**, lalu menyimpan detail nilai mereka dalam **Dictionary**.

**Instruksi:**
1.  Buat List berisi 3 nama siswa.
2.  Buat Dictionary untuk menyimpan nilai Matematika masing-masing siswa (Key = Nama, Value = Nilai).
3.  Tampilkan nilai siswa pertama dari List menggunakan Dictionary.

**Kunci Jawaban:**

<details>
<summary>👉 Klik untuk melihat jawaban</summary>

```python
# 1. List Nama Siswa
siswa = ["Andi", "Bella", "Chika"]

# 2. Dictionary Nilai (Key adalah nama siswa)
nilai_matematika = {
    "Andi": 85,
    "Bella": 90,
    "Chika": 78
}

# 3. Mengambil nama siswa pertama dari List
nama_siswa_pertama = siswa[0]  # Hasilnya "Andi"

# 4. Menggunakan nama tersebut untuk mengambil nilai dari Dictionary
nilai_andi = nilai_matematika[nama_siswa_pertama]

print(f"Nama: {nama_siswa_pertama}")
print(f"Nilai Matematika: {nilai_andi}")
```
</details>

---

## Ringkasan Materi

1.  **List `[]`**: Wadah berurutan. Akses pakai angka (index). Ingat, mulai dari **0**! Cocok untuk daftar absen.
2.  **Dictionary `{}`**: Wadah berpasangan (Key: Value). Akses pakai label (key). Cocok untuk buku telepon atau data profil.
3.  **Kombinasi**: Kita bisa menggabungkan List dan Dictionary untuk membuat data yang lebih kompleks (seperti database sederhana).

Selamat! Sekarang kamu sudah tahu cara menyimpan banyak data dengan rapi. Ini adalah fondasi penting sebelum kita belajar mengolah data tersebut lebih lanjut.
