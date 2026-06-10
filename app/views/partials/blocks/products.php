<section
  class="py-5 vep-products"
  data-limit="<?php echo (int)$limit; ?>"
  data-category="<?php echo (int)$category; ?>"
  data-base-url="<?php echo BASE_URL; ?>">

  <?php if (!empty($blockTitle)): ?>
    <div class="container text-center mb-4">
      <h2 class="vep-products__title"><?php echo htmlspecialchars($blockTitle); ?></h2>
    </div>
  <?php endif; ?>

  <div class="container">
    <!-- ─── Header : recherche + catégories + tri ─── -->
    <div class="vep-products__header">
      <div class="vep-products__search-wrap">
        <svg class="vep-products__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" class="vep-products__search" id="vep-search" placeholder="Rechercher un produit…" autocomplete="off">
        <div class="vep-products__ac" id="vep-ac"></div>
      </div>
      <div class="vep-products__pills" id="vep-pills"></div>
      <div class="vep-products__sort-wrap">
        <select class="vep-products__sort" id="vep-sort">
          <option value="popular">Populaire</option>
          <option value="name-asc">Nom A-Z</option>
          <option value="name-desc">Nom Z-A</option>
          <option value="newest">Nouveautés</option>
        </select>
      </div>
    </div>

    <div class="vep-products__bar" id="vep-bar">
      <span id="vep-count"></span>
      <button class="vep-products__clear" id="vep-clear" style="display:none">Effacer les filtres</button>
    </div>

    <!-- ─── Grille produits ─── -->
    <div class="vep-products__empty" id="vep-empty"></div>
    <div class="vep-products__grid" id="vep-grid"></div>
  </div>
</section>

<style>
/* ═══════════════════════════════════════════════════
   VEP Products Block — variables & reset
   ═══════════════════════════════════════════════════ */
.vep-products {
  --vp-primary:   #435980;
  --vp-primary-h: #345075;
  --vp-bg-card:   #fff;
  --vp-bg-skeleton: #e9ecef;
  --vp-shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
  --vp-shadow-h: 0 10px 30px rgba(0,0,0,.10), 0 4px 10px rgba(0,0,0,.06);
  --vp-radius: 12px;
}

/* ─── Titre ─── */
.vep-products__title {
  font-size: 1.75rem;
  font-weight: 700;
  position: relative;
  display: inline-block;
}
.vep-products__title::after {
  content: '';
  display: block;
  width: 60px; height: 3px;
  background: linear-gradient(90deg, var(--vp-primary), var(--vp-primary-h));
  margin: 10px auto 0;
  border-radius: 2px;
}

/* ─── Header ─── */
.vep-products__header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
  position: relative;
  z-index: 5;
}
.vep-products__search-wrap {
  flex: 1 1 320px;
  position: relative;
}
.vep-products__search-icon {
  position: absolute;
  left: 14px; top: 50%;
  transform: translateY(-50%);
  width: 18px; height: 18px;
  color: #94a3b8;
  pointer-events: none;
}
.vep-products__search {
  width: 100%;
  padding: 10px 14px 10px 42px;
  border: 1.5px solid #e2e8f0;
  border-radius: 10px;
  font-size: .95rem;
  background: #f8fafc;
  transition: border-color .2s, box-shadow .2s;
  outline: none;
}
.vep-products__search:focus {
  border-color: var(--vp-primary);
  box-shadow: 0 0 0 3px rgba(102,126,234,.15);
  background: #fff;
}
.vep-products__search::placeholder { color: #94a3b8; }

/* ─── Autocomplete ─── */
.vep-products__ac {
  position: absolute;
  top: calc(100% + 4px);
  left: 0; right: 0;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0,0,0,.10);
  max-height: 320px;
  overflow-y: auto;
  display: none;
  z-index: 50;
}
.vep-products__ac.open { display: block; }
.vep-products__ac-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 14px;
  cursor: pointer;
  text-decoration: none;
  color: inherit;
  transition: background .12s;
}
.vep-products__ac-item:hover,
.vep-products__ac-item.highlighted {
  background: #f1f5f9;
}
.vep-products__ac-item img {
  width: 36px; height: 36px;
  border-radius: 6px;
  object-fit: cover;
  background: #f1f5f9;
  flex-shrink: 0;
}
.vep-products__ac-item strong {
  font-size: .85rem;
  display: block;
}
.vep-products__ac-item small {
  font-size: .75rem;
  color: #64748b;
}

