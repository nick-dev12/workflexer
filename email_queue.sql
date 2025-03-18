CREATE TABLE IF NOT EXISTS `email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `destinataire` varchar(255) NOT NULL,
  `nom_destinataire` varchar(255) DEFAULT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `statut` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `tentatives` int(11) NOT NULL DEFAULT 0,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_envoi` timestamp NULL DEFAULT NULL,
  `erreur` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `statut` (`statut`),
  KEY `date_creation` (`date_creation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 