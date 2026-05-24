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
        canvas: {
            styles: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
            ]
        },
        blockManager: {}
    });

    const registerBlocks = function () {
        const blocks = [
            {
                id: 'hero-section',
                label: 'Hero',
                category: 'Blocs',
                content: `<section class="py-5 bg-light rounded-3">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <p class="text-primary fw-semibold mb-2">Nouveau bloc</p>
                <h1 class="display-5 fw-bold mb-3">Titre principal</h1>
                <p class="lead text-muted mb-4">Ajoutez ici votre accroche, une description courte et un appel à l’action.</p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-primary btn-lg">En savoir plus</a>
                    <a href="#" class="btn btn-outline-secondary btn-lg">Contact</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white rounded-3 shadow-sm p-4 border">
                    <p class="mb-0 text-muted">Zone visuelle pour une image, une illustration ou un témoignage.</p>
                </div>
            </div>
        </div>
    </div>
</section>`
            },
            {
                id: 'two-columns',
                label: 'Deux colonnes',
                category: 'Blocs',
                content: `<div class="row g-4">
    <div class="col-md-6">
        <div class="p-4 bg-light rounded-3 h-100">
            <h3 class="h4">Colonne gauche</h3>
            <p class="text-muted mb-0">Ajoutez un texte, une liste ou une mise en avant.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-4 bg-light rounded-3 h-100">
            <h3 class="h4">Colonne droite</h3>
            <p class="text-muted mb-0">Ajoutez un second bloc de contenu cohérent avec votre page.</p>
        </div>
    </div>
</div>`
            },
            {
                id: 'text-block',
                label: 'Texte',
                category: 'Blocs',
                content: `<div class="py-4">
    <h2 class="h3 mb-3">Sous-titre</h2>
    <p class="text-muted mb-0">Écrivez ici votre paragraphe avec un style prêt à l’emploi.</p>
</div>`
            },
            {
                id: 'cta-block',
                label: 'Call to action',
                category: 'Blocs',
                content: `<section class="py-5 text-center">
    <div class="container">
        <h2 class="h3 mb-3">Intéressez vos visiteurs</h2>
        <p class="text-muted mb-4">Ajoutez une incitation claire pour diriger l’utilisateur vers votre action principale.</p>
        <a href="#" class="btn btn-primary btn-lg">Appeler à l’action</a>
    </div>
</section>`
            },
            {
                id: 'image-card',
                label: 'Image',
                category: 'Blocs',
                content: `<div class="text-center py-3">
    <img src="https://via.placeholder.com/1200x600" alt="Image de démonstration" class="img-fluid rounded-3 shadow-sm">
</div>`
            },
            {
                id: 'vep-featured-products',
                label: 'Produits Populaires',
                category: 'Contenu Dynamique VEP',
                content: `<div data-vep-block="featured-products" data-limit="6" style="background:#e8f4fd;border:2px dashed #2196F3;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-box-open" style="font-size:32px;color:#2196F3;margin-bottom:8px;"></i><strong style="color:#1565C0;">Produits Populaires</strong><small style="color:#5c85b8;margin-top:4px;display:block;">6 produits mis en avant depuis la DB</small></div>`
            },
            {
                id: 'vep-products',
                label: 'Catalogue Produits',
                category: 'Contenu Dynamique VEP',
                content: `<div data-vep-block="products" data-limit="12" style="background:#e8f4fd;border:2px dashed #2196F3;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-th-large" style="font-size:32px;color:#2196F3;margin-bottom:8px;"></i><strong style="color:#1565C0;">Catalogue Produits</strong><small style="color:#5c85b8;margin-top:4px;display:block;">Tous les produits actifs — modifier data-limit pour changer la limite</small></div>`
            },
            {
                id: 'vep-news',
                label: 'Actualités',
                category: 'Contenu Dynamique VEP',
                content: `<div data-vep-block="news" data-limit="3" style="background:#fef9e7;border:2px dashed #FF9800;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-newspaper" style="font-size:32px;color:#FF9800;margin-bottom:8px;"></i><strong style="color:#E65100;">Dernières Actualités</strong><small style="color:#bf8040;margin-top:4px;display:block;">3 articles récents depuis la DB</small></div>`
            },
            {
                id: 'vep-brands',
                label: 'Marques',
                category: 'Contenu Dynamique VEP',
                content: `<div data-vep-block="brands" style="background:#f3e5f5;border:2px dashed #9C27B0;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-award" style="font-size:32px;color:#9C27B0;margin-bottom:8px;"></i><strong style="color:#6A1B9A;">Nos Marques</strong><small style="color:#8a56a0;margin-top:4px;display:block;">Toutes les marques actives depuis la DB</small></div>`
            },
            {
                id: 'vep-partners',
                label: 'Partenaires',
                category: 'Contenu Dynamique VEP',
                content: `<div data-vep-block="partners" style="background:#e8f5e9;border:2px dashed #4CAF50;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-handshake" style="font-size:32px;color:#4CAF50;margin-bottom:8px;"></i><strong style="color:#2E7D32;">Nos Partenaires</strong><small style="color:#558855;margin-top:4px;display:block;">Tous les partenaires actifs depuis la DB</small></div>`
            },
            {
                id: 'vep-contact-form',
                label: 'Formulaire de Contact',
                category: 'Contenu Dynamique VEP',
                content: `<div data-vep-block="contact-form" style="background:#fce4ec;border:2px dashed #E91E63;border-radius:8px;padding:24px;text-align:center;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;"><i class="fas fa-envelope" style="font-size:32px;color:#E91E63;margin-bottom:8px;"></i><strong style="color:#880E4F;">Formulaire de Contact</strong><small style="color:#b05070;margin-top:4px;display:block;">Connecté à la table contacts</small></div>`
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

    const defaultContent = '<section class="container py-5"><div class="row"><div class="col-lg-8"><h1>Votre nouvelle page</h1><p>Ajoutez vos blocs ici.</p></div></div></section>';
    editor.setComponents(config.initialBody || defaultContent);

    const hiddenInput = document.getElementById(config.hiddenInputId);

    if (!hiddenInput) {
        return;
    }

    const syncBody = function () {
        const cleanHtml = DOMPurify.sanitize(editor.getHtml(), {
            USE_PROFILES: { html: true }
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
