// assets/js/inline-edit.js — Édition inline frontend (admin uniquement)
// - Champs texte (h1-h6, p, blockquote, cite, code, figcaption) : contenteditable individuel
// - Blocs dynamiques (.vep-block-wrapper) : bouton lien vers l'admin
// - Images : popup sélecteur depuis assets/images/

(function () {
    'use strict';

    var csrfToken = getMeta('csrf-token');
    var pageSlug  = getMeta('page-slug');
    var baseUrl   = getMeta('base-url') || '/';

    var TEXT_SELECTORS = 'h1, h2, h3, h4, h5, h6, p, blockquote, cite, code, figcaption';

    // ── Barre d'outils admin ─────────────────────────────────────────────
    var toolbar = document.createElement('div');
    toolbar.id = 'ie-toolbar';
    toolbar.innerHTML =
        '<i class="fas fa-pencil-alt ie-toolbar-icon"></i>' +
        '<span id="ie-toolbar-hint">Mode <strong>édition inline</strong> — cliquez sur un texte pour le modifier</span>' +
        '<a href="' + baseUrl + 'admin/" id="ie-toolbar-admin">' +
            'Tableau de bord <i class="fas fa-external-link-alt"></i>' +
        '</a>';
    document.body.prepend(toolbar);

    // ── Champs simples : title, subtitle ─────────────────────────────────
    document.querySelectorAll('[data-inline-field="title"], [data-inline-field="subtitle"]').forEach(function (el) {
        initTextField(el, el.getAttribute('data-inline-field'));
    });

    // ── Champ body ────────────────────────────────────────────────────────
    var bodyEl = document.querySelector('[data-inline-field="body"]');
    if (bodyEl) initBodyField(bodyEl);

    // ── Toolbar WYSIWYG flottante (apparaît au focus d'un élément body) ──
    var wysiwygToolbar = null;
    var wysiwygTarget  = null;
    var wysiwygTimer   = null;

    function getWysiwygToolbar() {
        if (wysiwygToolbar) return wysiwygToolbar;
        wysiwygToolbar = document.createElement('div');
        wysiwygToolbar.id = 'ie-wysiwyg-toolbar';
        wysiwygToolbar.innerHTML =
            '<button type="button" data-cmd="bold" title="Gras (Ctrl+B)"><i class="fas fa-bold"></i></button>' +
            '<button type="button" data-cmd="italic" title="Italique (Ctrl+I)"><i class="fas fa-italic"></i></button>' +
            '<button type="button" data-cmd="underline" title="Souligné (Ctrl+U)"><i class="fas fa-underline"></i></button>' +
            '<span class="ie-wysiwyg-sep"></span>' +
            '<button type="button" data-cmd="formatBlock" data-arg="h2" title="Titre H2"><i class="fas fa-heading"></i> H2</button>' +
            '<button type="button" data-cmd="formatBlock" data-arg="h3" title="Titre H3"><i class="fas fa-heading"></i> H3</button>' +
            '<button type="button" data-cmd="formatBlock" data-arg="p" title="Paragraphe"><i class="fas fa-paragraph"></i></button>' +
            '<span class="ie-wysiwyg-sep"></span>' +
            '<button type="button" data-cmd="createLink" title="Insérer un lien"><i class="fas fa-link"></i></button>' +
            '<button type="button" data-cmd="unlink" title="Supprimer le lien"><i class="fas fa-unlink"></i></button>';

        wysiwygToolbar.addEventListener('mousedown', function (e) {
            e.preventDefault();
            var btn = e.target.closest('button');
            if (!btn) return;
            var cmd = btn.getAttribute('data-cmd');
            var arg = btn.getAttribute('data-arg') || null;
            if (cmd === 'createLink') {
                var url = prompt('URL du lien :', 'https://');
                if (url) document.execCommand(cmd, false, url);
            } else {
                document.execCommand(cmd, false, arg);
            }
            if (wysiwygTarget) wysiwygTarget.focus();
        });

        document.body.appendChild(wysiwygToolbar);
        return wysiwygToolbar;
    }

    function showWysiwygToolbar(el) {
        cancelHideWysiwyg();
        var tb = getWysiwygToolbar();
        wysiwygTarget = el;
        var rect = el.getBoundingClientRect();
        var scrollY = window.scrollY || window.pageYOffset;
        var topPos = rect.top + scrollY - tb.offsetHeight - 8;
        if (rect.top < tb.offsetHeight + 12) {
            topPos = rect.bottom + scrollY + 8;
        }
        tb.style.top = topPos + 'px';
        tb.style.left = Math.max(8, rect.left + (rect.width / 2) - 100) + 'px';
        tb.classList.add('ie-wysiwyg-visible');
    }

    function hideWysiwygToolbar() {
        if (wysiwygTimer) clearTimeout(wysiwygTimer);
        wysiwygTimer = setTimeout(function () {
            if (wysiwygToolbar) wysiwygToolbar.classList.remove('ie-wysiwyg-visible');
            wysiwygTarget = null;
        }, 200);
    }

    function cancelHideWysiwyg() {
        if (wysiwygTimer) {
            clearTimeout(wysiwygTimer);
            wysiwygTimer = null;
        }
    }

    // ── Champs texte simples (title, subtitle) : contenteditable ─────────
    function initTextField(el, field) {
        el.setAttribute('contenteditable', 'true');
        el.setAttribute('spellcheck', 'true');
        el.classList.add('ie-field');

        var originalHTML = el.innerHTML;

        el.addEventListener('focus', function () { this.classList.add('ie-editing'); });

        el.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                this.blur();
            }
            if (e.key === 'Escape') {
                this.innerHTML = originalHTML;
                this.blur();
            }
        });

        el.addEventListener('blur', function () {
            var self = this;
            self.classList.remove('ie-editing');
            var current = self.innerHTML;
            if (current === originalHTML) return;
            pulse(self, 'ie-saving');
            saveField(field, current, function (ok, data) {
                self.classList.remove('ie-saving');
                if (ok) {
                    originalHTML = current;
                    pulse(self, 'ie-success');
                    showToast(data.message, 'success');
                } else {
                    self.innerHTML = originalHTML;
                    pulse(self, 'ie-error');
                    showToast(data.message || 'Erreur inconnue', 'error');
                }
            });
        });
    }

    // ── Corps de page : édition granulaire ───────────────────────────────
    function initBodyField(bodyEl) {
        bodyEl.classList.add('ie-body');

        // 1. Blocs dynamiques → bouton admin
        bodyEl.querySelectorAll('.vep-block-wrapper').forEach(function (block) {
            decorateVepBlock(block);
        });

        // 2. Images hors blocs dynamiques → sélecteur d'image
        bodyEl.querySelectorAll('img').forEach(function (img) {
            if (!img.closest('.vep-block-wrapper')) {
                decorateImage(img, bodyEl);
            }
        });

        // 3. Éléments texte hors blocs dynamiques → contenteditable
        bodyEl.querySelectorAll(TEXT_SELECTORS).forEach(function (el) {
            if (el.closest('.vep-block-wrapper')) return;
            initInlineText(el, bodyEl);
        });
    }

    // ── Décoration bloc dynamique ─────────────────────────────────────────
    function decorateVepBlock(block) {
        block.classList.add('ie-vep-block');
        var adminUrl = baseUrl + (block.getAttribute('data-vep-admin-url') || 'admin/dashboard.php');
        var sep = adminUrl.indexOf('?') === -1 ? '?' : '&';
        adminUrl += sep + 'return_url=' + encodeURIComponent(window.location.href);

        var btn = document.createElement('a');
        btn.className = 'ie-vep-btn';
        btn.href = adminUrl;
        btn.target = '_blank';
        btn.rel = 'noopener';
        btn.innerHTML = '<i class="fas fa-cogs"></i> Gérer dans l\'admin';
        block.appendChild(btn);
    }

    // ── Décoration image ──────────────────────────────────────────────────
    function decorateImage(img, bodyEl) {
        img.classList.add('ie-img');

        var wrap = document.createElement('span');
        wrap.className = 'ie-img-wrap';
        img.parentNode.insertBefore(wrap, img);
        wrap.appendChild(img);

        var overlay = document.createElement('span');
        overlay.className = 'ie-img-overlay';
        overlay.innerHTML = '<i class="fas fa-camera"></i>';
        wrap.appendChild(overlay);

        overlay.addEventListener('click', function (e) {
            e.stopPropagation();
            openImagePicker(img, bodyEl);
        });

        img.addEventListener('click', function (e) {
            if (img.closest('.ie-editing')) return;
            e.preventDefault();
            e.stopPropagation();
            openImagePicker(img, bodyEl);
        });
    }

    // ── Édition texte inline ──────────────────────────────────────────────
    function initInlineText(el, bodyEl) {
        el.setAttribute('contenteditable', 'true');
        el.setAttribute('spellcheck', 'true');
        el.classList.add('ie-field');

        var originalHTML = el.innerHTML;

        el.addEventListener('focus', function () {
            this.classList.add('ie-editing');
            showWysiwygToolbar(this);
        });

        el.addEventListener('mousedown', function () {
            cancelHideWysiwyg();
        });

        el.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                this.blur();
            }
            if (e.key === 'Escape') {
                this.innerHTML = originalHTML;
                this.blur();
            }
        });

        el.addEventListener('blur', function () {
            var self = this;
            self.classList.remove('ie-editing');
            hideWysiwygToolbar();
            var current = self.innerHTML;
            if (current === originalHTML) return;

            pulse(self, 'ie-saving');
            serializeAndSaveBody(bodyEl, function (ok, data) {
                self.classList.remove('ie-saving');
                if (ok) {
                    originalHTML = current;
                    pulse(self, 'ie-success');
                    showToast(data.message, 'success');
                } else {
                    self.innerHTML = originalHTML;
                    pulse(self, 'ie-error');
                    showToast(data.message || 'Erreur inconnue', 'error');
                }
            });
        });
    }

    // ── Sélecteur d'image ─────────────────────────────────────────────────
    function openImagePicker(img, bodyEl) {
        fetch(baseUrl + 'includes/list_images.php')
            .then(function (r) { return r.json(); })
            .then(function (data) { showImagePickerModal(img, data.images || [], bodyEl); })
            .catch(function () { showToast('Impossible de charger les images', 'error'); });
    }

    function showImagePickerModal(img, images, bodyEl) {
        var existing = document.getElementById('ie-img-picker');
        if (existing) existing.remove();

        var grid = images.map(function (src) {
            return '<button class="ie-img-picker-item" data-src="' + escapeAttr(src) + '" type="button">' +
                   '<img src="' + escapeAttr(src) + '" alt="" loading="lazy"></button>';
        }).join('');

        var picker = document.createElement('div');
        picker.id = 'ie-img-picker';
        picker.innerHTML =
            '<div class="ie-img-picker-dialog">' +
                '<div class="ie-img-picker-header">' +
                    '<span><i class="fas fa-images"></i> Choisir une image</span>' +
                    '<button class="ie-img-picker-close" type="button" aria-label="Fermer">&times;</button>' +
                '</div>' +
                '<div class="ie-img-picker-grid">' +
                    (grid || '<p class="ie-img-picker-empty">Aucune image dans assets/images/</p>') +
                '</div>' +
            '</div>';

        document.body.appendChild(picker);

        picker.querySelector('.ie-img-picker-close').addEventListener('click', function () { picker.remove(); });
        picker.addEventListener('click', function (e) { if (e.target === picker) picker.remove(); });

        picker.querySelectorAll('.ie-img-picker-item').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var src = this.getAttribute('data-src');
                img.src = src;
                picker.remove();
                serializeAndSaveBody(bodyEl, function (ok, data) {
                    if (ok) {
                        showToast(data.message, 'success');
                    } else {
                        showToast(data.message || 'Erreur inconnue', 'error');
                    }
                });
            });
        });
    }

    // ── Sérialisation du body (shortcodes reconstruits) ───────────────────
    function serializeAndSaveBody(bodyEl, callback) {
        var clone = bodyEl.cloneNode(true);

        // Supprimer les UI d'édition injectées
        clone.querySelectorAll('.ie-vep-btn, .ie-img-overlay').forEach(function (n) { n.remove(); });

        // Défaire le wrapper des images, conserver l'img avec son src mis à jour
        clone.querySelectorAll('.ie-img-wrap').forEach(function (wrap) {
            var imgEl = wrap.querySelector('img');
            if (imgEl) wrap.replaceWith(imgEl);
        });

        // Nettoyer les attributs d'édition
        clone.querySelectorAll('[contenteditable]').forEach(function (n) { n.removeAttribute('contenteditable'); });
        clone.querySelectorAll('[spellcheck]').forEach(function (n) { n.removeAttribute('spellcheck'); });

        // Nettoyer les classes ie-* ajoutées
        var ieClasses = ['ie-field', 'ie-editing', 'ie-saving', 'ie-success', 'ie-error', 'ie-img', 'ie-vep-block'];
        clone.querySelectorAll('.' + ieClasses.join(', .')).forEach(function (n) {
            ieClasses.forEach(function (c) { n.classList.remove(c); });
        });
        clone.classList.remove('ie-body');

        // Remplacer chaque bloc dynamique par son shortcode original
        clone.querySelectorAll('.vep-block-wrapper').forEach(function (block) {
            var sc = block.getAttribute('data-vep-shortcode');
            if (sc) block.replaceWith(document.createTextNode(sc));
        });

        saveField('body', clone.innerHTML, callback);
    }

    // ── Envoi AJAX ────────────────────────────────────────────────────────
    function saveField(field, value, callback) {
        fetch(baseUrl + 'includes/inline_edit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                csrf_token: csrfToken,
                slug:       pageSlug,
                field:      field,
                value:      value
            })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) { callback(data.success, data); })
        .catch(function () { callback(false, { message: 'Erreur de connexion au serveur' }); });
    }

    // ── Feedback visuel ───────────────────────────────────────────────────
    function pulse(el, cls) {
        el.classList.remove('ie-saving', 'ie-success', 'ie-error');
        el.classList.add(cls);
        if (cls !== 'ie-saving') {
            setTimeout(function () { el.classList.remove(cls); }, 1800);
        }
    }

    function showToast(message, type) {
        var existing = document.getElementById('ie-toast');
        if (existing) existing.remove();

        var icon = type === 'success'
            ? '<i class="fas fa-check-circle"></i>'
            : '<i class="fas fa-exclamation-circle"></i>';

        var toast = document.createElement('div');
        toast.id = 'ie-toast';
        toast.className = 'ie-toast ie-toast-' + type;
        toast.innerHTML = icon + ' ' + escapeHtml(message);
        document.body.appendChild(toast);

        requestAnimationFrame(function () {
            requestAnimationFrame(function () { toast.classList.add('ie-toast-visible'); });
        });

        setTimeout(function () {
            toast.classList.remove('ie-toast-visible');
            setTimeout(function () { toast.remove(); }, 300);
        }, 3000);
    }

    // ── Utilitaires ───────────────────────────────────────────────────────
    function getMeta(name) {
        var el = document.querySelector('meta[name="' + name + '"]');
        return el ? el.getAttribute('content') : null;
    }

    function escapeHtml(str) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(String(str)));
        return d.innerHTML;
    }

    function escapeAttr(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    // ── Champs produit inline ─────────────────────────────────────────────
    function initProductField(el, productId) {
        var field = el.getAttribute('data-inline-field');
        if (!field) return;

        el.setAttribute('contenteditable', 'true');
        el.setAttribute('spellcheck', 'true');
        el.classList.add('ie-field');

        var originalHTML = el.innerHTML;

        el.addEventListener('focus', function () {
            this.classList.add('ie-editing');
            showWysiwygToolbar(this);
        });

        el.addEventListener('mousedown', function () { cancelHideWysiwyg(); });

        el.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') { e.preventDefault(); this.blur(); }
            if (e.key === 'Escape') { this.innerHTML = originalHTML; this.blur(); }
        });

        el.addEventListener('blur', function () {
            var self = this;
            self.classList.remove('ie-editing');
            hideWysiwygToolbar();
            var current = self.innerHTML;
            if (current === originalHTML) return;
            pulse(self, 'ie-saving');
            saveProductField(productId, field, current, function (ok, data) {
                self.classList.remove('ie-saving');
                if (ok) {
                    originalHTML = current;
                    pulse(self, 'ie-success');
                    showToast(data.message, 'success');
                } else {
                    self.innerHTML = originalHTML;
                    pulse(self, 'ie-error');
                    showToast(data.message || 'Erreur', 'error');
                }
            });
        });
    }

    function saveProductField(productId, field, value, callback) {
        fetch(baseUrl + 'includes/inline_edit_product.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                csrf_token: csrfToken,
                product_id: productId,
                field:      field,
                value:      value
            })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) { callback(data.success, data); })
        .catch(function () { callback(false, { message: 'Erreur de connexion' }); });
    }

    // ── Image produit inline ──────────────────────────────────────────────
    function initProductImage(img, productId) {
        img.classList.add('ie-img');

        var wrap = document.createElement('span');
        wrap.className = 'ie-img-wrap';
        img.parentNode.insertBefore(wrap, img);
        wrap.appendChild(img);

        var overlay = document.createElement('span');
        overlay.className = 'ie-img-overlay';
        overlay.innerHTML = '<i class="fas fa-camera"></i>';
        wrap.appendChild(overlay);

        overlay.addEventListener('click', function (e) {
            e.stopPropagation();
            openProductImagePicker(img, productId);
        });

        img.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openProductImagePicker(img, productId);
        });
    }

    function openProductImagePicker(img, productId) {
        fetch(baseUrl + 'includes/list_images.php')
            .then(function (r) { return r.json(); })
            .then(function (data) { showProductImagePickerModal(img, data.images || [], productId); })
            .catch(function () { showToast('Impossible de charger les images', 'error'); });
    }

    function showProductImagePickerModal(img, images, productId) {
        var existing = document.getElementById('ie-img-picker');
        if (existing) existing.remove();

        var grid = images.map(function (src) {
            return '<button class="ie-img-picker-item" data-src="' + escapeAttr(src) + '" type="button">' +
                   '<img src="' + escapeAttr(src) + '" alt="" loading="lazy"></button>';
        }).join('');

        var picker = document.createElement('div');
        picker.id = 'ie-img-picker';
        picker.innerHTML =
            '<div class="ie-img-picker-dialog">' +
                '<div class="ie-img-picker-header">' +
                    '<span><i class="fas fa-images"></i> Choisir une image produit</span>' +
                    '<button class="ie-img-picker-close" type="button" aria-label="Fermer">&times;</button>' +
                '</div>' +
                '<div class="ie-img-picker-grid">' +
                    (grid || '<p class="ie-img-picker-empty">Aucune image dans assets/images/</p>') +
                '</div>' +
            '</div>';

        document.body.appendChild(picker);

        picker.querySelector('.ie-img-picker-close').addEventListener('click', function () { picker.remove(); });
        picker.addEventListener('click', function (e) { if (e.target === picker) picker.remove(); });

        picker.querySelectorAll('.ie-img-picker-item').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var src = this.getAttribute('data-src');
                picker.remove();
                pulse(img, 'ie-saving');
                saveProductField(productId, 'image', src, function (ok, data) {
                    img.classList.remove('ie-saving');
                    if (ok) {
                        img.src = src;
                        pulse(img, 'ie-success');
                        showToast(data.message, 'success');
                    } else {
                        pulse(img, 'ie-error');
                        showToast(data.message || 'Erreur', 'error');
                    }
                });
            });
        });
    }

    // Initialiser les champs produit inline (en dehors du body)
    document.querySelectorAll('[data-inline-field][data-product-id]').forEach(function (el) {
        if (el.closest('.ie-body')) return;
        var pid = parseInt(el.getAttribute('data-product-id'), 10);
        if (pid > 0) initProductField(el, pid);
    });

    // Initialiser les images produit inline
    document.querySelectorAll('[data-product-img][data-product-id]').forEach(function (img) {
        var pid = parseInt(img.getAttribute('data-product-id'), 10);
        if (pid > 0) initProductImage(img, pid);
    });

})();
