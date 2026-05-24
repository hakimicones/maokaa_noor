<?php
// setup.php
// Script d'initialisation de la base de données - Lancer une seule fois!
// Accès: http://localhost/vep/setup.php

if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'])) {
    http_response_code(403);
    die('<h1>403 Forbidden</h1><p>Ce script ne peut être exécuté que depuis localhost.</p>');
}

require_once 'includes/config.php';
require_once 'includes/db.php';

// Importer et exécuter le schéma
$schema = file_get_contents(__DIR__ . '/db/shema.sql');
$statements = explode(';', $schema);

foreach ($statements as $statement) {
    $statement = trim($statement);
    if (!empty($statement)) {
        try {
            $pdo->exec($statement);
        } catch (Exception $e) {
            // Ignorer les erreurs (ex: tables qui existent déjà)
        }
    }
}

// Insérer les pages CMS de base
$pages = [
    [
        'slug' => 'home',
        'title' => 'Accueil',
        'subtitle' => 'Bienvenue chez VEP',
        'meta_title' => 'Accueil - VEP',
        'meta_description' => 'VEP - Votre partenaire incontournable du laboratoire en Algérie',
        'template' => 'home',
        'status' => 'published'
    ],
    [
        'slug' => 'about',
        'title' => 'À propos de VEP',
        'meta_title' => 'À propos - VEP',
        'meta_description' => 'Découvrez l\'histoire et les valeurs de VEP',
        'body' => '<h2>Notre Histoire</h2><p>VEP a été fondée il y a plus de 20 ans avec la vision de devenir le partenaire incontournable des laboratoires en Algérie.</p><h2>Notre Mission</h2><p>Fournir des équipements et consommables de laboratoire de haute qualité avec un service client exceptionnel.</p><h2>Notre Vision</h2><p>Être le leader incontesté dans l\'importation et la distribution de matériels de laboratoire en Algérie et en Afrique du Nord.</p><h2>Nos Valeurs</h2><ul><li><strong>Qualité:</strong> Tous nos produits sont certifiés et garantis</li><li><strong>Intégrité:</strong> Nous opérons avec transparence et honnêteté</li><li><strong>Innovation:</strong> Nous cherchons constamment à améliorer nos services</li><li><strong>Service Client:</strong> La satisfaction de nos clients est notre priorité</li></ul>',
        'template' => 'default',
        'status' => 'published'
    ],
    [
        'slug' => 'products',
        'title' => 'Nos Produits',
        'meta_title' => 'Produits - VEP',
        'meta_description' => 'Découvrez notre large gamme de produits de laboratoire',
        'body' => '<h2>Catalogue de Produits</h2><p>VEP propose une large gamme de matériels et consommables pour laboratoires, répartis en 18 catégories.</p><p>Utilisez les filtres ci-dessous pour trouver les produits que vous recherchez.</p>',
        'template' => 'products',
        'status' => 'published'
    ],
    [
        'slug' => 'brands',
        'title' => 'Nos Marques',
        'meta_title' => 'Marques Partenaires - VEP',
        'meta_description' => 'Découvrez nos marques partenaires',
        'body' => '<h2>Partenaires Mondiaux</h2><p>VEP représente les plus grandes marques de laboratoire au monde.</p>',
        'template' => 'default',
        'status' => 'published'
    ],
    [
        'slug' => 'partners',
        'title' => 'Nos Partenaires',
        'meta_title' => 'Partenaires - VEP',
        'meta_description' => 'Nos partenaires stratégiques',
        'body' => '<h2>Nos Partenaires</h2><p>VEP travaille avec les meilleures institutions en Algérie.</p>',
        'template' => 'default',
        'status' => 'published'
    ],
    [
        'slug' => 'news',
        'title' => 'Actualités',
        'meta_title' => 'Actualités - VEP',
        'meta_description' => 'Restez informé des dernières actualités de VEP',
        'body' => '<h2>Actualités et Événements</h2><p>Suivez toutes les actualités, nouveautés produits et événements de VEP.</p>',
        'template' => 'default',
        'status' => 'published'
    ],
    [
        'slug' => 'contact',
        'title' => 'Contact',
        'meta_title' => 'Contact - VEP',
        'meta_description' => 'Contactez VEP',
        'body' => '<h2>Nous Contacter</h2><p>N\'hésitez pas à nous contacter pour toute question ou demande.</p><h3>Coordonnées</h3><ul><li><strong>Téléphone:</strong> +213 (0) 123 456 789</li><li><strong>Email:</strong> contact@vep.dz</li><li><strong>Adresse:</strong> Alger, Algérie</li></ul><h3>Formulaire de Contact</h3><p>Remplissez le formulaire ci-dessous et nous vous recontacterons sous peu.</p>',
        'template' => 'default',
        'status' => 'published'
    ],
    [
        'slug' => '404',
        'title' => 'Page Non Trouvée',
        'meta_title' => '404 - Page Non Trouvée',
        'body' => '<div class="text-center py-5"><h1 class="display-1">404</h1><p class="fs-3"> <span class="text-danger">Oups!</span> La page que vous recherchez est introuvable.</p><p class="lead">La page a peut-être été supprimée ou l\'URL est incorrecte.</p><a href="' . BASE_URL . '" class="btn btn-primary">Retour à l\'accueil</a></div>',
        'template' => 'default',
        'status' => 'published'
    ]
];

// Insérer les pages
$stmt = $pdo->prepare(
    "INSERT IGNORE INTO content (slug, title, subtitle, meta_title, meta_description, body, template, status, language) 
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'fr')"
);

foreach ($pages as $page) {
    $stmt->execute([
        $page['slug'],
        $page['title'],
        $page['subtitle'] ?? '',
        $page['meta_title'] ?? '',
        $page['meta_description'] ?? '',
        $page['body'] ?? '',
        $page['template'] ?? 'default',
        $page['status'] ?? 'draft'
    ]);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - VEP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">✓ Installation Réussie!</h4>
            <p>La base de données a été initialisée avec succès.</p>
            <hr>
            <p class="mb-0"><strong>Identifiants par défaut:</strong></p>
            <ul>
                <li>Username: <code>admin</code></li>
                <li>Password: <code>admin123</code></li>
            </ul>
            <hr>
            <p class="mb-0">
                <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Aller à l'accueil</a>
                <a href="<?php echo BASE_URL; ?>login.php" class="btn btn-success">Connexion Admin</a>
            </p>
        </div>
        
        <div class="card mt-5">
            <div class="card-header">
                <h5>Étapes Suivantes</h5>
            </div>
            <div class="card-body">
                <ol>
                    <li>Connectez-vous avec les identifiants fournis ci-dessus</li>
                    <li>Changez le mot de passe administrateur</li>
                    <li>Uploadez les logos des marques et partenaires</li>
                    <li>Ajoutez les images des produits</li>
                    <li>Créez les produits et les actualités</li>
                    <li>Configurez les pages de contenu</li>
                    <li>Testez le site de bout en bout</li>
                </ol>
            </div>
        </div>
        
        <div class="alert alert-warning mt-5">
            <strong>⚠️ Important:</strong> Supprimez ce fichier setup.php après son exécution ou sécurisez son accès!
        </div>
    </div>
</body>
</html>
