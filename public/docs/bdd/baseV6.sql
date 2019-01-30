-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 26 Janvier 2019 à 19:42
-- Version du serveur :  5.7.20-0ubuntu0.16.04.1
-- Version de PHP :  7.2.12-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `adopte`
--

-- --------------------------------------------------------

--
-- Structure de la table `additional`
--

CREATE TABLE `additional` (
  `id` int(11) NOT NULL,
  `type_info` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit_card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `additional`
--

INSERT INTO `additional` (`id`, `type_info`, `content`, `visit_card_id`) VALUES
(1, 'assert', 'Humble', 1),
(2, 'assert', 'Honnête', 1),
(3, 'assert', 'Autonome', 1),
(4, 'assert', 'Mignon', 2),
(5, 'assert', 'Impressionnable', 2),
(6, 'assert', 'Timide', 2),
(7, 'assert', 'Solitaire', 3),
(8, 'assert', 'Indépendante', 2),
(9, 'assert', 'Agile', 2),
(14, 'interest', 'Les guerriers géant d\'Elbaf', 1),
(15, 'interest', 'Les plantes médicinales', 2),
(16, 'interest', 'Les ponéglyphes', 3);

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_order` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `published_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_story` tinyint(1) NOT NULL,
  `slug` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `list_order`, `status`, `published_at`, `updated_at`, `user_id`, `is_story`, `slug`) VALUES
(1, 'Qu\'est ce que "Adopte un alternant" ?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam dapibus sapien sapien, in ultricies ante aliquet id. Suspendisse pulvinar mi sit amet tellus elementum, eu efficitur mauris suscipit. Quisque varius nisl iaculis commodo blandit. Pellentesque eget ligula condimentum, finibus dolor vel, ultrices leo. Etiam metus justo, lobortis non neque in, mollis consectetur urna. Ut in nisl at tellus tristique ullamcorper. Donec egestas, quam eget vehicula feugiat, felis diam consequat felis, vitae dignissim lacus lorem ac nunc. Vivamus leo sapien, faucibus ut dolor non, consequat maximus nibh. Vestibulum et hendrerit magna, vestibulum faucibus nibh. Mauris eget mi ut sem hendrerit fermentum vel semper libero. Donec euismod sed justo ac elementum. Ut aliquet velit sed aliquam ultricies. Quisque id interdum ligula, non suscipit dui. Suspendisse eros est, bibendum sit amet mattis eget, dapibus ac eros.\r\n\r\nSed ut nisl nec turpis pretium tincidunt. Nulla facilisi. Aenean condimentum sem vel ipsum fringilla venenatis. Pellentesque tempor vitae eros in iaculis. Curabitur porta lectus eget posuere laoreet. Praesent id bibendum nunc. Maecenas scelerisque scelerisque tellus ac tincidunt. Quisque sit amet viverra orci. Fusce non metus odio. Suspendisse nulla massa, bibendum sollicitudin metus id, facilisis pretium nibh. Curabitur non pharetra nibh, eget molestie enim. Vivamus et magna fermentum, faucibus nisi vitae, vulputate purus. Aenean et massa nec nunc placerat molestie.\r\n\r\nMorbi mauris libero, tristique eu tempus pulvinar, blandit et metus. Mauris consectetur efficitur lectus sed varius. Integer sed tempus libero, vel consequat mauris. Etiam congue, risus et sodales bibendum, massa lectus mollis orci, in condimentum arcu ante eu nibh. Sed eu nulla vitae massa imperdiet imperdiet a id urna. Nulla vel orci id eros eleifend rhoncus. Fusce id elit nulla. Donec vestibulum tempus sapien, a ultricies nunc. In hac habitasse platea dictumst. Nulla vitae hendrerit nisi.', 1, 1, '2019-01-21 17:20:41', NULL, 4, 0, 'qu-est-ce-que-adopte-un-alternant'),
(2, 'Comment fonctionne le site ?', 'Morbi mauris libero, tristique eu tempus pulvinar, blandit et metus. Mauris consectetur efficitur lectus sed varius. Integer sed tempus libero, vel consequat mauris. Etiam congue, risus et sodales bibendum, massa lectus mollis orci, in condimentum arcu ante eu nibh. Sed eu nulla vitae massa imperdiet imperdiet a id urna. Nulla vel orci id eros eleifend rhoncus. Fusce id elit nulla. Donec vestibulum tempus sapien, a ultricies nunc. In hac habitasse platea dictumst. Nulla vitae hendrerit nisi.\r\n\r\nNunc at euismod leo, eget mattis tellus. Integer dapibus quam erat, eu rhoncus odio dapibus at. Phasellus eget urna pellentesque, tempus urna sed, rutrum augue. Nunc quis placerat mauris. Nulla et risus tempus tellus sodales placerat sed non quam. Aliquam feugiat ante at elit tincidunt, quis tincidunt lorem auctor. Aliquam ut justo commodo, tempor ligula non, commodo turpis. Etiam a nisi rutrum, dictum metus non, tempus ex. Duis sit amet justo egestas, maximus risus eget, interdum nisi. Aliquam non ultricies elit, in malesuada sapien. Nulla id dapibus ante. Cras porttitor felis sit amet risus aliquet auctor. Nunc eu libero nec risus elementum venenatis. Etiam orci enim, euismod sit amet dolor vel, accumsan laoreet massa.\r\n\r\nCras efficitur nibh purus, et posuere orci fermentum sit amet. Praesent auctor erat leo, sit amet ullamcorper lacus lobortis ac. Donec nunc ante, faucibus a tellus sed, accumsan viverra felis. Mauris odio nisl, suscipit ac ex vitae, bibendum interdum est. Sed dignissim erat ligula, quis tristique nibh fermentum eget. Donec sed eros placerat, imperdiet eros sit amet, pharetra ipsum. Cras eget nunc nec est viverra consectetur. Donec varius, magna vel faucibus iaculis, justo ligula consequat elit, ut convallis est lacus sed metus. Suspendisse nec neque enim. Nunc vel purus vel nisl semper aliquet id ac diam. Nulla facilisi. Vestibulum suscipit velit in feugiat imperdiet. Nullam consectetur, leo eu porttitor interdum, erat urna vulputate velit, quis mollis libero nisi ullamcorper felis.', 2, 1, '2019-01-21 15:16:42', NULL, 4, 0, 'comment-fonctionne-le-site'),
(3, 'Qu\'est ce que l\'alternance ?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec dui et neque vulputate posuere. Donec imperdiet arcu id rhoncus venenatis. Pellentesque sapien orci, placerat non orci at, volutpat vehicula neque. Nulla luctus felis in nulla volutpat sodales. Fusce posuere tincidunt volutpat. Sed viverra hendrerit pulvinar. Duis venenatis turpis felis, sed porttitor sem aliquam in. Curabitur id metus lectus. Nam posuere malesuada ipsum in rutrum. Fusce at tristique sapien, ac ornare libero. Praesent sagittis felis id metus lobortis, ac semper augue malesuada. Praesent placerat tellus at turpis posuere semper. Nullam euismod vehicula lacus, eget accumsan tellus elementum ut. Nam sollicitudin eros fermentum nulla tempor facilisis. Curabitur non ullamcorper velit, eu suscipit dui. Vestibulum vitae enim vitae metus semper suscipit.\r\n\r\nVivamus sit amet fermentum eros, in tempus risus. Ut sapien nulla, lacinia ut arcu sit amet, tempus lobortis orci. Mauris consectetur dolor augue, eu viverra neque placerat ut. Donec quis elit fermentum nisi elementum condimentum. Maecenas sodales sit amet leo vel accumsan. Pellentesque arcu ex, tempus eu quam a, faucibus venenatis diam. Phasellus ultrices justo et ex volutpat, at malesuada eros varius. Donec malesuada vestibulum augue porta vestibulum. Maecenas efficitur purus quis dictum auctor. Vivamus porta sapien vitae pellentesque eleifend.\r\n\r\nProin dignissim, orci ac dictum viverra, mi felis convallis lacus, at venenatis dolor velit vel mi. Nullam porttitor nisi et fringilla cursus. In condimentum rutrum tellus vestibulum luctus. Phasellus dictum sit amet mauris nec placerat. Ut sed tristique est. Nullam faucibus lorem justo, quis ultrices risus pulvinar eu. Duis ultricies leo et tellus posuere facilisis. Maecenas non sem erat.\r\n\r\nSed sed dictum ligula. Nullam aliquam magna sit amet egestas mattis. Etiam rhoncus bibendum eros, varius suscipit ex iaculis quis. Sed aliquam sollicitudin dolor, non euismod odio gravida in. Suspendisse eleifend faucibus diam eget fermentum. Pellentesque mi orci, posuere non justo ac, condimentum consequat odio. Nullam vehicula scelerisque purus, quis vulputate orci. Mauris viverra magna ante, vitae consectetur risus suscipit ac. Pellentesque eu finibus nunc, maximus porttitor odio. Quisque bibendum dui sit amet eleifend gravida. Cras ultrices iaculis malesuada. Curabitur consectetur ante eu lacus iaculis, vel cursus tellus ullamcorper. Proin semper luctus porta. Morbi tempus nunc erat, sed consequat lorem vehicula non. Pellentesque ac quam sit amet tortor scelerisque eleifend eget luctus orci.\r\n\r\nAenean fermentum molestie quam ut tincidunt. Sed volutpat eu dui vel lobortis. Quisque vulputate efficitur rhoncus. Sed purus massa, porttitor semper porttitor a, finibus eu nisi. Duis faucibus egestas augue at laoreet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris feugiat tempus augue, vitae lacinia ligula ornare at. Nam cursus nibh quis aliquam convallis. Sed malesuada quis lectus a pulvinar. Quisque efficitur, massa nec euismod euismod, sem dui varius urna, sed scelerisque neque nisi nec lacus. Praesent ac euismod purus. Mauris fermentum lacus ut erat ullamcorper vehicula. Ut vitae porta turpis. Morbi pharetra, urna nec sodales imperdiet, elit nisl ultricies mauris, eu dapibus lectus erat non sapien. Nullam ullamcorper sapien ultricies, bibendum nunc eget, aliquet lacus. Nullam tristique varius enim ac ullamcorper.', 3, 1, '2019-01-21 16:00:39', NULL, 4, 0, 'qu-est-ce-que-l-alternance'),
(4, 'En quelques clic j\'ai trouvé un alternant !', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec dui et neque vulputate posuere. Donec imperdiet arcu id rhoncus venenatis. Pellentesque sapien orci, placerat non orci at, volutpat vehicula neque. Nulla luctus felis in nulla volutpat sodales. Fusce posuere tincidunt volutpat. Sed viverra hendrerit pulvinar. Duis venenatis turpis felis, sed porttitor sem aliquam in. Curabitur id metus lectus. Nam posuere malesuada ipsum in rutrum. Fusce at tristique sapien, ac ornare libero. Praesent sagittis felis id metus lobortis, ac semper augue malesuada. Praesent placerat tellus at turpis posuere semper. Nullam euismod vehicula lacus, eget accumsan tellus elementum ut. Nam sollicitudin eros fermentum nulla tempor facilisis. Curabitur non ullamcorper velit, eu suscipit dui. Vestibulum vitae enim vitae metus semper suscipit.', 1, 1, '2019-01-21 19:26:00', NULL, 4, 1, 'en-quelques-clic-j-ai-trouve-un-alternant'),
(5, 'Un tas de nakama à porté de la main !', 'Vivamus sit amet fermentum eros, in tempus risus. Ut sapien nulla, lacinia ut arcu sit amet, tempus lobortis orci. Mauris consectetur dolor augue, eu viverra neque placerat ut. Donec quis elit fermentum nisi elementum condimentum. Maecenas sodales sit amet leo vel accumsan. Pellentesque arcu ex, tempus eu quam a, faucibus venenatis diam. Phasellus ultrices justo et ex volutpat, at malesuada eros varius. Donec malesuada vestibulum augue porta vestibulum. Maecenas efficitur purus quis dictum auctor. Vivamus porta sapien vitae pellentesque eleifend.\r\n\r\nProin dignissim, orci ac dictum viverra, mi felis convallis lacus, at venenatis dolor velit vel mi. Nullam porttitor nisi et fringilla cursus. In condimentum rutrum tellus vestibulum luctus. Phasellus dictum sit amet mauris nec placerat. Ut sed tristique est. Nullam faucibus lorem justo, quis ultrices risus pulvinar eu. Duis ultricies leo et tellus posuere facilisis. Maecenas non sem erat.', 2, 1, '2019-01-21 14:20:00', NULL, 4, 1, 'un-tas-de-nakama-a-porte-de-la-main'),
(6, 'Ça fonctionne ! En 15 jours seulement j\'ai pu trouver une alternance', 'Aenean fermentum molestie quam ut tincidunt. Sed volutpat eu dui vel lobortis. Quisque vulputate efficitur rhoncus. Sed purus massa, porttitor semper porttitor a, finibus eu nisi. Duis faucibus egestas augue at laoreet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris feugiat tempus augue, vitae lacinia ligula ornare at. Nam cursus nibh quis aliquam convallis. Sed malesuada quis lectus a pulvinar. Quisque efficitur, massa nec euismod euismod, sem dui varius urna, sed scelerisque neque nisi nec lacus. Praesent ac euismod purus. Mauris fermentum lacus ut erat ullamcorper vehicula. Ut vitae porta turpis. Morbi pharetra, urna nec sodales imperdiet, elit nisl ultricies mauris, eu dapibus lectus erat non sapien. Nullam ullamcorper sapien ultricies, bibendum nunc eget, aliquet lacus. Nullam tristique varius enim ac ullamcorper.', 3, 1, '2019-01-21 18:53:03', NULL, 4, 1, 'ca-fonctionne-en-15-jours-seulement-j-ai-pu-trouver-une-alternance'),
(7, 'Adieu pôle emploi, grâce à adopte un alternant j\'ai été contacté par une dizaines d\'entreprise en moins d\'un mois !', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec dui et neque vulputate posuere. Donec imperdiet arcu id rhoncus venenatis. Pellentesque sapien orci, placerat non orci at, volutpat vehicula neque. Nulla luctus felis in nulla volutpat sodales. Fusce posuere tincidunt volutpat. Sed viverra hendrerit pulvinar. Duis venenatis turpis felis, sed porttitor sem aliquam in. Curabitur id metus lectus. Nam posuere malesuada ipsum in rutrum. Fusce at tristique sapien, ac ornare libero. Praesent sagittis felis id metus lobortis, ac semper augue malesuada. Praesent placerat tellus at turpis posuere semper. Nullam euismod vehicula lacus, eget accumsan tellus elementum ut. Nam sollicitudin eros fermentum nulla tempor facilisis. Curabitur non ullamcorper velit, eu suscipit dui. Vestibulum vitae enim vitae metus semper suscipit.', 4, 1, '2019-01-21 12:39:23', NULL, 4, 1, 'adieu-pole-emploi-grace-a-adopte-un-alternant-j-ai-ete-contacte-par-une-dizaine-d-entreprise-en-moins-d-un-mois');

-- --------------------------------------------------------

--
-- Structure de la table `award_level`
--

CREATE TABLE `award_level` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `award_level`
--

INSERT INTO `award_level` (`id`, `name`) VALUES
(1, 'Brevet des collèges'),
(2, 'Bac'),
(3, 'Bts'),
(4, 'Licence'),
(5, 'Master'),
(6, 'DUT'),
(7, 'IUT'),
(8, 'Bac +2'),
(9, 'Bac +3');

-- --------------------------------------------------------

--
-- Structure de la table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `department`
--

INSERT INTO `department` (`id`, `name`, `code`) VALUES
(1, 'Ain', '01'),
(2, 'Aisne', '02'),
(3, 'Allier', '03'),
(4, 'Alpes-de-Haute-Provence', '04'),
(5, 'Hautes-alpes', '05'),
(6, 'Alpes-maritimes', '06'),
(7, 'Ardèche', '07'),
(8, 'Ardennes', '08'),
(9, 'Ariège', '09'),
(10, 'Aube', '10'),
(11, 'Aude', '11'),
(12, 'Aveyron', '12'),
(13, 'Bouches-du-Rhône', '13'),
(14, 'Calvados', '14'),
(15, 'Cantal', '15'),
(16, 'Charente', '16'),
(17, 'Charente', '17'),
(18, 'Cher', '18'),
(19, 'Corrèze', '19'),
(20, 'Corse-du-sud', '2a'),
(21, 'Haute-Corse', '2b'),
(22, 'Côte-d\'Or', '21'),
(23, 'Côtes-d\'Armor', '22'),
(24, 'Creuse', '23'),
(25, 'Dordogne', '24'),
(26, 'Doubs', '25'),
(27, 'Drôme', '26'),
(28, 'Eure', '27'),
(29, 'Eure-et-loir', '28'),
(30, 'Finistère', '29'),
(31, 'Gard', '30'),
(32, 'Haute-garonne', '31'),
(33, 'Gers', '32'),
(34, 'Gironde', '33'),
(35, 'Hérault', '34'),
(36, 'Ille-et-vilaine', '35'),
(37, 'Indre', '36'),
(38, 'Indre-et-loire', '37'),
(39, 'Isère', '38'),
(40, 'Jura', '39'),
(41, 'Landes', '40'),
(42, 'Loir-et-cher', '41'),
(43, 'Loire', '42'),
(44, 'Haute-loire', '43'),
(45, 'Loire-atlantique', '44'),
(46, 'Loiret', '45'),
(47, 'Lot', '46'),
(48, 'Lot-et-garonne', '47'),
(49, 'Lozère', '48'),
(50, 'Maine-et-loire', '49'),
(51, 'Manche', '50'),
(52, 'Marne', '51'),
(53, 'Haute-marne', '52'),
(54, 'Mayenne', '53'),
(55, 'Meurthe-et-moselle', '54'),
(56, 'Meuse', '55'),
(57, 'Morbihan', '56'),
(58, 'Moselle', '57'),
(59, 'Nièvre', '58'),
(60, 'Nord', '59'),
(61, 'Oise', '60'),
(62, 'Orne', '61'),
(63, 'Pas-de-calais', '62'),
(64, 'Puy-de-dôme', '63'),
(65, 'Pyrénées-atlantiques', '64'),
(66, 'Hautes-Pyrénées', '65'),
(67, 'Pyrénées-orientales', '66'),
(68, 'Bas-rhin', '67'),
(69, 'Haut-rhin', '68'),
(70, 'Rhône', '69'),
(71, 'Haute-saône', '70'),
(72, 'Saône-et-loire', '71'),
(73, 'Sarthe', '72'),
(74, 'Savoie', '73'),
(75, 'Haute-savoie', '74'),
(76, 'Paris', '75'),
(77, 'Seine-maritime', '76'),
(78, 'Seine-et-marne', '77'),
(79, 'Yvelines', '78'),
(80, 'Deux-sèvres', '79'),
(81, 'Somme', '80'),
(82, 'Tarn', '81'),
(83, 'Tarn-et-garonne', '82'),
(84, 'Var', '83'),
(85, 'Vaucluse', '84'),
(86, 'Vendée', '85'),
(87, 'Vienne', '86'),
(88, 'Haute-vienne', '87'),
(89, 'Vosges', '88'),
(90, 'Yonne', '89'),
(91, 'Territoire de belfort', '90'),
(92, 'Essonne', '91'),
(93, 'Hauts-de-seine', '92'),
(94, 'Seine-Saint-Denis', '93'),
(95, 'Val-de-marne', '94'),
(96, 'Val-d\'oise', '95'),
(97, 'Guadeloupe', '971'),
(98, 'Martinique', '972'),
(99, 'Guyane', '973'),
(100, 'La réunion', '974'),
(101, 'Mayotte', '976');

-- --------------------------------------------------------

--
-- Structure de la table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `started_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ended_at` datetime DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit_card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `experience`
--

INSERT INTO `experience` (`id`, `company_name`, `started_at`, `status`, `ended_at`, `description`, `visit_card_id`) VALUES
(37, 'Alabasta', '2018-06-19 00:00:00', 0, '2019-01-15 00:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut convallis metus, ac ultrices justo. Curabitur tincidunt nibh sit amet nibh rhoncus fermentum nec vitae tellus. Ut eget maximus nibh. Vivamus efficitur augue nec auctor rutrum. Pellentesque pretium justo sed rhoncus pharetra. Sed lacus ipsum, pulvinar non diam ut, luctus faucibus augue. Donec arcu enim, interdum in suscipit quis, sollicitudin a magna. Sed eget maximus ex. Vestibulum eu mollis augue. Sed sodales ex eget odio vulputate, vitae aliquet purus finibus. Pellentesque suscipit nisi eget nibh luctus, ut laoreet sem viverra. Curabitur a volutpat felis. Aenean posuere, sapien ultricies ultricies scelerisque, metus ligula tincidunt diam, in volutpat enim ipsum lacinia dolor. Nullam porta id augue a elementum. Proin feugiat venenatis est sed malesuada.', 1),
(38, 'East Blue', '2018-06-03 00:00:00', 0, '2018-11-07 00:00:00', 'Sed sodales ex eget odio vulputate, vitae aliquet purus finibus. Pellentesque suscipit nisi eget nibh luctus, ut laoreet sem viverra. Curabitur a volutpat felis. Aenean posuere, sapien ultricies ultricies scelerisque, metus ligula tincidunt diam, in volutpat enim ipsum lacinia dolor. Nullam porta id augue a elementum. Proin feugiat venenatis est sed malesuada.', 2),
(39, 'Red Line', '2018-04-08 00:00:00', 0, '2019-01-01 00:00:00', 'Pellentesque suscipit nisi eget nibh luctus, ut laoreet sem viverra. Curabitur a volutpat felis. Aenean posuere, sapien ultricies ultricies scelerisque, metus ligula tincidunt diam, in volutpat enim ipsum lacinia dolor. Nullam porta id augue a elementum. Proin feugiat venenatis est sed malesuada.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut convallis metus, ac ultrices justo. Curabitur tincidunt nibh sit amet nibh rhoncus fermentum nec vitae tellus. Ut eget maximus nibh. Vivamus efficitur augue nec auctor rutrum.', 3),
(40, 'South Blue', '2018-08-15 00:00:00', 1, NULL, 'Pellentesque suscipit nisi eget nibh luctus, ut laoreet sem viverra. Curabitur a volutpat felis. Aenean posuere, sapien ultricies ultricies scelerisque.', 2),
(41, 'Baratie', '2018-11-07 00:00:00', 1, NULL, 'Nullam porta id augue a elementum. Proin feugiat venenatis est sed malesuada.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut convallis metus, ac ultrices justo. Curabitur tincidunt nibh sit amet nibh rhoncus fermentum nec vitae tellus. Ut eget maximus nibh. Vivamus efficitur augue nec auctor rutrum. ', 1),
(42, 'Arlong Park', '2018-09-11 00:00:00', 1, NULL, 'Pellentesque pretium justo sed rhoncus pharetra. Sed lacus ipsum, pulvinar non diam ut, luctus faucibus augue. Donec arcu enim, interdum in suscipit quis, sollicitudin a magna. Sed eget maximus ex. Vestibulum eu mollis augue. Sed sodales ex eget odio vulputate, vitae aliquet purus finibus. ', 3);

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `id` int(11) NOT NULL,
  `award_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `started_at` datetime NOT NULL,
  `status` smallint(6) NOT NULL,
  `obtained_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `visit_card_id` int(11) DEFAULT NULL,
  `award_level_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `formation`
--

INSERT INTO `formation` (`id`, `award_name`, `started_at`, `status`, `obtained_at`, `ended_at`, `visit_card_id`, `award_level_id`, `school_id`) VALUES
(2, 'Médecine douce et homéopathie', '2018-07-01 00:00:00', 0, '2019-01-05 00:00:00', '2018-11-06 00:00:00', 2, 3, 1),
(3, 'Archéologie et lecture des langues anciennes', '2016-10-01 00:00:00', 0, '2017-10-01 00:00:00', '2017-09-01 00:00:00', 3, 8, 2),
(4, 'Snipper d\'élite', '2018-11-13 00:00:00', 0, '2019-04-19 00:00:00', '2019-02-08 00:00:00', 1, 5, 4),
(6, 'Titre de grand gourou de la médecine', '2019-01-17 00:00:00', 2, NULL, '2019-04-13 00:00:00', 2, 6, 7),
(7, 'Titre de la plus grande archéologue de tout les temps ', '2019-01-10 00:00:00', 2, NULL, '2019-07-12 00:00:00', 3, 8, 6),
(8, 'Menteur professionnel', '2019-02-08 00:00:00', 1, NULL, '2019-06-08 00:00:00', 1, 6, 2),
(9, 'Concepteur de rumble ball', '2019-03-05 00:00:00', 1, NULL, '2019-05-18 00:00:00', 2, 4, 5),
(10, 'Technicien de fouille', '2019-02-14 00:00:00', 1, NULL, '2019-11-12 00:00:00', 3, 9, 3),
(12, 'Ingénieur spécialisé en Kabuto', '2018-09-11 00:00:00', 2, NULL, '2019-04-11 00:00:00', 1, 4, 6);

-- --------------------------------------------------------

--
-- Structure de la table `is_apprenticeship`
--

CREATE TABLE `is_apprenticeship` (
  `id` int(11) NOT NULL,
  `academic_pace` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `formation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `is_candidate`
--

CREATE TABLE `is_candidate` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `is_candidate`
--

INSERT INTO `is_candidate` (`id`, `phone_number`, `picture`, `user_id`) VALUES
(1, '+33628563341', '', 1),
(2, '+33664883942', 'chopper.jpeg', 2),
(3, '+33653084139', 'robin.jpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `is_candidate_is_recruiter`
--

CREATE TABLE `is_candidate_is_recruiter` (
  `is_candidate_id` int(11) NOT NULL,
  `is_recruiter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `is_candidate_is_recruiter`
--

INSERT INTO `is_candidate_is_recruiter` (`is_candidate_id`, `is_recruiter_id`) VALUES
(1, 2),
(1, 3),
(2, 1),
(3, 1),
(3, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `is_recruiter`
--

CREATE TABLE `is_recruiter` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_location` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_custom` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `is_recruiter`
--

INSERT INTO `is_recruiter` (`id`, `company_name`, `phone_number`, `company_location`, `email_custom`, `user_id`) VALUES
(1, 'Merry & Nakama', '+33693584460', 'Toulon', 'Vivamus sit amet fermentum eros, in tempus risus. Ut sapien nulla, lacinia ut arcu sit amet, tempus lobortis orci. Mauris consectetur dolor augue, eu viverra neque placerat ut. Donec quis elit fermentum nisi elementum condimentum. Maecenas sodales sit amet leo vel accumsan. Pellentesque arcu ex, tempus eu quam a, faucibus venenatis diam. Phasellus ultrices justo et ex volutpat, at malesuada eros varius. Donec malesuada vestibulum augue porta vestibulum. Maecenas efficitur purus quis dictum auctor. Vivamus porta sapien vitae pellentesque eleifend.\r\n\r\nProin dignissim, orci ac dictum viverra, mi felis convallis lacus, at venenatis dolor velit vel mi. Nullam porttitor nisi et fringilla cursus. In condimentum rutrum tellus vestibulum luctus. Phasellus dictum sit amet mauris nec placerat. Ut sed tristique est. Nullam faucibus lorem justo, quis ultrices risus pulvinar eu. Duis ultricies leo et tellus posuere facilisis. Maecenas non sem erat.', 5),
(2, 'Thousand Sunny', '+33638469925', 'Paris', 'Aenean fermentum molestie quam ut tincidunt. Sed volutpat eu dui vel lobortis. Quisque vulputate efficitur rhoncus. Sed purus massa, porttitor semper porttitor a, finibus eu nisi. Duis faucibus egestas augue at laoreet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris feugiat tempus augue, vitae lacinia ligula ornare at. Nam cursus nibh quis aliquam convallis. Sed malesuada quis lectus a pulvinar. Quisque efficitur, massa nec euismod euismod, sem dui varius urna, sed scelerisque neque nisi nec lacus. Praesent ac euismod purus. Mauris fermentum lacus ut erat ullamcorper vehicula. Ut vitae porta turpis. Morbi pharetra, urna nec sodales imperdiet, elit nisl ultricies mauris, eu dapibus lectus erat non sapien. Nullam ullamcorper sapien ultricies, bibendum nunc eget, aliquet lacus. Nullam tristique varius enim ac ullamcorper.', 6),
(3, 'Grand line ', '+33616830496', 'Lyon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nec dui et neque vulputate posuere. Donec imperdiet arcu id rhoncus venenatis. Pellentesque sapien orci, placerat non orci at, volutpat vehicula neque. Nulla luctus felis in nulla volutpat sodales. Fusce posuere tincidunt volutpat. Sed viverra hendrerit pulvinar. Duis venenatis turpis felis, sed porttitor sem aliquam in. Curabitur id metus lectus. Nam posuere malesuada ipsum in rutrum. Fusce at tristique sapien, ac ornare libero. Praesent sagittis felis id metus lobortis, ac semper augue malesuada. Praesent placerat tellus at turpis posuere semper. Nullam euismod vehicula lacus, eget accumsan tellus elementum ut. Nam sollicitudin eros fermentum nulla tempor facilisis. Curabitur non ullamcorper velit, eu suscipit dui. Vestibulum vitae enim vitae metus semper suscipit.\r\n\r\nVivamus sit amet fermentum eros, in tempus risus. Ut sapien nulla, lacinia ut arcu sit amet, tempus lobortis orci. Mauris consectetur dolor augue, eu viverra neque placerat ut. Donec quis elit fermentum nisi elementum condimentum. Maecenas sodales sit amet leo vel accumsan. Pellentesque arcu ex, tempus eu quam a, faucibus venenatis diam. Phasellus ultrices justo et ex volutpat, at malesuada eros varius. Donec malesuada vestibulum augue porta vestibulum. Maecenas efficitur purus quis dictum auctor. Vivamus porta sapien vitae pellentesque eleifend.\r\n\r\nProin dignissim, orci ac dictum viverra, mi felis convallis lacus, at venenatis dolor velit vel mi. Nullam porttitor nisi et fringilla cursus. In condimentum rutrum tellus vestibulum luctus. Phasellus dictum sit amet mauris nec placerat. Ut sed tristique est. Nullam faucibus lorem justo, quis ultrices risus pulvinar eu. Duis ultricies leo et tellus posuere facilisis. Maecenas non sem erat.', 7);

-- --------------------------------------------------------

--
-- Structure de la table `is_story`
--

CREATE TABLE `is_story` (
  `id` int(11) NOT NULL,
  `witness_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `is_story`
--

INSERT INTO `is_story` (`id`, `witness_name`, `article_id`) VALUES
(1, 'Sanji Vinsmoke', 4),
(2, 'Monkey D Luffy', 5),
(3, 'Nico Robin', 6),
(4, 'Tony Chopper', 7);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20190121174649'),
('20190121184658'),
('20190123110338'),
('20190123122356'),
('20190126122417'),
('20190126135443'),
('20190126143219');

-- --------------------------------------------------------

--
-- Structure de la table `mobility`
--

CREATE TABLE `mobility` (
  `id` int(11) NOT NULL,
  `town_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `mobility`
--

INSERT INTO `mobility` (`id`, `town_name`, `department_id`) VALUES
(1, 'Toulon', 84),
(2, 'Marseille', 13),
(3, 'Paris', 76),
(4, 'Lyon', 70),
(5, 'Nice', 6);

-- --------------------------------------------------------

--
-- Structure de la table `mobility_visit_card`
--

CREATE TABLE `mobility_visit_card` (
  `mobility_id` int(11) NOT NULL,
  `visit_card_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `mobility_visit_card`
--

INSERT INTO `mobility_visit_card` (`mobility_id`, `visit_card_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 2),
(4, 1),
(5, 3);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `code` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `code`, `name`) VALUES
(1, 'ROLE_ADMIN', 'Administrateur'),
(2, 'ROLE_RECRUITER', 'Recruteur'),
(3, 'ROLE_CANDIDATE', 'Candidat');

-- --------------------------------------------------------

--
-- Structure de la table `school`
--

CREATE TABLE `school` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `school`
--

INSERT INTO `school` (`id`, `name`) VALUES
(1, 'O\'clock'),
(2, 'Web School Factory '),
(3, 'SupdeWeb'),
(4, 'Cifacom'),
(5, 'Coding Academy'),
(6, 'IIM Léonard de Vinci '),
(7, 'Ecole européenne des métiers de l\'internet');

-- --------------------------------------------------------

--
-- Structure de la table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `skill`
--

INSERT INTO `skill` (`id`, `name`) VALUES
(1, 'PHP'),
(2, 'Javascript'),
(3, 'Node.js'),
(4, 'React'),
(5, 'Symfony'),
(6, 'C'),
(7, 'C++'),
(8, 'C#'),
(9, 'Java'),
(10, 'Bootstrap');

-- --------------------------------------------------------

--
-- Structure de la table `skill_visit_card`
--

CREATE TABLE `skill_visit_card` (
  `skill_id` int(11) NOT NULL,
  `visit_card_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `skill_visit_card`
--

INSERT INTO `skill_visit_card` (`skill_id`, `visit_card_id`) VALUES
(1, 2),
(2, 1),
(3, 3),
(4, 3),
(5, 1),
(5, 2),
(7, 3),
(8, 1),
(8, 2),
(10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `token`, `status`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Usopp', 'Sogeking', 'sogeking@gmail.com', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', NULL, 1, '2019-01-21 20:56:06', NULL, 3),
(2, 'Tony', 'Chopper', 'tonytony@gmail.com', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', NULL, 1, '2019-01-21 19:20:13', NULL, 3),
(3, 'Robin', 'Nico', 'nico.robin@gmail.com', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', NULL, 1, '2019-01-21 21:44:29', NULL, 3),
(4, 'Nami', 'Belmer', 'treasur@gmail.com', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', NULL, 1, '2019-01-21 22:27:51', NULL, 1),
(5, 'Luffy', 'Monkey D.', 'kaizoku@gmail.com', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', NULL, 1, '2019-01-21 12:20:48', NULL, 2),
(6, 'Zoro', 'Roronoa', 'marimo@gmail.com', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', NULL, 1, '2019-01-21 09:43:05', NULL, 2),
(7, 'Sanji', 'Vinsmoke', 'namiswaaan@gmail.com', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', NULL, 1, '2019-01-21 14:07:33', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `visit_card`
--

CREATE TABLE `visit_card` (
  `id` int(11) NOT NULL,
  `about` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `adopted` tinyint(1) NOT NULL,
  `visibility_choice` smallint(6) NOT NULL,
  `is_candidate_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `visit_card`
--

INSERT INTO `visit_card` (`id`, `about`, `adopted`, `visibility_choice`, `is_candidate_id`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quam eros, accumsan a augue quis, suscipit ornare nibh. Mauris erat arcu, porttitor a pharetra vel, blandit et dui. Aliquam faucibus est nec ultricies cursus. Phasellus et mattis risus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque mauris elit, varius vitae congue at, tempor et nisi. Proin ex nulla, iaculis in elementum vitae, posuere varius elit. Donec a vestibulum ligula, a tristique nunc. Phasellus auctor imperdiet volutpat. Sed eu nunc non dui tristique cursus vitae et neque. Donec placerat ex ac ante convallis, ac interdum ex eleifend. Suspendisse porttitor enim tortor, sed aliquam ligula sodales eu.\r\n\r\nCurabitur ultricies dolor eu felis aliquet mattis. Maecenas at volutpat nibh. Pellentesque id commodo nisl. Nullam felis ante, imperdiet at nunc ac, ornare mollis libero. Sed gravida in risus id sagittis. Morbi in neque velit. Cras eu est sapien. Sed condimentum justo magna, ut dictum tortor ornare id. Mauris condimentum nibh eget mattis rutrum. Nam volutpat, odio tempor blandit finibus, orci lorem sollicitudin lorem, a malesuada nibh lectus at erat. Maecenas lobortis dictum justo eu facilisis. Nam eu ultrices ligula. Nulla nec dolor a ante interdum viverra id in risus. Aliquam ligula odio, faucibus nec ex ac, tincidunt lacinia purus. Nam maximus eu ligula convallis iaculis. Aliquam erat volutpat.', 0, 1, 1),
(2, 'Vivamus at lacinia leo, in bibendum ipsum. Sed elit augue, volutpat id blandit quis, vulputate quis magna. Fusce malesuada lobortis tortor, vitae lobortis velit. Nam in imperdiet ligula. Maecenas eget tristique dolor, ut efficitur quam. Etiam rhoncus, enim at egestas tempor, erat mi laoreet erat, eu euismod libero mi eget lorem. Cras sed fringilla magna. Pellentesque euismod lectus vitae augue accumsan fermentum. Praesent sit amet malesuada leo. Duis turpis elit, molestie quis posuere id, convallis vel dui. Donec nec iaculis nisl. Pellentesque odio leo, suscipit quis erat quis, sagittis sagittis eros. Mauris diam arcu, mollis fringilla feugiat quis, venenatis quis odio. Maecenas ut ex nec turpis eleifend accumsan sagittis nec leo.', 1, 2, 2),
(3, 'Ut vitae malesuada velit. Vestibulum sed nisl finibus, blandit libero nec, finibus ex. Nulla congue placerat nisl in molestie. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam varius eros lacus, vitae molestie mi suscipit at. Aenean ac justo sed nisi elementum iaculis sed sed sapien. Nulla tincidunt placerat turpis, vel imperdiet orci convallis a. Proin pulvinar semper ultrices. Maecenas id tincidunt dolor, sit amet euismod ante. Fusce felis justo, tincidunt vel nisi et, porttitor feugiat nisi. Praesent et neque non ligula suscipit convallis.\r\n\r\nUt scelerisque massa ac suscipit scelerisque. Aenean ut sollicitudin ligula. Proin porttitor dignissim diam sit amet rutrum. Ut justo turpis, auctor et ullamcorper non, molestie pellentesque eros. Suspendisse varius placerat lorem sed gravida. Phasellus sed ante lacus. Nulla ipsum eros, scelerisque ac porttitor sed, ultrices sit amet erat.', 0, 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `website`
--

CREATE TABLE `website` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit_card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `website`
--

INSERT INTO `website` (`id`, `name`, `link`, `visit_card_id`) VALUES
(1, 'Les vérité de Usopp', 'http://lecoinmanga-fr.over-blog.com/2017/08/les-mensonges-d-usopp.html', 1),
(2, 'Journal d\'un tanuki', 'http://fr.onepiece.wikia.com/wiki/Tony_Tony_Chopper', 2),
(3, 'Histoire de ponéglyphe', 'http://fr.onepiece.wikia.com/wiki/Nico_Robin', 3);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `additional`
--
ALTER TABLE `additional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8BD05CE61C459EE7` (`visit_card_id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E66A76ED395` (`user_id`);

--
-- Index pour la table `award_level`
--
ALTER TABLE `award_level`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_590C1031C459EE7` (`visit_card_id`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_404021BF1C459EE7` (`visit_card_id`),
  ADD KEY `IDX_404021BF5D231872` (`award_level_id`),
  ADD KEY `IDX_404021BFC32A47EE` (`school_id`);

--
-- Index pour la table `is_apprenticeship`
--
ALTER TABLE `is_apprenticeship`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4FBCC8985200282E` (`formation_id`);

--
-- Index pour la table `is_candidate`
--
ALTER TABLE `is_candidate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CF4AE32BA76ED395` (`user_id`);

--
-- Index pour la table `is_candidate_is_recruiter`
--
ALTER TABLE `is_candidate_is_recruiter`
  ADD PRIMARY KEY (`is_candidate_id`,`is_recruiter_id`),
  ADD KEY `IDX_55CA0D17B103645F` (`is_candidate_id`),
  ADD KEY `IDX_55CA0D1735D5019D` (`is_recruiter_id`);

--
-- Index pour la table `is_recruiter`
--
ALTER TABLE `is_recruiter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D97E5EB7A76ED395` (`user_id`);

--
-- Index pour la table `is_story`
--
ALTER TABLE `is_story`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A7AAE7487294869C` (`article_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `mobility`
--
ALTER TABLE `mobility`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D650201CAE80F5DF` (`department_id`);

--
-- Index pour la table `mobility_visit_card`
--
ALTER TABLE `mobility_visit_card`
  ADD PRIMARY KEY (`mobility_id`,`visit_card_id`),
  ADD KEY `IDX_F396FE588D92EAA4` (`mobility_id`),
  ADD KEY `IDX_F396FE581C459EE7` (`visit_card_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `skill_visit_card`
--
ALTER TABLE `skill_visit_card`
  ADD PRIMARY KEY (`skill_id`,`visit_card_id`),
  ADD KEY `IDX_DCC5B9635585C142` (`skill_id`),
  ADD KEY `IDX_DCC5B9631C459EE7` (`visit_card_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D93D649D60322AC` (`role_id`);

--
-- Index pour la table `visit_card`
--
ALTER TABLE `visit_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C94C6511B103645F` (`is_candidate_id`);

--
-- Index pour la table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_476F5DE71C459EE7` (`visit_card_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `additional`
--
ALTER TABLE `additional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `award_level`
--
ALTER TABLE `award_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT pour la table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `is_apprenticeship`
--
ALTER TABLE `is_apprenticeship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `is_candidate`
--
ALTER TABLE `is_candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `is_recruiter`
--
ALTER TABLE `is_recruiter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `is_story`
--
ALTER TABLE `is_story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `mobility`
--
ALTER TABLE `mobility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `visit_card`
--
ALTER TABLE `visit_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `website`
--
ALTER TABLE `website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `additional`
--
ALTER TABLE `additional`
  ADD CONSTRAINT `FK_8BD05CE61C459EE7` FOREIGN KEY (`visit_card_id`) REFERENCES `visit_card` (`id`);

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `FK_590C1031C459EE7` FOREIGN KEY (`visit_card_id`) REFERENCES `visit_card` (`id`);

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `FK_404021BF1C459EE7` FOREIGN KEY (`visit_card_id`) REFERENCES `visit_card` (`id`),
  ADD CONSTRAINT `FK_404021BF5D231872` FOREIGN KEY (`award_level_id`) REFERENCES `award_level` (`id`),
  ADD CONSTRAINT `FK_404021BFC32A47EE` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`);

--
-- Contraintes pour la table `is_apprenticeship`
--
ALTER TABLE `is_apprenticeship`
  ADD CONSTRAINT `FK_4FBCC8985200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`);

--
-- Contraintes pour la table `is_candidate`
--
ALTER TABLE `is_candidate`
  ADD CONSTRAINT `FK_CF4AE32BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `is_candidate_is_recruiter`
--
ALTER TABLE `is_candidate_is_recruiter`
  ADD CONSTRAINT `FK_55CA0D1735D5019D` FOREIGN KEY (`is_recruiter_id`) REFERENCES `is_recruiter` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_55CA0D17B103645F` FOREIGN KEY (`is_candidate_id`) REFERENCES `is_candidate` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `is_recruiter`
--
ALTER TABLE `is_recruiter`
  ADD CONSTRAINT `FK_D97E5EB7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `is_story`
--
ALTER TABLE `is_story`
  ADD CONSTRAINT `FK_A7AAE7487294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `mobility`
--
ALTER TABLE `mobility`
  ADD CONSTRAINT `FK_D650201CAE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);

--
-- Contraintes pour la table `mobility_visit_card`
--
ALTER TABLE `mobility_visit_card`
  ADD CONSTRAINT `FK_F396FE581C459EE7` FOREIGN KEY (`visit_card_id`) REFERENCES `visit_card` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F396FE588D92EAA4` FOREIGN KEY (`mobility_id`) REFERENCES `mobility` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `skill_visit_card`
--
ALTER TABLE `skill_visit_card`
  ADD CONSTRAINT `FK_DCC5B9631C459EE7` FOREIGN KEY (`visit_card_id`) REFERENCES `visit_card` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DCC5B9635585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Contraintes pour la table `visit_card`
--
ALTER TABLE `visit_card`
  ADD CONSTRAINT `FK_C94C6511B103645F` FOREIGN KEY (`is_candidate_id`) REFERENCES `is_candidate` (`id`);

--
-- Contraintes pour la table `website`
--
ALTER TABLE `website`
  ADD CONSTRAINT `FK_476F5DE71C459EE7` FOREIGN KEY (`visit_card_id`) REFERENCES `visit_card` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
