<?php
// admin/content/preview-block.php — API de prévisualisation des blocs/shortcodes

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/shortcodes.php';

requirePasswordChange();

header('Content-Type: application/json');

$type      = $_GET['type'] ?? '';
$limit     = max(1, (int)($_GET['limit']      ?? 6));
$category  = (int)($_GET['category']  ?? 0);
$slider_id = (int)($_GET['slider_id'] ?? 0);

if (empty($type)) {
    http_response_code(400);
    echo json_encode(['error' => 'type parameter required']);
    exit;
}

// Normaliser : accepte tirets ou underscores (featured-products = featured_products)
$tag = strtolower(str_replace('-', '_', $type));

$atts = ['limit' => (string)$limit, 'category' => (string)$category, 'slider_id' => (string)$slider_id];
$html = render_shortcode($tag, $atts, $pdo);

if ($html === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Unknown block type: ' . $type]);
    exit;
}

echo json_encode(['html' => $html]);
