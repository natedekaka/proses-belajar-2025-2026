**Judul Blog (Super Clickbait + SEO Juara):**  
Neovim dari NOL sampai GIGA CHAD dalam 1 Video – Setup ThePrimeagen 2024 (LSP, Tree-sitter, Harpoon, Telescope!)

**Permalink:**  
/neovim-setup-dari-nol-theprimeagen-2024-lsp-harpoon-telescope

**Deskripsi Penelusuran (139 karakter):**  
Setup Neovim dari kosong bareng ThePrimeagen: init.lua, Packer → LSP Zero, Tree-sitter, Harpoon, Telescope + remap terbaik seumur hidup!

**Sumber Asli:**  
[YouTube – ThePrimeagen: Setting up Neovim from scratch (2023 → 2024)](https://www.youtube.com/watch?v=w7i4amO_zaE&list=PLm323Lc7iSW_wuxqmKx_xxNtJC_hJbQ7R&index=6)

### Ringkasan Super Gampang + Langsung Bisa Dipakai Hari Ini

ThePrimeagen bikin config Neovim dari **benar-benar kosong** (bahkan tanpa folder ~/.config/nvim) sampai jadi setup impian dalam 40 menit. Ini semua yang kamu butuh:

#### 1. Struktur Folder (WAJIB persis gini)
```
~/.config/nvim/
├── init.lua
└── lua/
    └── theprimeagen/
        ├── init.lua
        ├── remap.lua
        ├── set.lua
        ├── packer.lua
        └── lsp.lua
    └── after/plugin/
        ├── telescope.lua
        ├── harpoon.lua
        ├── treesitter.lua
        ├── rose-pine.lua
        ├── undotree.lua
        └── fugitive.lua
```

#### 2. Plugin Inti yang Dipasang
| Plugin           | Fungsi                            | Kenapa Harus Ada?                    |
| ---------------- | --------------------------------- | ------------------------------------ |
| Packer.nvim      | Plugin manager                    | Paling ringan & cepat                |
| Telescope        | Fuzzy finder (Ctrl+P on steroids) | Cari file/grep dalam milidetik       |
| Harpoon          | Bookmark 4 file + lompat 1 tombol | Buatan Primeagen sendiri!            |
| nvim-treesitter  | Syntax highlighting + AST         | Warna jauh lebih cerdas dari bawaan  |
| rose-pine        | Colorscheme paling creamy         | Waifu background approved            |
| undotree         | Visualisasi undo history          | Bisa balik ke branch undo lain       |
| vim-fugitive     | Git di dalam Vim                  | :Git blame, :Gdiff, dll              |
| lsp-zero + mason | LSP super gampang                 | 3 baris kode → LSP siap semua bahasa |

#### 3. Remap Paling Cocok Buat Manusia 2024
```lua
-- Leader = space
vim.g.mapleader = " "

-- Harpoon (Ctrl+hjkl atau leader 1-4)
leader a    → tambah file ke Harpoon
Ctrl e      → buka Harpoon menu
Ctrl h/j/k/l → lompat ke file 1-4

-- Telescope
<leader>pf  → cari semua file
<leader>pg  → cari hanya file di git
<leader>ps  → live grep (cari kata di seluruh project)

-- Favorit Primeagen
<leader>pv  → buka netrw
<leader>u   → buka undotree
<leader>gs  → :Git status (fugitive)
<leader>y   → yank ke system clipboard
"_d         → delete tanpa ganggu register (void register)
J           → gabung baris tanpa gerak kursor
<C-d> / <C-u> → half page + zz (selalu di tengah)
```

#### 4. Set.lua yang Bikin Hidup Enak
```lua
vim.opt.nu = true
vim.opt.relativenumber = true
vim.opt.tabstop = 4
vim.opt.softtabstop = 4
vim.opt.shiftwidth = 4
vim.opt.expandtab = true
vim.opt.smartindent = true
vim.opt.wrap = false
vim.opt.swapfile = false
vim.opt.backup = false
vim.opt.undodir = os.getenv("HOME") .. "/.vim/undodir"
vim.opt.undofile = true
vim.opt.hlsearch = false
vim.opt.incsearch = true
vim.opt.termguicolors = true
vim.opt.scrolloff = 8
vim.opt.updatetime = 50
vim.opt.colorcolumn = "120"
```

#### 5. Bonus Hack Akhir Video
- `<leader>x` → otomatis `chmod +x %` (bikin file executable langsung)
- `<leader>s` → replace kata di bawah kursor di seluruh file (tanpa regex ribet)

### Mau Langsung Pakai?
1. Clone config ThePrimeagen (dia kasih link di deskripsi video)  
2. Atau copy-paste semua dari artikel ini  
3. `:PackerSync` → tunggu 2 menit → restart Neovim → kamu sudah jadi GIGA CHAD

Setelah video ini selesai, kamu resmi lulus dari “orang yang cuma install LunarVim” jadi “orang yang paham Neovim dari dalam”.

Sudah coba `<leader>a` + Harpoon belum? Tulis di komentar “GIGA CHAD activated” kalau sudah jadi! 🔥

Keep being blazingly fast,  
ThePrimeagen & saya yang bantu kamu jadi raja Neovim!