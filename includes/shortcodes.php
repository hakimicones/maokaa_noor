<?php
// includes/shortcodes.php — Moteur de shortcodes et blocs dynamiques

/**
 * Traite les shortcodes [tag attr="val"] et les blocs data-vep-block legacy dans le HTML.
 */
function do_shortcode(string $html, PDO $pdo): string
{
    if (empty($html)) return '';

    // Shortcodes WordPress-style : [tag attr="val"]
    $html = preg_replace_callback(
        '/\[([a-z_]+)((?:\s+[a-z_]+=\s*"[^"]*")*)\s*\]/',
        function (array $m) use ($pdo): string {
            return render_shortcode($m[1], parse_shortcode_atts($m[2]), $pdo);
        },
        $html
    );

    // Blocs legacy GrapesJS : <div data-vep-block="..." data-limit="6"></div>
    $html = preg_replace_callback(
        '/<div([^>]*\bdata-vep-block=["\'][^"\']+["\'][^>]*)>\s*<\/div>/i',
        function (array $m) use ($pdo): string {
            $attrs = _parse_vep_attrs($m[1]);
            $type  = str_replace('-', '_', $attrs['vep-block'] ?? '');
            unset($attrs['vep-block']);
            return render_shortcode($type, $attrs, $pdo);
        },
        $html
    );

    return $html ?? '';
}

// Alias pour compatibilité avec les templates existants
function process_vep_blocks(string $html, PDO $pdo): string
{
    return do_shortcode($html, $pdo);
}

function parse_shortcode_atts(string $text): array
{
    $atts = [];
    preg_match_all('/([a-z_]+)\s*=\s*"([^"]*)"/', $text, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) $atts[$m[1]] = $m[2];
    return $atts;
}

function render_shortcode(string $tag, array $atts, PDO $pdo): string
{
    $limit    = max(1, (int)($atts['limit']    ?? 6));
    $category = (int)($atts['category'] ?? 0);
    $title    = $atts['title'] ?? '';

    switch ($tag) {
        case 'products':          return render_block_products($pdo, $limit, $category, $title);
        case 'featured_products': return render_block_featured_products($pdo, $limit, $title);
        case 'news':              return render_block_news($pdo, $limit, $title);
        case 'brands':            return render_block_brands($pdo, $title);
        case 'partners':          return render_block_partners($pdo, $title);
        case 'contact_form':      return render_block_contact_form($pdo, $title);
        default:                  return '';
    }
}

// Parse les attributs data-* d'une balise HTML (usage interne)
function _parse_vep_attrs(string $attrString): array
{
    $result = [];
    preg_match_all('/\bdata-([\w-]+)=["\']([^"\']*)["\']/', $attrString, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) $result[$m[1]] = $m[2];
    return $result;
}

// --- Fonctions de rendu ---

function render_block_featured_products(PDO $pdo, int $limit = 6, string $blockTitle = ''): string
{
    require_once __DIR__ . '/../app/models/Product.php';
    $model = new Product($pdo);
    $items = $model->getFeatured($limit);
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/featured-products.php';
    return ob_get_clean();
}

function render_block_products(PDO $pdo, int $limit = 12, int $category = 0, string $blockTitle = ''): string
{
    require_once __DIR__ . '/../app/models/Product.php';
    $model = new Product($pdo);
    $items = $category > 0 ? $model->getByCategory($category, $limit) : $model->getAll(true, $limit);
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/products.php';
    return ob_get_clean();
}

function render_block_news(PDO $pdo, int $limit = 3, string $blockTitle = ''): string
{
    require_once __DIR__ . '/../app/models/News.php';
    $model = new News($pdo);
    $items = $model->getRecent($limit);
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/news.php';
    return ob_get_clean();
}

function render_block_brands(PDO $pdo, string $blockTitle = ''): string
{
    require_once __DIR__ . '/../app/models/Brand.php';
    $model = new Brand($pdo);
    $items = $model->getAll();
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/brands.php';
    return ob_get_clean();
}

function render_block_partners(PDO $pdo, string $blockTitle = ''): string
{
    require_once __DIR__ . '/../app/models/Partner.php';
    $model = new Partner($pdo);
    $items = $model->getAll();
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/partners.php';
    return ob_get_clean();
}

function render_block_contact_form(PDO $pdo, string $blockTitle = ''): string
{
    require_once __DIR__ . '/../app/models/Contact.php';
    $formSent  = false;
    $formError = '';
    $formData  = [];

    if (($_POST['vep_contact_form'] ?? '') === '1') {
        if (!function_exists('verifyCSRFToken') || !verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            $formError = 'Token de sécurité invalide.';
        } else {
            $formData = [
                'nom'       => trim($_POST['contact_nom']       ?? ''),
                'email'     => trim($_POST['contact_email']     ?? ''),
                'telephone' => trim($_POST['contact_telephone'] ?? ''),
                'sujet'     => trim($_POST['contact_sujet']     ?? ''),
                'message'   => trim($_POST['contact_message']   ?? ''),
            ];
            if (empty($formData['nom']) || empty($formData['email']) || empty($formData['message'])) {
                $formError = 'Veuillez remplir les champs obligatoires (nom, email, message).';
            } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $formError = 'Adresse email invalide.';
            } else {
                $model = new Contact($pdo);
                if ($model->create($formData)) {
                    $formSent = true;
                    $formData = [];
                } else {
                    $formError = "Erreur lors de l'envoi du message.";
                }
            }
        }
    }

    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/contact-form.php';
    return ob_get_clean();
}
