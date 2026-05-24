<?php
// admin/content/preview-block.php — API pour prévisualiser les blocs VEP

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/shortcodes.php';

requirePasswordChange();

header('Content-Type: application/json');

$type = $_GET['type'] ?? '';
$limit = (int)($_GET['limit'] ?? 6);
$category = (int)($_GET['category'] ?? 0);

if (empty($type)) {
    http_response_code(400);
    echo json_encode(['error' => 'type parameter required']);
    exit;
}

ob_start();

switch ($type) {
    case 'featured-products':
        echo render_block_featured_products($pdo, $limit, 'Produits Populaires');
        break;
    case 'products':
        echo render_block_products($pdo, $limit, $category, 'Catalogue Produits');
        break;
    case 'news':
        echo render_block_news($pdo, $limit, 'Dernières Actualités');
        break;
    case 'brands':
        echo render_block_brands($pdo, 'Nos Marques');
        break;
    case 'partners':
        echo render_block_partners($pdo, 'Nos Partenaires');
        break;
    case 'contact-form':
        echo render_block_contact_form($pdo, 'Contactez-nous');
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Unknown block type']);
        exit;
}

$html = ob_get_clean();
echo json_encode(['html' => $html]);
