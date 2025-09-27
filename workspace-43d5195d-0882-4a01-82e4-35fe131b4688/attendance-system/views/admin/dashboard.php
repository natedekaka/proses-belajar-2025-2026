<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard Administrator
        </h1>
    </div>
</div>

<!-- Dashboard Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Guru
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-guru">
                            <?php echo $total_guru; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300 card-icon"></i>
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
                            Total Jadwal
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-jadwal">
                            <?php echo $total_jadwal; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300 card-icon"></i>
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
                            Total Absensi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-absensi">
                            <?php echo $total_absensi; ?>
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
        <div class="card dashboard-card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Izin Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="pending-izin">
                            <?php echo $pending_izin; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300 card-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Jadwal Hari Ini -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Jadwal Mengajar Hari Ini</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/jadwal/today">Lihat Semua</a>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/jadwal/calendar">Kalender</a>
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
                                    <th>Guru</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jadwal_hari_ini as $jadwal): ?>
                                    <tr>
                                        <td><?php echo formatJamIndo($jadwal['jam_mulai']) . ' - ' . formatJamIndo($jadwal['jam_selesai']); ?></td>
                                        <td><?php echo $jadwal['guru_nama']; ?></td>
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
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Ringkasan Absensi Hari Ini -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Ringkasan Absensi Hari Ini</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/absensi/today">Lihat Detail</a>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/absensi/report">Laporan</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($ringkasan_absensi)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-user-times fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada data absensi hari ini</p>
                    </div>
                <?php else: ?>
                    <div class="chart-container">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                    
                    <div class="row mt-3">
                        <?php foreach ($ringkasan_absensi as $status => $count): ?>
                            <div class="col-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="badge badge-<?php echo $status; ?> me-2"></div>
                                    <span class="small"><?php echo getStatusKehadiran($status); ?>: <?php echo $count; ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Guru Belum Absen -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Guru Belum Absen</h6>
                <button class="btn btn-sm btn-danger" onclick="autoMarkAbsence()">
                    <i class="fas fa-robot me-1"></i> Tandai Otomatis
                </button>
            </div>
            <div class="card-body">
                <?php if (empty($guru_belum_absen)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="text-gray-500">Semua guru sudah melakukan absensi</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Guru</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Jam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($guru_belum_absen as $guru): ?>
                                    <tr>
                                        <td><?php echo $guru['nama']; ?></td>
                                        <td><?php echo $guru['mata_pelajaran']; ?></td>
                                        <td><?php echo $guru['kelas']; ?></td>
                                        <td><?php echo formatJamIndo($guru['jam_mulai']) . ' - ' . formatJamIndo($guru['jam_selesai']); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="addAbsence(<?php echo $guru['id']; ?>, <?php echo $guru['jadwal_id']; ?>)">
                                                <i class="fas fa-plus"></i>
                                            </button>
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

    <!-- Izin Pending -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Izin Menunggu Persetujuan</h6>
                <a href="<?php echo BASE_URL; ?>/izin/pending" class="btn btn-sm btn-primary">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <?php if (empty($izin_pending)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-file-check fa-3x text-success mb-3"></i>
                        <p class="text-gray-500">Tidak ada izin yang menunggu persetujuan</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Guru</th>
                                    <th>Jenis Izin</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($izin_pending, 0, 5) as $izin): ?>
                                    <tr>
                                        <td><?php echo $izin['guru_nama']; ?></td>
                                        <td><?php echo getJenisIzin($izin['jenis_izin']); ?></td>
                                        <td><?php echo formatTanggalIndo($izin['tanggal_mulai']); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-success" onclick="approveIzin(<?php echo $izin['id']; ?>)">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-danger" onclick="rejectIzin(<?php echo $izin['id']; ?>)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if (count($izin_pending) > 5): ?>
                        <div class="text-center mt-2">
                            <a href="<?php echo BASE_URL; ?>/izin/pending" class="text-primary">
                                Lihat semua izin pending (<?php echo count($izin_pending); ?>)
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Absensi Terbaru -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Absensi Terbaru</h6>
    </div>
    <div class="card-body">
        <?php if (empty($absensi_terbaru)): ?>
            <div class="text-center py-4">
                <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
                <p class="text-gray-500">Belum ada data absensi</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absensi_terbaru as $absensi): ?>
                            <tr>
                                <td><?php echo formatTanggalIndo($absensi['tanggal']) . ' ' . formatJamIndo($absensi['waktu_masuk']); ?></td>
                                <td><?php echo $absensi['guru_nama']; ?></td>
                                <td><?php echo $absensi['mata_pelajaran']; ?></td>
                                <td><?php echo $absensi['kelas']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $absensi['status_kehadiran']; ?>">
                                        <?php echo getStatusKehadiran($absensi['status_kehadiran']); ?>
                                    </span>
                                </td>
                                <td><?php echo $absensi['keterangan'] ?: '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Initialize attendance chart
