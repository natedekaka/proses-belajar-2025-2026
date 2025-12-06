**Judul Blog (Click-Magnet + SEO Ganas):**  
Neovim Real Life: Cara ThePrimeagen Debug Rust, Fix Bug & Resolve Merge Conflict dalam 5 Menit Pakai LSP + Harpoon + Fugitive

**Permalink:**  
/neovim-real-life-debug-harpoon-lsp-fugitive-merge-conflict

**Deskripsi Penelusuran (138 karakter):**  
Lihat ThePrimeagen live debug Rust, fix bug, resolve merge conflict pake Harpoon, Telescope, LSP, Fugitive — semua tanpa lepas tangan dari keyboard!

**Sumber Asli:**  
[YouTube – ThePrimeagen: Using Vim effectively (Part 7)](https://www.youtube.com/watch?v=FrMRyXtiJkc&list=PLm323Lc7iSW_wuxqmKx_xxNtJC_hJbQ7R&index=7)

### Workflow Nyata ThePrimeagen (Bisa Kamu Tiru Hari Ini)

| Situasi                         | Tombol yang Dia Pakai                                  | Hasil dalam < 3 Detik                       |
| ------------------------------- | ------------------------------------------------------ | ------------------------------------------- |
| Buka file main.rs cepat         | `<Ctrl-p>` → ketik “main” → Enter                      | Langsung di baris error (dari cargo run)    |
| Lompat ke definisi fungsi       | `gd`                                                   | LSP langsung bawa ke fungsi                 |
| Balik ke file sebelumnya        | `<C-^>` (Ctrl + 6) atau Harpoon Ctrl+h/t               | Super cepat bolak-balik                     |
| Bookmark file penting           | `<leader>a` → tambah ke Harpoon                        | Selalu 1 tombol ke file yang lagi dikerjain |
| Buka Harpoon menu               | `<Ctrl-e>`                                             | Pilih file 1-4 dengan satu jari             |
| Cek git status                  | `<leader>gs`                                           | Fugitive langsung buka :Git                 |
| Stage hanya chunk tertentu      | Visual select → `S`                                    | Bisa commit perubahan kecil doang           |
| Resolve merge conflict          | `:Gdiffsplit` → `gh` (ambil kanan) / `gu` (ambil kiri) | Conflict selesai dalam 3 detik              |
| Push ke remote                  | `<leader>P` atau langsung `:Git push`                  | Tanpa keluar Vim                            |
| Context fungsi selalu kelihatan | nvim-treesitter-context (otomatis)                     | Selalu tahu kamu lagi di fungsi mana        |

### Combo Paling Sering Dipakai (Wajib Pasang!)

```lua
-- Harpoon (contoh remap ThePrimeagen)
<leader>a   → harpoon.mark.add_file()
<Ctrl-e>    → harpoon.ui.toggle_quick_menu()
<Ctrl-h>    → harpoon.nav_file(1)
<Ctrl-t>    → harpoon.nav_file(2)
<Ctrl-n>    → harpoon.nav_file(3)
<Ctrl-s>    → harpoon.nav_file(4)

-- Git & Diff
<leader>gs  → :Git
<leader>P   → :Git push
gh          → :diffget //3  (ambil kanan)
gu          → :diffget //2  (ambil kiri)
```

### Highlight Moment yang Bikin Kamu “GILA!”
1. Bug karena folder `controllers` dan `views` nggak ada → langsung create via `std::fs::create_dir` → fix dalam 20 detik  
2. Resolve merge conflict 5 baris → pakai `:Gdiffsplit` + `gh`/`gu` → selesai sebelum kamu kedip  
3. Bolak-balik 4 file pake Harpoon → kayak pake Alt+Tab tapi 100× lebih cepat  
4. Tree-sitter context → nama fungsi selalu nempel di atas meskipun scroll ribuan baris

### Tantangan 24 Jam (Wajib!)
1. Pasang Harpoon + remap Ctrl+hjkl  
2. Pasang nvim-treesitter-context  
3. Pasang remap `gh`/`gu` untuk diffget  
4. Selesaikan 1 bug atau merge conflict tanpa pakai mouse sama sekali  
5. Besok kamu bakal ngerasa kayak ThePrimeagen versi budget

Setelah video ini, kamu nggak cuma “punya Neovim” — kamu beneran **PAKAI** Neovim kayak pro.

Sudah coba `gh`/`gu` di merge conflict belum? Tulis di komentar “conflict destroyed” kalau sudah! 🔥

Keep being keyboard-centric Chad,  
ThePrimeagen & saya yang bantu kamu jadi raja terminal!