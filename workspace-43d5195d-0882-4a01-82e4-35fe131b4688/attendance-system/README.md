# Sistem Absensi Guru Berbasis Web

Sistem absensi guru berbasis web yang dibuat dengan PHP dan MySQL menggunakan pola MVC (Model-View-Controller) dengan prinsip OOP (Object-Oriented Programming).

## Fitur Utama

### 1. Fitur Admin
- **Kelola Data Guru**: Tambah, edit, hapus, dan nonaktifkan data guru
- **Kelola Jadwal Mengajar**: Manajemen jadwal dengan drag & drop interface
- **Absensi Manual**: Input kehadiran guru secara manual
- **Laporan Real-time**: Monitoring absensi secara real-time
- **Generate Rekap**: Rekap kehadiran harian, mingguan, bulanan, dan semesteran
- **Export Data**: Export data ke Excel/PDF
- **Kelola Izin**: Approve/reject izin guru
- **Monitoring Guru**: Pantau guru yang belum absen sesuai jadwal

### 2. Fitur Guru
- **Login**: Autentikasi dengan username/NIP dan password
- **Jadwal Pribadi**: Melihat jadwal mengajar dalam kalender view
- **Absensi Mandiri**: Melakukan absensi melalui web interface atau mobile
- **Riwayat Absensi**: Melihat riwayat absensi pribadi dengan filter
- **Ajukan Izin**: Pengajuan izin/cuti secara online
- **Upload Bukti**: Upload bukti pendukung untuk izin

### 3. Sistem Absensi Multi-Metode
- **Absensi Mandiri**: Guru dapat melakukan absensi sendiri
- **Absensi Admin**: Admin dapat menginput/mengedit absensi
- **Absensi Otomatis**: Sistem menandai 'Tidak Hadir' jika guru tidak absen
- **Validasi Ganda**: Mencegah duplikasi absensi
- **Audit Trail**: Riwayat perubahan absensi

### 4. Status Kehadiran Lengkap
- Hadir Tepat Waktu
- Terlambat (dengan catatan menit keterlambatan)
- Tidak Hadir
- Izin (dinas, pribadi, dll)
- Sakit (dengan upload surat dokter)
- Cuti
- Libur Nasional

### 5. Security & Validation
- Password hashing (bcrypt)
- Session management dengan timeout
- Input validation dan sanitization
- Protection terhadap SQL injection dan XSS
- Role-based access control
- Audit log untuk semua perubahan data

### 6. User Interface
- Responsive design (desktop, tablet, mobile)
- Dashboard dengan statistik real-time
- Calendar view untuk jadwal
- Notification system
- Report generator dengan filter
- Import/export data

### 7. Fitur Tambahan
- QR code attendance system
- Geolocation validation
- Bulk attendance input
- Automatic reminder
- WhatsApp/SMS notification integration

## Teknologi yang Digunakan

### Backend
- PHP 7.4+
- MySQL 5.7+
- PDO untuk database connection
- Session management
- CSRF protection

### Frontend
- HTML5
- CSS3
- JavaScript (jQuery)
- Bootstrap 5
- Font Awesome
- DataTables
- FullCalendar
- Chart.js

### Security
- bcrypt password hashing
- CSRF tokens
- Input sanitization
- SQL injection prevention
- XSS protection
- Session security

## Struktur Database

### Tabel Guru
```sql
CREATE TABLE guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nip VARCHAR(20) NOT NULL UNIQUE,
    jabatan VARCHAR(50) NOT NULL,
    status_aktif TINYINT(1) DEFAULT 1,
    foto_profil VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabel Jadwal Mengajar
```sql
CREATE TABLE jadwal_mengajar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guru_id INT NOT NULL,
    hari ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    mata_pelajaran VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    semester ENUM('Ganjil', 'Genap') NOT NULL,
    tahun_ajaran VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE
);
```

### Tabel Absensi
```sql
CREATE TABLE absensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guru_id INT NOT NULL,
    jadwal_id INT NOT NULL,
    tanggal DATE NOT NULL,
    waktu_masuk TIME DEFAULT NULL,
    waktu_keluar TIME DEFAULT NULL,
    status_kehadiran ENUM('hadir', 'terlambat', 'tidak_hadir', 'izin', 'sakit', 'cuti') NOT NULL,
    keterangan TEXT DEFAULT NULL,
    dibuat_oleh INT NOT NULL,
    metode_absen ENUM('mandiri', 'admin', 'qr_code', 'otomatis') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE,
    FOREIGN KEY (jadwal_id) REFERENCES jadwal_mengajar(id) ON DELETE CASCADE,
    FOREIGN KEY (dibuat_oleh) REFERENCES pengguna(id) ON DELETE CASCADE
);
```

### Tabel Pengguna
```sql
CREATE TABLE pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    level_akses ENUM('admin', 'guru') NOT NULL,
    guru_id INT DEFAULT NULL,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE SET NULL
);
```

### Tabel Izin
```sql
CREATE TABLE izin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guru_id INT NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    jenis_izin ENUM('dinas', 'pribadi', 'sakit', 'cuti') NOT NULL,
    alasan TEXT NOT NULL,
    status_approval ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    file_bukti VARCHAR(255) DEFAULT NULL,
    approved_by INT DEFAULT NULL,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES pengguna(id) ON DELETE SET NULL
);
```

## Instalasi

### 1. Persyaratan Sistem
- Web server (Apache/Nginx)
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Ekstensi PHP: PDO, mysqli, gd, mbstring

### 2. Langkah Instalasi

1. **Download dan Ekstrak**
   ```bash
   git clone https://github.com/username/sistem-absensi-guru.git
   cd sistem-absensi-guru
   ```

2. **Konfigurasi Database**
   - Buat database baru di MySQL
   - Import file `database.sql`
   ```sql
   CREATE DATABASE sistem_absensi_guru;
   USE sistem_absensi_guru;
   SOURCE database.sql;
   ```

3. **Konfigurasi Koneksi Database**
   - Edit file `config/database.php`
   ```php
   private $host = "localhost";
   private $user = "root";
   private $pass = "";
   private $dbname = "sistem_absensi_guru";
   ```

4. **Set Permission Folder**
   ```bash
   chmod -R 755 attendance-system/
   chmod -R 777 attendance-system/public/uploads/
   ```

5. **Konfigurasi Virtual Host (Apache)**
   ```apache
   <VirtualHost *:80>
       DocumentRoot "/path/to/attendance-system"
       ServerName attendance-system.local
       <Directory "/path/to/attendance-system">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

