<?php
require_once __DIR__ . '/captcha.php';
$data = initCaptcha();
header('Content-Type: image/svg+xml; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
// Passer le token via un cookie ou le retourner dans l'en-tête
// On utilise un header personnalisé + fallback query string
if (!headers_sent()) {
    setcookie('captcha_token', $data['token'], 0, '/', '', false, true);
}
echo $data['svg'];
