-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 29 Mars 2026 à 12:29
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `infotools`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `entreprise` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `adresse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `user_id`, `nom`, `prenom`, `entreprise`, `email`, `tel`, `adresse`) VALUES
(1, 1, 'Bernard', 'Jean', 'Logistique 24', 'j.bernard@log24.fr', '0611223344', '10 rue des Lilas, Paris'),
(2, 1, 'Petit', 'Sophie', 'Design Studio', 'contact@design-studio.com', '0140506070', '5 ave du Graphisme, Lyon'),
(3, 1, 'Gascon', 'Marc', 'Vignobles Gascon', 'm.gascon@vigne.fr', '0544556677', 'Rte des Châteaux, Bordeaux'),
(4, 4, 'Dubois', 'Claire', 'Optique Dubois', 'claire@dubois-optique.fr', '0388990011', '12 place de la Mairie, Lille'),
(5, 4, 'Fontaine', 'Paul', 'Fontaine BTP', 'p.fontaine@btp-f.com', '0422334455', 'Zone Industrielle, Marseille'),
(6, NULL, 'TEST', 'TESTI', 'TESTEURSPRO', 'TEST@gmail.com', '0077007700', '007 rue du Test');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `produit_id` int(10) UNSIGNED NOT NULL,
  `quantite` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date_achat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`id`, `client_id`, `produit_id`, `quantite`, `montant`, `date_achat`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2450.00', '2026-03-10 09:00:00', NULL, NULL),
(2, 2, 3, 2, '2400.00', '2026-03-12 13:30:00', NULL, NULL),
(3, 3, 2, 3, '1740.00', '2026-03-14 08:15:00', NULL, NULL),
(4, 4, 4, 5, '600.00', '2026-03-15 15:45:00', NULL, NULL),
(5, 5, 5, 1, '3500.00', '2026-03-18 10:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test', 'Ceci est un test de log', '127.0.0.1', '2026-03-28 16:26:18', '2026-03-28 16:26:18'),
(2, 5, 'Création', 'A ajouté le client TESTI TEST (Entreprise: TESTEURSPRO)', '127.0.0.1', '2026-03-28 16:31:17', '2026-03-28 16:31:17'),
(3, 5, 'Modification', 'A modifié la fiche du client TESTI TEST', '127.0.0.1', '2026-03-28 16:32:13', '2026-03-28 16:32:13'),
(4, 5, 'Suppression', 'A supprimé définitivement le client : TESTI TEST', '127.0.0.1', '2026-03-28 16:32:23', '2026-03-28 16:32:23'),
(5, 5, 'Création', 'A ajouté le produit : TEST (Stock: 50)', '127.0.0.1', '2026-03-28 16:34:43', '2026-03-28 16:34:43'),
(6, 5, 'Modification', 'A mis à jour le produit : TEST', '127.0.0.1', '2026-03-28 16:37:07', '2026-03-28 16:37:07'),
(7, 5, 'Suppression', 'A supprimé le produit : TEST', '127.0.0.1', '2026-03-28 16:37:10', '2026-03-28 16:37:10'),
(8, 5, 'Création', 'A ajouté le prospect : TESTI TEST (Entreprise: TESTEURSPRO)', '127.0.0.1', '2026-03-28 16:44:17', '2026-03-28 16:44:17'),
(9, 5, 'Modification', 'A mis à jour la fiche du prospect : TESTI TEST', '127.0.0.1', '2026-03-28 16:45:01', '2026-03-28 16:45:01'),
(10, 5, 'Suppression', 'A supprimé le prospect : TESTI TEST', '127.0.0.1', '2026-03-28 16:45:07', '2026-03-28 16:45:07'),
(11, 5, 'Création', 'A planifié le RDV : TEST le 2026-03-28T19:00', '127.0.0.1', '2026-03-28 16:47:09', '2026-03-28 16:47:09'),
(12, 5, 'Modification', 'A modifié le RDV : TESTez (Prévu le 2026-03-28T19:30)', '127.0.0.1', '2026-03-28 16:47:46', '2026-03-28 16:47:46'),
(13, 5, 'Suppression', 'A annulé/supprimé le RDV : TESTez du 2026-03-28 19:30:00', '127.0.0.1', '2026-03-28 16:47:50', '2026-03-28 16:47:50'),
(14, 1, 'Modification', 'A mis à jour le produit : Audit Cybersécuritéd', '127.0.0.1', '2026-03-29 09:25:52', '2026-03-29 09:25:52'),
(15, 1, 'Création', 'A ajouté le prospect : TESTI TEST (Entreprise: Logistique 24)', '127.0.0.1', '2026-03-29 09:31:54', '2026-03-29 09:31:54'),
(16, 1, 'Suppression', 'A supprimé le prospect : TESTI TEST', '127.0.0.1', '2026-03-29 09:32:03', '2026-03-29 09:32:03');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `catégorie` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `catégorie`, `prix`, `stock`) VALUES
(1, 'Station de travail Z-Pro', 'Matériel', '2450.00', 5),
(2, 'Écran 4K Incurvé 34p', 'Matériel', '580.00', 15),
(3, 'Licence Cloud Infini (1 an)', 'Logiciel', '1200.00', 50),
(4, 'Clavier Mécanique RGB', 'Périphérique', '120.00', 30),
(5, 'Audit Cybersécuritéd', 'Service', '3500.00', 999),
(6, 'Antivirus', 'logiciel', '200.00', 20);

-- --------------------------------------------------------

--
-- Structure de la table `prospect`
--

CREATE TABLE `prospect` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `entreprise` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `adresse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `prospect`
--

