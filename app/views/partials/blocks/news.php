<?php
// $items = array of news articles, $blockTitle = optional heading
?>
<section class="py-5">
    <div class="container">
        <?php if (!empty($blockTitle)): ?>
            <h2 class="section-title"><?php echo htmlspecialchars($blockTitle); ?></h2>
        <?php else: ?>
            <h2 class="section-title">Dernières actualités</h2>
        <?php endif; ?>
        <div class="row g-4" style="grid-template-columns:repeat(auto-fill,minmax(300px,1fr));">
            <?php if (!empty($items)): foreach ($items as $item): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?php echo htmlspecialchars($item['image']); ?>"
                                 alt="<?php echo htmlspecialchars($item['title']); ?>"
                                 class="card-img-top" style="height:220px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <p class="text-muted small mb-2"><?php echo date('d/m/Y', strtotime($item['published_at'] ?? date('Y-m-d'))); ?></p>
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <p class="text-muted mb-3"><?php
                                $excerpt = $item['excerpt'] ?? '';
                                if (empty($excerpt)) {
                                    $excerpt = substr(strip_tags($item['content'] ?? ''), 0, 160) . '...';
                                }
                                echo htmlspecialchars($excerpt);
                            ?></p>
                            <a href="<?php echo BASE_URL; ?>news?id=<?php echo (int)$item['id']; ?>" class="btn btn-sm btn-primary">Lire plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="col-12"><div class="alert alert-info">Aucune actualité publiée pour le moment.</div></div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-5">
            <a href="<?php echo BASE_URL; ?>news" class="btn btn-primary btn-lg">Voir toutes les actualités</a>
        </div>
    </div>
</section>
