-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 08 juin 2026 à 11:56
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `maokaa`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

CREATE TABLE `actualites` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `published_at` datetime DEFAULT current_timestamp(),
  `status` enum('published','draft') DEFAULT 'draft',
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `actualites`
--

INSERT INTO `actualites` (`id`, `title`, `slug`, `content`, `image`, `excerpt`, `published_at`, `status`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'Nouveau contrat Avec USTHB', 'nouveau-contrat-avec-usthb', 'un nouveau contrat Avec USTHB a été conclut  un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut un nouveau contrat Avec USTHB a été conclut ', NULL, 'un nouveau contrat Avec USTHB a été conclut ...............', '2026-05-24 13:12:31', 'published', 1, '2026-05-24 12:12:31', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `fullname` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `fullname`, `email`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$lcQB5JIPnZeOTONHpzso0uFDSFQ1TNh5OH2lqw/wTgrw7h.XEx7wK', 'Admin VEP', 'admin@vep.dz', 1, '2026-05-23 10:29:22', '2026-05-23 11:21:37'),
(2, 'TC', '$2y$10$t1271KwMqR/N5N/vuN.xU.MIym2M3tolSIAn5hy6RWs8vNnYmF22K', 'Admin TC', 'TC@vep.dz', 1, '2026-05-23 10:29:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `admin_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, 1, 'inline_edit', 'Champ \'title\' modifié sur la page \'about\'', '::1', '2026-05-25 13:02:56'),
(2, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-25 13:03:56'),
(3, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-25 13:10:21'),
(4, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-25 13:45:31'),
(5, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-25 13:46:15'),
(6, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'contact\'', '::1', '2026-05-26 11:55:57'),
(7, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-26 13:07:15'),
(8, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-26 13:07:19'),
(9, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-26 13:09:03'),
(10, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-26 13:09:06'),
(11, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-05-26 13:09:09'),
(12, 1, 'inline_edit', 'Champ \'body\' modifié sur la page \'about\'', '::1', '2026-06-07 12:21:14'),
(13, 1, 'update_product', 'KT50 / KH50', '::1', '2026-06-07 15:45:48'),
(14, 1, 'update_product', 'KT120 / KH120', '::1', '2026-06-07 15:55:44'),
(15, 1, 'update_product', 'Echantilloneur Air Standard', '::1', '2026-06-07 15:56:18'),
(16, 1, 'update_product', 'Balance Analytique BM500', '::1', '2026-06-07 16:22:17');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `display_order`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Analyseurs d\'humidité', 'analyseurs-humidite', 'Analyseurs d\'humidité de laboratoire', 1, 1, '2026-05-23 10:29:22', NULL),
(2, 'Appareils de mesure portables', 'appareils-mesure-portables', 'Appareils de mesure portables', 2, 1, '2026-05-23 10:29:22', NULL),
(3, 'Armoires à filtration', 'armoires-filtration', 'Armoires à filtration', 3, 1, '2026-05-23 10:29:22', NULL),
(4, 'Balances de laboratoire', 'balances-laboratoire', 'Balances de laboratoire', 4, 1, '2026-05-23 10:29:22', NULL),
(5, 'Balances industrielles', 'balances-industrielles', 'Balances industrielles', 5, 1, '2026-05-23 10:29:22', NULL),
(6, 'Centrale d\'acquisition: Akivision', 'centrale-acquisition-akivision', 'Centrale d\'acquisition: Akivision', 6, 1, '2026-05-23 10:29:22', NULL),
(7, 'Compteur de particules dans les liquides', 'compteur-particules-liquides', 'Compteur de particules dans les liquides', 7, 1, '2026-05-23 10:29:22', NULL),
(8, 'Compteurs de particules air', 'compteurs-particules-air', 'Compteurs de particules air', 8, 1, '2026-05-23 10:29:22', NULL),
(9, 'Consommable pour essai de stérilité', 'consommable-essai-sterilite', 'Consommable pour essai de stérilité', 9, 1, '2026-05-23 10:29:22', NULL),
(10, 'Débitmètre', 'debitmetres', 'Débitmètre', 10, 1, '2026-05-23 10:29:22', NULL),
(11, 'Détecteurs de gaz', 'detecteurs-gaz', 'Détecteurs de gaz', 11, 1, '2026-05-23 10:29:22', NULL),
(12, 'Echantilloneur d\'air', 'echantilloneur-air', 'Echantilloneur d\'air', 12, 1, '2026-05-23 10:29:22', NULL),
(13, 'Enregistreurs', 'enregistreurs', 'Enregistreurs', 13, 1, '2026-05-23 10:29:22', NULL),
(14, 'Filtres membrane', 'filtres-membrane', 'Filtres membrane', 14, 1, '2026-05-23 10:29:22', NULL),
(15, 'Filtres seringue', 'filtres-seringue', 'Filtres seringue', 15, 1, '2026-05-23 10:29:22', NULL),
(16, 'Hotte à filtration', 'hotte-filtration', 'Hotte à filtration', 16, 1, '2026-05-23 10:29:22', NULL),
(17, 'Milieux de cultures', 'milieux-cultures', 'Milieux de cultures', 17, 1, '2026-05-23 10:29:22', NULL),
(18, 'Pipettes électroniques', 'pipettes-electroniques', 'Pipettes électroniques', 18, 1, '2026-05-23 10:29:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `lu` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(512) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `template` varchar(100) DEFAULT 'default',
  `status` enum('published','draft') DEFAULT 'published',
  `language` varchar(10) DEFAULT 'fr',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `content`
--

INSERT INTO `content` (`id`, `slug`, `title`, `subtitle`, `meta_title`, `meta_description`, `body`, `template`, `status`, `language`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Votre partenaire incontournable du laboratoire en Algérie', 'Importation et distribution de matériels et consommables de laboratoire depuis plus de 20 ans.', 'Accueil', 'VEP importateur et distributeur de matériels de laboratoire en Algérie', '<div class=\"row g-4\">[carousel slider_id=\"1\"]<div class=\"col-md-12\"> \r\n    </div></div><div class=\"container\"><div class=\"row g-4\"><div class=\"col-md-6\"><div class=\"p-4 bg-light rounded-3 h-100\"><h3 id=\"iy6zx\">\r\n        </h3><h3 id=\"i31yv\">À propos de VEP\r\n        </h3><p class=\"text-muted mb-0\">\r\n        </p><p id=\"ixncv\"><strong id=\"ijkzx\">VEP</strong> est une société spécialisée dans l’importation et la distribution de matériels et de consommables de laboratoire.\r\n        </p><p id=\"i2tg7\"><strong id=\"ifphv\">VEP</strong><span id=\"ib7zb\"> se présente comme votre partenaire incontournable du laboratoire en Algérie. Fort d’une expérience de plus de 20 ans et d’une équipe compétente et dynamique, nous assisterons nos clients tout au long du processus de production en offrant des solutions adaptées aux contrôles opérés à l’échelle du laboratoire mais également des solutions adaptées à la production.</span></p><p>\r\n        </p></div></div><div class=\"col-md-6\"><div class=\"p-4 bg-light rounded-3 h-100\"><div class=\"text-center py-3\"><img class=\"img-fluid rounded-3 shadow-sm\" alt=\"Image de demonstration\" src=\"/Hebergement/maokaa/assets/images/back2-small.jpg\"></div></div></div></div></div><div class=\"row g-4\"><div class=\"col-md-12\"><h2 class=\"h3 mb-3\"><br></h2></div></div>[featured_products limit=\"6\"][brands]', 'home', 'published', 'fr', '2026-05-23 10:29:22', '2026-05-31 07:59:37'),
(2, 'about', '\n                        À propos de VEP', '', 'maokaa - À propos', 'Histoire, mission, vision et équipe de maokaa', '\n                        \n                        \n                        <div class=\"row g-4\"><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\"><p class=\"text-muted mb-0\"><span draggable=\"true\" id=\"izzo-2\">VEP</span><span draggable=\"true\" id=\"ivpu-2\"> </span><span id=\"ikggg\">est une société spécialisée dans l’importation et la distribution de matériel et de consommable de laboratoire.</span> texte, une liste ou une mise en avant.\n        </p><div class=\"py-4\"><p class=\"text-muted mb-0\"><span draggable=\"true\" id=\"i2xl-2\">VEP</span><span id=\"i3pyi\"> se présente comme votre partenaire incontournable du laboratoire en Algérie. Fort d’une expérience de plus de 20 ans et d’une équipe compétente et dynamique, nous assisterons nos clients tout au long du processus de production en offrant des solutions adaptées aux contrôles opérés à l’échelle du laboratoire mais également des solutions adaptées à la production.</span> a l\'emploi.</p></div></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\"><div class=\"text-center py-3\"><img class=\"img-fluid rounded-3 shadow-sm\" alt=\"Image de demonstration\" src=\"/Hebergement/maokaa/assets/images/img1.jpg\"></div></div></div></div><div class=\"row g-4\"><div class=\"col-md-6\"><div class=\"p-4 bg-light rounded-3 h-100\"><p class=\"text-muted mb-0\"><span id=\"iyzaw\">A ce titre, VEP s’est toujours imposé de rechercher des partenaires proposant les solutions les plus adaptées à des industries en constante évolution. Offrant à ses clients une large gamme de produits dans les domaines de la pesée, de la filtration, du contrôle et la surveillance de l’air, du comptage particulaire, etc, VEP se veut comme étant un partenaire complet constamment à l’écoute de ses clients. C’est la raison pour laquelle VEP a su s’adapter et évoluer au fil des années et qu’elle dispose aujourd’hui d’un vaste réseau de clients provenant de divers secteurs tels que Pharmaceutique / Agro-alimentaire / Boissons / Pétrochimie / Energie.</span>e en avant.</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\"><div class=\"text-center py-3\"><img class=\"img-fluid rounded-3 shadow-sm\" src=\"/Hebergement/maokaa/assets/images/laboratory.jpg\" alt=\"Image de demonstration\"></div></div></div></div>                                                            ', 'page', 'published', 'fr', '2026-05-23 10:29:22', '2026-06-07 12:21:14'),
(3, 'brands', 'Nos marques', '', 'maokaa - Nos marques', 'Liste des marques distribuées par maokaa', '<div class=\"text-center py-3\"><img class=\"img-fluid rounded-3 shadow-sm\" alt=\"Image de demonstration\" src=\"/Hebergement/maokaa/assets/images/laboratory.jpg\"></div>[brands]', 'listing', 'published', 'fr', '2026-05-23 10:29:22', '2026-05-26 13:08:47'),
(4, 'partners', 'Nos partenaires', NULL, 'maokaa - Partenaires', 'Partenaires et collaborations', '<!-- body HTML: coordonnées, google maps, formulaire -->\r\n ', 'listing', 'published', 'fr', '2026-05-23 10:29:22', NULL),
(5, 'products', 'Produits', NULL, 'maokaa - Produits', 'Catalogue produits', '<div data-vep-block=\"products\" data-limit=\"12\"></div>', 'products', 'published', 'fr', '2026-05-23 10:29:22', '2026-05-23 18:07:51'),
(6, 'news', 'Actualité', NULL, 'maokaa - Actualité', 'Nouveautés, événements et annonces', '<div data-vep-block=\"news\" data-limit=\"12\"></div>', 'news', 'published', 'fr', '2026-05-23 10:29:22', '2026-05-23 18:07:51'),
(7, 'contact', 'Contact', '', 'maokaa - Contact', 'Coordonnées et formulaire de contact', '<div class=\"row g-4\"></div><div class=\"swiper\"><div class=\"swiper-wrapper\"></div><div class=\"swiper-button-next\"></div><div class=\"swiper-button-prev\"></div></div><div class=\"row g-4\"><div class=\"col-md-8\"><div class=\"p-4 h-100\">[contact_form]</div></div><div class=\"col-md-4\"><div class=\"p-4 bg-light rounded-3 h-100\"><h3 class=\"uk-panel-title\" id=\"iofvu\">Contact</h3><span id=\"imby7\">Dely Ibrahim - Alger</span><p class=\"text-muted mb-0\"><span id=\"idmb3\">119 Coopérative Bois des Cars 3</span><br id=\"iyzhf\"></p><p class=\"text-muted mb-0\"><strong id=\"ixsvt\">Tel:</strong><span id=\"i22sw\"> +213 (0) 23 306 869</span><br id=\"igfvd\"><strong id=\"iiqcu\">Mob:</strong><span id=\"iz9f7\"> +213 (0) 770 485 505</span><br id=\"i0lpk\"><strong id=\"itspf\">E-mail:</strong><span id=\"ik9p5\"> </span><a id=\"iqntt\" href=\"mailto:contact@vep-dz.com\">contact@vep-dz.com</a></p></div></div></div>', 'page', 'published', 'fr', '2026-05-23 10:29:22', '2026-05-26 12:42:39'),
(8, 'login', 'Login Admin', '', 'maokaa - Login', 'Espace administration', '<!-- body HTML: coordonnées, google maps, formulaire -->', 'auth', 'draft', 'fr', '2026-05-23 10:29:22', '2026-05-25 16:24:52');

-- --------------------------------------------------------

--
-- Structure de la table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `attempted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `marques`
--

CREATE TABLE `marques` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `marques`
--

INSERT INTO `marques` (`id`, `name`, `slug`, `logo`, `description`, `website`, `display_order`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Satorius', 'mettler-toledo', 'assets/images/sartorius1.png \r\n ', 'Sartorius Stedim Biotech est l’un des principaux fournisseurs d’équipements et de services destinés aux processus de développement...', '', 1, 1, '2026-05-23 10:29:22', '2026-05-24 13:11:56'),
(2, 'Kimo', 'kimo', 'assets\\images\\KIMO.jpg', 'KIMO conçoit et fabrique des instruments de mesure pour le contrôle et la surveillance de l’air en milieu confiné.  ', NULL, 2, 1, '2026-05-23 10:29:22', NULL),
(3, 'Beckman', 'beckman', 'assets/images/beckman.jpg', 'Depuis 1976, les marques MET ONE et HIAC sont synonymes d’innovation, de fiabilité et de service aux clients. Ces compteurs de particules dans l’air ...', NULL, 3, 1, '2026-05-23 10:29:22', NULL),
(4, 'Aqualabo', 'aqualabo', 'assets\\images\\aqualabo.jpg', 'A travers sa gamme SECOMAM, le spécialiste français en spectrophotométrie et en analyseurs en ligne & portables pour toutes vos applications.', NULL, 4, 1, '2026-05-23 10:29:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `name`, `label`, `description`, `created_at`, `updated_at`) VALUES
(1, 'main', 'Menu Principal', 'Menu de navigation principal du site', '2026-05-25 09:32:09', '2026-05-25 09:32:09');

-- --------------------------------------------------------

--
-- Structure de la table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `params` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `icon`, `position`, `active`, `params`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Accueil', '/', 'fas fa-home', 0, 1, '{\"icon\":0}', '2026-05-25 09:32:09', '2026-05-26 13:11:13'),
(2, 1, NULL, 'A propos', '/about', 'fas fa-info-circle', 1, 1, '{\r\n\"icon\":0 \r\n}', '2026-05-25 09:32:09', '2026-05-25 11:01:43'),
(3, 1, NULL, 'Nos marques', '/brands', 'fas fa-award', 2, 1, '{\"icon\":0}', '2026-05-25 09:32:09', '2026-05-25 11:14:40'),
(4, 1, NULL, 'Nos partenaires', '/partners', 'fas fa-handshake', 3, 1, '{\"icon\":0}', '2026-05-25 09:32:09', '2026-05-25 11:14:20'),
(5, 1, NULL, 'Produits', '/products', 'fas fa-box', 4, 1, '{\"icon\":0}', '2026-05-25 09:32:09', '2026-05-25 11:15:00'),
(6, 1, NULL, 'Actualités', '/news', 'fas fa-newspaper', 5, 1, '{\"icon\":0}', '2026-05-25 09:32:09', '2026-05-25 11:15:07'),
(7, 1, NULL, 'Contact', '/contact', 'fas fa-envelope', 6, 1, '{\"icon\":0}', '2026-05-25 09:32:09', '2026-05-25 11:15:24');

-- --------------------------------------------------------

--
-- Structure de la table `partenaires`
--

CREATE TABLE `partenaires` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `partenaires`
--

INSERT INTO `partenaires` (`id`, `name`, `logo`, `description`, `website`, `display_order`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Laboratoire National', 'Partenaire institutionnel', '/assets/images/partners/lab-national.png', NULL, 1, 1, '2026-05-23 10:29:22', NULL),
(2, 'Université Algerienne', 'Partenaire universitaire', '/assets/images/partners/univ-alg.png', NULL, 2, 1, '2026-05-23 10:29:22', NULL),
(3, 'Pharmaplus DZ', 'Distributeur pharmaceutique', '/assets/images/partners/pharmaplus.png', NULL, 3, 1, '2026-05-23 10:29:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `description_complete` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `brochure_pdf` varchar(255) DEFAULT NULL,
  `categorie_id` int(11) NOT NULL,
  `marque_id` int(11) DEFAULT NULL,
  `lettre_alphabet` char(1) DEFAULT NULL,
  `caracteristiques_techniques` longtext DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1,
  `featured` tinyint(4) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `slug`, `description`, `description_complete`, `image`, `brochure_pdf`, `categorie_id`, `marque_id`, `lettre_alphabet`, `caracteristiques_techniques`, `active`, `featured`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'KT50 / KH50', 'kt50-kh50', 'Enregistreur de température et humidité', '', 'assets/images/prod_6a25922cba34a.png', '/assets/brochures/broch_6a25922cbc075.pdf', 13, 1, 'K', '', 1, 1, 0, '2026-05-23 10:29:22', '2026-06-07 15:47:14'),
(2, 'KT120 / KH120', 'kt120-kh120', 'Enregistreur multicanal avancé', '', 'assets/images/prod_6a2594805a3d2.jpg', '/assets/brochures/broch_6a2594805a961.pdf', 13, 1, 'K', '', 1, 1, 0, '2026-05-23 10:29:22', '2026-06-07 15:55:44'),
(3, 'Echantilloneur Air Standard', 'echantilloneur-air-standard', 'Échantilloneur d&#039;air haute performance', '', 'assets/images/prod_6a2594a259aa5.png', NULL, 12, 2, 'E', '', 1, 1, 0, '2026-05-23 10:29:22', '2026-06-07 15:56:18'),
(4, 'Balance Analytique BM500', 'balance-analytique-bm500', 'Balance analytique ultra précise', '', 'assets/images/prod_6a259ab98bf15.jpg', NULL, 4, 1, 'B', '', 1, 1, 0, '2026-05-23 10:29:22', '2026-06-07 16:22:17');

-- --------------------------------------------------------

--
-- Structure de la table `produit_images`
--

CREATE TABLE `produit_images` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit_images`
--

INSERT INTO `produit_images` (`id`, `produit_id`, `image`, `alt_text`, `display_order`, `created_at`) VALUES
(1, 4, 'assets\\images\\produits\\1.jpg', NULL, 0, '2026-06-07 15:35:25'),
(2, 2, 'assets\\images\\produits\\2.jpg', NULL, 0, '2026-06-07 15:35:25');

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'active_theme', 'default', '2026-05-25 16:52:05');

-- --------------------------------------------------------

--
-- Structure de la table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `slider_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `subtitle` varchar(500) DEFAULT NULL,
  `bg` varchar(100) NOT NULL DEFAULT '#dde4ee',
  `image` varchar(500) DEFAULT NULL,
  `text_position` varchar(20) NOT NULL DEFAULT 'center',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sliders`
--

INSERT INTO `sliders` (`id`, `slider_id`, `label`, `subtitle`, `bg`, `image`, `text_position`, `sort_order`, `active`, `created_at`) VALUES
(1, 1, 'Sartorius', 'Sartorius Stedim Biotech est l’un des principaux fournisseurs d’équipements et de services destinés aux processus de développement', '#1a6ce0', 'assets/images/slide_6a1b1a2d3e347.jpg', 'top-left', 0, 1, '2026-05-26 17:09:12'),
(2, 1, 'Minebea Intec', 'Minebea Intec est une filiale du groupe Minebea , qui est un fabricant leader mondial des roulements de haute précision', '#e8c9d2', 'assets/images/slide_6a1b1afc86bbb.jpg', 'top-left', 1, 1, '2026-05-26 17:09:12'),
(3, 1, 'KIMO', 'KIMO conçoit et fabrique des instruments de mesure pour le contrôle et la surveillance de l’air en milieu confiné.', '#e4ece4', 'assets/images/slide_6a1b28f419f5f.jpg', 'top-left', 2, 1, '2026-05-26 17:09:12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actualites`
--
ALTER TABLE `actualites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `published_at` (`published_at`),
  ADD KEY `status` (`status`);

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `display_order` (`display_order`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lu` (`lu`),
  ADD KEY `created_at` (`created_at`);

--
-- Index pour la table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `slug_2` (`slug`),
  ADD KEY `status` (`status`);

--
-- Index pour la table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip` (`ip`);

--
-- Index pour la table `marques`
--
ALTER TABLE `marques`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `display_order` (`display_order`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `idx_menu_position` (`menu_id`,`position`);

--
-- Index pour la table `partenaires`
--
ALTER TABLE `partenaires`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `display_order` (`display_order`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `marque_id` (`marque_id`),
  ADD KEY `lettre_alphabet` (`lettre_alphabet`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `featured` (`featured`),
  ADD KEY `active` (`active`);

--
-- Index pour la table `produit_images`
--
ALTER TABLE `produit_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produit_id` (`produit_id`),
  ADD KEY `display_order` (`display_order`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Index pour la table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_slider_id` (`slider_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actualites`
--
ALTER TABLE `actualites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `marques`
--
ALTER TABLE `marques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `partenaires`
--
ALTER TABLE `partenaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `produit_images`
--
ALTER TABLE `produit_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actualites`
--
ALTER TABLE `actualites`
  ADD CONSTRAINT `actualites_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_items_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produits_ibfk_2` FOREIGN KEY (`marque_id`) REFERENCES `marques` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `produit_images`
--
ALTER TABLE `produit_images`
  ADD CONSTRAINT `produit_images_ibfk_1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
