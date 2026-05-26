<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/auth.php';

requirePasswordChange();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$uploadDir = __DIR__ . '/../../assets/images/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
$file = $_FILES['file'] ?? null;

if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Fichier invalide']);
    exit;
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    http_response_code(400);
    echo json_encode(['error' => 'Type de fichier non autorisé']);
    exit;
}

$filename = uniqid('img_', true) . '.' . $ext;
$destination = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    http_response_code(500);
    echo json_encode(['error' => 'Échec du téléversement']);
    exit;
}

$url = BASE_URL . 'assets/images/uploads/' . $filename;
echo json_encode(['data' => [['src' => $url, 'name' => $filename]]]);
