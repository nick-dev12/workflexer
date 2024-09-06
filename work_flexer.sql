-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 06 sep. 2024 à 19:57
-- Version du serveur : 8.3.0
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `work_flexer`
--

-- --------------------------------------------------------

--
-- Structure de la table `accepte_candidat`
--

DROP TABLE IF EXISTS `accepte_candidat`;
CREATE TABLE IF NOT EXISTS `accepte_candidat` (
  `accepte_id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `offre_id` int NOT NULL,
  `users_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`accepte_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `passe` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `mail`, `phone`, `image`, `remember_token`, `passe`) VALUES
(2, 'Nick EFFE', 'webgeniuses12@gmail.com', '785303879', '65f050e7b1c79_image-2.png', '6cda6490b15df43e762786cb08aa92bd', '$2y$10$3y8AOY2PXud7E.jFclAOPOgyf1nw4EJODTHwJ2MlX/zGyadkl0HYa');

-- --------------------------------------------------------

--
-- Structure de la table `admin_message`
--

DROP TABLE IF EXISTS `admin_message`;
CREATE TABLE IF NOT EXISTS `admin_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `compte` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_message`
--

INSERT INTO `admin_message` (`id`, `utilisateur_id`, `compte`, `message`, `mail`, `nom`, `date`) VALUES
(10, '1', 'compte professionnel', 'bonjour ', 'webgeniuses12@gmail.com', 'nick jomas effe work-flexer', '2024-03-12 09:24:22'),
(11, '2', 'compte entreprise', 'chance', 'webgeniuses12@gmail.com', 'OYONO', '2024-03-12 10:03:50'),
(12, '2', 'admin', 'bonjour nous comprenon votre souci', 'webgeniuses12@gmail.com', 'Nick EFFE', '2024-03-12 10:42:32'),
(13, '1', 'admin', 'bonjour nous comprenons votre souci', 'webgeniuses12@gmail.com', 'Nick EFFE', '2024-03-12 10:43:01'),
(14, '2', 'compte entreprise', 'message ', 'webgeniuses12@gmail.com', 'OYONO', '2024-03-12 11:53:27');

-- --------------------------------------------------------

--
-- Structure de la table `appel_offre`
--

DROP TABLE IF EXISTS `appel_offre`;
CREATE TABLE IF NOT EXISTS `appel_offre` (
  `id_appel` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  `titre` varchar(250) NOT NULL,
  `messages` text NOT NULL,
  `sujet` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_appel`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categori` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `categori`) VALUES
(1, 'Finance et comptabilité'),
(2, 'Design et création'),
(3, 'Conseil et gestion d\'entreprise'),
(4, 'Tourisme et hôtellerie'),
(5, 'Informatique et tech');

-- --------------------------------------------------------

--
-- Structure de la table `centre_interet`
--

DROP TABLE IF EXISTS `centre_interet`;
CREATE TABLE IF NOT EXISTS `centre_interet` (
  `interet_id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `interet` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`interet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `centre_interet`
--

INSERT INTO `centre_interet` (`interet_id`, `users_id`, `interet`, `date`) VALUES
(1, 1, 'je veux de toi', '2024-03-07 13:01:08'),
(2, 5, 'Musique ', '2024-03-26 18:46:43'),
(3, 5, 'Basketball ', '2024-03-26 18:47:04'),
(4, 5, 'Programmation ', '2024-03-26 18:47:28');

-- --------------------------------------------------------

--
-- Structure de la table `certificat_users`
--

DROP TABLE IF EXISTS `certificat_users`;
CREATE TABLE IF NOT EXISTS `certificat_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `certificat` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `certificat_users`
--

INSERT INTO `certificat_users` (`id`, `users_id`, `certificat`, `date`) VALUES
(1, 1, 'je suis ce que je suis', '2024-03-07 12:59:30');

-- --------------------------------------------------------

--
-- Structure de la table `competence_users`
--

DROP TABLE IF EXISTS `competence_users`;
CREATE TABLE IF NOT EXISTS `competence_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` varchar(250) NOT NULL,
  `competence` varchar(300) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `competence_users`
--

INSERT INTO `competence_users` (`id`, `users_id`, `competence`, `date`) VALUES
(1, '1', 'je suis', '2024-03-07 12:57:48'),
(2, '1', 'tu est', '2024-03-07 12:57:58'),
(3, '1', 'il est', '2024-03-07 12:58:09'),
(4, '1', 'nous somme', '2024-03-07 12:58:23'),
(5, '1', 'Teste', '2024-03-08 05:40:20'),
(6, '5', 'Mysql', '2024-03-26 18:25:05'),
(7, '5', 'PHP', '2024-03-26 18:25:21'),
(14, '5', 'sql', '2024-07-19 19:20:33'),
(9, '5', 'Gestion de base de données ', '2024-03-26 18:25:57'),
(10, '5', 'Maintenance des serveurs web', '2024-03-26 18:26:23'),
(11, '5', 'JavaScript ', '2024-03-26 18:26:53'),
(12, '5', 'HTML CSS', '2024-03-26 18:27:14'),
(13, '5', 'Git GitHub ', '2024-03-26 18:28:19'),
(15, '12', 'je suis ', '2024-07-29 15:25:37'),
(16, '12', 'tu est', '2024-07-29 15:25:50'),
(17, '12', 'je veux ', '2024-07-29 15:28:03'),
(18, '12', 'tu ne medis rien', '2024-07-29 15:28:24'),
(19, '12', 'je veux de toit', '2024-07-29 15:28:38');

-- --------------------------------------------------------

--
-- Structure de la table `compte_entreprise`
--

DROP TABLE IF EXISTS `compte_entreprise`;
CREATE TABLE IF NOT EXISTS `compte_entreprise` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `entreprise` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `types` varchar(250) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `images` varchar(250) NOT NULL,
  `taille` varchar(250) NOT NULL,
  `categorie` varchar(250) NOT NULL,
  `remember_token` varchar(250) NOT NULL,
  `verification` varchar(250) NOT NULL,
  `verification_statut` varchar(250) NOT NULL,
  `passe` varchar(255) DEFAULT NULL,
  `cpasse` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `compte_entreprise`
--

INSERT INTO `compte_entreprise` (`id`, `nom`, `entreprise`, `mail`, `phone`, `types`, `ville`, `images`, `taille`, `categorie`, `remember_token`, `verification`, `verification_statut`, `passe`, `cpasse`) VALUES
(1, ' OYONO effe nick jomas', 'LUDVANNE je suis le chef de bandit ', 'oyonoeffe11@gmail.com', 785303879, 'agence d\'informatique', 'Daka', '_bb.jpg', '1', '', '4380e99c9ae67bcf26e097e6bf514ef7', 'qwUvZNp4i', 'verified', '$2y$10$IDYmQT59k5/6RcG8pn7L8OclwLE3Ne.petjOcna84bdwhMBH9IvM.', NULL),
(4, 'ludvanne oyono effe nick ludvanne junior', 'advanted groupe', 'webgeniuses12@gmail.com', 78, 'agence d\'informatique', 'Newark', '66a7ab248605c_ministere.png', '11_49', 'Ingénierie et architecture', '', '5qVt2D8V0', '', '$2y$10$jhJMqYiXo1E0C.vzAemtBOAnQVhFFUZUOHO/0rHo9xUa9EPRCEfh.', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `description_entreprise`
--

DROP TABLE IF EXISTS `description_entreprise`;
CREATE TABLE IF NOT EXISTS `description_entreprise` (
  `id_description` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `descriptions` text NOT NULL,
  `liens` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_description`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `description_entreprise`
--

INSERT INTO `description_entreprise` (`id_description`, `entreprise_id`, `descriptions`, `liens`, `date`) VALUES
(1, 1, '<p>je suis la</p>', '', '2024-05-18 06:02:44');

-- --------------------------------------------------------

--
-- Structure de la table `description_users`
--

DROP TABLE IF EXISTS `description_users`;
CREATE TABLE IF NOT EXISTS `description_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `description_users`
--

INSERT INTO `description_users` (`id`, `users_id`, `description`, `date`) VALUES
(1, '1', 'je suis ce que je suis', '2024-03-07 12:56:55'),
(2, '5', 'Je suis un développeur web Full Stack passionné, spécialisé dans une gamme variée de langages de programmation, notamment PHP, HTML, CSS, JavaScript, SQL et Python. Avec une solide expérience dans la réalisation de projets web, j\'ai acquis une expertise dans la maintenance des serveurs, la gestion de bases de données et la création d\'API RESTful. Mon parcours professionnel m\'a permis de développer des compétences approfondies dans la conception et le développement d\'applications web robustes ', '2024-03-26 18:09:59'),
(3, '12', 'je suis ', '2024-07-29 15:27:16');

-- --------------------------------------------------------

--
-- Structure de la table `diplome`
--

DROP TABLE IF EXISTS `diplome`;
CREATE TABLE IF NOT EXISTS `diplome` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `diplome` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `diplome`
--

INSERT INTO `diplome` (`id`, `users_id`, `diplome`, `date`) VALUES
(1, 1, 'wejgjaweoigjio', '2024-03-07 12:59:16'),
(2, 5, 'Baccalauréat serie D', '2024-03-26 18:43:02'),
(3, 5, 'Licence en génie informatique ', '2024-03-26 18:43:40');

-- --------------------------------------------------------

--
-- Structure de la table `document_users`
--

DROP TABLE IF EXISTS `document_users`;
CREATE TABLE IF NOT EXISTS `document_users` (
  `document_id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `document` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`document_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `document_users`
--

INSERT INTO `document_users` (`document_id`, `users_id`, `document`, `date`) VALUES
(3, 1, 'namecheap-order-138978909.pdf', '2024-03-10 12:12:47'),
(5, 10, 'AFI1.pdf', '2024-07-21 18:41:28');

-- --------------------------------------------------------

--
-- Structure de la table `formation_users`
--

DROP TABLE IF EXISTS `formation_users`;
CREATE TABLE IF NOT EXISTS `formation_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `moisDebut` varchar(200) NOT NULL,
  `anneeDebut` varchar(200) NOT NULL,
  `moisFin` varchar(250) NOT NULL,
  `anneeFin` varchar(250) NOT NULL,
  `Filiere` varchar(300) NOT NULL,
  `etablissement` varchar(300) NOT NULL,
  `niveau` varchar(259) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `formation_users`
--

INSERT INTO `formation_users` (`id`, `users_id`, `moisDebut`, `anneeDebut`, `moisFin`, `anneeFin`, `Filiere`, `etablissement`, `niveau`, `date`) VALUES
(2, 5, 'octobre', '2019', 'juillet', '2020', 'Terminale Série D', 'Lycée paul Emane Eyegue (Lpee-oloumi)', 'Secondaire', '2024-03-26 18:33:11'),
(3, 5, 'novembre', '2020', 'août', '2021', 'Géni informatiques ', 'Ecole Supérieure Multinationale des Télécommunications (ESMT)', 'Licence1', '2024-03-26 18:40:10'),
(5, 5, 'décembre', '2022', 'mars', '2024', 'Acquisition de compétences à travers des ressources en ligne et des projets personnels.', 'Udemy, Coursera et FreeCodeCamp. YouTube ', 'Master1', '2024-03-26 19:08:37');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `historique_id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`historique_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`historique_id`, `entreprise_id`, `users_id`, `date`) VALUES
(4, 1, 10, '2024-06-20 20:53:18'),
(2, 1, 5, '2024-05-11 21:35:33'),
(5, 1, 14, '2024-07-29 15:05:39'),
(6, 1, 12, '2024-07-29 16:36:26');

-- --------------------------------------------------------

--
-- Structure de la table `historique_users`
--

DROP TABLE IF EXISTS `historique_users`;
CREATE TABLE IF NOT EXISTS `historique_users` (
  `historique_id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  `offre_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`historique_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `historique_users`
--

INSERT INTO `historique_users` (`historique_id`, `entreprise_id`, `users_id`, `offre_id`, `date`) VALUES
(13, 1, 5, 0, '2024-08-14 09:16:11'),
(14, 1, 12, 14, '2024-08-14 12:42:26'),
(12, 1, 5, 14, '2024-07-29 15:57:07');

-- --------------------------------------------------------

--
-- Structure de la table `langue_users`
--

DROP TABLE IF EXISTS `langue_users`;
CREATE TABLE IF NOT EXISTS `langue_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `langue` varchar(200) NOT NULL,
  `niveau` varchar(299) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `langue_users`
--

INSERT INTO `langue_users` (`id`, `users_id`, `langue`, `niveau`, `date`) VALUES
(1, 1, 'sdiojvdoasjvosi', 'professionel', '2024-03-07 13:00:50'),
(2, 5, 'Français ', 'professionel', '2024-03-26 18:46:02'),
(3, 5, 'Anglais ', 'Intermediaire', '2024-03-26 18:46:23');

-- --------------------------------------------------------

--
-- Structure de la table `message1`
--

DROP TABLE IF EXISTS `message1`;
CREATE TABLE IF NOT EXISTS `message1` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  `offre_id` int NOT NULL,
  `statut` varchar(250) NOT NULL,
  `messages` text NOT NULL,
  `indicatif` varchar(250) NOT NULL,
  `sujet` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  `dates` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `message1`
--

INSERT INTO `message1` (`message_id`, `entreprise_id`, `users_id`, `offre_id`, `statut`, `messages`, `indicatif`, `sujet`, `date`, `dates`) VALUES
(2, 2, 1, 1, 'accepter', 'J&#039;espère que vous allez bien ', 'candidat', '', '2024-03-09 11:14:57', '2024-03-19 10:01:07'),
(3, 2, 1, 1, 'accepter', 'bonjour', 'recruteur', '', '2024-03-09 11:15:38', '2024-03-19 10:01:07'),
(4, 2, 1, 0, '', '<p>teste</p>', 'recruteur', '', '0000-00-00 00:00:00', '2024-03-19 10:01:07'),
(5, 2, 1, 0, '', 'bonjour', 'recruteur', 'appel', '0000-00-00 00:00:00', '2024-03-19 10:01:07'),
(6, 2, 1, 0, '', 'bonjour ', 'recruteur', 'appel', '0000-00-00 00:00:00', '2024-03-19 10:01:07'),
(7, 2, 1, 0, '', 'bonjour', 'recruteur', 'appel', 'mardi 19 mars 2024 15:02', '2024-03-19 10:02:24'),
(8, 2, 1, 0, '', 'je veux de toi', 'recruteur', 'appel', 'mardi 19 mars 2024 15:05', '2024-03-19 10:05:46'),
(12, 2, 1, 0, '', 'Bonjour monsieur ', 'candidat', 'appel', 'dimanche 24 mars 2024 15:35', '2024-03-24 10:35:04'),
(10, 2, 1, 0, '', 'comment allez-vous ', 'recruteur', 'appel', 'mardi 19 mars 2024 15:15', '2024-03-19 10:15:04'),
(13, 2, 1, 0, '', 'Je veux', 'candidat', 'appel', 'dimanche 24 mars 2024 15:35', '2024-03-24 10:35:31'),
(59, 1, 5, 0, '', 'je', 'recruteur', 'appel', 'mercredi 14 août 2024 12:09', '2024-08-14 10:09:53'),
(55, 1, 5, 0, '', 'je veux <br />\r\n', 'recruteur', 'appel', 'mercredi 14 août 2024 12:08', '2024-08-14 10:08:51'),
(56, 1, 5, 0, '', 'je veux %$#@ si tu ne veux (pas)', 'recruteur', 'appel', 'mercredi 14 août 2024 12:09', '2024-08-14 10:09:13'),
(57, 1, 5, 0, '', 'je ne suis pas d\'accord avec toi', 'recruteur', 'appel', 'mercredi 14 août 2024 12:09', '2024-08-14 10:09:33'),
(58, 1, 5, 0, '', 'pourquoi tu parle avec moi', 'recruteur', 'appel', 'mercredi 14 août 2024 12:09', '2024-08-14 10:09:49'),
(21, 1, 5, 3, 'accepter', 'ok peut tu me dire ou vous vouler faire votre reunion', 'recruteur', 'postulation', 'dimanche 19 mai 2024 11:36', '2024-05-19 09:36:01'),
(60, 1, 5, 0, '', 'si tu le dis je le ferai sans problème ', 'recruteur', 'appel', 'mercredi 14 août 2024 12:11', '2024-08-14 10:11:49'),
(61, 1, 5, 0, '', '09u07957fyhchgvye56456rtyvjv#^##^#&amp;*%((%(($78jkbjvjhjhhhvjhbk_)=', 'recruteur', 'appel', 'mercredi 14 août 2024 12:15', '2024-08-14 10:15:42'),
(23, 1, 5, 3, 'accepter', 'ok moi de meme ', 'recruteur', 'postulation', 'dimanche 19 mai 2024 12:13', '2024-05-19 10:13:14'),
(24, 1, 5, 3, 'accepter', 'je ne veux pas te dire cela', 'recruteur', 'postulation', 'dimanche 19 mai 2024 12:13', '2024-05-19 10:13:35'),
(25, 1, 5, 3, 'accepter', 'comprends moi', 'recruteur', 'postulation', 'dimanche 19 mai 2024 12:13', '2024-05-19 10:13:50'),
(26, 1, 5, 5, 'accepter', 'bonjour', 'candidat', 'postulation', 'mardi 18 juin 2024 20:31', '2024-06-18 18:31:14'),
(27, 1, 5, 5, 'accepter', 'je suis désolé mais nous ne pouvons pas vous pendre ', 'recruteur', 'postulation', 'mercredi 19 juin 2024 14:16', '2024-06-19 12:16:47'),
(28, 1, 5, 7, 'accepter', 'bonjour  mr je voudrais que tu vienne ', 'recruteur', 'postulation', 'mercredi 19 juin 2024 23:50', '2024-06-19 21:50:28'),
(33, 1, 5, 7, 'accepter', 'bonjour', 'recruteur', 'postulation', 'dimanche 21 juillet 2024 16:01', '2024-07-21 14:01:11'),
(34, 1, 10, 10, 'accepter', 'bonjour', 'recruteur', 'postulation', 'dimanche 21 juillet 2024 16:01', '2024-07-21 14:01:26'),
(35, 1, 10, 10, 'accepter', 'bonjour ', 'candidat', 'postulation', 'dimanche 21 juillet 2024 16:04', '2024-07-21 14:04:01'),
(36, 1, 10, 10, 'accepter', 'ok je veux venir vous rendre visite ', 'candidat', 'postulation', 'dimanche 21 juillet 2024 16:04', '2024-07-21 14:04:33'),
(37, 1, 5, 0, '', 'cc', 'recruteur', 'appel', 'lundi 29 juillet 2024 18:17', '2024-07-29 16:17:50'),
(38, 1, 5, 14, 'accepter', 'Comment tu vas?', 'recruteur', 'postulation', 'lundi 29 juillet 2024 18:19', '2024-07-29 16:19:23'),
(62, 1, 5, 14, 'accepter', 'cc', 'candidat', 'postulation', 'mercredi 14 août 2024 12:18', '2024-08-14 10:18:18'),
(63, 1, 5, 0, '', 'cc', 'candidat', 'appel', 'mercredi 14 août 2024 12:18', '2024-08-14 10:18:34'),
(64, 1, 5, 0, '', 'cc', 'recruteur', 'appel', 'mercredi 14 août 2024 12:18', '2024-08-14 10:18:57'),
(65, 1, 5, 14, 'accepter', 'ccccccccc', 'recruteur', 'postulation', 'mercredi 14 août 2024 12:19', '2024-08-14 10:19:09'),
(67, 1, 12, 0, '', '??????????????????????????????????????????????????????????????????', 'recruteur', 'appel', 'mercredi 14 août 2024 13:15', '2024-08-14 11:15:14'),
(68, 1, 12, 0, '', 'cc<br />\r\n', 'recruteur', 'appel', 'mercredi 14 août 2024 13:49', '2024-08-14 11:49:39'),
(69, 1, 12, 0, '', 'cc', 'recruteur', 'appel', 'mercredi 14 août 2024 13:49', '2024-08-14 11:49:44'),
(70, 1, 12, 0, '', 'cc', 'candidat', 'appel', 'mercredi 14 août 2024 13:53', '2024-08-14 11:53:16'),
(71, 1, 12, 0, '', 'cc', 'candidat', 'appel', 'mercredi 14 août 2024 13:53', '2024-08-14 11:53:20'),
(72, 1, 5, 14, 'accepter', 'cc', 'recruteur', 'postulation', 'mercredi 14 août 2024 13:53', '2024-08-14 11:53:46'),
(73, 1, 5, 14, 'accepter', 'je jpweojpwocjpocjpwefj', 'recruteur', 'postulation', 'mercredi 14 août 2024 13:53', '2024-08-14 11:53:54'),
(74, 1, 5, 14, 'accepter', 'ok merci', 'candidat', 'postulation', 'mercredi 14 août 2024 13:54', '2024-08-14 11:54:41'),
(80, 1, 5, 14, 'accepter', 'd\'accord ', 'candidat', 'postulation', 'mardi 3 septembre 2024 17:59', '2024-09-03 15:59:22'),
(78, 1, 12, 14, 'accepter', 'bonjour ', 'recruteur', 'postulation', 'mercredi 14 août 2024 15:07', '2024-08-14 13:07:04'),
(79, 1, 12, 14, 'accepter', 'je suis toujour la', 'candidat', 'postulation', 'mercredi 14 août 2024 15:08', '2024-08-14 13:08:29');

-- --------------------------------------------------------

--
-- Structure de la table `metier_users`
--

DROP TABLE IF EXISTS `metier_users`;
CREATE TABLE IF NOT EXISTS `metier_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` varchar(200) NOT NULL,
  `metier` varchar(300) NOT NULL,
  `moisDebut` varchar(250) NOT NULL,
  `anneeDebut` varchar(250) NOT NULL,
  `moisFin` varchar(250) NOT NULL,
  `anneeFin` int NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `metier_users`
--

INSERT INTO `metier_users` (`id`, `users_id`, `metier`, `moisDebut`, `anneeDebut`, `moisFin`, `anneeFin`, `description`, `date`) VALUES
(1, '1', 'tete brûlé ', 'février', '1995', 'février', 2015, 'je suis le superviseurs&nbsp;', '2024-03-07 12:57:34'),
(2, '1', 'Développement de site web chez sen-study', 'avril', '1987', 'mai', 2000, 'Je ne veux pas être comme ça et si je ne suis pas avec toi je ne serai pas disponible.', '2024-03-08 16:24:48'),
(3, '5', 'Développeur Web chez Work-Flexer', 'février', '2022', 'mars', 2023, 'Conception et développement du site web Work-Flexer (work-flexer.com) en utilisant PHP.\r\nCréation d\'une plateforme d\'offres d\'emploi en ligne permettant aux recruteurs de publier des offres et aux professionnels de postuler en créant un profil virtuel détaillant leur parcours.SQL, JS, HTML, CSS, PHP.', '2024-03-26 18:22:43'),
(4, '5', 'Développeur Web chez Samba Market', 'septembre', '2023', 'mars', 2024, 'Responsable du développement en cours du site de commerce électronique Samba Market (samba-market.shop).\r\nUtilisation des technologies web pour créer une plateforme de vente en ligne robuste et sécurisée.\r\nCollaboration étroite avec l\'équipe pour concevoir des fonctionnalités innovantes PHP JS HTML', '2024-03-26 18:24:55'),
(5, '12', 'OYONO EFFE NICK LUDVANNE', 'février', '1994', 'mars', 1994, 'je ne veux pas', '2024-07-29 15:27:34');

-- --------------------------------------------------------

--
-- Structure de la table `niveau_etude`
--

DROP TABLE IF EXISTS `niveau_etude`;
CREATE TABLE IF NOT EXISTS `niveau_etude` (
  `niveau_id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `etude` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `experience` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `n_etude` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `n_experience` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`niveau_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `niveau_etude`
--

INSERT INTO `niveau_etude` (`niveau_id`, `users_id`, `etude`, `experience`, `n_etude`, `n_experience`, `date`) VALUES
(1, 1, 'Bac+4ans', '8ans', '', '', '2024-03-07 12:58:40'),
(2, 10, 'Bac+2ans', '2ans', '2', '2', '2024-07-20 19:56:38'),
(3, 12, 'Bac+3ans', '3ans', '3', '3', '2024-07-29 15:27:49'),
(4, 5, 'Bac+8ans', '6ans', '8', '6', '2024-07-29 15:58:42');

-- --------------------------------------------------------

--
-- Structure de la table `notification_message`
--

DROP TABLE IF EXISTS `notification_message`;
CREATE TABLE IF NOT EXISTS `notification_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `notification_message_users`
--

DROP TABLE IF EXISTS `notification_message_users`;
CREATE TABLE IF NOT EXISTS `notification_message_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  `statut` varchar(250) NOT NULL,
  `sujet` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `notification_postulation`
--

DROP TABLE IF EXISTS `notification_postulation`;
CREATE TABLE IF NOT EXISTS `notification_postulation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `notification_suivi`
--

DROP TABLE IF EXISTS `notification_suivi`;
CREATE TABLE IF NOT EXISTS `notification_suivi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  `statut` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `notification_suivi`
--

INSERT INTO `notification_suivi` (`id`, `entreprise_id`, `users_id`, `statut`) VALUES
(13, 1, 12, 'accepter');

-- --------------------------------------------------------

--
-- Structure de la table `offre_emploi`
--

DROP TABLE IF EXISTS `offre_emploi`;
CREATE TABLE IF NOT EXISTS `offre_emploi` (
  `offre_id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `poste` varchar(255) DEFAULT NULL,
  `mission` text,
  `profil` text,
  `metier` varchar(255) DEFAULT NULL,
  `contrat` varchar(255) DEFAULT NULL,
  `etudes` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `n_etudes` varchar(250) NOT NULL,
  `n_experience` varchar(250) NOT NULL,
  `localite` varchar(200) NOT NULL,
  `langues` varchar(255) DEFAULT NULL,
  `places` varchar(250) NOT NULL,
  `date_expiration` varchar(250) NOT NULL,
  `statut` varchar(250) NOT NULL,
  `categorie` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  PRIMARY KEY (`offre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `offre_emploi`
--

INSERT INTO `offre_emploi` (`offre_id`, `entreprise_id`, `poste`, `mission`, `profil`, `metier`, `contrat`, `etudes`, `experience`, `n_etudes`, `n_experience`, `localite`, `langues`, `places`, `date_expiration`, `statut`, `categorie`, `date`) VALUES
(14, 1, 'devellopeur web full stack et web design php html Charger de la clientel', '<p>tt</p>', '<p>tt</p>', NULL, 'CDD', 'Bac+2ans', '2ans', '2', '2', 'Dakar', 'francais et anglais', '7', '2024-09-17', 'publiee', 'Informatique et tech', 'lundi 29 juillet 2024 ');

-- --------------------------------------------------------

--
-- Structure de la table `outil_users`
--

DROP TABLE IF EXISTS `outil_users`;
CREATE TABLE IF NOT EXISTS `outil_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `outil` varchar(250) NOT NULL,
  `niveau` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `outil_users`
--

INSERT INTO `outil_users` (`id`, `users_id`, `outil`, `niveau`, `date`) VALUES
(2, 1, 'epfwefkewo', 'Intermediaire', '2024-03-22 21:11:32'),
(3, 5, 'VS code', 'professionel', '2024-03-26 18:44:09'),
(4, 5, 'word', 'professionel', '2024-03-26 18:44:29'),
(5, 5, 'Git', 'professionel', '2024-03-26 18:44:51'),
(6, 5, 'Wamp Server', 'Avencer', '2024-03-26 18:45:18');

-- --------------------------------------------------------

--
-- Structure de la table `postulation`
--

DROP TABLE IF EXISTS `postulation`;
CREATE TABLE IF NOT EXISTS `postulation` (
  `poste_id` int NOT NULL AUTO_INCREMENT,
  `offre_id` int NOT NULL,
  `entreprise_id` int NOT NULL,
  `poste` varchar(250) NOT NULL,
  `users_id` int NOT NULL,
  `nom` varchar(250) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `competences` varchar(250) NOT NULL,
  `profession` varchar(250) NOT NULL,
  `images` varchar(250) NOT NULL,
  `categorie` varchar(250) NOT NULL,
  `statut` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`poste_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `postulation`
--

INSERT INTO `postulation` (`poste_id`, `offre_id`, `entreprise_id`, `poste`, `users_id`, `nom`, `mail`, `phone`, `competences`, `profession`, `images`, `categorie`, `statut`, `date`) VALUES
(10, 14, 1, 'devellopeur web full stack et web design php html Charger de la clientel', 5, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '785303879', '  Développeur Web', 'Professionnel', '_image-2.png', 'Informatique et tech', 'accepter', '2024-09-03 15:59:22'),
(11, 14, 1, 'devellopeur web full stack et web design php html Charger de la clientel', 12, 'Nick jomas effe', 'webgeniuses12@gmail.com', '+221795303879', 'development web php ', 'Professionnel', '66a791e6767a8_groupe_ipg_isti_logo.jpg', 'Informatique et tech', 'accepter', '2024-08-14 13:08:29');

-- --------------------------------------------------------

--
-- Structure de la table `projet_users`
--

DROP TABLE IF EXISTS `projet_users`;
CREATE TABLE IF NOT EXISTS `projet_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `titre` varchar(400) NOT NULL,
  `liens` varchar(300) NOT NULL,
  `projetdescription` text NOT NULL,
  `images` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `projet_users`
--

INSERT INTO `projet_users` (`id`, `users_id`, `titre`, `liens`, `projetdescription`, `images`, `date`) VALUES
(1, 1, 'je ne veux pas de toi', 'https://google.com', '<p>je suis un developpeur web php performent</p>', 'bb.jpg', '2024-03-07 18:00:21');

-- --------------------------------------------------------

--
-- Structure de la table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `public_key` varchar(255) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `content_encoding` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `tmp_message1`
--

DROP TABLE IF EXISTS `tmp_message1`;
CREATE TABLE IF NOT EXISTS `tmp_message1` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` int NOT NULL,
  `users_id` int NOT NULL,
  `offre_id` int NOT NULL,
  `statut` varchar(250) NOT NULL,
  `messages` text NOT NULL,
  `indicatif` varchar(250) NOT NULL,
  `sujet` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  `dates` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `tmp_message1`
--

INSERT INTO `tmp_message1` (`message_id`, `entreprise_id`, `users_id`, `offre_id`, `statut`, `messages`, `indicatif`, `sujet`, `date`, `dates`) VALUES
(31, 2, 1, 0, '', 'Je veux', 'candidat', 'appel', 'dimanche 24 mars 2024 15:35', '2024-03-24 10:35:31'),
(29, 2, 1, 0, '', 'je suis dans ', 'candidat', 'appel', 'samedi 23 mars 2024 02:12', '2024-03-22 21:12:19'),
(30, 2, 1, 0, '', 'Bonjour monsieur ', 'candidat', 'appel', 'dimanche 24 mars 2024 15:35', '2024-03-24 10:35:04'),
(35, 1, 5, 0, '', '', '', '', '', '2024-05-14 22:18:59'),
(37, 1, 5, 0, '', '', '', '', '', '2024-05-14 22:19:35'),
(99, 1, 12, 14, 'accepter', 'je suis toujour la', 'candidat', 'postulation', 'mercredi 14 août 2024 15:08', '2024-08-14 13:08:29'),
(100, 1, 5, 14, 'accepter', 'd\'accord ', 'candidat', 'postulation', 'mardi 3 septembre 2024 17:59', '2024-09-03 15:59:22');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `competences` varchar(255) DEFAULT NULL,
  `profession` varchar(250) NOT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `statut` varchar(250) NOT NULL,
  `remember_token` varchar(250) NOT NULL,
  `verification` varchar(250) NOT NULL,
  `verification_statut` varchar(250) NOT NULL,
  `passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `mail`, `phone`, `ville`, `competences`, `profession`, `categorie`, `images`, `statut`, `remember_token`, `verification`, `verification_statut`, `passe`) VALUES
(10, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe09@gmail.com', '+221234455667', 'Dakar', 'development web', 'Professionnel', 'Tourisme et hôtellerie', '669c09ad715c9_bb.jpg', '', '9832372d38e7cde5e75e0c88a8a0edde', 'M2NGqkgVT', 'verified', '$2y$10$1x41GzzqamKXEgtK91LnKOs6c8l1gvB1SRQh63L8/3qmvB70iL2Fu'),
(5, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '785303879', 'Dakar', '  Développeur Web', 'Professionnel', 'Design et création', '_image-2.png', 'Disponible', 'f7b389dc54aef5bd7148d659430879e7', 'lqcZEYtvL', 'verified', '$2y$10$sgwp57wuGBJsIPVChPLdzOXf28l.XPXNm7BVbwfQA5p2Qt7DFnq..'),
(12, 'Nick jomas effe', 'webgeniuses12@gmail.com', '+221795303879', 'Newark', 'development web php ', 'Professionnel', 'Informatique et tech', '66a791e6767a8_groupe_ipg_isti_logo.jpg', 'Disponible', 'b2662bea788a24441e5b18a50d3ac043', 'NyXXuAEq5', 'verified', '$2y$10$yHZtg2hcQGD09fOPv.1zyek4EmW4IJkbGqSwgcd6VqhE2AP9ejFXy');

-- --------------------------------------------------------

--
-- Structure de la table `verification_entreprise`
--

DROP TABLE IF EXISTS `verification_entreprise`;
CREATE TABLE IF NOT EXISTS `verification_entreprise` (
  `id_verification` int NOT NULL AUTO_INCREMENT,
  `entreprise_id` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_verification`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `verification_users`
--

DROP TABLE IF EXISTS `verification_users`;
CREATE TABLE IF NOT EXISTS `verification_users` (
  `verification_id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `code` varchar(240) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`verification_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vue_offre`
--

DROP TABLE IF EXISTS `vue_offre`;
CREATE TABLE IF NOT EXISTS `vue_offre` (
  `vue_id` int NOT NULL AUTO_INCREMENT,
  `offre_id` int NOT NULL,
  `users_id` int NOT NULL,
  `entreprise_id` int NOT NULL,
  `nom` varchar(250) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`vue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `vue_offre`
--

INSERT INTO `vue_offre` (`vue_id`, `offre_id`, `users_id`, `entreprise_id`, `nom`, `mail`, `date`) VALUES
(1, 1, 1, 2, 'nick jomas effe work-flexer', 'webgeniuses12@gmail.com', '2024-03-07 13:13:23'),
(2, 2, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-05-11 20:37:03'),
(3, 3, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-05-14 23:04:56'),
(4, 5, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-05-18 19:57:02'),
(5, 4, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-06-18 22:06:03'),
(6, 7, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-06-19 16:09:38'),
(7, 8, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-06-21 10:11:05'),
(8, 9, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-06-21 22:31:39'),
(9, 8, 10, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe09@gmail.com', '2024-07-20 19:58:04'),
(10, 12, 10, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe09@gmail.com', '2024-07-20 21:54:19'),
(11, 10, 10, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe09@gmail.com', '2024-07-21 13:46:22'),
(12, 14, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-07-29 15:57:07'),
(13, 0, 5, 1, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '2024-08-14 09:16:11'),
(14, 14, 12, 1, 'Nick jomas effe', 'webgeniuses12@gmail.com', '2024-08-14 12:42:26');

-- --------------------------------------------------------

--
-- Structure de la table `vue_profil`
--

DROP TABLE IF EXISTS `vue_profil`;
CREATE TABLE IF NOT EXISTS `vue_profil` (
  `id_vue` int NOT NULL AUTO_INCREMENT,
  `id_users` int NOT NULL,
  `profil_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vue`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vue_profil`
--

INSERT INTO `vue_profil` (`id_vue`, `id_users`, `profil_id`, `date`) VALUES
(1, 1, 1, '2024-03-08 05:52:11'),
(2, 2, 1, '2024-03-18 11:18:51'),
(3, 5, 5, '2024-05-06 13:04:23'),
(4, 1, 5, '2024-05-11 21:35:33'),
(5, 1, 2, '2024-05-14 22:51:02'),
(6, 1, 10, '2024-06-20 20:53:18'),
(7, 5, 8, '2024-06-24 20:40:44'),
(8, 5, 7, '2024-06-24 20:40:53'),
(9, 10, 5, '2024-07-20 19:07:45'),
(10, 1, 14, '2024-07-29 15:05:39'),
(11, 1, 12, '2024-07-29 16:36:26'),
(12, 5, 12, '2024-07-29 22:53:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