/* ─── Catégories (pills) ─── */
.vep-products__pills {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  flex: 0 0 100%;
  order: 10;
}
.vep-products__pill {
  padding: 5px 14px;
  border-radius: 20px;
  border: 1.5px solid #e2e8f0;
  background: #fff;
  font-size: .82rem;
  font-weight: 500;
  cursor: pointer;
  transition: all .15s;
  color: #475569;
  white-space: nowrap;
}
.vep-products__pill:hover {
  border-color: var(--vp-primary);
  color: var(--vp-primary);
}
.vep-products__pill.active {
  background: var(--vp-primary);
  border-color: var(--vp-primary);
  color: #fff;
}

/* ─── Tri ─── */
.vep-products__sort-wrap {
  margin-left: auto;
  order: 5;
}
.vep-products__sort {
  padding: 8px 12px;
  border: 1.5px solid #e2e8f0;
  border-radius: 8px;
  font-size: .85rem;
  background: #fff;
  cursor: pointer;
  outline: none;
  color: #475569;
}

/* ─── Barre d'info ─── */
.vep-products__bar {
  display: flex;
  align-items: center;
  gap: 12px;
  min-height: 28px;
  font-size: .85rem;
  color: #64748b;
  margin-bottom: 16px;
}
.vep-products__clear {
  background: none;
  border: none;
  color: var(--vp-primary);
  font-size: .82rem;
  cursor: pointer;
  padding: 0;
}
.vep-products__clear:hover { text-decoration: underline; }

/* ═══════════════════════════════════════════════════
   Grille
   ═══════════════════════════════════════════════════ */
.vep-products__grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 24px;
}

