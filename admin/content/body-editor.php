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
        .ai-modal-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.55); display: flex; align-items: center; justify-content: center; z-index: 100000; }
        .ai-modal-dialog { background: #fff; border-radius: 12px; width: 100%; max-width: 520px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); overflow: hidden; }
        .ai-modal-header { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; border-bottom: 1px solid #eee; font-weight: 600; }
        .ai-modal-close { background: none; border: none; font-size: 22px; line-height: 1; cursor: pointer; color: #888; }
        .ai-modal-body { padding: 18px; }
        .ai-modal-body label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        .ai-modal-body textarea { width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 10px; font-family: inherit; font-size: 14px; resize: vertical; box-sizing: border-box; }
        .ai-modal-status { margin-top: 10px; font-size: 13px; min-height: 18px; }
        .ai-modal-status.ai-modal-error { color: #dc3545; }
        .ai-modal-status.ai-modal-loading { color: #0d6efd; }
        .ai-modal-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 18px; border-top: 1px solid #eee; }
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
            <a href="<?php echo BASE_URL; ?>admin/dashboard.php?section=content" class="btn btn-outline-secondary">Retour à la liste</a>
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
        uploadUrl: '<?php echo BASE_URL; ?>admin/content/upload-asset.php',
        aiUrl: '<?php echo BASE_URL; ?>includes/api_ai_content.php',
        csrfToken: '<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>',
        baseUrl: '<?php echo BASE_URL; ?>'
    };
</script>
<script src="https://unpkg.com/grapesjs@0.21.9/dist/grapes.min.js"></script>
<script src="https://unpkg.com/grapesjs-plugin-export@1.0.11/dist/grapesjs-plugin-export.min.js"></script>
<script src="https://unpkg.com/grapesjs-style-bg@2.0.2/dist/grapesjs-style-bg.min.js"></script>
<script src="https://unpkg.com/grapesjs-custom-code@1.0.2/dist/grapesjs-custom-code.min.js"></script>
<script src="https://unpkg.com/dompurify@3.1.6/dist/purify.min.js"></script>
<script src="<?php echo BASE_URL; ?>admin/content/body-editor.js"></script>
</body>
</html>
