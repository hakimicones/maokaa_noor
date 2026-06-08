<?php
// app/views/templates/home.php
require_once __DIR__ . '/../../../includes/shortcodes.php';
$isAdmin = isLoggedIn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['meta_title'] ?? 'Accueil - VEP'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description'] ?? 'VEP - Votre partenaire incontournable du laboratoire en Algérie'); ?>">

    <?php if ($isAdmin): ?>
    <!-- Inline edit : métadonnées pour le JS -->
    <meta name="csrf-token" content="<?php echo htmlspecialchars(generateCSRFToken()); ?>">
    <meta name="page-slug"  content="<?php echo htmlspecialchars($page['slug'] ?? 'home'); ?>">
    <meta name="base-url"   content="<?php echo htmlspecialchars(BASE_URL); ?>">
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">

    <?php if ($isAdmin): ?>
    <link href="<?php echo BASE_URL; ?>assets/css/inline-edit.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <main<?php if ($isAdmin): ?> data-inline-field="body"<?php endif; ?>>
        <?php echo process_vep_blocks($page['body'] ?? '', $pdo); ?>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>

    <?php if ($isAdmin): ?>
    <script src="<?php echo BASE_URL; ?>assets/js/inline-edit.js"></script>
    <?php endif; ?>
</body>
</html>
