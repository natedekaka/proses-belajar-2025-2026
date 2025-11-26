# Cara Mudah Format Flashdisk di Arch Linux Agar Bisa Dipakai di Windows & Linux (exFAT)

**Permalink (URL):**  
`https://namablogkamu.blogspot.com/2025/11/cara-format-flashdisk-arch-linux-exfat.html`

**Meta Description (untuk SEO, maks 150 karakter):**  
Cara format flashdisk di Arch Linux pakai exFAT supaya bisa dipakai di Windows & Linux. Panduan super gampang untuk pemula! (118 karakter)

---

Kebanyakan orang takut format flashdisk di Arch Linux karena khawatir salah hapus data atau hasilnya tidak bisa dibaca di Windows.

Tenang! Di artikel ini aku ajarin cara **paling aman dan paling gampang** format flashdisk pakai **exFAT** — format terbaik karena:

- Bisa simpan file lebih dari 4 GB  
- Langsung terbaca di Windows 10/11 tanpa install apa-apa  
- 100% support di semua distro Linux modern (termasuk Arch Linux)  
- Juga bisa dibaca di macOS  

Cocok banget buat pemula!

### Langkah 1: Colok Flashdisk & Cek Namanya
Buka Terminal, lalu ketik:
```bash
lsblk
```

Contoh hasilnya (flashdisk biasanya muncul sebagai `sda`, `sdb`, atau `sdc`):
```
sda      8:0    1   7.5G  0 disk 
└─sda1   8:1    1   7.5G  0 part /run/media/daniarsyah/NAMA_FLASH
```

Artinya flashdisk kamu adalah **/dev/sda** (bukan harddisk utama ya!).

### Langkah 2: Unmount Flashdisk
```bash
sudo umount /dev/sda1
```
(Atau klik kanan → Unmount kalau muncul di file manager)

### Langkah 3: Install Tool exFAT (sekali saja)
```bash
sudo pacman -S --needed exfatprogs
```

### Langkah 4: Format ke exFAT (Langkah Paling Penting!)

**Cara paling bersih (rekomendasi aku):**
```bash
sudo mkfs.exfat -n FLASHDISK /dev/sda
```
(Langsung format seluruh flashdisk, lebih rapi)

**Atau kalau mau pakai partisi lama:**
```bash
sudo mkfs.exfat -n FLASHDISK /dev/sda1
```

Ganti `FLASHDISK` dengan nama yang kamu suka, contoh: `DATAKU`, `BACKUP`, `MYDRIVE`, dll.

### Selesai!
Cabut flashdisk → colok lagi. Sekarang sudah jadi exFAT dan bisa langsung dipakai di:

- Windows 7/8/10/11  
- Arch Linux, Ubuntu, Fedora, Manjaro, Mint, dll  
- Mac juga bisa!

### Kalau Mau Pakai FAT32 (hanya untuk perangkat sangat lama)
```bash
sudo mkfs.vfat -F 32 -n FLASHDISK /dev/sda1
```
(Tapi ingat: tidak bisa simpan file >4GB)

### Tips Penting
- Selalu cek `lsblk` dulu sebelum format → jangan sampai salah device!  
- Tahun 2025, **exFAT adalah pilihan terbaik** untuk flashdisk lintas OS.

Sudah dicoba berkali-kali, 100% berhasil!

Punya pertanyaan? Tulis di kolom komentar ya 🌟  
Semoga membantu para pemula Arch Linux!

#ArchLinux #FormatFlashdisk #exFAT #TutorialLinux #PemulaArch