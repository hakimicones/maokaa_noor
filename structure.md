vep/
│
├── index.php                 # front controller (résout slug via content table)
├── router.php                # (optionnel) logique de routage centralisée
├── sitemap.php
├── about.php                 # alias -> router.php?slug=about (compatibilité)
├── brands.php                # alias -> router.php?slug=brands
├── partners.php              # alias -> router.php?slug=partners
├── products.php              # alias -> router.php?slug=products (ou catalogue dynamique)
├── product-details.php       # alias -> product-details.php?id=...
├── news.php                  # alias -> router.php?slug=news
├── contact.php               # alias -> router.php?slug=contact
├── login.php                 # page de connexion admin publique (POST -> admin/login.php)
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   ├── images/
│   └── brochures/
│
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── PageController.php        # rend les pages depuis content
│   │   ├── ProductController.php
│   │   └── AdminController.php
│   ├── models/
│   │   ├── Content.php
│   │   ├── Product.php
│   │   └── ...
│   └── views/
│       ├── templates/
│       │   ├── home.php
│       │   ├── page.php
│       │   └── default.php
│       ├── partials/
│       │   ├── header.php
│       │   ├── navbar.php
│       │   └── footer.php
│       └── errors/404.php
│
├── admin/
│   ├── login.php                 # traitement POST login (utilise includes/auth.php)
│   ├── logout.php
│   ├── dashboard.php
│   ├── partials/
│   │   ├── admin_header.php
│   │   └── admin_footer.php
│   ├── content/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   ├── products/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   └── messages/
│
├── includes/
│   ├── config.php
│   ├── db.php
│   ├── auth.php
│   ├── helpers.php
│   └── csrf.php
│
└── database/
    ├── vep_schema.sql
    ├── vep_schema_content.sql
    └── seeds.sql
