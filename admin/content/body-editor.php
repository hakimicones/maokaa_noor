<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../app/models/Content.php';

requirePasswordChange();

$model = new Content($pdo);
$pageId = (int)($_GET['id'] ?? 0);
$page = $model->findById($pageId);

if (!$page) {
    http_response_code(404);
    echo '<h1>Page introuvable</h1>';
    exit;
}

$editorId = 'contentBodyEditor';
$initialBody = $page['body'] ?? '';
$saveMessage = '';
$saveType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $saveMessage = 'Token de sécurité invalide';
        $saveType = 'danger';
    } else {
        $body = sanitize_body_html($_POST['body'] ?? '');
        $updated = $model->update($pageId, [
            'slug' => $page['slug'],
            'title' => $page['title'],
            'subtitle' => $page['subtitle'] ?? '',
            'meta_title' => $page['meta_title'] ?? '',
            'meta_description' => $page['meta_description'] ?? '',
            'body' => $body,
            'template' => $page['template'] ?? 'default',
            'status' => $page['status'] ?? 'draft',
            'language' => $page['language'] ?? 'fr'
        ]);

        if ($updated) {
            $saveMessage = 'Contenu enregistré dans MySQL.';
            $saveType = 'success';
            $initialBody = $body;
            $page['body'] = $body;
        } else {
            $saveMessage = 'Échec de la sauvegarde du contenu.';
            $saveType = 'danger';
        }
    }
}

$csrfToken = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title']); ?> - Éditeur visuel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/grapesjs@0.21.9/dist/css/grapes.min.css">
    <style>
        body { background: #f4f6f8; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .editor-shell { padding: 24px; min-height: 100vh; }
        .editor-topbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; }
        .editor-card { background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); }
        .editor-toolbar { display: flex; justify-content: flex-end; gap: 10px; margin-top: 16px; }
    </style>
</head>
<body>
<div class="editor-shell">
    <div class="editor-topbar">
        <div>
             
            <h1 class="h3 mb-1"><?php echo htmlspecialchars($page['title']); ?></h1>
            
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?php echo BASE_URL; ?>admin/content/edit.php?id=<?php echo (int)$pageId; ?>" class="btn btn-outline-secondary">Modifier les métadonnées</a>
            <a href="<?php echo BASE_URL; ?>admin/content/index.php" class="btn btn-outline-secondary">Retour à la liste</a>
        </div>
    </div>

    <?php if (!empty($saveMessage)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($saveType); ?>" role="alert">
            <?php echo htmlspecialchars($saveMessage); ?>
        </div>
    <?php endif; ?>

    <div class="editor-card" style="padding: 0;
">
        <form method="POST" id="bodyEditorForm">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <div class="mb-3">
                 
              
                <div class="border rounded overflow-hidden bg-white">
                    <div id="<?php echo htmlspecialchars($editorId); ?>" style="min-height: 760px;"></div>
                </div>
            </div>

            <input type="hidden" name="body" id="body-html" value="<?php echo htmlspecialchars($initialBody, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="editor-toolbar">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
              <p class="text-muted small mb-3">Glissez des blocs, éditez le contenu puis cliquez sur <strong>Enregistrer dans MySQL</strong>.</p>
        </form>
    </div>
</div>

<script>
    <?php
    $imagesDir = __DIR__ . '/../../assets/images';
    $assetImages = [];
    if (is_dir($imagesDir)) {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($imagesDir, FilesystemIterator::SKIP_DOTS));
        foreach ($rii as $file) {
            if ($file->isFile() && preg_match('/\.(jpg|jpeg|png|gif|svg|webp)$/i', $file->getFilename())) {
                $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen(__DIR__ . '/../../')));
                $assetImages[] = BASE_URL . $relativePath;
            }
        }
    }
    ?>
    window.__contentEditorConfig = {
        editorContainerId: '<?php echo htmlspecialchars($editorId); ?>',
        hiddenInputId: 'body-html',
        initialBody: <?php echo json_encode($initialBody); ?>,
        assets: <?php echo json_encode($assetImages); ?>,
        uploadUrl: '<?php echo BASE_URL; ?>admin/content/upload-asset.php'
    };
</script>
<script src="https://unpkg.com/grapesjs@0.21.9/dist/grapes.min.js"></script>
<script src="https://unpkg.com/dompurify@3.1.6/dist/purify.min.js"></script>
<script src="<?php echo BASE_URL; ?>admin/content/body-editor.js"></script>
</body>
</html>
