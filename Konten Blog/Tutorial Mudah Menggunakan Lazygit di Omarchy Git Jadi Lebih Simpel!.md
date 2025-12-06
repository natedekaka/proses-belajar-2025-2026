# Tutorial Mudah Menggunakan Lazygit di Omarchy: Git Jadi Lebih Simpel!

**Permalink:** /tutorial-lazygit-omarchy-mudah

**Meta Description:** Cara mudah pakai Lazygit di Omarchy untuk commit & push Git di terminal. Cocok pemula Linux! (78 karakter)

---

Halo, sobat Linux dan developer! Pernah merasa ribet ngurus Git dengan perintah manual seperti `git add`, `git commit`, atau `git push`? Nah, kalau kamu pakai setup Omarchy (dotfiles super praktis), ada tool keren namanya **Lazygit** yang bikin semuanya jadi satu layar doang. Lazygit ini seperti GitHub Desktop, tapi di terminal—cepat, ringan, dan pakai keyboard aja.

Kenapa tutorial ini? Karena Omarchy udah integrate lazygit dengan Neovim, jadi kamu bisa commit code tanpa keluar editor. Saya bakal jelasin step-by-step, super mudah dipahami bahkan buat pemula. Setelah baca, kamu bakal hemat waktu berjam-jam setiap hari. Yuk, langsung mulai!

### Apa Itu Lazygit dan Kenapa Cocok dengan Omarchy?
Lazygit adalah TUI (Text User Interface) untuk Git. Dia jalankan di terminal, tapi tampilannya cantik kayak app desktop. Di Omarchy, lazygit dioptimasi buat Neovim—buka dengan shortcut cepat, tanpa install tambahan ribet.

Keuntungan pakai di Omarchy:
- **Mudah akses**: Dari Neovim, tekan `<Space>gg`—langsung muncul!
- **Produktif**: Commit, push, branch, stash—semua satu tempat.
- **Pemula-friendly**: Nggak perlu hafal perintah Git panjang.

Kalau belum punya Omarchy, clone dari GitHub dotfiles Omarchy dulu ya. Asumsi kamu udah setup.

### Cara Install Lazygit di Omarchy (Kalau Belum Ada)
Omarchy biasanya udah include lazygit via lazy.nvim atau paket manager. Tapi kalau nggak, tambahin gini:

1. Install lazygit via package manager:
   - Ubuntu/Debian: `sudo apt install lazygit`
   - Arch: `sudo pacman -S lazygit`
   - macOS: `brew install lazygit`

2. Di Neovim Omarchy, pastiin pluginnya aktif. Buka `init.lua` atau `plugins.lua`, tambah:
   ```lua
   return {
       "kdheepak/lazygit.nvim",
       keys = {
           { "<leader>gg", "<cmd>LazyGit<cr>", desc = "LazyGit" },
       },
   }
   ```
   Reload Neovim: `:Lazy sync`.

Selesai! Sekarang lazygit siap dipakai.

### Cara Masuk ke Lazygit di Omarchy
Dua cara utama, pilih yang nyaman:

1. **Dari Terminal Biasa**:
   - Masuk ke folder repo Git kamu (yang ada `.git`).
   - Ketik: `lazygit`
   - Boom! Tampilan full-screen muncul.

2. **Dari Neovim (Rekomendasi Omarchy)**:
   - Buka file di Neovim.
   - Tekan `<Space>gg` (spasi lalu g dua kali).
   - Lazygit terbuka di window Neovim—ngedit code sambil Git-an!

Pro tip: Kalau sering pindah repo, buat alias di `.zshrc` Omarchy: `alias lg=lazygit`. Tinggal ketik `lg`.

### Navigasi Dasar di Lazygit (Hanya Pakai Keyboard)
Lazygit punya panel-panel: Files, Commits, Branches, Stash. Pindah antar panel pakai **Tab**.

- **Panel Files**: Lihat file yang berubah. Tekan **Space** buat stage (centang hijau) atau unstage.
- **Panel Commits**: Lihat history. Tekan **Enter** buat detail diff.
- **Panel Branches**: Tekan **b** buat checkout atau buat branch baru.

Lihat semua shortcut: Tekan **?** (tanda tanya). Keluar: **q** atau **Ctrl+C**.

### Cara Commit di Lazygit (Paling Mudah!)
Ini bagian favorit: Commit cuma 3 langkah!

1. Di panel Files, pilih file dengan arrow keys.
2. Tekan **Space** sampai centang hijau (stage all: tekan **a**).
3. Tekan **c** (commit).
   - Muncul editor pesan: Ketik pesan commit, misal "fix bug login".
   - Save: Esc lalu `:wq` (kalau vim-mode).

Selesai! Commit langsung jadi.

### Cara Push di Lazygit (Cuma 1 Tombol)
Setelah commit, push gampang banget:

1. Tetap di lazygit.
2. Tekan **p** (push).
   - Kalau branch baru: Otomatis set upstream seperti `git push -u origin main`.
   - Kalau mau opsi lanjutan (force push): Tekan **P** (huruf besar).

Contoh alur lengkap: `<Space>gg` → Space (stage) → c (commit) → p (push) → q (keluar). Kurang dari 10 detik!

### Tips Lanjutan buat Power User Omarchy
- **Pull changes**: Tekan **P** (huruf besar, beda dari push).
- **Stash changes**: Di panel Files, tekan **s**. Pop stash: **Shift+s**.
- **Amend commit**: Tekan **a** setelah stage file baru.
- **Lihat diff**: Tekan **Enter** di file/commit.
- **Branch management**: Tekan **B** buat list branch, **d** buat delete.

Kalau error? Cek `git status` dulu atau restart lazygit.

### Kesimpulan: Lazygit + Omarchy = Git Tanpa Ribet
Dengan lazygit di Omarchy, Git jadi fun lagi—nggak lagi ketik perintah panjang. Coba sekarang, dan rasain bedanya. Buat pemula, ini cara terbaik mulai Git di terminal. Kalau suka, share tutorial ini ke teman developer-mu!

Punya pertanyaan? Komen di bawah. Stay productive! 🚀

*Tags: tutorial lazygit, cara pakai lazygit omarchy, git terminal mudah, neovim git integration, linux developer tips* 

Ditulis oleh [Nama Kamu] pada 7 Desember 2025. Ikuti blog untuk tutorial tech lain!