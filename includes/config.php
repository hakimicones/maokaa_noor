<?php


// Charger les variables d'environnement depuis .env
require_once __DIR__ . '/env.php';

/**
 * Retourne l'URL de retour prioritaire : return_url GET > Referer > défaut.
 */
function return_url(string $default = ''): string {
    if (!empty($_GET['return_url'])) return $_GET['return_url'];
    if (!empty($_SERVER['HTTP_REFERER'])) return $_SERVER['HTTP_REFERER'];
    return $default;
}
