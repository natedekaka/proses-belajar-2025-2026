**Judul Blog (Langsung Bikin Klik + SEO Gila):**  
Neovim Part 5: Vertical Editing + Trik CEO ThePrimeagen yang Bikin Kamu Ngedit Ribuan Baris dalam 3 Detik

**Permalink:**  
/neovim-part5-vertical-editing-vap-yap-cib-gaa-primeagen

**Deskripsi Penelusuran (137 karakter):**  
Part 5 ThePrimeagen: Trik vertical editing paling cepat — VAP, ci{, yap, g ctrl-a, visual block, dan hack “vi{ Esc” buat lompat cepat!

**Sumber Asli:**  
[YouTube – ThePrimeagen: Vim As Your Editor – Vertical Editing (Part 5)](https://www.youtube.com/watch?v=uL9oOZStezw&list=PLm323Lc7iSW_wuxqmKx_xxNtJC_hJbQ7R&index=5)

### Combo Paling OP yang Wajib Kamu Hafal Minggu Ini

| Combo                 | Artinya                                        | Kapan Pakai?                          | Efek di Otak        |
| --------------------- | ---------------------------------------------- | ------------------------------------- | ------------------- |
| `va{` / `va(` / `va[` | Visual select around curly/paren/bracket       | Mau hapus/ganti seluruh blok          | 1 detik!            |
| `di{`                 | Delete inside curly braces                     | Hapus isi fungsi tanpa kurungnya      | Super bersih        |
| `ci{`                 | Change inside curly → langsung insert          | Ganti seluruh isi fungsi              | Favorit CEO         |
| `yi{`                 | Yank inside curly                              | Copy isi blok kode                    |                     |
| `yip` / `yap`         | Yank inner/around paragraph                    | Copy blok kode + spasi sekitar        | yap = emas!         |
| `dap`                 | Delete around paragraph (termasuk spasi)       | Bersihin blok kode                    |                     |
| `>ap` / `=ap`         | Indent / auto-format seluruh paragraf          | Format ulang blok kode                | =ap = magic         |
| `g Ctrl-A`            | Increment angka di banyak baris sekaligus      | Bikin array data0, data1, data2…      | Otak meledak        |
| `vi{ Esc`             | Pindah ke akhir fungsi/array tanpa Tree-sitter | Fungsi 1000 baris? Langsung ke bawah! | Hack terakhir video |

### Contoh Real-Life yang Bikin Kamu “WADUH, KOK BISA?”

1. Mau ambil isi objek config → `ci{` → paste → selesai  
2. Mau bikin array dari 50 baris → `yap` → paste → `Vip` → `:s/^/data`/ → `g Ctrl-A` → jadi data0 sampai data49 dalam 5 detik  
3. Mau hapus seluruh fungsi raksasa → `va{Vd` (capital V = line-wise) → gone!  
4. Di JSON/array ribuan baris → `vi[` → `Esc` → langsung lompat ke bracket penutup

### Kenapa ThePrimeagen Nggak Pakai EasyMotion & [[ / ]] ?
- Karena tergantung gaya orang lain → kadang lompat terlalu jauh  
- Ngerusak jump list (`Ctrl-O`) → susah balik  
- Dia mau tetap cepat meskipun cuma SSH ke server tanpa plugin

### Remap Wajib Tambahan (Lua)
```lua
-- Auto-indent paragraf dengan satu tombol
vim.keymap.set('n', '<leader==', '=ap', { desc = 'Format paragraf' })

-- Increment lebih gampang
vim.keymap.set('v', 'g+', 'g Ctrl-A', { desc = 'Increment selection' })
```

### Tantangan 48 Jam (Wajib Dilakuin!)
1. Buka file JavaScript/TypeScript/React yang paling berantakan di projectmu  
2. Larang diri sendiri pakai mouse atau Ctrl+V biasa  
3. Paksa gunakan `ci{`, `yap`, `=ap`, dan `g Ctrl-A` minimal 30 kali  
4. Besok kamu bakal ngerasa kayak cheat engine nyala

Setelah part 5 ini, kamu resmi jadi **Neovim CEO level** — tinggal pake jas dan ngomong “blazingly fast” sambil ngedit 10.000 baris sekaligus.

Sudah coba `vi{ Esc` di JSON raksasa belum? Tulis di komentar “CEO mode activated” kalau sudah! 🔥

Keep being the multi-billion dollar startup CEO of your own codebase,  
ThePrimeagen & saya yang bantu kamu jadi dewa vertical editing!