6. **Akses Aplikasi**
   - Buka browser dan akses `http://attendance-system.local`
   - Login dengan default admin:
     - Username: `admin`
     - Password: `admin123`

## Struktur Folder

```
attendance-system/
├── app/                    # Application files
├── config/                 # Configuration files
│   ├── config.php         # Main configuration
│   └── database.php       # Database configuration
├── controllers/            # Controller files
│   ├── AuthController.php
│   ├── HomeController.php
│   ├── GuruController.php
│   ├── JadwalController.php
│   ├── AbsensiController.php
│   └── IzinController.php
├── models/                 # Model files
│   ├── Guru.php
│   ├── JadwalMengajar.php
│   ├── Absensi.php
│   ├── Pengguna.php
│   └── Izin.php
├── views/                  # View files
│   ├── layout.php         # Main layout
│   ├── auth/              # Authentication views
│   ├── admin/             # Admin views
│   └── guru/              # Guru views
├── public/                # Public files
│   ├── css/               # CSS files
│   ├── js/                # JavaScript files
│   ├── images/            # Image files
│   └── uploads/           # Upload files
├── includes/               # Include files
│   ├── helpers.php        # Helper functions
│   └── security.php       # Security functions
├── api/                   # API files
├── database.sql           # Database schema
├── index.php             # Entry point
├── .htaccess             # URL rewriting
└── README.md             # This file
```

## Penggunaan

### Login Administrator
1. Buka halaman login
2. Masukkan username dan password admin
3. Klik tombol login

### Login Guru
1. Buka halaman login
2. Masukkan username/NIP dan password
3. Klik tombol login

### Menambah Guru
1. Login sebagai admin
2. Pilih menu "Guru"
3. Klik tombol "Tambah Guru"
4. Isi form yang tersedia
5. Upload foto profil (opsional)
6. Klik "Simpan"

### Membuat Jadwal Mengajar
1. Login sebagai admin
2. Pilih menu "Jadwal"
3. Klik tombol "Tambah Jadwal"
4. Pilih guru, hari, jam, mata pelajaran, kelas
5. Klik "Simpan"

### Melakukan Absensi
1. Login sebagai guru
2. Pilih menu "Absensi"
3. Pilih jadwal yang akan diabsen
4. Klik "Check In" atau scan QR code
5. Selesai mengajar, klik "Check Out"

### Mengajukan Izin
1. Login sebagai guru
2. Pilih menu "Izin"
3. Klik "Ajukan Izin"
4. Isi form izin (tanggal, jenis, alasan)
5. Upload bukti pendukung (jika diperlukan)
6. Klik "Kirim"

### Menyetujui Izin
1. Login sebagai admin
2. Pilih menu "Izin"
3. Pilih tab "Menunggu Persetujuan"
4. Klik "Setujui" atau "Tolak"

## Troubleshooting

### 1. Error Database Connection
- Pastikan MySQL server running
- Cek koneksi database di `config/database.php`
- Pastikan database sudah dibuat

### 2. Error 404 Not Found
- Pastikan mod_rewrite Apache aktif
- Cek file `.htaccess`
- Pastikan URL rewriting enabled

### 3. Error Session
- Pastikan folder session writable
- Cek konfigurasi session di `php.ini`
- Hapus session cookies di browser

### 4. Error Upload File
- Pastikan folder `uploads` writable
- Cek ukuran maksimal upload di `php.ini`
- Pastikan ekstensi file diizinkan

## Kontribusi

1. Fork repository
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## License

Dilisensikan under MIT License - lihat file [LICENSE](LICENSE) untuk detail

## Support

Jika ada masalah atau pertanyaan, silahkan:
- Buat issue di GitHub
- Kirim email ke support@example.com
- Kunjungi dokumentasi di docs.example.com

## Changelog

### v1.0.0 (2023-12-01)
- Initial release
- Basic attendance system
- Admin and guru dashboard
- Schedule management
- Permission system
- QR code attendance

### v1.1.0 (2023-12-15)
- Add export to Excel/PDF
- Add notification system
- Add drag & drop schedule
- Improve UI/UX
- Bug fixes

### v1.2.0 (2024-01-01)
- Add mobile responsive design
- Add WhatsApp/SMS notification
- Add geolocation validation
- Add bulk attendance
- Performance improvements