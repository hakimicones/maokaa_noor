<?php $isAdmin = isLoggedIn(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['meta_title'] ?? $page['title'] ?? 'VEP'); ?> - VEP</title>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? ''); ?>">

    <?php if ($isAdmin): ?>
    <!-- Inline edit : métadonnées pour le JS -->
    <meta name="csrf-token" content="<?php echo htmlspecialchars(generateCSRFToken()); ?>">
    <meta name="page-slug"  content="<?php echo htmlspecialchars($page['slug'] ?? ''); ?>">
    <meta name="base-url"   content="<?php echo htmlspecialchars(BASE_URL); ?>">
    <?php endif; ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Splide -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

    <!-- Custom CSS -->
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">

    <?php if ($isAdmin): ?>
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/inline-edit.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body>
    <!-- Navigation -->
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <!-- Main Content -->
    <main>
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-6 mb-3 default"
                        <?php if ($isAdmin): ?>data-inline-field="title"<?php endif; ?>>
                      
                    </h1>

                    <?php if (!empty($page['subtitle'])): ?>
                        <p class="lead text-muted mb-4"
                           <?php if ($isAdmin): ?>data-inline-field="subtitle"<?php endif; ?>>
                            <?php echo htmlspecialchars($page['subtitle']); ?>
                        </p>
                    <?php endif; ?>

                    <div class="page-content"
                         <?php if ($isAdmin): ?>data-inline-field="body"<?php endif; ?>>
                        <?php
                        require_once __DIR__ . '/../../../includes/shortcodes.php';
                        echo process_vep_blocks($page['body'] ?? '', $pdo);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <!-- Custom JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

    <?php if ($isAdmin): ?>
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/inline-edit.js"></script>
    <?php endif; ?>
</body>
</html>
