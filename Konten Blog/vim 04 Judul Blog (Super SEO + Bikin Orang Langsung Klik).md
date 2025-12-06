### Judul Blog (Super SEO + Bikin Orang Langsung Klik)  
Neovim Part 4: Text Objects & Operators – Senjata Rahasia ThePrimeagen yang Bikin Kamu Ngedit Kode Kayak Dewa

**Permalink:**  
/neovim-part4-text-objects-operator-inner-around-primeagen

**Deskripsi Penelusuran (134 karakter):**  
Part 4 ThePrimeagen: Kuasai text objects (iw, a", ip, it) + operator (d, c, y) → hapus, ganti, copy blok kode dalam 1–2 tombol saja!

**Sumber Asli:**  
[YouTube – ThePrimeagen: Vim As Your Editor – Part 4 (Operators & Text Objects)](https://www.youtube.com/watch?v=qZO9A5F6BZs&list=PLm323Lc7iSW_wuxqmKx_xxNtJC_hJbQ7R&index=4)

### Intisari yang Paling Gampang Dipahami (Langsung Bisa Dipraktikkan 3 Menit Lagi)

Setelah kamu jago gerakin kursor (part 1–3), sekarang waktunya naik level jadi **Vim God Mode** dengan 2 konsep sakti:

1. **Operator** = apa yang mau kamu lakukan  
   → `d` (delete), `c` (change/hapus+lansung insert), `y` (yank/copy), `>` (indent), `<` (unindent), dll.

2. **Text Object** = bagian teks yang mau kamu operasi  
   → `iw` = inner word  
   → `aw` = a word (termasuk spasi di sekitar)  
   → `i"` = inner quotes  
   → `a"` = around quotes (termasuk tanda kutipnya)  
   → `i)` / `ib` = inner bracket/parentheses  
   → `a)` / `ab` = around bracket  
   → `i]` / `i>` / `i}` = inner kurung lain  
   → `ip` = inner paragraph  
   → `it` = inner tag (HTML)  
   → `i>` = inner angle bracket

### Combo Paling Sering Dipakai (bikin kamu 20× lebih cepat)

| Combo | Artinya                          | Contoh Hasil                             |
| ----- | -------------------------------- | ---------------------------------------- |
| `ciw` | change inner word                | hapus satu kata + langsung insert        |
| `ci"` | change inside quotes             | ganti isi string tanpa hapus tanda kutip |
| `ca"` | change around quotes             | ganti string + tanda kutipnya sekalian   |
| `di(` | delete inside parentheses        | hapus isi fungsi tanpa kurungnya         |
| `da(` | delete around parentheses        | hapus seluruh call fungsi                |
| `yip` | yank inner paragraph             | copy satu blok kode                      |
| `>ip` | indent seluruh paragraf          | format ulang blok kode                   |
| `ci{` | change inside curly braces       | ganti isi fungsi/blok                    |
| `vat` | visual + around tag (HTML) → `d` | hapus tag HTML + isinya sekali tekan     |
| `yit` | yank inside tag                  | copy isi tag HTML                        |

### Contoh Real-Life (yang bikin kamu “WADUH!”)
Kursor di tengah-tengah kata `username` → tekan `ciw` → ketik `email` → selesai.  
Kursor di dalam fungsi panjang → `ci{` → ketik fungsi baru → seluruh isi blok langsung terganti.  
Mau ganti semua isi string → `ci"` → ketik string baru → tanda kutip tetap utuh.

### Tips ThePrimeagen
- `i` = **inner** (tanpa delimiter)  
- `a` = **around** (termasuk delimiter)  
- Selalu pakai `c` (change) daripada `d` + `i` → lebih cepat 1 tombol  
- Gunakan visual mode kalau ragu: `v i )` → lihat dulu apa yang kena select

### Tantangan 24 Jam (Wajib!)
1. Buka project kamu  
2. Larang diri sendiri pakai mouse untuk delete/change/copy selama 24 jam  
3. Paksa gunakan `ciw`, `ci"`, `di(`, `yip` minimal 50 kali  
4. Besok kamu bakal ketawa sendiri ngeliat seberapa lambat dulu caramu ngedit

Setelah part 4 ini selesai, kamu resmi jadi **Neovim black belt** di level editing. Tinggal satu part lagi (macro & repeat) dan kamu beneran bakal ngerasain “coconut oil everywhere”.

Sudah coba `ciw` belum? Tulis di komentar combo favoritmu hari ini! 🔥

Keep being blazingly fast,  
ThePrimeagen & saya yang bantu kamu jadi dewa Neovim!