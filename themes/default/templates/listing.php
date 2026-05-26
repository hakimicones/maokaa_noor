<?php
require_once dirname(__DIR__, 3) . '/includes/shortcodes.php';
$slug = $page['slug'] ?? 'page';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['meta_title'] ?? $page['title'] ?? 'VEP'); ?> - VEP</title>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? ''); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo theme_url('assets/css/theme.css'); ?>" rel="stylesheet">
</head>
<body>
    <?php theme_partial('navbar'); ?>
    <main class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-6 mb-3"><?php echo htmlspecialchars($page['title'] ?? 'Liste'); ?></h1>
                    <?php if (!empty($page['subtitle'])): ?>
                    <p class="lead text-muted mb-4"><?php echo htmlspecialchars($page['subtitle']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($page['body'])): ?>
                    <div class="text-start"><?php echo do_shortcode($page['body'], $pdo); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php theme_partial('footer'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>
