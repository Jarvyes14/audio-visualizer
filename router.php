<?php

// router.php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Manejar archivos de storage
if (preg_match('/^\/storage\/(.+)$/', $uri, $matches)) {
    $file = __DIR__ . '/storage/app/public/' . $matches[1];

    if (file_exists($file) && is_file($file)) {
        $mimeType = mime_content_type($file);
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    http_response_code(404);
    echo '404 - File not found';
    exit;
}

// Si no es un archivo de storage, dejar que Laravel maneje
if (file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';
