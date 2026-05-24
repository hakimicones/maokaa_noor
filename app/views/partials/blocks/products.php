<?php
// $items = array of products, $blockTitle = optional heading
?>
<section class="py-5">
    <div class="container">
        <?php if (!empty($blockTitle)): ?>
            <h2 class="section-title"><?php echo htmlspecialchars($blockTitle); ?></h2>
        <?php endif; ?>
        <div class="row g-4">
            <?php if (!empty($items)): foreach ($items as $product): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                 alt="<?php echo htmlspecialchars($product['nom']); ?>"
                                 class="card-img-top" style="height:220px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <p class="text-primary fw-bold mb-1"><?php echo htmlspecialchars($product['categorie_name'] ?? 'Produit'); ?></p>
                            <h2 class="h5 fw-bold"><?php echo htmlspecialchars($product['nom']); ?></h2>
                            <p class="text-muted mb-3"><?php
                                $desc = strip_tags($product['description'] ?? '');
                                echo htmlspecialchars(substr($desc, 0, 140)) . (strlen($desc) > 140 ? '...' : '');
                            ?></p>
                            <div class="d-flex gap-2">
                                <a href="<?php echo BASE_URL; ?>products?id=<?php echo (int)$product['id']; ?>" class="btn btn-primary btn-sm">Voir le détail</a>
                                <?php if (!empty($product['brochure_pdf'])): ?>
                                    <a href="<?php echo htmlspecialchars($product['brochure_pdf']); ?>"
                                       class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener">Brochure</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="col-12"><div class="alert alert-info">Aucun produit disponible pour le moment.</div></div>
            <?php endif; ?>
        </div>
    </div>
</section>
