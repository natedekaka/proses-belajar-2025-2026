**Judul Blog (SEO + Click-Magnet):**  
Neovim Part 3: Cara Bergerak Vertikal & Search yang Bikin Kamu 10× Lebih Cepat (ThePrimeagen Style)

**Permalink:**  
/neovim-part3-gerakan-vertikal-search-zz-asterisk

**Deskripsi Penelusuran (129 karakter):**  
Part 3 ThePrimeagen: Ctrl+D/U + zz, search /*, relative number, dan trik supaya mata nggak pusing lagi saat coding di Neovim!

**Sumber Asli:**  
[YouTube – ThePrimeagen: Vim As Your Editor – Vertical Motion (Part 3)](https://www.youtube.com/watch?v=KfENDDEpCsI&list=PLm323Lc7iSW_wuxqmKx_xxNtJC_hJbQ7R&index=3)

### Intisari yang Langsung Bikin Kamu Bisa Praktik 5 Menit Lagi

#### Gerakan Vertikal Terbaik 2025 (urutan prioritas ala ThePrimeagen)
| Rank | Tombol                  | Fungsi                            | Rekomendasi Primeagen                                  |
| ---- | ----------------------- | --------------------------------- | ------------------------------------------------------ |
| 1    | `Ctrl + D` / `Ctrl + U` | Turun/naik setengah layar         | WAJIB diremap + `zz` (center screen)                   |
| 2    | `8j` / `5k`             | Lompat pakai relative line number | Super akurat kalau target kelihatan                    |
| 3    | `/kata` atau `*`        | Search kata                       | `*` = cepat banget, nggak perlu ketik                  |
| 4    | `n` / `N`               | Next / previous match             | Remap `nzz` dan `Nzz` biar selalu tengah               |
| 5    | `gg` / `G`              | Ke atas/bawah file                | Jarang dipakai                                         |
| 6    | `{` / `}`               | Lompat paragraf                   | Kurang direkomendasikan (tergantung format orang lain) |

#### Remap Wajib yang Harus Kamu Pasang HARI INI (Lua)
```lua
-- init.lua atau plugins/keymaps.lua
vim.keymap.set('n', '<C-d>', '<C-d>zz', { desc = 'Half-page down + center' })
vim.keymap.set('n', '<C-u>', '<C-u>zz', { desc = 'Half-page up + center' })
vim.keymap.set('n', 'n', 'nzzzv', { desc = 'Next search + center' })
vim.keymap.set('n', 'N', 'Nzzzv', { desc = 'Prev search + center' })
vim.keymap.set('n', '*', '*zz', { desc = 'Search word under cursor + center' })
```

Setelah ini dipasang, mata kamu nggak akan pernah “kejar-kejar kursor” lagi.

#### Workflow Nyata ThePrimeagen Saat Nulis Kode
1. Ctrl+D / Ctrl+U sampai target masuk layar  
2. Lihat nomor relative → langsung `12j` atau `7k`  
3. Kalau masih jauh → taruh kursor di kata → tekan `*` → `nnnn`  
→ Selesai dalam ≤ 2 detik

#### Bonus Tips
- `*` = search kata di bawah kursor ke arah bawah  
- `#` = ke arah atas (Primeagen jarang pakai, cukup `*` + `N` kapital)  
- `:123` = langsung lompat ke baris 123 (error message biasanya kasih nomor baris)

### Tantangan 48 Jam
1. Pasang semua remap di atas  
2. Matikan mouse & scroll wheel selama 48 jam  
3. Tiap mau cari fungsi/variabel → pakai `*` atau `/` (dilarang Ctrl+F)  
4. Hari ketiga kamu bakal ngomong sendiri: “Kok dulu aku lambat banget ya…”

Setelah ini selesai, kamu resmi lulus dari “pemula yang masih pakai mouse” jadi “intermediate coconut oil warrior” dan siap ke part berikutnya (text objects + macro = bom nuklir produktivitas).

Sudah pasang remap `zz` belum? Tulis di komentar “zz activated” kalau sudah! 🚀

Keep sliding,  
ThePrimeagen & saya yang bantu kamu jatuh cinta sama Neovim!