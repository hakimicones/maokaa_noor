<?php
// app/views/templates/news.php
require_once __DIR__ . '/../../../includes/shortcodes.php';

// Detail view: ?id=X
$newsId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($newsId > 0) {
    require_once __DIR__ . '/../../models/News.php';
    $newsModel = new News($pdo);
    $article = $newsModel->getById($newsId);
    if (!$article || $article['status'] !== 'published') {
        http_response_code(404);
        include __DIR__ . '/../errors/404.php';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($newsId > 0): ?>
        <title><?php echo htmlspecialchars($article['title']); ?> - VEP</title>
        <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($article['content'] ?? ''), 0, 160)); ?>">
    <?php else: ?>
        <title><?php echo htmlspecialchars($page['meta_title'] ?? $page['title'] ?? 'Actualités - VEP'); ?> - VEP</title>
        <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? ''); ?>">
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <main class="py-5">
        <div class="container">

        <?php if ($newsId > 0): ?>
            <!-- Vue détail article -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>news">Actualités</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($article['title']); ?></li>
                </ol>
            </nav>

            <?php if (!empty($article['image'])): ?>
                <img src="<?php echo htmlspecialchars($article['image']); ?>"
                     alt="<?php echo htmlspecialchars($article['title']); ?>"
                     class="img-fluid rounded mb-4 w-100" style="max-height:400px;object-fit:cover;">
            <?php endif; ?>

            <p class="text-muted small"><?php echo date('d/m/Y', strtotime($article['published_at'] ?? date('Y-m-d'))); ?></p>
            <h1 class="h2 fw-bold mb-4"><?php echo htmlspecialchars($article['title']); ?></h1>
            <div class="article-content">
                <?php echo $article['content'] ?? ''; ?>
            </div>

            <div class="mt-5">
                <a href="<?php echo BASE_URL; ?>news" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour aux actualités
                </a>
            </div>

        <?php else: ?>
            <!-- Vue liste actualités (contenu dynamique depuis body) -->
            <div class="text-center mb-5">
                <h1 class="display-6 mb-3"><?php echo htmlspecialchars($page['title'] ?? 'Actualités'); ?></h1>
                <?php if (!empty($page['subtitle'])): ?>
                    <p class="lead text-muted"><?php echo htmlspecialchars($page['subtitle']); ?></p>
                <?php endif; ?>
            </div>
            <?php echo process_vep_blocks($page['body'] ?? '', $pdo); ?>
        <?php endif; ?>

        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>
