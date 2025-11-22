# Belajar Ruby on Rails dari Nol di Omarchy Linux  
(Oleh: Dani Arsyah – Guru Informatika SMA Negeri 6 Cimahi – Kelas XI – Tahun 2025)

Halo anak-anak kelas XI IPA/IPS dan teman-teman guru se-Indonesia!

Saya Pak Dani, biasa dipanggil Pak Dan, guru Informatika di SMA Negeri 6 Cimahi.  
Baru minggu ini saya mulai belajar Ruby on Rails dari nol (beneran nol banget).  
Tujuan saya: nanti bisa bikin aplikasi **Jurnal Harian Online** yang bisa dipakai kalian semua di kelas untuk menulis refleksi harian, mood tracker, dan portofolio proyek.

Setelah muter-muter 2 hari, akhirnya berhasil install Ruby + Rails terbaru di laptop Omarchy Linux saya. Saya catat langkah-langkahnya supaya kalian tidak perlu pusing seperti saya.

### Langkah Install Ruby + Rails di Omarchy / Arch Linux (November 2025)

1. Update sistem  
   ```bash
   sudo pacman -Syu
   ```

2. Install Ruby dan alat penting  
   ```bash
   sudo pacman -S ruby rubygems nodejs npm
   ```

3. Install Rails terbaru  
   ```bash
   gem install rails
   ```

4. Atasi error “rails: command not found” (ini yang bikin saya stuck 1 hari)  
   ```bash
   export PATH="$HOME/.local/share/gem/ruby/3.4.0/bin:$PATH"
   echo 'export PATH="$HOME/.local/share/gem/ruby/3.4.0/bin:$PATH"' >> ~/.bashrc
   source ~/.bashrc
   ```

5. Cek berhasil!  
   ```bash
   ruby -v
   rails -v
   ```
   Hasil saya:
   ```
   ruby 3.4.7 (2025-10-08 …)
   Rails 8.1.1
   ```

### Tes Pertama: Game Tebak Angka (Hari 1 Belajar Ruby)

Saya langsung bikin game kecil ini (cuma 25 baris):

```ruby
# tebak_angka.rb – karya pertama Pak Dani
puts "=================================="
puts "   GAME TEBAK ANGKA – KELAS XI    "
puts "=================================="

angka_rahasia = rand(1..100)
tebakan = 0
jumlah = 0

puts "Ayo tebak angka 1–100!"

while tebakan != angka_rahasia
  print "Tebakanmu: "
  tebakan = gets.chomp.to_i
  jumlah += 1
  
  if tebakan < angka_rahasia
    puts "↑ Terlalu kecil!"
  elsif tebakan > angka_rahasia
    puts "↓ Terlalu besarar!"
  else
    puts "KEREN! Kamu benar dalam #{jumlah} kali tebakan!"
  end
end
```

Cara main:
```bash
ruby tebak_angka.rb
```

Rekor saya sampai sekarang: 6 tebakan (pernah 12 juga, haha).

### Rencana Belajar Pak Dani ke Depan (kalian boleh ikutan!)
- Minggu 1–2 → Kuasai dasar Ruby (variabel, array, hash, method)
- Minggu 3 → Bikin blog sederhana pakai Rails
- Minggu 4–6 → Bikin aplikasi Jurnal Harian Online (ada login, rich text, foto, mood tracker)
- Minggu 7 → Deploy gratis di Render.com → kalian semua bisa akses lewat HP!

Nanti aplikasi jurnalnya bisa kalian pakai untuk tugas refleksi, portofolio P5, atau proyek akhir tahun.

### Pesan dari Pak Dani
Ruby on Rails masih sangat hidup di tahun 2025 (malah baru rilis versi 8!).  
Di Omarchy/Arch Linux, instalasinya justru paling gampang dan selalu dapat versi terbaru.  
Jadi buat kalian anak kelas XI yang pakai Linux, tidak ada alasan lagi “susah install”.

Kalau ada yang mau belajar bareng, boleh komentar di bawah atau WA saya.  
Nanti kita bikin grup “Rails SMAN 6 Cimahi 2025”.

Sampai ketemu di postingan berikutnya:  
“Hari 2 – Variabel, Array, dan Hash dalam Ruby”

Salam coding dari ruang guru Informatika!  
Pak Dani Arsyah  
Guru Informatika SMA Negeri 6 Cimahi  
Kelas XI – Tahun Pelajaran 2025/2026