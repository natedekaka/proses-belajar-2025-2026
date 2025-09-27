<?php
// Simple test file to verify the system is working
require_once 'config/config.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Sistem Absensi Guru - Test</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "</head>";
echo "<body>";
echo "<div class='container mt-5'>";
echo "<div class='row justify-content-center'>";
echo "<div class='col-md-8'>";
echo "<div class='card'>";
echo "<div class='card-header text-center'>";
echo "<h3>Sistem Absensi Guru - Test Page</h3>";
echo "</div>";
echo "<div class='card-body'>";

echo "<h4>System Status:</h4>";
echo "<ul>";

// Test database connection
try {
    $database = new Database();
    $db = $database->getConnection();
    echo "<li class='text-success'>✓ Database connection: OK</li>";
} catch (Exception $e) {
    echo "<li class='text-danger'>✗ Database connection: Failed - " . $e->getMessage() . "</li>";
}

// Test models
try {
    $guruModel = new Guru();
    echo "<li class='text-success'>✓ Guru Model: OK</li>";
} catch (Exception $e) {
    echo "<li class='text-danger'>✗ Guru Model: Failed - " . $e->getMessage() . "</li>";
}

try {
    $jadwalModel = new JadwalMengajar();
    echo "<li class='text-success'>✓ Jadwal Model: OK</li>";
} catch (Exception $e) {
    echo "<li class='text-danger'>✗ Jadwal Model: Failed - " . $e->getMessage() . "</li>";
}

try {
    $absensiModel = new Absensi();
    echo "<li class='text-success'>✓ Absensi Model: OK</li>";
} catch (Exception $e) {
    echo "<li class='text-danger'>✗ Absensi Model: Failed - " . $e->getMessage() . "</li>";
}

try {
    $izinModel = new Izin();
    echo "<li class='text-success'>✓ Izin Model: OK</li>";
} catch (Exception $e) {
    echo "<li class='text-danger'>✗ Izin Model: Failed - " . $e->getMessage() . "</li>";
}

echo "</ul>";

echo "<h4>Test Data:</h4>";

// Test guru count
try {
    $guruModel = new Guru();
    $guruCount = $guruModel->getGuruCount();
    echo "<p>Total Guru: " . $guruCount . "</p>";
} catch (Exception $e) {
    echo "<p class='text-danger'>Error getting guru count: " . $e->getMessage() . "</p>";
}

// Test jadwal count
try {
    $jadwalModel = new JadwalMengajar();
    $jadwalCount = $jadwalModel->getJadwalCount();
    echo "<p>Total Jadwal: " . $jadwalCount . "</p>";
} catch (Exception $e) {
    echo "<p class='text-danger'>Error getting jadwal count: " . $e->getMessage() . "</p>";
}

// Test absensi count
try {
    $absensiModel = new Absensi();
    $absensiCount = $absensiModel->getAbsensiCount();
    echo "<p>Total Absensi: " . $absensiCount . "</p>";
} catch (Exception $e) {
    echo "<p class='text-danger'>Error getting absensi count: " . $e->getMessage() . "</p>";
}

echo "<hr>";

echo "<h4>Quick Links:</h4>";
echo "<div class='list-group'>";
echo "<a href='index.php' class='list-group-item list-group-item-action'>Go to Main Application</a>";
echo "<a href='views/auth/login.php' class='list-group-item list-group-item-action'>Login Page</a>";
echo "<a href='database.sql' class='list-group-item list-group-item-action'>Database Schema</a>";
echo "<a href='README.md' class='list-group-item list-group-item-action'>Documentation</a>";
echo "</div>";

echo "<hr>";

echo "<h4>Default Login:</h4>";
echo "<div class='alert alert-info'>";
echo "<strong>Admin:</strong> admin / admin123<br>";
echo "<strong>Guru:</strong> budi / password123";
echo "</div>";

echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</body>";
echo "</html>";
?>