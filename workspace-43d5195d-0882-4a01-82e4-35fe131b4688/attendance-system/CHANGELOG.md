# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial project structure
- MVC architecture with OOP principles
- Database schema for attendance system
- Basic authentication system
- Admin and Guru dashboards
- Schedule management system
- Attendance tracking system
- Permission management system
- QR code attendance system
- Export functionality (Excel/PDF)
- Notification system
- Responsive design
- Security features (CSRF protection, input validation, etc.)

### Changed
- Nothing yet

### Deprecated
- Nothing yet

### Removed
- Nothing yet

### Fixed
- Nothing yet

### Security
- Password hashing with bcrypt
- CSRF protection
- Input sanitization
- SQL injection prevention
- XSS protection
- Session security

## [1.0.0] - 2023-12-01

### Added
- Initial release
- Complete attendance system
- Admin dashboard with statistics
- Guru dashboard with personal schedule
- Schedule management with drag & drop
- Multi-method attendance (manual, QR code, automatic)
- Permission system with approval workflow
- Export to Excel/PDF
- Real-time notifications
- Mobile responsive design
- Comprehensive security measures

### Features
- **Admin Features**:
  - Manage teacher data (add, edit, delete, deactivate)
  - Schedule management with drag & drop interface
  - Manual attendance input
  - Real-time attendance monitoring
  - Generate attendance reports (daily, weekly, monthly, semester)
  - Export data to Excel/PDF
  - Manage teacher permissions (approve/reject)
  - Monitor teachers who haven't attended according to schedule

- **Teacher Features**:
  - Login with username/NIP and password
  - View personal teaching schedule (calendar view)
  - Self-attendance (web interface or mobile)
  - View personal attendance history with filters
  - Apply for leave/permit online
  - Upload supporting documents (if required)

- **Attendance System**:
  - Self-attendance by Teacher: through web interface or mobile
  - Attendance by Admin: admin can input/edit attendance for specific teachers
  - Automatic Attendance: system marks 'Absent' if teacher doesn't attend according to schedule
  - Double validation to prevent duplicate attendance
  - Attendance change history (audit trail)

- **Attendance Status**:
  - On Time
  - Late (with late minutes note)
  - Absent
  - Permit (with permit type: official, personal, etc.)
  - Sick (with doctor's note upload)
  - Leave
  - National Holiday

- **Security & Validation**:
  - Password hashing (bcrypt)
  - Session management with timeout
  - Input validation and sanitization
  - Protection against SQL injection and XSS
  - Role-based access control
  - Audit log for all data changes

- **User Interface**:
  - Responsive design (desktop, tablet, mobile)
  - Dashboard with real-time attendance statistics
  - Calendar view for teaching schedule
  - Notification system (email/web notification)
  - Report generator with various filters
  - Import/export data

- **Additional Features**:
  - QR code attendance system
  - Geolocation validation for attendance
  - Bulk attendance input for admin
  - Automatic reminder for teachers who haven't attended
  - WhatsApp/SMS notification integration

### Technical Details
- **Backend**: PHP 7.4+ with MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (jQuery), Bootstrap 5
- **Architecture**: MVC pattern with OOP principles
- **Database**: MySQL with proper indexing and relationships
- **Security**: Comprehensive security measures implemented
- **Performance**: Optimized queries and caching where appropriate

### Database Schema
- **guru**: Teacher information (id, name, NIP, position, active_status, profile_photo)
- **jadwal_mengajar**: Teaching schedule (id, teacher_id, day, start_time, end_time, subject, class/room, semester, academic_year)
- **absensi**: Attendance records (id, teacher_id, schedule_id, date, time_in, time_out, attendance_status, notes, created_by, attendance_method)
- **pengguna**: Users (id, username, password, access_level, teacher_id)
- **izin**: Permissions (id, teacher_id, start_date, end_date, permission_type, reason, approval_status, supporting_document)

### Installation
1. Create MySQL database
2. Import database.sql
3. Configure database connection
4. Set folder permissions
5. Access through web browser

### Default Login
- **Admin**: username: admin, password: admin123
- **Teacher**: username: budi, password: password123

### Future Enhancements
- Mobile app development
- Integration with biometric devices
- Advanced reporting and analytics
- Multi-school support
- API for third-party integrations
- Cloud deployment options