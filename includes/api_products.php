<?php
// includes/api_products.php — API JSON des produits pour le bloc interactif

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../app/models/Product.php';
require_once __DIR__ . '/../app/models/Category.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Max-Age: 300');

$limit    = min(9999, max(1, (int)($_GET['limit'] ?? 9999)));
$category = (int)($_GET['category'] ?? 0);
$search   = trim($_GET['search'] ?? '');
$sort     = $_GET['sort'] ?? 'popular';

$productModel  = new Product($pdo);
$categoryModel = new Category($pdo);

if ($search !== '') {
    $products = $productModel->search($search, $limit);
} elseif ($category > 0) {
    $products = $productModel->getByCategory($category, $limit);
} else {
    $products = $productModel->getAll(true, $limit);
}

usort($products, function ($a, $b) use ($sort) {
    switch ($sort) {
        case 'name-asc':
            return strcasecmp($a['nom'], $b['nom']);
        case 'name-desc':
            return strcasecmp($b['nom'], $a['nom']);
        case 'newest':
            $ta = $a['created_at'] ?? '0';
            $tb = $b['created_at'] ?? '0';
            return strtotime($tb) - strtotime($ta);
        case 'popular':
        default:
            $fa = (int)($a['featured'] ?? 0);
            $fb = (int)($b['featured'] ?? 0);
            if ($fa !== $fb) return $fb - $fa;
            return ($a['display_order'] ?? 0) - ($b['display_order'] ?? 0);
    }
});

$categories = $categoryModel->getAll(true);
$featured   = $productModel->getFeatured(4);

echo json_encode([
    'products'   => $products,
    'categories' => $categories,
    'featured'   => $featured,
]);
