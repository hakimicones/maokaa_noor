<?php if (!empty($items)): ?>
<section class="splide brands-carousel py-4" aria-label="<?php echo htmlspecialchars($blockTitle ?: 'Marques partenaires'); ?>">
  <div class="container">
    <h2 class="text-center mb-4"><?php echo htmlspecialchars($blockTitle ?: 'Nos marques partenaires'); ?></h2>
  </div>
  <div class="splide__track">
    <ul class="splide__list">
      <?php foreach ($items as $brand): ?>
      <li class="splide__slide carousel-item">
        <a href="<?php echo htmlspecialchars($brand['website'] ?: '#'); ?>"
           target="_blank" rel="noopener"
           class="brands-carousel__item d-flex flex-column align-items-center justify-content-center h-100 text-decoration-none p-3">
          <?php if (!empty($brand['logo'])): ?>
          <img src="<?php echo htmlspecialchars(BASE_URL . str_replace('\\', '/', trim($brand['logo']))); ?>"
               alt="<?php echo htmlspecialchars($brand['name']); ?>"
               class="brands-carousel__logo mb-2"
               loading="lazy">
          <?php else: ?>
          <div class="brands-carousel__placeholder d-flex align-items-center justify-content-center mb-2">
            <i class="fas fa-building fa-3x text-muted"></i>
          </div>
          <?php endif; ?>
          <span class="brands-carousel__name small text-muted text-center"><?php echo htmlspecialchars($brand['name']); ?></span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<style>
.brands-carousel__item {
  transition: transform .2s ease, box-shadow .2s ease;
  border-radius: 12px;
  background: #fff;
  border: 1px solid #e9ecef;
}
.brands-carousel__item:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,.08);
}
.brands-carousel__logo {
  max-height: 80px;
  max-width: 140px;
  object-fit: contain;
  width: auto;
  height: auto;
}
.brands-carousel__placeholder {
  width: 120px;
  height: 80px;
  background: #f8f9fa;
  border-radius: 8px;
}
.brands-carousel__name {
  font-weight: 600;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  max-width: 140px;
}
</style>

<script>
(function() {
  var el = document.querySelector('.brands-carousel');
  if (!el || el.classList.contains('is-initialized')) return;
  el.classList.add('is-initialized');
  function init() {
    if (typeof Splide === 'undefined') { setTimeout(init, 150); return; }
    new Splide(el, {
      type: 'loop',
      perPage: 5,
      perMove: 1,
      autoplay: true,
      interval: 3000,
      pauseOnHover: true,
      gap: '24px',
      breakpoints: {
        992: { perPage: 3 },
        576: { perPage: 2 }
      },
      pagination: false,
      arrows: true
    }).mount();
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>
<?php endif; ?>
