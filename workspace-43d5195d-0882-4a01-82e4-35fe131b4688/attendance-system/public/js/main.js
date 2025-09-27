// Custom JavaScript for Sistem Absensi Guru

// Document Ready
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
    
    // Confirm delete actions
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = $(this).attr('href');
        }
    });
    
    // File upload preview
    $('.file-upload').on('change', function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            $('.file-preview').attr('src', e.target.result);
        }
        
        if (file) {
            reader.readAsDataURL(file);
        }
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        var isValid = true;
        var form = $(this);
        
        // Check required fields
        form.find('[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Harap lengkapi semua field yang diperlukan');
        }
    });
    
    // Clear form validation on input
    $('.form-control').on('input', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Password strength checker
    $('#password').on('input', function() {
        var password = $(this).val();
        var strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        
        var strengthText = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
        var strengthColor = ['#dc3545', '#fd7e14', '#ffc107', '#198754', '#0d6efd'];
        
        $('#password-strength').text(strengthText[strength - 1] || '');
        $('#password-strength').css('color', strengthColor[strength - 1] || '#000');
    });
    
    // Confirm password match
    $('#confirm_password').on('input', function() {
        var password = $('#password').val();
        var confirm_password = $(this).val();
        
        if (password !== confirm_password) {
            $(this).addClass('is-invalid');
            $('#password-match').text('Password tidak cocok');
        } else {
            $(this).removeClass('is-invalid');
            $('#password-match').text('Password cocok');
        }
    });
    
    // Date range picker
    if ($('.date-range').length > 0) {
        $('.date-range').flatpickr({
            mode: 'range',
            dateFormat: 'Y-m-d',
            locale: 'id'
        });
    }
    
    // Time picker
    if ($('.time-picker').length > 0) {
        $('.time-picker').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true
        });
    }
    
    // Initialize charts
    if ($('#attendanceChart').length > 0) {
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hadir', 'Terlambat', 'Tidak Hadir', 'Izin', 'Sakit'],
                datasets: [{
                    label: 'Jumlah Guru',
                    data: [12, 3, 2, 5, 1],
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
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    // Initialize calendar
    if ($('#calendar').length > 0) {
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/api/calendar-events'
        });
        calendar.render();
    }
    
    // QR Code Scanner
    if ($('#qr-scanner').length > 0) {
        const scanner = new Html5QrcodeScanner('qr-scanner', {
            qrbox: {
                width: 250,
                height: 250
            },
            fps: 20
        });
        
        scanner.render(onScanSuccess, onScanError);
        
        function onScanSuccess(decodedText, decodedResult) {
            // Handle the scanned code
            $.ajax({
                url: '/absensi/qr-check-in',
                method: 'POST',
                data: {
                    qr_data: decodedText,
                    csrf_token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert('Absensi berhasil!');
                        window.location.reload();
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
            // Handle scan error
            console.log(errorMessage);
        }
    }
    
    // Auto refresh dashboard
    if ($('.auto-refresh').length > 0) {
        setInterval(function() {
            $.ajax({
                url: '/api/dashboard-stats',
                method: 'GET',
                success: function(data) {
                    // Update dashboard stats
                    $('#total-guru').text(data.total_guru);
                    $('#total-jadwal').text(data.total_jadwal);
                    $('#total-absensi').text(data.total_absensi);
                    $('#pending-izin').text(data.pending_izin);
                }
            });
        }, 30000); // Refresh every 30 seconds
    }
    
    // Drag and drop jadwal
    if ($('.jadwal-draggable').length > 0) {
        $('.jadwal-draggable').draggable({
            revert: 'invalid',
            zIndex: 1000,
            start: function(event, ui) {
                ui.helper.css('z-index', 1000);
            }
        });
        
        $('.jadwal-droppable').droppable({
            accept: '.jadwal-draggable',
            drop: function(event, ui) {
                var jadwalId = ui.draggable.data('jadwal-id');
                var targetHari = $(this).data('hari');
                var targetJam = $(this).data('jam');
                
                $.ajax({
                    url: '/jadwal/drag-drop',
                    method: 'POST',
                    data: {
                        jadwal_id: jadwalId,
                        hari: targetHari,
                        jam_mulai: targetJam,
                        csrf_token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Jadwal berhasil diperbarui');
                            window.location.reload();
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan');
                    }
                });
            }
        });
    }
    
    // Print functionality
    $('.btn-print').on('click', function() {
        window.print();
    });
    
    // Export functionality
    $('.btn-export').on('click', function(e) {
        e.preventDefault();
        var format = $(this).data('format');
        var url = $(this).attr('href') + '&format=' + format;
        window.location.href = url;
    });
    
    // Search functionality
    $('#search-input').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#search-table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    // Filter functionality
    $('.filter-select').on('change', function() {
        var filter = $(this).val();
        var table = $('#filter-table');
        
        if (filter === 'all') {
            table.find('tbody tr').show();
        } else {
            table.find('tbody tr').hide();
            table.find('tbody tr[data-status="' + filter + '"]').show();
        }
    });
    
    // Pagination
    $('.pagination .page-link').on('click', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        var url = window.location.pathname + '?page=' + page;
        window.location.href = url;
    });
    
    // Modal confirmation
    $('.modal-confirm').on('click', function() {
        var modalId = $(this).data('modal');
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    });
    
    // Loading state
    $('.btn-loading').on('click', function() {
        var btn = $(this);
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        
        setTimeout(function() {
            btn.prop('disabled', false);
            btn.html(btn.data('original-text'));
        }, 2000);
    });
    
    // Store original button text
    $('.btn-loading').each(function() {
        $(this).data('original-text', $(this).html());
    });
    
    // Notification bell animation
    $('.notification-bell').on('click', function() {
        $(this).addClass('animate-bell');
        setTimeout(function() {
            $('.notification-bell').removeClass('animate-bell');
        }, 1000);
    });
    
    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    
    $('.back-to-top').on('click', function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
});

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatTime(time) {
    return new Date('1970-01-01T' + time + 'Z').toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

function showNotification(message, type = 'info') {
    var alertClass = {
        'success': 'alert-success',
        'error': 'alert-danger',
        'warning': 'alert-warning',
        'info': 'alert-info'
    };
    
    var alert = $('<div class="alert ' + alertClass[type] + ' alert-dismissible fade show" role="alert">')
        .html(message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>');
    
    $('.notification-container').prepend(alert);
    
    setTimeout(function() {
        alert.fadeOut();
    }, 5000);
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

function loadingStart(element) {
    element.prop('disabled', true);
    element.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
}

function loadingEnd(element, originalText) {
    element.prop('disabled', false);
    element.html(originalText);
}

// AJAX setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Global error handler
$(document).ajaxError(function(event, jqXHR, settings, thrownError) {
    if (jqXHR.status === 401) {
        window.location.href = '/auth/login';
    } else if (jqXHR.status === 403) {
        showNotification('Anda tidak memiliki akses', 'error');
    } else if (jqXHR.status === 404) {
        showNotification('Data tidak ditemukan', 'error');
    } else if (jqXHR.status === 500) {
        showNotification('Terjadi kesalahan server', 'error');
    } else {
        showNotification('Terjadi kesalahan', 'error');
    }
});

// CSRF token refresh
function refreshCSRFToken() {
    $.get('/api/csrf-token', function(data) {
        $('meta[name="csrf-token"]').attr('content', data.token);
        $('input[name="csrf_token"]').val(data.token);
    });
}

// Refresh CSRF token every hour
setInterval(refreshCSRFToken, 3600000);

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
        e.preventDefault();
        $('form').first().submit();
    }
    
    // ESC to close modal
    if (e.keyCode === 27) {
        $('.modal').modal('hide');
    }
});

// Dark mode toggle
$('#dark-mode-toggle').on('change', function() {
    if ($(this).is(':checked')) {
        $('body').addClass('dark-mode');
        localStorage.setItem('darkMode', 'true');
    } else {
        $('body').removeClass('dark-mode');
        localStorage.setItem('darkMode', 'false');
    }
});

// Check for saved dark mode preference
if (localStorage.getItem('darkMode') === 'true') {
    $('body').addClass('dark-mode');
    $('#dark-mode-toggle').prop('checked', true);
}

// Responsive sidebar toggle
$('.sidebar-toggle').on('click', function() {
    $('.sidebar').toggleClass('sidebar-collapsed');
    $('.main-content').toggleClass('main-content-expanded');
});

// Initialize tooltips on dynamically added elements
$(document).on('mouseover', '[data-bs-toggle="tooltip"]', function() {
    var tooltip = new bootstrap.Tooltip($(this));
});

// Initialize popovers on dynamically added elements
$(document).on('mouseover', '[data-bs-toggle="popover"]', function() {
    var popover = new bootstrap.Popover($(this));
});