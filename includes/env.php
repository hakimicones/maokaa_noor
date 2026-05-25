<?php
// includes/env.php — Charger les variables d'environnement depuis .env

function loadEnv($path = null) {
    if (!$path) {
        $path = __DIR__ . '/../.env';
    }

    if (!file_exists($path)) {
        throw new Exception(".env file not found at $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $projectRoot = __DIR__ . '/../';

    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parser la ligne KEY=VALUE
        if (strpos($line, '=') === false) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Retirer les guillemets si présents
        if (strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) {
            $value = substr($value, 1, -1);
        }

        // Construire les chemins complets pour les répertoires
        if ($key === 'UPLOAD_DIR') {
            $value = $projectRoot . $value;
        } elseif ($key === 'BROCHURE_DIR') {
            $value = $projectRoot . $value;
        } elseif ($key === 'MAX_IMAGE_SIZE' || $key === 'MAX_PDF_SIZE') {
            $value = (int)$value;
        }

        // Définir la variable d'environnement et la constante
        putenv("$key=$value");
        if (!defined($key)) {
            define($key, $value);
        }
    }
}

// Charger le fichier .env au démarrage
loadEnv();

