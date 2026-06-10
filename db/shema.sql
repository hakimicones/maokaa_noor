-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 10 juin 2026 à 13:09
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
(16, 1, 'update_product', 'Balance Analytique BM500', '::1', '2026-06-07 16:22:17'),
(17, 1, 'update_product', 'HIAC 9703+', '::1', '2026-06-10 10:16:57');

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
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `display_order`, `active`, `created_at`, `updated_at`, `parent_id`) VALUES
(6, 'Analyseurs d\'humidité', 'analyseurs-d-humidite', NULL, 0, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(7, 'Appareils de mesure portables', 'appareils-de-mesure-portables', NULL, 1, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(8, 'Armoires à filtration', 'armoires-a-filtration', NULL, 2, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(9, 'Balances', 'balances', NULL, 25, 0, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(10, 'Balances de laboratoire', 'balances-de-laboratoire', NULL, 3, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(11, 'Balances industrielles', 'balances-industrielles', NULL, 4, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(12, 'Compteurs de particules air', 'compteur-de-particules-air', NULL, 7, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(13, 'Débitmètre', 'debitmetre', NULL, 9, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(14, 'Détecteurs de gaz', 'detecteurs-de-gaz', NULL, 10, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(15, 'Echantilloneur d\'air', 'echantilloneur-d-air', NULL, 11, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(16, 'Enregistreurs', 'enregistreurs', NULL, 12, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(17, 'Filtration', 'filtration', NULL, 15, 0, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(18, 'Hotte à filtration', 'hottes-a-filtration', NULL, 16, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(19, 'Milieux de cultures', 'milieux-de-cultures', NULL, 17, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(20, 'Pipettes électroniques', 'pipettes', NULL, 18, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(21, 'Pompe Sterisart', 'pompe-sterisart', NULL, 20, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(22, 'Purificateur d\'eau', 'purificateur-d-eau', NULL, 21, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(23, 'Spectrophotomètres', 'spectrophotometre', NULL, 23, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(24, 'Thermomètres', 'thermometres', NULL, 24, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(25, 'Indicateurs', 'indicateurs', NULL, 0, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', 11),
(26, 'Plate-Formes de pesée', 'plate-formes-de-pesee', NULL, 1, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', 11),
(27, 'Accessoires', 'accessoires', NULL, 2, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', 11),
(28, 'Consommable pour essai de stérilité', 'consommables-pour-essai-de-sterilite', NULL, 8, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(29, 'Filtres membrane', 'filtres-membranes', NULL, 13, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(30, 'Filtres seringue', 'filtres-seringues', NULL, 14, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(31, 'Rampes de filtration', 'rampes-de-filtration', NULL, 22, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(32, 'Poids étalons', 'jeu-de-poids', NULL, 19, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(36, 'Accessoires - Balances de laboratoire', 'accessoires-2', NULL, 0, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', 10),
(37, 'Centrale d\'acquisition: Akivision', 'centrale-d-acquisition-akivision', NULL, 5, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL),
(38, 'Compteur de particules dans les liquides', 'compteur-de-particules-dans-les-liquides', NULL, 6, 1, '2026-06-09 12:07:13', '2026-06-09 12:07:13', NULL);

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
(14, 'MA37', 'ma', NULL, NULL, 'assets/images/products/ma37-min.jpg', 'assets/Data_MA37_W--2053-e.pdf', 6, NULL, NULL, NULL, 1, 0, 100, '2016-02-22 13:40:18', '2026-06-09 17:45:30'),
(16, 'MA160', 'ma-160', NULL, NULL, 'assets/images/products/ma160-min.jpg', 'assets/brochuresData_MA160_W--2054-e.pdf', 6, NULL, NULL, NULL, 1, 0, 80, '2016-02-22 14:04:50', '2026-06-09 17:48:42'),
(17, 'LMA200PM', 'sartorius-lma200pm', NULL, NULL, 'assets/images/products/ma200pm-min.jpg', 'assets/brochuresDS-LMA200PM-f.pdf', 6, NULL, NULL, NULL, 1, 0, 70, '2016-02-22 14:08:12', '2026-06-09 17:48:42'),
(18, 'MA100C', 'ma100c', NULL, NULL, 'assets/images/products/ma100c-min.jpg', 'assets/brochuresDS-MA100C-f.pdf', 6, NULL, NULL, NULL, 1, 0, 90, '2016-02-22 14:10:42', '2026-06-09 17:48:42'),
(19, 'CT 110', 'ct-110', NULL, NULL, 'images/products/appareils-de-mesure-portables/ct110-min.jpg', 'images/products/appareils-de-mesure-portables/FT_ct_110.pdf', 7, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 14:13:14', '2016-02-22 14:15:52'),
(20, 'HQ 210', 'hq-210', NULL, NULL, 'images/products/appareils-de-mesure-portables/hq210-min.jpg', 'images/products/appareils-de-mesure-portables/FT_hq_210.pdf', 7, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 14:15:55', '2016-02-22 14:19:47'),
(21, 'MP 210', 'mp-210', NULL, NULL, 'images/products/appareils-de-mesure-portables/mp210-min.jpg', 'images/products/appareils-de-mesure-portables/FT_mp_210.pdf', 7, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 14:19:51', '2016-02-22 14:21:59'),
(22, 'VT 210', 'vt-210', NULL, NULL, 'images/products/appareils-de-mesure-portables/vt210-min.jpg', 'images/products/appareils-de-mesure-portables/FT_vt_210.pdf', 7, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 14:22:02', '2016-02-22 14:23:11'),
(23, 'AMI 310', 'images-products-appareils-de-mesure-portables-vt210-min-jpg', NULL, NULL, 'images/products/appareils-de-mesure-portables/ami310-min.jpg', 'images/products/appareils-de-mesure-portables/FT-portable-AMI310.pdf', 7, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 14:23:15', '2016-02-22 14:27:35'),
(24, 'Filtres Asura', 'filtres-asura', NULL, NULL, 'images/products/armoires-a-filtration/filtre-asura-min.jpg', 'images/products/armoires-a-filtration/brochure_Asura_FR_bd_31102013101013.pdf', 8, NULL, NULL, NULL, 1, 0, 80, '2016-02-22 14:24:48', '2016-02-22 14:26:54'),
(25, 'Smart Armoires', 'smart-armoires', NULL, NULL, 'images/products/armoires-a-filtration/captair-smart-min.jpg', 'images/products/armoires-a-filtration/SMART_Armoires_FR.pdf', 8, NULL, NULL, NULL, 1, 0, 100, '2016-02-22 14:31:13', '2016-02-22 14:32:31'),
(26, 'Practum', 'practum', NULL, NULL, 'images/products/balances/balances-de-laboratoire/practum-min.jpg', 'images/products/balances/balances-de-laboratoire/Data_Practum_WL-2002-f.pdf', 9, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 14:32:35', '2016-02-22 14:36:38'),
(27, 'Secura', 'balances', NULL, NULL, 'images/products/balances/balances-de-laboratoire/secura-min.jpg', 'images/products/balances/balances-de-laboratoire/Data_Secura_WL-2000-f.pdf', 9, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 14:36:41', '2016-02-22 14:38:07'),
(28, 'Poids etalons', 'accessoires', NULL, NULL, 'images/products/balances/balances-de-laboratoire/accessoires/weight-min.jpg', 'images/products/balances/balances-de-laboratoire/accessoires/BRO-Weights-f.pdf', 9, NULL, NULL, NULL, 0, 0, 0, '2016-02-22 14:38:11', '2016-03-20 10:04:16'),
(29, 'CAWP', 'cawp', NULL, NULL, 'images/products/balances/balances-industrielles/cawp-min.jpg', 'images/products/balances/balances-industrielles/DS-CAWP-Balances_completes-f.pdf', 9, NULL, NULL, NULL, 0, 0, 0, '2016-02-22 14:40:01', '2016-02-22 14:53:46'),
(30, 'CAWS', 'caws', NULL, NULL, 'images/products/balances/balances-industrielles/caws-min.jpg', 'images/products/balances/balances-industrielles/DS-CAWS-Balances_completes-f.pdf', 9, NULL, NULL, NULL, 0, 0, 0, '2016-02-22 14:53:49', '2016-02-22 14:55:08'),
(31, 'MWS', 'mws', NULL, NULL, 'images/products/balances/balances-industrielles/mws-min.jpg', 'images/products/balances/balances-industrielles/DS-MWS-Balances_completes-f.pdf', 9, NULL, NULL, NULL, 0, 0, 0, '2016-02-22 14:55:12', '2016-02-22 14:56:41'),
(32, 'SIWA', 'siwa', NULL, NULL, 'images/products/balances/balances-industrielles/signum-min.jpg', 'images/products/balances/balances-industrielles/DS-Signum-Advanced-f.pdf', 9, NULL, NULL, NULL, 0, 0, 0, '2016-02-22 14:56:45', '2016-02-22 14:59:13'),
(33, 'MET ONE HHPC+', 'met-one-hhpc', NULL, NULL, 'images/products/compteur-de-particules-air/handheld-particle-counters-min.jpg', 'images/products/compteur-de-particules-air/Handheld-Airborne-Particle-Counter-MET-ONE-HHPC-Series-Brochure-UK-2.pdf', 12, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 15:03:10', '2016-02-22 15:07:37'),
(34, 'MET ONE 3400', 'images-products-compteur-de-particules-air-handheld-particle-counters-min-jpg', NULL, NULL, 'images/products/compteur-de-particules-air/met-one-3400-min.jpg', 'images/products/compteur-de-particules-air/MET-ONE-3400-Airborne-Particle-Counter-Series-Brochure.pdf', 12, NULL, NULL, NULL, 1, 0, 0, '2016-02-22 15:07:41', '2016-02-23 08:30:47'),
(35, 'DBM610', 'dbm610', NULL, NULL, 'images/products/debitmetre/dbm210-min.jpg', 'images/products/debitmetre/FT_dbm_610.pdf', 13, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:30:50', '2016-02-23 08:35:06'),
(36, 'QRAE II', 'qrae-ii', NULL, NULL, 'images/products/detecteurs-de-gaz/qraeii-min.jpg', 'images/products/detecteurs-de-gaz/FT_qraeii.pdf', 14, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:35:12', '2016-02-23 08:36:30'),
(37, 'ToxiRAEII-NH3 / ToxiRAEII-O2', 'toxiraeii-nh3-toxiraeii-o2', NULL, NULL, 'images/products/detecteurs-de-gaz/toxi-raeii-min.jpg', 'images/products/detecteurs-de-gaz/FT_toxi_raeii_nh3_o2.pdf', 14, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:36:36', '2016-02-23 08:38:08'),
(38, 'AirPort MD8', 'airport-md8', NULL, NULL, 'images/products/echantilloneur-d-air/mdb-airport-min.jpg', 'images/products/echantilloneur-d-air/MD8_Airport.pdf', 15, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:38:13', '2016-02-23 08:39:19'),
(39, 'KT 120 / KH 120', 'kt-120-kh-120', NULL, NULL, 'images/products/enregistreurs/kistock120-min.jpg', 'images/products/enregistreurs/FT_kistock_120.pdf', 16, NULL, NULL, NULL, 1, 0, 80, '2016-02-23 08:39:22', '2016-02-23 08:41:23'),
(40, 'KT 220 / KH 220 / KTT 220', 'kt-220-kh-220-ktt-220', NULL, NULL, 'images/products/enregistreurs/kistock220-min.jpg', 'images/products/enregistreurs/FT_kistock_220.pdf', 16, NULL, NULL, NULL, 1, 0, 60, '2016-02-23 08:41:26', '2016-02-23 08:42:25'),
(41, 'KT50 / KH50', 'kt50-kh50', NULL, NULL, 'images/products/enregistreurs/kt50kh50-min.jpg', 'images/products/enregistreurs/FT_kt_50_kh_50.pdf', 16, NULL, NULL, NULL, 1, 0, 100, '2016-02-23 08:42:28', '2016-02-23 08:43:31'),
(42, 'Minisart Syringe Filters', 'minisart-syringe-filters', NULL, NULL, 'images/products/filtration/minisart-min.jpg', 'images/products/filtration/Broch_Minisart-Product-Overview_SL-0012-pièce-jointe.pdf', 30, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:43:34', '2016-03-20 13:52:02'),
(43, 'Laboratory Filtration', 'laboratory-filtration', NULL, NULL, 'images/products/filtration/lab-filtration-min.jpg', 'images/products/filtration/Cata_Lab-Filtration_SLU0006-e.pdf', 17, NULL, NULL, NULL, 0, 0, 0, '2016-02-23 08:48:57', '2016-02-23 08:50:49'),
(44, 'Microfilters', 'microfilters', NULL, NULL, 'images/products/filtration/membranes-min.jpg', 'images/products/filtration/membranes.pdf', 29, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:50:52', '2016-03-20 13:51:41'),
(45, 'Rampe 6 postes 500ml', 'rampe-6-postes-500ml', NULL, NULL, 'images/products/filtration/rampe-6postes-min.jpg', 'images/products/filtration/rampe-6poste-500ml.pdf', 31, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:52:24', '2016-03-20 13:52:53'),
(46, 'Rampe de filtration 3 postes 500ml', 'rampe-de-filtration-combisart-3-postes-500ml', NULL, NULL, 'images/products/filtration/rampe-3postes-min.jpg', 'images/products/filtration/Rampe-de-filtration-Combisart-3POSTES-500ml.pdf', 31, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 08:55:29', '2016-03-20 13:52:43'),
(47, 'Filtre Asura', 'filtre-asura', NULL, NULL, 'images/products/hottes-a-filtration/asura-min.jpg', 'images/products/hottes-a-filtration/brochure_Asura_FR_bd_31102013101013.pdf', 18, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 09:01:00', '2016-02-23 09:02:53'),
(48, 'Captair Smart', 'captair-smart', NULL, NULL, 'images/products/hottes-a-filtration/amrt-hottes-min.jpg', 'images/products/SMART_hottes_FR.pdf', 18, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 09:02:56', '2016-02-23 09:04:05'),
(49, 'Contrôle microbiologique', 'controle-microbiologique', NULL, NULL, 'images/products/milieux-de-cultures/microbio-min.jpg', 'images/products/milieux-de-cultures/Broch_Microbiological_Testing_SM-4017-f[1].pdf', 19, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 09:04:08', '2016-02-23 09:07:07'),
(50, 'Liquid Handling', 'liquid-handling', NULL, NULL, 'images/products/pipettes/lh-min.jpg', 'images/products/pipettes/Cata_Liquid-Handling_SUL0002-e.pdf', 20, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 09:07:10', '2016-02-23 09:15:10'),
(51, 'Universal Pump', 'universal-pump', NULL, NULL, 'images/products/pompe-sterisart/steristart-min.jpg', 'images/products/pompe-sterisart/Broch_New-Sterisart-Universal-Pump_SLD1003-e.pdf', 21, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 09:15:13', '2016-02-23 09:16:43'),
(52, 'Water Purification Systems', 'water-purification-systems', NULL, NULL, 'images/products/purificateur-d-eau/arium-min.jpg', 'images/products/purificateur-d-eau/Broch_arium_Water_Purification_Systems_SL-1532-e.pdf', 22, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 09:16:47', '2016-02-23 09:18:07'),
(53, 'UVILINE 8100', 'uviline-8100', NULL, NULL, 'images/products/spectrophotometre/uviline8100-min.jpg', 'images/products/spectrophotometre/Fiche-Uviline-8100.pdf', 23, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 09:18:10', '2016-02-23 10:08:27'),
(54, 'UVILINE 9100 & 9400', 'fiche-uviline-9100-9400-pdf', NULL, NULL, 'images/products/spectrophotometre/uviline-9100-9400-min.jpg', 'images/products/spectrophotometre/Fiche-Uviline-9100-9400.pdf', 23, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 10:08:30', '2016-02-23 10:10:01'),
(55, 'KIRAY 100', 'kiray-100', NULL, NULL, 'images/products/thermometres/kiray100-min.jpg', 'images/products/thermometres/FT_kiray_100.pdf', 24, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 10:10:03', '2016-02-23 10:12:23'),
(56, 'KIRAY 200', 'kiray-200', NULL, NULL, 'images/products/thermometres/kiray200-min.jpg', 'images/products/thermometres/FT_kiray_200.pdf', 24, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 10:12:26', '2016-02-23 10:18:23'),
(57, 'KIRAY 300', 'kiray-300', NULL, NULL, 'images/products/thermometres/kiray300-min.jpg', 'images/products/thermometres/FT_kiray_300.pdf', 24, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 10:18:26', '2016-02-23 10:28:35'),
(58, 'TK 110 – TK 112', 'tk-110-tk-112', NULL, NULL, 'images/products/thermometres/tk110-tk112-min.jpg', 'images/products/thermometres/FT_tk_110_tk_112.pdf', 24, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 10:28:38', '2016-02-23 10:29:50'),
(59, 'TR 110 – TR 112', 'tr-110-tr-112', NULL, NULL, 'images/products/thermometres/tr110-tr112-min.jpg', 'images/products/thermometres/FT_tr_110_tr_112', 24, NULL, NULL, NULL, 1, 0, 0, '2016-02-23 10:29:53', '2016-02-23 10:30:51'),
(60, 'Printer YDP 20', 'printer-ydp-20', NULL, NULL, 'images/products/printer-ydp20-min.jpg', NULL, 36, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 10:11:42', '2016-03-23 09:39:38'),
(61, 'Printer YDP 40', 'printer-ydp-40', NULL, NULL, 'images/products/printer-ydp40-min.jpg', NULL, 36, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 10:14:01', '2016-03-23 09:39:06'),
(62, 'Midrics', 'midrics', NULL, NULL, 'images/products/midrics-min.jpg', 'images/products/midrics.pdf', 25, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 13:57:04', '2016-03-20 14:02:50'),
(63, 'Combic 1', 'combic-1', NULL, NULL, 'images/products/combic-1-min.jpg', 'images/products/combic-1.pdf', 25, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 13:59:16', '2016-03-20 14:03:15'),
(64, 'Combic 2', 'combic-2', NULL, NULL, 'images/products/combic-2-min.jpg', 'images/products/combic-2.pdf', 25, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:00:29', '2016-03-20 14:01:24'),
(65, 'Combic 3', 'combic-3', NULL, NULL, 'images/products/combic-3-min.jpg', 'brochures/products/combic-3.pdf', 25, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:01:26', '2026-06-10 08:21:37'),
(66, 'Maxxis 5', 'maxxis-5', NULL, NULL, 'images/products/maxxis5-min.jpg', 'images/products/maxxis5.pdf', 25, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:03:26', '2016-03-20 14:04:20'),
(67, 'Plate-forme IS', 'plate-forme-is', NULL, NULL, 'images/products/plate-forme-is-min.jpg', 'images/products/plate-forme-is.pdf', 26, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:04:31', '2016-03-30 09:02:47'),
(68, 'Plate-forme IF', 'plate-forme-if', NULL, NULL, 'images/products/plate-forme-if-min.jpg', 'images/products/plate-forme-if.pdf', 26, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:05:48', '2016-03-20 14:24:55'),
(69, 'Pese-Palette IU', 'pese-palette-iu', NULL, NULL, 'images/products/pese-palette-iu-min.jpg', NULL, 26, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:26:04', '2016-03-20 14:32:42'),
(70, 'YDP04', 'ydp04', NULL, NULL, 'images/products/ydp04-min.jpg', NULL, 27, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:33:13', '2016-03-30 09:02:29'),
(71, 'STERISART NF', 'sterisart', NULL, NULL, 'images/products/sterisart-nf-min.jpg', NULL, 28, NULL, NULL, NULL, 1, 0, 0, '2016-03-20 14:34:58', '2016-03-20 14:36:05'),
(72, 'Poids fil', 'poids-fil', NULL, NULL, 'images/products/poids-fil-min.jpg', NULL, 32, NULL, NULL, NULL, 1, 0, 0, '2016-03-21 11:03:24', '2016-03-21 11:04:30'),
(73, 'Poids à gorge de préhension', 'poids-a-gorge-de-prehension', NULL, NULL, 'images/products/poids-a--gorge-min.jpg', NULL, 32, NULL, NULL, NULL, 1, 0, 0, '2016-03-21 11:04:39', '2016-03-21 11:05:15'),
(74, 'Poids lamelle', 'poids-lamelle', NULL, NULL, 'images/products/poids-lamelle-min.jpg', NULL, 32, NULL, NULL, NULL, 1, 0, 0, '2016-03-21 11:05:33', '2016-03-21 11:06:02'),
(75, 'Poids cylindriques', 'poids-cylindriques', NULL, NULL, 'images/products/poids-cylindriques-min.jpg', NULL, 32, NULL, NULL, NULL, 1, 0, 0, '2016-03-21 11:06:04', '2016-03-21 11:06:36'),
(76, 'Jeux de poids', 'jeux-de-poids', NULL, NULL, 'images/products/jeux-de-poids-min.jpg', NULL, 32, NULL, NULL, NULL, 1, 0, 0, '2016-03-21 11:06:42', '2016-03-21 11:07:29'),
(77, 'Accessoires', 'accessoires-2', NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, 0, 0, '2016-03-23 08:48:22', '2016-03-23 09:37:13'),
(78, 'Cubis', 'cubiqs', NULL, NULL, 'images/products/cubis-min.jpg', 'images/products/cubis.pdf', 10, NULL, NULL, NULL, 1, 0, 0, '2016-03-23 10:04:33', '2016-03-23 10:05:33'),
(79, 'Quintix', 'quintix', NULL, NULL, 'images/products/quintix-min.jpg', 'images/products/quintix.pdf', 10, NULL, NULL, NULL, 1, 0, 0, '2016-03-23 10:06:50', '2016-03-23 10:07:49'),
(80, 'Akivision', 'akivision', NULL, NULL, 'images/products/akivision-min.jpg', 'images/products/ft-akivision.pdf', 37, NULL, NULL, NULL, 1, 0, 0, '2016-03-24 14:44:04', '2016-03-24 14:45:09'),
(81, 'UVILINE 9300 & 9600', 'uviline-9300-9600', NULL, NULL, 'images/products/uviline-min.jpg', 'images/products/uviline.pdf', 23, NULL, NULL, NULL, 1, 0, 0, '2016-03-30 09:10:02', '2016-03-30 09:10:52'),
(82, 'HIAC 9703+', 'compteur-de-particules-dans-les-liquides', '', '', '/Hebergement/maokaa/includes/../assets/images/products/hiac_9703.jpg', '/Hebergement/maokaa/includes/../assets/brochures/hiac9703.pdf', 38, NULL, NULL, '', 1, 0, 0, '2016-06-25 09:55:01', '2026-06-10 10:16:57');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
