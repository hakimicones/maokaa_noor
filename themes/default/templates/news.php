<?php
require_once dirname(__DIR__, 3) . '/includes/shortcodes.php';

$newsId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($newsId > 0) {
    require_once dirname(__DIR__, 3) . '/app/models/News.php';
    $newsModel = new News($pdo);
    $article   = $newsModel->getById($newsId);
    if (!$article || $article['status'] !== 'published') {
        http_response_code(404);
        include dirname(__DIR__, 3) . '/app/views/errors/404.php';
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
    <title><?php echo htmlspecialchars($page['meta_title'] ?? $page['title'] ?? 'Actualités'); ?> - VEP</title>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? ''); ?>">
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo theme_url('assets/css/theme.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
</head>
<body>
    <?php theme_partial('navbar'); ?>
    <main class="py-5">
        <div class="container">
        <?php if ($newsId > 0): ?>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>news">Actualités</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($article['title']); ?></li>
                </ol>
            </nav>
            <?php if (!empty($article['image'])): ?>
            <img src="<?php echo htmlspecialchars($article['image']); ?>"
                 alt="<?php echo htmlspecialchars($article['title']); ?>"
                 class="img-fluid rounded mb-4 w-100" style="max-height:400px;object-fit:cover;">
            <?php endif; ?>
            <p class="text-muted small"><?php echo date('d/m/Y', strtotime($article['published_at'] ?? 'now')); ?></p>
            <h1 class="h2 fw-bold mb-4"><?php echo htmlspecialchars($article['title']); ?></h1>
            <div class="article-content"><?php echo $article['content'] ?? ''; ?></div>
            <div class="mt-5">
                <a href="<?php echo BASE_URL; ?>news" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour aux actualités
                </a>
            </div>
        <?php else: ?>
            <div class="text-center mb-5">
                
                <?php if (!empty($page['subtitle'])): ?>
                <p class="lead text-muted"><?php echo htmlspecialchars($page['subtitle']); ?></p>
                <?php endif; ?>
            </div>
            <?php echo do_shortcode($page['body'] ?? '', $pdo); ?>
        <?php endif; ?>
        </div>
    </main>
    <?php theme_partial('footer'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.splide:not(.is-initialized)').forEach(function (el) {
            if (el.classList.contains('brands-carousel')) {
                new Splide(el, {
                    type: 'loop', perPage: 5, perMove: 1, autoplay: true,
                    interval: 3000, pauseOnHover: true, gap: '24px',
                    breakpoints: { 992: { perPage: 3 }, 576: { perPage: 2 } },
                    pagination: false, arrows: true
                }).mount();
            } else {
                new Splide(el, {
                    type: 'fade', autoplay: true, interval: 4000,
                    pauseOnHover: true, rewind: true, cover: true, heightRatio: 0.4
                }).mount();
            }
        });
    });
    </script>
</body>
</html>