INSERT INTO `prospect` (`id`, `nom`, `prenom`, `entreprise`, `email`, `tel`, `adresse`) VALUES
(1, 'Leroy', 'Alice', 'Alice Créations', 'alice@creations.fr', '0600000001', '1 bis rue Neuve, Nantes'),
(2, 'Gomez', 'Ricardo', 'Tapas & Co', 'ricardo@tapas.es', '0600000002', 'Madrid, Espagne'),
(3, 'Chen', 'Li', 'Tech Import', 'li.chen@techimport.cn', '0600000003', 'Pékin, Chine'),
(4, 'Muller', 'Hans', 'Muller Auto', 'h.muller@auto.de', '0600000004', 'Berlin, Allemagne'),
(5, 'Silva', 'Joao', 'Silva Export', 'j.silva@export.pt', '0600000005', 'Lisbonne, Portugal');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `id` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `date_heure` datetime NOT NULL,
  `lieu` varchar(200) NOT NULL,
  `prospect_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `rendezvous`
--

INSERT INTO `rendezvous` (`id`, `titre`, `description`, `date_heure`, `lieu`, `prospect_id`) VALUES
(1, 'Démo Station Travail', 'Montrer les perfs de la Z-Pro à Alice', '2026-03-20 14:00:00', 'Bureaux Alice Créations', 1),
(2, 'Négociation Cloud', 'Discussion sur le volume de stockage', '2026-03-21 10:30:00', 'Visio Teams', 1),
(3, 'Premier Contact', 'Présentation générale InfoTools', '2026-03-22 15:00:00', 'Restaurant El Toro', 2),
(4, 'Audit Import', 'Vérification des besoins hardware', '2026-03-23 09:00:00', 'Skype', 3),
(5, 'Signature Contrat', 'Finalisation de la commande groupée', '2026-03-25 11:00:00', 'Bureaux Muller Auto', 4),
(6, 'rdv skyrock', 'planet rap lamano', '2026-12-01 15:45:00', 'ici', 3);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('juaM90ZQacLBC91Z8YVRN8syESBeTgMgAW4rQBlD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.27.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS0hMazRMVFR6aFR4ZnNDbjBxUVlXNmY5Z3lpRzNzUlNBN0Q0OEpvUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9zbGFtZHVuay50ZXN0L2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774718340),
('o8qaSK1tfy4v94sMSPXnJVtD5RgF1vS5PnNBvy7E', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.27.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1gxYWF3Zm9nRXBwaEdGY0VwemxsZUdMVkpoQWRibnlCSk02bjZXYiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovL3NsYW1kdW5rLnRlc3QvP2hlcmQ9cHJldmlldyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vc2xhbWR1bmsudGVzdC8/aGVyZD1wcmV2aWV3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774718340),
('qGJm5MAAJlx7I9YuGXIzXAgzJFaWUH4jjhraujw2', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 OPR/128.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZFJxQnhPbUdWNmlEMTdXU0p6TDF5TmFZVkJTaFBjZ1lHbFRJTXVVSiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vc2xhbWR1bmsudGVzdC9wcm9zcGVjdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1774783923),
('uV5itWF3SvwX2KSAr4cecS6fHhGqSNJYfW6XY76d', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 OPR/128.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTzd0UFZzZnF6eTlaWFFsYU95UWF6WHFJVWZCcjR3enYyTXRTSk1qdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9zbGFtZHVuay50ZXN0L3Byb2R1aXRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1774725810);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `identifiant`, `nom`, `prenom`, `mdp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'RayanR', 'Rimane', 'Rayan', '$2y$12$bhhQRqTAqg4Li7Q2vXBZTuvMnbY3R7YcLz30pdTURWU5gBEaTCo/a', NULL, '2026-03-18 11:55:02', '2026-03-18 11:55:02'),
(4, 'NolanR', 'Roisot', 'Nolan', '$2y$12$TAPv/mXHfydmzWlUF.5iAuFjAxtE/QZueuTnosFv386lcsOPPL7Ja', NULL, '2026-03-28 16:20:08', '2026-03-28 16:20:08'),
(5, 'MaxenceP', 'Pereira', 'Maxence', '$2y$12$8xfhgjokTA7rUGXFwBaFAOL211ZMLSjw0LJn5V0dzRNLALouRx9o.', NULL, '2026-03-28 16:20:19', '2026-03-28 16:20:19'),
(6, 'OceaneR', 'Rioual', 'Oceane', '$2y$12$NiM0FC0C30WVqrgCqbFSjuvj3.OJ3Yk5EBtOWV5DhyStOIyBJXXF6', NULL, '2026-03-28 16:20:23', '2026-03-28 16:20:23');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_logs_user` (`user_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `prospect`
--
ALTER TABLE `prospect`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Rdv_Prospect` (`prospect_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_identifiant_unique` (`identifiant`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `prospect`
--
ALTER TABLE `prospect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `FK_Rdv_Prospect` FOREIGN KEY (`prospect_id`) REFERENCES `prospect` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
