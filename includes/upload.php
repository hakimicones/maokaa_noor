<?php
// includes/upload.php
// Helpers d'upload centralisés avec validation MIME côté serveur

/**
 * Valide et déplace une image uploadée.
 * Retourne ['filename' => '...'] en succès ou ['error' => '...'] en échec.
 */
function upload_image(array $file, string $uploadDir, string $prefix = 'img'): array {
    $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Erreur lors de l\'upload (code ' . $file['error'] . ')'];
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        return ['error' => 'L\'image ne doit pas dépasser 2 MB'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);

    if (!array_key_exists($mime, $allowedMimes)) {
        return ['error' => 'Format d\'image invalide (JPEG, PNG ou WebP requis)'];
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid($prefix . '_') . '.' . $allowedMimes[$mime];
    $dest     = rtrim($uploadDir, '/') . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['error' => 'Impossible d\'enregistrer l\'image'];
    }

    return ['filename' => $filename];
}

/**
 * Valide et déplace un PDF uploadé.
 * Retourne ['filename' => '...'] en succès ou ['error' => '...'] en échec.
 */
function upload_pdf(array $file, string $uploadDir, string $prefix = 'doc'): array {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Erreur lors de l\'upload (code ' . $file['error'] . ')'];
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        return ['error' => 'Le PDF ne doit pas dépasser 5 MB'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);

    if ($mime !== 'application/pdf') {
        return ['error' => 'Seuls les fichiers PDF sont acceptés'];
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid($prefix . '_') . '.pdf';
    $dest     = rtrim($uploadDir, '/') . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['error' => 'Impossible d\'enregistrer le PDF'];
    }

    return ['filename' => $filename];
}
