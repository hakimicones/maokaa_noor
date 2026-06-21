<?php
// app/views/templates/products.php
require_once __DIR__ . '/../../models/Product.php';
$productModel = new Product($pdo);

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId > 0) {
    $product = $productModel->getById($productId);
    if (!$product) {
        http_response_code(404);
        include __DIR__ . '/../errors/404.php';
        exit;
    }
    $productImages = $productModel->getImages($productId);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($productId > 0): ?>
        <title><?php echo htmlspecialchars($product['nom']); ?> - VEP</title>
        <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($product['description'] ?? ''), 0, 160)); ?>">
    <?php else: ?>
        <title><?php echo htmlspecialchars($page['meta_title'] ?? $page['title'] ?? 'Produits - VEP'); ?> - VEP</title>
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

        <?php if ($productId > 0): ?>
            <!-- Vue détail produit -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>products">Produits</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['nom']); ?></li>
                </ol>
            </nav>

            <div class="row g-5">
                <div class="col-lg-5">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                             alt="<?php echo htmlspecialchars($product['nom']); ?>"
                             class="img-fluid rounded shadow-sm w-100"
                             style="max-height: 400px; object-fit: contain;"
                             <?php if ($isAdmin): ?>data-product-img data-product-id="<?php echo $product['id']; ?>"<?php endif; ?>>
                    <?php else: ?>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <i class="fas fa-image text-muted fa-5x"></i>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($productImages)): ?>
                        <div class="d-flex gap-2 mt-3 flex-wrap">
                            <?php foreach ($productImages as $img): ?>
                                <img src="<?php echo htmlspecialchars($img['image']); ?>"
                                     alt="<?php echo htmlspecialchars($img['alt_text'] ?? ''); ?>"
                                     class="img-thumbnail"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-7">
                    <?php if (!empty($product['categorie_name'])): ?>
                        <p class="text-primary fw-bold mb-1 text-uppercase small"><?php echo htmlspecialchars($product['categorie_name']); ?></p>
                    <?php endif; ?>
                    <h1 class="h2 fw-bold mb-2"><?php echo htmlspecialchars($product['nom']); ?></h1>

                    <?php if (!empty($product['marque_name'])): ?>
                        <p class="text-muted mb-3">Marque : <strong><?php echo htmlspecialchars($product['marque_name']); ?></strong></p>
                    <?php endif; ?>

                    <?php if (!empty($product['description'])): ?>
                        <p class="lead mb-4"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    <?php endif; ?>

                    <div class="d-flex gap-3 mt-4 flex-wrap">
                        <?php if (!empty($product['brochure_pdf'])): ?>
                            <a href="<?php echo htmlspecialchars($product['brochure_pdf']); ?>"
                               class="btn btn-primary" target="_blank" rel="noopener">
                                <i class="fas fa-download me-2"></i>Télécharger la brochure
                            </a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quoteModal"
                                data-quote-id="<?php echo $product['id']; ?>"
                                data-quote-nom="<?php echo htmlspecialchars($product['nom'], ENT_QUOTES); ?>">
                            <i class="fas fa-file-invoice me-2"></i>Demander un devis
                        </button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="<?php echo BASE_URL; ?>products" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour au catalogue
                </a>
            </div>

        <?php else: ?>
            <!-- Vue liste produits (contenu dynamique depuis body) -->
            <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                <div class="text-center mb-4">
                    <a href="<?php echo BASE_URL; ?>admin/dashboard.php?section=products" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-cogs me-1"></i>G&eacute;rer les Produits
                    </a>
                </div>
            <?php endif; ?>
            <div class="text-center mb-5">
                <h1 class="display-6 mb-3 products"><?php echo htmlspecialchars($page['title'] ?? 'Produits'); ?></h1>
            </div>
            <?php
            require_once __DIR__ . '/../../../includes/shortcodes.php';
            echo process_vep_blocks($page['body'] ?? '', $pdo);
            ?>
        <?php endif; ?>

        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
    <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
    <script src="<?php echo BASE_URL; ?>assets/js/inline-edit.js"></script>
    <?php endif; ?>

    <?php include __DIR__ . '/../partials/blocks/quote-form.php'; ?>

    <script>
    (function() {
        var modalEl = document.getElementById('quoteModal');
        if (!modalEl) return;
        modalEl.addEventListener('show.bs.modal', function (e) {
            var btn = e.relatedTarget;
            if (!btn) return;
            var id  = btn.getAttribute('data-quote-id');
            var nom = btn.getAttribute('data-quote-nom');
            document.getElementById('quote-produit-id').value  = id || '';
            document.getElementById('quote-produit-nom').value = nom || '';
        });
    })();
    </script>
</body>
</html>
