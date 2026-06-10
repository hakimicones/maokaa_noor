<?php
// $items = array of partners, $blockTitle = optional heading
?>
<section class="py-5">
    <div class="container">
        <?php if (!empty($blockTitle)): ?>
            <h2 class="section-title"><?php echo htmlspecialchars($blockTitle); ?></h2>
        <?php else: ?>
            <h2 class="section-title">Nos partenaires</h2>
        <?php endif; ?>
        <div class="row">
            <?php if (!empty($items)): foreach ($items as $partner): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if (!empty($partner['logo'])): ?>
                            <img src="<?php echo htmlspecialchars(BASE_URL . $partner['logo']); ?>"
                                 alt="<?php echo htmlspecialchars($partner['name']); ?>"
                                 class="card-img-top" style="height:200px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($partner['name']); ?></h5>
                            <?php if (!empty($partner['description'])): ?>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($partner['description']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($partner['website'])): ?>
                                <a href="<?php echo htmlspecialchars($partner['website']); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">Visiter le site</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="col-12"><p class="text-muted text-center">Aucun partenaire disponible.</p></div>
            <?php endif; ?>
        </div>
    </div>
</section>
