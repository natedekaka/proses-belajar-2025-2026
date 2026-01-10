### Tutorial: Setup Mirror & Extend Display Mudah di Hyprland (Arch Linux)

Halo teman-teman Linux enthusiast! Kali ini kita bahas cara simpel mengatur **mirror** (duplikat layar) dan **extend** (layar tambahan) di Hyprland, cocok banget buat presentasi pakai proyektor atau dual monitor di rumah/kantor.

#### Langkah 1: Atur Config Dasar (Default Mirror Otomatis)
Edit file `~/.config/hypr/hyprland.conf`, tambahkan ini:

```conf
# Laptop built-in sebagai primary (ganti eDP-1 jika nama monitor kamu beda)
monitor = eDP-1, preferred, auto, 1

# Semua monitor eksternal/proyektor yang dicolok otomatis MIRROR dari laptop
monitor = , preferred, auto, 1, mirror, eDP-1
```

Simpan, lalu reload dengan `hyprctl reload`.  
**Hasil:** Saat colok proyektor/monitor eksternal apa pun, langsung mirror otomatis — ideal untuk presentasi!

#### Langkah 2: Tambah Keybind Super Praktis untuk Switch Extend/Mirror
Tambahkan baris ini di config yang sama (bagian bind biasanya di bawah):

```conf
# SUPER + E = Switch ke EXTEND (monitor eksternal jadi layar tambahan di kanan)
bind = SUPER, E, exec, hyprctl keyword monitor ",preferred,auto,1"

# SUPER + M = Balik ke MIRROR (duplikat layar lagi)
bind = SUPER, M, exec, hyprctl keyword monitor ",preferred,auto,1,mirror,eDP-1"
```

Reload lagi dengan `hyprctl reload`.

**Cara pakai sehari-hari:**
- Colok monitor/proyektor → otomatis **mirror**.
- Mau extend (dual screen)? Tekan **Super + E**.
- Mau balik mirror? Tekan **Super + M**.

Super cepat, nggak perlu edit config lagi!

#### Tips Tambahan
- Cek nama monitor kamu dengan `hyprctl monitors`.
- Jika layout posisi aneh saat extend, ganti `auto` jadi posisi manual (misal `1920x0` untuk di kanan).

Selamat mencoba! Setup ini bikin hidup pakai Hyprland jauh lebih fleksibel. 🚀

**Permalink terbaik (SEO-friendly):**  
`https://blogkamu.com/hyprland-mirror-extend-display-keybind`

**Deskripsi penelusuran (meta description, 138 karakter):**  
Tutorial singkat setup mirror & extend display di Hyprland Arch Linux dengan keybind Super+E/M. Otomatis mirror proyektor, switch extend mudah!