<?php
// includes/inline_edit_product.php — AJAX pour l'édition inline des produits

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');

if (!isLoggedIn()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

$csrf = $input['csrf_token'] ?? '';
if (!verifyCSRFToken($csrf)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide']);
    exit;
}

$productId = (int)($input['product_id'] ?? 0);
$field     = $input['field'] ?? '';
$value     = $input['value'] ?? '';

if ($productId < 1) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID produit invalide']);
    exit;
}

$allowedFields = ['nom', 'description', 'description_complete', 'caracteristiques_techniques', 'image'];
if (!in_array($field, $allowedFields, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Champ non autorisé']);
    exit;
}

if ($field === 'nom' || $field === 'image') {
    $value = htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
} else {
    $value = sanitize_body_html($value);
}

require_once __DIR__ . '/../app/models/Product.php';
$model = new Product($pdo);

try {
    $ok = $model->update($productId, [$field => $value]);
    if ($ok) {
        logAudit('inline_edit_product', "Produit #{$productId} — champ '{$field}' modifié");
        echo json_encode(['success' => true, 'message' => 'Produit mis à jour']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
