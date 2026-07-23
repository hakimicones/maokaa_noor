<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

$stmt = $pdo->prepare("SELECT body FROM content WHERE slug = ?");
$stmt->execute(['about']);
$body = $stmt->fetchColumn();

echo "=== RAW BODY (first 500 chars) ===\n";
echo substr($body, 0, 500) . "\n\n";

// Replace literal PHP tags with actual BASE_URL
$body = str_replace('<?php echo BASE_URL; ?>', BASE_URL, $body);

$newHistoire = BASE_URL . 'assets/images/noor-guide/histoire.jpg';
$newTech = BASE_URL . 'assets/images/noor-guide/tech.jpg';

$oldHistoireSvg = BASE_URL . 'assets/images/noor-guide/illustration-accessibility.svg';
$oldTechSvg = BASE_URL . 'assets/images/noor-guide/illustration-autonomy.svg';

$body = str_replace($oldHistoireSvg, $newHistoire, $body);
$body = str_replace($oldTechSvg, $newTech, $body);

$stmt = $pdo->prepare("UPDATE content SET body = ? WHERE slug = ?");
$stmt->execute([$body, 'about']);

echo "=== FIXED ===\n";
echo "Replaced literal PHP tags with BASE_URL\n";
echo "Replaced SVGs with jpg photos\n\n";

// Verify
preg_match_all('/src=["\']([^"\']+)["\']/', $body, $matches);
echo "=== IMAGE SOURCES NOW ===\n";
foreach ($matches[1] as $i => $src) {
    echo ($i+1) . ". " . $src . "\n";
    $path = str_replace(BASE_URL, $_SERVER['DOCUMENT_ROOT'] . '/', $src);
    if (file_exists($path)) {
        echo "   -> FILE EXISTS\n";
    } else {
        echo "   -> FILE NOT FOUND\n";
    }
}
