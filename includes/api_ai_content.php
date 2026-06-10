<?php
// includes/api_ai_content.php — API AJAX : régénération du HTML d'une page via IA (admin uniquement)

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/ai_client.php';

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
if (!verifyCSRFToken($input['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide ou expiré']);
    exit;
}

// 5. Validation des entrées
$html = (string)($input['html'] ?? '');
$instruction = trim((string)($input['instruction'] ?? ''));

if ($instruction === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Instruction requise']);
    exit;
}

if (mb_strlen($instruction) > 2000) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Instruction trop longue (2000 caractères max)']);
    exit;
}

if (mb_strlen($html) > 60000) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Contenu de la page trop volumineux pour l\'IA']);
    exit;
}

// 6. Appel au service IA
$result = ai_generate_html($html, $instruction);

if (!$result['success']) {
    http_response_code(502);
    echo json_encode(['success' => false, 'message' => $result['error']]);
    exit;
}

// 7. Nettoyage XSS (même pipeline que pour l'édition inline / l'éditeur visuel)
$cleanHtml = sanitize_body_html($result['html']);

// 8. Journal d'audit
logAudit('ai_content', 'Instruction IA : ' . mb_substr($instruction, 0, 200));

echo json_encode(['success' => true, 'html' => $cleanHtml]);
