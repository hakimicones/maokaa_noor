(function () {
    const config = window.__contentEditorConfig;

    if (!config || typeof grapesjs === 'undefined' || typeof DOMPurify === 'undefined') {
        return;
    }

    const editor = grapesjs.init({
        container: '#' + config.editorContainerId,
        height: '760px',
        width: '100%',
        fromElement: false,
        storageManager: false,
        plugins: [
            'grapesjs-plugin-export',
            'grapesjs-style-bg',
            'grapesjs-custom-code'
        ],
        pluginsOpts: {
            'grapesjs-plugin-export': {},
            'grapesjs-style-bg': {},
            'grapesjs-custom-code': {}
        },
        canvas: {
            scripts: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
                'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js'
            ],
            styles: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
                config.baseUrl + 'assets/css/style.css'
            ]
        },
        assetManager: {
            assets: config.assets || [],
            upload: config.uploadUrl || false,
            uploadName: 'file',
            multiUpload: false,
            showUrlInput: true
        },
        blockManager: {}
    });

    const registerBlocks = function () {
        const blocks = [
            {
                id: 'hero-section',
                label: 'Hero',
                category: 'Blocs',
                content: '<section class="py-5 bg-light rounded-3"><div class="container"><div class="row align-items-center g-4"><div class="col-lg-6"><p class="text-primary fw-semibold mb-2">Nouveau bloc</p><h1 class="display-5 fw-bold mb-3">Titre principal</h1><p class="lead text-muted mb-4">Ajoutez ici votre accroche, une description courte et un appel a l\'action.</p><div class="d-flex gap-2"><a href="#" class="btn btn-primary btn-lg">En savoir plus</a><a href="#" class="btn btn-outline-secondary btn-lg">Contact</a></div></div><div class="col-lg-6"><div class="bg-white rounded-3 shadow-sm p-4 border"><p class="mb-0 text-muted">Zone visuelle pour une image, une illustration ou un temoignage.</p></div></div></div></div></section>'
            },
            {
                id: 'two-columns',
                label: 'Deux colonnes',
                category: 'Blocs',
                content: '<div class="row g-4"><div class="col-md-6"><div class="p-4 bg-light rounded-3 h-100"><h3 class="h4">Colonne gauche</h3><p class="text-muted mb-0">Ajoutez un texte, une liste ou une mise en avant.</p></div></div><div class="col-md-6"><div class="p-4 bg-light rounded-3 h-100"><h3 class="h4">Colonne droite</h3><p class="text-muted mb-0">Ajoutez un second bloc de contenu coherent avec votre page.</p></div></div></div>'
            },
             {
                id: 'two-columns-8-4',
                label: 'Deux colonnes 2-1',
                category: 'Blocs',
                content: '<div class="row g-4"><div class="col-md-8"><div class="p-4 bg-light rounded-3 h-100"><h3 class="h4">Colonne gauche</h3><p class="text-muted mb-0">Ajoutez un texte, une liste ou une mise en avant.</p></div></div><div class="col-md-4"><div class="p-4 bg-light rounded-3 h-100"><h3 class="h4">Colonne droite</h3><p class="text-muted mb-0">Ajoutez un second bloc de contenu coherent avec votre page.</p></div></div></div>'
            },
            {
                id: 'one-columns-12',
                label: 'Une colonnes ',
                category: 'Blocs',
                content: '<div class="row g-4"><div class="col-md-12"> <h2 class="h3 mb-3">Sous-titre</h2>  </div>'
            },
            {
                id: 'text-block',
                label: 'Texte',
                category: 'Blocs',
                content: '<div class="py-4"><h2 class="h3 mb-3">Sous-titre</h2><p class="text-muted mb-0">Ecrivez ici votre paragraphe avec un style pret a l\'emploi.</p></div>'
            },
            {
                id: 'cta-block',
                label: 'Call to action',
                category: 'Blocs',
                content: '<section class="py-5 text-center"><div class="container"><h2 class="h3 mb-3">Interessez vos visiteurs</h2><p class="text-muted mb-4">Ajoutez une incitation claire pour diriger l\'utilisateur vers votre action principale.</p><a href="#" class="btn btn-primary btn-lg">Appeler a l\'action</a></div></section>'
            },
            {
                id: 'image-card',
                label: 'Image',
                category: 'Blocs',
                content: '<div class="text-center py-3"><img src="https://via.placeholder.com/1200x600" alt="Image de demonstration" class="img-fluid rounded-3 shadow-sm"></div>'
            },
            {
                id: 'vep-featured-products',
                label: 'Produits Populaires',
                category: 'Contenu Dynamique ',
                content: '<div data-vep-block="featured-products" data-limit="6" style="background:#e8f4fd;border:2px dashed #2196F3;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-box-open" style="font-size:40px;color:#2196F3;margin-bottom:12px;"></i><strong style="color:#1565C0;font-size:16px;">Produits Populaires</strong><small style="color:#5c85b8;margin-top:6px;display:block;font-size:13px;">6 produits mis en avant depuis la DB</small></div>'
            },
            {
                id: 'vep-products',
                label: 'Catalogue Produits ',
                category: 'Contenu Dynamique ',
                content: '<div data-vep-block="products" data-limit="12" style="background:#e8f4fd;border:2px dashed #2196F3;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-th-large" style="font-size:40px;color:#2196F3;margin-bottom:12px;"></i><strong style="color:#1565C0;font-size:16px;">Catalogue Produits</strong><small style="color:#5c85b8;margin-top:6px;display:block;font-size:13px;">Tous les produits actifs</small></div>'
            },
            {
                id: 'vep-news',
                label: 'Actualites',
                category: 'Contenu Dynamique ',
                content: '<div data-vep-block="news" data-limit="3" style="background:#fef9e7;border:2px dashed #FF9800;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-newspaper" style="font-size:40px;color:#FF9800;margin-bottom:12px;"></i><strong style="color:#E65100;font-size:16px;">Dernieres Actualites</strong><small style="color:#bf8040;margin-top:6px;display:block;font-size:13px;">3 articles recents depuis la DB</small></div>'
            },
            {
                id: 'vep-brands',
                label: 'Marques',
                category: 'Contenu Dynamique ',
                content: '<div class="row g-4"  data-vep-block="brands" style="background:#f3e5f5;border:2px dashed #9C27B0;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-award" style="font-size:40px;color:#9C27B0;margin-bottom:12px;"></i><strong style="color:#6A1B9A;font-size:16px;">Nos Marques</strong><small style="color:#8a56a0;margin-top:6px;display:block;font-size:13px;">Toutes les marques actives depuis la DB</small></div>'
            },
            {
                id: 'vep-brands-carousel',
                label: 'Marques Carousel',
                category: 'Contenu Dynamique ',
                content: '<div class="row g-4" data-vep-block="brands-carousel" style="background:#f3e5f5;border:2px dashed #9C27B0;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-images" style="font-size:40px;color:#9C27B0;margin-bottom:12px;"></i><strong style="color:#6A1B9A;font-size:16px;">Marques Carousel</strong><small style="color:#8a56a0;margin-top:6px;display:block;font-size:13px;">Marques en carousel depuis la DB</small></div>'
            },
            {
                id: 'vep-partners',
                label: 'Partenaires',
                category: 'Contenu Dynamique ',
                content: '<div data-vep-block="partners" style="background:#e8f5e9;border:2px dashed #4CAF50;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-handshake" style="font-size:40px;color:#4CAF50;margin-bottom:12px;"></i><strong style="color:#2E7D32;font-size:16px;">Nos Partenaires</strong><small style="color:#558855;margin-top:6px;display:block;font-size:13px;">Tous les partenaires actifs depuis la DB</small></div>'
            },
            {
                id: 'vep-contact-form',
                label: 'Formulaire de Contact',
                category: 'Contenu Dynamique ',
                content: '<div class="row g-4" data-vep-block="contact-form" style="background:#fce4ec;border:2px dashed #E91E63;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-envelope" style="font-size:40px;color:#E91E63;margin-bottom:12px;"></i><strong style="color:#880E4F;font-size:16px;">Formulaire de Contact</strong><small style="color:#b05070;margin-top:6px;display:block;font-size:13px;">Connecte a la table contacts</small></div>'
            },
            {
                id: 'bs-carousel',
                label: 'Carousel',
                category: 'Caroussel',
                content: '<div class="row g-4"data-vep-block="carousel" data-slider-id="1" style="background:#e3f2fd;border:2px dashed #2196F3;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-images" style="font-size:40px;color:#2196F3;margin-bottom:12px;"></i><strong style="color:#1565C0;font-size:16px;">Carousel #1</strong><small style="color:#5c85b8;margin-top:6px;display:block;font-size:13px;">Slider depuis la DB</small></div>'
            }

        ];


        



        blocks.forEach((block) => {
            editor.BlockManager.add(block.id, {
                label: block.label,
                category: block.category,
                content: block.content,
                activate: true,
                select: true
            });
        });
    };

    registerBlocks();

    editor.Commands.add('import-template', {
        run: function(ed) {
            var modal = ed.Modal;
            var container = document.createElement('div');
            container.innerHTML =
                '<p style="font-size:13px;margin-bottom:8px;">Collez votre HTML/CSS puis cliquez sur <strong>Importer</strong>.</p>' +
                '<textarea id="gjs-import-input" style="width:100%;height:250px;font-family:monospace;font-size:13px;padding:8px;box-sizing:border-box;border:1px solid #ccc;border-radius:4px;"></textarea>' +
                '<div style="text-align:right;margin-top:10px;"><button id="gjs-import-btn" style="padding:8px 18px;background:#2196F3;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:14px;">Importer</button></div>';
            modal.setTitle('Import Template');
            modal.setContent(container);
            modal.open();
            container.querySelector('#gjs-import-btn').addEventListener('click', function() {
                var val = container.querySelector('#gjs-import-input').value.trim();
                if (!val) return;

                try {
                    // Extraire les blocs <style> et les retirer du HTML
                    var cssBlocks = [];
                    var html = val.replace(/<style[^>]*>([\s\S]*?)<\/style>/gi, function(match, css) {
                        if (css.trim()) cssBlocks.push(css.trim());
                        return '';
                    });
                    html = html.trim();

                    var cssComposer = ed.CssComposer;

                    function parseDeclarations(cssText) {
                        var styles = {};
                        cssText.split(';').forEach(function(decl) {
                            var idx = decl.indexOf(':');
                            if (idx > 0) {
                                var key = decl.substring(0, idx).trim();
                                var val = decl.substring(idx + 1).trim();
                                if (key) styles[key] = val;
                            }
                        });
                        return styles;
                    }

                    // Parser CSS qui gère @media et les commentaires /* */
                    function importCss(css, mediaText) {
                        css = css.replace(/\/\*[\s\S]*?\*\//g, '');

                        var blocks = [];
                        var depth = 0;
                        var buf = '';
                        for (var i = 0; i < css.length; i++) {
                            var ch = css[i];
                            if (ch === '{') {
                                buf += ch;
                                depth++;
                            } else if (ch === '}') {
                                depth--;
                                buf += ch;
                                if (depth === 0) {
                                    blocks.push(buf);
                                    buf = '';
                                }
                            } else if (ch !== '\n' && ch !== '\r') {
                                buf += ch;
                            }
                        }
                        if (buf.trim()) blocks.push(buf);

                        blocks.forEach(function(block) {
                            block = block.trim();
                            if (!block) return;

                            var braceIdx = block.indexOf('{');
                            if (braceIdx === -1) return;

                            var pre = block.substring(0, braceIdx).trim();
                            var body = block.substring(braceIdx + 1, block.lastIndexOf('}'));

                            if (pre.indexOf('@media') === 0) {
                                var cond = pre.replace(/@media\s*/i, '').trim();
                                importCss(body, cond);
                            } else if (pre.indexOf('@') === 0) {
                                return;
                            } else {
                                var selector = pre.replace(/\s+/g, ' ').trim();
                                if (!selector) return;
                                var styles = parseDeclarations(body);
                                if (Object.keys(styles).length > 0) {
                                    try {
                                        var opts = {};
                                        if (mediaText) {
                                            opts.atRuleType = 'media';
                                            opts.mediaText = mediaText;
                                        }
                                        cssComposer.add(selector, styles, opts);
                                    } catch(e) {
                                        console.warn('CSS import error:', selector, e);
                                    }
                                }
                            }
                        });
                    }

                    cssBlocks.forEach(function(css) {
                        importCss(css);
                    });

                    if (html) {
                        ed.setComponents(html);
                    }
                    modal.close();
                } catch(e) {
                    console.error('Import error:', e);
                    alert('Erreur lors de l\'import : ' + e.message);
                }
            });
        }
    });

    editor.Panels.addButton('options', {
        id: 'import-template',
        command: 'import-template',
        className: 'fa fa-upload',
        attributes: { title: 'Import Template' }
    });

    function openAiModal(opts) {
        var existing = document.getElementById('ai-modal-overlay');
        if (existing) existing.remove();

        var overlay = document.createElement('div');
        overlay.id = 'ai-modal-overlay';
        overlay.className = 'ai-modal-overlay';
        overlay.innerHTML =
            '<div class="ai-modal-dialog">' +
                '<div class="ai-modal-header">' +
                    '<span><i class="fas fa-magic"></i> Assistant IA</span>' +
                    '<button type="button" class="ai-modal-close" aria-label="Fermer">&times;</button>' +
                '</div>' +
                '<div class="ai-modal-body">' +
                    '<label for="ai-modal-instruction">Instruction pour l\'IA</label>' +
                    '<textarea id="ai-modal-instruction" rows="4" placeholder="Ex: Réécris cette page avec un ton plus commercial et ajoute une section avantages."></textarea>' +
                    '<div class="ai-modal-status"></div>' +
                '</div>' +
                '<div class="ai-modal-footer">' +
                    '<button type="button" class="btn btn-outline-secondary btn-sm ai-modal-cancel">Annuler</button>' +
                    '<button type="button" class="btn btn-primary btn-sm ai-modal-generate">Générer</button>' +
                '</div>' +
            '</div>';

        document.body.appendChild(overlay);

        var statusEl = overlay.querySelector('.ai-modal-status');
        var textarea = overlay.querySelector('#ai-modal-instruction');
        var generateBtn = overlay.querySelector('.ai-modal-generate');

        function close() { overlay.remove(); }

        overlay.querySelector('.ai-modal-close').addEventListener('click', close);
        overlay.querySelector('.ai-modal-cancel').addEventListener('click', close);
        overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });

        generateBtn.addEventListener('click', function () {
            var instruction = textarea.value.trim();
            if (!instruction) {
                statusEl.textContent = 'Veuillez saisir une instruction.';
                statusEl.className = 'ai-modal-status ai-modal-error';
                return;
            }

            generateBtn.disabled = true;
            statusEl.textContent = 'Génération en cours...';
            statusEl.className = 'ai-modal-status ai-modal-loading';

            fetch(opts.aiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    csrf_token: opts.csrfToken,
                    html: opts.getHtml(),
                    instruction: instruction
                })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                generateBtn.disabled = false;
                if (data.success) {
                    opts.onApply(data.html);
                    close();
                } else {
                    statusEl.textContent = data.message || 'Erreur inconnue';
                    statusEl.className = 'ai-modal-status ai-modal-error';
                }
            })
            .catch(function () {
                generateBtn.disabled = false;
                statusEl.textContent = 'Erreur de connexion au serveur';
                statusEl.className = 'ai-modal-status ai-modal-error';
            });
        });

        textarea.focus();
    }

    editor.Commands.add('ai-rewrite', {
        run: function (ed) {
            openAiModal({
                csrfToken: config.csrfToken,
                aiUrl: config.aiUrl,
                getHtml: function () { return blocksToShortcodes(ed.getHtml()); },
                onApply: function (newHtml) {
                    ed.setComponents(shortcodesToBlocks(newHtml));
                    syncBody();
                }
            });
        }
    });

    editor.Panels.addButton('options', {
        id: 'ai-rewrite',
        command: 'ai-rewrite',
        className: 'fa fa-magic',
        attributes: { title: 'Assistant IA' }
    });

    function initSplideInCanvas() {
        try {
            var canvasWin = editor.Canvas.getWindow();
            if (!canvasWin || !canvasWin.Splide) return;
            canvasWin.document.querySelectorAll('.splide:not(.is-initialized)').forEach(function(el) {
                if (el.classList.contains('brands-carousel')) {
                    new canvasWin.Splide(el, {
                        type: 'loop',
                        perPage: 5,
                        perMove: 1,
                        autoplay: true,
                        interval: 3000,
                        pauseOnHover: true,
                        gap: '24px',
                        breakpoints: { 992: { perPage: 3 }, 576: { perPage: 2 } },
                        pagination: false,
                        arrows: true
                    }).mount();
                } else {
                    new canvasWin.Splide(el, {
                        type: 'fade',
                        autoplay: true,
                        interval: 4000,
                        pauseOnHover: true,
                        rewind: true,
                        cover: true,
                        heightRatio: 0.4
                    }).mount();
                }
            });
        } catch(e) {
            console.warn('Splide canvas init error:', e);
        }
    }

    const loadVepBlockPreview = function(component) {
        const content = component.toHTML();
        const match = content.match(/data-vep-block="([^"]+)"/);
        if (!match) return;

        const blockType = match[1];
        const limitMatch = content.match(/data-limit="(\d+)"/);
        const limit = limitMatch ? limitMatch[1] : '6';
        const categoryMatch = content.match(/data-category="(\d+)"/);
        const category = categoryMatch ? categoryMatch[1] : '0';
        const sliderIdMatch = content.match(/data-slider-id="(\d+)"/);
        const sliderId = sliderIdMatch ? sliderIdMatch[1] : '0';

        fetch(config.baseUrl + 'admin/content/preview-block.php?type=' + blockType + '&limit=' + limit + '&category=' + category + '&slider_id=' + sliderId)
            .then(r => r.json())
            .then(data => {
                if (data.html) {
                    component.components(data.html);
                    if (data.html.includes('splide')) {
                        setTimeout(initSplideInCanvas, 900);
                    }
                }
            })
            .catch(err => console.error('Preview load error:', err));
    };

    editor.on('component:add', function(component) {
        const html = component.toHTML();
        if (html.includes('data-vep-block')) {
            setTimeout(() => loadVepBlockPreview(component), 100);
        }
    });

    // Convertit [shortcode attr="val"] en divs data-vep-block pour l'éditeur
    function shortcodesToBlocks(html) {
        return html.replace(/\[([a-z_]+)((?:\s+[a-z_]+="[^"]*")*)\s*\]/g, function(match, tag, attrsStr) {
            var attrs = {};
            var re = /([a-z_]+)="([^"]*)"/g, m;
            while ((m = re.exec(attrsStr)) !== null) attrs[m[1]] = m[2];

            var blockType = tag.replace(/_/g, '-');
            var dataAttrs = 'data-vep-block="' + blockType + '"';
            for (var k in attrs) {
                dataAttrs += ' data-' + k.replace(/_/g, '-') + '="' + attrs[k] + '"';
            }
            return '<div ' + dataAttrs + ' style="background:#e8f4fd;border:2px dashed #2196F3;border-radius:8px;padding:24px;text-align:center;min-height:80px;display:flex;align-items:center;justify-content:center;"><span style="color:#1565C0;font-weight:bold;">[' + tag + ']</span></div>';
        });
    }

    // Convertit les divs data-vep-block en shortcodes [tag attr="val"] pour la sauvegarde
    function blocksToShortcodes(html) {
        var temp = document.createElement('div');
        temp.innerHTML = html;
        var blocks = Array.from(temp.querySelectorAll('[data-vep-block]'));
        var replacements = {};

        blocks.forEach(function(el, i) {
            var blockType = el.getAttribute('data-vep-block');
            var tag = blockType.replace(/-/g, '_');
            var sc = '[' + tag;
            for (var j = 0; j < el.attributes.length; j++) {
                var attr = el.attributes[j];
                if (attr.name.startsWith('data-') && attr.name !== 'data-vep-block') {
                    var attrName = attr.name.slice(5).replace(/-/g, '_');
                    if (attr.value !== '') sc += ' ' + attrName + '="' + attr.value + '"';
                }
            }
            sc += ']';
            var marker = 'SCMARKER' + i + 'END';
            replacements[marker] = sc;
            el.replaceWith(document.createTextNode(marker));
        });

        var result = temp.innerHTML;
        for (var marker in replacements) {
            result = result.split(marker).join(replacements[marker]);
        }
        return result;
    }

    var defaultContent = '<section class="container py-5"><div class="row"><div class="col-lg-8"><h1>Votre nouvelle page</h1><p>Ajoutez vos blocs ici.</p></div></div></section>';
    var initialHtml = shortcodesToBlocks(config.initialBody || defaultContent);
    editor.setComponents(initialHtml);

    editor.on('load', function() {
        editor.getComponents().forEach(function(comp) {
            if (comp.toHTML().includes('data-vep-block')) {
                loadVepBlockPreview(comp);
            }
        });
    });

    const hiddenInput = document.getElementById(config.hiddenInputId);

    if (!hiddenInput) {
        return;
    }

    var syncBody = function () {
        var rawHtml = editor.getHtml();
        var withShortcodes = blocksToShortcodes(rawHtml);
        var cleanHtml = DOMPurify.sanitize(withShortcodes, {
            USE_PROFILES: { html: true },
            FORCE_BODY: false,
            ALLOWED_ATTR: ['class', 'id', 'style', 'href', 'src', 'alt', 'target', 'rel',
                           'data-limit', 'data-category', 'data-title', 'data-slider-id',
                           'data-vep-block', 'data-inline-field',
                           'role', 'aria-label', 'aria-current', 'type', 'name', 'value',
                           'placeholder', 'required', 'method', 'action', 'enctype']
        });
        hiddenInput.value = cleanHtml;
    };

    editor.on('component:update', syncBody);
    editor.on('component:add', syncBody);
    editor.on('component:remove', syncBody);

    const form = hiddenInput.closest('form');

    if (form) {
        form.addEventListener('submit', function () {
            syncBody();
        });
    }

    syncBody();
})();
