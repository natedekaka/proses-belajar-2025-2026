# Panduan Pemula Belajar Vim: Kuasai Motions dan Modes untuk Coding Lebih Cepat

**Permalink:** /belajar-vim-pemula-motions-modes-efisien

**Deskripsi Penelusuran:** Pelajari Vim dari nol dengan tips The Primeagen: modes, motions, dan trik sederhana agar coding lebih cepat. Ideal untuk programmer pemula! (112 karakter)

**Sumber:** [YouTube: Belajar Vim oleh The Primeagen](https://www.youtube.com/watch?v=X6AR2RMB5tE&list=PLm323Lc7iSW_wuxqmKx_xxNtJC_hJbQ7R)

Halo, para programmer! Jika kamu pernah merasa frustrasi dengan editor kode yang lambat atau terlalu bergantung pada mouse, saatnya mencoba Vim. Dalam artikel ini, saya akan merangkum transkrip dari video pertama seri "Belajar Vim" oleh The Primeagen, seorang developer berpengalaman yang telah menggunakan Vim selama 10 tahun. Fokusnya adalah membuatmu dari pemula total menjadi mahir dalam menggunakan *Vim motions* dan *modes*, yang bisa diterapkan di editor seperti VS Code, IntelliJ, atau bahkan Neovim (versi modern Vim yang lebih fleksibel dan mudah dikustomisasi).

Seri ini dirancang bertahap, sehingga kamu bisa ikuti langkah demi langkah tanpa kewalahan. The Primeagen membedakan antara "Vim the program" (editor itu sendiri) dan "Vim motions" (gerakan efisien yang bisa digunakan di mana saja). Motions ini super berguna untuk navigasi cepat, dan tersedia di plugin untuk editor populer seperti VS Code atau Sublime. Jika kamu suka kustomisasi, Neovim adalah pilihan bagus karena lebih modern dan punya komunitas aktif—kamu bisa mulai dengan menginstalnya via situs resmi mereka.

### Mengapa Belajar Vim atau Neovim?
Vim bukan sekadar editor; ini seperti "game" di mana kamu combo tombol untuk edit teks super cepat. Bayangkan coding tanpa angkat tangan dari keyboard—efisien banget! The Primeagen bilang, motions Vim adalah yang terbaik untuk programmer, tapi editor Vim sendiri butuh adaptasi karena kamu harus konfigurasi sendiri (via `.vimrc` atau `.config/nvim` untuk Neovim). Jika penasaran, cek video tentang `.vimrc` di deskripsi YouTube asli.

Tips awal: Jangan langsung pindah ke Vim/Neovim full-time. Mulai dengan plugin Vim di editor favoritmu (misalnya, VS Code Vim extension). Ini bantu kamu biasa tanpa ganggu workflow.

### Dasar Vim: Empat Modes Utama
Vim adalah *modal editor*, artinya punya mode berbeda untuk navigasi, edit, dll. Ini beda dari editor biasa yang langsung bisa ketik. Empat mode utama:

1. **Normal Mode**: Mode default saat buka Vim. Di sini, tombol keyboard buat navigasi, bukan ketik. Gunakan `h` (kiri), `j` (bawah), `k` (atas), `l` (kanan) untuk gerak kursor. Latih ini dulu!
   
2. **Insert Mode**: Mode untuk ketik seperti editor biasa. Masuk dengan tekan `i` (insert di kiri kursor) atau `a` (insert di kanan). Keluar dengan `Esc` atau `Ctrl+C`. Neovim punya fitur auto-indent yang lebih pintar.

3. **Visual Mode**: Untuk select teks seperti highlight mouse. Tekan `v` untuk visual char-by-char, atau `Shift+V` untuk visual line. Berguna buat copy-paste.

4. **Command Mode**: Tekan `:` untuk masuk. Di sini, ketik perintah seperti `:w` (save), `:q` (quit), atau `:wq` (save & quit). Lucu, meme "can't quit Vim" masih relevan meski mudah sebenarnya!

### Motions: Gerakan Dasar yang Bikin Vim Cepat
Motions adalah inti Vim—cara gerak kursor efisien. Mulai dengan dasar:

- `h/j/k/l`: Gerak dasar (kiri/bawah/atas/kanan).
- `w`: Lompat ke awal kata berikutnya (word forward).
- `b`: Lompat ke awal kata sebelumnya (backward).

Tambah *count* untuk ulang: `8k` = gerak 8 baris atas, `3w` = lompat 3 kata depan. Aktifkan *relative line numbers* di config (di Neovim: `set relativenumber` di `init.vim`) untuk lompat mudah, seperti `5j` untuk 5 baris bawah.

The Primeagen sarankan latihan via game di Neovim: Ketik `:VimBeGood` untuk mode latihan hjkl atau relative jumps. Ini bikin muscle memory cepat terbentuk!

### Commands: Delete, Yank, Paste
Gabung motions dengan commands:

- `d` (delete): `dd` hapus satu baris, `dw` hapus satu kata, `d3j` hapus baris saat ini + 3 baris bawah.
- `y` (yank/copy): `yy` copy baris, `y5j` copy 5 baris bawah.
- `p` (paste): Tempel setelah kursor. Yank dan delete masuk ke buffer sama, jadi `dd` lalu `p` tempel baris yang dihapus.

Di visual mode: Select dulu, lalu `y` untuk copy, `p` untuk paste over select.

Undo? Tekan `u`. Redo? `Ctrl+R`.

### Tips untuk Pemula agar Tidak Frustrasi
- Jangan hafal semua sekaligus. Mulai dengan hjkl, w/b, dan modes dasar. Latih seminggu, baru lanjut.
- Jika di VS Code, aktifkan Vim mode dan subscribe channel The Primeagen untuk motivasi (dia bilang subscribe bikin belajar lebih mudah—haha!).
- Neovim lebih ramah pemula karena plugin mudah (via Packer atau Lazy). Coba instal dan mainkan game latihan tadi.
- Ini bagian tersulit seri. Setelah mahir motions, editing jadi seperti game combo—cepat dan fun!

Dengan latihan, Vim/Neovim bikin kamu edit kode tanpa pikir panjang. Ini bukan cuma tool, tapi skill yang bikin produktif. Lanjut ke part 2 seri asli jika sudah siap. Bagaimana pengalamanmu belajar Vim? Share di komentar!

Terima kasih The Primeagen atas inspirasinya. Semoga artikel ini bantu kamu paham dan mulai pakai Neovim/Vim hari ini! 🚀