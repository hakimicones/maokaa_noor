<?php
// $items = array of featured products, $blockTitle = optional heading, $pdo available
?>
<section class="py-5">
    <div class="container">
        <?php if (!empty($blockTitle)): ?>
            <h2 class="section-title"><?php echo htmlspecialchars($blockTitle); ?></h2>
        <?php else: ?>
            <h2 class="section-title">Produits populaires</h2>
        <?php endif; ?>
        <div class="grid-container">
            <?php if (!empty($items)): foreach ($items as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                    <?php else: ?>
                        <div style="width:100%;height:100%;background:var(--light-gray,#f5f5f5);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-image text-muted" style="font-size:48px;"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-body">
                    <div class="product-category"><?php echo htmlspecialchars($product['categorie_name'] ?? 'Produit'); ?></div>
                    <h4 class="product-title"><?php echo htmlspecialchars($product['nom']); ?></h4>
                    <p class="product-description"><?php
                        $desc = strip_tags($product['description'] ?? '');
                        echo htmlspecialchars(substr($desc, 0, 80)) . (strlen($desc) > 80 ? '...' : '');
                    ?></p>
                    <div class="product-actions">
                        <a href="<?php echo BASE_URL; ?>products?id=<?php echo (int)$product['id']; ?>" class="btn-read-more">Lire la suite</a>
                        <?php if (!empty($product['brochure_pdf'])): ?>
                            <a href="<?php echo htmlspecialchars($product['brochure_pdf']); ?>" target="_blank" rel="noopener" class="btn-download">
                                <i class="fas fa-download"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <p class="text-muted">Aucun produit populaire disponible.</p>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo BASE_URL; ?>products" class="btn btn-primary btn-lg">Voir tous les produits</a>
        </div>
    </div>
</section>
