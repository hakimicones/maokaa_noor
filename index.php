<?php
// index.php - Front Controller Principal
// Routeur centralisé pour l'application VEP

require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'app/models/Content.php';

// Résoudre le slug depuis l'URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Retirer BASE_URL de l'URI si présent
$basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?: '', '/');
$path = $uri;

if ($basePath && strpos($uri, $basePath) === 0) {
    $path = substr($uri, strlen($basePath));
}

$path = trim($path, '/');
$slug = empty($path) || $path === 'index.php' ? 'home' : basename($path, '.php');

// Normaliser et valider le slug
$slug = strtolower(preg_replace('/[^a-z0-9\-_]/', '', $slug));

// Routes spéciales
if ($slug === 'login' || $slug === 'login.php') {
    include __DIR__ . '/login.php';
    exit;
}

if (strpos($slug, 'admin') === 0) {
    if (isLoggedIn()) {
        include __DIR__ . '/admin/dashboard.php';
    } else {
        header('Location: ' . BASE_URL . 'login.php');
    }
    exit;
}

// Charger la page depuis la table content
$contentModel = new Content($pdo);
$page = $contentModel->findBySlug($slug);

if (!$page) {
    // Essayer de charger une page 404 spécifique
    $page404 = $contentModel->findBySlug('404');
    if ($page404) {
        http_response_code(404);
        $page = $page404;
    } else {
        http_response_code(404);
        include __DIR__ . '/app/views/errors/404.php';
        exit;
    }
}

// Déterminer le template à utiliser
$template = !empty($page['template']) ? $page['template'] : 'default';
$templateFile = __DIR__ . "/app/views/templates/{$template}.php";

if (!file_exists($templateFile)) {
    $templateFile = __DIR__ . '/app/views/templates/default.php';
}

// Inclure le template choisi
include $templateFile;
