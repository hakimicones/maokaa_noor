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
        plugins: ['grapesjs-preset-webpage', 'grapesjs-plugin-export', 'grapesjs-style-bg', 'grapesjs-custom-code'],
        pluginsOpts: {
            'grapesjs-plugin-export': {},
            'grapesjs-style-bg': {},
            'grapesjs-custom-code': {},
            'grapesjs-preset-webpage': {
            modalImportTitle: 'Import Template',
            modalImportLabel: '<div style="margin-bottom: 10px; font-size: 13px;">Paste here your HTML/CSS and click Import</div>',
            modalImportContent: function(editor) {return editor.getHtml() + '<style>'+editor.getCss()+'</style>'  },
			
          }
        },
        canvas: {
            styles: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
                '/Hebergement/maokaa/assets/css/style.css'
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
                content: '<div data-vep-block="brands" style="background:#f3e5f5;border:2px dashed #9C27B0;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-award" style="font-size:40px;color:#9C27B0;margin-bottom:12px;"></i><strong style="color:#6A1B9A;font-size:16px;">Nos Marques</strong><small style="color:#8a56a0;margin-top:6px;display:block;font-size:13px;">Toutes les marques actives depuis la DB</small></div>'
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
                content: '<div data-vep-block="contact-form" style="background:#fce4ec;border:2px dashed #E91E63;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-envelope" style="font-size:40px;color:#E91E63;margin-bottom:12px;"></i><strong style="color:#880E4F;font-size:16px;">Formulaire de Contact</strong><small style="color:#b05070;margin-top:6px;display:block;font-size:13px;">Connecte a la table contacts</small></div>'
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

    const loadVepBlockPreview = function(component) {
        const content = component.toHTML();
        const match = content.match(/data-vep-block="([^"]+)"/);
        if (!match) return;

        const blockType = match[1];
        const limitMatch = content.match(/data-limit="(\d+)"/);
        const limit = limitMatch ? limitMatch[1] : '6';
        const categoryMatch = content.match(/data-category="(\d+)"/);
        const category = categoryMatch ? categoryMatch[1] : '0';

        fetch('/Hebergement/maokaa/admin/content/preview-block.php?type=' + blockType + '&limit=' + limit + '&category=' + category)
            .then(r => r.json())
            .then(data => {
                if (data.html) {
                    component.setContent(data.html);
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
                           'data-limit', 'data-category', 'data-title',
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
