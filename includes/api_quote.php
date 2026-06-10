<?php
// includes/api_quote.php — API AJAX pour soumettre une demande de devis

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../app/models/Contact.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$nom      = trim($input['nom']      ?? '');
$email    = trim($input['email']    ?? '');
$telephone= trim($input['telephone']?? '');
$produit  = trim($input['produit']  ?? '');
$quantite = (int)($input['quantite']?? 1);
$message  = trim($input['message']  ?? '');

if (empty($nom) || empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nom et email requis.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email invalide.']);
    exit;
}

$fullMessage = "Produit : $produit\nQuantité : $quantite\n\nMessage : $message";

$model = new Contact($pdo);
$ok = $model->create([
    'nom'       => $nom,
    'email'     => $email,
    'telephone' => $telephone,
    'sujet'     => '[Demande de devis] ' . $produit,
    'message'   => $fullMessage,
]);

if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Votre demande de devis a bien été envoyée.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi.']);
}
