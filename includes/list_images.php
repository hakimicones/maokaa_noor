<?php
// includes/list_images.php — Liste les images disponibles pour le sélecteur inline

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');

if (!isLoggedIn()) {
    http_response_code(403);
    echo json_encode(['images' => []]);
    exit;
}

$dir     = __DIR__ . '/../assets/images';
$images  = [];

if (is_dir($dir)) {
    $rii = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($rii as $file) {
        if ($file->isFile() && preg_match('/\.(jpg|jpeg|png|gif|svg|webp)$/i', $file->getFilename())) {
            $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen(__DIR__ . '/../')));
            $images[] = BASE_URL . $relativePath;
        }
    }
}

sort($images);
echo json_encode(['images' => $images]);
