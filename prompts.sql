-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 27 mars 2026 à 16:09
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
-- Base de données : `prompts`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'code'),
(2, 'scientifique');

-- --------------------------------------------------------

--
-- Structure de la table `prompts`
--

CREATE TABLE `prompts` (
  `prompt_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prompts`
--

INSERT INTO `prompts` (`prompt_id`, `title`, `content`, `user_id`, `category_id`) VALUES
(3, 'biotechnologies', 'developement de biotechnologies(pla,pha)', 7, 2),
(4, 'experience', 'en premeier code en php je observe defferente probleme au nivaeu de la logique et comment gerer les probleme', 12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(4, 'hayat', 'hayatlk@gmail.com', '$2y$10$ZMM3nyAVo7GrJYWNCFZiXukZO1h19fb/VidOv.ysEizDXTBAhhUny', 'user'),
(6, 'halima', 'halimaait@gmail.com', '$2y$10$1F3A7m0mpEnmyyBzioiRt.XZOcKdup8vc7wz9MeOe8UHqqgpOE6x.', 'user'),
(7, 'hidaya', 'hidaya@gmail.com', '$2y$10$.8tA1eY53ym5GF11yxY5LeieJgSxQ7EuM9ZBtETAPlDJmBGZ1H3bW', 'user'),
(8, 'kamal', 'kamal@gmail.com', '$2y$10$rUD2xpvhhj2Bptq7nmSd.uLNrw0EgqDwixbf4EMZMTo1DSrR5Aj2q', 'user'),
(9, 'manal', 'manal@gmail.com', '$2y$10$Mw5.P.FHu9MV6wyYGB5EruXb8UzX79R1YBH0AKu2YQw7Oc.0sW2gm', 'user'),
(10, 'kira', 'kira@gmail.com', '$2y$10$DozkGgdC4KiQiPrMaSyRhOml52jvAb78.xN/U3IorTjwV65Aadhoa', 'admin'),
(11, 'amina', 'amina@gmail.com', 'aminaamina12', 'user'),
(12, 'amal', 'amal@gmail.com', '$2y$10$PXvWC6ljRHS8alqpzHEu9.L8ckcu5SQc32HC6UgxTnTUTb1webSdm', 'user'),
(13, 'abdo', 'abdo@gmail.com', '$2y$10$7aTT8ehjB7vQcyGZ66bdfOLH17KOKzp9TcEZ4SVYLqurClnoHT3pm', 'user'),
(14, 'lamyae', 'lami@gmail.com', '$2y$10$jauR59T4dL5W4sOAF9RjtO8uMxswGVAcAdZtbfdApQubFXvdBFMty', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Index pour la table `prompts`
--
ALTER TABLE `prompts`
  ADD PRIMARY KEY (`prompt_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `prompts`
--
ALTER TABLE `prompts`
  MODIFY `prompt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `prompts`
--
ALTER TABLE `prompts`
  ADD CONSTRAINT `prompts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prompts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