/* ─── Squelette (skeleton) ─── */
@keyframes vp-shimmer {
  0%   { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}
.vep-products__skeleton {
  border-radius: var(--vp-radius);
  overflow: hidden;
  background: #fff;
  box-shadow: var(--vp-shadow);
}
.vep-products__skeleton-img {
  width: 100%;
  padding-bottom: 100%;
  background: linear-gradient(90deg, var(--vp-bg-skeleton) 25%, #f4f6f8 50%, var(--vp-bg-skeleton) 75%);
  background-size: 200% 100%;
  animation: vp-shimmer 1.4s ease-in-out infinite;
}
.vep-products__skeleton-body {
  padding: 14px;
}
.vep-products__skeleton-line {
  height: 12px;
  border-radius: 6px;
  margin-bottom: 8px;
  background: linear-gradient(90deg, var(--vp-bg-skeleton) 25%, #f4f6f8 50%, var(--vp-bg-skeleton) 75%);
  background-size: 200% 100%;
  animation: vp-shimmer 1.4s ease-in-out infinite;
}

/* ═══════════════════════════════════════════════════
   Carte produit
   ═══════════════════════════════════════════════════ */
.vep-products__card {
  background: var(--vp-bg-card);
  border-radius: var(--vp-radius);
  box-shadow: var(--vp-shadow);
  overflow: hidden;
  transition: transform .25s cubic-bezier(.25,.46,.45,.94), box-shadow .25s;
  display: flex;
  flex-direction: column;
  opacity: 0;
  transform: translateY(12px);
  animation: vp-card-in .35s ease forwards;
}
@keyframes vp-card-in {
  to { opacity: 1; transform: translateY(0); }
}
.vep-products__card:hover {
  transform: translateY(-6px);
  box-shadow: var(--vp-shadow-h);
}

/* Image */
.vep-products__card-img {
  position: relative;
  background: #f1f5f9;
  overflow: hidden;
}
.vep-products__card-img-inner {
  display: block;
  width: 100%;
  padding-bottom: 100%;
  position: relative;
}
.vep-products__card-img-inner img {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform .4s ease;
}
.vep-products__card:hover .vep-products__card-img-inner img {
  transform: scale(1.06);
}

/* Wishlist */
.vep-products__wish {
  position: absolute;
  top: 10px; right: 10px;
  width: 34px; height: 34px;
  border-radius: 50%;
  border: none;
  background: rgba(255,255,255,.85);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: .9rem;
  color: #94a3b8;
  transition: all .2s;
  z-index: 2;
  opacity: 0;
  transform: scale(.8);
}
.vep-products__card:hover .vep-products__wish {
  opacity: 1;
  transform: scale(1);
}
.vep-products__wish:hover {
  color: #ef4444;
  background: rgba(255,255,255,.95);
}
.vep-products__wish.liked {
  color: #ef4444;
  opacity: 1;
  transform: scale(1);
}

/* Quick view overlay */
.vep-products__qv {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  padding: 12px;
  background: linear-gradient(transparent, rgba(0,0,0,.35));
  display: flex;
  justify-content: center;
  opacity: 0;
  transform: translateY(8px);
  transition: all .25s;
  z-index: 2;
}
.vep-products__card:hover .vep-products__qv {
  opacity: 1;
  transform: translateY(0);
}
.vep-products__qv-link {
  padding: 6px 18px;
  border-radius: 8px;
  background: rgba(255,255,255,.92);
  backdrop-filter: blur(4px);
  font-size: .82rem;
  font-weight: 600;
  color: #1e293b;
  text-decoration: none;
  transition: background .15s;
}
.vep-products__qv-link:hover {
  background: #fff;
  color: #0f172a;
}
.vep-products__qv-link i {
  margin-right: 6px;
  font-size: .75rem;
}

/* Corps */
.vep-products__card-body {
  padding: 14px 16px 16px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.vep-products__card-cat {
  font-size: .75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .03em;
  color: var(--vp-primary);
}
.vep-products__card-title {
  font-size: .95rem;
  font-weight: 700;
  line-height: 1.3;
  color: #0f172a;
  margin: 0;
}
.vep-products__card-desc {
  font-size: .82rem;
  color: #64748b;
  line-height: 1.45;
  margin-top: 2px;
  flex: 1;
}
.vep-products__card-actions {
  display: flex;
  gap: 8px;
  margin-top: 10px;
}
.vep-products__card-actions a {
  padding: 7px 14px;
  border-radius: 8px;
  font-size: .8rem;
  font-weight: 600;
  text-decoration: none;
  transition: all .15s;
  text-align: center;
}
.vep-products__card-detail {
  flex: 1;
  background: var(--vp-primary);
  color: #fff;
}
.vep-products__card-detail:hover {
  background: var(--vp-primary-h);
}
.vep-products__card-brochure {
  background: #f1f5f9;
  color: #475569;
}
.vep-products__card-brochure:hover {
  background: #e2e8f0;
}
.vep-products__card-quote {
  display: inline-flex;
  align-items: center;
  gap: 2px;
  padding: 6px 10px;
  border: 1px solid var(--vp-primary);
  border-radius: 8px;
  background: transparent;
  color: var(--vp-primary);
  font-size: 11px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}
.vep-products__card-quote:hover {
  background: var(--vp-primary);
  color: #fff;
}

/* ═══════════════════════════════════════════════════
   État vide intelligent
   ═══════════════════════════════════════════════════ */
.vep-products__empty {
  display: none;
}
.vep-products__empty.visible { display: block; }
.vep-products__empty-box {
  text-align: center;
  padding: 48px 16px;
}
.vep-products__empty-box h3 {
  font-size: 1.1rem;
  color: #475569;
  margin-bottom: 8px;
  font-weight: 600;
}
.vep-products__empty-box p {
  color: #94a3b8;
  font-size: .9rem;
  margin-bottom: 24px;
}
.vep-products__empty-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 16px;
  max-width: 720px;
  margin: 0 auto;
}
.vep-products__empty-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  text-decoration: none;
  color: inherit;
  padding: 12px;
  border-radius: 10px;
  background: #f8fafc;
  transition: background .15s;
}
.vep-products__empty-card:hover {
  background: #f1f5f9;
}
.vep-products__empty-card img {
  width: 80px; height: 80px;
  border-radius: 8px;
  object-fit: cover;
  background: #e2e8f0;
  margin-bottom: 8px;
}
.vep-products__empty-card strong {
  font-size: .85rem;
  display: block;
}
.vep-products__empty-card small {
  font-size: .75rem;
  color: #64748b;
}

/* ─── Responsive ─── */
@media (max-width: 640px) {
  .vep-products__grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
  .vep-products__header {
    flex-direction: column;
    align-items: stretch;
  }
  .vep-products__sort-wrap {
    margin-left: 0;
    order: 0;
  }
  .vep-products__pills {
    order: 0;
    overflow-x: auto;
    flex-wrap: nowrap;
    padding-bottom: 4px;
    -webkit-overflow-scrolling: touch;
  }
  .vep-products__empty-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<script>
(function(){
'use strict';

var section = document.querySelector('.vep-products');
if (!section) return;

var baseUrl   = section.getAttribute('data-base-url') || '';
var rawLimit  = parseInt(section.getAttribute('data-limit'), 10);
var initLimit = isNaN(rawLimit) ? 0 : rawLimit;
var initCat   = parseInt(section.getAttribute('data-category'), 10) || 0;

// ─── Éléments DOM ───
var grid      = document.getElementById('vep-grid');
var emptyEl   = document.getElementById('vep-empty');
var bar       = document.getElementById('vep-bar');
var countEl   = document.getElementById('vep-count');
var clearBtn  = document.getElementById('vep-clear');
var searchInp = document.getElementById('vep-search');
var acEl      = document.getElementById('vep-ac');
var pillsEl   = document.getElementById('vep-pills');
var sortSel   = document.getElementById('vep-sort');

// ─── État ───
var allProducts   = [];
var allCategories = [];
var featured      = [];
var searchTerm    = '';
var activeCat     = initCat;
var activeSort    = 'popular';
var debounceTimer = null;

// ─── DICE COEFFICIENT (fuzzy) ───
function getBigrams(s) {
  var set = new Set();
  for (var i = 0; i < s.length - 1; i++) set.add(s.slice(i, i + 2));
  return set;
}
function diceCoeff(a, b) {
  if (a === b) return 1;
  if (a.length < 2 || b.length < 2) return 0;
  var ba = getBigrams(a), bb = getBigrams(b);
  var inter = 0;
  for (var bg of ba) if (bb.has(bg)) inter++;
  return 2 * inter / (ba.size + bb.size);
}

// ─── SQUELETTES ───
function showSkeletons() {
  var h = '';
  for (var i = 0; i < 6; i++) {
    h += '<div class="vep-products__skeleton">' +
      '<div class="vep-products__skeleton-img"></div>' +
      '<div class="vep-products__skeleton-body">' +
        '<div class="vep-products__skeleton-line" style="width:40%"></div>' +
        '<div class="vep-products__skeleton-line" style="width:75%"></div>' +
        '<div class="vep-products__skeleton-line" style="width:60%"></div>' +
      '</div></div>';
  }
  grid.innerHTML = h;
  emptyEl.classList.remove('visible');
}

// ─── CARTE HTML ───
function cardHTML(p) {
  var img   = p.image ? html(p.image) : '';
  var name  = html(p.nom);
  var cat   = html(p.categorie_name || 'Produit');
  var desc  = html(strip(p.description || '').slice(0, 100));
  var url   = baseUrl + 'products?id=' + p.id;
  var like  = isLiked(p.id) ? ' liked' : '';
  var brochure = p.brochure_pdf
    ? '<a href="' + html(p.brochure_pdf) + '" target="_blank" rel="noopener" class="vep-products__card-brochure"><i class="fas fa-file-pdf"></i></a>'
    : '';
  var catTag = cat ? '<span class="vep-products__card-cat">' + cat + '</span>' : '';
  return '<div class="vep-products__card" data-id="' + p.id + '">' +
    '<div class="vep-products__card-img">' +
      '<a href="' + url + '" class="vep-products__card-img-inner">' +
        (img ? '<img src="' + img + '" alt="' + name + '" loading="lazy">' : '') +
      '</a>' +
      '<button class="vep-products__wish' + like + '" data-id="' + p.id + '" aria-label="Favoris">' +
        '<i class="' + (like ? 'fas' : 'far') + ' fa-heart"></i>' +
      '</button>' +
      '<div class="vep-products__qv">' +
        '<a href="' + url + '" class="vep-products__qv-link"><i class="fas fa-eye"></i> Voir le détail</a>' +
      '</div>' +
    '</div>' +
    '<div class="vep-products__card-body">' +
      catTag +
      '<h3 class="vep-products__card-title">' + name + '</h3>' +
      '<p class="vep-products__card-desc">' + desc + '</p>' +
      '<div class="vep-products__card-actions">' +
        '<a href="' + url + '" class="vep-products__card-detail">Détail</a>' +
        '<button type="button" class="vep-products__card-quote" data-quote-id="' + p.id + '" data-quote-nom="' + name + '"><i class="fas fa-file-invoice"></i> Devis</button>' +
        brochure +
      '</div>' +
    '</div>' +
  '</div>';
}

// ─── AFFICHER LES PRODUITS ───
function render(items) {
  if (items.length === 0) {
    emptyEl.classList.add('visible');
    emptyEl.innerHTML = smartEmptyHTML();
    grid.innerHTML = '';
    countEl.textContent = '0 produit trouvé';
    return;
  }
  emptyEl.classList.remove('visible');
  var frag = document.createDocumentFragment();
  items.forEach(function (p) {
    var tmp = document.createElement('div');
    tmp.innerHTML = cardHTML(p);
    frag.appendChild(tmp.firstElementChild);
  });
  grid.innerHTML = '';
  grid.appendChild(frag);

  var nb = items.length;
  countEl.textContent = nb + ' produit' + (nb > 1 ? 's' : '') + ' trouvé' + (nb > 1 ? 's' : '');
  clearBtn.style.display = (searchTerm || activeCat > 0) ? '' : 'none';

  // Wishlist clicks
  grid.querySelectorAll('.vep-products__wish').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      toggleLike(this);
    });
  });
}

// ─── FILTRER & TRIER ───
function filterAndSort() {
  showSkeletons();
  var q = searchTerm.toLowerCase().trim();
  var items = allProducts.filter(function (p) {
    if (activeCat > 0 && p.categorie_id != activeCat) return false;
    if (q === '') return true;
    var name = (p.nom || '').toLowerCase();
    var desc = (p.description || '').toLowerCase();
    if (name.indexOf(q) !== -1 || desc.indexOf(q) !== -1) return true;
    return diceCoeff(q, name) > 0.3;
  });
  sortItems(items);
  // Mini délai pour l'effet squelette
  setTimeout(function () { render(items); }, 280);
}

function sortItems(items) {
  var cmp;
  switch (activeSort) {
    case 'name-asc':  cmp = function (a, b) { return (a.nom||'').localeCompare(b.nom||''); }; break;
    case 'name-desc': cmp = function (a, b) { return (b.nom||'').localeCompare(a.nom||''); }; break;
    case 'newest':    cmp = function (a, b) { return ((b.created_at||'')+'').localeCompare((a.created_at||'')+''); }; break;
    default:
      cmp = function (a, b) {
        var fa = (a.featured||0)|0, fb = (b.featured||0)|0;
        if (fa !== fb) return fb - fa;
        return (a.display_order||0) - (b.display_order||0);
      };
  }
  items.sort(cmp);
}

// ─── AUTOCOMPLETE ───
function buildAC(q) {
  if (q.length < 2) { acEl.classList.remove('open'); return; }
  var hits = [];
  var lq = q.toLowerCase();
  allProducts.forEach(function (p) {
    var name = (p.nom || '').toLowerCase();
    if (name.indexOf(lq) !== -1 || diceCoeff(lq, name) > 0.35) {
      hits.push(p);
    }
  });
  hits.sort(function (a, b) {
    return diceCoeff(lq, b.nom) - diceCoeff(lq, a.nom);
  });
  hits = hits.slice(0, 7);
  if (hits.length === 0) { acEl.classList.remove('open'); return; }
  var h = '';
  hits.forEach(function (p) {
    var img = p.image ? '<img src="' + html(p.image) + '" alt="">' : '<div style="width:36px;height:36px;border-radius:6px;background:#f1f5f9;flex-shrink:0"></div>';
    h += '<a class="vep-products__ac-item" href="' + baseUrl + 'products?id=' + p.id + '">' +
      img +
      '<div><strong>' + html(p.nom) + '</strong><small>' + html(p.categorie_name || '') + '</small></div>' +
    '</a>';
  });
  acEl.innerHTML = h;
  acEl.classList.add('open');
}

// ─── CATÉGORIES (pills) ───
function renderPills() {
  var h = '<button class="vep-products__pill' + (activeCat === 0 ? ' active' : '') + '" data-cat="0">Tous</button>';
  allCategories.forEach(function (c) {
    h += '<button class="vep-products__pill' + (activeCat === c.id ? ' active' : '') + '" data-cat="' + c.id + '">' + html(c.name) + '</button>';
  });
  pillsEl.innerHTML = h;
  pillsEl.querySelectorAll('.vep-products__pill').forEach(function (btn) {
    btn.addEventListener('click', function () {
      activeCat = parseInt(this.getAttribute('data-cat'), 10);
      renderPills();
      filterAndSort();
    });
  });
}

// ─── ÉTAT VIDE INTELLIGENT ───
function smartEmptyHTML() {
  var f = featured.slice(0, 3);
  if (f.length === 0) {
    return '<div class="vep-products__empty-box">' +
      '<h3>Aucun résultat</h3>' +
      '<p>Essayez de modifier vos filtres ou votre recherche.</p>' +
    '</div>';
  }
  var cards = '';
  f.forEach(function (p) {
    var img = p.image ? '<img src="' + html(p.image) + '" alt="">' : '';
    cards += '<a href="' + baseUrl + 'products?id=' + p.id + '" class="vep-products__empty-card">' +
      img +
      '<strong>' + html(p.nom) + '</strong>' +
      '<small>' + html(p.categorie_name || '') + '</small>' +
    '</a>';
  });
  var q = html(searchTerm);
  return '<div class="vep-products__empty-box">' +
    '<h3>Aucun résultat pour "' + q + '"</h3>' +
    '<p>Mais vous aimerez peut-être ces nouveautés :</p>' +
    '<div class="vep-products__empty-grid">' + cards + '</div>' +
  '</div>';
}

// ─── FAVORIS (localStorage) ───
function getLiked() {
  try { return JSON.parse(localStorage.getItem('vep-wish') || '[]'); } catch(e) { return []; }
}
function isLiked(id) { return getLiked().indexOf(id) !== -1; }
function toggleLike(btn) {
  var id = parseInt(btn.getAttribute('data-id'), 10);
  var arr = getLiked();
  var idx = arr.indexOf(id);
  if (idx === -1) { arr.push(id); btn.classList.add('liked'); btn.querySelector('i').className = 'fas fa-heart'; }
  else { arr.splice(idx, 1); btn.classList.remove('liked'); btn.querySelector('i').className = 'far fa-heart'; }
  localStorage.setItem('vep-wish', JSON.stringify(arr));
}

// ─── HELPER ───
function html(s) { return (s + '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
function strip(s) { var d = document.createElement('div'); d.innerHTML = s; return d.textContent || d.innerText || ''; }

// ─── CHARGEMENT INITIAL ───
showSkeletons();

var apiUrl = baseUrl + 'includes/api_products.php?';
if (initLimit > 0) apiUrl += 'limit=' + initLimit + '&';
if (initCat > 0) apiUrl += 'category=' + initCat + '&';
fetch(apiUrl)
  .then(function (r) {
    if (!r.ok) { throw new Error('HTTP ' + r.status); }
    return r.json();
  })
  .then(function (data) {
    allProducts   = data.products   || [];
    allCategories = data.categories || [];
    featured      = data.featured   || [];
    sortItems(allProducts);
    renderPills();
    render(allProducts);
  })
  .catch(function (err) {
    console.error('VEP Products fetch error:', err);
    emptyEl.classList.add('visible');
    emptyEl.innerHTML = '<div class="vep-products__empty-box"><h3>Erreur de chargement</h3><p>Impossible de charger les produits.</p></div>';
    grid.innerHTML = '';
  });

// ─── ÉVÈNEMENTS ───

// Recherche
searchInp.addEventListener('input', function () {
  searchTerm = this.value;
  buildAC(searchTerm);
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(filterAndSort, 180);
});

// Clic hors autocomplete
document.addEventListener('click', function (e) {
  if (!acEl.contains(e.target) && e.target !== searchInp) {
    acEl.classList.remove('open');
  }
});

// Tri
sortSel.addEventListener('change', function () {
  activeSort = this.value;
  filterAndSort();
});

// Effacer
clearBtn.addEventListener('click', function () {
  searchTerm = '';
  searchInp.value = '';
  activeCat = 0;
  activeSort = 'popular';
  sortSel.value = 'popular';
  renderPills();
  filterAndSort();
});

// ─── MODAL DEVIS (délégation) ───
document.body.addEventListener('click', function (e) {
  var btn = e.target.closest('.vep-products__card-quote, [data-bs-target="#quoteModal"]');
  if (!btn) return;
  var modalEl = document.getElementById('quoteModal');
  if (!modalEl) return;
  var id  = btn.getAttribute('data-quote-id');
  var nom = btn.getAttribute('data-quote-nom');
  if (id !== null)  document.getElementById('quote-produit-id').value  = id;
  if (nom !== null) document.getElementById('quote-produit-nom').value = nom;
  var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
  modal.show();
});

// ─── SOUMISSION FORMULAIRE DEVIS (une seule fois) ───
if (!window._vepQuoteInit) {
  window._vepQuoteInit = true;
  document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('quoteForm');
    if (!form) return;
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn  = document.getElementById('quote-submit');
      var succ = document.getElementById('quote-success');
      var err  = document.getElementById('quote-error');
      if (!btn) return;
      btn.disabled = true;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi...';
      succ.classList.add('d-none');
      err.classList.add('d-none');
      fetch(baseUrl + 'includes/api_quote.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nom:       form.nom.value,
          email:     form.email.value,
          telephone: form.telephone.value,
          produit:   document.getElementById('quote-produit-nom').value,
          quantite:  form.quantite.value,
          message:   form.message.value
        })
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          succ.querySelector('span').textContent = data.message;
          succ.classList.remove('d-none');
          form.reset();
          document.getElementById('quote-produit-id').value = '';
          document.getElementById('quote-produit-nom').value = '';
        } else {
          err.querySelector('span').textContent = data.message;
          err.classList.remove('d-none');
        }
      })
      .catch(function () {
        err.querySelector('span').textContent = 'Erreur de connexion.';
        err.classList.remove('d-none');
      })
      .then(function () {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Envoyer la demande';
      });
    });
  });
}

})();
</script>

<?php
// Inclure le modal de devis une seule fois, quel que soit le nombre de blocs
if (!defined('VEP_QUOTE_MODAL_INCLUDED')) {
    define('VEP_QUOTE_MODAL_INCLUDED', true);
    include __DIR__ . '/quote-form.php';
}
?>
