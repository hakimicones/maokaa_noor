
<section class="brands-section">
  <div class="brands-container">
    <div class="brands-header">
      <h2><?php echo htmlspecialchars($blockTitle ?: 'Nos marques partenaires'); ?></h2>
    </div>

    <?php if (!empty($items)): foreach ($items as $idx => $brand):
      $reverse = $idx % 2 === 1;
    ?>
      <div class="brand-row<?php echo $reverse ? ' reverse' : ''; ?>" data-brand-row>
        <div class="brand-logo-col">
          <?php if (!empty($brand['logo'])): ?>
            <div class="brand-logo-box">
              <img src="<?php echo htmlspecialchars(BASE_URL . $brand['logo']); ?>"
                   alt="<?php echo htmlspecialchars($brand['name']); ?>"
                   style="max-height:200px; width:auto; max-width:100%;">
            </div>
          <?php else: ?>
            <div class="brand-logo-box brand-logo-placeholder">
              <span><?php echo htmlspecialchars($brand['name']); ?></span>
            </div>
          <?php endif; ?>
        </div>

        <div class="brand-content-col">
          <h3 class="brand-name"><?php echo htmlspecialchars($brand['name']); ?></h3>

          <?php if (!empty($brand['description'])): ?>
            <div class="brand-desc">
              <?php echo nl2br(htmlspecialchars($brand['description'])); ?>
            </div>
          <?php endif; ?>

          <div class="brand-meta">
            <?php if (!empty($brand['website'])): ?>
              <div>
                <a href="<?php echo htmlspecialchars($brand['website']); ?>" target="_blank" rel="noopener">
                  <?php echo htmlspecialchars($brand['website']); ?>
                </a>
              </div>
            <?php endif; ?>
            <?php if (!empty($brand['email'])): ?>
              <div>
                <a href="mailto:<?php echo htmlspecialchars($brand['email']); ?>">
                  <?php echo htmlspecialchars($brand['email']); ?>
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; else: ?>
      <p class="no-brands">Aucune marque disponible.</p>
    <?php endif; ?>
  </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const rows = document.querySelectorAll('[data-brand-row]');

  if (!rows.length) {
    return;
  }

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) {
        return;
      }

      const index = Array.from(rows).indexOf(entry.target);
      entry.target.style.transitionDelay = `${index * 0.12}s`;
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    });
  }, {
    threshold: 0.18,
  });

  rows.forEach((row) => observer.observe(row));
});
</script>


<style>
    .brands-section {
  width: 100vw;
  position: relative;
  left: 50%;
  right: 50%;
  margin-left: -50vw;
  margin-right: -50vw;
  background: #f8f9fa;
  padding: 4rem 0;
}

.brands-content {
  width: 100%;
  max-width: none;
  padding: 0 5rem;
}

.brands-header {
  padding-bottom: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
  margin-bottom: 2.5rem;
}

.brands-header h2 {
  font-size: clamp(2rem, 3vw, 3rem);
  text-align: left;
  margin: 0;
}

.brand-row {
  display: flex;
  align-items: stretch;
  gap: 2rem;
  width: 100%;
  margin-left: 3rem;
  padding: 2.5rem 0;
  border-bottom: 1px solid #e5e7eb;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

.brand-row.visible {
  opacity: 1;
  transform: translateY(0);
}

.brand-row.reverse {
  flex-direction: row-reverse;
}

.brand-logo-col {
  flex: 0 0 35%;
  max-width: 35%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.brand-logo-col img {
  width: 100%;
  height: auto;
  max-height: 240px;
  object-fit: contain;
  border-radius: 16px;
}

.brand-logo-placeholder {
  width: 100%;
  min-height: 220px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
  color: #111;
  font-weight: 700;
  border-radius: 16px;
  border: 1px solid #e5e7eb;
  padding: 2rem;
  text-align: center;
}

.brand-content-col {
  flex: 1;
  max-width: 65%;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.brand-name {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: #111;
}

.brand-desc {
  font-size: 1rem;
  line-height: 1.9;
  color: #444;
  margin-bottom: 1.5rem;
  white-space: normal;
  overflow: visible;
}

.brand-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 1.2rem;
  font-size: 0.95rem;
}

.brand-meta a {
  color: #1a7fd4;
  text-decoration: none;
}

@media (max-width: 1200px) {
  .brands-content {
    padding: 0 4rem;
  }
}

@media (max-width: 992px) {
  .brand-row,
  .brand-row.reverse {
    flex-direction: column;
  }
  .brand-logo-col,
  .brand-content-col {
    max-width: 100%;
    width: 100%;
  }
  .brand-logo-col {
    padding-bottom: 1.5rem;
  }
  .brands-content {
    padding: 0 2rem;
  }
}

@media (max-width: 768px) {
  .brands-header {
    padding-bottom: 1rem;
  }
  .brand-row {
    gap: 1.5rem;
  }
  .brands-content {
    padding: 0 1.5rem;
  }
}
</style>