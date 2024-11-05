<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'course_db');

// Site configuration
define('SITE_NAME', 'Khóa Học Chuyên Nghiệp');
define('SITE_URL', 'http://localhost/course-website');
define('ADMIN_EMAIL', 'admin@example.com');

// SMTP configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');

// Payment configuration
define('VNP_TMN_CODE', 'your-vnpay-tmn-code');
define('VNP_HASH_SECRET', 'your-vnpay-hash-secret');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start(); 