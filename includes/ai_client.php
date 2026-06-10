<?php
// includes/ai_client.php — Client HTTP pour API compatible OpenAI (Chat Completions)

/**
 * Demande à l'IA de transformer le HTML d'une page selon une instruction.
 *
 * @return array{success: bool, html?: string, error?: string}
 */
function ai_generate_html(string $currentHtml, string $instruction): array {
    $apiUrl = rtrim((string)(getenv('AI_API_URL') ?: ''), '/');
    $apiKey = (string)(getenv('AI_API_KEY') ?: '');
    $model  = (string)(getenv('AI_MODEL') ?: '');
    $maxTokens = (int)(getenv('AI_MAX_TOKENS') ?: 4096);

    if ($apiUrl === '' || $apiKey === '' || $model === '') {
        return ['success' => false, 'error' => "Service IA non configuré (vérifiez AI_API_URL, AI_API_KEY et AI_MODEL dans .env)."];
    }

    $systemPrompt = "Tu es un assistant d'édition de contenu pour un site web Bootstrap 5 "
        . "(CMS de la société VEP, Algérie, distribution de matériel de laboratoire). "
        . "Tu reçois le HTML actuel du contenu d'une page et une instruction de l'administrateur. "
        . "Réponds UNIQUEMENT avec le nouveau code HTML complet du contenu (un fragment), "
        . "sans balises <html>, <head> ou <body>, sans bloc de code markdown (pas de ```), "
        . "et sans aucune explication. "
        . "Conserve tels quels les éventuels shortcodes entre crochets présents dans le HTML "
        . "(par exemple [carousel ...], [products ...], [featured_products ...], [brands], "
        . "[partners], [contact_form], [news ...]) car ils correspondent à des blocs dynamiques "
        . "générés depuis la base de données. "
        . "Utilise des classes Bootstrap 5 pour la structure et la mise en page.";

    $payload = [
        'model' => $model,
        'messages' => [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => "HTML actuel :\n" . $currentHtml . "\n\nInstruction :\n" . $instruction],
        ],
        'max_tokens' => $maxTokens,
        'temperature' => 0.7,
    ];

    $ch = curl_init($apiUrl . '/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_TIMEOUT => 60,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        return ['success' => false, 'error' => "Erreur de connexion au service IA : $curlError"];
    }

    $data = json_decode($response, true);

    if ($httpCode < 200 || $httpCode >= 300 || !isset($data['choices'][0]['message']['content'])) {
        $msg = $data['error']['message'] ?? "Réponse invalide du service IA (HTTP $httpCode)";
        return ['success' => false, 'error' => $msg];
    }

    $html = trim((string)$data['choices'][0]['message']['content']);

    // Retirer un éventuel bloc de code markdown ```html ... ```
    $html = preg_replace('/^```(?:html)?\s*|\s*```$/i', '', $html);

    return ['success' => true, 'html' => trim($html)];
}
