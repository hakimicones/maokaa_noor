<?php
// includes/inline_edit.php — Handler AJAX pour l'édition inline frontend (admin uniquement)

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');

// 1. Sécurité : session admin requise
if (!isLoggedIn()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit;
}

// 2. Méthode POST uniquement
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// 3. Lire et décoder le corps JSON
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

// 4. Vérification du token CSRF
$csrf = $input['csrf_token'] ?? '';
if (!verifyCSRFToken($csrf)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide ou expiré']);
    exit;
}

// 5. Valider et assainir le slug
$slug = preg_replace('/[^a-z0-9\-_]/', '', strtolower($input['slug'] ?? ''));
if (empty($slug)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Slug invalide']);
    exit;
}

// 6. Whitelist stricte des champs autorisés
$allowed_fields = ['title', 'subtitle', 'body'];
$field = $input['field'] ?? '';
if (!in_array($field, $allowed_fields, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Champ non autorisé']);
    exit;
}

$value = $input['value'] ?? '';

// 7. Nettoyage XSS selon le type de champ
if ($field === 'body') {
    // Autoriser HTML balisé mais supprimer scripts, handlers d'événements, etc.
    $value = sanitize_body_html($value);
} else {
    // Champs texte simples : aucun HTML accepté
    $value = htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
}

try {
    // 8. Vérifier que la page existe
    $check = $pdo->prepare("SELECT id FROM content WHERE slug = ?");
    $check->execute([$slug]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Page introuvable']);
        exit;
    }

    // 9. Mise à jour sécurisée par requête préparée PDO
    // Le nom de colonne est interpolé après whitelist stricte — la valeur est paramétrée
    $stmt = $pdo->prepare("UPDATE content SET {$field} = ? WHERE slug = ?");
    $stmt->execute([$value, $slug]);

    // 10. Journal d'audit
    logAudit('inline_edit', "Champ '{$field}' modifié sur la page '{$slug}'");

    echo json_encode(['success' => true, 'message' => 'Modification enregistrée']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
