<?php
require_once '../config/config.php';

// Set header for JSON response
header('Content-Type: application/json');

// Get the requested endpoint
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

// Route the request
switch ($endpoint) {
    case 'dashboard-stats':
        getDashboardStats();
        break;
    case 'guru-dashboard-stats':
        getGuruDashboardStats();
        break;
    case 'calendar-events':
        getCalendarEvents();
        break;
    case 'csrf-token':
        getCSRFToken();
        break;
    default:
        sendJSONResponse(['error' => 'Endpoint not found'], 404);
}

function getDashboardStats() {
    requireAdmin();
    
    $guruModel = new Guru();
    $jadwalModel = new JadwalMengajar();
    $absensiModel = new Absensi();
    $izinModel = new Izin();
    
    $stats = [
        'total_guru' => $guruModel->getGuruCount(),
        'total_jadwal' => $jadwalModel->getJadwalCount(),
        'total_absensi' => $absensiModel->getAbsensiCount(),
        'pending_izin' => $izinModel->getPendingIzinCount()
    ];
    
    sendJSONResponse($stats);
}

function getGuruDashboardStats() {
    requireGuru();
    
    $guru_id = $_SESSION['guru_id'];
    $jadwalModel = new JadwalMengajar();
    $absensiModel = new Absensi();
    $izinModel = new Izin();
    
    $today = date('Y-m-d');
    $day = date('l', strtotime($today));
    
    // Get today's schedule
    $jadwal_hari_ini = $jadwalModel->getJadwalByGuruId($guru_id);
    $jadwal_hari_ini = array_filter($jadwal_hari_ini, function($jadwal) use ($day) {
        return $jadwal['hari'] == $day;
    });
    
    // Get recent absensi
    $absensi_terbaru = $absensiModel->getAbsensiByGuruId($guru_id, null, null, 10);
    
    // Get recent izin
    $izin_terbaru = $izinModel->getIzinByGuruId($guru_id);
    
    $stats = [
        'jadwal_hari_ini' => count($jadwal_hari_ini),
        'total_absensi' => count($absensi_terbaru),
        'izin_aktif' => count(array_filter($izin_terbaru, function($izin) {
            return $izin['status_approval'] == 'approved';
        })),
        'hadir_bulan_ini' => count(array_filter($absensi_terbaru, function($absensi) {
            return date('Y-m') == date('Y-m', strtotime($absensi['tanggal']));
        }))
    ];
    
    sendJSONResponse($stats);
}

function getCalendarEvents() {
    requireAuth();
    
    $jadwalModel = new JadwalMengajar();
    $izinModel = new Izin();
    
    $events = [];
    
    if (isAdmin()) {
        // Get all schedules
        $jadwal_list = $jadwalModel->getAllJadwal();
        
        foreach ($jadwal_list as $jadwal) {
            $events[] = [
                'title' => $jadwal['mata_pelajaran'] . ' - ' . $jadwal['kelas'],
                'start' => getNextDateForDay($jadwal['hari']),
                'backgroundColor' => '#0d6efd',
                'borderColor' => '#0d6efd',
                'extendedProps' => [
                    'guru' => $jadwal['guru_nama'],
                    'jam' => formatJamIndo($jadwal['jam_mulai']) . ' - ' . formatJamIndo($jadwal['jam_selesai'])
                ]
            ];
        }
        
        // Get all approved izin
        $izin_list = $izinModel->getIzinByStatus('approved');
        
        foreach ($izin_list as $izin) {
            $events[] = [
                'title' => 'Izin: ' . getJenisIzin($izin['jenis_izin']),
                'start' => $izin['tanggal_mulai'],
                'end' => date('Y-m-d', strtotime($izin['tanggal_selesai'] . ' +1 day')),
                'backgroundColor' => '#dc3545',
                'borderColor' => '#dc3545',
                'extendedProps' => [
                    'guru' => $izin['guru_nama'],
                    'alasan' => $izin['alasan']
                ]
            ];
        }
    } elseif (isGuru()) {
        $guru_id = $_SESSION['guru_id'];
        
        // Get guru's schedules
        $jadwal_list = $jadwalModel->getJadwalByGuruId($guru_id);
        
        foreach ($jadwal_list as $jadwal) {
            $events[] = [
                'title' => $jadwal['mata_pelajaran'] . ' - ' . $jadwal['kelas'],
                'start' => getNextDateForDay($jadwal['hari']),
                'backgroundColor' => '#0d6efd',
                'borderColor' => '#0d6efd',
                'extendedProps' => [
                    'jam' => formatJamIndo($jadwal['jam_mulai']) . ' - ' . formatJamIndo($jadwal['jam_selesai'])
                ]
            ];
        }
        
        // Get guru's izin
        $izin_list = $izinModel->getIzinByGuruId($guru_id);
        
        foreach ($izin_list as $izin) {
            $events[] = [
                'title' => 'Izin: ' . getJenisIzin($izin['jenis_izin']),
                'start' => $izin['tanggal_mulai'],
                'end' => date('Y-m-d', strtotime($izin['tanggal_selesai'] . ' +1 day')),
                'backgroundColor' => $izin['status_approval'] == 'approved' ? '#28a745' : '#ffc107',
                'borderColor' => $izin['status_approval'] == 'approved' ? '#28a745' : '#ffc107',
                'extendedProps' => [
                    'status' => getStatusIzin($izin['status_approval'])
                ]
            ];
        }
    }
    
    sendJSONResponse($events);
}

function getCSRFToken() {
    sendJSONResponse([
        'token' => generateCSRFToken()
    ]);
}

function getNextDateForDay($day) {
    $dayMap = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6
    ];
    
    $targetDay = $dayMap[$day];
    $currentDay = date('w');
    $daysUntilTarget = ($targetDay - $currentDay + 7) % 7;
    
    return date('Y-m-d', strtotime("+$daysUntilTarget days"));
}
?>