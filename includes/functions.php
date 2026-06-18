<?php
// includes/functions.php
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function is_admin_logged_in() {
    return !empty($_SESSION['admin_logged_in']) && !empty($_SESSION['admin_id']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function admin_logout() {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
}

function flash_message() {
    if (!empty($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

function set_flash($message) {
    $_SESSION['flash_message'] = $message;
}

function upload_file($file, $targetDir, $allowedTypes = ['image/jpeg','image/png','image/webp','image/gif','image/svg+xml']) {
    if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if (!in_array($file['type'], $allowedTypes, true)) {
        return null;
    }
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $path = $targetDir . DIRECTORY_SEPARATOR . $filename;
    if (!move_uploaded_file($file['tmp_name'], $path)) {
        return null;
    }
    return $filename;
}

function get_setting($pdo, $key, $default = '') {
    $stmt = $pdo->prepare('SELECT value FROM settings WHERE `key` = ? LIMIT 1');
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? $row['value'] : $default;
}

function get_seo($pdo, $page) {
    $stmt = $pdo->prepare('SELECT meta_title, meta_description, meta_keywords FROM seo_settings WHERE page = ? LIMIT 1');
    $stmt->execute([$page]);
    return $stmt->fetch() ?: ['meta_title' => '', 'meta_description' => '', 'meta_keywords' => ''];
}

function get_base_url() {
    // Extract the base directory from SCRIPT_NAME
    // For /CALOGI/index.php -> /CALOGI
    // For /CALOGI/pages/about.php -> /CALOGI
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $parts = explode('/', trim($scriptName, '/'));
    if (!empty($parts) && $parts[0] !== 'index.php') {
        // Remove the filename, keep the path
        array_pop($parts);
        // If we have at least one directory, remove the last one if it's a subdirectory
        if (count($parts) > 1 && $parts[count($parts) - 1] !== $parts[0]) {
            array_pop($parts);
        }
        return '/' . implode('/', $parts);
    }
    return '/';
}

function site_url($path = '') {
    $base = get_base_url();
    if ($base === '/') {
        return '/' . ltrim($path, '/');
    }
    return $base . '/' . ltrim($path, '/');
}

function sanitize_url($url) {
    return filter_var($url, FILTER_SANITIZE_URL);
}
