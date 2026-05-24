<?php
// includes/shortcodes.php — Server-side dynamic block engine for GrapesJS body HTML

function parse_vep_attrs(string $attrString): array {
    $result = [];
    preg_match_all('/\bdata-([\w-]+)=["\']([^"\']*)["\']/', $attrString, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $result[$match[1]] = $match[2];
    }
    return $result;
}

function process_vep_blocks(string $html, PDO $pdo): string {
    if (empty($html)) {
        return '';
    }
    $pattern = '/<div([^>]*\bdata-vep-block=["\'][^"\']+["\'][^>]*)>\s*<\/div>/i';
    $result = preg_replace_callback($pattern, function (array $m) use ($pdo): string {
        $attrs    = parse_vep_attrs($m[1]);
        $type     = $attrs['vep-block'] ?? '';
        $limit    = max(1, (int)($attrs['limit'] ?? 6));
        $category = (int)($attrs['category'] ?? 0);
        $title    = $attrs['title'] ?? '';
        switch ($type) {
            case 'featured-products': return render_block_featured_products($pdo, $limit, $title);
            case 'products':          return render_block_products($pdo, $limit, $category, $title);
            case 'news':              return render_block_news($pdo, $limit, $title);
            case 'brands':            return render_block_brands($pdo, $title);
            case 'partners':          return render_block_partners($pdo, $title);
            case 'contact-form':      return render_block_contact_form($pdo, $title);
            default:                  return '<!-- vep-block inconnu: ' . htmlspecialchars($type) . ' -->';
        }
    }, $html);
    return $result ?? $html;
}

function render_block_featured_products(PDO $pdo, int $limit, string $blockTitle): string {
    require_once __DIR__ . '/../app/models/Product.php';
    $model = new Product($pdo);
    $items = $model->getFeatured($limit);
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/featured-products.php';
    return ob_get_clean();
}

function render_block_products(PDO $pdo, int $limit, int $category, string $blockTitle): string {
    require_once __DIR__ . '/../app/models/Product.php';
    $model = new Product($pdo);
    $items = $category > 0 ? $model->getByCategory($category, $limit) : $model->getAll(true, $limit);
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/products.php';
    return ob_get_clean();
}

function render_block_news(PDO $pdo, int $limit, string $blockTitle): string {
    require_once __DIR__ . '/../app/models/News.php';
    $model = new News($pdo);
    $items = $model->getRecent($limit);
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/news.php';
    return ob_get_clean();
}

function render_block_brands(PDO $pdo, string $blockTitle): string {
    require_once __DIR__ . '/../app/models/Brand.php';
    $model = new Brand($pdo);
    $items = $model->getAll();
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/brands.php';
    return ob_get_clean();
}

function render_block_partners(PDO $pdo, string $blockTitle): string {
    require_once __DIR__ . '/../app/models/Partner.php';
    $model = new Partner($pdo);
    $items = $model->getAll();
    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/partners.php';
    return ob_get_clean();
}

function render_block_contact_form(PDO $pdo, string $blockTitle): string {
    require_once __DIR__ . '/../app/models/Contact.php';
    $formSent  = false;
    $formError = '';
    $formData  = [];

    if (($_POST['vep_contact_form'] ?? '') === '1') {
        if (!function_exists('verifyCSRFToken') || !verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            $formError = 'Token de sécurité invalide.';
        } else {
            $formData = [
                'nom'       => trim($_POST['contact_nom'] ?? ''),
                'email'     => trim($_POST['contact_email'] ?? ''),
                'telephone' => trim($_POST['contact_telephone'] ?? ''),
                'sujet'     => trim($_POST['contact_sujet'] ?? ''),
                'message'   => trim($_POST['contact_message'] ?? ''),
            ];
            if (empty($formData['nom']) || empty($formData['email']) || empty($formData['message'])) {
                $formError = 'Veuillez remplir les champs obligatoires (nom, email, message).';
            } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $formError = 'Adresse email invalide.';
            } else {
                $model = new Contact($pdo);
                if ($model->create($formData)) {
                    $formSent  = true;
                    $formData  = [];
                } else {
                    $formError = 'Erreur lors de l\'envoi du message.';
                }
            }
        }
    }

    ob_start();
    include __DIR__ . '/../app/views/partials/blocks/contact-form.php';
    return ob_get_clean();
}
