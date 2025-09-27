<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard Guru
        </h1>
    </div>
</div>

<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <?php if (!empty($guru['foto_profil'])): ?>
                        <img src="<?php echo BASE_URL; ?>/public/uploads/profile/<?php echo $guru['foto_profil']; ?>" 
                             class="rounded-circle me-3" width="60" height="60" alt="Profile">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h4 class="mb-1">Selamat datang, <?php echo $guru['nama']; ?></h4>
                        <p class="mb-0 text-muted"><?php echo $guru['jabatan']; ?> | NIP: <?php echo $guru['nip']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jadwal Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo count($jadwal_hari_ini); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300 card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card border-left-success shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Absensi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo count($absensi_terbaru); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300 card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card border-left-info shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Izin Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php 
                            $izin_aktif = 0;
                            foreach ($izin_terbaru as $izin) {
                                if ($izin['status_approval'] == 'approved') {
                                    $izin_aktif++;
                                }
                            }
                            echo $izin_aktif;
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-check fa-2x text-gray-300 card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Kehadiran Bulan Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php 
                            $hadir_bulan_ini = 0;
                            foreach ($absensi_terbaru as $absensi) {
                                if (date('Y-m') == date('Y-m', strtotime($absensi['tanggal']))) {
                                    $hadir_bulan_ini++;
                                }
                            }
                            echo $hadir_bulan_ini;
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300 card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Jadwal Hari Ini -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Jadwal Mengajar Hari Ini</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/guru/jadwal/today">Lihat Detail</a>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/guru/jadwal/calendar">Kalender</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($jadwal_hari_ini)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Tidak ada jadwal mengajar hari ini</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jadwal_hari_ini as $jadwal): ?>
                                    <tr>
                                        <td><?php echo formatJamIndo($jadwal['jam_mulai']) . ' - ' . formatJamIndo($jadwal['jam_selesai']); ?></td>
                                        <td><?php echo $jadwal['mata_pelajaran']; ?></td>
                                        <td><?php echo $jadwal['kelas']; ?></td>
                                        <td>
                                            <?php
                                            $current_time = date('H:i:s');
                                            if ($current_time >= $jadwal['jam_mulai'] && $current_time <= $jadwal['jam_selesai']) {
                                                echo '<span class="badge bg-success">Sedang Berlangsung</span>';
                                            } elseif ($current_time < $jadwal['jam_mulai']) {
                                                echo '<span class="badge bg-primary">Akan Datang</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary">Selesai</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            // Check if already attended
                                            $attended = false;
                                            foreach ($absensi_terbaru as $absensi) {
                                                if ($absensi['jadwal_id'] == $jadwal['id'] && $absensi['tanggal'] == date('Y-m-d')) {
                                                    $attended = true;
                                                    break;
                                                }
                                            }
                                            
                                            if ($current_time >= $jadwal['jam_mulai'] && $current_time <= $jadwal['jam_selesai'] && !$attended) {
                                                echo '<button class="btn btn-sm btn-primary" onclick="checkIn(' . $jadwal['id'] . ')">Check In</button>';
                                            } elseif ($attended && empty($absensi['waktu_keluar'])) {
                                                echo '<button class="btn btn-sm btn-success" onclick="checkOut(' . $jadwal['id'] . ')">Check Out</button>';
                                            } elseif ($attended) {
                                                echo '<span class="text-success">Sudah Absen</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if (!empty($jadwal_sekarang)): ?>
                        <button class="btn btn-primary" onclick="checkIn(<?php echo $jadwal_sekarang['id']; ?>)">
                            <i class="fas fa-sign-in-alt me-2"></i> Check In Sekarang
                        </button>
                    <?php endif; ?>
                    
                    <a href="<?php echo BASE_URL; ?>/guru/izin/add" class="btn btn-warning">
                        <i class="fas fa-file-alt me-2"></i> Ajukan Izin
                    </a>
                    
                    <a href="<?php echo BASE_URL; ?>/guru/jadwal/calendar" class="btn btn-info">
                        <i class="fas fa-calendar me-2"></i> Lihat Jadwal
                    </a>
                    
                    <a href="<?php echo BASE_URL; ?>/guru/absensi/history" class="btn btn-success">
                        <i class="fas fa-history me-2"></i> Riwayat Absensi
                    </a>
                </div>
                
                <hr>
                
                <h6 class="mb-3">QR Code Absensi</h6>
                <div class="text-center">
                    <div id="qrcode" class="mb-3"></div>
                    <button class="btn btn-outline-primary btn-sm" onclick="showQRScanner()">
                        <i class="fas fa-qrcode me-1"></i> Scan QR Code
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Jadwal Sekarang -->
    <?php if (!empty($jadwal_sekarang)): ?>
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-left-success">
                <div class="card-body">
                    <h6 class="text-success">Jadwal Sekarang</h6>
                    <h5><?php echo $jadwal_sekarang['mata_pelajaran']; ?></h5>
                    <p class="mb-1">
                        <i class="fas fa-clock me-2"></i>
                        <?php echo formatJamIndo($jadwal_sekarang['jam_mulai']) . ' - ' . formatJamIndo($jadwal_sekarang['jam_selesai']); ?>
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-door-open me-2"></i>
                        <?php echo $jadwal_sekarang['kelas']; ?>
                    </p>
                    
                    <?php
                    // Check if already attended
                    $attended = false;
                    $absensi_info = null;
                    foreach ($absensi_terbaru as $absensi) {
                        if ($absensi['jadwal_id'] == $jadwal_sekarang['id'] && $absensi['tanggal'] == date('Y-m-d')) {
                            $attended = true;
                            $absensi_info = $absensi;
                            break;
                        }
                    }
                    
                    if (!$attended) {
                        echo '<button class="btn btn-success" onclick="checkIn(' . $jadwal_sekarang['id'] . ')">Check In</button>';
                    } elseif (empty($absensi_info['waktu_keluar'])) {
                        echo '<button class="btn btn-primary" onclick="checkOut(' . $jadwal_sekarang['id'] . ')">Check Out</button>';
                        echo '<p class="mb-0 mt-2 text-success">Check in: ' . formatJamIndo($absensi_info['waktu_masuk']) . '</p>';
                    } else {
                        echo '<p class="mb-0 text-success">Sudah selesai mengajar</p>';
                        echo '<p class="mb-0 text-muted">Check in: ' . formatJamIndo($absensi_info['waktu_masuk']) . '</p>';
                        echo '<p class="mb-0 text-muted">Check out: ' . formatJamIndo($absensi_info['waktu_keluar']) . '</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Jadwal Selanjutnya -->
    <?php if (!empty($jadwal_selanjutnya)): ?>
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-left-primary">
                <div class="card-body">
                    <h6 class="text-primary">Jadwal Selanjutnya</h6>
                    <h5><?php echo $jadwal_selanjutnya['mata_pelajaran']; ?></h5>
                    <p class="mb-1">
                        <i class="fas fa-clock me-2"></i>
                        <?php echo formatJamIndo($jadwal_selanjutnya['jam_mulai']) . ' - ' . formatJamIndo($jadwal_selanjutnya['jam_selesai']); ?>
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-door-open me-2"></i>
                        <?php echo $jadwal_selanjutnya['kelas']; ?>
                    </p>
                    
                    <?php
                    $time_until = strtotime($jadwal_selanjutnya['jam_mulai']) - time();
                    $minutes_until = floor($time_until / 60);
                    
                    if ($minutes_until > 0) {
                        echo '<p class="mb-0 text-muted">Dimulai dalam ' . $minutes_until . ' menit</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Recent Activities -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terkini</h6>
    </div>
    <div class="card-body">
        <div class="timeline">
            <?php 
            // Combine absensi and izin for timeline
            $activities = [];
            
            // Add absensi activities
            foreach (array_slice($absensi_terbaru, 0, 5) as $absensi) {
                $activities[] = [
                    'type' => 'absensi',
                    'data' => $absensi,
                    'time' => strtotime($absensi['tanggal'] . ' ' . $absensi['waktu_masuk'])
                ];
            }
            
            // Add izin activities
            foreach (array_slice($izin_terbaru, 0, 3) as $izin) {
                $activities[] = [
                    'type' => 'izin',
                    'data' => $izin,
                    'time' => strtotime($izin['created_at'])
                ];
            }
            
            // Sort by time
            usort($activities, function($a, $b) {
                return $b['time'] - $a['time'];
            });
            
            if (empty($activities)): 
            ?>
                <div class="text-center py-4">
                    <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada aktivitas</p>
                </div>
            <?php else: ?>
                <?php foreach ($activities as $activity): ?>
                    <?php if ($activity['type'] == 'absensi'): ?>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2">
                                        <i class="fas fa-user-check text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>Absensi <?php echo getStatusKehadiran($activity['data']['status_kehadiran']); ?></strong>
                                        <span class="text-muted small ms-2">
                                            <?php echo formatTanggalIndo($activity['data']['tanggal']) . ' ' . formatJamIndo($activity['data']['waktu_masuk']); ?>
                                        </span>
                                    </div>
                                </div>
                                <p class="mb-0 text-muted">
                                    <?php echo $activity['data']['mata_pelajaran'] . ' - ' . $activity['data']['kelas']; ?>
                                </p>
                            </div>
                        </div>
                    <?php elseif ($activity['type'] == 'izin'): ?>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-2">
                                        <i class="fas fa-file-alt text-warning"></i>
                                    </div>
                                    <div>
                                        <strong>Ajukan <?php echo getJenisIzin($activity['data']['jenis_izin']); ?></strong>
                                        <span class="badge bg-<?php echo $activity['data']['status_approval'] == 'approved' ? 'success' : ($activity['data']['status_approval'] == 'rejected' ? 'danger' : 'warning'); ?> ms-2">
                                            <?php echo getStatusIzin($activity['data']['status_approval']); ?>
                                        </span>
                                    </div>
                                </div>
                                <p class="mb-0 text-muted">
                                    <?php echo formatTanggalIndo($activity['data']['tanggal_mulai']) . ' - ' . formatTanggalIndo($activity['data']['tanggal_selesai']); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code Scanner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="qr-scanner"></div>
                <div class="text-center mt-3">
                    <p class="text-muted">Arahkan kamera ke QR code untuk melakukan absensi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Check In function
function checkIn(jadwalId) {
    $.ajax({
        url: '<?php echo BASE_URL; ?>/absensi/check-in',
        method: 'POST',
        data: {
            jadwal_id: jadwalId,
            csrf_token: '<?php echo generateCSRFToken(); ?>'
        },
        success: function(response) {
            if (response.success) {
                alert('Check in berhasil!');
                location.reload();
            } else {
                alert(response.error);
            }
        },
        error: function() {
            alert('Terjadi kesalahan');
        }
    });
}

// Check Out function
function checkOut(jadwalId) {
    $.ajax({
        url: '<?php echo BASE_URL; ?>/absensi/check-out',
        method: 'POST',
        data: {
            jadwal_id: jadwalId,
            csrf_token: '<?php echo generateCSRFToken(); ?>'
        },
        success: function(response) {
            if (response.success) {
                alert('Check out berhasil!');
                location.reload();
            } else {
                alert(response.error);
            }
        },
        error: function() {
            alert('Terjadi kesalahan');
        }
    });
}

// Show QR Scanner
function showQRScanner() {
    $('#qrScannerModal').modal('show');
    
    // Initialize QR scanner
    if (typeof Html5QrcodeScanner !== 'undefined') {
        const scanner = new Html5QrcodeScanner('qr-scanner', {
            qrbox: {
                width: 250,
                height: 250
            },
            fps: 20
        });
        
        scanner.render(onScanSuccess, onScanError);
        
        function onScanSuccess(decodedText, decodedResult) {
            $.ajax({
                url: '<?php echo BASE_URL; ?>/absensi/qr-check-in',
                method: 'POST',
                data: {
                    qr_data: decodedText,
                    csrf_token: '<?php echo generateCSRFToken(); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Absensi QR code berhasil!');
                        scanner.clear();
                        $('#qrScannerModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response.error);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan');
                }
            });
        }
        
        function onScanError(errorMessage) {
            console.log(errorMessage);
        }
    } else {
        alert('QR scanner library tidak tersedia');
    }
}

// Generate QR Code
$(document).ready(function() {
    if (typeof QRCode !== 'undefined') {
        // Generate QR code for current schedule
        <?php if (!empty($jadwal_sekarang)): ?>
            new QRCode(document.getElementById("qrcode"), {
                text: generateQRData(<?php echo $_SESSION['guru_id']; ?>, <?php echo $jadwal_sekarang['id']; ?>),
                width: 128,
                height: 128
            });
        <?php endif; ?>
    }
});

// Auto refresh dashboard
setInterval(function() {
    $.ajax({
        url: '<?php echo BASE_URL; ?>/api/guru-dashboard-stats',
        method: 'GET',
        success: function(data) {
            // Update stats if needed
        }
    });
}, 60000); // Refresh every minute
</script>