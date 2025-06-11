-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 03 mai 2025 à 22:56
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
-- Base de données : `saint_jean`
--

-- --------------------------------------------------------

--
-- Structure de la table `sessions_concours`
--

CREATE TABLE `sessions_concours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_session` varchar(191) NOT NULL,
  `nom_filiere` varchar(191) NOT NULL,
  `date_debut` date NOT NULL,
  `date_concours` date NOT NULL,
  `date_fin` date NOT NULL,
  `statut` enum('ouverte','fermee') NOT NULL DEFAULT 'ouverte',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions_concours`
--

INSERT INTO `sessions_concours` (`id`, `nom_session`, `nom_filiere`, `date_debut`, `date_concours`, `date_fin`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'mai 2025', 'INGE', '2025-04-26', '2025-05-07', '2025-05-06', 'ouverte', '2025-04-26 05:48:12', '2025-04-26 05:48:12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `sessions_concours`
--
ALTER TABLE `sessions_concours`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `sessions_concours`
--
ALTER TABLE `sessions_concours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
