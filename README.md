# VEP - Site Web Vitrine Professionnel

## À propos
VEP est un site web vitrine moderne et professionnel pour une entreprise spécialisée dans l'importation et la distribution de matériels et consommables de laboratoire en Algérie.

## Caractéristiques
- ✅ Architecture MVC complète
- ✅ Design moderne, élégant et responsive
- ✅ Système de gestion de contenu (CMS)
- ✅ Authentification sécurisée (PDO, password_hash)
- ✅ Dashboard administration complet
- ✅ Gestion des produits avec filtrage alphabétique
- ✅ Système de brochures PDF
- ✅ Formulaire de contact
- ✅ Gestion des actualités (blog)
- ✅ Galerie de produits
- ✅ Responsive design (mobile, tablette, desktop)

## Prérequis
- PHP 7.4+
- MySQL/MariaDB 5.7+
- Apache avec mod_rewrite (optionnel, pour les URL propres)
- Bootstrap 5.3

## Installation

### 1. Télécharger les fichiers
Placez tous les fichiers dans le répertoire `c:\xampp\htdocs\Hebergement\maokaa\`

### 2. Créer la base de données
Assurez-vous que MySQL/MariaDB est en cours d'exécution sur votre XAMPP.

### 3. Configurer les paramètres
Éditez `includes/config.php`:
```php
define('BASE_URL', 'http://localhost/Hebergement/maokaa/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'maokaa');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Initialiser la base de données
Accédez à votre navigateur:
```
http://localhost/Hebergement/maokaa/setup.php
```

Cela va:
- Créer toutes les tables
- Insérer les données initiales
- Créer un compte administrateur par défaut

### 5. Identifiants par défaut
```
Username: admin
Password: admin123
```

⚠️ **Important:** Changez le mot de passe admin immédiatement après la première connexion!

## Structure du Projet

```
maokaa/
├── index.php                 # Front controller principal
├── login.php                 # Page de connexion admin
├── setup.php                 # Script d'initialisation (à exécuter une seule fois)
│
├── admin/
│   ├── dashboard.php         # Dashboard administrateur
│   ├── logout.php            # Déconnexion
│   ├── products/
│   ├── brands/
│   ├── partners/
│   ├── news/
│   └── messages/
│
├── app/
│   ├── controllers/          # Contrôleurs MVC
│   ├── models/               # Modèles MVC
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Brand.php
│   │   ├── Partner.php
│   │   ├── News.php
│   │   ├── Contact.php
│   │   └── Content.php
│   └── views/                # Vues/Templates
│       ├── partials/         # Navbar, Footer
│       ├── templates/        # Layouts principaux
│       └── errors/           # Pages d'erreur
│
├── assets/
│   ├── css/                  # Styles CSS
│   │   └── style.css         # Style principal
│   ├── js/                   # JavaScript
│   │   └── main.js           # Script principal
│   ├── images/               # Images produits, marques, etc.
│   └── brochures/            # Fichiers PDF brochures
│
├── includes/
│   ├── config.php            # Configuration
│   ├── db.php                # Connexion BD
│   └── auth.php              # Gestion authentification
│
├── db/
│   └── shema.sql             # Schéma SQL complet
│
└── README.md                 # Ce fichier
```

## Pages Principales

### Pages Publiques
- **Accueil** (`/` ou `/home`) - Page d'accueil avec sections dynamiques
- **À propos** (`/about`) - Informations sur l'entreprise
- **Produits** (`/products`) - Catalogue complet avec filtres
- **Nos marques** (`/brands`) - Marques partenaires
- **Nos partenaires** (`/partners`) - Partenaires stratégiques
- **Actualités** (`/news`) - Blog/Actualités
- **Contact** (`/contact`) - Formulaire de contact
- **Connexion Admin** (`/login.php`) - Formulaire de connexion

### Pages Admin (après connexion)
- **Dashboard** (`/admin/dashboard.php`) - Tableau de bord
- **Gestion Produits** - CRUD complet
- **Gestion Catégories** - CRUD complet
- **Gestion Marques** - CRUD complet
- **Gestion Partenaires** - CRUD complet
- **Gestion Actualités** - CRUD complet
- **Gestion Messages** - Consulter les messages de contact

## Fonctionnalités Clés

### Système de Produits
- Liste complète avec pagination
- Filtrage par catégorie
- Filtrage alphabétique (A-Z, #)
- Recherche dynamique
- Fiche produit détaillée
- Galerie d'images
- Téléchargement de brochures PDF
- Produits populaires/featured sur l'accueil

### Sécurité
- PDO Prepared Statements (protection SQL Injection)
- Hachage de mots de passe (password_hash/verify)
- Tokens CSRF
- Sessions PHP sécurisées
- Validation des formulaires côté serveur
- Validation des uploads (images, PDF)

### Design
- Responsive design (mobile-first)
- Gradient moderne bleu/violet
- Cards avec animations
- Transitions fluides
- Design scientifique et professionnel
- Font Awesome pour icônes
- Bootstrap 5.3 pour structure

## Configuration Avancée

### Variables d'Environnement
Créez un fichier `.env` pour les configurations sensibles:
```
DB_HOST=localhost
DB_NAME=maokaa
DB_USER=root
DB_PASS=
BASE_URL=http://localhost/Hebergement/maokaa/
```

### URL Rewriting (optionnel)
Créez un `.htaccess` pour les URLs propres:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /Hebergement/maokaa/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?/$1 [QSA,L]
</IfModule>
```

## Gestion des Images et Fichiers

### Dossiers de Upload
- `/assets/images/` - Images de produits et contenus
- `/assets/images/brands/` - Logos des marques
- `/assets/images/partners/` - Logos des partenaires
- `/assets/brochures/` - Fichiers PDF

### Limites de Taille
- Images: 2 MB maximum
- PDF: 5 MB maximum

## Personnalisation

### Couleurs
Modifiez les variables CSS dans `assets/css/style.css`:
```css
:root {
    --primary: #667eea;
    --primary-dark: #764ba2;
    --secondary: #42a5f5;
    --success: #26c281;
    --danger: #e74c3c;
    --warning: #f39c12;
}
```

### Contenu Statique
Éditez le contenu des pages depuis le Dashboard Admin ou directement dans la BD table `content`.

## Support Multi-Langue
Le système supporte le multi-langue via la colonne `language` dans `content`. Par défaut: français (fr).

## Performance

### Optimisations Implémentées
- Images responsives
- CSS minifiée
- JavaScript optimisé
- Caching des requêtes
- Lazy loading pour images
- Compression gzip

### Recommandations
- Utilisez un CDN pour les images
- Activez le cache du navigateur
- Optimisez les images (WebP)
- Minifiez CSS/JS en production

## Maintenance

### Sauvegardes
Sauvegardez régulièrement votre base de données:
```bash
mysqldump -u root maokaa > backup_maokaa.sql
```

### Logs
Les actions administrateur sont enregistrées dans la table `audit_logs`.

### Mises à Jour
Pour les mises à jour:
1. Backup la base de données
2. Backup les fichiers
3. Appliquez les changements
4. Testez complètement

## Dépannage

### La page d'accueil est blanche
- Vérifiez que le template `home.php` existe
- Vérifiez les erreurs PHP dans les logs

### Impossible de se connecter
- Vérifiez les identifiants dans la BD table `admins`
- Vérifiez que PHP sessions sont activées
- Vérifiez le BASE_URL dans config.php

### Images ne s'affichent pas
- Vérifiez les chemins dans `<img src="">`
- Assurez-vous que les dossiers existent
- Vérifiez les permissions (755)

### Erreur: CSRF token invalide
- Assurez-vous que les sessions sont activées
- Vérifiez que le formulaire inclut le token CSRF

## Support et Contact
Pour toute question ou problème:
- Email: support@vep.dz
- Téléphone: +213 123 456 789
- Adresse: Alger, Algérie

## Licence
Tous droits réservés © 2024 VEP

## Changelog

### Version 1.0.0 (Initial Release)
- Architecture MVC complète
- Dashboard administration
- Gestion des produits, marques, partenaires
- Gestion des actualités
- Formulaire de contact
- Authentification sécurisée
- Design responsive

---

**Dernière mise à jour:** 23 Mai 2024
