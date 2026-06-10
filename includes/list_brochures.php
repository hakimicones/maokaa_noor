<?php
// includes/list_brochures.php — Liste les fichiers PDF disponibles dans assets/brochures/

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');

if (!isLoggedIn()) {
    http_response_code(403);
    echo json_encode(['files' => []]);
    exit;
}

$dir   = __DIR__ . '/../assets/brochures';
$files = [];

if (is_dir($dir)) {
    $rii = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($rii as $file) {
        if ($file->isFile() && preg_match('/\.pdf$/i', $file->getFilename())) {
            $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen(__DIR__ . '/../')));
            $files[] = [
                'url'  => BASE_URL . $relativePath,
                'name' => $file->getFilename(),
            ];
        }
    }
}

usort($files, function ($a, $b) { return strcmp($a['name'], $b['name']); });
echo json_encode(['files' => $files]);