if (document.getElementById('attendanceChart')) {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Terlambat', 'Tidak Hadir', 'Izin', 'Sakit'],
            datasets: [{
                data: [
                    <?php echo $ringkasan_absensi['hadir'] ?? 0; ?>,
                    <?php echo $ringkasan_absensi['terlambat'] ?? 0; ?>,
                    <?php echo $ringkasan_absensi['tidak_hadir'] ?? 0; ?>,
                    <?php echo $ringkasan_absensi['izin'] ?? 0; ?>,
                    <?php echo $ringkasan_absensi['sakit'] ?? 0; ?>
                ],
                backgroundColor: [
                    '#198754',
                    '#fd7e14',
                    '#dc3545',
                    '#0dcaf0',
                    '#6f42c1'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Auto mark absence
function autoMarkAbsence() {
    if (confirm('Apakah Anda yakin ingin menandai semua guru yang belum absen sebagai Tidak Hadir?')) {
        $.ajax({
            url: '<?php echo BASE_URL; ?>/absensi/auto-mark',
            method: 'POST',
            data: {
                tanggal: '<?php echo date('Y-m-d'); ?>',
                csrf_token: '<?php echo generateCSRFToken(); ?>'
            },
            success: function(response) {
                if (response.success) {
                    alert('Berhasil menandai ' + response.data.marked + ' guru sebagai tidak hadir');
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
}

// Add absence
function addAbsence(guruId, jadwalId) {
    window.location.href = '<?php echo BASE_URL; ?>/absensi/add?guru_id=' + guruId + '&jadwal_id=' + jadwalId;
}

// Approve izin
function approveIzin(izinId) {
    if (confirm('Apakah Anda yakin ingin menyetujui izin ini?')) {
        $.ajax({
            url: '<?php echo BASE_URL; ?>/izin/approve/' + izinId,
            method: 'POST',
            data: {
                csrf_token: '<?php echo generateCSRFToken(); ?>'
            },
            success: function(response) {
                if (response.success) {
                    alert('Izin berhasil disetujui');
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
}

// Reject izin
function rejectIzin(izinId) {
    if (confirm('Apakah Anda yakin ingin menolak izin ini?')) {
        $.ajax({
            url: '<?php echo BASE_URL; ?>/izin/reject/' + izinId,
            method: 'POST',
            data: {
                csrf_token: '<?php echo generateCSRFToken(); ?>'
            },
            success: function(response) {
                if (response.success) {
                    alert('Izin berhasil ditolak');
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
}

// Auto refresh dashboard
setInterval(function() {
    $.ajax({
        url: '<?php echo BASE_URL; ?>/api/dashboard-stats',
        method: 'GET',
        success: function(data) {
            $('#total-guru').text(data.total_guru);
            $('#total-jadwal').text(data.total_jadwal);
            $('#total-absensi').text(data.total_absensi);
            $('#pending-izin').text(data.pending_izin);
        }
    });
}, 30000); // Refresh every 30 seconds
</script>