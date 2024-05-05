-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 29 avr. 2024 à 10:43
-- Version du serveur : 10.6.17-MariaDB-cll-lve
-- Version de PHP : 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ludvanne12_work_flexer`
--

-- --------------------------------------------------------

--
-- Structure de la table `accepte_candidat`
--

CREATE TABLE `accepte_candidat` (
  `accepte_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `remember_token` varchar(300) NOT NULL,
  `passe` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `mail`, `phone`, `image`, `remember_token`, `passe`) VALUES
(2, 'Nick EFFE', 'webgeniuses12@gmail.com', '785303879', '65f050e7b1c79_image-2.png', '6cda6490b15df43e762786cb08aa92bd', '$2y$10$3y8AOY2PXud7E.jFclAOPOgyf1nw4EJODTHwJ2MlX/zGyadkl0HYa');

-- --------------------------------------------------------

--
-- Structure de la table `admin_message`
--

CREATE TABLE `admin_message` (
  `id` int(11) NOT NULL,
  `utilisateur_id` varchar(200) NOT NULL,
  `compte` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `mail` varchar(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `appel_offre` (
  `id_appel` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `titre` varchar(250) NOT NULL,
  `messages` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `appel_offre`
--

INSERT INTO `appel_offre` (`id_appel`, `entreprise_id`, `users_id`, `titre`, `messages`, `date`) VALUES
(1, 2, 1, 'je ne veux pas de toi', '<p>teste</p>', '2024-03-18 19:29:18');

-- --------------------------------------------------------

--
-- Structure de la table `centre_interet`
--

CREATE TABLE `centre_interet` (
  `interet_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `interet` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `certificat_users` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `certificat` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `certificat_users`
--

INSERT INTO `certificat_users` (`id`, `users_id`, `certificat`, `date`) VALUES
(1, 1, 'je suis ce que je suis', '2024-03-07 12:59:30');

-- --------------------------------------------------------

--
-- Structure de la table `competence_users`
--

CREATE TABLE `competence_users` (
  `id` int(11) NOT NULL,
  `users_id` varchar(250) NOT NULL,
  `competence` varchar(300) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
(8, '5', 'SQL', '2024-03-26 18:25:31'),
(9, '5', 'Gestion de base de données ', '2024-03-26 18:25:57'),
(10, '5', 'Maintenance des serveurs web', '2024-03-26 18:26:23'),
(11, '5', 'JavaScript ', '2024-03-26 18:26:53'),
(12, '5', 'HTML CSS', '2024-03-26 18:27:14'),
(13, '5', 'Git GitHub ', '2024-03-26 18:28:19');

-- --------------------------------------------------------

--
-- Structure de la table `compte_entreprise`
--

CREATE TABLE `compte_entreprise` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `entreprise` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `types` varchar(250) NOT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `images` varchar(250) NOT NULL,
  `taille` varchar(250) NOT NULL,
  `categorie` varchar(250) NOT NULL,
  `remember_token` varchar(250) NOT NULL,
  `verification` varchar(250) NOT NULL,
  `verification_statut` varchar(250) NOT NULL,
  `passe` varchar(255) DEFAULT NULL,
  `cpasse` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `compte_entreprise`
--

INSERT INTO `compte_entreprise` (`id`, `nom`, `entreprise`, `mail`, `phone`, `types`, `ville`, `images`, `taille`, `categorie`, `remember_token`, `verification`, `verification_statut`, `passe`, `cpasse`) VALUES
(1, 'OYONO', 'LUDVANNE', 'oyonoeffe11@gmail.com', 785303879, 'agence d\'informatique', 'Daka', '65e9fe43aceec_ipg.png', '1', '', '4a23d4c4d7875546eb18f740c2bdc9cb', 'qwUvZNp4i', 'verified', '$2y$10$zvQgCaliOaCwwm95.bxtBeCHA3R.APbReg0bfUy3QrYjDx4S9D0Gy', NULL),
(2, 'OYONO', 'LUDVANNE', 'webgeniuses12@gmail.com', 234455667, 'agence d\'informatique', 'Daka', '_outils-revue-code.png', '1', 'Marketing', '4d26065d1de3e4de98472c2b9c7918cb', '4yHrrIISW', 'verified', '$2y$10$9gkkCzP558AFF2voK/QDTe13GA/d4hMTsEePTIZCpsfiT0wvdOJ5.', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `description_entreprise`
--

CREATE TABLE `description_entreprise` (
  `id_description` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `liens` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `description_users`
--

CREATE TABLE `description_users` (
  `id` int(11) NOT NULL,
  `users_id` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `description_users`
--

INSERT INTO `description_users` (`id`, `users_id`, `description`, `date`) VALUES
(1, '1', 'je suis ce que je suis', '2024-03-07 12:56:55'),
(2, '5', 'Je suis un développeur web Full Stack passionné, spécialisé dans une gamme variée de langages de programmation, notamment PHP, HTML, CSS, JavaScript, SQL et Python. Avec une solide expérience dans la réalisation de projets web, j\'ai acquis une expertise dans la maintenance des serveurs, la gestion de bases de données et la création d\'API RESTful. Mon parcours professionnel m\'a permis de développer des compétences approfondies dans la conception et le développement d\'applications web robustes ', '2024-03-26 18:09:59');

-- --------------------------------------------------------

--
-- Structure de la table `diplome`
--

CREATE TABLE `diplome` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `diplome` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `document_users` (
  `document_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `document` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `document_users`
--

INSERT INTO `document_users` (`document_id`, `users_id`, `document`, `date`) VALUES
(3, 1, 'namecheap-order-138978909.pdf', '2024-03-10 12:12:47');

-- --------------------------------------------------------

--
-- Structure de la table `formation_users`
--

CREATE TABLE `formation_users` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `moisDebut` varchar(200) NOT NULL,
  `anneeDebut` varchar(200) NOT NULL,
  `moisFin` varchar(250) NOT NULL,
  `anneeFin` varchar(250) NOT NULL,
  `Filiere` varchar(300) NOT NULL,
  `etablissement` varchar(300) NOT NULL,
  `niveau` varchar(259) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `historique` (
  `historique_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`historique_id`, `entreprise_id`, `users_id`, `date`) VALUES
(1, 2, 1, '2024-03-18 11:18:51');

-- --------------------------------------------------------

--
-- Structure de la table `historique_users`
--

CREATE TABLE `historique_users` (
  `historique_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `langue_users`
--

CREATE TABLE `langue_users` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `langue` varchar(200) NOT NULL,
  `niveau` varchar(299) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `message1` (
  `message_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `statut` varchar(250) NOT NULL,
  `messages` text NOT NULL,
  `indicatif` varchar(250) NOT NULL,
  `sujet` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  `dates` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
(13, 2, 1, 0, '', 'Je veux', 'candidat', 'appel', 'dimanche 24 mars 2024 15:35', '2024-03-24 10:35:31');

-- --------------------------------------------------------

--
-- Structure de la table `metier_users`
--

CREATE TABLE `metier_users` (
  `id` int(11) NOT NULL,
  `users_id` varchar(200) NOT NULL,
  `metier` varchar(300) NOT NULL,
  `moisDebut` varchar(250) NOT NULL,
  `anneeDebut` varchar(250) NOT NULL,
  `moisFin` varchar(250) NOT NULL,
  `anneeFin` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `metier_users`
--

INSERT INTO `metier_users` (`id`, `users_id`, `metier`, `moisDebut`, `anneeDebut`, `moisFin`, `anneeFin`, `description`, `date`) VALUES
(1, '1', 'tete brûlé ', 'février', '1995', 'février', 2015, 'je suis le superviseurs&nbsp;', '2024-03-07 12:57:34'),
(2, '1', 'Développement de site web chez sen-study', 'avril', '1987', 'mai', 2000, 'Je ne veux pas être comme ça et si je ne suis pas avec toi je ne serai pas disponible.', '2024-03-08 16:24:48'),
(3, '5', 'Développeur Web chez Work-Flexer', 'février', '2022', 'mars', 2023, 'Conception et développement du site web Work-Flexer (work-flexer.com) en utilisant PHP.\r\nCréation d\'une plateforme d\'offres d\'emploi en ligne permettant aux recruteurs de publier des offres et aux professionnels de postuler en créant un profil virtuel détaillant leur parcours.SQL, JS, HTML, CSS, PHP.', '2024-03-26 18:22:43'),
(4, '5', 'Développeur Web chez Samba Market', 'septembre', '2023', 'mars', 2024, 'Responsable du développement en cours du site de commerce électronique Samba Market (samba-market.shop).\r\nUtilisation des technologies web pour créer une plateforme de vente en ligne robuste et sécurisée.\r\nCollaboration étroite avec l\'équipe pour concevoir des fonctionnalités innovantes PHP JS HTML', '2024-03-26 18:24:55');

-- --------------------------------------------------------

--
-- Structure de la table `niveau_etude`
--

CREATE TABLE `niveau_etude` (
  `niveau_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `etude` varchar(250) NOT NULL,
  `experience` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `niveau_etude`
--

INSERT INTO `niveau_etude` (`niveau_id`, `users_id`, `etude`, `experience`, `date`) VALUES
(1, 1, 'Bac+4ans', '8ans', '2024-03-07 12:58:40');

-- --------------------------------------------------------

--
-- Structure de la table `offre_emploi`
--

CREATE TABLE `offre_emploi` (
  `offre_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `poste` varchar(255) DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `profil` text DEFAULT NULL,
  `metier` varchar(255) DEFAULT NULL,
  `contrat` varchar(255) DEFAULT NULL,
  `etudes` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `localite` varchar(200) NOT NULL,
  `langues` varchar(255) DEFAULT NULL,
  `categorie` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `outil_users`
--

CREATE TABLE `outil_users` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `outil` varchar(250) NOT NULL,
  `niveau` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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

CREATE TABLE `postulation` (
  `poste_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `poste` varchar(250) NOT NULL,
  `users_id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `competences` varchar(250) NOT NULL,
  `profession` varchar(250) NOT NULL,
  `images` varchar(250) NOT NULL,
  `statut` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet_users`
--

CREATE TABLE `projet_users` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `titre` varchar(400) NOT NULL,
  `liens` varchar(300) NOT NULL,
  `projetdescription` text NOT NULL,
  `images` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `projet_users`
--

INSERT INTO `projet_users` (`id`, `users_id`, `titre`, `liens`, `projetdescription`, `images`, `date`) VALUES
(1, 1, 'je ne veux pas de toi', 'https://google.com', '<p>je suis un developpeur web php performent</p>', 'bb.jpg', '2024-03-07 18:00:21');

-- --------------------------------------------------------

--
-- Structure de la table `tmp_message1`
--

CREATE TABLE `tmp_message1` (
  `message_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `statut` varchar(250) NOT NULL,
  `messages` text NOT NULL,
  `indicatif` varchar(250) NOT NULL,
  `sujet` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  `dates` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tmp_message1`
--

INSERT INTO `tmp_message1` (`message_id`, `entreprise_id`, `users_id`, `offre_id`, `statut`, `messages`, `indicatif`, `sujet`, `date`, `dates`) VALUES
(31, 2, 1, 0, '', 'Je veux', 'candidat', 'appel', 'dimanche 24 mars 2024 15:35', '2024-03-24 10:35:31'),
(29, 2, 1, 0, '', 'je suis dans ', 'candidat', 'appel', 'samedi 23 mars 2024 02:12', '2024-03-22 21:12:19'),
(30, 2, 1, 0, '', 'Bonjour monsieur ', 'candidat', 'appel', 'dimanche 24 mars 2024 15:35', '2024-03-24 10:35:04');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
  `passe` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `mail`, `phone`, `ville`, `competences`, `profession`, `categorie`, `images`, `statut`, `remember_token`, `verification`, `verification_statut`, `passe`) VALUES
(6, 'nick jomas effe work-flexer', 'webgeniuses12@gmail.com', '785303879', 'Dakar', 'development web', 'Professionnel', 'Finance et comptabilité', '66078055105d1_creation-site-1-600x511.png', '', 'd2b7a4909da5310a6d4951ec89fbf790', 'BvXjRZiz5', 'verified', '$2y$10$HR99Er/kyj6T5MGMcC6rM.fS0evNwf7Rvy4DWLghBdaFDlUIa2gzy'),
(5, 'OYONO EFFE NICK LUDVANNE', 'oyonoeffe11@gmail.com', '785303879', 'Dakar', '  Développeur Web', 'Professionnel', 'Informatique et tech', '_image-2.png', '', '8f39e5d86f2eaf01de1be18a701f05aa', 'lqcZEYtvL', 'verified', '$2y$10$sgwp57wuGBJsIPVChPLdzOXf28l.XPXNm7BVbwfQA5p2Qt7DFnq..');

-- --------------------------------------------------------

--
-- Structure de la table `verification_entreprise`
--

CREATE TABLE `verification_entreprise` (
  `id_verification` int(11) NOT NULL,
  `entreprise_id` varchar(250) NOT NULL,
  `code` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `verification_users`
--

CREATE TABLE `verification_users` (
  `verification_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `code` varchar(240) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vue_offre`
--

CREATE TABLE `vue_offre` (
  `vue_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `mail` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `vue_offre`
--

INSERT INTO `vue_offre` (`vue_id`, `offre_id`, `users_id`, `entreprise_id`, `nom`, `mail`, `date`) VALUES
(1, 1, 1, 2, 'nick jomas effe work-flexer', 'webgeniuses12@gmail.com', '2024-03-07 13:13:23');

-- --------------------------------------------------------

--
-- Structure de la table `vue_profil`
--

CREATE TABLE `vue_profil` (
  `id_vue` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `profil_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vue_profil`
--

INSERT INTO `vue_profil` (`id_vue`, `id_users`, `profil_id`, `date`) VALUES
(1, 1, 1, '2024-03-08 05:52:11'),
(2, 2, 1, '2024-03-18 11:18:51');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accepte_candidat`
--
ALTER TABLE `accepte_candidat`
  ADD PRIMARY KEY (`accepte_id`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `admin_message`
--
ALTER TABLE `admin_message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `appel_offre`
--
ALTER TABLE `appel_offre`
  ADD PRIMARY KEY (`id_appel`);

--
-- Index pour la table `centre_interet`
--
ALTER TABLE `centre_interet`
  ADD PRIMARY KEY (`interet_id`);

--
-- Index pour la table `certificat_users`
--
ALTER TABLE `certificat_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `competence_users`
--
ALTER TABLE `competence_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `compte_entreprise`
--
ALTER TABLE `compte_entreprise`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `description_entreprise`
--
ALTER TABLE `description_entreprise`
  ADD PRIMARY KEY (`id_description`);

--
-- Index pour la table `description_users`
--
ALTER TABLE `description_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `diplome`
--
ALTER TABLE `diplome`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `document_users`
--
ALTER TABLE `document_users`
  ADD PRIMARY KEY (`document_id`);

--
-- Index pour la table `formation_users`
--
ALTER TABLE `formation_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`historique_id`);

--
-- Index pour la table `historique_users`
--
ALTER TABLE `historique_users`
  ADD PRIMARY KEY (`historique_id`);

--
-- Index pour la table `langue_users`
--
ALTER TABLE `langue_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message1`
--
ALTER TABLE `message1`
  ADD PRIMARY KEY (`message_id`);

--
-- Index pour la table `metier_users`
--
ALTER TABLE `metier_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `niveau_etude`
--
ALTER TABLE `niveau_etude`
  ADD PRIMARY KEY (`niveau_id`);

--
-- Index pour la table `offre_emploi`
--
ALTER TABLE `offre_emploi`
  ADD PRIMARY KEY (`offre_id`);

--
-- Index pour la table `outil_users`
--
ALTER TABLE `outil_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `postulation`
--
ALTER TABLE `postulation`
  ADD PRIMARY KEY (`poste_id`);

--
-- Index pour la table `projet_users`
--
ALTER TABLE `projet_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tmp_message1`
--
ALTER TABLE `tmp_message1`
  ADD PRIMARY KEY (`message_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `verification_entreprise`
--
ALTER TABLE `verification_entreprise`
  ADD PRIMARY KEY (`id_verification`);

--
-- Index pour la table `verification_users`
--
ALTER TABLE `verification_users`
  ADD PRIMARY KEY (`verification_id`);

--
-- Index pour la table `vue_offre`
--
ALTER TABLE `vue_offre`
  ADD PRIMARY KEY (`vue_id`);

--
-- Index pour la table `vue_profil`
--
ALTER TABLE `vue_profil`
  ADD PRIMARY KEY (`id_vue`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accepte_candidat`
--
ALTER TABLE `accepte_candidat`
  MODIFY `accepte_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `admin_message`
--
ALTER TABLE `admin_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `appel_offre`
--
ALTER TABLE `appel_offre`
  MODIFY `id_appel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `centre_interet`
--
ALTER TABLE `centre_interet`
  MODIFY `interet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `certificat_users`
--
ALTER TABLE `certificat_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `competence_users`
--
ALTER TABLE `competence_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `compte_entreprise`
--
ALTER TABLE `compte_entreprise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `description_entreprise`
--
ALTER TABLE `description_entreprise`
  MODIFY `id_description` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `description_users`
--
ALTER TABLE `description_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `diplome`
--
ALTER TABLE `diplome`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `document_users`
--
ALTER TABLE `document_users`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `formation_users`
--
ALTER TABLE `formation_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `historique_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `historique_users`
--
ALTER TABLE `historique_users`
  MODIFY `historique_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `langue_users`
--
ALTER TABLE `langue_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `message1`
--
ALTER TABLE `message1`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `metier_users`
--
ALTER TABLE `metier_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `niveau_etude`
--
ALTER TABLE `niveau_etude`
  MODIFY `niveau_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `offre_emploi`
--
ALTER TABLE `offre_emploi`
  MODIFY `offre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `outil_users`
--
ALTER TABLE `outil_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `postulation`
--
ALTER TABLE `postulation`
  MODIFY `poste_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `projet_users`
--
ALTER TABLE `projet_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tmp_message1`
--
ALTER TABLE `tmp_message1`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `verification_entreprise`
--
ALTER TABLE `verification_entreprise`
  MODIFY `id_verification` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `verification_users`
--
ALTER TABLE `verification_users`
  MODIFY `verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vue_offre`
--
ALTER TABLE `vue_offre`
  MODIFY `vue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vue_profil`
--
ALTER TABLE `vue_profil`
  MODIFY `id_vue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
