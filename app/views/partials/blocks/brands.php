<?php
// $items = array of brands, $blockTitle = optional heading
?>
<section class="py-5" style="background:var(--light,#f8f9fa);">
    <div class="container">
        <?php if (!empty($blockTitle)): ?>
            <h2 class="section-title"><?php echo htmlspecialchars($blockTitle); ?></h2>
        <?php else: ?>
            <h2 class="section-title">Nos marques partenaires</h2>
        <?php endif; ?>
        <div class="row align-items-center">
            <?php if (!empty($items)): foreach ($items as $brand): ?>
                <div class="col-md-3 mb-4 text-center">
                    <?php if (!empty($brand['logo'])): ?>
                        <img src="<?php echo htmlspecialchars($brand['logo']); ?>"
                             alt="<?php echo htmlspecialchars($brand['name']); ?>"
                             style="max-height:100px;margin-bottom:15px;">
                    <?php else: ?>
                        <div style="height:100px;display:flex;align-items:center;justify-content:center;">
                            <span class="fw-semibold"><?php echo htmlspecialchars($brand['name']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; else: ?>
                <div class="col-12"><p class="text-muted text-center">Aucune marque disponible.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>
