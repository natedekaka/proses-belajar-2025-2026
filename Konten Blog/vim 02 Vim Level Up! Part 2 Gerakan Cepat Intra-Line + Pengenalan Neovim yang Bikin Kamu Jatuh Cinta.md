# Vim Level Up! Part 2: Gerakan Cepat Intra-Line + Pengenalan Neovim yang Bikin Kamu Jatuh Cinta

**Permalink:** /vim-neovim-level-up-motions-f-t-o-harpoon-telescope

**Deskripsi Penelusuran (119 karakter):** Tingkatkan skill Vim/Neovim kamu! Pelajari motions f, t, F, T, O/o, plus konsep buffer, Telescope & Harpoon dari The Primeagen.

**Sumber asli:**  
[YouTube – ThePrimeagen: Vim As Your Editor – Part 2](https://www.youtube.com/watch?v=8gMO7y2p4B8&list=PLm323Lc7iSW_wuxqmKx_xxNtJC_hJbQ7R&index=2)

### Ringkasan yang Bikin Kamu Langsung “Wah, gitu caranya!”

Setelah part 1 kamu sudah jago hjkl + w/b + count, sekarang saatnya naik level jadi **Vim Diesel** yang licin pakai coconut oil!

#### 1. Motions Horizontal Paling OP (bikin ngedit baris jadi instan)
| Tombol     | Fungsi                                     | Contoh Praktis                    |
| ---------- | ------------------------------------------ | --------------------------------- |
| `$`        | Ke akhir baris                             | `d$` → hapus sampai akhir baris   |
| `^`        | Ke karakter pertama yang bukan spasi       | `d^` → hapus sampai awal “isi”    |
| `0`        | Ke kolom paling kiri (kolom 0)             |                                   |
| `f + char` | Lompat **ke atas** karakter itu (forward)  | `f(` → langsung ke tanda kurung   |
| `F + char` | Lompat mundur ke karakter itu              | `F=` → lompat ke = sebelum kursor |
| `t + char` | Lompat **sampai sebelum** karakter (till)  | `dt)` → hapus sampai sebelum )    |
| `T + char` | Lompat mundur sampai sebelum karakter      |                                   |
| `;`        | Ulangi f/F/t/T ke depan                    |                                   |
| `,`        | Ulangi ke arah berlawanan                  |                                   |
| `O`        | Buat baris baru di atas + langsung insert  | Super cepat nambah baris!         |
| `o`        | Buat baris baru di bawah + langsung insert |                                   |

Contoh combo gila:
- `df)` → hapus dari kursor sampai termasuk tanda kurung )
- `ct$` → change (hapus + insert) sampai akhir baris
- `y2f"` → yank sampai tanda kutip kedua

#### 2. Pengertian Buffer vs Window (penting banget buat Neovim!)
- **Buffer** = file yang ada di memori (bisa sama di banyak tempat)
- **Window** = “jendela” yang menampilkan buffer
- Satu buffer bisa ditampilkan di banyak window sekaligus → edit di satu tempat, otomatis update di semua jendela!

#### 3. Navigasi File di Neovim yang Bikin Kamu Lupa Mouse
- `:Ex` atau `:Sex` atau `:Vex` → buka file explorer bawaan (netrw)
- Tapi yang bener-bener bikin cepat:
  - **Telescope** → fuzzy finder tercanggih (cari file, git branch, dll dalam milidetik)
  - **Harpoon** (buatan The Primeagen sendiri) → tandai 4–10 file penting, lompat antar file pakai satu tombol!

#### 4. Filosofi The Primeagen yang Wajib Kamu Tanamkan
> “Install plugin hanya kalau kamu benar-benar butuh. Kalau belum ada yang pas, buat sendiri!”

Itulah kenapa dia bikin Harpoon — karena nggak ada yang cocok buat dia waktu itu.

### Kesimpulan & Tantangan Minggu Ini
1. Hafalin dan latihan `f t F T ; ,` sampai otomatis (bisa langsung 2–5× lebih cepat ngedit satu baris!)
2. Pasang Telescope + Harpoon di Neovim kamu (cara instal ada di video vimrc-nya)
3. Coba buka 4 file penting di projectmu, tandai dengan Harpoon, lalu lompat-lompat tanpa mouse

Setelah ini selesai, kamu resmi naik kelas dari “pemula pakai training wheels” jadi “junior coconut oil user”! Tunggu part 3 yang bakal bahas gerakan vertikal super canggih + text objects.

Siap jadi licin? Drop komentar “sudah pasang Harpoon” kalau kamu sudah coba! 🚀

Keep sliding,  
The Primeagen & saya yang nulis ringkasan ini supaya kamu makin jago Neovim!