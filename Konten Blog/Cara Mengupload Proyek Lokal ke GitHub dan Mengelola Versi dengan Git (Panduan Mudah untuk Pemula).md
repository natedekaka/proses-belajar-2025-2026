### Cara Mengupload Proyek Lokal ke GitHub dan Mengelola Versi dengan Git (Panduan Mudah untuk Pemula)

Halo pembaca!  
Beberapa waktu lalu saya sedang mengembangkan aplikasi absensi berbasis web PHP yang dijalankan menggunakan **Podman** di Fedora. Agar kode saya aman, mudah dikontrol versinya, dan bisa diakses dari mana saja, saya memutuskan untuk mengupload seluruh proyek ke **GitHub**.

Berikut ini panduan lengkap dan sederhana yang saya buat berdasarkan pengalaman langsung saya. Cocok untuk Anda yang baru belajar Git, ingin mengupload proyek lokal ke GitHub, atau sekadar butuh catatan kalau suatu saat lupa lagi.

#### Persiapan Awal
1. Pastikan **Git** sudah terinstal di Fedora  
   ```bash
   sudo dnf install git
   ```
2. Buat akun GitHub jika belum punya (github.com).
3. Buat repository baru di GitHub:
   - Klik tombol **+** → **New repository**
   - Isi nama repo, misalnya `absensi-podman`
   - Pilih **Private** atau **Public**
   - **JANGAN** centang "Add a README file" atau yang lain → biarkan kosong
   - Klik **Create repository**
   - Catat URL repo, contoh: `https://github.com/natedekaka/absensi-podman.git`

#### Langkah-Langkah Mengupload Proyek ke GitHub

Buka terminal, masuk ke folder proyek Anda (contoh saya: `~/absensi-podman`).

1. **Inisialisasi Git di folder proyek**  
   ```bash
   git init
   ```
   (Akan muncul pesan bahwa branch default adalah `master` – ini normal)

2. **Tambahkan semua file ke Git**  
   ```bash
   git add .
   ```

3. **Buat commit pertama**  
   ```bash
   git commit -m "Initial commit"
   ```
   Jika muncul error nama/email, atur dulu (sekali saja):  
   ```bash
   git config --global user.name "Nama Anda"
   git config --global user.email "email-anda@github.com"
   ```

4. **Hubungkan folder lokal ke GitHub**  
   ```bash
   git remote add origin https://github.com/username/nama-repo.git
   ```
   Ganti `username` dan `nama-repo` sesuai milik Anda.

5. **Push ke GitHub (branch master dulu)**  
   ```bash
   git push -u origin master
   ```
   Terminal akan minta username dan password:  
   - Username: nama akun GitHub Anda  
   - Password: **Personal Access Token** (bukan password biasa!)

   **Cara buat Personal Access Token (PAT):**
   - Buka https://github.com/settings/tokens
   - Generate new token (classic)
   - Beri nama token
   - Centang scope **repo**
   - Generate → salin token (hanya muncul sekali!)

6. **(Opsional tapi direkomendasikan) Ganti nama branch dari master jadi main**  
   Standar GitHub sekarang menggunakan `main`.  
   ```bash
   git branch -M main
   git push -u origin main
   ```

7. **Setelah ini, setiap ada perubahan baru:**  
   ```bash
   git add .
   git commit -m "Penjelasan perubahan, misalnya: tambah db"
   git push
   ```

#### Contoh Nyata dari Proyek Saya
Berikut hasil terminal saya saat menambahkan backup database dan file readme:

```bash
# Tambah file backup database
git status                  # lihat ada folder db_backup yang belum di-track
git add .
git commit -m "tambah db"
git push -u origin master   # berhasil push ke branch master

# Ganti nama branch ke main
git branch -M main
git push -u origin main     # buat branch main di GitHub

# Tambah file readme
git add .
git commit -m "tambah readku"
git push                    # sudah otomatis ke branch main
```

#### Tips Penting
- **Jangan upload file sensitif** seperti `.env`, password, atau file besar. Buat file `.gitignore` di root folder, contoh isinya:
  ```
  .env
  *.log
  vendor/
  node_modules/
  db_backup/          # kalau tidak ingin backup DB diupload
  ```
- File besar seperti backup database (`absensi_db.sql` ~8MB) sebaiknya **tidak diupload** ke GitHub. Gunakan layanan lain seperti Google Drive atau GitHub Releases jika memang perlu.
- Selalu tulis pesan commit yang jelas agar mudah dilacak nanti.

Dengan GitHub, sekarang proyek saya aman, bisa dikembangkan dari laptop mana saja, dan versi kode selalu tercatat dengan rapi. Semoga tutorial ini membantu Anda juga!

Kalau ada yang kurang jelas, tinggalkan komentar ya.  
Happy coding! 

*(Diposting oleh Dani Arsyah – Pengembang Web & DevOps Enthusiast)*

Anda tinggal copy-paste teks di atas ke Blogger, tambahkan sedikit gambar screenshot terminal jika mau, dan publish. Semoga bermanfaat untuk Anda sendiri di masa depan maupun untuk pembaca lain!



