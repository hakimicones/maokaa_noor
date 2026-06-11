<?php
// app/views/templates/listing.php
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <main class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    
                     
                    <?php if (!empty($page['subtitle'])): ?>
                        <p class="lead text-muted mb-4"><?php echo htmlspecialchars($page['subtitle']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($page['body'])): ?>
                        <div class="text-start"><?php echo $page['body']; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($slug === 'brands'): ?>
                <?php require_once __DIR__ . '/../../models/Brand.php'; ?>
                <?php $brandModel = new Brand($pdo); $items = $brandModel->getAll(); ?>
                <div class="row g-4">
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body text-center">
                                    <?php if (!empty($item['logo'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['logo']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid mb-3" style="max-height: 90px;">
                                    <?php endif; ?>
                                    <h3 class="h5 fw-bold"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="text-muted mb-3"><?php echo htmlspecialchars($item['description'] ?? ''); ?></p>
                                    <?php if (!empty($item['website'])): ?>
                                        <a href="<?php echo htmlspecialchars($item['website']); ?>" class="btn btn-outline-primary btn-sm" target="_blank" rel="noreferrer">Site web</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($slug === 'partners'): ?>
                <?php require_once __DIR__ . '/../../models/Partner.php'; ?>
                <?php $partnerModel = new Partner($pdo); $items = $partnerModel->getAll(); ?>
                <div class="row g-4">
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body text-center">
                                    <?php if (!empty($item['logo'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['logo']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="img-fluid mb-3" style="max-height: 90px;">
                                    <?php endif; ?>
                                    <h3 class="h5 fw-bold"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="text-muted mb-3"><?php echo htmlspecialchars($item['description'] ?? ''); ?></p>
                                    <?php if (!empty($item['website'])): ?>
                                        <a href="<?php echo htmlspecialchars($item['website']); ?>" class="btn btn-outline-primary btn-sm" target="_blank" rel="noreferrer">Site web</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Aucune liste dynamique n'est disponible pour cette page.</div>
            <?php endif; ?>
        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
</body>
</html>
