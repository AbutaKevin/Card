<?php

session_start();

define('APP_URL', 'http://localhost/Card/public');
define('APP_NAME', 'State Department for Lands & Physical Planning Job Card System');

define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_USERNAME', 'bytevera2024@gmail.com');
define('MAIL_PASSWORD', 'kpym orwa julb zqqs');
define('MAIL_FROM_EMAIL', 'landsict811@gmail.com');
define('MAIL_FROM_NAME', APP_NAME);
define('MAIL_SMTP_SECURE', 'tls');
define('MAIL_PORT', 587);

define('DB_HOST', 'localhost');
define('DB_NAME', 'card_system');
define('DB_USER', 'root');
define('DB_PASS', '');

define('UPLOAD_DIR', dirname(__DIR__, 1) . '/storage/uploads');
define('QR_DIR', dirname(__DIR__, 1) . '/storage/qrcodes');
define('REPORT_DIR', dirname(__DIR__, 1) . '/storage/reports');

define('DEFAULT_ROLE', 'Viewer');

define('PASSWORD_ALGO', PASSWORD_DEFAULT);

define('SESSION_TIMEOUT', 1800); // 30 minutes

if (empty($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}

if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
    session_unset();
    session_destroy();
}

$_SESSION['last_activity'] = time();

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function auth_redirect() {
    header('Location: ' . APP_URL . '/auth/login');
    exit;
}

if (file_exists(dirname(__DIR__, 2) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
}

function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}
