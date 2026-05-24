-- ===================================================
-- VEP - Hebergement Maokaa Database Schema
-- ===================================================

CREATE DATABASE IF NOT EXISTS maokaa CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE maokaa;

-- ===================================================
-- 1. ADMINS TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  fullname VARCHAR(150),
  email VARCHAR(150),
  active TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 2. CATEGORIES TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  slug VARCHAR(255) NOT NULL UNIQUE,
  description TEXT,
  display_order INT DEFAULT 0,
  active TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 3. MARQUES (BRANDS) TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS marques (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  slug VARCHAR(255) NOT NULL UNIQUE,
  logo VARCHAR(255),
  description TEXT,
  website VARCHAR(255),
  display_order INT DEFAULT 0,
  active TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 4. PARTENAIRES (PARTNERS) TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS partenaires (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  logo VARCHAR(255),
  description TEXT,
  website VARCHAR(255),
  display_order INT DEFAULT 0,
  active TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 5. ACTUALITES (NEWS) TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS actualites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  content LONGTEXT,
  image VARCHAR(255),
  excerpt VARCHAR(500),
  published_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('published','draft') DEFAULT 'draft',
  author_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES admins(id) ON DELETE SET NULL,
  INDEX (published_at),
  INDEX (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 6. PRODUITS (PRODUCTS) TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS produits (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  description TEXT,
  description_complete LONGTEXT,
  image VARCHAR(255),
  brochure_pdf VARCHAR(255),
  categorie_id INT NOT NULL,
  marque_id INT,
  lettre_alphabet CHAR(1),
  caracteristiques_techniques LONGTEXT,
  active TINYINT DEFAULT 1,
  featured TINYINT DEFAULT 0,
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE,
  FOREIGN KEY (marque_id) REFERENCES marques(id) ON DELETE SET NULL,
  INDEX (lettre_alphabet),
  INDEX (categorie_id),
  INDEX (featured),
  INDEX (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 7. PRODUCT GALLERY TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS produit_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  produit_id INT NOT NULL,
  image VARCHAR(255) NOT NULL,
  alt_text VARCHAR(255),
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE,
  INDEX (produit_id),
  INDEX (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 8. CONTACTS TABLE
-- ===================================================
CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  telephone VARCHAR(50),
  sujet VARCHAR(255),
  message LONGTEXT,
  lu TINYINT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX (lu),
  INDEX (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- 9. CONTENT TABLE (Pages CMS)
-- ===================================================
CREATE TABLE IF NOT EXISTS content (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(191) NOT NULL UNIQUE,
  title VARCHAR(255) NOT NULL,
  subtitle VARCHAR(255),
  meta_title VARCHAR(255),
  meta_description VARCHAR(512),
  body LONGTEXT,
  template VARCHAR(100) DEFAULT 'default',
  status ENUM('published','draft') DEFAULT 'published',
  language VARCHAR(10) DEFAULT 'fr',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX (slug),
  INDEX (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===================================================
-- INSERT INITIAL DATA
-- ===================================================

-- Insert default admin (password: admin123)
INSERT INTO admins (username, password_hash, fullname, email, active)
VALUES ('admin', '$2y$10$JPDdB.BlQmfuKOv/mL8Xw.g5O4qrH2u/v.IqJucMr1n/BUmMIZWQa', 'Admin VEP', 'admin@vep.dz', 1)
ON DUPLICATE KEY UPDATE id=id;

-- Insert categories
INSERT INTO categories (name, slug, description, display_order, active) VALUES
('Analyseurs d\'humidité', 'analyseurs-humidite', 'Analyseurs d\'humidité de laboratoire', 1, 1),
('Appareils de mesure portables', 'appareils-mesure-portables', 'Appareils de mesure portables', 2, 1),
('Armoires à filtration', 'armoires-filtration', 'Armoires à filtration', 3, 1),
('Balances de laboratoire', 'balances-laboratoire', 'Balances de laboratoire', 4, 1),
('Balances industrielles', 'balances-industrielles', 'Balances industrielles', 5, 1),
('Centrale d\'acquisition: Akivision', 'centrale-acquisition-akivision', 'Centrale d\'acquisition: Akivision', 6, 1),
('Compteur de particules dans les liquides', 'compteur-particules-liquides', 'Compteur de particules dans les liquides', 7, 1),
('Compteurs de particules air', 'compteurs-particules-air', 'Compteurs de particules air', 8, 1),
('Consommable pour essai de stérilité', 'consommable-essai-sterilite', 'Consommable pour essai de stérilité', 9, 1),
('Débitmètre', 'debitmetres', 'Débitmètre', 10, 1),
('Détecteurs de gaz', 'detecteurs-gaz', 'Détecteurs de gaz', 11, 1),
('Echantilloneur d\'air', 'echantilloneur-air', 'Echantilloneur d\'air', 12, 1),
('Enregistreurs', 'enregistreurs', 'Enregistreurs', 13, 1),
('Filtres membrane', 'filtres-membrane', 'Filtres membrane', 14, 1),
('Filtres seringue', 'filtres-seringue', 'Filtres seringue', 15, 1),
('Hotte à filtration', 'hotte-filtration', 'Hotte à filtration', 16, 1),
('Milieux de cultures', 'milieux-cultures', 'Milieux de cultures', 17, 1),
('Pipettes électroniques', 'pipettes-electroniques', 'Pipettes électroniques', 18, 1)
ON DUPLICATE KEY UPDATE id=id;

-- Insert sample brands
INSERT INTO marques (name, slug, logo, description, display_order, active) VALUES
('Mettler Toledo', 'mettler-toledo', '/assets/images/brands/mettler-toledo.png', 'Leader mondial des instruments de mesure', 1, 1),
('Shimadzu', 'shimadzu', '/assets/images/brands/shimadzu.png', 'Équipements analytiques de précision', 2, 1),
('PerkinElmer', 'perkinelmer', '/assets/images/brands/perkinelmer.png', 'Solutions de laboratoire innovantes', 3, 1),
('Horiba', 'horiba', '/assets/images/brands/horiba.png', 'Instrumentation analytique avancée', 4, 1)
ON DUPLICATE KEY UPDATE id=id;

-- Insert sample partners
INSERT INTO partenaires (name, logo, description, display_order, active) VALUES
('Laboratoire National', 'Partenaire institutionnel', '/assets/images/partners/lab-national.png', 1, 1),
('Université Algerienne', 'Partenaire universitaire', '/assets/images/partners/univ-alg.png', 2, 1),
('Pharmaplus DZ', 'Distributeur pharmaceutique', '/assets/images/partners/pharmaplus.png', 3, 1)
ON DUPLICATE KEY UPDATE id=id;

-- Insert sample products
INSERT INTO produits (nom, slug, description, categorie_id, marque_id, lettre_alphabet, active, featured) VALUES
('KT50 / KH50', 'kt50-kh50', 'Enregistreur de température et humidité', 13, 1, 'K', 1, 1),
('KT120 / KH120', 'kt120-kh120', 'Enregistreur multicanal avancé', 13, 1, 'K', 1, 1),
('Echantilloneur Air Standard', 'echantilloneur-air-standard', 'Échantilloneur d\'air haute performance', 12, 2, 'E', 1, 1),
('Balance Analytique BM500', 'balance-analytique-bm500', 'Balance analytique ultra précise', 4, 1, 'B', 1, 1)
ON DUPLICATE KEY UPDATE id=id;

-- Contenu d'exemple pour les pages principales
INSERT INTO content (slug, title, subtitle, meta_title, meta_description, body, template, status)
VALUES
('home', 'maokaa — Votre partenaire incontournable du laboratoire en Algérie',
 'Importation et distribution de matériels et consommables de laboratoire depuis plus de 20 ans.',
 'maokaa - Accueil', 'maokaa importateur et distributeur de matériels de laboratoire en Algérie', '<!-- body HTML: hero, valeurs, produits populaires, logos, actualités, contact rapide -->', 'home', 'published'),
('about', 'Qui sommes nous', NULL, 'maokaa - À propos', 'Histoire, mission, vision et équipe de maokaa', '<!-- body HTML: histoire, mission, vision, timeline, équipe -->', 'page', 'published'),
('brands', 'Nos marques', NULL, 'maokaa - Nos marques', 'Liste des marques distribuées par maokaa', '<!-- body HTML: logos et descriptions des marques -->', 'listing', 'published'),
('partners', 'Nos partenaires', NULL, 'maokaa - Partenaires', 'Partenaires et collaborations', '<!-- body HTML: logos et descriptions des partenaires -->', 'listing', 'published'),
('products', 'Produits', NULL, 'maokaa - Produits', 'Catalogue produits', '<!-- body HTML: zone catalogue, filtres, alphabet -->', 'products', 'published'),
('news', 'Actualité', NULL, 'maokaa - Actualité', 'Nouveautés, événements et annonces', '<!-- body HTML: blog listing -->', 'news', 'published'),
('contact', 'Contact', NULL, 'maokaa - Contact', 'Coordonnées et formulaire de contact', '<!-- body HTML: coordonnées, google maps, formulaire -->', 'page', 'published'),
('login', 'Login Admin', NULL, 'maokaa - Login', 'Espace administration', '<!-- body HTML: login form (admin only) -->', 'auth', 'draft');

